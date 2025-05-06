<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Manga;
use Illuminate\Http\Request;

class MangaController extends Controller
{
    public function allMangas(){
        $categories = Category::all();
        $mangas = Manga::all();
        return view("Admin.mangas",[
            "mangas"=> $mangas,
            "categories"=> $categories
        ] );
    }
    public function insertManga(Request $request){
        $manga = Manga::create([
            "title"=> $request->title,
            "description" => $request->description,
            "cover_image" => $request->cover_image,
            "author" => $request->author,
            "status" => $request->status,
            "user_id" => 1,
        ]);
        $manga->categories()->attach($request->category);
        return redirect()->route("mangas")->with("success","");
    }

}
