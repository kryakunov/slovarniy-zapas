@extends('layouts.admin')

@section('content')

    <!-- Main Content -->
    <main class="flex-1 p-6">
        <h1 class="mb-10 text-2xl w-50">Добавить словарь</h1>

        <div class="m-3 mb-5 w-100">
            <a href="{{ route('admin.add-words') }}" class="items-center bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded cursor-pointer">Назад</a>
        </div>

        <form action="{{ route('admin.add-list') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="m-3 w-100">
                Название
                <input type="text" name="title"  class="bg-white w-100 p-4 border border-gray-100 rounded">
            </div>
            <div class="m-3 w-100">
                Описание
                <textarea name="description" rows=5 class="bg-white w-100 p-4 border border-gray-100 rounded"></textarea>
            </div>
            <div class="m-3 w-100">
                <input type="submit" value="Сохранить" class="items-center bg-sky-500 hover:bg-sky-600 text-white font-bold py-2 px-4 rounded cursor-pointer">
            </div>
        </form>



    </main>

@endsection
