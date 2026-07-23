@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<!-- Header and Quick Stats -->
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
    <div>
        <h2 class="font-title text-dark mb-1">Dashboard Administrator</h2>
        <p class="text-secondary mb-0">Kelola pendaftaran, validasi data, dan jurnal kegiatan peserta Prakerin.</p>
    </div>
    <div>
        <a href="{{ route('admin.prakerin.create') }}" class="btn btn-gradient-primary rounded-pill shadow-sm">
            <i class="fa-solid fa-user-plus me-2"></i>Tambah Peserta Baru
        </a>
    </div>
</div>

<!-- Stat Cards -->
<div class="row g-4 mb-5">
    <div class="col-6 col-lg-3">
        <div class="stat-card primary">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-uppercase text-white-50 small mb-1">Total Peserta</h6>
                    <h2 class="font-title mb-0">{{ $stats['total'] }}</h2>
                </div>
                <div class="stat-card-icon">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card warning">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-uppercase text-white-50 small mb-1">Menunggu Validasi</h6>
                    <h2 class="font-title mb-0">{{ $stats['pending'] }}</h2>
                </div>
                <div class="stat-card-icon">
                    <i class="fa-solid fa-hourglass-half"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card success">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-uppercase text-white-50 small mb-1">Disetujui (Aktif)</h6>
                    <h2 class="font-title mb-0">{{ $stats['approved'] }}</h2>
                </div>
                <div class="stat-card-icon">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card danger">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="text-uppercase text-white-50 small mb-1">Ditolak</h6>
                    <h2 class="font-title mb-0">{{ $stats['rejected'] }}</h2>
                </div>
                <div class="stat-card-icon">
                    <i class="fa-solid fa-circle-xmark"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Search, Filter & Student Table Card -->
<div class="premium-card p-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
        <h4 class="font-title mb-0 text-dark">Data Peserta Prakerin</h4>

        <!-- Search and Filter Form -->
        <form action="{{ route('admin.dashboard') }}" method="GET" class="d-flex flex-wrap gap-2 align-items-center col-12 col-md-auto">
            <div class="input-group" style="max-width: 250px;">
                <span class="input-group-text bg-white border-end-0 text-secondary"><i class="fa-solid fa-magnifying-glass"></i></span>
                <input type="text" name="search" class="form-control border-start-0 rounded-end-3" placeholder="Cari nama, sekolah..." value="{{ request('search') }}">
            </div>

            <select name="status" class="form-select rounded-3" style="max-width: 160px;" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
            </select>

            @if(request('search') || request('status'))
                <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary rounded-3" title="Clear Filter">
                    <i class="fa-solid fa-rotate-left"></i>
                </a>
            @endif
        </form>
    </div>

    <!-- Table content -->
    <div class="table-responsive">
        <table class="table custom-table mb-0 align-middle">
            <thead>
                <tr>
                    <th>ID Peserta</th>
                    <th>Peserta</th>
                    <th>NISN & Asal Sekolah</th>
                    <th>Jurusan</th>
                    <th>Periode Magang</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Validasi Data</th>
                    <th class="text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                    <tr>
                        <td>
                            <span class="fw-semibold text-dark">#{{ $student->id }}</span>
                        </td>

                        <!-- Student Profile -->
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center fw-bold text-primary" style="width: 42px; height: 42px;">
                                    {{ strtoupper(substr($student->name, 0, 2)) }}
                                </div>
                                <div>
                                    <div class="fw-semibold text-dark">{{ $student->name }}</div>
                                    <small class="text-muted">{{ $student->email }}</small>
                                </div>
                            </div>
                        </td>

                        <!-- School Information -->
                        <td>
                            @if($student->prakerinProfile)
                                <div class="text-dark">{{ $student->prakerinProfile->school }}</div>
                                <small class="text-muted">NISN: {{ $student->prakerinProfile->nisn }}</small>
                            @else
                                <span class="text-danger small">Belum mengisi profil</span>
                            @endif
                        </td>

                        <!-- Department -->
                        <td>
                            @if($student->prakerinProfile)
                                <span class="text-dark">{{ $student->prakerinProfile->department }}</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>

                        <!-- Date range -->
                        <td>
                            @if($student->prakerinProfile)
                                <div class="small text-dark">
                                    <i class="fa-regular fa-calendar-days text-muted me-1"></i>
                                    {{ \Carbon\Carbon::parse($student->prakerinProfile->start_date)->translatedFormat('d M Y') }}
                                </div>
                                <div class="small text-dark mt-1">
                                    <i class="fa-regular fa-calendar-check text-muted me-1"></i>
                                    {{ \Carbon\Carbon::parse($student->prakerinProfile->end_date)->translatedFormat('d M Y') }}
                                </div>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>

                        <!-- Status badge -->
                        <td class="text-center">
                            @if($student->prakerinProfile)
                                @if($student->prakerinProfile->status === 'pending')
                                    <span class="badge-pending"><i class="fa-regular fa-clock me-1"></i>Menunggu</span>
                                @elseif($student->prakerinProfile->status === 'approved')
                                    <span class="badge-approved"><i class="fa-regular fa-circle-check me-1"></i>Disetujui</span>
                                @else
                                    <span class="badge-rejected"><i class="fa-regular fa-circle-xmark me-1"></i>Ditolak</span>
                                @endif
                            @else
                                <span class="badge bg-secondary">N/A</span>
                            @endif
                        </td>

                        <!-- Validation Buttons -->
                        <td class="text-center">
                            @if($student->prakerinProfile)
                                <div class="d-flex justify-content-center gap-1">
                                    @if($student->prakerinProfile->status !== 'approved')
                                        <form action="{{ route('admin.prakerin.validate', $student->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="btn btn-sm btn-success rounded-3 py-1.5 px-2.5" title="Setujui/Validasi">
                                                <i class="fa-solid fa-check"></i> Setujui
                                            </button>
                                        </form>
                                    @endif

                                    @if($student->prakerinProfile->status !== 'rejected')
                                        <form action="{{ route('admin.prakerin.validate', $student->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="status" value="rejected">
                                            <button type="submit" class="btn btn-sm btn-danger rounded-3 py-1.5 px-2.5" title="Tolak">
                                                <i class="fa-solid fa-xmark"></i> Tolak
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @else
                                <span class="text-muted small">No profile yet</span>
                            @endif
                        </td>

                        <!-- CRUD Actions -->
                        <td class="text-center">
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle rounded-3" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Pilih Aksi
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-2">
                                    <li>
                                        <a class="dropdown-item rounded-2" href="{{ route('admin.prakerin.activities', $student->id) }}">
                                            <i class="fa-solid fa-book-open text-primary me-2"></i>Lihat Jurnal Kegiatan`
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item rounded-2" href="{{ route('admin.prakerin.edit', $student->id) }}">
                                            <i class="fa-solid fa-pen-to-square text-warning me-2"></i>Ubah Profil
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('admin.prakerin.destroy', $student->id) }}" method="POST" class="d-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus peserta ini? Seluruh jurnal kegiatan juga akan terhapus.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger rounded-2">
                                                <i class="fa-solid fa-trash me-2"></i>Hapus Peserta
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-secondary">
                            <i class="fa-regular fa-folder-open display-6 text-muted mb-3 d-block"></i>
                            Tidak ada data peserta magang yang ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($students->hasPages())
        <div class="d-flex justify-content-center mt-4">
            <nav aria-label="Navigasi halaman daftar peserta">
                <ul class="pagination mb-0">
                    <li class="page-item {{ $students->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $students->previousPageUrl() ?? '#' }}" aria-label="Sebelumnya">&laquo;</a>
                    </li>

                    @foreach($students->getUrlRange(1, $students->lastPage()) as $page => $url)
                        <li class="page-item {{ $page == $students->currentPage() ? 'active' : '' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach

                    <li class="page-item {{ $students->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $students->nextPageUrl() ?? '#' }}" aria-label="Berikutnya">&raquo;</a>
                    </li>
                </ul>
            </nav>
        </div>
    @endif
</div>
@endsection
