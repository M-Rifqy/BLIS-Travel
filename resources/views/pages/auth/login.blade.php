@extends('layouts.client.index')

@section('title', 'Login')

@section('content')

    <!-- Page Title -->
    <div class="page-title light-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Login</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="{{ route('client.home') }}">Home</a></li>
                    <li class="current">Login</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <!-- Login Section -->
    <section id="enroll" class="enroll section">

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="enrollment-form-wrapper">

                        <div class="enrollment-header text-center mb-5" data-aos="fade-up" data-aos-delay="200">
                            <h2>Selamat Datang Kembali</h2>
                            <p>Masuk ke akun Anda untuk melanjutkan aktivitas Anda di sistem.</p>
                        </div>

                        <form class="enrollment-form" action="{{ route('login') }}" method="POST" data-aos="fade-up"
                            data-aos-delay="300">
                            @csrf

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="email" class="form-label">Email *</label>
                                        <input type="email" id="email" name="email" class="form-control" required
                                            autocomplete="email" value="{{ old('email') }}">
                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-4">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="password" class="form-label">Password *</label>

                                        <div class="d-flex align-items-center">
                                            <input type="password" id="password" name="password" class="form-control"
                                                required autocomplete="current-password">
                                            <button type="button" id="togglePassword"
                                                class="btn border-0 bg-transparent ms-n5" style="margin-left: -55px;">
                                                <i class="bi bi-eye fs-5 text-secondary"></i>
                                            </button>
                                        </div>

                                        @error('password')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    const passwordInput = document.getElementById('password');
                                    const toggleBtn = document.getElementById('togglePassword');
                                    const icon = toggleBtn.querySelector('i');

                                    toggleBtn.addEventListener('click', function() {
                                        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                                        passwordInput.setAttribute('type', type);
                                        icon.classList.toggle('bi-eye');
                                        icon.classList.toggle('bi-eye-slash');
                                    });
                                });
                            </script>

                            <div class="row">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-enroll">
                                        Login
                                    </button>
                                    <p class="enrollment-note mt-3 mb-0">
                                        Belum punya akun? Silakan hubungi admin melalui WhatsApp:<br>
                                        <a href="https://wa.me/6281234567890" target="_blank" class="fw-bold text-success">
                                            <i class="bi bi-whatsapp"></i> +62 812-3456-7890
                                        </a>
                                    </p>
                                </div>
                            </div>

                        </form>

                    </div>
                </div><!-- End Form Column -->

                <div class="col-lg-4 d-none d-lg-block">
                    <div class="enrollment-benefits" data-aos="fade-left" data-aos-delay="400">
                        <h3>Fitur yang Dapat Anda Akses!</h3>
                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class="bi bi-file-earmark-text"></i>
                            </div>
                            <div class="benefit-content">
                                <h4>Dokumen & Tiket Perjalanan</h4>
                                <p>Lihat dan unduh tiket pesawat, voucher hotel, visa, serta dokumen penting lainnya
                                    langsung dari sistem.</p>
                            </div>
                        </div>

                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class="bi bi-calendar-event"></i>
                            </div>
                            <div class="benefit-content">
                                <h4>Rundown & Jadwal Kegiatan</h4>
                                <p>Pantau jadwal perjalanan dan agenda kegiatan Anda selama tour berlangsung.</p>
                            </div>
                        </div>

                        <div class="benefit-item">
                            <div class="benefit-icon">
                                <i class="bi bi-person-lines-fill"></i>
                            </div>
                            <div class="benefit-content">
                                <h4>Absensi & Aktivitas</h4>
                                <p>Lakukan absensi dan lihat rekap kehadiran Anda selama kegiatan berlangsung.</p>
                            </div>
                        </div>
                    </div>
                </div><!-- End Benefits Column -->

            </div>

        </div>

    </section><!-- /Login Section -->
@endsection
