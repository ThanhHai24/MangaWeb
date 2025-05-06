<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Chapter;
use App\Models\Manga;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    public function showChapters($slug){
        $manga = Manga::where('slug', $slug)->firstOrFail();
        $chapters = Chapter::where('manga_id', $manga->id)->get();
        return view("Admin.chapters",[
            "manga"=> $manga,
            "chapters"=> $chapters,
        ]);
    }
    public function addChapter(Request $request){
        $chapter = new Chapter;
        $chapter -> manga_id = $request->manga_id;
        $chapter->title = $request->title;
        $chapter->chapter_number = $request->chapter_number;
        $chapter_images = implode("*", $request->images);
        $chapter ->images= $chapter_images;
        $chapter->save();
        return redirect()->back()->with("success","");
    }

    
}
