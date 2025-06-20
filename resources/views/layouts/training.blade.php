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
    @vite([ 'resources/js/app.js', 'resources/css/app.css'])

</head>
<body class="bg-gray-50">

<div class="overlay" id="overlay"></div>
<div class="popup text-center" id="popup">
    <div class="text-2xl mt-10">Тренировка закончена</div>
    <div class="mt-5 flex text-center justify-center">
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 64 64"><path fill="#ffdd7d" d="M59.7 13.8c1.7-5.2 1.2-14.9-16.6-3.2C25 22.5 6.2 50.3 7.6 55.4c1.1 4 17.3-5 26-17.2c.7-1 8.7 8.8 7.6 9.8C33.4 55.8 8.3 65.7 3 60.6c-6.1-5.9 16.7-39.8 40.1-53.3c6.4-3.7 25.5-12.5 16.6 6.5"/><path fill="#ffd05a" d="M60.6 49.5L46.7 48l-9.1 10.6l-2.9-13.7l-12.9-5.4l12.2-7l1.2-13.9L45.5 28l13.6-3.2l-5.7 12.7l7.2 12"/></svg>
        </div>
        <div class="ml-3">Вы молодец!</div>
    </div>
    <div class="m-5">Возвращайтесь к тренировке позже, чтобы слова отложились в долгосрочной памяти</div>
    <div class="mt-10">
        <button onclick="confirmClose()" class="cursor-pointer w-full bg-red-400 hover:bg-red-500 text-white px-4 py-2 rounded">Выйти</button>
    </div>
</div>

<div class="popup text-center" id="endWords">
    <div class="text-2xl mt-10">
        Слова закончились</div>
    <div class="mt-5 flex text-center justify-center">
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 64 64"><path fill="#ffdd7d" d="M59.7 13.8c1.7-5.2 1.2-14.9-16.6-3.2C25 22.5 6.2 50.3 7.6 55.4c1.1 4 17.3-5 26-17.2c.7-1 8.7 8.8 7.6 9.8C33.4 55.8 8.3 65.7 3 60.6c-6.1-5.9 16.7-39.8 40.1-53.3c6.4-3.7 25.5-12.5 16.6 6.5"/><path fill="#ffd05a" d="M60.6 49.5L46.7 48l-9.1 10.6l-2.9-13.7l-12.9-5.4l12.2-7l1.2-13.9L45.5 28l13.6-3.2l-5.7 12.7l7.2 12"/></svg>
        </div>
        <div class="ml-3">Вы молодец, вы повторили все слова!</div>
    </div>
    <div class="m-5">Вощвращайтесь к тренировкам позже, чтобы слова отложились в долгосрочной памяти</div>
    <div class="mt-10">
        <button onclick="confirmClose()" class="cursor-pointer w-full bg-red-400 hover:bg-red-500 text-white px-4 py-2 rounded">Выйти</button>
    </div>
</div>

    <div class="flex justify-end mt-10 mr-5">
    <div class="cursor-pointer mr-5">
        <a id="openPopup">
            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
            </svg>
        </a>
    </div>
    </div>

    <div class="flex">
        <main class="flex-1 p-6 flex flex-col items-center justify-center text-center">
            @yield('content')
        </main>
    </div>

<script>
    function confirmClose() {
        window.location.href = "/home/training/";
    }

    const openPopupButton = document.getElementById('openPopup');
    const closePopupButton = document.getElementById('closePopup');
    const popup = document.getElementById('popup');
    const overlay = document.getElementById('overlay');

    openPopupButton.addEventListener('click', () => {
        popup.style.display = 'block';
        overlay.style.display = 'block';
    });

    closePopupButton.addEventListener('click', () => {
        popup.style.display = 'none';
        overlay.style.display = 'none';
    });

    overlay.addEventListener('click', () => {
        popup.style.display = 'none';
        overlay.style.display = 'none';
    });

</script>
</body>
</html>
