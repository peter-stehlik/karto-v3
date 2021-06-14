<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\UserController;
use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\PeriodicalController;
use App\Http\Controllers\NonperiodicalController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/* ------------------ */
/* --- KARTOTEKA --- */
/* ---------------- */
Route::name('kartoteka.')->group(function () {
    Route::get('/kartoteka', function () {
        return view('v-kartoteka/kartoteka');
    })->middleware(['auth'])->name('uvod');
});

/* ---------------------- */
/* --- VYDAVATELSTVO --- */
/* -------------------- */
Route::name('vydavatelstvo.')->group(function () {
    Route::get('/vydavatelstvo', function () {
        return view('v-vydavatelstvo/vydavatelstvo');
    })->middleware(['auth'])->name('uvod');

    Route::resource('vydavatelstvo/publikacie', PeriodicalController::class)->middleware(['auth']);

    Route::resource('vydavatelstvo/neperiodika', NonperiodicalController::class)->middleware(['auth']);
});

/* ------------------- */
/* --- KANCELARIA --- */
/* ----------------- */
Route::name('kancelaria.')->group(function () {
    Route::get('/kancelaria', function () {
        return view('v-kancelaria/kancelaria');
    })->middleware(['auth'])->name('uvod');

    Route::resource('kancelaria/bankove-ucty', BankAccountController::class)->middleware(['auth']);
});

/* ----------------- */
/* --- UZIVATEL --- */
/* --------------- */
Route::name('uzivatel.')->group(function () {
    Route::get('/uzivatel', function () {
        return view('v-uzivatel/uzivatel');
    })->middleware(['auth'])->name('uvod');
    
    Route::get('/uzivatel/zmenit-heslo', function () {
        return view('v-uzivatel/zmenit-heslo');
    })->middleware(['auth'])->name('zmenit-heslo');

    Route::post('/uzivatel/zmenit-heslo', [UserController::class, 'changePassword'])->middleware(['auth'])->name('zmenit-heslo-post');
});

require __DIR__.'/auth.php';
