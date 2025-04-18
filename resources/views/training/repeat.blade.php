@extends('layouts.training')

@section('content')

        <div id="word" class="mt-20 text-sky-600 font-semibold text-5xl">Слово</div>
        <div id="description" class="text-xl mt-10">Описание</div>
        <button onclick="doneWord()" class="mt-10 cursor-pointer bg-white hover:bg-gray-100 text-gray-800 font-semibold py-2 px-4 border border-gray-400 rounded shadow">
            Следующее слово
        </button>

@endsection


<script>
    function doneWord()
    {
        fetch('/home/done-repeat-word/' + word.id)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Сеть не ответила: ' + response.statusText);
                }
                return response.json(); // Преобразуем ответ в JSON
            })
            .then(data => {
               getWord()
            })
            .catch(error => {
                console.error('Ошибка:', error); // Обработка ошибок
            });
    }

    let word = '';

    function getWord()
    {
        fetch('/home/get-repeat-word')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Сеть не ответила: ' + response.statusText);
                }
                return response.json(); // Преобразуем ответ в JSON
            })
            .then(data => {
                let wordElement = document.getElementById('word');
                let descriptionElement = document.getElementById('description');
                word = data.word;
                wordElement.textContent = data.word.word.word;
                descriptionElement.textContent = data.word.word.description;
            })
            .catch(error => {
                console.error('Ошибка:', error); // Обработка ошибок
            });
    }

    getWord();
</script>

