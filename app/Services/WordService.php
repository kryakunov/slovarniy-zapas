<?php

namespace App\Services;


use App\DTO\Admin\WordStoreDTO;
use App\Repositories\WordRepository;

class WordService
{
    public function __construct
    (
        private readonly WordRepository $wordRepository,
    )
    {}

    public function register(WordStoreDTO $data, $id): void
    {
        $this->wordRepository->create([
            'word' => $data->word,
            'description' => $data->description,
            'word_list_id' => $id,
        ]);
    }
}
