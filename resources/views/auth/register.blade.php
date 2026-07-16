@extends('layouts.app')

@section('title', 'Registrasi Peserta Prakerin')

@section('content')
<div class="row justify-content-center py-4">
    <div class="col-lg-8">
        <div class="premium-card p-4 shadow-lg border-0" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
            <div class="text-center mb-4">
                <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                    <i class="fa-solid fa-user-pen fs-4 text-primary"></i>
                </div>
                <h3 class="font-title text-dark">Registrasi Akun Magang</h3>
                <p class="text-secondary small">Lengkapi komponen diri Anda untuk memulai praktik kerja industri (Prakerin)</p>
            </div>

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

            <form method="POST" action="{{ route('register.submit') }}">
                @csrf

                <!-- Section 1: Akun Pengguna -->
                <div class="border-bottom pb-3 mb-4">
                    <h5 class="text-primary mb-3 font-title"><i class="fa-solid fa-circle-user me-2"></i>Komponen Akun</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="name" class="form-label fw-medium text-dark">Nama Lengkap</label>
                            <input id="name" name="name" type="text" class="form-control rounded-3 py-2" placeholder="Nama lengkap Anda" value="{{ old('name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-medium text-dark">Alamat Email</label>
                            <input id="email" name="email" type="email" class="form-control rounded-3 py-2" placeholder="contoh@prakerin.com" value="{{ old('email') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="form-label fw-medium text-dark">Kata Sandi</label>
                            <input id="password" name="password" type="password" class="form-control rounded-3 py-2" placeholder="Minimal 8 karakter" required>
                        </div>
                        <div class="col-md-6">
                            <label for="password_confirmation" class="form-label fw-medium text-dark">Konfirmasi Kata Sandi</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" class="form-control rounded-3 py-2" placeholder="Ulangi kata sandi" required>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Data Prakerin (Komponen Diri) -->
                <div class="mb-4">
                    <h5 class="text-primary mb-3 font-title"><i class="fa-solid fa-address-card me-2"></i>Komponen Diri (Data Prakerin)</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nisn" class="form-label fw-medium text-dark">NISN (Nomor Induk Siswa Nasional)</label>
                            <input id="nisn" name="nisn" type="text" class="form-control rounded-3 py-2" placeholder="Masukkan NISN Anda" value="{{ old('nisn') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="school" class="form-label fw-medium text-dark">Asal Sekolah / Instansi</label>
                            <input id="school" name="school" type="text" class="form-control rounded-3 py-2" placeholder="Contoh: SMK Negeri 1 Jakarta" value="{{ old('school') }}" required>
                        </div>
                        <div class="col-md-12">
                            <label for="department" class="form-label fw-medium text-dark">Jurusan / Kompetensi Keahlian</label>
                            <input id="department" name="department" type="text" class="form-control rounded-3 py-2" placeholder="Contoh: Rekayasa Perangkat Lunak" value="{{ old('department') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="start_date" class="form-label fw-medium text-dark">Tanggal Mulai Magang</label>
                            <input id="start_date" name="start_date" type="date" class="form-control rounded-3 py-2" value="{{ old('start_date') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="end_date" class="form-label fw-medium text-dark">Tanggal Selesai Magang</label>
                            <input id="end_date" name="end_date" type="date" class="form-control rounded-3 py-2" value="{{ old('end_date') }}" required>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-gradient-primary w-100 py-2.5 rounded-3 mb-3">
                    <i class="fa-solid fa-user-plus me-2"></i>Kirim & Daftar Akun
                </button>
            </form>

            <div class="text-center mt-3 border-top pt-3">
                <span class="text-secondary small">Sudah memiliki akun magang?</span>
                <a href="{{ route('login') }}" class="text-primary fw-semibold small text-decoration-none d-block d-md-inline ms-md-1">
                    Masuk Sekarang <i class="fa-solid fa-arrow-right-long small ms-1"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
