@extends('layouts.admin.index')

@section('title', 'Dokumen - ' . $activity->title)

@section('content')

    <div class="pagetitle">
        <h1>Dokumen Kegiatan: {{ $activity->title }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('client.index') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Dokumen Kegiatan</li>
            </ol>
        </nav>
    </div>

    <div class="row">
        @forelse ($documents as $doc)
            <div class="col-md-4 mb-3">
                <div class="card shadow-sm border-0 p-3 h-100">
                    <h6 class="fw-bold">{{ $doc->title }}</h6>
                    <p class="text-muted small mb-2">
                        {{ $doc->participant_id ? 'Pribadi' : 'Umum' }}
                    </p>
                    <a href="{{ asset('storage/' . $doc->file) }}" class="btn btn-outline-primary btn-sm" target="_blank">
                        <i class="bi bi-download"></i> Unduh
                    </a>
                </div>
            </div>
        @empty
            <div class="col-12 text-center text-muted">Tidak ada dokumen tersedia.</div>
        @endforelse
    </div>
@endsection
