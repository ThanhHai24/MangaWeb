<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Comment;
use App\Models\Manga;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $mangas = Manga::all();
        $chapters = Chapter::all();
        $manga_count = $mangas->count();
        $views = $mangas->sum('views') + $chapters->sum('views');
        $user_count = User::count();
        $comment_count = Comment::count();
        $updatedMangas = Manga::orderBy('created_at', 'desc')->take(5) -> get();
        return view('Admin.home',[
            'manga_count'=> $manga_count,
            'views'=> $views,
            'user_count'=> $user_count,
            'comment_count'=> $comment_count,
            'updatedMangas'=> $updatedMangas
        ]);
    }
}
