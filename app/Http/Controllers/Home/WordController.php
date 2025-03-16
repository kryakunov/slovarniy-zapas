<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;

class WordController extends Controller
{
    public function index()
    {

        return view('home.my-words');
    }
}
