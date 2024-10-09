<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>{{ $title ?? 'Home' }} - {{ env('APP_NAME') }}</title>
    <meta name="description" content="{{ env('APP_NAME') }}">
    <meta name="keywords" content="{{ env('APP_NAME') }}">

    <!-- Favicons -->
    <link href="{{ asset('frontend_theme') }}/assets/img/favicon.png" rel="icon">
    <link href="{{ asset('frontend_theme') }}/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Marcellus:wght@400&display=swap"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('frontend_theme') }}/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('frontend_theme') }}/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('frontend_theme') }}/assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="{{ asset('frontend_theme') }}/assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link href="{{ asset('frontend_theme') }}/assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('frontend_theme') }}/assets/css/main.css" rel="stylesheet">

</head>

<body class="index-page">

    @include('layouts.frontend.menu')

    <main class="main" style="min-height: 80vh">

        @yield('main')
    </main>

    @include('layouts.frontend.footer')


    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>


    <!-- Vendor JS Files -->
    <script src="{{ asset('frontend_theme') }}/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('frontend_theme') }}/assets/vendor/php-email-form/validate.js"></script>
    <script src="{{ asset('frontend_theme') }}/assets/vendor/aos/aos.js"></script>
    <script src="{{ asset('frontend_theme') }}/assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="{{ asset('frontend_theme') }}/assets/vendor/glightbox/js/glightbox.min.js"></script>

    <!-- Main JS File -->
    <script src="{{ asset('frontend_theme') }}/assets/js/main.js"></script>

</body>

</html>
