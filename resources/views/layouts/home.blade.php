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
{{--                <img--}}
{{--                    src="/logo-min.png"--}}
{{--                    class="w-6"--}}
{{--                />--}}
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 100 100"><path fill="#C0392B" fill-rule="evenodd" d="M6 100h88a6 6 0 0 0 6-6V6a6 6 0 0 0-6-6H6a6 6 0 0 0-6 6v88a6 6 0 0 0 6 6z" clip-rule="evenodd"/><path fill="#E74C3C" fill-rule="evenodd" d="M100 30h-.025a5.5 5.5 0 0 0-5.475-5H6.25C2.937 25 0 22.314 0 19V6a6 6 0 0 1 6-6h88c3.313 0 6 2.687 6 6.001V30z" clip-rule="evenodd"/><path fill-rule="evenodd" d="M5 100h2V0H5v100z" clip-rule="evenodd" opacity=".15"/><path fill="#fff" fill-rule="evenodd" d="M7 100h2V0H7v100z" clip-rule="evenodd" opacity=".15"/><path fill="#fff" fill-rule="evenodd" d="M100 10.001a5 5 0 0 0-5-5H7a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h87a6 6 0 0 1 6 6v-15h-.101c.066-.323.101-.658.101-1z" clip-rule="evenodd"/><path fill="#95A5A6" fill-rule="evenodd" d="M100 15.423v-3.921s.183-4-5-4H5v2h89a5.995 5.995 0 0 1 5.98 5.616c-.107-1-.789-3.615-4.98-3.615H5v2h89a5.995 5.995 0 0 1 5.98 5.616c-.107-1.001-.789-3.616-4.98-3.616H5v2h89a6 6 0 0 1 6 6v-8.08z" clip-rule="evenodd" opacity=".2"/><path fill="#2980B9" fill-rule="evenodd" d="M80 100h10V25H80v75z" clip-rule="evenodd"/><path fill="#3498DB" fill-rule="evenodd" d="M80 25.007h10V0H80v25.007z" clip-rule="evenodd"/><path fill-rule="evenodd" d="M82 100h2V0h-2v100zM86 0v100h2V0h-2z" clip-rule="evenodd" opacity=".1"/></svg>
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
