@extends('layouts.admin')

@section('content')

    <!-- Main Content -->
    <main class="flex-1 p-6">
        <h1 class="mb-10 text-2xl w-50">Редактировать словарь</h1>

        <div class="m-3 mb-5 w-100">
            <a href="{{ route('admin.add-words') }}" class="items-center bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded cursor-pointer">Назад</a>
        </div>

        <div class="m-3 mb-5 w-100">
            <a href="{{ route('admin.add-word', $wordList['id']) }}" class="items-center bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded cursor-pointer">Добавить слово</a>
        </div>

        <table class="table-auto w-300">
            <thead>
            <tr>
                <th class="text-left p-2 bg-gray-100">Слово</th>
                <th class="text-left p-2 bg-gray-100">Ударение</th>
                <th class="text-left p-2 bg-gray-100">Изображение</th>
                <th class="text-left p-2 bg-gray-100">Скрыто</th>
                <th class="text-left p-2 bg-gray-100">Описание</th>
                <th class="text-left p-2 bg-gray-100">Лайков</th>
                <th class="text-left p-2 bg-gray-100">Действия</th>
            </tr>
            </thead>
            <tbody>
            @foreach($words as $word)
            <tr>
                <td class="p-2 text-sm font-semibold text-sky-800">{{ $word['word'] }}</td>
                <td class="p-2 text-sm">{{ $word['stress'] ? '' : 'no' }}</td>
                <td class="p-2 text-sm">{{ $word['image'] ? '' : 'no' }}</td>
                <td class="p-2 text-sm">{{ $word['hide_image'] ? 'yes' : '' }}</td>
                <td class="p-2 text-sm">{{ $word['description'] }}</td>
                <td class="p-2 text-sm">{{ $word['likes'] }}</td>
                <td class="p-2 text-sm">
                    <a href="{{ route('admin.edit-word', $word['id']) }}">Редактировать</a>
                    <a href="{{ route('admin.delete-word', $word['id']) }}" onclick="return confirm('Вы уверены?')">Удалить</a>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>

    </main>

@endsection
