<?php

namespace Database\Factories;

use App\Models\Word;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class WordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Word::class;

    public function definition()
    {
        return [
            'word' => $this->faker->word,
            'description' => $this->faker->word,
            'likes' => rand(0,100),
            'word_list_id' => rand(1,5),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }


}
