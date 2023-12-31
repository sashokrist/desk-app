<?php

use App\Http\Controllers\DeskController;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//    Route::get('/desks/', [DeskController::class, 'index'])->name('desks.index');
//    Route::get('desks/{desk}/edit', [DeskController::class, 'edit'])->name('desks.edit');
//    Route::post('/desks/updatePosition', [DeskController::class, 'updatePosition'])->name('desks.updatePosition');
//    Route::post('/desks', [DeskController::class, 'store'])->name('desks.store');
//    Route::put('/desks/{id}', [DeskController::class, 'update'])->name('desks.update');
//    Route::delete('/desks/{id}', [DeskController::class, 'destroy'])->name('desks.destroy');
//    Route::get('/desks/search', [DeskController::class, 'search'])->name('desks.search');
