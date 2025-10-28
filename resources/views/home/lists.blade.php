@extends('layouts.home')

@section('content')

    <!-- Main Content -->
    <main class="flex-1 p-6">
        <div class="bg-white shadow-sm rounded-lg p-4">
        <h1 class="text-2xl mb-5">Наборы слов</h1>
        <div class="grid grid-cols-6 gap-6">
            @forelse($wordLists as $list)
                <div class="bg-white shadow-md border border-gray-100 rounded-xl flex flex-col hover:shadow-xl">
                    @if(in_array($list['id'], $myWordLists))
                        <div id="list{{ $list['id'] }}" class="absolute pl-2 bg-green-600 shadow-md rounded-tl-xl p-1 text-white z-1">
                            добавлено
                        </div>
                    @else
                        <a onclick="addList( {{ $list['id'] }} )" class="cursor-pointer">
                        <div id="list{{ $list['id'] }}"  class="absolute bg-sky-600 shadow-md  rounded-tl-xl p-1 text-white z-1 hover:bg-sky-500">
                           + добавить
                        </div>
                        </a>
                    @endif

                    @php
                        if ($list['image'] == null) {
                            $list['image'] = '/no-image.png';
                            }
                    @endphp

                    <a href="{{ route('open-word-list', $list['slug']) }}">
                    <img class="mb-5 rounded-t-xl" src="{{ $list['image'] }}" alt="{{ $list['title'] }}">
                    <h2 class="text-sm h-20 font-semibold pl-4 pr-4">{{ $list['title'] }}</h2>
                    <div class="flex-grow pl-4 mt-7 text-gray-400 mb-5">
                    <div class="font-semibold">{{ $list->type?->title }}</div>
                    <div>{{ $list['count'] }} слов</div>
                    </div>
                    </a>
                </div>

            @empty
                Не найдено
            @endforelse
        </div>
        </div>
    </main>

@endsection


<script>
    function addList(id)
    {
        $.ajax({
            url: '/home/add-word-list/' + id,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                if(data.status == true) {
                    var element = document.getElementById('list' + id);
                    element.textContent = 'добавлено'
                    element.className = 'absolute pl-2 bg-green-600 shadow-md rounded-tl-xl p-1 text-white z-1';
                } else {
                    console.log('Ошибка добавления списка')
                }
            },
            error: function(xhr, status, error) {
                console.error('Ошибка при получении данных:', error);
            }
        });
    }
</script>
