<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\Admin\MemberController;
use App\Http\Controllers\Admin\LendController;
use App\Http\Controllers\Admin\AdminSettingsController;

Route::get('/', function () {
    return redirect('/login');
});

// Route for authentication
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Routes that require authentication
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/borrow/{book}', [BorrowController::class, 'borrow'])->name('borrow');
    Route::post('/return/{borrowing}', [BorrowController::class, 'returnBook'])->name('return');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/borrowings', [BorrowController::class, 'myBorrowings'])->name('borrowings.index');

    Route::prefix('admin')->group(function () {
        Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::resource('books', BookController::class)->names('admin.books');
        
        // Member routes
        Route::get('members', [MemberController::class, 'index'])->name('admin.members.index');
        Route::post('members', [MemberController::class, 'store'])->name('admin.members.store');
        Route::put('members/{member}', [MemberController::class, 'update'])->name('admin.members.update');
        Route::delete('members/{member}', [MemberController::class, 'destroy'])->name('admin.members.destroy');
        
        // Lend routes
        Route::get('lend', [LendController::class, 'index'])->name('admin.lend.index');
        Route::post('lend/find-member', [LendController::class, 'findMember'])->name('admin.lend.findMember');
        Route::post('lend', [LendController::class, 'store'])->name('admin.lend.store');
        
        Route::get('borrowings', [AdminController::class, 'borrowings'])->name('admin.borrowings.index');
        Route::post('borrowings/{borrowing}/return', [AdminController::class, 'returnBook']);
        
        // Admin Settings routes
        Route::get('settings', [AdminSettingsController::class, 'index'])->name('admin.settings.index');
        Route::put('settings', [AdminSettingsController::class, 'update'])->name('admin.settings.update');
    });
});
