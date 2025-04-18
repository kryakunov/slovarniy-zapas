<?php

namespace App\DTO\Admin;

use Psr\Http\Message\ServerRequestInterface;

class WordStoreDTO
{
    public function __construct
    (
        public readonly string $word,
        public readonly string $description,
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            word: $data['word'],
            description: $data['description'],
        );
    }
}
