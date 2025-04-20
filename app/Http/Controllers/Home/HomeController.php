<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\MyWord;
use App\Models\MyWordList;
use App\Models\Word;
use App\Models\WordList;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index()
    {
        $userId = auth()->user()->id;

        // TODO жадная агрузка

        $wordLists = MyWordList::where('user_id', $userId)->get();

        $all = [];
        $count = 0;
        foreach($wordLists as $wordList){
            $all[] = $wl = WordList::where('id', $wordList->word_list_id)->first();
            $count += $wl->count;
        }

        $doneWords = MyWord::where('user_id', $userId)
            ->where('status', 2)
            ->count();

        $repeatWords = MyWord::where('user_id', $userId)
            ->whereBetween('status', [1,2])
            ->where('repeated', '<', time() - 72000)
            ->count();

        $repeatedWords = MyWord::where('user_id', $userId)
            ->where('status', 1)
            ->where('repeated', '>', time() - 72000)
            ->count();

        $allWords = MyWord::where('user_id', $userId)
            ->count();

        $percent = 5;//($doneWords / $allWords) * 100;

        return view('home.index', [
            'wordLists' => $all,
            'doneWords' => $doneWords,
            'repeatWords' => $repeatWords,
            'repeatedWords' => $repeatedWords,
            'allWords' => $allWords,
            'percent' => $percent,
        ]);
    }


    public function lists()
    {
        $wordLists = WordList::all();
        $words =  Word::all()->count();

        $myWordLists = MyWordList::select('word_list_id')
            ->where('user_id', auth()->id())
            ->pluck('word_list_id')
            ->toArray();

        return view('home.lists', [
            'wordLists' => $wordLists,
            'myWordLists' => $myWordLists,
        ]);
    }

    public function training()
    {
        return view('home.training');
    }
}
