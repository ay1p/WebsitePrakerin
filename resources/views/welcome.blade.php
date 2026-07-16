@extends('layouts.app')

@section('title', 'Selamat Datang')

@section('content')
<div class="row align-items-center py-5">
    <div class="col-lg-6 mb-5 mb-lg-0">
        <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-2 mb-3 fw-semibold">
            <i class="fa-solid fa-rocket me-2"></i>Sistem Monitoring Magang Modern
        </span>
        <h1 class="display-4 fw-extrabold mb-3 text-dark brand-font" style="line-height: 1.2;">
            Kelola Kegiatan <span class="text-primary bg-gradient">Prakerin</span> Anda Secara Digital
        </h1>
        <p class="lead text-secondary mb-4">
            E-Prakerin memudahkan siswa melakukan pendaftaran data diri secara mandiri, memudahkan guru/admin melakukan validasi data, serta mencatat jurnal kegiatan harian secara real-time dan terstruktur.
        </p>

        <div class="d-flex flex-wrap gap-3">
            @auth
                <a href="{{ route('dashboard') }}" class="btn btn-gradient-primary btn-lg rounded-pill px-4
                -sm">
                    <i class="fa-solid fa-gauge-high me-2"></i>Masuk Dashboard
                </a>
            @else
                <a href="{{ route('register') }}" class="btn btn-gradient-primary btn-lg rounded-pill px-4 shadow-sm">
                    <i class="fa-solid fa-user-plus me-2"></i>Daftar Prakerin
                </a>
                <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-lg rounded-pill px-4">
                    <i class="fa-solid fa-right-to-bracket me-2"></i>Masuk Akun
                </a>
            @endauth
        </div>
    </div>
    <div class="col-lg-6 text-center">
        <!-- We will create a stunning gradient block representing a card preview -->
        <div class="position-relative d-inline-block p-4">
            <div class="position-absolute translate-middle start-50 top-50 bg-primary opacity-10 rounded-circle filter-blur" style="width: 400px; height: 400px; z-index: -1; filter: blur(50px);"></div>
            <div class="welcome-float-wrapper">
                <div class="premium-card p-4 mx-auto text-start welcome-preview-card" style="max-width: 480px; border-radius: 24px; border: 1px solid rgba(255,255,255,0.7); background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(10px);">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="mb-0 text-dark font-title"><i class="fa-solid fa-circle-check text-success me-2"></i>Status Magang</h5>
                        <span class="badge-approved"><i class="fa-solid fa-check-double me-1"></i>Divalidasi</span>
                    </div>

                    <div class="mb-4">
                        <small class="text-muted d-block mb-1">Nama Peserta</small>
                        <strong class="fs-5 text-dark">Nama Lengkap Anda</strong>
                    </div>

                    <div class="row mb-4">
                        <div class="col-6">
                            <small class="text-muted d-block mb-1">Sekolah</small>
                            <span class="text-dark fw-semibold">Asal Sekolah</span>
                        </div>
                        <div class="col-6">
                            <small class="text-muted d-block mb-1">Jurusan</small>
                            <span class="text-dark fw-semibold">Contoh: PPLG</span>
                        </div>
                    </div>

                    <div class="border-top pt-4">
                        <h6 class="text-dark mb-3"><i class="fa-solid fa-list-check text-primary me-2"></i>Jurnal Terbaru</h6>
                        <div class="p-3 bg-light rounded-3 mb-2 border-start border-primary border-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <small class="fw-bold text-dark">Hari Ke-3</small>
                                <small class="text-muted">15 Juli 2026</small>
                            </div>
                            <p class="small text-secondary mb-0">Artikel Kegiatan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="py-5 my-5 border-top">
    <div class="text-center mb-5">
        <h2 class="font-title display-6">Bagaimana Alur E-Prakerin Bekerja?</h2>
        <p class="text-secondary col-md-6 mx-auto">Tiga langkah mudah untuk mendokumentasikan kegiatan magang industri Anda secara profesional.</p>
    </div>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="premium-card p-4 text-center h-100">
                <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-4" style="width: 70px; height: 70px;">
                    <i class="fa-solid fa-address-card fs-3 text-primary"></i>
                </div>
                <h4 class="font-title">1. Registrasi (Komponen Diri)</h4>
                <p class="text-secondary small">Siswa melakukan registrasi akun magang sekaligus melengkapi data diri (komponen diri) seperti NISN, sekolah, jurusan, dan tanggal pelaksanaan magang.</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="premium-card p-4 text-center h-100">
                <div class="rounded-circle bg-warning bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-4" style="width: 70px; height: 70px;">
                    <i class="fa-solid fa-user-shield fs-3 text-warning"></i>
                </div>
                <h4 class="font-title">2. Validasi Data Admin</h4>
                <p class="text-secondary small">Admin melakukan verifikasi dan peninjauan data siswa yang mendaftar. Admin dapat menyetujui (Approve) atau menolak (Reject) pendaftaran tersebut.</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="premium-card p-4 text-center h-100">
                <div class="rounded-circle bg-success bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-4" style="width: 70px; height: 70px;">
                    <i class="fa-solid fa-file-pen fs-3 text-success"></i>
                </div>
                <h4 class="font-title">3. Isi Jurnal Kegiatan</h4>
                <p class="text-secondary small">Setelah data divalidasi oleh Admin, siswa dapat mengakses fitur pengisian jurnal harian untuk mencatat kegiatan praktik kerja industri mereka.</p>
            </div>
        </div>
    </div>
</div>
@endsection
