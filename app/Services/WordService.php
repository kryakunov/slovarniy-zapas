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
        return Word::where('is_active', 1)
            ->whereHas('wordList', function ($query) {
                $query->where('is_active', 1);
            })
            ->inRandomOrder()
            ->first();
    }

    public static function getRandomWordWithImage()
    {
        return Word::where('is_active', 1)
            ->whereNotNull('image')
            ->whereHas('wordList', function ($query) {
                $query->where('is_active', 1);
            })
            ->inRandomOrder()
            ->first();
    }

    public static function getRepeatWords($userId, string $column = 'user_id')
    {
        $allowedColumns = ['user_id', 'tg_user_id']; // Добавьте другие, если нужно
        if (!in_array($column, $allowedColumns)) {
            throw new \InvalidArgumentException("Недопустимая колонка: {$column}");
        }

        $repeatWords = MyWord::where($column, $userId)
            ->where('status', 1)
            ->where(function($query) {
                $query
                    ->where('repeated', '<', time() - 72000 / 2)
                    ->orWhere('repeated', null);
            })
            ->count();

        return $repeatWords;
    }

    public static function getRememberWord($userId, string $column = 'user_id')
    {
        $allowedColumns = ['user_id', 'tg_user_id']; // Добавьте другие, если нужно
        if (!in_array($column, $allowedColumns)) {
            throw new \InvalidArgumentException("Недопустимая колонка: {$column}");
        }

        $word = MyWord::where($column, $userId)
            ->where('status', self::REPEAT)
            ->where(function($query) {
                $query->where('repeated', '<', time() - 72000 / 2)
                    ->orWhere('repeated', '=', null);
            })
            ->with('word')
            ->first();

        return $word;
    }

    public static function addWordToRepeatList($userId, string $column = 'user_id', $wordId): bool
    {
        $allowedColumns = ['user_id', 'tg_user_id']; // Добавьте другие, если нужно
        if (!in_array($column, $allowedColumns)) {
            throw new \InvalidArgumentException("Недопустимая колонка: {$column}");
        }

        $word = Word::where('id', $wordId)->firstOrFail();

        $word = MyWord::firstOrCreate(
            [
            'word_id' => $wordId
            ],
            [
            'user_id' => 1,
            'tg_user_id' => $userId,
            'word_list_id' => $word['word_list_id'],
            'status' => self::REPEAT,
            'repeated' => null,
            'count_repeated' => null,
        ]);

        if ($word->wasRecentlyCreated) {
            return true;
        } else {
            return false;
        }
    }

    public static function wordRepeated($userId, string $column = 'user_id', $wordId)
    {
        $allowedColumns = ['user_id', 'tg_user_id']; // Добавьте другие, если нужно
        if (!in_array($column, $allowedColumns)) {
            throw new \InvalidArgumentException("Недопустимая колонка: {$column}");
        }

        MyWord::where($column, $userId)
            ->where('id', $wordId)
            ->update([
                'status' => self::REPEAT,
                'repeated' => time(),
            ]);

        return true;
    }

    public static function getNewWord($userId, string $column = 'user_id')
    {
        $allowedColumns = ['user_id', 'tg_user_id']; // Добавьте другие, если нужно
        if (!in_array($column, $allowedColumns)) {
            throw new \InvalidArgumentException("Недопустимая колонка: {$column}");
        }

        $word = MyWord::where($column, $userId)
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
}
