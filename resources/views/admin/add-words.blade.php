@extends('layouts.admin')

@section('content')

    <!-- Main Content -->
    <main class="flex-1 p-6">
        <h1 class="mb-10 text-2xl">Словари</h1>

        <div class="m-3 mb-5 w-100">
            <a href="{{ route('admin.add-list') }}" class="items-center bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded cursor-pointer">Добавить словарь</a>
        </div>

        <div class="grid grid-cols-4 gap-5">

            @include('admin._word-lists')

        </div>
    </main>

@endsection
