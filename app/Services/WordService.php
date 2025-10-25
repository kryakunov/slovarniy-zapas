<?php

namespace App\Services;


use App\DTO\Admin\WordStoreDTO;
use App\Models\MyWord;
use App\Models\Word;
use App\Repositories\WordRepository;

class WordService
{
    const NEW = 0;
    const REPEAT = 1;
    const DONE = 2;

    public function __construct
    (
        private readonly WordRepository $wordRepository,
    )
    {}

    public static function getRandomWord()
    {
        return Word::inRandomOrder()->first();
    }

    public static function getRepeatWords($userId)
    {
        $repeatWords = MyWord::where('user_id', $userId)
            ->where('status', 1)
            ->where(function($query) {
                $query
                    ->where('repeated', '<', time() - 72000 / 2)
                    ->orWhere('repeated', null);
            })
            ->count();

        return $repeatWords;
    }

    public static function getRememberWord($userId)
    {
        $word = MyWord::where('user_id', $userId)
            ->where('status', self::REPEAT)
            ->where(function($query) {
                $query->where('repeated', '<', time() - 72000 / 2)
                    ->orWhere('repeated', '=', null);
            })
            ->with('word')
            ->first();

        return $word;
    }

    public static function getNewWord($userId)
    {
        $word = MyWord::where('user_id', $userId)
            ->where('status', self::NEW)
            ->with('word')
            ->first();

        return $word;
    }

    public function register(WordStoreDTO $data, $id): void
    {
        $this->wordRepository->create([
            'word' => $data->word,
            'stress' => $data->word,
            'description' => $data->description,
            'sentence' => $data->sentence,
            'word_list_id' => $id,
        ]);
    }

    public static function getNewWordByTgId($tgId)
    {
        MyWord::where('tg_user_id', $tgId)
            ->where('status', 0)
            ->with('word')
            ->first();
    }
}
