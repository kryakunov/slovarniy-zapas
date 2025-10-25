<?php

namespace App\Services;

use App\Models\TgUser;
use App\Models\TgUsers;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class TelegramService
{
    public function __construct(
    )
    {}

    public function handleCallback($callback)
    {
        $btn = $callback['data'];
        $chatId = $callback['message']['chat']['id'];
        $messageId = $callback['message']['message_id'];


        // Кнопка "больше не присылать слова"
        if ($btn == 'btn1') {
            $text = "Слово {$callback['callback_query']['message']} убрано из словаря повторений";
            $this->sendMessage($chatId, $text);
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

        try {

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

                if ($tgUser->wasRecentlyCreated) {
                    $this->sendMessage($chatId, 'Привет, ' . $userName . '! Бот запущен. Скоро вам будут приходить слова');
                }

                $this->sendMessage($chatId, 'Привет, ' . $userName . '! Вы уже используете этого бота');
            }

            if ($text == 'Новое слово') {
                $this->sendMessage($chatId, 'Вы запросили новое слово');
            }

        } catch (\Exception $e) {
            file_put_contents('errors.txt', $e->getMessage() . "\n" . $userName . "\n" . $userId);
        }

    }

    public function sendMessage($chatId, $message): bool
    {
        $botToken = env('TELEGRAM_TOKEN');
        $botApiUrl = "https://api.telegram.org/bot{$botToken}/sendMessage";

        Http::post($botApiUrl, [
            'chat_id' => $chatId,
            'text' => $message,
            'reply_markup' => json_encode($this->getInlineKeyboard()),
            'parse_mode' => 'HTML'
        ]);

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
                [['text' => 'Новое слово'], ['text' => 'Повторение']],
                [['text' => 'Кнопка 3']]
            ],
            'resize_keyboard' => true, // Автоматическое изменение размера
            'one_time_keyboard' => false // Клавиатура остается после нажатия
        ];
    }

    public function getInlineKeyboard(): array
    {
        return [
            'inline_keyboard' => [
                [['text' => 'Выучил, больше не присылать', 'callback_data' => 'btn1']]
            ]
        ];
    }


    public function error(): void
    {
        http_response_code(200);
        echo 'OK';
        exit;
    }

}
