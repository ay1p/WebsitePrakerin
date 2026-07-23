<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PrakerinController extends Controller
{
    /**
     * Prakerin Student Dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();
        $profile = $user->prakerinProfile;

        // Only load activities if approved
        $activities = [];
        if ($profile && $profile->status === 'approved') {
            $activities = Activity::with('attachments')->where('user_id', $user->id)
                ->orderBy('date', 'desc')
                ->paginate(5);
        }

        return view('prakerin.dashboard', compact('user', 'profile', 'activities'));
    }

    /**
     * Store a new daily activity.
     */
    public function storeActivity(Request $request)
    {
        $user = Auth::user();

        // Security check: must be approved
        if (!$user->prakerinProfile || $user->prakerinProfile->status !== 'approved') {
            return back()->withErrors(['error' => 'Anda tidak diizinkan mengisi kegiatan sebelum status divalidasi oleh Admin.']);
        }

        $request->validate([
            'activity' => ['required', 'string', 'min:5'],
            'attachment' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,ppt,pptx,txt', 'max:5120'],
        ], [
            'activity.required' => 'Deskripsi kegiatan wajib diisi.',
            'activity.min' => 'Deskripsi kegiatan minimal 5 karakter.',
            'attachment.required' => 'Lampiran file wajib diunggah.',
            'attachment.file' => 'Lampiran harus berupa file yang valid.',
            'attachment.mimes' => 'Format lampiran tidak didukung.',
            'attachment.max' => 'Ukuran lampiran maksimal 5 MB.',
        ]);

        $attachmentPath = $this->storeAttachment($request->file('attachment'));

        Activity::create([
            'user_id' => $user->id,
            'date' => now()->toDateString(),
            'activity' => $request->activity,
            'attachment_path' => $attachmentPath,
            'submitted_at' => now(),
        ]);

        return redirect()->route('prakerin.dashboard')->with('success', 'Jurnal kegiatan berhasil ditambahkan.');
    }

    /**
     * Update an existing daily activity.
     */
    public function updateActivity(Request $request, $id)
    {
        $user = Auth::user();

        // Security check: must be approved
        if (!$user->prakerinProfile || $user->prakerinProfile->status !== 'approved') {
            return back()->withErrors(['error' => 'Akses ditolak.']);
        }

        $activity = Activity::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        $request->validate([
            'activity' => ['required', 'string', 'min:5'],
            'attachment' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf,doc,docx,xls,xlsx,ppt,pptx,txt', 'max:5120'],
        ], [
            'activity.required' => 'Deskripsi kegiatan wajib diisi.',
            'activity.min' => 'Deskripsi kegiatan minimal 5 karakter.',
            'attachment.file' => 'Lampiran harus berupa file yang valid.',
            'attachment.mimes' => 'Format lampiran tidak didukung.',
            'attachment.max' => 'Ukuran lampiran maksimal 5 MB.',
        ]);

        if ($request->hasFile('attachment')) {
            $this->deleteAttachment($activity->attachment_path);
            $attachmentPath = $this->storeAttachment($request->file('attachment'));
            $activity->attachment_path = $attachmentPath;
        }

        $activity->date = now()->toDateString();
        $activity->activity = $request->activity;
        $activity->submitted_at = now();
        $activity->save();

        return redirect()->route('prakerin.dashboard')->with('success', 'Jurnal kegiatan berhasil diperbarui.');
    }

    /**
     * Add documentation photos to an existing daily activity.
     */
    public function addAttachments(Request $request, $id)
    {
        $user = Auth::user();

        if (!$user->prakerinProfile || $user->prakerinProfile->status !== 'approved') {
            return back()->withErrors(['error' => 'Akses ditolak.']);
        }

        $activity = Activity::where('id', $id)->where('user_id', $user->id)->firstOrFail();

        $request->validate([
            'attachments' => ['required', 'array', 'min:1', 'max:10'],
            'attachments.*' => ['required', 'file', 'mimes:jpg,jpeg,png', 'max:5120'],
        ], [
            'attachments.required' => 'Minimal satu foto dokumentasi wajib dipilih.',
            'attachments.max' => 'Maksimal 10 foto dapat ditambahkan sekaligus.',
            'attachments.*.mimes' => 'Foto harus berformat JPG, JPEG, atau PNG.',
            'attachments.*.max' => 'Ukuran setiap foto maksimal 5 MB.',
        ]);

        foreach ($request->file('attachments') as $file) {
            ActivityAttachment::create([
                'activity_id' => $activity->id,
                'path' => $this->storeAttachment($file),
            ]);
        }

        return redirect()->route('prakerin.dashboard')->with('success', 'Foto dokumentasi berhasil ditambahkan.');
    }

    /**
     * Replace one documentation photo on an existing activity.
     */
    public function replaceAttachment(Request $request, $activityId, $attachmentId)
    {
        $user = Auth::user();

        if (!$user->prakerinProfile || $user->prakerinProfile->status !== 'approved') {
            return back()->withErrors(['error' => 'Akses ditolak.']);
        }

        $activity = Activity::where('id', $activityId)->where('user_id', $user->id)->firstOrFail();
        $attachment = ActivityAttachment::where('activity_id', $activity->id)
            ->whereKey($attachmentId)
            ->firstOrFail();

        $request->validate([
            'attachment' => ['required', 'file', 'mimes:jpg,jpeg,png', 'max:5120'],
        ], [
            'attachment.mimes' => 'Foto harus berformat JPG, JPEG, atau PNG.',
            'attachment.max' => 'Ukuran foto maksimal 5 MB.',
        ]);

        $this->deleteAttachment($attachment->path);
        $attachment->update(['path' => $this->storeAttachment($request->file('attachment'))]);

        return redirect()->route('prakerin.dashboard')->with('success', 'Foto dokumentasi berhasil diganti.');
    }

    /**
     * Delete one documentation photo from an existing activity.
     */
    public function deleteAttachmentRecord($activityId, $attachmentId)
    {
        $user = Auth::user();

        if (!$user->prakerinProfile || $user->prakerinProfile->status !== 'approved') {
            return back()->withErrors(['error' => 'Akses ditolak.']);
        }

        $activity = Activity::where('id', $activityId)->where('user_id', $user->id)->firstOrFail();
        $attachment = ActivityAttachment::where('activity_id', $activity->id)
            ->whereKey($attachmentId)
            ->firstOrFail();

        $this->deleteAttachment($attachment->path);
        $attachment->delete();

        return redirect()->route('prakerin.dashboard')->with('success', 'Foto dokumentasi berhasil dihapus.');
    }

    /**
     * Delete an activity.
     */
    public function destroyActivity($id)
    {
        $user = Auth::user();

        // Security check: must be approved
        if (!$user->prakerinProfile || $user->prakerinProfile->status !== 'approved') {
            return back()->withErrors(['error' => 'Akses ditolak.']);
        }

        $activity = Activity::where('id', $id)->where('user_id', $user->id)->firstOrFail();
        foreach ($activity->attachments as $attachment) {
            $this->deleteAttachment($attachment->path);
        }
        $this->deleteAttachment($activity->attachment_path);
        $activity->delete();

        return redirect()->route('prakerin.dashboard')->with('success', 'Jurnal kegiatan berhasil dihapus.');
    }

    private function storeAttachment($file): string
    {
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeName = preg_replace('/[^A-Za-z0-9._-]+/', '-', $originalName);
        $filename = time() . '_' . Str::slug($safeName) . '.' . $file->getClientOriginalExtension();

        $destinationPath = public_path('uploads/prakerin');
        if (!is_dir($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        $file->move($destinationPath, $filename);

        return 'uploads/prakerin/' . $filename;
    }

    private function deleteAttachment(?string $path): void
    {
        if (empty($path)) {
            return;
        }

        $fullPath = public_path($path);
        if (file_exists($fullPath)) {
            @unlink($fullPath);
        }
    }
}
