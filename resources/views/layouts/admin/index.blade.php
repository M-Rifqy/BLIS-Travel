<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>@yield('title') &mdash; BLIS Travel </title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/admin/img/favicon/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ asset('assets/admin/img/favicon/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ asset('assets/admin/img/favicon/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('assets/admin/img/favicon/site.webmanifest') }}">
    <link rel="icon" href="{{ asset('assets/admin/img/favicon/favicon.ico') }}" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/admin/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('assets/admin/vendor/quill/quill.snow.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/vendor/quill/quill.bubble.css') }}" rel="stylesheet"> --}}
    <link href="{{ asset('assets/admin/vendor/simple-datatables/style.css') }}" rel="stylesheet">

    <!-- Others -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="{{ asset('assets/admin/css/style.css') }}" rel="stylesheet">

    @stack('style')

    <style>
    </style>

    <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

    <!-- ======= Header ======= -->
    @include('components.admin.header')

    <!-- ======= Sidebar ======= -->
    @include('components.admin.sidebar')

    <main id="main" class="main">

        @yield('content')

    </main><!-- End #main -->

    <!-- ======= Footer ======= -->
    @include('components.admin.footer')

    <a href="#" class="back-to-top d-flex align-items-center justify-content-center bg-danger"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/admin/vendor/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/admin/vendor/chart.js/chart.umd.js') }}"></script>
    <script src="{{ asset('assets/admin/vendor/echarts/echarts.min.js') }}"></script>
    {{-- <script src="{{ asset('assets/admin/vendor/quill/quill.js') }}"></script> --}}
    <script src="{{ asset('assets/admin/vendor/simple-datatables/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/admin/vendor/tinymce/tinymce.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>

    <!-- Others -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-lite.min.js"></script>


    <!-- Template Main JS File -->
    <script src="{{ asset('assets/admin/js/main.js') }}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @if (session('swal'))
                Swal.fire({
                    icon: "{{ session('swal') }}",
                    title: "{{ session('success') ?? (session('error') ?? (session('info') ?? session('warning'))) }}",
                    showConfirmButton: false,
                    timer: 3000
                });
            @endif
        });
    </script>

    <script src="https://unpkg.com/html5-qrcode"></script>

    @stack('script')
</body>

</html>
