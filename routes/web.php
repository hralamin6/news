<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\Passwords\Confirm;
use App\Http\Livewire\Auth\Passwords\Email;
use App\Http\Livewire\Auth\Passwords\Reset;
use App\Http\Livewire\Auth\Register;
use App\Http\Livewire\Auth\Verify;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/', \App\Http\Livewire\HomeComponent::class)->name('home');
Route::get('/category/{category}', \App\Http\Livewire\CategoryComponent::class)->name('category');
Route::get('/post/{post:id}', \App\Http\Livewire\PostComponent::class)->name('post');
Route::middleware('auth')->group(function () {

    Route::get('email/verify', Verify::class)->middleware('throttle:6,1')->name('verification.notice');
    Route::get('password/confirm', Confirm::class)->name('password.confirm');
    Route::get('email/verify/{id}/{hash}', EmailVerificationController::class)->middleware('signed')->name('verification.verify');
    Route::post('logout', LogoutController::class)->name('logout');
});

Route::middleware('guest')->group(function () {
    Route::get('login', Login::class)->name('login');
    Route::get('register', Register::class)->name('register');
});
Route::get('password/reset', Email::class)->name('password.request');
Route::get('password/reset/{token}', Reset::class)->name('password.reset');

Route::get('cmd/optimize', function () {Artisan::call('optimize');
    return "php artisan optimized successfully";
})->name('optimize');
Route::get('cmd/migrate', function () {Artisan::call('migrate');
    return "php artisan migrate successfully";
})->name('migrate');
Route::get('cmd/migrate-fresh', function () {Artisan::call('migrate:fresh --seed');
    return "php artisan migrate-fresh successfully";
})->name('migrate.fresh');
Route::get('cmd/migrate-rollback', function () {Artisan::call('migrate:rollback');
    return "php artisan migrate-rollback successfully";
})->name('migrate.rollback');
Route::get('cmd/db-seed', function () {Artisan::call('db:seed');
    return "php artisan db:seed successfully";
})->name('db.seed');
