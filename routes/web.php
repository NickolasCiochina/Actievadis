<?php

use App\Http\Controllers\ActivityController;
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
//     return view('welcome');
// });

Route::get('/', [ActivityController::class, 'index'])->name('activity_cards');
Route::get('/activity/{activity}', [ActivityController::class, 'show'])->name('activity.show');
Route::post('/activity/store', [ActivityController::class, 'store'])->name('activity.store');
Route::post('/activity/{activity}/register', [ActivityController::class, 'register'])->name('activity.register');
Route::delete('/activity/{activity}', [ActivityController::class, 'destroy'])->name('activity.destroy');