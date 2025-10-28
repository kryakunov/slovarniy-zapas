<?php

namespace App\Services;

use App\Models\MyWord;
use App\Models\TgUser;
use App\Models\TgUsers;
use App\Models\User;
use App\Models\Word;
use App\Models\WordList;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class TelegramService
{
    const btn1 =  [['text' => '✅ Выучил, больше не присылать', 'callback_data' => 'done_btn']];
    const btn2 =   [['text' => '📝 Добавить в список повторения', 'callback_data' => 'add_btn']];
    public $gigaChatService;

    public function __construct(GigaChatService $gigaChatService)
    {
        $this->gigaChatService = $gigaChatService;
    }

    public function handleCallback($callback, $id = 'no')
    {

        $btn = $callback['data'];
        $chatId = $callback['message']['chat']['id'];

        $btn = explode('_', $btn);

        // Кнопка "больше не присылать слова"
        if ($btn[0] == 'delete') {
            $text = "Слово убрано из словаря повторений";

            // TODO убрать из словаря

            $this->sendMessage($chatId, $text);

        } elseif ($btn[0] == 'add') { // Слова добавлено в словарь повторений

            try {

                $tgUser = TgUser::where('tg_id', $chatId)->first();

                if (WordService::addWordToRepeatList($tgUser['id'], 'tg_user_id', $btn[1])) {
                    $this->sendMessage($chatId, 'Слово добавлено в словарь повторений');
                } else {
                    $this->sendMessage($chatId, 'Слово уже есть в словаре');
                }

            } catch (\Exception $e) {
                $this->sendMessage($chatId, 'Произошла ошибка: ' . $e->getMessage());
            }

        }
    }

    public function handleMessage($message)
    {
        $chatId = $message['chat']['id'];
        $text = $message['text'] ?? '';
        // $caption = $message['caption'] ?? 'no';
        $userName = $message['from']['first_name'] ?? ($message['from']['username'] ?? 'Unknown');
        $userLogin = $message['from']['username'] ?? null;
        $userId = $message['from']['id'] ?? '';


        if (empty($text)) {
            $this->error();
        }

        $text = trim($text);


        if ($text == '/start') {


            $tgUser = TgUser::updateOrCreate(
                [
                    'chat_id' => $chatId,
                    'tg_id' => $userId,
                ],
                [
                    'tg_name' => $userName,
                    'tg_login' => $userLogin,
                ]
            );

            $msg = 'Привет, ' . $userName . '! Бот запущен.';

            if ($tgUser->wasRecentlyCreated) {
                $this->sendMessage($chatId, $msg, 'reply');
            }

            $this->sendMessage($chatId, 'Привет, ' . $userName . '! Вы уже используете этого бота', 'reply');
        }

        if ($text == '✨ Новое слово') {

           // $word = WordService::getNewWord($userId);

            $word = WordService::getRandomWord();

            // TODO слово с ударением


            $this->sendMessageWithNewWord($chatId, $word);
        }

        if ($text == '🔁 Повторение') {

            $repeatWords = WordService::getRememberWord($userId, 'tg_user_id');

            $this->sendMessage($chatId, 'Вам осталось повторить {$repeatWords} слов', 'inline');
        }



    }

    public function sendMessage($chatId, $message, $keyboard = false): bool
    {
        $botToken = env('TELEGRAM_TOKEN');
        $botApiUrl = "https://api.telegram.org/bot{$botToken}/sendMessage";

        $data = [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'HTML'
        ];

        if ($keyboard == 'inline') {
            $data['reply_markup'] = $this->getInlineKeyboard();
        }elseif ($keyboard == 'reply') {
            $data['reply_markup'] = $this->getReplyKeyboard();
        }

        Http::post($botApiUrl, $data);

        return true;
    }

    public function sendMessageWithNewWord($chatId, $word): bool
    {
        $botToken = env('TELEGRAM_TOKEN');

        $sentence = '';
//        try {
//            $sentence = $this->gigaChatService->generate($word['word']);
//        }
//        catch (\Exception $e) {
//
//        }

        $text = "<b>{$word['word']}</b> — {$word['description']}" . PHP_EOL . PHP_EOL . "<i>{$sentence}</i>";

        if ($word['image']) {
            $botApiUrl = "https://api.telegram.org/bot{$botToken}/sendPhoto";

            $fullPath = Storage::disk('public')->url('/images/'.$word['image']);
            $fullPath = str_replace('словарныйзапас.рф', 'xn--80aaaf0allsgqghl8k.xn--p1ai', $fullPath);
            $fullPath = str_replace('http', 'https', $fullPath);

            Http::post($botApiUrl, [
                'chat_id' => $chatId,
                'photo' => $fullPath,
                'caption' => $text,
                'parse_mode' => 'HTML',
                'reply_markup' => [
                    'inline_keyboard' => [
                        [['text' => '📝 Добавить в список повторения', 'callback_data' => 'add_' . $word['id']]]
                    ],
                ],
            ]);

        } else {
            $botApiUrl = "https://api.telegram.org/bot{$botToken}/sendMessage";

            Http::post($botApiUrl, [
                'chat_id' => $chatId,
                'text' => $text,
                'parse_mode' => 'HTML',
                'reply_markup' => [
                    'inline_keyboard' => [
                        [['text' => '📝 Добавить в список повторения', 'callback_data' => 'add_' . $word['id']]]
                    ],
                ],
            ]);
        }

        return true;
    }

    public function sendPhoto($chatId, $message, $image): bool
    {
        $botToken = env('TELEGRAM_TOKEN');
        $botApiUrl = "https://api.telegram.org/bot{$botToken}/sendPhoto";

        try {

            $response = Http::attach(
                'photo',
                fopen($image, 'r')
            )->post($botApiUrl, [
                'chat_id' => $chatId,
                'caption' => $message,
                'reply_markup' => json_encode($this->getReplyKeyboard()),
                'parse_mode' => 'HTML'
            ]);

        } catch (\Exception $e) {
            dd($e->getMessage());
        }

        return true;
    }

    public function getReplyKeyboard(): array
    {
        return [
            'keyboard' => [
                [["text" => "✨ Новое слово"], ["text" => "🔁 Повторение"]],
                [["text" =>  "📚 Мои словари"], ["text" => "📈 Мой прогресс"]]
            ],
            'resize_keyboard' => true, // Автоматическое изменение размера
            'one_time_keyboard' => false // Клавиатура остается после нажатия
        ];
    }

    public function getInlineKeyboard(array $buttons = null): array
    {
        return [
            'inline_keyboard' => [
               $buttons
            ]
        ];
    }

    public function error(): void
    {
        http_response_code(200);
        echo 'OK';
        exit;
    }

    public static function sendWordLists($chatId)
    {
        $botToken = env('TELEGRAM_TOKEN');
        $botApiUrl = "https://api.telegram.org/bot{$botToken}/sendMessage";

        $wordLists = WordList::select('id','title','description','count')->get()->toArray();

        // формируем массив кнопок со словарями
        $buttons = [];
        foreach ($wordLists as $wordList) {
            $buttons[]  = [['text' => $wordList['title'], 'callback_data' => 'list_'.$wordList['id']]];
        }

        $data = [
            'chat_id' => $chatId,
            'text' => 'Словари:' . PHP_EOL,
            'parse_mode' => 'HTML',
            'reply_markup' => [
                'inline_keyboard' => $buttons
            ],
        ];

        Http::post($botApiUrl, $data);

        return true;
    }
}
