<?php

namespace App\Http\Controllers\Back;

use App\Models\Article;
use App\Models\Category;
use App\Models\Page;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Dashboard extends Controller
{
    public function index(){
        $articles=Article::all()->count();
        $hit=Article::sum('hit');
        $categories=Category::all()->count();
        $pages=Page::all()->count();
        return view('back.dashboard',compact('articles','hit','categories','pages'));
    }
}
