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
    
}
