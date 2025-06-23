<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DonatorController;
use App\Http\Controllers\ProfileController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home and dashboard
Route::get('/', function () {
    return view('homepage');
})->name('homepage');
Route::get('/home', function () {
    return view('transactions.homepage');
})->name('dashhome');
Route::get('/home', function () {
    return view('Organization.dashhome');
})->name('thome');

Route::get('/login', function () {
    return view('auth.login'); // or your login view path
})->name('login');

Route::get('/thank', function () {
    return view('transactions.thank');
})->name('transaction.thank');

Route::get('/profile/edit', function () {
    return view('profile.edit');
})->name('profile.edit');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/dashhome', function () {
    return view('dashhome'); // Replace 'dashhome' with the name of your Blade view file
})->name('dashhome');

// Organization management routes (only for logged-in users)
Route::middleware('auth')->group(function () {
    Route::get('/organizations/my', [OrganizationController::class, 'index'])->name('organizations.my');
    Route::get('/organizations/create', [OrganizationController::class, 'create'])->name('organizations.create');
    Route::post('/organizations', [OrganizationController::class, 'store'])->name('organizations.store');
    Route::get('/organizations/{organization}/edit', [OrganizationController::class, 'edit'])->name('organizations.edit');
    Route::put('/organizations/{organization}', [OrganizationController::class, 'update'])->name('organizations.update');
    Route::delete('/organizations/{organization}', [OrganizationController::class, 'destroy'])->name('organizations.destroy');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Show all organizations (for donation listing)
Route::get('/organizations', [OrganizationController::class, 'index'])->name('organizations.index');
Route::get('/organizations/{organization}/transactions', [OrganizationController::class, 'transactions'])->name('organizations.transactions');
// Auth routes
Route::post('login', [AuthController::class, 'loginWithEmail'])->name('login');
Route::post('register', [AuthController::class, 'registerWithEmail'])->name('register');
Route::post('transaction/logout', [AuthController::class, 'logout'])->name('transaction.logout');


Route::get('/donate', [DonatorController::class, 'donateForm'])->name('transaction.donate');
Route::post('/donate', [DonatorController::class, 'donate'])->name('transaction.donate.submit');// (Optional) Remove or comment out old StatController/DonatorController routes if not needed


Route::get('organizations/{organization}/transactions', [TransactionController::class, 'index'])->name('organizations.transactions');
Route::get('organizations/{organization}/transactions/create', [TransactionController::class, 'create'])->name('organizations.transactions.create');
Route::post('organizations/{organization}/transactions', [TransactionController::class, 'store'])->name('organizations.transactions.store');
Route::get('organizations/{organization}/transactions/{transaction}/edit', [TransactionController::class, 'edit'])->name('organizations.transactions.edit');
Route::put('organizations/{organization}/transactions/{transaction}', [TransactionController::class, 'update'])->name('organizations.transactions.update');
Route::delete('organizations/{organization}/transactions/{transaction}', [TransactionController::class, 'destroy'])->name('organizations.transactions.destroy');



Route::get('/servertime', function () {
    return now();
});