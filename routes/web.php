<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

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

    Route::resource('tasks', TaskController::class);
    Route::patch('/tasks/{task}/toggle-completed', [TaskController::class, 'toggleCompleted'])->name('tasks.toggleCompleted');
    Route::get('/tasks/export/csv', [TaskController::class, 'exportCsv'])->name('tasks.export.csv');
    Route::get('/tasks/export/pdf', [TaskController::class, 'exportPdf'])->name('tasks.export.pdf');

});

require __DIR__.'/auth.php';
