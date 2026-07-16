@extends('layouts.app')

@section('title', 'Prakerin Student Dashboard')

@section('content')
<div class="row g-4">
    <!-- Student Profile Card (Always Visible) -->
    <div class="col-lg-4">
        <div class="premium-card p-4 h-100 shadow-sm">
            <div class="text-center mb-4 border-bottom pb-4">
                <div class="rounded-circle bg-primary bg-opacity-10 d-inline-flex align-items-center justify-content-center fw-bold text-primary mb-3 display-6" style="width: 80px; height: 80px;">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <h4 class="font-title text-dark mb-1">{{ $user->name }}</h4>
                <span class="badge bg-secondary rounded-pill px-3">{{ $user->email }}</span>
            </div>

            <h5 class="font-title text-primary mb-3"><i class="fa-solid fa-address-card me-2"></i>Komponen Diri</h5>
            <div class="vstack gap-3 text-secondary small">
                <div>
                    <span class="d-block text-muted mb-0.5">NISN</span>
                    <strong class="text-dark fs-6">{{ $profile->nisn ?? '-' }}</strong>
                </div>
                <div>
                    <span class="d-block text-muted mb-0.5">Asal Sekolah / Instansi</span>
                    <strong class="text-dark fs-6">{{ $profile->school ?? '-' }}</strong>
                </div>
                <div>
                    <span class="d-block text-muted mb-0.5">Jurusan</span>
                    <strong class="text-dark fs-6">{{ $profile->department ?? '-' }}</strong>
                </div>
                <div>
                    <span class="d-block text-muted mb-0.5">Periode Pelaksanaan</span>
                    @if($profile)
                        <strong class="text-dark fs-6">
                            {{ \Carbon\Carbon::parse($profile->start_date)->translatedFormat('d M Y') }}
                            s/d
                            {{ \Carbon\Carbon::parse($profile->end_date)->translatedFormat('d M Y') }}
                        </strong>
                    @else
                        <strong class="text-dark fs-6">-</strong>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Area: Status and Activity logs -->
    <div class="col-lg-8">
        <!-- Status Notification Alert -->
        @if($profile)
            @if($profile->status === 'pending')
                <div class="alert alert-warning border-0 shadow-sm d-flex gap-3 p-4 mb-4" role="alert">
                    <i class="fa-solid fa-hourglass-half fs-2 text-warning"></i>
                    <div>
                        <h5 class="alert-heading font-title fw-bold text-warning-emphasis">Status Pendaftaran: Menunggu Validasi</h5>
                        <p class="mb-0 small text-warning-emphasis opacity-90">Data pendaftaran dan komponen diri Anda saat ini sedang ditinjau oleh Administrator. Anda baru dapat mengisi jurnal kegiatan harian setelah status pendaftaran Anda disetujui (Approved).</p>
                    </div>
                </div>
            @elseif($profile->status === 'rejected')
                <div class="alert alert-danger border-0 shadow-sm d-flex gap-3 p-4 mb-4" role="alert">
                    <i class="fa-solid fa-circle-xmark fs-2 text-danger"></i>
                    <div>
                        <h5 class="alert-heading font-title fw-bold text-danger-emphasis">Status Pendaftaran: Ditolak</h5>
                        <p class="mb-0 small text-danger-emphasis opacity-90">Maaf, data pendaftaran Anda ditolak oleh Admin. Silakan hubungi pihak pembimbing industri atau admin untuk melakukan perbaikan data komponen diri Anda.</p>
                    </div>
                </div>
            @else
                <div class="alert alert-success border-0 shadow-sm d-flex gap-3 p-4 mb-4" role="alert">
                    <i class="fa-solid fa-circle-check fs-2 text-success"></i>
                    <div>
                        <h5 class="alert-heading font-title fw-bold text-success-emphasis">Status Pendaftaran: Divalidasi</h5>
                        <p class="mb-0 small text-success-emphasis opacity-90 font-sans">Data diri Anda telah divalidasi oleh Admin. Anda sekarang memiliki akses penuh untuk mengisi jurnal kegiatan magang harian di bawah.</p>
                    </div>
                </div>
            @endif
        @endif

        <!-- Jurnal Kegiatan Section (Only if status is approved) -->
        @if($profile && $profile->status === 'approved')
            <!-- Add Activity Form -->
            <div class="premium-card p-4 mb-4">
                <h5 class="font-title text-dark mb-3"><i class="fa-solid fa-file-signature text-primary me-2"></i>Tambah Jurnal Kegiatan Harian</h5>
                <form action="{{ route('prakerin.activities.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="activity" class="form-label fw-medium text-secondary small">Deskripsi Kegiatan</label>
                            <textarea name="activity" id="activity" rows="6" class="form-control rounded-3 py-2" placeholder="Apa yang Anda kerjakan hari ini? (min. 5 karakter)" required></textarea>
                            <small class="text-muted d-block mt-1">Tanggal kegiatan akan otomatis diset ke hari saat Anda mengirim jurnal.</small>
                        </div>
                        <div class="col-md-9">
                            <label for="attachment" class="form-label fw-medium text-secondary small">Lampiran File</label>
                            <input type="file" name="attachment" id="attachment" class="form-control rounded-3 py-2" required accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt">
                            <small class="text-muted d-block mt-1">Wajib diunggah, maksimal 5 MB.</small>
                        </div>
                        <div class="col-md-4 d-flex align-items-end justify-content-md-end">
                            <button type="submit" class="btn btn-gradient-primary rounded-4 px-4 py-2 w-100">
                                <i class="fa-solid fa-paper-plane me-1"></i> Kirim Kegiatan
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- List of activities -->
            <div class="premium-card p-4">
                <h5 class="font-title text-dark mb-4"><i class="fa-solid fa-receipt text-primary me-2"></i>Riwayat Jurnal Kegiatan</h5>

                @forelse($activities as $activity)
                    <div class="p-3 mb-3 bg-light rounded-3 border-start border-primary border-4 shadow-sm">
                        <div class="row align-items-center">
                            <div class="col-md-3 border-end border-2 border-white mb-2 mb-md-0">
                                <div class="fw-bold text-dark"><i class="fa-regular fa-calendar text-muted me-2"></i>{{ \Carbon\Carbon::parse($activity->date)->translatedFormat('d M Y') }}</div>
                            </div>
                            <div class="col-md-6 py-1">
                                <p class="text-dark mb-0 small" style="white-space: pre-line;">{{ $activity->activity }}</p>
                                @if($activity->attachment_path)
                                    <a href="{{ asset($activity->attachment_path) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-3 mt-2">
                                        <i class="fa-solid fa-paperclip me-1"></i> Lihat Lampiran
                                    </a>
                                @endif
                            </div>
                            <div class="col-md-3 text-end">
                                <button type="button" class="btn btn-sm btn-outline-warning rounded-3 me-1"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editActivityModal"
                                    data-id="{{ $activity->id }}"
                                    data-date="{{ $activity->date }}"
                                    data-activity="{{ $activity->activity }}">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </button>
                                <form action="{{ route('prakerin.activities.destroy', $activity->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus catatan kegiatan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-3">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5 text-secondary">
                        <i class="fa-solid fa-book-journal-whills display-6 text-muted mb-3 d-block"></i>
                        Belum ada kegiatan yang dicatat. Silakan isi form di atas.
                    </div>
                @endforelse
            </div>
        @else
            <!-- Display profile placeholder when NOT approved -->
            <div class="premium-card p-4 text-center py-5 text-secondary">
                <i class="fa-solid fa-lock display-5 text-muted mb-3 d-block"></i>
                <h5 class="font-title text-dark">Jurnal Kegiatan Terkunci</h5>
                <p class="small text-secondary mb-0 col-md-8 mx-auto">Anda belum dapat mengisi dan melihat riwayat kegiatan magang karena akun Anda belum divalidasi oleh Administrator.</p>
            </div>
        @endif
    </div>
</div>

<!-- Bootstrap Edit Activity Modal (Only if approved) -->
@if($profile && $profile->status === 'approved')
<div class="modal fade" id="editActivityModal" tabindex="-1" aria-labelledby="editActivityModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title font-title text-dark" id="editActivityModalLabel"><i class="fa-solid fa-pen-to-square text-warning me-2"></i>Ubah Jurnal Kegiatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editActivityForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body pt-3">
                    <div class="mb-3">
                        <label for="edit_attachment" class="form-label fw-medium text-secondary small">Lampiran File</label>
                        <input type="file" name="attachment" id="edit_attachment" class="form-control rounded-3 py-2" required accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt">
                        <small class="text-muted d-block mt-1">Maksimal 5 MB. Unggah ulang file jika ingin menggantinya.</small>
                    </div>
                    <div class="mb-3">
                        <label for="edit_activity" class="form-label fw-medium text-secondary small">Deskripsi Kegiatan</label>
                        <textarea name="activity" id="edit_activity" rows="4" class="form-control rounded-3 py-2" required></textarea>
                    </div>
                </div>
                <div class="modal-footer border-top-0 pt-0">
                    <button type="button" class="btn btn-outline-secondary rounded-3" data-bs-modal="dismiss" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-gradient-success rounded-3 px-4">
                        <i class="fa-solid fa-floppy-disk me-1"></i> Perbarui
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const editModal = document.getElementById('editActivityModal');
        if (editModal) {
            editModal.addEventListener('show.bs.modal', function (event) {
                // Button that triggered the modal
                const button = event.relatedTarget;

                // Extract info from data-* attributes
                const id = button.getAttribute('data-id');
                const activity = button.getAttribute('data-activity');

                // Update form action url dynamically
                const form = editModal.querySelector('#editActivityForm');
                form.action = `/prakerin/activities/${id}`;

                // Update input values
                editModal.querySelector('#edit_activity').value = activity;
                editModal.querySelector('#edit_attachment').value = '';
            });
        }
    });
</script>
@endif
@endsection
