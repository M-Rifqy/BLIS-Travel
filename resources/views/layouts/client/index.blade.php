<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Index - Learner Bootstrap Template</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/client/img/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/client/img/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/client/img/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('assets/client/img/site.webmanifest') }}">
    <link rel="icon" href="{{ asset('assets/client/img/favicon.ico') }}">


    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Ubuntu:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/client/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/client/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/client/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/client/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="assets/client/css/main.css" rel="stylesheet">

    @stack('style')

    <!-- =======================================================
  * Template Name: Learner
  * Template URL: https://bootstrapmade.com/learner-bootstrap-course-template/
  * Updated: Jul 08 2025 with Bootstrap v5.3.7
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body class="index-page">

    @include('components.client.sections.header')

    <main class="main">
        @yield('content')
    </main>

    @include('components.client.sections.footer')

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="assets/client/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/client/vendor/php-email-form/validate.js"></script>
    <script src="assets/client/vendor/aos/aos.js"></script>
    <script src="assets/client/vendor/purecounter/purecounter_vanilla.js"></script>
    <script src="assets/client/vendor/swiper/swiper-bundle.min.js"></script>

    <!-- Main JS File -->
    <script src="assets/client/js/main.js"></script>

    @stack('script')
</body>

</html>
