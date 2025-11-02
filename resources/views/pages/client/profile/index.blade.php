@extends('layouts.admin.index')

@section('title', 'Profil Saya')

@push('style')
    <style>
        .id-card {
            max-width: 420px;
            margin: 0 auto;
            background: linear-gradient(135deg, #007bff, #00c6ff);
            color: #fff;
            border-radius: 20px;
            padding: 2rem;
            text-align: center;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }

        .id-card::before {
            content: "";
            position: absolute;
            top: -30px;
            right: -30px;
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .id-card img.avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            border: 3px solid #fff;
            margin-bottom: 1rem;
        }

        .id-card h4 {
            font-weight: bold;
            margin-bottom: 0.25rem;
        }

        .id-card p {
            margin-bottom: 0.25rem;
            font-size: 0.95rem;
        }

        .id-card .badge-role {
            background: rgba(255, 255, 255, 0.2);
            padding: 0.3rem 0.75rem;
            border-radius: 20px;
            font-size: 0.85rem;
        }

        .id-footer {
            margin-top: 1rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 0.75rem;
            font-size: 0.85rem;
        }

        .qr-container {
            margin-top: 1.5rem;
            background: #fff;
            border-radius: 12px;
            padding: 1rem;
            display: inline-block;
        }

        .qr-container img {
            width: 140px;
            height: 140px;
        }

        .qr-label {
            margin-top: 0.5rem;
            font-size: 0.85rem;
            color: #d0d0d0;
        }
    </style>
@endpush

@section('content')
    <div class="pagetitle">
        <h1>Profil Saya</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('client.index') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Profil Saya</li>
            </ol>
        </nav>
    </div>

    <div class="id-card mt-4">
        {{-- Avatar --}}
        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" alt="Avatar"
            class="avatar">

        {{-- Informasi dasar --}}
        <h4>{{ $participant->full_name ?? $user->name }}</h4>
        <p class="mb-1">{{ $user->email }}</p>
        <p class="badge-role">{{ ($user->role === 'client') ? 'Peserta' : ucfirst($user->role ?? '') }}</p>

        {{-- Detail tambahan --}}
        <div class="id-footer">
            <p><strong>Nomor HP:</strong> {{ $participant->phone ?? '-' }}</p>
            <p><strong>Status:</strong> {{ ucfirst($participant->status ?? 'Active') }}</p>
        </div>

        {{-- QR Code --}}
        <div class="qr-container mt-3">
            <img src="data:image/png;base64,{{ base64_encode(QrCode::format('png')->size(200)->margin(1)->generate($participant->qr_token)) }}"
                alt="QR Code">
            <div class="qr-label">Tunjukkan QR ini untuk absensi</div>
        </div>
    </div>
@endsection
