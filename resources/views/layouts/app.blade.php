<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>DUTCL</title>

    <!-- Bootstrap 5 CSS (via CDN) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Optional custom styles -->
    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    @include('layouts.navigation')

    <!-- Page Header -->
    @hasSection('header')
        <header class="bg-white shadow-sm py-3 mb-4 border-bottom">
            <div class="container">
                <h1 class="h4 mb-0">
                    @yield('header')
                </h1>
            </div>
        </header>
    @endif

    <!-- Page Content -->
    <main class="container mb-5">
        @yield('content')
    </main>

    <!-- Bootstrap 5 JS (via CDN) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Select2 JS from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- Optional custom scripts -->
    @stack('scripts')
</body>
</html>
