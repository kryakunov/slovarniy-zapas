@extends('layouts.training')

@section('content')

        <div id="wordDescription" class="mt-20 text-sky-600 font-semibold text-xl">...</div>


        <div id="wordContainer"></div>


        <div id="wordCheckResultSuccess" class="mt-8 font-semibold text-xl text-green-600" style="display: none">Верно!</div>
        <div id="wordCheckResultError" class="mt-8 font-semibold text-xl text-red-500" style="display: none">Неверно</div>


@endsection
<style>
    .non-clickable {
        pointer-events: none; /* Отключаем клики */
        opacity: 0.5; /* Можно добавить эффект, чтобы показать, что элемент неактивен */
    }

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

    #wordContainer {
        margin-top: 70px;
    }

    #wordContainer span {
        background-color: lightslategrey;
        color: white;
        padding: 15px;
        border-radius: 5%;
        margin-left: 5px;
    }

    #wordContainer span:hover {
        cursor: pointer;
        background-color: forestgreen;
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
    let words = [];

    const wordDescription = document.getElementById('wordDescription');
    const inputField = document.getElementById('word-input');
    const wordCheckResultError = document.getElementById('wordCheckResultError');
    const wordCheckResultSuccess = document.getElementById('wordCheckResultSuccess');

    function showNewWord()
    {
        const wordContainer = document.getElementById('wordContainer');

        if (wordContainer.classList.contains('non-clickable')) {
            wordContainer.classList.remove('non-clickable');
        }

        const wordCheckResultError = document.getElementById('wordCheckResultError');
        const wordCheckResultSuccess = document.getElementById('wordCheckResultSuccess');

        wordCheckResultSuccess.style.display = 'none';
        wordCheckResultError.style.display = 'none';

        // Получаем элемент, в который будем добавлять слова
        wordContainer.textContent = '';

        // Проходим по массиву и добавляем каждое слово в контейнер
        words.forEach((word, index) => {
            const wordElement = document.createElement('span'); // Создаем новый элемент <span>
            wordElement.textContent = word.word; // Устанавливаем текст элемента

            // Добавляем обработчик клика
            wordElement.addEventListener('click', () => checkWord(word.word));

            wordContainer.appendChild(wordElement); // Добавляем элемент в контейнер


        });

        // const wordCheckResultError = document.getElementById('wordCheckResultError');
        // const wordCheckResultSuccess = document.getElementById('wordCheckResultSuccess');
         const wordDescription = document.getElementById('wordDescription');
        // const buttonNextWord = document.getElementById('buttonNextWord');
        // const buttonCheckWord = document.getElementById('buttonCheckWord');
        // const buttonDontKnowWord = document.getElementById('buttonDontKnowWord');
        // wordCheckResultError.style.display = 'none';
        // wordCheckResultSuccess.style.display = 'none';
        // buttonNextWord.style.display = 'none';
        // buttonCheckWord.style.display = 'block';
        // buttonDontKnowWord.style.display = 'block';
         wordDescription.textContent = description;
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
                if(data.status == 'success') {
                    word = data.word;
                    description = data.description
                    wordId = data.word_id
                    words = data.words
                    showNewWord()
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


    function buttonNextWordDisabledTrue()
    {
        const buttonNextWord = document.getElementById('buttonNextWord');
        buttonNextWord.disabled = true;
        buttonNextWord.classList.replace('bg-orange-400', 'bg-gray-500');
        buttonNextWord.classList.replace('hover:bg-orange-500', 'hover:bg-gray-500');
    }

    function greenAnimate()
    {
        const wordCheckResultError = document.getElementById('wordCheckResultError');
        const wordCheckResultSuccess = document.getElementById('wordCheckResultSuccess');

        wordCheckResultSuccess.style.display = 'block';
        wordCheckResultError.style.display = 'none';

        document.body.classList.add('fade-in');

        setTimeout(() => {
            document.body.classList.remove('fade-in');
        }, 500);
    }

    function redAnimate()
    {

        const wordCheckResultError = document.getElementById('wordCheckResultError');
        const wordCheckResultSuccess = document.getElementById('wordCheckResultSuccess');

        wordCheckResultSuccess.style.display = 'none';
        wordCheckResultError.style.display = 'block';

        document.body.classList.add('fade-out');

        // Удаляем класс через 2 секунды, чтобы можно было повторно нажать на кнопку
        setTimeout(() => {
            document.body.classList.remove('fade-out');
        }, 500);
    }

    function sendDoneWord()
    {
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

    function sendErrorWord()
    {
        fetch('/home/error-repeat-description-word/' + wordId)
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

    function checkWord(wordClick)
    {

        const wordContainer = document.getElementById('wordContainer');
        wordContainer.classList.add('non-clickable')

        // проверяем, совпадают ли слова
        if (word.toLowerCase() == wordClick.toLowerCase()) {
            greenAnimate();
            sendDoneWord();
        } else {
            redAnimate();
            sendErrorWord();
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

