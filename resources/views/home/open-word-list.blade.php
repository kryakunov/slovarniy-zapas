@extends('layouts.home')

@section('content')

    <!-- Main Content -->
    <main class="flex-1 p-6">
        <h1 class="mb-10 text-2xl">{{ $wordList['title'] }}</h1>
        <div class="">


            @forelse($words as $word)
                <div>
                {{ $word['word'] }}
                </div>
            @empty
                Не найдено
            @endforelse


        </div>
    </main>

@endsection
