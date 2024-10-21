<?php

use App\Http\Controllers\ActivityController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WelcomeController;


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

Route::get('/covadis-activities', [ActivityController::class, 'covadisActivities'])->name('activity_cards_covadis');
Route::get('/ended-activities', [ActivityController::class, 'endedActivities'])->name('activities.ended');

Route::delete('/activity/{activity}/{registration}/unregister', [ActivityController::class, 'unregister'])->name('activity.unregister');

// User registration routes
Route::get('/register', [UserController::class, 'showRegistrationForm'])->name('user.register');
Route::post('/register', [UserController::class, 'register']);

// User login routes
Route::get('/login', [UserController::class, 'showLoginForm'])->name('user.login');
Route::post('/login', [UserController::class, 'login']);

// User logout route
Route::post('/logout', [UserController::class, 'logout'])->name('user.logout');
