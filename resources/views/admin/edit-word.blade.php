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

        <form action="{{ route('admin.edit-word', $word['id']) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="border-b border-b-gray-300">
                <div class="m-3 w-100">
                    <input type="text" name="word" value="{{ $word['word'] }}" class="bg-white w-100 p-4 border border-gray-100 rounded">
                </div>
                <div class="m-3 w-200">
                    <textarea name="description" rows=2 class="bg-white w-200 p-4 border border-gray-100 rounded">{{ $word['description'] }}</textarea>
                </div>
                <div class="m-3">
                    <input type="checkbox" {{ $word['hide_image'] ? 'checked' : '' }} name="hide_image" value="1" id="hide_image"> <label for="hide_image">Скрыть изображение</label>
                </div>

                <div class="m-3">
                    <input type="file"  name="image" accept="image/png, image/jpeg"/>
                </div>
                @if(isset($word['image']))
                <div>
                    <img src="{{ asset('storage/images/' . $word['image']) }}" alt="{{ $word['image'] }}">
                </div>
                @endif
            </div>


            <div class="m-3 w-100">
                <input type="submit" value="Сохранить" class="items-center bg-sky-500 hover:bg-sky-600 text-white font-bold py-2 px-4 rounded cursor-pointer">
            </div>
        </form>



    </main>

@endsection
