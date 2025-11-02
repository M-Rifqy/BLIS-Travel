@extends('layouts.admin.index')

@section('title', 'Absensi - ' . $activity->title)

@push('style')
<style>
    .attendance-header {
        background: linear-gradient(135deg, #0d6efd, #00bcd4);
        color: white;
        padding: 35px 30px;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }

    .attendance-header h2 {
        font-weight: 700;
        margin-bottom: 8px;
    }

    .attendance-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        font-size: 0.95rem;
        opacity: 0.9;
    }

    .attendance-meta i {
        margin-right: 5px;
    }

    .stat-card {
        border-radius: 12px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        background: #fff;
        padding: 20px;
        transition: all 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0,0,0,0.1);
    }

    .stat-card h6 {
        font-weight: 600;
        color: #6c757d;
    }

    .stat-card .value {
        font-size: 1.5rem;
        font-weight: 700;
        color: #0d6efd;
    }

    .table-container {
        background: #fff;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    table th {
        background: #f8f9fa;
        color: #495057;
        font-weight: 600;
    }

    table td {
        vertical-align: middle;
    }

    .table-hover tbody tr:hover {
        background-color: #f1f7ff;
    }

    .empty-state {
        text-align: center;
        color: #6c757d;
        padding: 40px 0;
        font-size: 1.1rem;
    }

    @media (max-width: 768px) {
        .attendance-meta {
            flex-direction: column;
        }
    }
</style>
@endpush

@section('content')
<div class="pagetitle">
    <h1>Absensi Kegiatan</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('client.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Riwayat Absensi</li>
        </ol>
    </nav>
</div>

<!-- Header Section -->
<div class="attendance-header">
    <h2>{{ $activity->title }}</h2>
    <div class="attendance-meta">
        <div><i class="bi bi-geo-alt"></i> {{ $activity->location ?? '-' }}</div>
        <div><i class="bi bi-calendar-event"></i>
            {{ \Carbon\Carbon::parse($activity->start_date)->format('d M Y') }}
            -
            {{ \Carbon\Carbon::parse($activity->end_date)->format('d M Y') }}
        </div>
    </div>
</div>

<!-- Statistic Cards -->
<div class="row mb-4">
    <div class="col-md-4">
        <div class="stat-card text-center">
            <h6>Total Kehadiran</h6>
            <div class="value">{{ $attendances->count() }}</div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card text-center">
            <h6>Kehadiran Terakhir</h6>
            <div class="value">
                {{ $attendances->first() 
                    ? \Carbon\Carbon::parse($attendances->first()->check_in_time)->format('d M Y H:i') 
                    : '-' }}
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="stat-card text-center">
            <h6>Status Peserta</h6>
            <div class="value text-success">Aktif</div>
        </div>
    </div>
</div>

<!-- Attendance Table -->
<div class="table-container">
    <h5 class="mb-3 fw-semibold"><i class="bi bi-clock-history me-2"></i>Riwayat Absensi</h5>
    @if ($attendances->isEmpty())
        <div class="empty-state">
            <i class="bi bi-calendar-x fs-3 mb-2 d-block"></i>
            Belum ada data absensi.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Grup</th>
                        <th>Waktu Check-in</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($attendances as $att)
                        <tr>
                            <td>{{ $att->group ?? '-' }}</td>
                            <td>{{ \Carbon\Carbon::parse($att->check_in_time)->format('d M Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
