<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PackageBankController;
use App\Http\Controllers\PackageTourController;
use App\Http\Controllers\PackageBookingController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('can: checkout package')->group(function(){
        Route::get('book/{packageTour:slug}', [FrontController::class, 'book'])->name('book');
        Route::post('book/{packageTour:slug}', [FrontController::class, 'book_store'])->name('book.store');

        Route::get('book/choose-bank/{packageBooking}/', [FrontController::class, 'choose_bank'])->name('choose.bank');
        Route::patch('book/choose-bank/{packageBooking}/save', [FrontController::class, 'choose_bank_store'])->name('choose.bank.store');

        Route::get('book/payment/{packageBooking}/save', [FrontController::class, 'book_payment'])->name('book.payment');
        Route::patch('book/payment/{packageBooking}/save', [FrontController::class, 'book_payment_store'])->name('book.payment.store');

        Route::patch('book-finish', [FrontController::class, 'book_finish'])->name('book.finish');
    });
    Route::prefix('admin')->name('admin.')->group(function(){
        Route::middleware('can: manage categories')->group(function(){
            Route::resource('categories', CategoryController::class);
        });

        Route::middleware('can: manage packages')->group(function(){
            Route::resource('package_tours', PackageTourController::class);
        });

        Route::middleware('can: manage package banks')->group(function(){
            Route::resource('package_banks', PackageBankController::class);
        });

        Route::middleware('can: manage transactions')->group(function(){
            Route::resource('package_bookings', PackageBookingController::class);
        });
    });
});

require __DIR__.'/auth.php';
