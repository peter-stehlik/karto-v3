<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\UserController;


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
