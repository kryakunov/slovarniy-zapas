<?php

namespace App\Repositories;

use App\Models\Word;

class WordRepository
{
    public function create(array $data): Word
    {
        return Word::create($data);
    }

}
