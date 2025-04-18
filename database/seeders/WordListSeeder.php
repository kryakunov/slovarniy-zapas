<?php

namespace Database\Seeders;

use App\Models\WordList;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WordListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WordList::factory()->count(10)->create();
    }
}
