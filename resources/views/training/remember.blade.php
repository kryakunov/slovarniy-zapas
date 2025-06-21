@extends('layouts.training')

@section('content')

<div id="app" class="mt-20 text-sky-600 font-semibold text-xl"></div>

<div class="flex mt-15"  id="container">

аыв
</div>

<div id="hidden-text" style="display: none" class=" mt-4 text-sm"></div>
<div id="result" class="mt-8 font-semibold text-xl"></div>


@endsection
<style>
    /* Анимация для плавного исчезновения фона */
    @keyframes fadeOut {
        0% {
            background-color: rgb(255, 228, 228); /* Красный */
        }
        100% {
            background-color: rgba(255, 0, 0, 0); /* Прозрачный */
        }
    }
    /* Анимация для плавного исчезновения фона */
    @keyframes fadeIn {
        0% {
            background-color: rgb(221, 255, 219); /* Красный */
        }
        100% {
            background-color: rgba(255, 0, 0, 0); /* Прозрачный */
        }
    }

    .fade-out {
        animation: fadeOut 1.5s forwards; /* Длительность 2 секунды */
    }
    .fade-in {
        animation: fadeIn 2s forwards; /* Длительность 2 секунды */
    }
</style>

<script>


    let word = '';
    let sentence = '';
    let wordId = '';
    let words = '';

    getWord();

    function checkWord() {
        const input = document.getElementById('word-input').value; // Получаем значение из input
        const inputField = document.getElementById('word-input');
        const wordInput = input.replace(/\s+/g, '').toLowerCase(); // Удаляем пробелы и приводим к нижнему регистру
        let sentenceElement = document.getElementById('sentence');
        let resultElement = document.getElementById('result');
        if (word == wordInput) {
            sentenceElement.textContent = sentence.replace(/\.{3,}/g, word);
            sentenceElement.style.color = 'green';
            resultElement.style.color = 'green';
            resultElement.textContent = 'Верно!';
            document.body.classList.add('fade-in');
            inputField.value = '';
            inputField.style.borderColor = 'green'

            setTimeout(() => {
                doneWord();
            }, 1000);

        } else {
            document.body.classList.add('fade-out');
            resultElement.style.color = 'red';
            resultElement.textContent = 'Неверно';
            inputField.style.borderColor = 'red'
            // Удаляем класс через 2 секунды, чтобы можно было повторно нажать на кнопку
            setTimeout(() => {
                document.body.classList.remove('fade-out');
            }, 2000);
        }
    }

    function showHidden() {
        const hiddenText = document.getElementById('hidden-text');
        hiddenText.style.display = 'block';
    }

    function doneWord()
    {
        fetch('/home/done-repeat-sentence/' + wordId)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Сеть не ответила: ' + response.statusText);
                }
                return response.json(); // Преобразуем ответ в JSON
            })
            .then(data => {
                setTimeout(getWord, 3000);
            })
            .catch(error => {
                console.error('Ошибка:', error); // Обработка ошибок
            });
    }


    function getWord()
    {
        fetch('/home/get-remember')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Сеть не ответила: ' + response.statusText);
                }
                return response.json(); // Преобразуем ответ в JSON
            })
            .then(data => {
                let sentenceElement = document.getElementById('sentence');
                let descriptionElement = document.getElementById('hidden-text');
                let resultElement = document.getElementById('result');
                const inputField = document.getElementById('word-input');
                word = data.word;
                wordId = data.word_id
                words = data.words
                description = data.description
                 sentenceElement.textContent = description;
                // sentenceElement.style.color = '#0E7490';
                // sentenceElement.classList.add = 'mt-20 text-sky-600 font-semibold text-xl';
                // descriptionElement.textContent = description;
                // resultElement.textContent = '';
                // inputField.style.borderColor = '#0E7490'


                const container = document.getElementById('container');

                words.forEach(function(word) {
                    const button = document.createElement('button');
                    button.className = 'mr-2 cursor-pointer bg-cyan-800 hover:bg-cyan-900 py-2 px-4 text-white text-lg rounded'; // Добавляем класс
                    button.textContent = word.word; // Устанавливаем текст кнопки

                    // Добавляем обработчик события
                    button.onclick = test;

                    // Добавляем кнопку в контейнер
                    container.appendChild(button);
                });

            })
            .catch(error => {
                console.error('Ошибка:', error); // Обработка ошибок
            });
    }


    function test()
    {
        alert('df')
    }
</script>

