<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\MyWord;
use App\Models\MyWordList;
use App\Models\Word;
use App\Models\WordList;
use Illuminate\Http\Request;

class WordListController extends Controller
{
    public function index()
    {
        $wordLists = WordList::all();

        return view('home.word-list', compact('wordLists'));
    }

    public function openWordList($slug)
    {
        $wordList = WordList::where('slug', $slug)->first();

        $words = Word::where('word_list_id', $wordList->id)
            ->get();

        return view('home.open-word-list', compact('words', 'wordList'));
    }

    public function openMyWordList($slug)
    {
        $wordList = WordList::where('slug', $slug)->first();

        $words = MyWord::where('user_id', auth()->id())
            ->where('word_list_id', $wordList->id)
            ->with('word')
            ->get();

        return view('home.open-my-word-list', compact('words', 'wordList'));
    }

    public function addWordList($id)
    {
        $list = MyWordList::create([
            'word_list_id' => $id,
            'user_id' => auth()->id(),
        ]);

        $words = Word::where('word_list_id', $id)->get();

        foreach($words as $word){
            MyWord::create([
                'user_id' => auth()->id(),
                'word_id' => $word->id,
                'word_list_id' => $id,
            ]);
        }

        if ($list) {
            return response()->json([
                'status' => true,
            ]);
        }

        return response()->json([
            'status' => false,
        ]);
    }

    public function removeWordList($id)
    {
        $res = MyWordList::where('user_id', auth()->id())->where('word_list_id', $id)->delete();

        MyWord::where('user_id', auth()->id())->where('word_list_id', $id)->delete();

        if ($res) {
            return response()->json([
                'status' => true,
            ]);
        }

        return response()->json([
            'status' => false,
        ]);
    }

    public function addWords(Request $request)
    {
        dd($request->all());

        MyWord::create([
            'user_id' => auth()->id(),
            'word_id' => $id
        ]);
    }
}
