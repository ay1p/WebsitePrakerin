@extends('layouts.app')

@section('title', 'Jurnal Kegiatan Peserta')

@section('content')
<div class="row">
    <div class="col-lg-12">
        <!-- Back Button -->
        <div class="mb-4">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary rounded-pill">
                <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Dashboard
            </a>
        </div>

        <!-- Student Brief Info Card -->
        <div class="premium-card p-4 mb-4 border-0 shadow-sm" style="background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);">
            <div class="row align-items-center g-3">
                <div class="col-md-auto text-center">
                    <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center fw-bold text-primary display-6" style="width: 75px; height: 75px;">
                        {{ strtoupper(substr($student->name, 0, 2)) }}
                    </div>
                </div>
                <div class="col-md">
                    <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
                        <h3 class="mb-0 font-title text-dark">#{{ $student->id }} - {{ $student->name }}</h3>
                        @if($student->prakerinProfile->status === 'pending')
                            <span class="badge-pending"><i class="fa-regular fa-clock me-1"></i>Menunggu</span>
                        @elseif($student->prakerinProfile->status === 'approved')
                            <span class="badge-approved"><i class="fa-regular fa-circle-check me-1"></i>Disetujui</span>
                        @else
                            <span class="badge-rejected"><i class="fa-regular fa-circle-xmark me-1"></i>Ditolak</span>
                        @endif
                    </div>
                    <p class="text-secondary mb-1"><i class="fa-solid fa-envelope me-2"></i>{{ $student->email }}</p>
                    <div class="d-flex flex-wrap gap-x-4 gap-y-1 small text-secondary">
                        <span class="me-3"><i class="fa-solid fa-school me-1"></i> Asal: <b>{{ $student->prakerinProfile->school }}</b></span>
                        <span class="me-3"><i class="fa-solid fa-address-card me-1"></i> NISN: <b>{{ $student->prakerinProfile->nisn }}</b></span>
                        <span class="me-3"><i class="fa-solid fa-graduation-cap me-1"></i> Jurusan: <b>{{ $student->prakerinProfile->department }}</b></span>
                        <span><i class="fa-regular fa-calendar-days me-1"></i> Periode: <b>{{ \Carbon\Carbon::parse($student->prakerinProfile->start_date)->translatedFormat('d M Y') }} s/d {{ \Carbon\Carbon::parse($student->prakerinProfile->end_date)->translatedFormat('d M Y') }}</b></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Activity Timeline -->
        <div class="premium-card p-4">
            <h4 class="font-title text-dark mb-4"><i class="fa-solid fa-book-open text-primary me-2"></i>Jurnal Kegiatan Harian</h4>

            @forelse($activities as $activity)
                <div class="p-3 mb-3 bg-light rounded-3 border-start border-primary border-4 shadow-sm" style="transition: transform 0.2s;">
                    <div class="row align-items-start">
                        <div class="col-md-3 border-end border-2 border-white mb-2 mb-md-0">
                            <div class="fw-bold text-dark"><i class="fa-regular fa-calendar text-muted me-2"></i>{{ \Carbon\Carbon::parse($activity->date)->translatedFormat('d M Y') }}</div>
                        </div>
                        <div class="col-md-9 ps-md-4">
                            <h6 class="fw-semibold text-primary mb-1">Catatan Kegiatan</h6>
                            <p class="text-dark mb-2" style="white-space: pre-line;">{{ $activity->activity }}</p>
                            @if($activity->attachment_paths)
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach($activity->attachment_paths as $attachmentPath)
                                        @php($isImage = in_array(strtolower(pathinfo($attachmentPath, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png']))
                                        @if($isImage)
                                            <button type="button" class="btn btn-sm btn-outline-primary rounded-3"
                                                data-bs-toggle="modal"
                                                data-bs-target="#attachmentPreviewModal"
                                                data-image-url="{{ asset($attachmentPath) }}">
                                                <i class="fa-solid fa-image me-1"></i>Lihat Foto
                                            </button>
                                        @else
                                            <a href="{{ asset($attachmentPath) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-3">
                                                <i class="fa-solid fa-paperclip me-1"></i>Lihat Lampiran
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5 text-secondary">
                    <i class="fa-solid fa-book-journal-whills display-6 text-muted mb-3 d-block"></i>
                    Belum ada jurnal kegiatan yang diinput oleh peserta ini.
                </div>
            @endforelse

            @if($activities->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    <nav aria-label="Navigasi halaman jurnal kegiatan">
                        <ul class="pagination mb-0">
                            <li class="page-item {{ $activities->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link" href="{{ $activities->previousPageUrl() ?? '#' }}" aria-label="Sebelumnya">&laquo;</a>
                            </li>

                            @foreach($activities->getUrlRange(1, $activities->lastPage()) as $page => $url)
                                <li class="page-item {{ $page == $activities->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach

                            <li class="page-item {{ $activities->hasMorePages() ? '' : 'disabled' }}">
                                <a class="page-link" href="{{ $activities->nextPageUrl() ?? '#' }}" aria-label="Berikutnya">&raquo;</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            @endif
        </div>
    </div>
</div>

<div class="modal fade" id="attachmentPreviewModal" tabindex="-1" aria-labelledby="attachmentPreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title font-title text-dark" id="attachmentPreviewModalLabel">
                    <i class="fa-solid fa-image text-primary me-2"></i>Preview Foto
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body text-center pt-0">
                <img id="attachmentPreviewImage" src="" alt="Preview lampiran" class="img-fluid rounded-3" style="max-height: 70vh;">
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const attachmentModal = document.getElementById('attachmentPreviewModal');
        const attachmentImage = document.getElementById('attachmentPreviewImage');

        if (attachmentModal && attachmentImage) {
            attachmentModal.addEventListener('show.bs.modal', function (event) {
                attachmentImage.src = event.relatedTarget.getAttribute('data-image-url');
            });
            attachmentModal.addEventListener('hidden.bs.modal', function () {
                attachmentImage.src = '';
            });
        }
    });
</script>
@endsection
