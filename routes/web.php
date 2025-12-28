<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('/blog/{post}', [PostController::class, 'show'])->name('blog.show');

Route::get('/admin-login', function () {
    return redirect()->route('filament.admin.auth.login');
});


