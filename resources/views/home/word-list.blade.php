@extends('layouts.home')

@section('content')


    <!-- Main Content -->
    <main class="flex-1 p-6">
        <h1 class="mb-10 text-2xl">Мои слова</h1>
        <div class="grid grid-cols-4 gap-5">
            @forelse($wordLists as $list)
                <div class="bg-white shadow-md  border border-gray-100 p-5 rounded-2xl w-70">
                    <h2 class="text-lg font-semibold mb-5">{{ $list['title'] }}</h2>
                    <img class="mb-5 rounded-2xl" src="{{ $list['image'] }}" alt="{{ $list['title'] }}">
                    <div class="h-30">{{ $list['description'] }}</div>
                    <div class="flex justify-center">
                        <a href="{{ route('open-word-list', $list['id']) }}" class="w-100 text-center bg-sky-500 hover:bg-sky-600 text-white font-bold py-2 px-4 rounded cursor-pointer">
                            Открыть
                        </a>
                    </div>
                </div>
            @empty
                Не найдено
            @endforelse
        </div>
    </main>

@endsection
