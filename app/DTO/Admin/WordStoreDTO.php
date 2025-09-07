<?php

namespace App\DTO\Admin;

use Psr\Http\Message\ServerRequestInterface;

class WordStoreDTO
{
    public function __construct
    (
        public readonly string $word,
        public readonly string $stress,
        public readonly string $description,
        public readonly string $sentence,
    )
    {
    }

    public static function fromArray(array $data): self
    {
        return new self(
            word: $data['word'],
            stress: $data['stress'] ?? null,
            description: $data['description'],
            sentence: $data['sentence'],
        );
    }
}
