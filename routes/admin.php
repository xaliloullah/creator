<?php

use App\Http\Controllers\RouteController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TarifController;
use App\Http\Controllers\Admin\AccessController;
use App\Http\Controllers\Admin\ModuleController;
use App\Http\Controllers\Admin\SettingController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'mode', 'verified', 'role:admin', 'password.confirm'])->prefix('dashboard')->group(function () {
    Route::resource('users', UserController::class)->middleware('permission:users');
    Route::resource('modules', ModuleController::class)->middleware('permission:modules');
    Route::resource('tarifs', TarifController::class)->middleware('permission:tarifs');
    Route::resource('access', AccessController::class)->middleware('permission:access');
    Route::get('settings/update', [SettingController::class, 'update'])->name('settings.update');
    Route::get('docs', [RouteController::class, 'docs'])->name('docs')->middleware('permission:documentations');
    Route::get('test', [RouteController::class, 'test'])->name('test');

    Route::prefix('access')->group(function () {
        Route::post('/roles/create', [AccessController::class, 'create_role'])->name('roles.create');
        Route::get('/roles/edit/{id}', [AccessController::class, 'edit_role'])->name('roles.edit');
        Route::put('/roles/update/{id}', [AccessController::class, 'update_role'])->name('roles.update');
        Route::delete('/roles/delete/{id}', [AccessController::class, 'delete_role'])->name('roles.delete');
        Route::post('/roles/assign', [AccessController::class, 'assign_role'])->name('roles.assign');
        Route::post('/roles/remove', [AccessController::class, 'remove_role'])->name('roles.remove');

        Route::post('/permissions/create', [AccessController::class, 'create_permission'])->name('permissions.create');
        Route::get('/permissions/edit/{id}', [AccessController::class, 'edit_permission'])->name('permissions.edit');
        Route::put('/permissions/update/{id}', [AccessController::class, 'update_permission'])->name('permissions.update');
        Route::delete('/permissions/delete/{id}', [AccessController::class, 'delete_permission'])->name('permissions.delete');
        Route::post('/permissions/assign', [AccessController::class, 'assign_permission'])->name('permissions.assign');
        Route::post('/permissions/remove', [AccessController::class, 'remove_permission'])->name('permissions.remove');
    });

    Route::controller(TarifController::class)->group(function () {
        Route::get('tarifs-statut', 'statut')->name('tarifs.statut');
    });
});
