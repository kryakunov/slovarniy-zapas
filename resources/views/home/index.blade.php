@extends('layouts.home')

@section('content')

    <!-- Main Content -->
    <main class="flex-1 p-6">
        <div class="overlay" id="overlay"></div>
        <div class="popup text-center" id="popup">
            <div class="text-2xl mt-10">Удалить набор слов</div>
            <div class="m-5">Если вы удалите набор слов, все слова из него также удалятся. Вы уверены? </div>
            <div class="mt-10">
                <button onclick="confirmRemove()" class="cursor-pointer w-full bg-red-400 hover:bg-red-500 text-white px-4 py-2 rounded">Да, удаляем</button>
                <button onclick="closePopup()" class="cursor-pointer w-full bg-sky-400 hover:bg-sky-500 text-white px-4 mt-3 py-2 rounded">Закрыть</button>
            </div>
        </div>
        <div class="bg-white shadow-sm rounded-lg p-4">
            <div class="w-full">
                <h1 class="mb-5 text-xl font-semibold">Мой прогресс</h1>
                <div class="mb-4">
                </div>
            </div>
            <div class="flex  justify-between">

                <div onclick="window.location.href = '{{ route('training') }}' " class=" bg-indigo-100 hover:bg-indigo-200 cursor-pointer shadow-sm rounded-lg p-4 flex items-center" style="width: 32%">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 64 64"><path fill="#ffce31" d="m44.5 2l-9 2.5L29.4 2l-9.9 34.4h10.4L20.8 62l22.4-34.4H29.7z"/></svg>
                    </div>
                    <div class="ml-5">
                        <div class="font-semibold">Нужно повторить</div>
                        <div class="mt-4 text-sm">Вам cегодня нужно повторить {{ $repeatWords }} слов </div>
                    </div>
                </div>

                <div class=" bg-emerald-100 shadow-sm rounded-lg p-4 flex items-center" style="width: 32%">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 64 64"><path fill="#ff9d33" d="M57 26.2s-3 2.8-8.1 6.1C47.5 24.2 43.6 14.2 36 2c0 0-2.5 13.1-10.8 25.4c-3.6-5.6-5.2-10-5.2-10C-6 43.5 15.6 62 29.2 62c17.4 0 32.7-8.4 27.8-35.8"/><path fill="#ffce31" d="M46.7 49.4c1.5-3.3 2.6-7.6 2.8-13c0 0-2.1 1.8-5.7 4.1c-1-5.4-3.7-12-9-20.2c0 0-1.7 8.7-7.5 17c-2.5-3.7-3.6-6.7-3.6-6.7c-4.3 6.8-6 12.2-6.1 16.5c-2.4-.9-3.9-1.6-3.9-1.6c4.1 12.2 12.6 14.9 16.4 14.9c6.8 0 13.7-2 20.5-11.7c0-.1-1.5.3-3.9.7"/><path fill="#ffdf85" d="M21.9 43.9s2.8 3.8 4.9 2.9c0 0 4-6.3 9.8-9.8c0 0-1.2 9.6.2 11.3c1.8 2.3 6.7-2.5 6.7-2.5c0 5.7-6.2 12.8-11.8 12.8c-5.4 0-13.2-6.2-9.8-14.7"/><path fill="#ff9d33" d="M49.8 18.1c2.1-3 3.5-6.2 3.5-6.2c3.5 5.8 1.4 9.3-.1 10.4c-2.1 1.6-5.8-.7-3.4-4.2m-38.2-1c-2.1-3.5-2.3-7.9-2.3-7.9c-5 7.5-3.1 11.7-1.4 12.9c2.2 1.7 6-.9 3.7-5m11.6-7.8c.3-2.4-.7-4.8-.7-4.8c4.7 3.1 4.7 5.7 4.1 6.8c-.9 1.3-3.7.7-3.4-2"/></svg> </div>
                    <div class="ml-5">
                        <div class="font-semibold">Повторено</div>
                        <div class="mt-4 text-sm">Вы сегодня повторили {{ $repeatedWords }} слов</div>
                    </div>
                </div>

                <div class=" bg-blue-100 shadow-sm rounded-lg p-4 flex items-center" style="width: 32%">
                    <div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 64 64"><ellipse cx="26.6" cy="32" fill="#fff" rx="21.6" ry="26.4"/><ellipse cx="29" cy="32" fill="#ed4c5c" rx="2.7" ry="3.9"/><path fill="#428bc1" d="m41.4 36.8l.3-1.5c0-.2.1-.4.1-.7c0-.3.1-.6.1-1c0-.6.1-1.1.1-1.7s0-1.1-.1-1.7c0-.3-.1-.7-.1-1c0-.2 0-.4-.1-.6l-.3-1.5c-1.8-7-7.2-12.2-13.7-12.2c-7.9 0-14.3 7.6-14.3 17s6.4 17 14.3 17c6.5.1 11.9-5 13.7-12.1m-12.8 5c-4.4 0-8-4.4-8-9.8s3.6-9.8 8-9.8c1 0 1.9.2 2.7.6c2.9 1.6 4.9 5.1 4.9 9.2s-2 7.6-5 9.2c-.8.4-1.7.6-2.6.6"/><path fill="#3e4347" d="M51.6 32v-1.5C50.9 14.6 40.1 2 26.8 2C13.1 2 2 15.4 2 32s11.1 30 24.8 30c13.3 0 24.1-12.6 24.8-28.5V32m-24 22.7C17.4 54.7 9 44.5 9 32C9 19.4 17.4 9.3 27.6 9.3c4.1 0 7.9 1.7 11 4.4C43.1 17.9 46 24.6 46 32s-2.9 14-7.4 18.3c-3 2.7-6.9 4.4-11 4.4"/><path fill="#fff" d="M33.1 29.3h18.1v5.3H33.1z"/><path fill="#f2b200" d="M45.5 36L62 44.6l-2.3-11.7H43.1z"/><path fill="#c94747" d="M51.6 39.1L49.5 38l-3.1-5.5h2.1zm6.3 3.3l-2.1-1.1l-3.1-8.8h2.1z"/><path fill="#f2b200" d="M45.5 27.9L62 19.2L59.7 31H43.1z"/><path fill="#c94747" d="m51.6 24.7l-2.1 1.1l-3.1 5.5h2.1zm6.3-3.3l-2.1 1.1l-3.1 8.8h2.1z"/><path fill="#754e27" d="M60.2 30.6H29.3c-.9 0-.9 2.7 0 2.7h30.9c.9-.1.9-2.7 0-2.7"/><path fill="#b28769" d="M59.6 31.2H30c-.9 0-.9 1.4 0 1.4h29.6c.8 0 .8-1.4 0-1.4"/></svg>
                    </div>
                    <div class="ml-5">
                        <div class="font-semibold">Всего изучено</div>
                        <div class="mb-1 text-sm mt-2 font-medium"> {{ $doneWords }} из {{ $totalWords }} слов</div>
                        <div class=" h-4 bg-gray-200 rounded-full dark:bg-gray-700">
                            @if($totalWords > 0)
                                <div class="h-4 bg-blue-600 rounded-full dark:bg-blue-500" style="width: {{ $doneWords / $totalWords * 100 }}%"></div>
                            @else
                                <div class="h-4 bg-blue-600 rounded-full dark:bg-blue-500" style="width: 0%"></div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-sm rounded-lg p-4 mt-5">
            <div class="flex items-center justify-start mt-2  mb-5">
                <div><h1 class="text-xl font-semibold">Мои наборы слов</h1></div>

                <div class="">
                    <button class="ml-10 cursor-pointer bg-blue-400 hover:bg-blue-500 text-white font-bold py-1 px-4 rounded">
                        <a href="{{ route('lists') }}" class="flex items-center"> <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-folder-plus" viewBox="0 0 16 16">
                                <path d="m.5 3 .04.87a2 2 0 0 0-.342 1.311l.637 7A2 2 0 0 0 2.826 14H9v-1H2.826a1 1 0 0 1-.995-.91l-.637-7A1 1 0 0 1 2.19 4h11.62a1 1 0 0 1 .996 1.09L14.54 8h1.005l.256-2.819A2 2 0 0 0 13.81 3H9.828a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 6.172 1H2.5a2 2 0 0 0-2 2m5.672-1a1 1 0 0 1 .707.293L7.586 3H2.19q-.362.002-.683.12L1.5 2.98a1 1 0 0 1 1-.98z"/>
                                <path d="M13.5 9a.5.5 0 0 1 .5.5V11h1.5a.5.5 0 1 1 0 1H14v1.5a.5.5 0 1 1-1 0V12h-1.5a.5.5 0 0 1 0-1H13V9.5a.5.5 0 0 1 .5-.5"/>
                            </svg>
                            <span class="ml-2">Добавить набор слов</span></a>
                    </button>
                </div>
            </div>
            <div class="col-span-3">
                <div class="grid grid-cols-5 gap-6">
                    @forelse($wordLists as $list)
                            <div class="bg-white shadow-md border border-gray-100 rounded-xl flex flex-col hover:shadow-xl">
                                <a onclick="openPopup({{ $list['id'] }})" class="cursor-pointer">
                                    <div id="list{{ $list['id'] }}"  class="absolute bg-red-400 shadow-md  rounded-tl-xl p-2 text-white z-1 hover:bg-red-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                            <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5"/>
                                        </svg>
                                    </div>
                                </a>
                                <a href="{{ route('open-my-word-list', $list['slug']) }}">
                                <img class="mb-5 rounded-t-xl" src="{{ $list['image'] }}" alt="{{ $list['title'] }}">
                                <h2 class="text h-20 font-semibold pl-4 pr-4">{{ $list['title'] }}</h2>
                                <div class="flex-grow pl-4 mt-7 text-gray-400 mb-5 pr-4">

                                    <div class="mb-1 text-base font-medium text-sm">Изучено {{ $list['done'] }} из {{ $list['count'] }}</div>
                                    <div class="w-full bg-gray-200 rounded-full h-1.5 mb-4 dark:bg-gray-700">
                                        <div class="bg-blue-600 h-1.5 rounded-full dark:bg-blue-500" style="width: {{ $list['done'] / $list['count'] * 100 }}%"></div>
                                    </div>

                                    <div class="font-semibold">{{ $list->type?->title }}</div>
                                    <div>{{ $list['count'] }} слов</div>
                                </div>
                                </a>
                            </div>
                    @empty
                    </div>
                    <div class="mt-5">
                        У вас ещё нет добавленных словарей
                        @endforelse
                </div>
            </div>
        </div>
    </main>

    <script>
        const openPopupButton = document.getElementById('openPopup');
        const closePopupButton = document.getElementById('closePopup');
        const popup = document.getElementById('popup');
        const overlay = document.getElementById('overlay');
        let deleteListId = '';

        openPopupButton.addEventListener('click', () => {
            popup.style.display = 'block';
            overlay.style.display = 'block';
        });

        closePopupButton.addEventListener('click', () => {
            popup.style.display = 'none';
            overlay.style.display = 'none';
        });

        overlay.addEventListener('click', () => {
            popup.style.display = 'none';
            overlay.style.display = 'none';
        });

        function closePopup()
        {
            popup.style.display = 'none';
            overlay.style.display = 'none';
        }

        function confirmRemove(id) {
            removeList(id);
            closePopup();
        }

        function openPopup(id)
        {
            popup.style.display = 'block';
            overlay.style.display = 'block';
            deleteListId = id;
        }

        function removeList()
        {
            $.ajax({
                url: '/home/remove-word-list/' + deleteListId,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    if(data.status == true) {
                        // var element = document.getElementById('list' + id);
                        // element.textContent = 'удалено'
                        // element.className = 'absolute pl-2 bg-green-600 shadow-md rounded-tl-xl p-1 text-white z-1'

                        location.reload();
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
@endsection


