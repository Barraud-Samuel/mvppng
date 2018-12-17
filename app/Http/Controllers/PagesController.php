<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('pages.index');
    }

    public function about(){
        return view('pages.about');
    }

    public function matchs(){
        return view('pages.matchs');
    }

    public function ranking(){
        return view('pages.ranking');
    }
}
