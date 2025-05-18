<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Chapter;
use App\Models\Manga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
            "is_featured" => $request->has('hot'),
            "user_id" => Auth::user()->id,
        ]);
        $manga->categories()->attach($request->category);
        return redirect()->route("mangas")->with("success","");
    }

    // Add these new methods for edit functionality
    public function editManga($slug)
    {
        $manga = Manga::where('slug', $slug)->with('categories')->first();
        
        if (!$manga) {
            return response()->json(['success' => false, 'message' => 'Manga not found'], 404);
        }
        
        return response()->json([
            'success' => true,
            'manga' => $manga
        ]);
    }
    
    public function updateManga(Request $request, $slug)
    {
        $manga = Manga::where('slug', $slug)->first();
        
        if (!$manga) {
            return redirect()->route('mangas')->with('error', 'Manga not found');
        }
        
        $manga->title = $request->title;
        // Check if title changed, if so update slug
        // if ($manga->title != $request->title) {
        //     $manga->slug = Str::slug($request->title);
        // }
        $manga->description = $request->description;
        $manga->author = $request->author;
        $manga->status = $request->status;
        $manga->is_featured = $request->has('hot');
        
        // Only update cover image if a new one is provided
        if ($request->cover_image) {
            $manga->cover_image = $request->cover_image;
        }
        
        $manga->save();
        
        // Update categories
        if ($request->has('category')) {
            $manga->categories()->sync($request->category);
        }
        
        return redirect()->route('mangas')->with('success', 'Manga updated successfully');
    }

    public function deleteManga($slug)
    {
        try {
            // Find the manga by slug
            $manga = Manga::where('slug', $slug)->first();
            
            if (!$manga) {
                return response()->json([
                    'success' => false,
                    'message' => 'Manga not found'
                ], 404);
            }
            
            // Delete manga's relationships first
            // This would include detaching categories
            $manga->categories()->detach();
            
            // You may need to delete chapters if they have a foreign key constraint
            $manga->chapters()->delete();
            
            // Then delete the manga itself
            $manga->forceDelete();
            
            return response()->json([
                'success' => true,
                'message' => 'Manga deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting manga: ' . $e->getMessage()
            ], 500);
        }
    }

    public function search(Request $request)
    {
        $search = $request->search;
        $categories = Category::all();
        $mangas = Manga::where('title', 'LIKE', "%$search%")->get();
        return view('admin.mangas', [
            'mangas'=> $mangas,
            'categories'=> $categories
        ]);
    }

}
