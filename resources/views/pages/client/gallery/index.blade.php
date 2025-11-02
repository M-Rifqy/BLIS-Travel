@extends('layouts.admin.index')

@section('title', 'Galeri - ' . $activity->title)

@push('style')
<style>
    /* Masonry style layout */
    .masonry {
        column-count: 4;
        column-gap: 1rem;
    }

    @media (max-width: 1200px) {
        .masonry { column-count: 3; }
    }

    @media (max-width: 768px) {
        .masonry { column-count: 2; }
    }

    @media (max-width: 576px) {
        .masonry { column-count: 1; }
    }

    .masonry-item {
        display: inline-block;
        margin-bottom: 1rem;
        width: 100%;
        border-radius: 12px;
        overflow: hidden;
        position: relative;
        cursor: zoom-in;
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    .masonry-item:hover {
        transform: scale(1.02);
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
    }

    .masonry-item img {
        width: 100%;
        height: auto;
        border-radius: 12px;
        display: block;
    }

    .photo-caption {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);
        color: #fff;
        font-size: 0.85rem;
        padding: 8px 12px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .masonry-item:hover .photo-caption {
        opacity: 1;
    }

    /* Modal */
    .modal-img {
        width: 100%;
        height: auto;
        border-radius: 10px;
    }
</style>
@endpush

@section('content')
<div class="pagetitle">
    <h1>Galeri Kegiatan: {{ $activity->title }}</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('client.index') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Galeri Kegiatan</li>
        </ol>
    </nav>
</div>

@if($galleries->isEmpty())
    <div class="text-center text-muted mt-4">
        <i class="bi bi-image" style="font-size: 2rem;"></i>
        <p class="mt-2">Belum ada galeri tersedia.</p>
    </div>
@else
    <div class="masonry">
        @foreach ($galleries as $gallery)
            <div class="masonry-item" data-bs-toggle="modal" data-bs-target="#galleryModal-{{ $gallery->id }}">
                <img src="{{ asset('storage/' . $gallery->image) }}" alt="Foto Galeri">
                @if ($gallery->caption)
                    <div class="photo-caption">{{ $gallery->caption }}</div>
                @endif
            </div>

            <!-- Modal (lightbox) -->
            <div class="modal fade" id="galleryModal-{{ $gallery->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content border-0 bg-transparent shadow-none">
                        <img src="{{ asset('storage/' . $gallery->image) }}" class="modal-img" alt="Preview">
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
@endsection
