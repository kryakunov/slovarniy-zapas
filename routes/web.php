<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\GigaChatController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Home\WordListController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\TrainingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [MainController::class, 'index']);
Route::get('/go', [GigaChatController::class, 'index'])->name('go');
Route::get('/vue', function(){
    return view('app');
});
Route::get('/get-word-lists/{id}', [MainController::class, 'getWordLists'])->name('get-word-lists');
Route::get('/amo', [\App\Http\Controllers\AmoCrmController::class, 'index']);

Auth::routes();

Route::group(['middleware' => 'auth', 'prefix' => 'home'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/lists', [HomeController::class, 'lists'])->name('lists');
    Route::get('/training', [HomeController::class, 'training'])->name('training');
    Route::get('/training-repeat', [TrainingController::class, 'repeat'])->name('training-repeat');
    Route::get('/training-sentence', [TrainingController::class, 'sentence'])->name('training-sentence');
    Route::get('/training-remember', [TrainingController::class, 'remember'])->name('training-remember');
    // тренировки
    Route::get('/get-repeat-word', [TrainingController::class, 'getRepeatWord']);
    Route::get('/get-sentence', [TrainingController::class, 'getSentence']);
    Route::get('/get-remember', [TrainingController::class, 'getRememberWord']);
    Route::get('/done-repeat-word/{id}', [TrainingController::class, 'doneRepeatWord']);
    Route::get('/done-repeat-sentence/{id}', [TrainingController::class, 'doneRepeatSentence']);
    Route::get('/done-remember-word/{id}', [TrainingController::class, 'doneRememberWord']);

    Route::get('/wordlist', [WordListController::class, 'index'])->name('wordlist');
    Route::get('/open-word-list/{slug}', [WordListController::class, 'openWordList'])->name('open-word-list');
    Route::get('/open-my-word-list/{slug}', [WordListController::class, 'openMyWordList'])->name('open-my-word-list');
    Route::post('/addWords', [WordListController::class, 'addWords'])->name('add-words');
    Route::get('/add-word-list/{id}', [WordListController::class, 'addWordList'])->name('add-word-list');
    Route::get('/remove-word-list/{id}', [WordListController::class, 'removeWordList'])->name('add-word-list');
});

Route::group(['middleware' => 'auth', 'prefix' => 'admin'], function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/add-words', [AdminController::class, 'addWords'])->name('admin.add-words');
    // редактировать словарь
    Route::get('/edit-list/{wordList}', [AdminController::class, 'editWordList'])->name('admin.edit-list');
    Route::put('/edit-list/{id}', [AdminController::class, 'updateWordList'])->name('admin.edit-list');
    Route::get('/add-list', [AdminController::class, 'addWordList'])->name('admin.add-list');
    Route::post('/add-list', [AdminController::class, 'storeWordList'])->name('admin.add-list');
    // редактировать слова
    Route::get('/edit-words/{wordList}', [AdminController::class, 'editWords'])->name('admin.edit-words');
    Route::get('/edit-word/{word}', [AdminController::class, 'editWord'])->name('admin.edit-word');
    Route::put('/edit-word/{id}', [AdminController::class, 'updateWord'])->name('admin.edit-word');
    Route::get('/delete-word/{id}', [AdminController::class, 'deleteWord'])->name('admin.delete-word');
    Route::get('/add-word/{id}', [AdminController::class, 'addWord'])->name('admin.add-word');
    Route::post('/add-word/{id}', [AdminController::class, 'saveWord'])->name('admin.add-word');
});
