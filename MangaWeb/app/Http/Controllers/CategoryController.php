<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function ShowAll(){
        $categories = Category::all();
        return view("admin.categories",[
            "categories"=> $categories,
        ]);
    }
    public function ImportCategory(Request $request){
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        Category::create($validated);
        return redirect()->back();
    }
    public function Show($id){
        $category = Category::find($id);
        return view("admin.category.edit",[
            "category" => $category,
        ]);
    }

    public function UpdateCategory(Request $request){
        $category = Category::find($request->id);
        $category->name = $request->name;
        $category->description = $request->description;
        $category->save();
        return redirect('admin/categories')->with('success', 'Cập nhật thành công!');
    }
    
    public function DeleteCategory($id){
        try {
            $category = Category::findOrFail($id);
            
            // Detach this category from all mangas
            // This uses the existing relationship defined in your Category model
            $category->mangas()->detach();
            
            // Now delete the category
            $category->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Thể loại đã được xóa thành công và gỡ bỏ khỏi tất cả truyện.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa thể loại: ' . $e->getMessage()
            ], 500);
        }
    }

    public function search(Request $request)
    {
        $search = $request->search;
        $categories = Category::where('name', 'LIKE', "%$search%")->get();
        return view('admin.categories', [
            'categories'=> $categories
        ]);
    }
}
