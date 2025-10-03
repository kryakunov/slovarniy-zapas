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

    public function register()
    {

        function check_captcha($token) {

            $captchaServerKey = env('CAPTCHA_SERVER_KEY');

            $ch = curl_init("https://smartcaptcha.yandexcloud.net/validate");
            $args = [
                "secret" => $captchaServerKey,
                "token" => $token,
                "ip" =>  $_SERVER['REMOTE_ADDR'], // Нужно передать IP-адрес пользователя.
                // Способ получения IP-адреса пользователя зависит от вашего прокси.
            ];
            curl_setopt($ch, CURLOPT_TIMEOUT, 1);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($args));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $server_output = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpcode !== 200) {
                echo "Allow access due to an error: code=$httpcode; message=$server_output\n";
                return true;
            }

            $resp = json_decode($server_output);
            return $resp->status === "ok";
        }

        $token = $_POST['smart-token'];
        if (check_captcha($token)) {
            dd('Passed');
        } else {
            dd('Robot');
        }

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

        $repeatWords = MyWord::where('user_id', $userId)
            ->where('status', 1)
            ->where(function($query) {
                $query
                    ->where('repeated', '<', time() - 72000 / 2)
                    ->orWhere('repeated', null);
            })
            ->count();

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
