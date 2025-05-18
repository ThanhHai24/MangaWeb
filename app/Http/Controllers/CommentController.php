<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
    {
        // Lấy danh sách comment
        $comments = Comment::all();
        return view('admin.comments', [
            'comments'=> $comments
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string',
            'commentable_id' => 'required|integer',
            'commentable_type' => 'required|string',
            'parent_id' => 'nullable|integer|exists:comments,id'
        ]);

        $comment = new Comment();
        $comment->content = $request->content;
        $comment->user_id = auth()->id(); // Người dùng hiện tại
        $comment->commentable_id = $request->commentable_id;
        $comment->commentable_type = $request->commentable_type;
        $comment->parent_id = $request->parent_id;
        $comment->save();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'comment' => $comment->load('user')
            ]);
        }

        return back()->with('success', 'Bình luận đã được thêm');
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);
        
        // Kiểm tra quyền xóa comment
        if (auth()->id() != $comment->user_id && !auth()->user()->isAdmin()) {
            return back()->with('error', 'Bạn không có quyền xóa bình luận này');
        }
        
        $comment->forceDelete();
        
        return back()->with('success', 'Bình luận đã được xóa');
    }
    
}
