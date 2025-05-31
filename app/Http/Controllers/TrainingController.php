<?php

namespace App\Http\Controllers;

use App\Models\MyWord;
use App\Models\Word;
use App\Services\GigaChatService;
use Illuminate\Http\Request;

class TrainingController extends Controller
{
    const NEW = 0;
    const REPEAT = 1;
    const DONE = 2;

    public function start()
    {
        return view('training.start');
    }

    public function repeat()
    {
        return view('training.repeat-word');
    }

    public function sentence()
    {
        return view('training.sentence');
    }

    public function descriptionWord()
    {
        return view('training.description-word');
    }


    public function getRepeatWord()
    {
        $word = MyWord::where('user_id', auth()->id())
            ->where('status', self::REPEAT)
            ->with('word')
            ->first()
            ->toArray();

        return response()->json([
            'status' => 'success',
            'word' => $word,
        ]);
    }

    public function doneRepeatWord($id)
    {
        $word = MyWord::where('user_id', auth()->id())
            ->where('id', $id);

        $word->update([
            'status' => self::REPEAT,
            'repeated' => time(),
        ]);

        return response()->json([
            'status' => 'success',
        ]);
    }

    public function doneRepeatSentence($id)
    {
        $word = MyWord::where('user_id', auth()->id())
            ->where('word_id', $id)
            ->first();

        $lastRepeat = time() - $word->repeated;

        // если прошло более суток (22 часа) с момента последнего повтора
        if ($lastRepeat > 72000 / 2) {

            $word->count_repeated++;

            switch ($word->count_repeated) {
                case null:
                case 1:
                case 2:
                    $word->status = self::REPEAT;
                    break;
                case 3:
                    $word->status = self::DONE;
                    break;
            }
        }

        $word->repeated = time();
        $word->update();

        // TODO рассчитать исходя из даты последнего повтора, прибавлять ли count repeated

        return response()->json([
            'status' => 'success',
        ]);
    }

    public function doneRepeatDescriptionWord($id)
    {
        $word = MyWord::where('user_id', auth()->id())
            ->where('word_id', $id)
            ->first();

        $lastRepeat = time() - $word->repeated;

        // если прошло более суток (22 часа) с момента последнего повтора
        if ($lastRepeat > 72000 /2 ) {

            $word->count_repeated++;

            switch ($word->count_repeated) {
                case null:
                case 1:
                case 2:
                    $word->status = self::REPEAT;
                    break;
                case 3:
                    $word->status = self::DONE;
                    break;
            }
        }

        $word->repeated = time();
        $word->update();

        // TODO рассчитать исходя из даты последнего повтора, прибавлять ли count repeated

        return response()->json([
            'status' => 'success',
        ]);
    }

    public function doneStartWord($id)
    {
        $word = MyWord::where('user_id', auth()->id())
            ->where('word_id', $id)
            ->first();

        $word->status = self::REPEAT;
        $word->update();

        return response()->json([
            'status' => 'success',
        ]);
    }

    public function errorRepeatDescriptionWord($id)
    {
        $word = MyWord::where('user_id', auth()->id())
            ->where('word_id', $id)
            ->first();

        $word->repeated = time();
        $word->update();

        // TODO рассчитать исходя из даты последнего повтора, прибавлять ли count repeated

        return response()->json([
            'status' => 'success',
        ]);
    }

    public function dontKnowRepeatDescriptionWord($id)
    {
        $word = MyWord::where('user_id', auth()->id())
            ->where('word_id', $id)
            ->first();

        $word->repeated = time();
        $word->update();

        // TODO рассчитать исходя из даты последнего повтора, прибавлять ли count repeated

        return response()->json([
            'status' => 'success',
        ]);
    }

    public function getSentence(GigaChatService $chatService)
    {
        $res = MyWord::where('user_id', auth()->id())
            ->where('status', self::REPEAT)
            ->where(function($query) {
                $query->where('repeated', '<', time() - 72000 / 2)
                    ->orWhere('repeated', '=', null);
            })
            ->with('word')
            ->first();

        if (isset($res)) {
            $res = $res->toArray();
        } else {
            return response()->json([
                'status' => 'endWords',
            ]);
        }

        $wordId = $res['word']['id'];
        $word = $res['word']['word'];
        $description = $res['word']['description'];

        // Просим ИИ сгенерировать предложение с этим словом
        $sentence = $chatService->generate($word);

        return response()->json([
            'status' => 'success',
            'sentence' => $sentence,
            'word' => $word,
            'word_id' => $wordId,
            'description' => $description,
        ]);
    }


    public function getDescriptionWord()
    {
        $res = MyWord::where('user_id', auth()->id())
            ->where('status', self::REPEAT)
            ->where(function($query) {
                $query->where('repeated', '<', time() - 72000 / 2)
                    ->orWhere('repeated', '=', null);
            })
            ->with('word')
            ->first();

        if (isset($res)) {
            $res = $res->toArray();
        } else {
            return response()->json([
                'status' => 'endWords',
            ]);
        }

        $wordId = $res['word']['id'];
        $word = $res['word']['word'];
        $description = $res['word']['description'];

        // Просим ИИ сгенерировать предложение с этим словом
        $sentence = 'Вчера я так горомко ...... что все соседи шарохались!';

        return response()->json([
            'status' => 'success',
            'word' => $word,
            'word_id' => $wordId,
            'description' => $description,
        ]);
    }

    public function getStartWord()
    {
        $res = MyWord::where('user_id', auth()->id())
            ->where('status', self::NEW)
            ->with('word')
            ->first();

        if (isset($res)) {
            $res = $res->toArray();
        } else {
            return response()->json([
                'status' => 'endWords',
            ]);
        }

        $wordId = $res['word']['id'];
        $word = $res['word']['word'];
        $description = $res['word']['description'];
        $image = $res['word']['image'];

        return response()->json([
            'status' => 'success',
            'word' => $word,
            'word_id' => $wordId,
            'description' => $description,
            'image' => $image,
        ]);
    }

    public function getRememberWord()
    {
        $res = MyWord::where('user_id', auth()->id())
            ->where('status', self::REPEAT)
            ->where('repeated', '<', time() - 72000 / 2)
            ->orWhere('repeated', '=', null)
            ->with('word')
            ->first();

        $res = MyWord::where('user_id', auth()->id())
            ->where('status', self::REPEAT)
            ->where(function($query) {
                $query->where('repeated', '<', time() - 72000 / 2)
                      ->orWhere('repeated', '=', null);
            })
            ->with('word')
            ->first();

        if (isset($res)) {
            $res = $res->toArray();
        } else {
            return response()->json([
                'status' => 'endWords',
            ]);
        }

        $wordId = $res['word']['id'];
        $word = $res['word']['word'];
        $description = $res['word']['description'];

        $words = Word::select('word')->inRandomOrder()->take(5)->get()->toArray();
        $words[] = ['word' => $word];
        shuffle($words);

        return response()->json([
            'status' => 'success',
            'word' => $word,
            'words' => $words,
            'word_id' => $wordId,
            'description' => $description,
        ]);

    }
}
