<?php

use App\Http\Controllers\DeskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

////Route::middleware(['auth'])->group(function () {
//    Route::get('/desks/', [DeskController::class, 'index']);
//    // Route::get('/desks/edit', [DeskController::class, 'edit'])->name('desks.edit');
//    Route::get('desks/{desk}/edit', [DeskController::class, 'edit'])->name('desks.edit');
//
//    // Route::put('/desks/', [DeskController::class, 'updatePosition'])->name('desks.updatePosition');
//    Route::post('/desks/updatePosition', [DeskController::class, 'updatePosition'])->name('desks.updatePosition');
//    Route::post('/desks', [DeskController::class, 'store'])->name('desks.store');
//    Route::put('/desks/{id}', [DeskController::class, 'update'])->name('desks.update');
//    Route::delete('/desks/{id}', [DeskController::class, 'destroy'])->name('desks.destroy');
//
//// Add the following route for searching desks
//    Route::get('/desks/search', [DeskController::class, 'search'])->name('desks.search');
////});
