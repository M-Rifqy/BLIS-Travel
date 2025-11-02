@extends('layouts.admin.index')

@section('title', 'Gallery Kegiatan')

@section('content')
    <div class="pagetitle">
        <h1>Gallery: {{ $activity->title }}</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.activity.index') }}">Kegiatan</a></li>
                <li class="breadcrumb-item active">Gallery</li>
            </ol>
        </nav>
    </div>

    <x-admin.error-message />

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Daftar Gallery</h5>

            <!-- Tombol Tambah -->
            <button class="btn btn-sm btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createGalleryModal">
                <i class="bi bi-plus-lg"></i> Tambah Gallery
            </button>
            @include('pages.admin.gallery.create')

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th>No</th>
                            <th>Gambar</th>
                            <th>Caption</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($galleries as $index => $gallery)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td class="text-center">
                                    <img src="{{ asset('storage/' . $gallery->image) }}" alt="Gallery" width="100">
                                </td>
                                <td>{{ $gallery->caption ?? '-' }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editGalleryModal-{{ $gallery->id }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger btn-delete"
                                            data-id="{{ $gallery->id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                        <form id="delete-form-{{ $gallery->id }}"
                                            action="{{ route('admin.activity.gallery.destroy', ['activity' => $activity->id, 'gallery' => $gallery->id]) }}"
                                            method="POST" style="display:none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            @include('pages.admin.gallery.edit', ['gallery' => $gallery])
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script>
        document.querySelectorAll('.btn-delete').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                Swal.fire({
                    title: 'Yakin ingin menghapus gallery ini?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then(result => {
                    if (result.isConfirmed) {
                        document.getElementById(`delete-form-${id}`).submit();
                    }
                });
            });
        });

        $('form').on('submit', function() {
            const btn = $(this).find('button[type="submit"]');
            const spinner = btn.find('.spinner-border');
            const text = btn.find('span:not(.spinner-border)');
            btn.prop('disabled', true);
            spinner.removeClass('d-none');
            if (text) text.text('Memproses...');
        });
    </script>
@endpush
