<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Word;
use App\Models\WordList;

class MainController extends Controller
{
    public function index()
    {
        $wordLists = WordList::take(6)->get();
        $words = Word::all();
        $categories = Category::all();

        return view('welcome', compact('wordLists', 'words', 'categories'));
    }

    public function about()
    {
        return view('home.about');
    }

    public function getWordLists($id)
    {
        $wordLists = WordList::where('category_id', $id)->get();

        return response()->json($wordLists);
    }
}
