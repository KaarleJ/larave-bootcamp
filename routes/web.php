<?php

use App\Http\Controllers\ChirpController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\SocialAuthController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }

    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::get('/search', [SearchController::class, 'index'])->name('search.index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/request-delete', [ProfileController::class, 'requestDelete'])->name('profile.requestDelete');
});

Route::get('/profile/confirm-delete/{userId}', [ProfileController::class, 'confirmDelete'])->middleware('signed')->name('profile.confirmDelete');

Route::get('/auth/redirect/{provider}', [SocialAuthController::class, 'redirect']);
Route::get('/auth/callback/{provider}', [SocialAuthController::class, 'callback']);


Route::resource('chirps', ChirpController::class)
    ->only(['index', 'store', 'update', 'destroy'])
    ->middleware(['auth', 'verified']);

require __DIR__ . '/auth.php';
