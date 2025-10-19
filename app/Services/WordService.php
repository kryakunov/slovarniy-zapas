<?php

namespace App\Services;


use App\DTO\Admin\WordStoreDTO;
use App\Models\MyWord;
use App\Models\Word;
use App\Repositories\WordRepository;

class WordService
{
    public function __construct
    (
        private readonly WordRepository $wordRepository,
    )
    {}

    public static function getRandomWord()
    {
        return Word::inRandomOrder()->first();
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
