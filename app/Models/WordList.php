<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WordList extends Model
{
    protected $guarded = false;
    use HasFactory;

    public function words()
    {
        return $this->hasMany(Word::class);
    }

    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}
