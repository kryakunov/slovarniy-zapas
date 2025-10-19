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

    public function handle($message)
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
            'parse_mode' => 'HTML'
        ]);

        return true;
    }

    public function error(): void
    {
        http_response_code(200);
        echo 'OK';
        exit;
    }

}
