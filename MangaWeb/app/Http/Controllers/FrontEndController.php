<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Chapter;
use App\Models\Manga;
use Illuminate\Http\Request;

class FrontEndController extends Controller
{
    public function index()
    {   
        $categories = Category::all();
        $mangas = Manga::all();
        $updatedMangas = Manga::orderBy('created_at', 'desc')
        ->take(5)
        ->with(['chapters' => function ($query) {
            $query->orderBy('chapter_number', 'desc')->take(3);
        }])
        ->get();
        return view('Frontend.home',[
            'mangas' => $mangas,
            'updatedMangas'=> $updatedMangas,
            'categories' => $categories,
        ]);
    }

    public function showManga($slug)
    {
        $manga = Manga::where('slug', $slug)->firstOrFail();
        $chapters = Chapter::where('manga_id', $manga->id)->orderBy('chapter_number', 'asc')->get();
        $manga->increment('views');
        $categories = Category::all();
        return view('Frontend.detail', [
            'manga' => $manga,
            'chapters' => $chapters,
            'categories'=> $categories
        ]);
    }

    public function reading($slug, $chapter_slug)
    {
        $manga = Manga::where('slug', $slug)->firstOrFail();
        $chapters = Chapter::where('manga_id', $manga->id)->orderBy('chapter_number', 'asc')->get();
        $chapter = Chapter::where('manga_id', $manga->id)->where('slug', $chapter_slug)->firstOrFail();
        $chapter->increment('views');
        $categories = Category::all();
        $lastChapter = $chapters->last();
        return view('Frontend.reading', [
            'manga' => $manga,
            'chapter' => $chapter,
            'chapters' => $chapters,
            'lastChapter'=> $lastChapter,
            'categories'=> $categories
        ]);
    }

    public function showbyCategory($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $mangas = $category->mangas()->get();
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
        $mangas = Manga::where('title', 'LIKE', "%$search%")->get();
        $categories = Category::all();
        return view('Frontend.search', [
            'mangas' => $mangas,
            'categories'=> $categories
        ]);
    }
}
