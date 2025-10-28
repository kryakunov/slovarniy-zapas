<?php

namespace App\Services;

use App\Enums\Button;
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
    public $gigaChatService;
    public $botToken;

    public function __construct(GigaChatService $gigaChatService)
    {
        $this->botToken = env('TELEGRAM_TOKEN');
        $this->gigaChatService = $gigaChatService;
    }

    public function handleCallback($callback, $id = 'no')
    {
        $btn = $callback['data'];
        $chatId = $callback['message']['chat']['id'];

        $btn = explode('_', $btn);

        // Кнопка "больше не присылать слово". Удаляем его из словаря повторений
        if ($btn[0] == 'delete') {

            try {
                $tgUser = TgUser::where('tg_id', $chatId)->first()->id;
                MyWord::where([
                    'tg_user_id' => $tgUser->id,
                    'id' => $btn[1],
                ])->delete();
            } catch (\Throwable $th) {
                Log::error($th->getMessage());
            }

            $this->sendMessage($chatId, 'Слово убрано из словаря повторений');

        } elseif ($btn[0] == 'add') { // Добавить слово в словарь повторений

            try {
                $tgUser = TgUser::where('tg_id', $chatId)->first()->id;

                if (WordService::addWordToRepeatList($tgUser, 'tg_user_id', $btn[1])) {
                    $this->sendMessage($chatId, 'Слово добавлено в словарь повторений');
                } else {
                    $this->sendMessage($chatId, 'Слово уже есть в словаре');
                }

            } catch (\Exception $e) {
                $this->sendMessage($chatId, 'Произошла ошибка: ' . $e->getMessage());
            }

        } elseif ($btn[0] == 'repeat') { // Проверить слово

            if ($btn[1] == 'false') {
                $this->sendMessage($chatId, 'Неверно');

                // TODO получить id сообщения и удалить. А слово пометить как незачет
                return;
            }

            try {
                $myWord = MyWord::where('id', $btn[1])->first();
                $count = $myWord->count_repeated;
                $myWord->update([
                    'count_repeated' => $count + 1,
                    'repeated' => time(),
                ]);

                $this->sendMessage($chatId, 'Да!');

            } catch (\Exception $e) {
                Log::error($e->getMessage());
                $this->sendMessage($chatId, 'Произошла ошибка ' . $e->getMessage());
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

            $tgUserId = TgUser::where('tg_id', $chatId)->first()->id;
            $word = WordService::getRememberWord($tgUserId, 'tg_user_id');

            $botToken = env('TELEGRAM_TOKEN');
            if (!isset($word)) {
                $this->sendMessage($chatId, 'Слова закончились');
                return;
            }

            // Рандомные слова для кнпочек
            $words = Word::select('word', 'id')->inRandomOrder()->take(3)->get()->toArray();
            $buttons = [];
            foreach($words as $item) {
                $buttons[] = [['text' => $item['word'], 'callback_data' => 'repeat_false']];
            }
            $buttons[] = [['text' => $word->word->word, 'callback_data' => 'repeat_'.$word->id]];

            shuffle($buttons);
            $text = "<i>{$word->word->description}</i> " . PHP_EOL . PHP_EOL . " — Что это за слово? 🤔". PHP_EOL . PHP_EOL;

            if ($word->word->image) {
                $botApiUrl = "https://api.telegram.org/bot{$botToken}/sendPhoto";

                $fullPath = Storage::disk('public')->url('/images/'.$word->word->image);
                $fullPath = str_replace('словарныйзапас.рф', 'xn--80aaaf0allsgqghl8k.xn--p1ai', $fullPath);
                $fullPath = str_replace('http', 'https', $fullPath);

                Http::post($botApiUrl, [
                    'chat_id' => $chatId,
                    'photo' => $fullPath,
                    'caption' => $text,
                    'parse_mode' => 'HTML',
                    'reply_markup' => [
                        'inline_keyboard' => $buttons
                    ],
                ]);

            } else {
                $botApiUrl = "https://api.telegram.org/bot{$botToken}/sendMessage";

                Http::post($botApiUrl, [
                    'chat_id' => $chatId,
                    'text' => $text,
                    'parse_mode' => 'HTML',
                    'reply_markup' => [
                        'inline_keyboard' => $buttons
                    ],
                ]);
            }

            return true;
        }
    }

    public function sendMessage($chatId, $message, $keyboard = false, $buttons = null): bool
    {
        $botApiUrl = "https://api.telegram.org/bot{$this->botToken}/sendMessage";

        $data = [
            'chat_id' => $chatId,
            'text' => $message,
            'parse_mode' => 'HTML'
        ];

        if ($keyboard == 'inline') {
            if (!$buttons) {
                return false;
            }

            $data['reply_markup'] = [
                'inline_keyboard' =>  $buttons
            ];

        } elseif ($keyboard == 'reply') {
            $data['reply_markup'] = $this->getReplyKeyboard();
        }

        Http::post($botApiUrl, $data);

        return true;
    }

    public function sendMessageWithNewWord($chatId, $word): bool
    {
        $text = "<b>{$word['word']}</b> — {$word['description']}" . PHP_EOL . PHP_EOL . "<i>{$word['sentence']}</i>";

        $btn = [['text' => Button::AddToRepeatList->value, 'callback_data' => 'add_' . $word['id']]];

        if ($word['image']) {

            $fullPath = Storage::disk('public')->url('/images/'.$word['image']);
            $fullPath = str_replace('словарныйзапас.рф', 'xn--80aaaf0allsgqghl8k.xn--p1ai', $fullPath);
            $fullPath = str_replace('http', 'https', $fullPath);

            $this->sendPhoto(
                chatId: $chatId,
                message: $text,
                photoUrl: $fullPath,
                keyboard: 'inline',
                buttons: $btn
            );

        } else {

            $this->sendMessage(
                chatId: $chatId,
                message: $text,
                keyboard: 'inline',
                buttons: $btn
            );
        }

        return true;
    }

    public function sendPhoto($chatId, $message, $photoUrl, $keyboard = 'reply', $buttons = null): bool
    {
        $botApiUrl = "https://api.telegram.org/bot{$this->botToken}/sendPhoto";

        $data = [
            'chat_id' => $chatId,
            'photo' => $photoUrl,
            'caption' => $message,
            'parse_mode' => 'HTML',
        ];

        if ($keyboard == 'inline') {
            if (!$buttons) {
                return false;
            }

            $data['reply_markup'] = [
                'inline_keyboard' =>  $buttons
            ];

        } elseif ($keyboard == 'reply') {
            $data['reply_markup'] = $this->getReplyKeyboard();
        }

        try {

            Http::post($botApiUrl, $data);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
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
