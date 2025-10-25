<?php

namespace App\Http\Controllers;

use App\Services\TelegramService;
use Longman\TelegramBot\Telegram;

class TelegramController extends Controller
{
    public function __construct(
        private readonly TelegramService $telegramService,
    )
    {}

    public function __invoke()
    {
        // Получаем сырые POST-данные от Telegram (JSON)
        $input = file_get_contents('php://input');
        $update = json_decode($input, true);

        // Проверка на пустой запрос (Telegram иногда шлет для теста)
        if (!$update || !isset($update['update_id'])) {
            $this->telegramService->error();
        }

        if (isset($update['message'])) {

            $this->telegramService->handleMessage($update['message']);

        } elseif (isset($update['callback_query'])) {

            $this->telegramService->handleCallback($update['callback_query']);

        }

    }


    public function setWebhook()
    {
        $botToken = env('TELEGRAM_TOKEN');
        $botUsername = 'szapan';
        $webhook_url = 'https://словарныйзапас.рф/bot';

        $telegram = new Telegram($botToken, $botUsername);
        $result = $telegram->setWebhook($webhook_url);

        if ($result->isOk()) {
            echo "Webhook установлен успешно: " . $result->getDescription() . "\n";
        } else {
            echo "Ошибка установки webhook: " . $result->getDescription() . "\n";
        }
    }

}
