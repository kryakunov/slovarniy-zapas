@extends('layouts.training')

@section('content')

        <div id="wordDescription" class="mt-20 text-sky-600 font-semibold text-xl"></div>

        <div class="mb-1 text-cyan-900  w-90 flex justify-start mt-10">
            Вставьте пропущенное слово:
        </div>
        <div class="mb-2 w-90 flex justify-center">
            <input type="text" id="word-input" class="bg-gray-50 border w-100 border-cyan-600 text-gray-900 text-2xl rounded-lg focus:ring-blue-500 focus:border-blue-500 block  p-2 dark:bg-white ">
        </div>
        <div class="flex mt-5">
            <button id="buttonDontKnowWord" onclick="dontKnow()" class="cursor-pointer bg-red-400 hover:bg-red-500 py-3 px-6 text-white text-lg rounded">
                Не помню
            </button>
            <button id="buttonCheckWord" onclick="checkWord()" class="ml-3 cursor-pointer bg-emerald-500 hover:bg-emerald-600 py-3 px-6 text-white text-lg rounded">
                Проверить
            </button>
            <button id="buttonNextWord" style="display: none" onclick="nextWord()"  class="ml-3 mr-2 cursor-pointer bg-orange-400 hover:bg-orange-500 py-3 px-6 text-white text-lg rounded">
                Следующее слово
            </button>
        </div>

        <div id="wordCheckResultSuccess" class="mt-8 font-semibold text-xl text-green-600" style="display: none">Верно!</div>
        <div id="wordCheckResultError" class="mt-8 font-semibold text-xl text-red-500" style="display: none">Неверно</div>


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
    getWord();

    setTimeout(() => {
        showNewWord();
    }, 1000);

    let word = '';
    let description = '';
    let wordId = 0;

    const wordDescription = document.getElementById('wordDescription');
    const inputField = document.getElementById('word-input');
    const wordCheckResultError = document.getElementById('wordCheckResultError');
    const wordCheckResultSuccess = document.getElementById('wordCheckResultSuccess');

    function showNewWord()
    {
        const wordCheckResultError = document.getElementById('wordCheckResultError');
        const wordCheckResultSuccess = document.getElementById('wordCheckResultSuccess');
        const wordDescription = document.getElementById('wordDescription');
        const inputField = document.getElementById('word-input');
        const buttonNextWord = document.getElementById('buttonNextWord');
        const buttonCheckWord = document.getElementById('buttonCheckWord');
        const buttonDontKnowWord = document.getElementById('buttonDontKnowWord');
        wordCheckResultError.style.display = 'none';
        wordCheckResultSuccess.style.display = 'none';
        buttonNextWord.style.display = 'none';
        buttonCheckWord.style.display = 'block';
        buttonDontKnowWord.style.display = 'block';
        inputField.value = '';
        inputField.style.color = 'black';
        wordDescription.textContent = description;
    }

    function getWord()
    {
        fetch('/home/get-description-word')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Сеть не ответила: ' + response.statusText);
                }
                return response.json(); // Преобразуем ответ в JSON
            })
            .then(data => {
                if(data.status == 'success') {
                    word = data.word;
                    description = data.description
                    wordId = data.word_id

                    buttonNextWordDisabledFalse();

                } else if(data.status == 'endWords') {
                    alert('Слова закончились!')
                }
            })
            .catch(error => {
                console.error('Ошибка:', error); // Обработка ошибок
            });
    }


    function buttonNextWordDisabledFalse()
    {
        const buttonNextWord = document.getElementById('buttonNextWord');
        buttonNextWord.disabled = false;
        buttonNextWord.classList.replace('bg-gray-500', 'bg-orange-400');
        buttonNextWord.classList.replace('hover:bg-gray-500', 'hover:bg-orange-500');
    }


    function buttonNextWordDisabledTrue()
    {
        const buttonNextWord = document.getElementById('buttonNextWord');
        buttonNextWord.disabled = true;
        buttonNextWord.classList.replace('bg-orange-400', 'bg-gray-500');
        buttonNextWord.classList.replace('hover:bg-orange-500', 'hover:bg-gray-500');
    }

    function greenAnimate()
    {
        const inputField = document.getElementById('word-input');
        const wordCheckResultError = document.getElementById('wordCheckResultError');
        const wordCheckResultSuccess = document.getElementById('wordCheckResultSuccess');

        wordCheckResultSuccess.style.display = 'block';
        wordCheckResultError.style.display = 'none';
        inputField.style.borderColor = 'green'

        document.body.classList.add('fade-in');

        setTimeout(() => {
            document.body.classList.remove('fade-in');
        }, 500);
    }

    function redAnimate()
    {
        const inputField = document.getElementById('word-input');
        const wordCheckResultError = document.getElementById('wordCheckResultError');
        const wordCheckResultSuccess = document.getElementById('wordCheckResultSuccess');

        wordCheckResultSuccess.style.display = 'none';
        wordCheckResultError.style.display = 'block';
        inputField.style.borderColor = 'red'

        document.body.classList.add('fade-out');

        // Удаляем класс через 2 секунды, чтобы можно было повторно нажать на кнопку
        setTimeout(() => {
            document.body.classList.remove('fade-out');
        }, 500);
    }

    function sendDoneWord()
    {
        buttonNextWordDisabledTrue();

        fetch('/home/done-repeat-description-word/' + wordId)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Сеть не ответила: ' + response.statusText);
                }
                return response.json(); // Преобразуем ответ в JSON
            })
            .then(data => {
                getWord(); // получаем новое слово
            })
            .catch(error => {
                console.error('Ошибка:', error); // Обработка ошибок
            });
    }

    function sendDoneWordDontKnow()
    {
        buttonNextWordDisabledTrue();

        fetch('/home/dont-know-repeat-description-word/' + wordId)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Сеть не ответила: ' + response.statusText);
                }
                return response.json(); // Преобразуем ответ в JSON
            })
            .then(data => {
                getWord(); // получаем новое слово
            })
            .catch(error => {
                console.error('Ошибка:', error); // Обработка ошибок
            });
    }

    function checkWord()
    {
        const input = document.getElementById('word-input').value; // Получаем значение из input
        const wordInput = input.replace(/\s+/g, ''); // Удаляем пробелы

        // проверяем, совпадают ли слова
        if (word.toLowerCase() == wordInput.toLowerCase()) {
            greenAnimate();
            sendDoneWord();
            showButtonNextWord();
        } else {
            redAnimate();
        }
    }

    function nextWord()
    {
        showNewWord();
    }

    function showButtonNextWord()
    {
        let buttonNextWord = document.getElementById('buttonNextWord');
        let buttonDontKnowWord = document.getElementById('buttonDontKnowWord');
        let buttonCheckWord = document.getElementById('buttonCheckWord');
        buttonDontKnowWord.style.display = 'none';
        buttonCheckWord.style.display = 'none';
        buttonNextWord.style.display = 'block';
    }

    function dontKnow()
    {
        const wordCheckResultError = document.getElementById('wordCheckResultError');
        const wordCheckResultSuccess = document.getElementById('wordCheckResultSuccess');
        const inputField = document.getElementById('word-input');
        const buttonDontKnowWord = document.getElementById('buttonDontKnowWord');
        wordCheckResultError.style.display = 'none';
        wordCheckResultSuccess.style.display = 'none';
        buttonDontKnowWord.style.display = 'block';
        inputField.value = word;
        inputField.style.color = 'black';
        sendDoneWordDontKnow()
        showButtonNextWord();
    }

    function showHidden()
    {
        const hiddenText = document.getElementById('hidden-text');
        hiddenText.style.display = 'block';
    }

    function doneWord()
    {
        let sentenceElement = document.getElementById('sentence');
        sentenceElement.textContent = '';
        const inputField = document.getElementById('word-input');
        inputField.value = '';
        let buttonNextWord = document.getElementById('buttonNextWord');
        let buttonDontKnowWord = document.getElementById('buttonDontKnowWord');
        let buttonCheckWord = document.getElementById('buttonCheckWord');
        buttonDontKnowWord.style.display = 'block';
        buttonCheckWord.style.display = 'block';
        buttonNextWord.style.display = 'none';

        showNewWord()
    }


</script>

