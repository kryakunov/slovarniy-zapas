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
    @vite([ 'resources/js/app.js', 'resources/css/app.css'])
</head>
<body class="bg-[#339dc8]">
<div id="app">
    <nav class="bg-white shadow">
        <div class="container mx-auto px-4 py-2 flex justify-between items-center">
            <a class="text-lg font-semibold text-gray-800" href="{{ url('/') }}">
                Словарный запас
            </a>
            <button class="md:hidden flex items-center px-3 py-2 border rounded text-gray-500 border-gray-600 hover:text-gray-700 hover:border-gray-700" type="button" aria-label="{{ __('Toggle navigation') }}">
                <svg class="fill-current h-3 w-3" viewBox="0 0 20 20"><title>Menu</title><path d="M0 3h20v2H0V3zm0 6h20v2H0v-2zm0 6h20v2H0v-2z"/></svg>
            </button>

            <div class="hidden md:flex md:items-center md:space-x-4">
                <!-- Left Side Of Navbar -->
                <ul class="flex space-x-4">
                    <!-- Add any left side links here -->
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="flex space-x-4">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li>
                                <a class="text-gray-700 hover:text-gray-900" href="{{ route('login') }}">Войти</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li>
                                <a class="text-gray-700 hover:text-gray-900" href="{{ route('register') }}">Зарегистрироваться</a>
                            </li>
                        @endif
                    @else
                        <li class="relative">
                            <a class="text-gray-700 hover:text-gray-900 dropdown-toggle" href="#" role="button" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-20 hidden dropdown-menu">
                                <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
</div>

<script>
    // JavaScript for dropdown functionality
    document.addEventListener('DOMContentLoaded', function () {
        const dropdownToggle = document.querySelector('.dropdown-toggle');
        const dropdownMenu = document.querySelector('.dropdown-menu');

        if (dropdownToggle && dropdownMenu) {
            dropdownToggle.addEventListener('click', function () {
                dropdownMenu.classList.toggle('hidden');
            });
        }
    });
</script>
</body>
</html>
