<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\WordStoreRequest;
use App\Models\User;
use App\Models\Word;
use App\Models\WordList;
use App\Services\WordService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct(
        private readonly WordService $wordService,
    )
    {}

    public function index()
    {
        $users = User::all()->count();
        $wordLists = WordList::all()->count();
        $words = Word::all()->count();

        return view('admin.index', compact('users', 'wordLists', 'words'));
    }

    public function addWords()
    {
        $wordLists = WordList::all();

        return view('admin.add-words', compact('wordLists'));
    }

    public function editWordList(WordList $wordList)
    {
        return view('admin.edit-list', compact('wordList'));
    }

    public function addWordList()
    {
        return view('admin.add-list');
    }

    public function storeWordList(Request $request)
    {
        WordList::create([
            'title' => $request->title,
            'description' => $request->description,
            'slug' => $request->slug,
            'category_id' => 1,
            'type_id' => 1,
        ]);

        return view('admin.add-list');
    }

    public function updateWordList($id, Request $request)
    {
        WordList::find($id)->update($request->all());

        $wordLists = WordList::all();

        return view('admin.add-words', compact('wordLists'));
    }

    public function editWords(WordList $wordList)
    {
        $words = $wordList->words;

        return view('admin.show-all-words', compact('words', 'wordList'));
    }

    public function editWord(Word $word)
    {
        return view('admin.edit-word', compact('word'));
    }


    public function updateWord($id, Request $request)
    {

        $word = Word::find($id);
        $path = null;

        // Загрузка изображения
        if ($request->file('image')) {
            $filename = $word->id . '.' . $request->file('image')->getClientOriginalExtension();
            $path = $request->file('image')->storeAs('images', $filename, 'public');
        }

        $word->update([
            'word' => $request->word,
            'description' => $request->description,
            'image' => $filename ?? null,
            'hide_image' => $request->hide_image ?? 0,
        ]);

        return redirect()->route('admin.edit-words', $word->word_list_id);
    }

    public function deleteWord($id)
    {
        $word = Word::find($id);

        $listId = $word->word_list_id;

        $word->delete();

        return redirect()->route('admin.edit-words', $listId);
    }

    public function addWord($id)
    {
        return view('admin.add-word', compact('id'));
    }

    public function saveWord(WordStoreRequest $request, $id)
    {
        $wordDTO = $request->toDTO();

        $this->wordService->register($wordDTO, $id);

        $count = Word::where('word_list_id', $id)->count();
        $wordList = WordList::where('id', $id)->first();
        $wordList->update(['count' => $count]);

        return redirect()->route('admin.edit-words', $id);
    }
}
