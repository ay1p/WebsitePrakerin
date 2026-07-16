@extends('layouts.app')

@section('title', 'Masuk')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-md-5">
        <div class="premium-card p-4 shadow-lg border-0" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px);">
            <div class="text-center mb-4">
                <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                    <i class="fa-solid fa-lock fs-4 text-primary"></i>
                </div>
                <h3 class="font-title text-dark">Masuk ke Akun Anda</h3>
                <p class="text-secondary small">Akses dashboard monitoring E-Prakerin</p>
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

            <form method="POST" action="{{ route('login.submit') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label fw-medium text-dark">
                        <i class="fa-solid fa-envelope text-muted me-2"></i>Alamat Email <span class="text-danger">*</span>
                    </label>
                    <input id="email" name="email" type="email" class="form-control rounded-3 py-2 @error('email') is-invalid @enderror" placeholder="contoh@prakerin.com" value="{{ old('email') }}" required autofocus autocomplete="email">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label fw-medium text-dark">
                        <i class="fa-solid fa-key text-muted me-2"></i>Kata Sandi <span class="text-danger">*</span>
                    </label>
                    <input id="password" name="password" type="password" class="form-control rounded-3 py-2 @error('password') is-invalid @enderror" placeholder="Masukkan password Anda" required autocomplete="current-password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="mb-4 d-flex justify-content-between align-items-center">
                    <div class="form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember" value="1">
                        <label class="form-check-label text-secondary small" for="remember">Ingat Saya</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-gradient-primary w-100 py-2.5 rounded-3 mb-3">
                    <i class="fa-solid fa-right-to-bracket me-2"></i>Masuk
                </button>
            </form>

            <div class="text-center mt-3 border-top pt-3">
                <span class="text-secondary small">Belum punya akun magang?</span>
                <a href="{{ route('register') }}" class="text-primary fw-semibold small text-decoration-none d-block d-md-inline ms-md-1">
                    Daftar Sekarang <i class="fa-solid fa-arrow-right-long small ms-1"></i>
                </a>
            </div>
            
        </div>
    </div>
</div>
@endsection
