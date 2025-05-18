<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Chapter;
use App\Models\Comment;
use App\Models\Manga;
use App\Models\ReadingHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontEndController extends Controller
{
    public function index()
    {   
        $categories = Category::all();
        $mangas = Manga::paginate(20);
        $top20 = Manga::orderBy('views', 'desc')
              ->limit(20)
              ->get();
        $recommendeds = $top20->shuffle()->take(10);
        $updatedMangas = Manga::orderBy('created_at', 'desc')
        ->take(5)
        ->with(['chapters' => function ($query) {
            $query->orderBy('chapter_number', 'desc')->take(3);
        }])
        ->get();
        $finishedMangas = Manga::where('status', 'Hoàn Thành')->inRandomOrder()->take(10)->get();
        $userId = Auth::id();

        $historymangas = ReadingHistory::with('manga') // eager load để tránh N+1 query
            ->where('user_id', $userId)
            ->get()
            ->pluck('manga') // lấy danh sách các đối tượng Manga
            ->unique('id')   // lọc ra các manga không trùng
            ->values();

        return view('Frontend.home',[
            'mangas' => $mangas,
            'updatedMangas'=> $updatedMangas,
            'categories' => $categories,
            'recommendeds'=> $recommendeds,
            'finishedMangas'=> $finishedMangas,
            'historymangas'=> $historymangas,
        ]);
    }

    public function showManga($slug)
    {
        $manga = Manga::where('slug', $slug)->firstOrFail();
        $chapters = Chapter::where('manga_id', $manga->id)->orderBy('chapter_number', 'asc')->get();
        $manga->increment('views');
        $categories = Category::all();
        $comments = Comment::with(['user', 'replies', 'replies.user'])
        ->where('commentable_type', 'App\Models\Manga')
        ->where('commentable_id', $manga->id)
        ->whereNull('parent_id')
        ->orderBy('created_at', 'desc')
        ->get();
        return view('Frontend.detail', [
            'manga' => $manga,
            'chapters' => $chapters,
            'categories'=> $categories,
            'comments'=> $comments,
        ]);
    }

    public function showbyCategory($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $mangas = $category->mangas()->paginate(20);
        $categories = Category::all();
        return view('Frontend.genre', [
            'mangas' => $mangas,
            'category' => $category,
            'categories'=> $categories
        ]);
    }

    public function search(Request $request)
    {
        $search = $request->search;
        $mangas = Manga::where('title', 'LIKE', "%$search%")->paginate(20);
        $categories = Category::all();
        return view('Frontend.search', [
            'mangas' => $mangas,
            'categories'=> $categories
        ]);
    }

    public function listall(Request $request)
    {
        $categories = Category::all();
        
        // Lấy tham số sắp xếp từ request
        $sort = $request->query('sort', 'newest');
        
        // Query builder cho manga
        $query = Manga::query();
        
        // Áp dụng logic sắp xếp
        switch ($sort) {
            case 'most-viewed':
                $query->orderBy('views', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        
        $mangas = $query->paginate(30)->withQueryString();
        
        return view('Frontend.list', [
            'mangas' => $mangas,
            'categories' => $categories,
            'title' => 'Danh Sách Truyện',
            'currentSort' => $sort
        ]);
    }

    public function news()
    {
        $categories = Category::all();
        $mangas = Manga::orderBy('created_at', 'desc')->paginate(30);
        return view('Frontend.list', [
            'mangas' => $mangas,
            'categories'=> $categories,
            'title' => 'Truyện mới'
        ]);
    }

    public function finished()
    {
        $categories = Category::all();
        $mangas = Manga::where('status', 'Hoàn Thành')->paginate(30);
        return view('Frontend.list', [
            'mangas' => $mangas,
            'categories'=> $categories,
            'title' => 'Truyện đã hoàn thành'
        ]);
    }

    public function hot()
    {
        $categories = Category::all();
        $mangas = Manga::where('is_featured', true)->paginate(30);
        return view('Frontend.list', [
            'mangas' => $mangas,
            'categories'=> $categories,
            'title' => 'Truyện Hot'
        ]);
    }

    public function showProfile()
    {
        $categories = Category::all();
        $user = auth()->user();
        return view('Frontend.auth.profile', [
            'categories'=> $categories,
            'user' => $user
        ]);
    }

    public function updateProfile(Request $request)
    {
        $categories = Category::all();
        $user = User::find(auth()->user()->id);
        $user->displayname = $request->displayname;
        $user -> save();
        return view('Frontend.auth.profile', [
            'categories'=> $categories,
            'user'=> $user
        ]);
    }
    
}
