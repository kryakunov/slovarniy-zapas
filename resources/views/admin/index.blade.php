@extends('layouts.admin')

@section('content')



    <!-- Main Content -->
    <main class="flex-1 p-6">
       <p>Пользователей зарегистрировано: {{ $users }}</p>
        <p>Всего словарей: {{ $wordLists }}</p>
        <p>Всего слов: {{ $words }}</p>
    </main>

@endsection
