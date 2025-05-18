<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Chapter;
use App\Models\Comment;
use App\Models\Manga;
use App\Models\ReadingHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReadingController extends Controller
{
    public function show($mangaSlug, $chapter_slug)
    {
        // Tìm manga theo slug
        $manga = Manga::where('slug', $mangaSlug)->firstOrFail();
        
        // Tìm chapter theo manga_id và chapter_number
        $chapters = Chapter::where('manga_id', $manga->id)->orderBy('chapter_number', 'asc')->get();
        $chapter = Chapter::where('manga_id', $manga->id)->where('slug', $chapter_slug)->firstOrFail();
        $chapter->increment('views');
        
        $categories = Category::all();
        $lastChapter = $chapters->last();
        $comments = Comment::with(['user', 'replies', 'replies.user'])
        ->where('commentable_type', 'App\Models\Chapter')
        ->where('commentable_id', $manga->id)
        ->whereNull('parent_id')
        ->orderBy('created_at', 'desc')
        ->get();
        // Nếu người dùng đã đăng nhập, lưu hoặc cập nhật lịch sử đọc
        if (Auth::check()) {
            $user = Auth::user();
            
            // Tìm xem người dùng đã có lịch sử đọc manga này chưa
            $readingHistory = ReadingHistory::where('user_id', $user->id)
                                           ->where('manga_id', $manga->id)
                                           ->first();
                                           
            if ($readingHistory) {
                // Nếu đã có lịch sử đọc, cập nhật chapter_id
                $readingHistory->update([
                    'chapter_id' => $chapter->id
                ]);
            } else {
                // Nếu chưa có lịch sử đọc, tạo mới
                ReadingHistory::create([
                    'user_id' => $user->id,
                    'manga_id' => $manga->id,
                    'chapter_id' => $chapter->id
                ]);
            }
        }
        
        // Truyền dữ liệu sang view
        return view('frontend.reading', [
            'manga' => $manga,
            'chapter' => $chapter,
            'chapters' => $chapters,
            'lastChapter'=> $lastChapter,
            'categories'=> $categories,
            'comments'=> $comments
        ]);
    }
}
