<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\MangaController;
use App\Http\Controllers\UploadController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;


// Admin Route
Route::get('/admin', function () {
     return view('Admin.home');
});
Route::get('admin/mangas', [MangaController::class,'allMangas']) -> name('mangas');
Route::post('admin/mangas/insert', [MangaController::class,'insertManga']);

Route::get('/admin/mangas/{slug}', [ChapterController::class,'showChapters'])->name('chapters');
Route::post('/admin/mangas/{slug}', [ChapterController::class,'addChapter']);

Route::get('admin/categories', [CategoryController::class,'ShowAll']);
Route::post('admin/categories/import', [CategoryController::class,'ImportCategory']);
Route::get('admin/categories/edit/{id}', [CategoryController::class,'Show']);
Route::post('admin/categories/update', [CategoryController::class,'UpdateCategory']);

Route::get('/admin/users', function () {
    return view('Admin.users');
});
Route::get('/admin/comments', function () {
    return view('Admin.comments');
});
Route::get('/admin/settings', function () {
    return view('Admin.settings');
});

//upload
route::post('/upload', [UploadController::class, 'uploadImage'])->name('upload.image');
route::post('/uploads', [UploadController::class, 'uploadImages']) -> name('');


Route::get('/', [FrontEndController::class,'index']) -> name('home');
Route::get('/search', [FrontEndController::class, 'search'])->name('search');
Route::get('/the-loai/{genre}', [FrontEndController::class,'showbyCategory']) -> name('genre');
Route::get('/{slug}', [FrontEndController::class,'showManga']) -> name('detail');
Route::get('/{slug}/{chapter_slug}', [FrontEndController::class,'reading']) -> name('read');


// Route cho authentication
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Route dành cho user thường
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    
    // Route dành cho admin
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');
    });
    
    // Route dành cho moderator
    Route::middleware('role:moderator')->group(function () {
        Route::get('/moderator/dashboard', function () {
            return view('moderator.dashboard');
        })->name('moderator.dashboard');
    });
});