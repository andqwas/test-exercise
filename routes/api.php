<?php

use App\Http\Controllers\EmployeeController;
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
    //Route::get('/{employee}/tasks', [EmployeeController::class, 'tasks'])->name('tasks');
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
    //Route::get('/{task}/employees', [TaskController::class, 'employees'])->name('employees');
});
