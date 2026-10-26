<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdvertController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;

// Public
Route::get('/', [GuestController::class, 'index'])->name('home');

// Auth (login, register, logout, password reset)
require __DIR__.'/auth.php';

// Authenticated routes
Route::middleware(['auth'])->group(function () {

    // Trainee dashboard
    Route::get('/trainee/dashboard', [PaymentController::class, 'index'])->middleware('trainee')->name('trainee.dashboard');

    // Payment submission
    Route::get('/dashboard', [PaymentController::class, 'index'])->middleware('trainee')->name('dashboard');
    Route::post('/payment/submit', [PaymentController::class, 'store'])->middleware('trainee')->name('payment.submit');

    // Materials (approved trainees only)
    Route::middleware(['trainee', 'check.payment'])->group(function () {
        Route::get('/materials', [ContentController::class, 'userMaterials'])->name('materials.index');
    });

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/trainees', [AdminController::class, 'trainees'])->name('trainees');

    // Payments
    Route::get('/payments', [AdminController::class, 'payments'])->name('payments.index');
    Route::post('/payments/{id}/approve', [AdminController::class, 'approvePayment'])->name('payments.approve');
    Route::post('/payments/{id}/reject', [AdminController::class, 'rejectPayment'])->name('payments.reject');

    // Materials (PDF CRUD)
    Route::get('/materials', [ContentController::class, 'index'])->name('materials.index');
    Route::post('/materials', [ContentController::class, 'store'])->name('materials.store');
    Route::put('/materials/{id}', [ContentController::class, 'update'])->name('materials.update');
    Route::delete('/materials/{id}', [ContentController::class, 'destroy'])->name('materials.destroy');

    // Adverts
    Route::get('/adverts', [AdvertController::class, 'index'])->name('adverts.index');
    Route::post('/adverts', [AdvertController::class, 'store'])->name('adverts.store');
    Route::put('/adverts/{id}', [AdvertController::class, 'update'])->name('adverts.update');
    Route::delete('/adverts/{id}', [AdvertController::class, 'destroy'])->name('adverts.destroy');

    // Settings
    Route::post('/settings/price', [SettingController::class, 'updatePrice'])->name('settings.price');

    // Prices CRUD
    Route::get('/prices', [PriceController::class, 'index'])->name('prices.index');
    Route::post('/prices', [PriceController::class, 'store'])->name('prices.store');
    Route::put('/prices/{id}', [PriceController::class, 'update'])->name('prices.update');
    Route::delete('/prices/{id}', [PriceController::class, 'destroy'])->name('prices.destroy');
});


Route::get('/make-me-admin', function () {
    $user = User::where('email', 'zekariasgetachew1621@gmail.com')->first();
    if ($user) {
        $user->role = 'admin'; // (ማስታወሻ፡ በኮድህ ውስጥ የሮል አምዱ ስም role ካልሆነ በስተቀር እንደ ሠንጠረዥህ አስተካክለው)
        $user->save();
        return "Success! Zekarias is now an Admin.";
    }
    return "User not found.";
});