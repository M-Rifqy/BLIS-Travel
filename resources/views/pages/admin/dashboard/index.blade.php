@extends('layouts.admin.index')

@section('title', 'Dashboard')

@section('content')
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">

            <!-- Statistik ringkas -->
            <div class="col-lg-12">
                <div class="row">

                    <!-- Total Kegiatan -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Total Kegiatan</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-calendar-event"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $activities->count() }}</h6>
                                        <span class="text-muted small pt-2 ps-1">Kegiatan Terdaftar</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Total Kegiatan -->

                    <!-- Total Peserta -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card customers-card">
                            <div class="card-body">
                                <h5 class="card-title">Total Peserta</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-people"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $participants->count() }}</h6>
                                        <span class="text-muted small pt-2 ps-1">Peserta Terdaftar</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Total Peserta -->

                </div>
            </div>

            <!-- Daftar Kegiatan -->
            <div class="col-12">
                <div class="card">
                    <div class="card-body pb-0">
                        <div class="d-flex justify-content-between align-items-center mt-3 mb-2">
                            <h5 class="card-title mb-0">Daftar Kegiatan</h5>
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#createActivityModal">
                                + Tambah Kegiatan
                            </button>
                        </div>
                        @include('pages.admin.activity.create')
                    </div>
                </div>

                <div class="row">
                    @forelse ($activities as $activity)
                        <div class="col-xl-4 col-md-6 mb-4">
                            <div class="card shadow-sm border-0 h-100">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold mb-2">{{ $activity->title }}</h5>
                                    <p class="text-muted small mb-2">
                                        <i class="bi bi-geo-alt"></i> {{ $activity->location ?: '-' }}
                                    </p>
                                    <p class="text-muted small mb-3">
                                        <i class="bi bi-calendar-week"></i>
                                        {{ \Carbon\Carbon::parse($activity->start_date)->format('d M Y') }}
                                        -
                                        {{ \Carbon\Carbon::parse($activity->end_date)->format('d M Y') }}
                                    </p>

                                    <p class="text-muted" style="min-height: 60px;">
                                        {{ Str::limit($activity->description, 80) ?: '-' }}
                                    </p>

                                    <div class="d-flex justify-content-between mt-3">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.activity.attendance.index', $activity->id) }}"
                                                class="btn btn-outline-success btn-sm" title="Absensi">
                                                <i class="bi bi-card-checklist"></i>
                                            </a>
                                            <a href="{{ route('admin.activity.document.index', $activity->id) }}"
                                                class="btn btn-outline-primary btn-sm" title="Dokumen">
                                                <i class="bi bi-file-earmark-text"></i>
                                            </a>
                                            <a href="{{ route('admin.activity.gallery.index', $activity->id) }}"
                                                class="btn btn-outline-warning btn-sm" title="Galeri">
                                                <i class="bi bi-image"></i>
                                            </a>
                                            <a href="{{ route('admin.activity.participant.index', ['activity' => $activity->id]) }}"
                                                class="btn btn-outline-info btn-sm" title="Peserta">
                                                <i class="bi bi-people"></i>
                                            </a>
                                        </div>

                                        <div class="btn-group" role="group">
                                            <button class="btn btn-outline-warning btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#editActivityModal-{{ $activity->id }}">
                                                <i class="bi bi-pencil"></i>
                                            </button>

                                            <button type="button" class="btn btn-outline-danger btn-sm btn-delete"
                                                data-id="{{ $activity->id }}">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @include('pages.admin.activity.edit', ['activity' => $activity])
                    @empty
                        <div class="col-12">
                            <div class="alert alert-secondary text-center mt-3">
                                <i class="bi bi-info-circle me-1"></i> Belum ada kegiatan yang terdaftar.
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>

        </div>
    </section>
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
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
        });
    </script>

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
