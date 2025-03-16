<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WordList extends Model
{
    protected $guarded = false;

    public function words()
    {
        return $this->hasMany(Word::class);
    }
}
