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

    public function openWordList(WordList $wordList)
    {
        $words = $wordList->words;

        return view('home.open-word-list', compact('words', 'wordList'));
    }
}
