<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Home\MainController;
use App\Http\Controllers\Home\WordController;
use App\Http\Controllers\Home\WordListController;
use App\Http\Controllers\HomeController;
use App\Models\Word;
use App\Models\WordList;
use Illuminate\Support\Facades\Route;

Route::get('/', [MainController::class, 'index']);

Auth::routes();


Route::group(['middleware' => 'auth', 'prefix' => 'home'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/my-words', [WordController::class, 'index'])->name('my-words');
    Route::get('/wordlist', [WordListController::class, 'index'])->name('wordlist');
    Route::get('/open-word-list/{wordList}', [WordListController::class, 'openWordList'])->name('open-word-list');
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
