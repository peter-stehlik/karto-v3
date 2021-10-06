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
use App\Http\Controllers\PersonController;
use App\Http\Controllers\PersonFilterController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\CorrectionController;


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

    Route::get('/kartoteka/nepotvrdeny-prijem-potvrdit/{id}', [IncomeUnconfirmedController::class, 'confirmIncomeIndividually'])->middleware(['auth'])->name('nepotvrdeny-prijem-potvrdit');
    Route::resource('/kartoteka/nepotvrdene-prijmy', IncomeUnconfirmedController::class)->middleware(['auth']);

    Route::get('/kartoteka/nepotvrdene-prevody', [TransferUnconfirmedController::class, 'index'])->middleware(['auth'])->name('nepotvrdene-prevody-get');
    Route::get('/kartoteka/nepotvrdene-prevody-vymazat/{id}', [TransferUnconfirmedController::class, 'destroy'])->middleware(['auth'])->name('nepotvrdene-prevody-vymazat');

    Route::get('/kartoteka/nepotvrdene-opravy', [CorrectionController::class, 'listUnconfirmedCorrections'])->middleware(['auth'])->name('nepotvrdene-opravy-get');
    Route::get('/kartoteka/nepotvrdena-oprava-potvrdit/{id}', [CorrectionController::class, 'confirmCorrectionIndividually'])->middleware(['auth'])->name('nepotvrdena-oprava-potvrdit');
    Route::get('/kartoteka/nepotvrdene-opravy-upravit/{id}', [CorrectionController::class, 'editGet'])->middleware(['auth'])->name('nepotvrdene-opravy-upravit-get');
    Route::post('/kartoteka/nepotvrdene-opravy-upravit', [CorrectionController::class, 'editPost'])->middleware(['auth'])->name('nepotvrdene-opravy-upravit-post');
    Route::get('/kartoteka/nepotvrdene-opravy-vymazat/{id}', [CorrectionController::class, 'destroy'])->middleware(['auth'])->name('nepotvrdene-opravy-vymazat');
});

/* ---------------------- */
/* --- VYDAVATELSTVO --- */
/* -------------------- */
Route::name('vydavatelstvo.')->group(function () {
    Route::get('/vydavatelstvo', [ListingController::class, 'getVydavatelstvo'])->middleware(['auth'])->name('uvod');

    Route::resource('/vydavatelstvo/publikacie', PeriodicalController::class)->middleware(['auth']);

    Route::resource('/vydavatelstvo/neperiodika', NonperiodicalController::class)->middleware(['auth']);

    Route::get('/vydavatelstvo/nove-cislo', [ListingController::class, 'getNoveCislo'])->middleware(['auth'])->name('get-nove-cislo');

    Route::get('/vydavatelstvo/zoznam', [ListingController::class, 'getListFilter'])->middleware(['auth'])->name('get-list-filter');
});

/* -------------- */
/* --- OSOBA --- */
/* ------------ */
Route::name('osoba.')->group(function () {
    Route::get('/osoba', [PersonFilterController::class, 'index'])->middleware(['auth'])->name('uvod');
    Route::get('/osoba/filter', [PersonFilterController::class, 'filter'])->middleware(['auth'])->name('filter');

    Route::resource('/osoba/kategorie', CategoryController::class)->middleware(['auth']);
});

/* DOBRODINEC */
/* detaily konkretnej osoby */
Route::name('dobrodinec.')->group(function () {
    Route::get('/dobrodinec/{id}/ucty', [PersonController::class, 'index'])->middleware(['auth'])->name('ucty');

    Route::get('/dobrodinec/{id}/osobne-udaje', [PersonController::class, 'getBio'])->middleware(['auth'])->name('getbio');
    Route::post('/dobrodinec/osobne-udaje', [PersonController::class, 'postBio'])->middleware(['auth'])->name('postbio');

    Route::get('/dobrodinec/{id}/prijmy', [PersonController::class, 'getIncomes'])->middleware(['auth'])->name('getincomes');
    Route::get('/dobrodinec/prijmy-filter', [PersonController::class, 'getIncomesFilter'])->middleware(['auth'])->name('getincomesfilter');
    Route::get('/dobrodinec/prijmy-filter-zobraz-prevody', [PersonController::class, 'getTransfersForIncome'])->middleware(['auth'])->name('gettransfersforincome');

    Route::get('/dobrodinec/{id}/prevody', [PersonController::class, 'getTransfers'])->middleware(['auth'])->name('gettransfers');
    Route::get('/dobrodinec/prevody-filter', [PersonController::class, 'getTransfersFilter'])->middleware(['auth'])->name('gettransfersfilter');
    Route::get('/dobrodinec/prevody-filter-zobraz-prijem', [PersonController::class, 'getIncomeForTransfer'])->middleware(['auth'])->name('getincomefortransfer');
    

    Route::get('/dobrodinec/{id}/oprava-cez-hviezdicku', [CorrectionController::class, 'opravaCezHviezdicku'])->middleware(['auth'])->name('opravacezhviezdicku');
    Route::post('/dobrodinec/oprava-cez-hviezdicku', [CorrectionController::class, 'store'])->middleware(['auth'])->name('storeopravacezhviezdicku');

    Route::get('/dobrodinec/{id}/zoznam-oprav', [CorrectionController::class, 'listCorrections'])->middleware(['auth'])->name('listcorrections');
    Route::get('/dobrodinec/opravy-filter', [CorrectionController::class, 'getCorrectionsFilter'])->middleware(['auth'])->name('getcorrectionsfilter');
});


/* ------------------- */
/* --- KANCELARIA --- */
/* ----------------- */
Route::name('kancelaria.')->group(function () {
    Route::get('/kancelaria', function () {
        return view('v-kancelaria/kancelaria');
    })->middleware(['auth'])->name('uvod');

    Route::resource('/kancelaria/bankove-ucty', BankAccountController::class)->middleware(['auth']);

    Route::get('/kancelaria/denny-mesacny-vypis', [ListingController::class, 'dailyMonthlyListingFilter'])->middleware(['auth'])->name('denny-mesacny-vypis');

    Route::post('/kancelaria/denny-mesacny-vypis', [ListingController::class, 'dailyMonthlyListingPdf'])->middleware(['auth'])->name('pdf-denny-mesacny-vypis');

    Route::get('/kancelaria/denne-mesacne-opravy', [ListingController::class, 'dailyMonthlyCorrectionsFilter'])->middleware(['auth'])->name('denne-mesacne-opravy');

    Route::post('/kancelaria/denne-mesacne-opravy', [ListingController::class, 'dailyMonthlyCorrectionPdf'])->middleware(['auth'])->name('pdf-denne-mesacne-opravy');

    Route::get('/kancelaria/tlac-pre-ucel', [ListingController::class, 'printForTransfer'])->middleware(['auth'])->name('tlac-pre-ucel');

    Route::post('/kancelaria/tlac-pre-ucel', [ListingController::class, 'printForTransferPdf'])->middleware(['auth'])->name('pdf-tlac-pre-ucel');
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

    Route::get('/uzivatel/zoznam-prijmov', [PersonFilterController::class, 'getAllIncomes'])->middleware(['auth'])->name('zoznam-prijmov');

    Route::get('/uzivatel/zoznam-prevodov', [PersonFilterController::class, 'getAllTransfers'])->middleware(['auth'])->name('zoznam-prevodov');

    Route::get('/uzivatel/zoznam-oprav', [PersonFilterController::class, 'getAllCorrections'])->middleware(['auth'])->name('zoznam-oprav');
});

require __DIR__.'/auth.php';
