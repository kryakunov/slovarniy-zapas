@extends('layouts.home')

@section('content')

    <!-- Main Content -->
    <main class="flex-1 p-6">
        <h1 class="mb-5 text-2xl">Мой прогресс</h1>
        <div class="grid grid-cols-3 gap-5">

            <div class="bg-white shadow-md rounded-lg p-4 col-span-1 bg-[url('https://avatars.mds.yandex.net/i?id=1e99c7414ed4b56ef5d65e243706ebf2b0e6ed05-5877309-images-thumbs&n=13')] ">
                <h2 class="text-lg mb-5">Мои слова</h2>
                <div class="mb-1 font-medium">Новых слов: 14</div>
                <div class="mb-1 font-medium">Словарей: 2</div>
                <div class="mb-1 font-medium">Вы сегодня повторили {{ $repeatedWords }} слов</div>
            </div>

            <div class="bg-[url('https://avatars.mds.yandex.net/i?id=1e99c7414ed4b56ef5d65e243706ebf2b0e6ed05-5877309-images-thumbs&n=13')] shadow-md rounded-lg p-4 col-span-2 ">
                <h2 class="text-lg mb-5">Мой прогресс</h2>

                <div class="mb-1 text-sm font-medium">На изучении {{ $repeatWords }} из {{ $allWords }} слов</div>
                <div class="w-full h-4 mb-4 bg-gray-200 rounded-full dark:bg-gray-700">
                    <div class="h-4 bg-blue-600 rounded-full dark:bg-blue-500" style="width: {{ $percent }}%"></div>
                </div>

                <div class="mb-1 text-sm font-medium">Изучено {{ $doneWords }} из {{ $allWords }} слов</div>
                <div class="w-full h-4 mb-4 bg-gray-200 rounded-full dark:bg-gray-700">
                    <div class="h-4 bg-blue-600 rounded-full dark:bg-blue-500" style="width: {{ $percent }}%"></div>
                </div>
            </div>

            <div class="bg-white flex items-center text-white shadow-md rounded-lg p-4 col-span-3 bg-[url('https://avatars.mds.yandex.net/i?id=ceab486dfcacd1e73a2e02512f6e3b5d_l-9837140-images-thumbs&n=13')] ">
                <div>
                    <h2 class="text-lg mb-5">Слова для повторения</h2>
                    <div class="mb-1 font-medium">Вам сегодня нужно повторить {{ $repeatWords }} слов</div>
                </div>
                <div>
                    <div class="">
                        <button class="ml-10 cursor-pointer bg-orange-400 hover:bg-orange-500 text-white font-bold py-2 px-4 rounded">
                            <a href="{{ route('lists') }}" class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-up-right-square-fill" viewBox="0 0 16 16">
                                    <path d="M14 0a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2zM5.904 10.803 10 6.707v2.768a.5.5 0 0 0 1 0V5.5a.5.5 0 0 0-.5-.5H6.525a.5.5 0 1 0 0 1h2.768l-4.096 4.096a.5.5 0 0 0 .707.707"/>
                                </svg>
                                <span class="ml-2">Начать тренировку</span></a>
                        </button>
                    </div>
                </div>
            </div>

        </div>
        <div>


            <div class="flex items-center justify-start mt-20 mb-5">
                <div><h1 class="text-2xl ">На изучении</h1></div>
                <div class="">
                    <button class="ml-10 cursor-pointer bg-blue-400 hover:bg-blue-500 text-white font-bold py-2 px-4 rounded">
                        <a href="{{ route('lists') }}" class="flex items-center"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-folder-plus" viewBox="0 0 16 16">
                                <path d="m.5 3 .04.87a2 2 0 0 0-.342 1.311l.637 7A2 2 0 0 0 2.826 14H9v-1H2.826a1 1 0 0 1-.995-.91l-.637-7A1 1 0 0 1 2.19 4h11.62a1 1 0 0 1 .996 1.09L14.54 8h1.005l.256-2.819A2 2 0 0 0 13.81 3H9.828a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 6.172 1H2.5a2 2 0 0 0-2 2m5.672-1a1 1 0 0 1 .707.293L7.586 3H2.19q-.362.002-.683.12L1.5 2.98a1 1 0 0 1 1-.98z"/>
                                <path d="M13.5 9a.5.5 0 0 1 .5.5V11h1.5a.5.5 0 1 1 0 1H14v1.5a.5.5 0 1 1-1 0V12h-1.5a.5.5 0 0 1 0-1H13V9.5a.5.5 0 0 1 .5-.5"/>
                            </svg>
                            <span class="ml-2">Добавить словарь</span></a>
                    </button>
                </div>
            </div>
            <div class="col-span-3">
                <div class="grid grid-cols-6 gap-6">
                    @forelse($wordLists as $list)
                            <div class="bg-white shadow-md border border-gray-100 rounded-xl flex flex-col hover:shadow-xl">
                                <a onclick="confirmRemove({{ $list['id'] }})" class="cursor-pointer">
                                    <div id="list{{ $list['id'] }}"  class="absolute bg-red-400 shadow-md  rounded-tl-xl p-2 text-white z-1 hover:bg-red-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
                                        </svg>
                                    </div>
                                </a>
                                <a href="{{ route('open-my-word-list', $list['slug']) }}">
                                <img class="mb-5 rounded-t-xl" src="{{ $list['image'] }}" alt="{{ $list['title'] }}">
                                <h2 class="text-sm h-20 font-semibold pl-4 pr-4">{{ $list['title'] }}</h2>
                                <div class="flex-grow pl-4 mt-7 text-gray-400 mb-5">
                                    <div class="font-semibold">{{ $list->type?->title }}</div>
                                    <div>{{ $list['count'] }} слов</div>
                                </div>
                                </a>
                            </div>
                    @empty
                    </div>
                    <div class="grid grid-cols-1 gap-6">
                        У вас еще нет добавленных словарей
                    @endforelse
                </div>
            </div>

        </div>
    </main>

@endsection



<script>
    function confirmRemove(id) {
        if (confirm("Вы уверены, что хотите удалить этот набор из изучения?")) {
            removeList(id);
        }
    }

    function removeList(id)
    {
        $.ajax({
            url: '/home/remove-word-list/' + id,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                if(data.status == true) {
                    var element = document.getElementById('list' + id);
                    element.textContent = 'удалено'
                    element.className = 'absolute pl-2 bg-green-600 shadow-md rounded-tl-xl p-1 text-white z-1'
                } else {
                    console.log('Ошибка удаления списка')
                }
            },
            error: function(xhr, status, error) {
                console.error('Ошибка при получении данных:', error);
            }
        });
    }
</script>
