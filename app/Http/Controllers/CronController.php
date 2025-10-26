<?php

namespace App\Http\Controllers;

use App\Models\TgUser;
use App\Models\WordList;
use App\Services\TelegramService;
use App\Services\WordService;
use Illuminate\Support\Facades\Http;

class CronController extends Controller
{
    public function __construct(
        private readonly TelegramService $telegramService,
    )
    {}

    public function responder()
    {
        $users = TgUser::all();

        foreach($users as $user) {

            $text = "Доброе утро, {$user->tg_name}! ☀️  ". PHP_EOL .PHP_EOL ."Новый день — новое слово. Нажми на кнопку «Новое слово» чтобы получить его.";

            $this->telegramService->sendMessage($user->chat_id, $text);

        }

    }
}
