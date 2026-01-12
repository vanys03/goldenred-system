<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased bg-[#fdfaf6]">
    <div class="min-h-screen flex flex-col items-center justify-center">
        <div class="mb-4">
            <a href="/">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="w-24 h-auto mx-auto">
            </a>
        </div>

        <div class="w-full sm:max-w-md px-6 py-4 bg-[#fdfaf6]">
            {{ $slot }}
        </div>
    </div>

    <script>
        window.addEventListener('pageshow', function (event) {
            if (event.persisted) {
                window.location.reload();
            }
        });
    </script>
</body>

</html>
