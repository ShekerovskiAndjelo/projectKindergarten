<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GeneratedNumberController;
use App\Http\Controllers\KindergartenController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\AttendaceController;
use App\Http\Controllers\KidController;

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

Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/{user}/restore', [UserController::class, 'restore'])->name('users.restore');

    Route::get('/generated_numbers', [GeneratedNumberController::class, 'index'])->name('generated_numbers.index');
    Route::get('/generated_numbers/create', [GeneratedNumberController::class, 'create'])->name('generated_numbers.create');
    Route::post('/generated_numbers', [GeneratedNumberController::class, 'store'])->name('generated_numbers.store');
    Route::post('/generated_numbers/storeRandomNumbers', [GeneratedNumberController::class, 'storeRandomNumbers'])->name('generated_numbers.storeRandomNumbers');

    Route::get('/kindergartens', [KindergartenController::class, 'index'])->name('kindergartens.index');
    Route::get('/kindergartens/create', [KindergartenController::class, 'create'])->name('kindergartens.create');
    Route::post('/kindergartens', [KindergartenController::class, 'store'])->name('kindergartens.store');
    Route::get('/kindergartens/{kindergarten}/edit', [KindergartenController::class, 'edit'])->name('kindergartens.edit');
    Route::put('/kindergartens/{kindergarten}', [KindergartenController::class, 'update'])->name('kindergartens.update');
    Route::delete('/kindergartens/{kindergarten}', [KindergartenController::class, 'destroy'])->name('kindergartens.destroy');
    Route::get('/kindergartens/{id}/restore', [KindergartenController::class, 'restore'])->name('kindergartens.restore');

});

Route::group(['middleware' => ['auth', 'role:director']], function () {
    Route::get('/groups', [GroupController::class, 'index'])->name('groups.index');
    Route::get('/groups/create', [GroupController::class, 'create'])->name('groups.create');
    Route::post('/groups', [GroupController::class, 'store'])->name('groups.store');
    Route::get('/groups/{group}/edit', [GroupController::class, 'edit'])->name('groups.edit');
    Route::put('/groups/{group}', [GroupController::class, 'update'])->name('groups.update');
    Route::delete('/groups/{group}', [GroupController::class, 'destroy'])->name('groups.destroy');
    Route::get('/groups/{id}/restore', [GroupController::class, 'restore'])->name('groups.restore');

    Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances.index');
    Route::get('/attendances/create', [AttendanceController::class, 'create'])->name('attendances.create');
    Route::post('/attendances', [AttendanceController::class, 'store'])->name('attendances.store');
    Route::get('/attendances/{attendance}/edit', [AttendanceController::class, 'edit'])->name('attendances.edit');
    Route::put('/attendances/{attendance}', [AttendanceController::class, 'update'])->name('attendances.update');
});

Route::group(['middleware' => ['auth', 'role:teacher']], function () {
    Route::get('/groups', [GroupController::class, 'index'])->name('groups.index');
    Route::get('/groups/{group}/edit', [GroupController::class, 'edit'])->name('groups.edit');
    Route::put('/groups/{group}', [GroupController::class, 'update'])->name('groups.update');

    Route::get('/attendances', [AttendanceController::class, 'index'])->name('attendances.index');
    Route::get('/attendances/{attendance}/edit', [AttendanceController::class, 'edit'])->name('attendances.edit');
    Route::put('/attendances/{attendance}', [AttendanceController::class, 'update'])->name('attendances.update');
});

Route::group(['middleware' => ['auth', 'role:parent']], function () {
    Route::get('/kids', [KidController::class, 'index'])->name('kids.index');
    Route::get('/kids/create', [KidController::class, 'create'])->name('kids.create');
    Route::post('/kids', [KidController::class, 'store'])->name('kids.store');
    Route::get('/kids/{kid}/edit', [KidController::class, 'edit'])->name('kids.edit');
    Route::put('/kids/{kid}', [KidController::class, 'update'])->name('kids.update');
    Route::delete('/kids/{kid}', [KidController::class, 'destroy'])->name('kids.destroy');
});




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
});

require __DIR__.'/auth.php';
