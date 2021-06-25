<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\UserController;
use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\PeriodicalController;
use App\Http\Controllers\NonperiodicalController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\IncomeUnconfirmedController;
use App\Http\Controllers\TransferUnconfirmedController;


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

    Route::get('/kartoteka/prijem', [IncomeController::class, 'create'])->middleware(['auth'])->name('prijem-get');
    Route::post('/kartoteka/prijem', [IncomeController::class, 'store'])->middleware(['auth'])->name('prijem-post');
    
    Route::get('/kartoteka/prijem/autocomplete', [IncomeController::class, 'autocomplete'])->middleware(['auth'])->name('autocomplete-get');
    
    Route::get('/kartoteka/prijem/create-new-person', [IncomeController::class, 'createNewPerson'])->middleware(['auth'])->name('create-new-person-get');
    
    Route::get('/kartoteka/prijem/delete-person', [IncomeController::class, 'deletePerson'])->middleware(['auth'])->name('delete-person-get');
    
    Route::get('/kartoteka/prijem/potvrdit-prijmy', [IncomeController::class, 'unconfirmedIncomesSummary'])->middleware(['auth'])->name('unconfirmed-incomes-summary-get');
    Route::post('/kartoteka/prijem/potvrdit-prijmy', [IncomeController::class, 'confirmIncomes'])->middleware(['auth'])->name('confirm-incomes-post');

    Route::resource('/kartoteka/nepotvrdene-prijmy', IncomeUnconfirmedController::class)->middleware(['auth']);

    Route::get('/kartoteka/nepotvrdene-prevody', [TransferUnconfirmedController::class, 'index'])->middleware(['auth'])->name('nepotvrdene-prevody-get');
    Route::get('/kartoteka/nepotvrdene-prevody-filter', [TransferUnconfirmedController::class, 'filter'])->middleware(['auth'])->name('nepotvrdene-prevody-filter-get');
});

/* ---------------------- */
/* --- VYDAVATELSTVO --- */
/* -------------------- */
Route::name('vydavatelstvo.')->group(function () {
    Route::get('/vydavatelstvo', function () {
        return view('v-vydavatelstvo/vydavatelstvo');
    })->middleware(['auth'])->name('uvod');

    Route::resource('/vydavatelstvo/publikacie', PeriodicalController::class)->middleware(['auth']);

    Route::resource('/vydavatelstvo/neperiodika', NonperiodicalController::class)->middleware(['auth']);
});

/* -------------- */
/* --- OSOBA --- */
/* ------------ */
Route::name('osoba.')->group(function () {
    Route::get('/osoba', function () {
        return view('v-osoba/osoba');
    })->middleware(['auth'])->name('uvod');

    Route::resource('/osoba/kategorie', CategoryController::class)->middleware(['auth']);
});

/* ------------------- */
/* --- KANCELARIA --- */
/* ----------------- */
Route::name('kancelaria.')->group(function () {
    Route::get('/kancelaria', function () {
        return view('v-kancelaria/kancelaria');
    })->middleware(['auth'])->name('uvod');

    Route::resource('/kancelaria/bankove-ucty', BankAccountController::class)->middleware(['auth']);
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

    Route::get('/uzivatel/uctovny-datum', [UserController::class, 'updateAccountingDate'])->middleware(['auth'])->name('update-accounting-date-get');
});

require __DIR__.'/auth.php';
