@extends('layouts.admin.index')

@section('title', 'Peserta')

@section('content')

    <div class="pagetitle">
        <h1>Manajemen Peserta</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.activity.index') }}">Kegiatan</a></li>
                <li class="breadcrumb-item active">Peserta</li>
            </ol>
        </nav>
    </div>

    <x-admin.error-message />

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Daftar Peserta</h5>

            <div class="mb-3">
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createParticipantModal">
                    + Tambah Peserta
                </button>
                @include('pages.admin.participant.create')
            </div>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Activity</th>
                            <th>Status</th>
                            <th>QR Token</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($participants as $index => $participant)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $participant->full_name }}</td>
                                <td>{{ $participant->user?->email ?? '-' }}</td>
                                <td>{{ $participant->phone ?: '-' }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $participant->activity->title }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-secondary">{{ $participant->status }}</span>
                                </td>
                                <td>
                                    <img src="data:image/png;base64,{{ base64_encode((string) \Endroid\QrCode\Builder\Builder::create()->data($participant->qr_token)->size(100)->build()->getString()) }}"
                                        alt="QR Code">
                                </td>

                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <form
                                            action="{{ route('admin.activity.participant.reset-password', [$activity->id, $participant->id]) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-info"
                                                onclick="return confirm('Reset password peserta ini?')">
                                                <i class="bi bi-key"></i>
                                            </button>
                                        </form>

                                        <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                            data-bs-target="#qrModal-{{ $participant->id }}">
                                            <i class="bi bi-qr-code"></i>
                                        </button>
                                        <a href="{{ route('admin.activity.participant.document.index', [$activity->id, $participant->id]) }}"
                                            class="btn btn-sm btn-primary" title="Dokumen">
                                            <i class="bi bi-file-earmark-text"></i>
                                        </a>
                                        
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editParticipantModal-{{ $participant->id }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger btn-delete"
                                            data-id="{{ $participant->id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>

                                        <form id="delete-form-{{ $participant->id }}"
                                            action="{{ route('admin.activity.participant.destroy', [$activity->id, $participant->id]) }}"
                                            method="POST" style="display:none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>


                                    </div>
                                </td>
                            </tr>

                            @include('pages.admin.participant.edit', [
                                'participant' => $participant,
                            ])

                            <div class="modal fade" id="qrModal-{{ $participant->id }}" tabindex="-1"
                                aria-labelledby="qrModalLabel-{{ $participant->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="qrModalLabel-{{ $participant->id }}">QR Code
                                                {{ $participant->full_name }}
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <img src="data:image/png;base64,{{ base64_encode((string) \Endroid\QrCode\Builder\Builder::create()->data($participant->qr_token)->size(200)->build()->getString()) }}"
                                                alt="QR Code">
                                        </div>
                                        <div class="modal-footer">
                                            <a href="{{ route('admin.activity.participant.download-qr', [$activity->id, $participant->id]) }}"
                                                class="btn btn-primary">
                                                Download QR
                                            </a>
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Delete confirmation
            document.querySelectorAll('.btn-delete').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.getAttribute('data-id');
                    Swal.fire({
                        title: 'Yakin ingin menghapus kegiatan ini?',
                        text: "Data yang dihapus tidak bisa dikembalikan.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById(`delete-form-${id}`).submit();
                        }
                    });
                });
            });

            // Submit animation
            $('form').on('submit', function() {
                const btn = $(this).find('button[type="submit"]');
                const spinner = btn.find('.spinner-border');
                const text = btn.find('span:not(.spinner-border)');
                btn.prop('disabled', true);
                spinner.removeClass('d-none');
                if (text) text.text('Memproses...');
            });
        });
    </script>

    {{-- SweetAlert Notification --}}
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: '{{ session('success') }}',
                timer: 2000,
                showConfirmButton: false
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
            });
        </script>
    @endif
@endpush
