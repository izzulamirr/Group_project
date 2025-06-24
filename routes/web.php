<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DonatorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegistrationController;



// Home and dashboard
Route::get('/', function () {
    return view('homepage');
})->name('homepage');

Route::get('/home', function () {
    return view('transactions.homepage');
})->name('dashhome');

Route::get('/dashboard', function () {
    return view('Organization.dashboard');
})->name('Orgdashboard');

Route::get('/thank', function () {
    return view('transactions.thank');
})->name('transaction.thank');



// --------------------
// ADMIN-ONLY ROUTES
// --------------------
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/user/{user}/organizations', [AdminController::class, 'userOrganizations'])->name('admin.user.organizations');
    Route::get('/admin/user/{user}/permissions', [AdminController::class, 'editPermissions'])->name('admin.user.permissions');
    Route::post('/admin/user/{user}/permissions', [AdminController::class, 'updatePermissions'])->name('admin.user.permissions.update');
    Route::get('/admin/user/create', [AdminController::class, 'createUser'])->name('admin.user.create');
    Route::post('/admin/user/store', [AdminController::class, 'storeUser'])->name('admin.user.store');
    Route::delete('/admin/user/{userId}', [AdminController::class, 'deleteUser'])->name('admin.user.delete');
});

// --------------------
// AUTHENTICATED USER ROUTES
// --------------------
Route::middleware('auth')->group(function () {
    // Organization management
    Route::get('/organizations/my', [OrganizationController::class, 'index'])->name('organizations.my');
    Route::get('/organizations/create', [OrganizationController::class, 'create'])->name('organizations.create');
    Route::post('/organizations', [OrganizationController::class, 'store'])->name('organizations.store');
    Route::get('/organizations/{organization}/edit', [OrganizationController::class, 'edit'])->name('organizations.edit');
    Route::put('/organizations/{organization}', [OrganizationController::class, 'update'])->name('organizations.update');
    Route::delete('/organizations/{organization}', [OrganizationController::class, 'destroy'])->name('organizations.destroy');

    // Profile management
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    //Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// --------------------
// PERMISSION-BASED ROUTES
// --------------------
Route::middleware(['auth', 'permission:Create Organization', 'permission:Create Transaction'])->group(function () {
    Route::get('/organization/create', [OrganizationController::class, 'create'])->name('organization.create');
    Route::post('/organization', [OrganizationController::class, 'store'])->name('organization.store');
    Route::get('/transaction/create', [TransactionController::class, 'create'])->name('transaction.create');
    Route::post('/transaction', [TransactionController::class, 'store'])->name('transaction.store');
});

// --------------------
// PUBLIC ROUTES
// --------------------
Route::get('/organizations', [OrganizationController::class, 'index'])->name('organizations.index');
Route::get('/organizations/{organization}/transactions', [OrganizationController::class, 'transactions'])->name('organizations.transactions');

Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::post('register', [RegistrationController::class, 'register'])->name('register');

Route::get('/donate', [DonatorController::class, 'donateForm'])->name('transaction.donate');
Route::post('/donate', [DonatorController::class, 'donate'])->name('transaction.donate.submit');

Route::get('organizations/{organization}/transactions', [TransactionController::class, 'index'])->name('organizations.transactions');
Route::get('organizations/{organization}/transactions/create', [TransactionController::class, 'create'])->name('organizations.transactions.create');
Route::post('organizations/{organization}/transactions', [TransactionController::class, 'store'])->name('organizations.transactions.store');
Route::get('/organizations/{organization}/transactions/{transaction}/edit', [App\Http\Controllers\TransactionController::class, 'edit'])->name('organizations.transactions.edit');
Route::put('organizations/{organization}/transactions/{transaction}', [TransactionController::class, 'update'])->name('organizations.transactions.update');
Route::delete('organizations/{organization}/transactions/{transaction}', [TransactionController::class, 'destroy'])->name('organizations.transactions.destroy');