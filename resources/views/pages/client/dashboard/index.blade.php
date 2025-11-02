@extends('layouts.admin.index')

@section('title', 'Dashboard Saya')

@section('content')

    <div class="pagetitle">
        <h1>Dashboard Saya</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('client.index') }}">Home</a></li>
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
        </nav>
    </div>

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">

                    <!-- Total Kegiatan -->
                    <div class="col-xxl-4 col-md-6">
                        <div class="card info-card sales-card">
                            <div class="card-body">
                                <h5 class="card-title">Kegiatan diikuti</h5>
                                <div class="d-flex align-items-center">
                                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                        <i class="bi bi-calendar-event"></i>
                                    </div>
                                    <div class="ps-3">
                                        <h6>{{ $joinedActivities->count() }}</h6>
                                        <span class="text-muted small pt-2 ps-1">Total kegiatan kamu</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- End Total Kegiatan -->

                </div>
            </div>
            <div class="col-lg-12">
                <h5 class="card-title mb-4">Kegiatan yang Kamu Ikuti</h5>
                <div class="row">
                    @forelse ($joinedActivities as $activity)
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
                                            <a href="{{ route('client.activity.show', $activity->id) }}"
                                                class="btn btn-outline-info btn-sm" title="Detail Kegiatan">
                                                <i class="bi bi-eye"></i>
                                            </a>

                                            <a href="{{ route('client.activity.document', $activity->id) }}"
                                                class="btn btn-outline-primary btn-sm" title="Dokumen kegiatan">
                                                <i class="bi bi-file-earmark-text"></i>
                                            </a>

                                            <a href="{{ route('client.activity.gallery', $activity->id) }}"
                                                class="btn btn-outline-warning btn-sm" title="Galeri kegiatan">
                                                <i class="bi bi-image"></i>
                                            </a>

                                            <a href="{{ route('client.activity.attendance', $activity->id) }}"
                                                class="btn btn-outline-success btn-sm" title="Absensi Kegiatan">
                                                <i class="bi bi-card-checklist"></i>
                                            </a>
                                        </div>

                                        <a href="{{ route('client.profile') }}" class="btn btn-outline-secondary btn-sm"
                                            title="Profil Saya">
                                            <i class="bi bi-person-circle"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-secondary text-center mt-3">
                                <i class="bi bi-info-circle me-1"></i> Belum ada kegiatan yang kamu ikuti.
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

@endsection

@push('style')
    <style>
        .hover-card {
            transition: all 0.2s ease;
        }

        .hover-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 14px rgba(0, 0, 0, 0.08);
        }
    </style>
@endpush
