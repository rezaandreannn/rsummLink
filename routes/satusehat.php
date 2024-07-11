<?php

use App\Http\Controllers\SatuSehat\AntreanController;
use App\Models\Role;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\SatuSehat\DashboardController;
use App\Http\Controllers\SatuSehat\Map\EncounterController;
use App\Http\Controllers\SatuSehat\Master\DokterController;
use App\Http\Controllers\SatuSehat\Master\Icd10Controller;
use App\Http\Controllers\SatuSehat\Master\Icd9Controller;
use App\Http\Controllers\SatuSehat\Master\LocationController;
use App\Http\Controllers\SatuSehat\Master\OrganizationController;
use App\Http\Controllers\SatuSehat\Master\PasienController;
use App\Http\Controllers\SatuSehat\Master\RegisterPasienController;

// dashboard 
if (Schema::hasTable('roles')) {
    $roles = Role::where('application_id', 1)->pluck('name')->toArray();
    $rolesString = !empty($roles) ? implode(',', $roles) : '';

    Route::prefix('satu-sehat')->middleware(['checkrole:' . $rolesString])->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('satu-sehat.dashboard');
        Route::get('encounter', [EncounterController::class, 'index'])->name('encounter');
        Route::get('antrean', [AntreanController::class, 'index'])->name('antrean.index');

        Route::prefix('master')->group(function () {
            Route::get('register', [RegisterPasienController::class, 'index'])->name('register.index');
            Route::get('pasien', [PasienController::class, 'index'])->name('pasien.index');
            Route::get('register/search', [RegisterPasienController::class, 'search'])->name('register.search');
            Route::resource('icd9', Icd9Controller::class);
            Route::resource('icd10', Icd10Controller::class);

            // dokter
            Route::get('dokter', [DokterController::class, 'index'])->name('dokter.index');

            // location
            Route::get('location', [LocationController::class, 'index'])->name('location.index');
            Route::get('location/create', [LocationController::class, 'create'])->name('location.create');

            // organization
            Route::get('organization', [OrganizationController::class, 'index'])->name('organization.index');
            Route::get('organization/create', [OrganizationController::class, 'create'])->name('organization.create');
            Route::get('organization/{id}', [OrganizationController::class, 'show'])->name('organization.show');
            Route::get('organization/{id}/edit', [OrganizationController::class, 'edit'])->name('organization.edit');
            Route::post('organization', [OrganizationController::class, 'store'])->name('organization.store');
            Route::put('organization/{id}', [OrganizationController::class, 'update'])->name('organization.update');
        });

        Route::prefix('map')->group(function () {
            Route::get('encounter', [EncounterController::class, 'index'])->name('map.encounter.index');
        });
    });
}
