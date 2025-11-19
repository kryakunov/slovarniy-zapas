<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MyWord extends Model
{
    protected $guarded = false;

    public function word()
    {
        return $this->hasOne(Word::class, 'id', 'word_id');
    }
}
