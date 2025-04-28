@extends('layouts.training')

@section('content')

    <div id="word" class="mt-20 text-sky-600 font-semibold text-2xl">Слово</div>
    <div id="description" class="text-sm mt-5 ml-50 mb-5 mr-50">Описание</div>

    <button id="buttonNextWord"  onclick="sendDoneWord()"  class="ml-3 mr-2 cursor-pointer mt-3 py-3 px-6 text-white text-lg rounded">
        Следующее слово
    </button>
    </div>

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

    #buttonNextWord {
        background-color: lightslategrey;
        color: white;
        padding: 15px;
        margin-left: 5px;
    }

    #buttonNextWord:hover {
        cursor: pointer;
        background-color: forestgreen;
    }

</style>

<script>
    getWord();


    let word = '';
    let description = '';
    let wordId = 0;

    const wordDescription = document.getElementById('wordDescription');
    const inputField = document.getElementById('word-input');
    const wordCheckResultError = document.getElementById('wordCheckResultError');
    const wordCheckResultSuccess = document.getElementById('wordCheckResultSuccess');

    function getWord()
    {
        fetch('/home/get-start-word')
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



                    showNewWord();

                    buttonNextWordDisabledFalse();

                } else if(data.status == 'endWords') {
                    const popup = document.getElementById('endWords');
                    const overlay = document.getElementById('overlay');

                    endWords.style.display = 'block';
                    overlay.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Ошибка:', error); // Обработка ошибок
            });
    }

    function showNewWord()
    {
        const wordDiv = document.getElementById('word');
        const descriptionDev = document.getElementById('description');
        wordDiv.textContent = word;
        descriptionDev.textContent = description;
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



    function sendDoneWord()
    {
        buttonNextWordDisabledTrue();

        fetch('/home/done-start-word/' + wordId)
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
        inputField.style.borderColor = 'black'
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

