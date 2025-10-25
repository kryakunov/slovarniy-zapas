<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\MyWord;
use App\Models\MyWordList;
use App\Models\Word;
use App\Models\WordList;
use App\Services\WordService;

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
            $wl = WordList::where('id', $wordList->word_list_id)->first();
            $wl['done'] = MyWord::where('user_id', $userId)
                ->where('word_list_id', $wl->id)
                ->where('status', 2)
                ->count();
            $all[] = $wl;
        }

        $totalWords = MyWord::where('user_id', $userId)
            ->count();

        $doneWords = MyWord::where('user_id', $userId)
            ->where('status', 2)
            ->count();

        $newWords = MyWord::where('user_id', $userId)
            ->where('status', 0)
            ->count();

        $repeatWords = WordService::getRepeatWords($userId);

        $repeatedWords = MyWord::where('user_id', $userId)
          //  ->where('status', 1)
            ->where('repeated', '>', time() - 72000/2)
            ->count();

        $allWords = MyWord::where('user_id', $userId)
            ->count();


        return view('home.index', [
            'wordLists' => $all,
            'doneWords' => $doneWords,
            'repeatWords' => $repeatWords,
            'repeatedWords' => $repeatedWords,
            'totalWords' => $totalWords,
            'newWords' => $newWords,
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
        $userId = auth()->id();

        $repeatWords = MyWord::where('user_id', $userId)
            ->where('status', 1)
            ->where(function($query) {
                $query
                    ->where('repeated', '<', time() - 72000 / 2)
                    ->orWhere('repeated', null);
            })
            ->count();

        $newWords = MyWord::where('user_id', $userId)
            ->where('status', 0)
            ->count();

        return view('home.training', compact('repeatWords', 'newWords'));
    }
}
