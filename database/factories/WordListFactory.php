<?php

namespace Database\Factories;

use App\Models\WordList;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WordList>
 */
class WordListFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = WordList::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'likes' => rand(0, 30),
            'category_id' => rand(1, 5),
            'type_id' => 1,
            'count' => rand(20, 120),
            'slug' => $this->faker->word . '-' . $this->faker->word,
            'image' => 'https://avatars.mds.yandex.net/i?id=a94d968b1a293c873f388ed7c64c1c82d05e5f22-5588720-images-thumbs&n=13',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
