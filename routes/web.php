<?php

use App\Http\Controllers\PostDashboardController;
use App\Http\Controllers\ProfileController;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home', [
        'title' => 'Home page',
    ]);
});

Route::get('/posts', function () {
    $posts = Post::latest()
        ->filter(request(['search', 'category', 'author']))
        ->paginate(6)
        ->withQueryString();

    return view('posts', [
        'title' => 'Blog', 'posts' => $posts,
    ]);
});

Route::get('/posts/{post:slug}', function (Post $post) {
    return view('post', [
        'title' => 'Single Post',
        'post' => $post,
    ]);

});

Route::get('/about', function () {
    return view('about', [
        'title' => 'About',
    ]);
});

Route::get('/contact', function () {
    return view('contact', [
        'title' => 'Contact',
    ]);
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/dashboard', [PostDashboardController::class, 'index'])->middleware(['auth',
//     'verified'])->name('dashboard');

// Route::post('/dashboard', [PostDashboardController::class, 'store'])->middleware(['auth',
//     'verified'])->name('dashboard.store');

// Route::get('/dashboard/create', [PostDashboardController::class, 'create'])->middleware(['auth',
//     'verified']);

// Route::delete('/dashboard/{post:slug}', [PostDashboardController::class, 'destroy'])->middleware(['auth',
//     'verified']);

// Route::get('/dashboard/{post:slug}', [PostDashboardController::class, 'show'])->middleware(['auth',
//     'verified']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [PostDashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard', [PostDashboardController::class, 'store']);
    Route::get('/dashboard/create', [PostDashboardController::class, 'create']);
    Route::get('/dashboard/{post:slug}', [PostDashboardController::class, 'destroy']);
   Route::get('/dashboard/{post:slug}/edit', [PostDashboardController::class, 'edit']);
    Route::patch('/dashboard/{post:slug}', [PostDashboardController::class, 'update']);
    Route::get('/dashboard/{post:slug}', [PostDashboardController::class, 'show']);
});

// Route::middleware(['auth', 'verified'])->group(function () {
//     // Halaman utama dashboard
//     Route::get('/dashboard', [PostDashboardController::class, 'index'])->name('dashboard');

//     // Simpan data post baru (menyelesaikan error di form)
//     Route::post('/dashboard', [PostDashboardController::class, 'store'])->name('posts.store');

//     // Buka form tambah post (menyelesaikan error di tombol create)
//     Route::get('/dashboard/create', [PostDashboardController::class, 'create'])->name('posts.create');

//     // Lihat detail post spesifik
//     Route::get('/dashboard/{post:slug}', [PostDashboardController::class, 'show'])->name('posts.show');

//     // Buka form untuk mengedit post
// Route::get('/dashboard/{post:slug}/edit', [PostDashboardController::class, 'edit'])->name('posts.edit');

// // Simpan pembaruan data setelah diedit
// Route::put('/dashboard/{post:slug}', [PostDashboardController::class, 'update'])->name('posts.update');

//     // Hapus post
//     Route::delete('/dashboard/{post:slug}', [PostDashboardController::class, 'destroy'])->name('posts.destroy');
// });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
