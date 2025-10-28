<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MyWord extends Model
{
    use SoftDeletes;
    protected $guarded = false;

    public function word()
    {
        return $this->hasOne(Word::class, 'id', 'word_id');
    }
}
