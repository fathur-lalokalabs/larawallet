<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CreditTransferController;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {

    // payment routes
    Route::get('/credit_transfers', [CreditTransferController::class, 'index'])->name('credit_transfers.index');
    Route::get('/credit_transfers/create', [CreditTransferController::class, 'create'])->name('credit_transfers.create');
    Route::post('/credit_transfers/store', [CreditTransferController::class, 'store'])->name('credit_transfers.store');
    Route::get('/credit_transfers/show/{payment}', [CreditTransferController::class, 'show'])->name('credit_transfers.show');

});

// GETOTP callback route

require __DIR__.'/auth.php';
