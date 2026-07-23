@extends('layouts.app')

@section('title', 'Ubah Data Peserta')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <!-- Back Button -->
        <div class="mb-4">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary rounded-pill">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Dashboard
            </a>
        </div>

        <!-- Edit Card -->
        <div class="premium-card p-4 shadow-lg border-0">
            <h3 class="font-title text-dark mb-4"><i class="fa-solid fa-user-pen text-warning me-2"></i>Ubah Data Peserta: {{ $student->name }}</h3>

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show shadow-sm d-flex align-items-center gap-2 mb-4" role="alert">
                    <i class="fa-solid fa-circle-exclamation fs-5"></i>
                    <div>
                        <ul class="mb-0 ps-3 small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.prakerin.update', $student->id) }}">
                @csrf
                @method('PUT')

                <!-- Section 1: Akun Pengguna -->
                <div class="border-bottom pb-3 mb-4">
                    <h5 class="text-primary mb-3 font-title"><i class="fa-solid fa-circle-user me-2"></i>Komponen Akun</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-medium text-dark">Nama Lengkap</label>
                            <input id="name" name="name" type="text" class="form-control rounded-3 py-2" placeholder="Nama lengkap siswa" value="{{ old('name', $student->name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-medium text-dark">Alamat Email</label>
                            <input id="email" name="email" type="email" class="form-control rounded-3 py-2" placeholder="email@contoh.com" value="{{ old('email', $student->email) }}" required>
                        </div>
                        <div class="col-md-12">
                            <label for="password" class="form-label fw-medium text-dark">Kata Sandi Baru (Opsional)</label>
                            <input id="password" name="password" type="text" class="form-control rounded-3 py-2" placeholder="Kosongkan jika tidak ingin mengubah kata sandi">
                        </div>
                    </div>
                </div>

                <!-- Section 2: Data Prakerin (Komponen Diri) -->
                <div class="border-bottom pb-3 mb-4">
                    <h5 class="text-primary mb-3 font-title"><i class="fa-solid fa-address-card me-2"></i>Komponen Diri (Data Prakerin)</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nisn" class="form-label fw-medium text-dark">NISN (Nomor Induk Siswa Nasional)</label>
                            <input id="nisn" name="nisn" type="text" class="form-control rounded-3 py-2" placeholder="Nomor induk siswa" value="{{ old('nisn', $student->prakerinProfile->nisn ?? '') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="school" class="form-label fw-medium text-dark">Asal Sekolah / Instansi</label>
                            <input id="school" name="school" type="text" class="form-control rounded-3 py-2" placeholder="Contoh: SMK Negeri 1 Jakarta" value="{{ old('school', $student->prakerinProfile->school ?? '') }}" required>
                        </div>
                        <div class="col-md-12">
                            <label for="department" class="form-label fw-medium text-dark">Jurusan / Kompetensi Keahlian</label>
                            <input id="department" name="department" type="text" class="form-control rounded-3 py-2" placeholder="Contoh: Rekayasa Perangkat Lunak" value="{{ old('department', $student->prakerinProfile->department ?? '') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="start_date" class="form-label fw-medium text-dark">Tanggal Mulai Magang</label>
                            <input id="start_date" name="start_date" type="date" class="form-control rounded-3 py-2" value="{{ old('start_date', $student->prakerinProfile->start_date ?? '') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="end_date" class="form-label fw-medium text-dark">Tanggal Selesai Magang</label>
                            <input id="end_date" name="end_date" type="date" class="form-control rounded-3 py-2" value="{{ old('end_date', $student->prakerinProfile->end_date ?? '') }}" required>
                        </div>
                    </div>
                </div>

                <!-- Section 3: Status Validasi -->
                <div class="mb-4">
                    <h5 class="text-primary mb-3 font-title"><i class="fa-solid fa-shield-halved me-2"></i>Status Validasi</h5>
                    <div class="col-md-6">
                        <label for="status" class="form-label fw-medium text-dark">Status Validasi</label>
                        <select id="status" name="status" class="form-select rounded-3 py-2" required>
                            <option value="approved" {{ old('status', $student->prakerinProfile->status ?? '') == 'approved' ? 'selected' : '' }}>Disetujui (Approved)</option>
                            <option value="pending" {{ old('status', $student->prakerinProfile->status ?? '') == 'pending' ? 'selected' : '' }}>Menunggu Validasi (Pending)</option>
                            <option value="rejected" {{ old('status', $student->prakerinProfile->status ?? '') == 'rejected' ? 'selected' : '' }}>Ditolak (Rejected)</option>
                        </select>
                        <small class="text-muted">Peserta yang berstatus disetujui dapat mengisi jurnal harian.</small>
                    </div>
                </div>

                <button type="submit" class="btn btn-gradient-success w-100 py-2.5 rounded-3">
                    <i class="fa-solid fa-floppy-disk me-2"></i> Perbarui Data Peserta
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
