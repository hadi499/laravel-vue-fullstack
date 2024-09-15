<?php

use Inertia\Inertia;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AvatarController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('adminUser:admin');
    Route::post('/dashboard', [DashboardController::class, 'store'])->name('dashboard.store');
    Route::get('/test', [DashboardController::class, 'test'])->name('test');
    Route::post('/test', [DashboardController::class, 'storeTest'])->name('test.store');
    Route::put('/dashboard/{category:slug}/edit', [DashboardController::class, 'update'])->name('dashboard.update');
    Route::delete('/dashboard/{category:id}', [DashboardController::class, 'destroy'])->name('dashboard.destroy');

    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts/create', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post:slug}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post:slug}/edit', [PostController::class, 'update'])->name('posts.update');
    Route::get('/posts/{post:slug}', [PostController::class, 'show'])->name('posts.show');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    Route::get('/categories/{category:slug}', [CategoryController::class, 'categories'])->name('categories');



    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('/profile', [AvatarController::class, 'update'])->name('avatar.update');
});

require __DIR__ . '/auth.php';
