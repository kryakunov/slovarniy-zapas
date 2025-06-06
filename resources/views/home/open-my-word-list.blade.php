@extends('layouts.home')

@section('content')

            <div class="flex items-center mb-5">
                <div class="cursor-pointer mr-5">
                    <a href="/home">
                        <svg xmlns="http://www.w3.org/2000/svg" width="46" height="46" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5"/>
                        </svg>
                    </a>
                </div>
                <div>
                    <img class="mt-3 rounded-sm w-25" src="{{ $wordList['image'] }}" alt="{{ $wordList['title'] }}">
                </div>
                <div class="ml-10">
                    <h1 class="mb-2 font-semibold text-xl">{{ $wordList['title'] }} ({{ $wordList['count'] }})</h1>
                    <div class="text-gray-600">{{ $wordList['description'] }}</div>
                </div>
            </div>

            <div class="mb-4 p-2 flex items-center font-semibold text-sky-800">
                <input type="checkbox" onchange="toggleCheckbox(this)"  style="width: 18px; height: 18px; cursor: pointer;" >
                <span class="ml-4 py-2">Выбрано слов: </span> &nbsp; <span id="count" class="font-semibold">0</span>
                <meta name="csrf-token" content="{{ csrf_token() }}">


                <div class="ml-6" id="options" style="display: none">
                    <select id="mySelect" class="cursor-pointer bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option>С отмеченными:</option>
                        <option value="new">Пометить как новое</option>
                        <option value="repeat">Пометить как изучается</option>
                        <option value="done">Пометить как изученное</option>
                        <option value="delete">Удалить из словаря</option>
                    </select>
                </div>

                <script>
                    let action = '';

                    document.getElementById('mySelect').addEventListener('change', function() {
                        const selectedValue = this.value;
                        action = selectedValue;
                        addWords();
                        // Выполните нужное действие в зависимости от выбранного значения

                    });
                </script>

            </div>



            @forelse($words as $word)
                <div class="border-b-1 border-gray-200 p-2 flex items-center  justify-between">
                    <div class="flex items-center w-4/5">
                    <div class="mr-4">
                        <input type="checkbox" id="checkbox{{ $word['id'] }}" onchange="updateCount()" class="custom-checkbox" style="width: 18px; height: 18px; cursor: pointer;" name="word" value="{{ $word['id'] }}">
                    </div>
                    <label for="checkbox{{ $word['id'] }}" class="flex items-center cursor-pointer">
                    <div class="cursor-pointer hover:bg-sky-100 p-1 rounded-sm">
                        <span class="font-semibold text-sky-800">{{ $word['word']['word'] }}</span> —
                        <span>{{ $word['word']['description'] }}</span>
                    </div>
                    </label>
                    </div>
                    <div>
                        @if ($word['status'] == 0) <span class="bg-orange-200 p-1 pl-2 pr-2 rounded">Новое слово</span>
                        @elseif ($word['status'] == 1) <span class="bg-sky-200 p-1 pl-2 pr-2  rounded">На изучении</span>
                        @elseif ($word['status'] == 2) <span class="bg-green-200 p-1 pl-2 pr-2  rounded">Изучено</span>
                        @endif
                    </div>
                </div>
            @empty
                Не найдено
            @endforelse

        </div>


@endsection

<script>
    function updateCount() {

        const options = document.getElementById('options');

        // Получаем все чекбоксы
        const checkboxes = document.querySelectorAll('.custom-checkbox');
        let count = 0;

        // Считаем количество отмеченных чекбоксов
        checkboxes.forEach(checkbox => {
            if (checkbox.checked) {
                count++;
            }
        });

        if (count > 0){
            options.style.display = 'block';
        } else {
            options.style.display = 'none';
        }

        // Обновляем отображаемое количество
        document.getElementById('count').textContent = count;
    }

    function toggleCheckbox(checkbox) {
        // Получаем все чекбоксы
        const checkboxes = document.querySelectorAll('.custom-checkbox');

        // Если текущий чекбокс отмечен, снимаем отметку со всех
        if (checkbox.checked) {
            checkboxes.forEach(cb => {
                if (cb !== checkbox) {
                    cb.checked = true; // Снимаем отметку с других чекбоксов
                    updateCount()
                }
            });
        } else {
            checkboxes.forEach(cb => {
                if (cb !== checkbox) {
                    cb.checked = false; // Снимаем отметку с других чекбоксов
                    updateCount()
                }
            });
        }
    }


    function addWords()
    {
        const checkboxes = document.querySelectorAll('.custom-checkbox');
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        let words = [];
        checkboxes.forEach(cb => {
            if (cb.checked) {
                words.push(cb.value)
            }
        });

        const data = {
            words: words,
            action: action
        };

        fetch('/home/addWords', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
            body: JSON.stringify(data)
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Сеть не в порядке');
                }
                location.reload();
            })
            .then(data => {
                console.log('Успех:', data);
            })
            .catch((error) => {
                console.error('Ошибка:', error);
            });
    }
</script>
