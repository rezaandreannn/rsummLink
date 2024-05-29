<?php

use App\Http\Controllers\SatuSehat\DashboardController;
use Illuminate\Support\Facades\Route;

// dashboard 
Route::prefix('satusehat')->middleware('checkrole:user')->group(function () {
    Route::get('satusehatrole', [DashboardController::class, 'index'])->name('satusehat.dashboard');
});
