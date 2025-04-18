@extends('layouts.home')

@section('content')

    <!-- Main Content -->
    <main class="flex-1 p-6">
        <h1 class="mb-5 text-2xl">Тренировки</h1>
        <div class="grid grid-cols-3 gap-5">

            <div class="bg-sky-700 text-white shadow-md rounded-lg p-4 col-span-1 hover:bg-sky-600 cursor-pointer">
                <a href="{{ route('training-repeat') }}">
                    <h2 class="text-lg mb-5 font-semibold">Повторение</h2>
                    <div class="mb-1">Слов для повторения: 14</div>
                </a>
            </div>

            <div class="bg-green-700 text-white shadow-md rounded-lg p-4 col-span-1 hover:bg-green-600 cursor-pointer  bg-[url('https://avatars.mds.yandex.net/i?id=ceab486dfcacd1e73a2e02512f6e3b5d_l-9837140-images-thumbs&n=13')]">
                <a href="{{ route('training-sentence') }}">
                    <h2 class="text-lg mb-5 font-semibold">Слова в предложении</h2>
                    <div class="mb-1 ">Слов для повторения: 14</div>
                </a>
            </div>
            <div class="bg-green-700 text-white shadow-md rounded-lg p-4 col-span-1 hover:bg-green-600 cursor-pointer">
                <a href="{{ route('training-remember') }}">
                    <h2 class="text-lg mb-5 font-semibold">Повторение</h2>
                    <div class="mb-1 ">Слов для повторения: 14</div>
                </a>
            </div>
    </main>

@endsection

