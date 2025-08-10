<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CinemaHub - Xem Phim Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    @stack('styles')
    <style>
        .link {
            color: white;
        }

        .link:hover {
            color: red;
        }
    </style>
</head>

<body class="">
    {{-- Header --}}
    @include('user.partials.header')

    {{-- Content --}}
    <main>
        @yield('content')
    </main>
    @include('user.pages.chatbot')

    {{-- Footer --}}
    @include('user.partials.footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    @stack('scripts')

</body>

</html>