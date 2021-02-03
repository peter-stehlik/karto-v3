<?php

use Illuminate\Support\Facades\Route;

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

Route::name('kartoteka.')->group(function () {
    Route::get('/kartoteka', function () {
        return view('kartoteka');
    })->middleware(['auth'])->name('uvod');
});



require __DIR__.'/auth.php';
