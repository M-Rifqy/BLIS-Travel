@extends('layouts.admin.index')

@section('title', 'Kegiatan')

@section('content')

    <div class="pagetitle">
        <h1>Manajemen Kegiatan</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                <li class="breadcrumb-item active">Kegiatan</li>
            </ol>
        </nav>
    </div>

    <x-admin.error-message />

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="card-title m-0">Daftar Kegiatan</h5>
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createActivityModal">
                    + Tambah Kegiatan
                </button>
            </div>

            {{-- Modal Tambah --}}
            @include('pages.admin.activity.create')

            {{-- Grid Card --}}
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @forelse ($activities as $activity)
                    <div class="col">
                        <div class="card h-100 shadow-sm border-0 hover-card">
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title fw-bold text-dark">{{ $activity->title }}</h5>
                                <p class="text-muted mb-2 small">
                                    <i class="bi bi-geo-alt"></i> {{ $activity->location ?: 'Lokasi belum ditentukan' }}
                                </p>
                                <p class="flex-grow-1 mb-3 small">
                                    {{ Str::limit($activity->description, 100) ?: 'Tidak ada deskripsi.' }}
                                </p>

                                <div class="d-flex justify-content-between align-items-center mt-auto pt-3 border-top">
                                    <div>
                                        <span class="badge bg-primary">
                                            <i class="bi bi-calendar-event"></i>
                                            {{ \Carbon\Carbon::parse($activity->start_date)->format('d M Y') }}
                                        </span>
                                        <span class="badge bg-secondary">
                                            {{ \Carbon\Carbon::parse($activity->end_date)->format('d M Y') }}
                                        </span>
                                    </div>

                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm border dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-gear"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end shadow-sm">
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.activity.attendance.index', $activity->id) }}">
                                                    <i class="bi bi-card-checklist text-success"></i> Absensi
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.activity.document.index', $activity->id) }}">
                                                    <i class="bi bi-file-earmark-text text-primary"></i> Dokumen
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.activity.gallery.index', $activity->id) }}">
                                                    <i class="bi bi-image text-warning"></i> Galeri
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('admin.activity.participant.index', ['activity' => $activity->id]) }}">
                                                    <i class="bi bi-people text-info"></i> Peserta
                                                </a>
                                            </li>
                                            <li><hr class="dropdown-divider"></li>
                                            <li>
                                                <button class="dropdown-item text-warning" data-bs-toggle="modal"
                                                    data-bs-target="#editActivityModal-{{ $activity->id }}">
                                                    <i class="bi bi-pencil"></i> Edit
                                                </button>
                                            </li>
                                            <li>
                                                <button type="button" class="dropdown-item text-danger btn-delete"
                                                    data-id="{{ $activity->id }}">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Modal Edit --}}
                    @include('pages.admin.activity.edit', ['activity' => $activity])
                @empty
                    <div class="col text-center py-5">
                        <i class="bi bi-folder2-open fs-1 text-muted"></i>
                        <p class="text-muted mt-2">Belum ada kegiatan yang ditambahkan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

@endsection

{{-- ===== STYLE SECTION ===== --}}
@push('style')
<style>
    .hover-card {
        transition: all 0.2s ease;
    }
    .hover-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 14px rgba(0, 0, 0, 0.08);
    }
    .card-title {
        font-size: 1.05rem;
    }
</style>
@endpush


{{-- ===== SCRIPT SECTION ===== --}}
@push('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // SweetAlert Delete Confirmation
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

            // Button Loading State
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

    {{-- SweetAlert Notifications --}}
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
