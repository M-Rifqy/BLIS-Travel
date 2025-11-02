@extends('layouts.admin.index')

@section('title', 'Dokumen Peserta')

@section('content')

    <div class="pagetitle">
        <h1>Manajemen Dokumen Peserta</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.index') }}">Home</a></li>
                <li class="breadcrumb-item">
                    <a href="{{ route('admin.activity.participant.index', $participant->activity_id) }}">Peserta</a>
                </li>
                <li class="breadcrumb-item active">{{ $participant->full_name }}</li>
            </ol>
        </nav>
    </div>

    <x-admin.error-message />

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Daftar Dokumen - {{ $participant->full_name }}</h5>

            <div class="mb-3">
                <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createDocumentModal">
                    + Upload Dokumen
                </button>
                @include('pages.admin.participant.document.create')
            </div>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light text-center">
                        <tr>
                            <th style="width:50px;">No</th>
                            <th>Judul Dokumen</th>
                            <th>File</th>
                            <th>Visibility</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($documents as $index => $document)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $document->title }}</td>
                                <td class="text-center">
                                    <a href="{{ asset('storage/' . $document->file) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-file-earmark"></i> Lihat
                                    </a>
                                </td>
                                <td class="text-center">
                                    <span class="badge bg-{{ $document->visibility === 'public' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($document->visibility) }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#editDocumentModal-{{ $document->id }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>

                                        <button type="button" class="btn btn-sm btn-danger btn-delete"
                                            data-id="{{ $document->id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>

                                        <form id="delete-form-{{ $document->id }}"
                                            action="{{ route('admin.activity.participant.document.destroy', [
                                                'activity' => $participant->activity_id,
                                                'participant' => $participant->id,
                                                'document' => $document->id
                                            ]) }}" method="POST" style="display:none;">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>

                            @include('pages.admin.participant.document.edit', ['document' => $document])
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
                        title: 'Yakin ingin menghapus dokumen ini?',
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
