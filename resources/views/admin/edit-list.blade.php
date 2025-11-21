@extends('layouts.admin')

@section('content')

    <!-- Main Content -->
    <main class="flex-1 p-6">
        <h1 class="mb-10 text-2xl w-50">Редактировать словарь</h1>
<script>
    function goBack() {
        window.history.back();
    }
</script>
        <div class="m-3 mb-5 w-100">
            <a onclick="goBack()" class="items-center bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-4 rounded cursor-pointer">Назад</a>
        </div>

        <form action="{{ route('admin.edit-list', $wordList['id']) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="m-3 w-100">
                <input type="text" name="title" value="{{ $wordList['title'] }}" class="bg-white w-100 p-4 border border-gray-100 rounded">
            </div>
            <div class="m-3 w-100">
                <textarea name="description" rows=5 class="bg-white w-100 p-4 border border-gray-100 rounded">{{ $wordList['description'] }}</textarea>
            </div>
            <div class="m-3 w-100">
                <input type="checkbox" {{ $wordList['is_active'] ? 'checked' : '' }} name="is_active" value="1" id="is_active"> <label for="is_active">Активно?</label>
            </div>
            <div class="m-3 w-100">
                <input type="submit" value="Сохранить" class="items-center bg-sky-500 hover:bg-sky-600 text-white font-bold py-2 px-4 rounded cursor-pointer">
            </div>
        </form>



    </main>

@endsection
