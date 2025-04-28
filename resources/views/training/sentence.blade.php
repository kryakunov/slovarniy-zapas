@extends('layouts.training')

@section('content')



        <div id="sentence" class="mt-20 text-sky-600 font-semibold text-xl"></div>

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
            <button id="buttonNextWord" style="display: none" onclick="doneWord()"  class="ml-3 mr-2 cursor-pointer bg-orange-400 hover:bg-orange-500 py-3 px-6 text-white text-lg rounded">
                Следующее слово
            </button>
        </div>
        <span  onclick="showHidden()" class="cursor-pointer mt-5"> Показать подсказку</span>

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

    getWord();

    function successWord()
    {
        let sentenceElement = document.getElementById('sentence');
        let resultElement = document.getElementById('result');
        const inputField = document.getElementById('word-input');
        const hiddenText = document.getElementById('hidden-text');
        sentenceElement.textContent = sentence.replace(/\.{3,}/g, word);
        sentenceElement.style.color = 'green';
        resultElement.style.color = 'green';
        resultElement.textContent = 'Верно!';
        inputField.value = word;
        inputField.style.borderColor = 'green'
        hiddenText.style.display = 'none';
    }

    function showWord()
    {
        let sentenceElement = document.getElementById('sentence');
        let resultElement = document.getElementById('result');
        const inputField = document.getElementById('word-input');
        const hiddenText = document.getElementById('hidden-text');
        sentenceElement.textContent = sentence.replace(/\.{3,}/g, word);
        resultElement.textContent = '';
        inputField.value = word;
        inputField.style.borderColor = 'black'
        hiddenText.style.display = 'none';
    }



    function checkWord() {
        const input = document.getElementById('word-input').value; // Получаем значение из input
        let resultElement = document.getElementById('result');
        const wordInput = input.replace(/\s+/g, '').toLowerCase(); // Удаляем пробелы и приводим к нижнему регистру

        if (word.toLowerCase() == wordInput.toLowerCase()) {
            successWord();
            document.body.classList.add('fade-in');
            nextWord();
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

    function nextWord()
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
        showWord();
        nextWord();
    }

    function showHidden() {
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

        fetch('/home/done-repeat-sentence/' + wordId)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Сеть не ответила: ' + response.statusText);
                }
                return response.json(); // Преобразуем ответ в JSON
            })
            .then(data => {
                getWord();
            })
            .catch(error => {
                console.error('Ошибка:', error); // Обработка ошибок
            });
    }

    let word = '';
    let sentence = '';
    let wordId = '';

    function getWord()
    {
        fetch('/home/get-sentence')
            .then(response => {
                if (!response.ok) {
                    throw new Error('Сеть не ответила: ' + response.statusText);
                }
                return response.json(); // Преобразуем ответ в JSON
            })
            .then(data => {
                if(data.status == 'success') {
                    let sentenceElement = document.getElementById('sentence');
                    let descriptionElement = document.getElementById('hidden-text');
                    let resultElement = document.getElementById('result');
                    const inputField = document.getElementById('word-input');
                    word = data.word;
                    sentence = data.sentence
                    wordId = data.word_id
                    description = data.description
                    sentenceElement.textContent = sentence;
                    sentenceElement.style.color = '#0E7490';
                    sentenceElement.classList.add = 'mt-20 text-sky-600 font-semibold text-xl';
                    descriptionElement.textContent = description;
                    resultElement.textContent = '';
                    inputField.style.borderColor = '#0E7490'
                    inputField.value = '';
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

</script>

