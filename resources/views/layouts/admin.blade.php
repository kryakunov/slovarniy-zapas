<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>
<body class="bg-gray-50">
    <nav class="bg-white shadow">
        <div class="container mx-auto py-2 flex justify-between items-center">
            <div class="flex">
                <a href="/">
                <img
                    src="/logo-min.png"
                    class="w-6"
                />                </a><a href="/">
                    <p class="ml-2 font-bold">Словарный запас</p></a>

            </div>
            <div class="hidden md:flex md:items-center md:space-x-4">
                <a class="m-2 hover:underline decoration-red-400 underline-offset-10" href="{{ route('logout') }}">Выйти</a>
            </div>
        </div>
    </nav>
    <div id="app" class="flex">

        @include('admin._menu')

        <main class="flex-1">
            @yield('content')
        </main>
    </div>
</body>
</html>
