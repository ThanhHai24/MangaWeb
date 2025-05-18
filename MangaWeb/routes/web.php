<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\MangaController;
use App\Http\Controllers\ReadingController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;

// Login Route
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'login'])->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Register Route
Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register')->middleware('guest');
Route::post('/register', [LoginController::class, 'register'])->middleware('guest');

// Forgot Password Route
Route::get('/forgot-password', [LoginController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [LoginController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [LoginController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [LoginController::class, 'resetPassword'])->name('password.update');


Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    
    // Manga Routes
    Route::get('/mangas', [MangaController::class, 'allMangas'])->name('mangas');
    Route::post('/mangas/insert', [MangaController::class,'insertManga']);
    Route::get('/mangas/{slug}/edit', [MangaController::class, 'editManga']);
    Route::put('/mangas/{slug}/update', [MangaController::class, 'updateManga']);
    Route::delete('/mangas/{slug}/delete', [MangaController::class, 'deleteManga']);
    Route::get('/mangas/search', [MangaController::class, 'search'])->name('manga-search');
    
    // Chapter Routes
    Route::get('/mangas/{slug}', [ChapterController::class,'showChapters'])->name('chapters');
    Route::post('/mangas/{slug}', [ChapterController::class,'addChapter']);
    Route::get('/chapters/{id}/images', [ChapterController::class, 'getChapterImages']);
    Route::put('/chapters/{id}/update', [ChapterController::class, 'updateChapter']);
    Route::delete('/chapters/{id}/delete', [ChapterController::class, 'deleteChapter']);
    Route::post('/chapters/{id}/remove-image', [ChapterController::class, 'removeImage']);
    
    // Category Routes
    Route::get('/categories', [CategoryController::class,'ShowAll']);
    Route::post('/categories/import', [CategoryController::class,'ImportCategory']);
    Route::get('/categories/edit/{id}', [CategoryController::class,'Show']);
    Route::post('/categories/update', [CategoryController::class,'UpdateCategory']);
    Route::delete('/categories/delete/{id}', [CategoryController::class,'DeleteCategory']);
    Route::get('/categories/search', [CategoryController::class, 'search'])->name('category-search');
    
    // Other Admin Routes
    Route::get('/users', [UserController::class,'showAllUser'])->name('users');
    Route::post('/users/add', [UserController::class,'add'])->name('add-user');
    Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::post('/users/{id}/update', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{id}/delete', [UserController::class, 'delete'])->name('users.delete');
    Route::get('/users/search', [UserController::class, 'search'])->name('user-search');



    Route::get('/comments', [CommentController::class, 'index']);
    Route::get('/settings', function () {
        return view('Admin.settings');
    });
    
    // Upload Routes
      
});

    Route::post('/upload', [UploadController::class, 'uploadImage'])->name('upload.image');
    Route::post('/uploads', [UploadController::class, 'uploadImages'])->name('upload.images');
    Route::post('/uploadavatar', [UploadController::class, 'uploadAvatar'])->name('upload.avatar');
// Logged Route
Route::middleware('auth')->group(function () {
    Route::get('/change-password', [LoginController::class, 'showChangePasswordForm'])->name('password.change.form');
    Route::post('/change-password', [LoginController::class, 'changePassword'])->name('password.change');
    Route::get('/profile', [FrontEndController::class, 'showProfile'])->name('profile');
    Route::post('/profile', [FrontEndController::class, 'updateProfile'])->name('updateprofile');
    Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Route xử lý toggle bookmark
    Route::post('/bookmarks/toggle', [BookmarkController::class, 'toggleBookmark'])->name('bookmarks.toggle');
    
    // Route hiển thị danh sách truyện đã bookmark
    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
});


Route::get('/', [FrontEndController::class,'index']) -> name('home');
Route::get('/search', [FrontEndController::class, 'search'])->name('search');
Route::get('/the-loai/{genre}', [FrontEndController::class,'showbyCategory']) -> name('genre');
Route::get('/list', [FrontEndController::class, 'listall'])->name('list');
Route::get('/newest', [FrontEndController::class, 'news'])->name('newest');
Route::get('/finished', [FrontEndController::class, 'finished'])->name('finished');
Route::get('/hot', [FrontEndController::class, 'hot'])->name('hot');
Route::get('/{slug}', [FrontEndController::class,'showManga']) -> name('detail');
Route::get('/{slug}/{chapter_slug}', [ReadingController::class,'show']) -> name('read');


