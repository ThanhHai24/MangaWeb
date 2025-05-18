<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Bookmark;
use App\Models\Category;
use App\Models\Manga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    public function toggleBookmark(Request $request)
    {
        // Kiểm tra người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng đăng nhập để theo dõi truyện',
                'redirect' => route('login')
            ], 401);
        }

        $mangaId = $request->manga_id;
        $userId = Auth::id();

        // Tìm manga
        $manga = Manga::find($mangaId);
        if (!$manga) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy truyện',
            ], 404);
        }

        // Kiểm tra xem đã bookmark chưa
        $bookmark = Bookmark::where('user_id', $userId)
                            ->where('manga_id', $mangaId)
                            ->first();

        if ($bookmark) {
            // Đã bookmark rồi, xóa bookmark
            $bookmark->delete();
            return response()->json([
                'success' => true,
                'bookmarked' => false,
                'message' => 'Đã hủy theo dõi truyện',
            ]);
        } else {
            // Chưa bookmark, tạo mới
            Bookmark::create([
                'user_id' => $userId,
                'manga_id' => $mangaId
            ]);
            return response()->json([
                'success' => true,
                'bookmarked' => true,
                'message' => 'Đã theo dõi truyện thành công',
            ]);
        }
    }

    /**
     * Hiển thị danh sách manga đã bookmark của người dùng
     */
    public function index()
    {
        // Kiểm tra người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để xem truyện đã theo dõi');
        }
        $categories = Category::all();
        $bookmarks = Bookmark::with('manga')
                                ->where('user_id', Auth::id())
                                ->get();

        // Trích ra danh sách các manga từ bookmark
        $mangas = $bookmarks->map(function ($bookmark) {
            return $bookmark->manga;
        })->filter();

        return view('frontend.bookmark',[
            'title' => 'Danh sách truyện đã theo dõi',
            'categories'=> $categories,
            'mangas' => $mangas,

        ], compact('bookmarks'));
    }
}
