@extends('layouts.admin.index')

@section('title', $activity->title)

@push('style')
<style>
    /* Hero section */
    .activity-hero {
        background: linear-gradient(135deg, #007bff, #00bcd4);
        color: #fff;
        border-radius: 12px;
        padding: 40px 30px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        margin-bottom: 2rem;
    }

    .activity-hero h2 {
        font-weight: 700;
        margin-bottom: 10px;
    }

    .activity-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        font-size: 0.95rem;
        opacity: 0.9;
    }

    .activity-meta i {
        margin-right: 5px;
    }

    /* Description Card */
    .activity-description {
        background: #fff;
        border-radius: 12px;
        padding: 25px 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 2rem;
    }

    .activity-description h5 {
        font-weight: 600;
        margin-bottom: 1rem;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .action-buttons a {
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s ease;
    }

    .action-buttons a:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    /* Empty state */
    .text-muted i {
        font-size: 1.3rem;
    }
</style>
@endpush

@section('content')
<div class="pagetitle">
    <h1>Detail Kegiatan</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('client.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">{{ $activity->title }}</li>
        </ol>
    </nav>
</div>

<!-- Hero Section -->
<div class="activity-hero">
    <h2>{{ $activity->title }}</h2>
    <div class="activity-meta">
        <div><i class="bi bi-geo-alt"></i> {{ $activity->location ?? '-' }}</div>
        <div><i class="bi bi-calendar-event"></i>
            {{ \Carbon\Carbon::parse($activity->start_date)->format('d M Y') }}
            -
            {{ \Carbon\Carbon::parse($activity->end_date)->format('d M Y') }}
        </div>
    </div>
</div>

<!-- Deskripsi -->
<div class="activity-description">
    <h5>Deskripsi Kegiatan</h5>
    <p class="text-muted mb-0">{{ $activity->description ?? 'Tidak ada deskripsi kegiatan.' }}</p>
</div>

<!-- Action Buttons -->
<div class="action-buttons">
    <a href="{{ route('client.activity.gallery', $activity->id) }}" class="btn btn-outline-primary">
        <i class="bi bi-images me-1"></i> Galeri
    </a>
    <a href="{{ route('client.activity.document', $activity->id) }}" class="btn btn-outline-info">
        <i class="bi bi-file-earmark-text me-1"></i> Dokumen
    </a>
    <a href="{{ route('client.activity.attendance', $activity->id) }}" class="btn btn-outline-success">
        <i class="bi bi-card-checklist me-1"></i> Absensi
    </a>
    <a href="{{ route('client.profile') }}" class="btn btn-outline-secondary">
        <i class="bi bi-person-circle me-1"></i> Profil Saya
    </a>
</div>
@endsection
