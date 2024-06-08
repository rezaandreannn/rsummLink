<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\SubmenuController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('home');
// });
Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::get('/app', function () {
    return view('layouts.app');
});

Route::get('/register', function () {
    return view('auth.register');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// manajemen user 
Route::prefix('manage-user')->middleware('auth')->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('menu', MenuController::class);
    Route::post('submenu', [SubmenuController::class, 'store'])->name('submenu.store');
    Route::put('submenu/{id}', [SubmenuController::class, 'update'])->name('submenu.update');
    Route::delete('submenu/{id}', [SubmenuController::class, 'destroy'])->name('submenu.destroy');
    Route::get('/getPermissionsByApplicationId/{id}', [MenuController::class, 'getPermissionByApplicationId'])->name('permissions.get');
    Route::resource('permission', PermissionController::class)->except(['show', 'edit', 'create']);
    Route::resource('role', RoleController::class)->except(['show', 'edit', 'create']);
    Route::get('/role-permission', RolePermissionController::class)->name('role.permission.manage');
});



Route::prefix('v-claimbpjs')->middleware('checkrole:user')->group(function () {
    Route::get('vclaim', [TestController::class, 'index'])->name('v-claimbpjs.dashboard');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/satusehat.php';
