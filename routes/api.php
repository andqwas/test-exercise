<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('employees')->group(function () {
    Route::get('/', [EmployeeController::class, 'index'])->name('index');
    Route::post('/', [EmployeeController::class, 'store'])->name('store');
    Route::get('/{employee}', [EmployeeController::class, 'show'])->name('show');
    Route::put('/{employee}', [EmployeeController::class, 'update'])->name('update');
    Route::delete('/{employee}', [EmployeeController::class, 'destroy'])->name('destroy');
    Route::post('/{employee}/assign-role', [EmployeeController::class, 'assignRole'])->name('assign');
    Route::delete('/{employee}/unassign-role', [EmployeeController::class, 'unassignRole'])->name('unassign');
});

Route::prefix('tasks')->group(function () {
    Route::get('/grouped-by-status', [TaskController::class, 'groupedByStatus'])->name('grouped-by-status');
    Route::get('/', [TaskController::class, 'index'])->name('index');
    Route::post('/', [TaskController::class, 'store'])->name('store')->middleware('throttle:2,1');
    Route::get('/{task}', [TaskController::class, 'show'])->name('show');
    Route::put('/{task}', [TaskController::class, 'update'])->name('update');
    Route::delete('/{task}', [TaskController::class, 'destroy'])->name('destroy');
    Route::post('/{task}/assign', [TaskController::class, 'assign'])->name('assign');
    Route::delete('/{task}/unassign', [TaskController::class, 'unassign'])->name('unassign');
});

Route::prefix('notifications')->group(function () {
    Route::post('/', [NotificationController::class, 'index'])->name('index');
    Route::put('/{notification}/read', [NotificationController::class, 'markAsRead'])->name('markAsRead');
});
