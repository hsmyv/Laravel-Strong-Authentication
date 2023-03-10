<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('Home.Index');
    }

    public function posts()
    {
        $posts = Post::All();
        return view('Posts.Index', ['posts' => $posts]);
    }

    public function posts_create()
    {
        return view('Posts.Create');
    }
}
