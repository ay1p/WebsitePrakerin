<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PrakerinProfile;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * Admin Dashboard - View all Prakerin students.
     */
    public function dashboard(Request $request)
    {
        $query = User::where('role', 'prakerin')->with('prakerinProfile');

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('prakerinProfile', function($qp) use ($search) {
                      $qp->where('nisn', 'like', "%{$search}%")
                         ->orWhere('school', 'like', "%{$search}%")
                         ->orWhere('department', 'like', "%{$search}%");
                  });
            });
        }

        // Filter functionality
        if ($request->has('status') && $request->status != '') {
            $status = $request->status;
            $query->whereHas('prakerinProfile', function($q) use ($status) {
                $q->where('status', $status);
            });
        }

        $students = $query->orderBy('created_at', 'desc')->get();

        $recentActivities = Activity::with('user:id,name')
            ->orderBy('date', 'desc')
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        $recentActivitiesByUser = [];
        foreach ($students as $student) {
            $recentActivitiesByUser[$student->id] = Activity::where('user_id', $student->id)
                ->orderBy('date', 'desc')
                ->orderBy('created_at', 'desc')
                ->take(2)
                ->get();
        }

        // Calculate statistics
        $stats = [
            'total' => User::where('role', 'prakerin')->count(),
            'pending' => PrakerinProfile::where('status', 'pending')->count(),
            'approved' => PrakerinProfile::where('status', 'approved')->count(),
            'rejected' => PrakerinProfile::where('status', 'rejected')->count(),
        ];

        return view('admin.dashboard', compact('students', 'stats', 'recentActivities', 'recentActivitiesByUser'));
    }

    /**
     * Validate/Approve/Reject Prakerin student.
     */
    public function validatePrakerin(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', 'in:approved,rejected,pending']
        ]);

        $profile = PrakerinProfile::where('user_id', $id)->firstOrFail();
        $profile->status = $request->status;
        $profile->save();

        $statusLabel = $request->status == 'approved' ? 'Disetujui' : ($request->status == 'rejected' ? 'Ditolak' : 'Ditunda');

        return back()->with('success', "Status data prakerin {$profile->user->name} berhasil diperbarui menjadi {$statusLabel}.");
    }

    /**
     * Show form to create new Prakerin student.
     */
    public function create()
    {
        return view('admin.prakerin.create');
    }

    /**
     * Store newly created Prakerin student.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'nisn' => ['required', 'string', 'max:20'],
            'school' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'status' => ['required', 'in:pending,approved,rejected'],
        ]);

        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'prakerin',
            ]);

            PrakerinProfile::create([
                'user_id' => $user->id,
                'nisn' => $request->nisn,
                'school' => $request->school,
                'department' => $request->department,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'status' => $request->status,
            ]);

            DB::commit();

            return redirect()->route('admin.dashboard')->with('success', 'Data peserta Prakerin baru berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal menambahkan data peserta.'])->withInput();
        }
    }

    /**
     * Show form to edit Prakerin student.
     */
    public function edit($id)
    {
        $student = User::where('role', 'prakerin')->with('prakerinProfile')->findOrFail($id);
        return view('admin.prakerin.edit', compact('student'));
    }

    /**
     * Update Prakerin student.
     */
    public function update(Request $request, $id)
    {
        $user = User::where('role', 'prakerin')->findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'password' => ['nullable', 'string', 'min:8'],
            'nisn' => ['required', 'string', 'max:20'],
            'school' => ['required', 'string', 'max:255'],
            'department' => ['required', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'status' => ['required', 'in:pending,approved,rejected'],
        ]);

        DB::beginTransaction();
        try {
            $userData = [
                'name' => $request->name,
                'email' => $request->email,
            ];

            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $user->update($userData);

            $profile = PrakerinProfile::where('user_id', $user->id)->firstOrFail();
            $profile->update([
                'nisn' => $request->nisn,
                'school' => $request->school,
                'department' => $request->department,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'status' => $request->status,
            ]);

            DB::commit();

            return redirect()->route('admin.dashboard')->with('success', 'Data peserta Prakerin berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal memperbarui data peserta.'])->withInput();
        }
    }

    /**
     * Delete Prakerin student.
     */
    public function destroy($id)
    {
        $user = User::where('role', 'prakerin')->findOrFail($id);
        $user->delete(); // Cascades deletes profile and activities

        return redirect()->route('admin.dashboard')->with('success', 'Data peserta Prakerin berhasil dihapus.');
    }

    /**
     * View daily activities of a specific Prakerin student.
     */
    public function activities($id)
    {
        $student = User::where('role', 'prakerin')->with('prakerinProfile')->findOrFail($id);
        $activities = Activity::where('user_id', $id)
            ->orderBy('date', 'desc')
            ->orderBy('submitted_at', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.prakerin.activities', compact('student', 'activities'));
    }
}
