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
    @vite(['resources/sass/app.scss', 'resources/js/app.js', 'resources/css/app.css'])

    <style>

        .popup {
            display: none; /* Скрываем попап по умолчанию */
            position: fixed;
            left: 50%;
            top: 40%;
            transform: translate(-50%, -50%);
            width: 30%; /* Ширина попапа 50% */
            height: 50%; /* Высота попапа 50% */
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3); /* Тень */
            padding: 20px;
            z-index: 1000;
            overflow: auto; /* Прокрутка, если контент превышает высоту */
        }
        .overlay {
            display: none; /* Скрываем оверлей по умолчанию */
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.6);
            z-index: 999;
        }
        .close-btn {
            cursor: pointer;
            color: red;
            display: block;
            margin-top: 20px;
        }
    </style>
</head>
<body class="bg-gray-50">

<div class="overlay" id="overlay"></div>
<div class="popup text-center" id="popup">
    <div class="text-2xl mt-10">Тренировка закончена</div>
    <div class="mt-10">Вы молодец!</div>
    <div class="mt-15">
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
        window.history.back();
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
