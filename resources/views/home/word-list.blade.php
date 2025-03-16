@extends('layouts.home')

@section('content')


    <!-- Main Content -->
    <main class="flex-1 p-6">
        <h1 class="mb-10 text-2xl">Мои слова</h1>
        <div class="grid grid-cols-4 gap-5">

            @include('word-lists')

        </div>
    </main>

@endsection
