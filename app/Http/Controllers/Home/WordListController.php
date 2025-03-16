<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\WordList;

class WordListController extends Controller
{
    public function index()
    {
        $wordLists = WordList::all();

        return view('home.word-list', compact('wordLists'));
    }
}
