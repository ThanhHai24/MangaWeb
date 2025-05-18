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
        if($request -> images == null){
            $chapter ->images= null;
        }else{
            $chapter_images = implode("*", $request->images);
            $chapter ->images= $chapter_images;
        }
        
        $chapter->save();
        return redirect()->back()->with("success","");
    }

    public function getChapterImages($id)
    {
        $chapter = Chapter::findOrFail($id);
        $images = [];
        
        if ($chapter->images) {
            // If images are stored as JSON array in database
            if (is_array($chapter->images)) {
                $images = $chapter->images;
            } 
            // If images are stored as string with separator
            else if (is_string($chapter->images)) {
                $images = explode("*", $chapter->images);
            }
        }
        
        return response()->json([
            'success' => true,
            'images' => $images
        ]);
    }
    
    public function updateChapter(Request $request, $id)
    {
        $chapter = Chapter::findOrFail($id);
        
        $chapter->title = $request->title;
        $chapter->chapter_number = $request->chapter_number;
        
        // Handle image updates if new images are provided
        if ($request->hasFile('images')) {
            $imageUrls = [];
            foreach ($request->file('images') as $file) {
                $path = $file->store('chapter-images', 'public');
                $imageUrls[] = Storage::url($path);
            }
            
            // If existing images are found, append new ones
            if (!empty($chapter->images)) {
                $existingImages = is_array($chapter->images) ? $chapter->images : explode("*", $chapter->images);
                $allImages = array_merge($existingImages, $imageUrls);
                $chapter->images = implode("*", $allImages);
            } else {
                $chapter->images = implode("*", $imageUrls);
            }
        }
        
        $chapter->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Chapter updated successfully',
            'chapter' => $chapter
        ]);
    }
    
    public function removeImage(Request $request, $id)
    {
        $chapter = Chapter::findOrFail($id);
        $imageToRemove = $request->input('image_url');
        
        if (empty($chapter->images)) {
            return response()->json([
                'success' => false,
                'message' => 'No images found'
            ]);
        }
        
        // Get current images
        $currentImages = is_array($chapter->images) ? $chapter->images : explode("*", $chapter->images);
        
        // Remove the specified image
        $updatedImages = array_filter($currentImages, function($img) use ($imageToRemove) {
            return $img !== $imageToRemove;
        });
        
        // Update the chapter
        $chapter->images = !empty($updatedImages) ? implode("*", $updatedImages) : null;
        $chapter->save();
        
        // Optionally delete the actual file from storage
        // This depends on how your image paths are stored
        // $relativePath = str_replace('/storage/', '', $imageToRemove);
        // Storage::disk('public')->delete($relativePath);
        
        return response()->json([
            'success' => true,
            'message' => 'Image removed successfully'
        ]);
    }
    
    public function deleteChapter($id)
    {
        $chapter = Chapter::findOrFail($id);
        
        // Optional: Delete associated image files
        if (!empty($chapter->images)) {
            $images = is_array($chapter->images) ? $chapter->images : explode("*", $chapter->images);
            foreach ($images as $image) {
                // Delete the actual file if needed
                // $relativePath = str_replace('/storage/', '', $image);
                // Storage::disk('public')->delete($relativePath);
            }
        }
        
        $chapter->forceDelete();
        
        return response()->json([
            'success' => true,
            'message' => 'Chapter deleted successfully'
        ]);
    }
}
