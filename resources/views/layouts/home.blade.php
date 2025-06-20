<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite('resources/js/app.js')
    <title>Словарный запас</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/js/app.js', 'resources/css/app.css'])
    <style>
        body {

        }

    </style>
</head>
<body class="bg-neutral-100">

    <nav class="sticky top-0 bg-white shadow-md p-0 z-10">
        <div class="container mx-auto py-3 flex justify-between items-center">
            <div class="flex items-center">
                <a href="/">
                            <img
                                src="/logo.png"
                                class="logo"
                                style="height: 40px; width: 40px"
                            />
                </a>
                <a href="/home">
                    <p class="ml-2 font-bold">Словарный запас</p>
                </a>
                <div class="ml-20">
                    <a href="/about" class="ml-10">О сервисе</a>
                </div>
            </div>
            <div class="hidden md:flex md:items-center md:space-x-4">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <input type="submit" class="m-2 cursor-pointer hover:underline decoration-red-400 underline-offset-10  hover:underline decoration-red-400 underline-offset-10" value="Выйти">
                </form>
            </div>
        </div>
    </nav>
    <div class="flex">
        @include('home._menu')

        <!-- Main Content -->
        <main class="flex-1 p-6 mr-30">
            @yield('content')
        </main>
    </div>

</body>
</html>
