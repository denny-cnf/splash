<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//Route::get('/print-products', function () {
//    return view('print-products');
//})->middleware(['auth', 'verified'])->name('print-products');

Route::get('/print-products', [App\Livewire\PrintProducts\Index::class, 'render'])->middleware(['auth', 'verified'])->name('print-products');

Route::get('/paper-formats', [App\Livewire\PaperFormats\Index::class, 'render'])->middleware(['auth', 'verified'])->name('paper-formats.index');
Route::get('/paper-type', [App\Livewire\PaperType\Index::class, 'render'])->middleware(['auth', 'verified'])->name('paper-type.index');
Route::get('/color-modes', [App\Livewire\ColorModes\Index::class, 'render'])->middleware(['auth', 'verified'])->name('color-modes.index');
Route::get('/machines', [App\Livewire\Machines\Index::class, 'render'])->middleware(['auth', 'verified'])->name('machines.index');
Route::get('/consumables', [App\Livewire\Consumables\Index::class, 'render'])->middleware(['auth', 'verified'])->name('consumables.index');




Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
