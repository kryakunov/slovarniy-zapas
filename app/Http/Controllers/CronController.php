<?php

namespace App\Http\Controllers;

use App\Models\TgUser;
use App\Services\TelegramService;
use App\Services\WordService;

class CronController extends Controller
{
    public function __construct(
        private readonly TelegramService $telegramService,
    )
    {}

    public function responder()
    {
        $users = TgUser::where('tg_id', 375727411)->get();

        foreach($users as $user) {

           // $word = WordService::getNewWordByTgId($user->tg_id);
            $word = WordService::getRandomWord();
            $text = "Привет, {$user->tg_name}! Новое слово на сегодня: " . PHP_EOL .PHP_EOL .
                    "<b>{$word['word']}</b> — {$word['description']}";

            if($word['image']) {
                $this->telegramService->sendPhoto($user->chat_id, $text, $word['image']);
            } else {
                $this->telegramService->sendMessage($user->chat_id, $text);
            }
        }

    }
}
