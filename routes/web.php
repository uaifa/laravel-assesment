<?php

use App\Http\Controllers\Admin\FavoriteQuotesController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Admin\QuotesController;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
        'quotes' => Route::has('quotes'),
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

require __DIR__.'/auth.php';

Route::group(['middleware' => ['auth']], function() {
	Route::get('quotes/{limit?}', [QuotesController::class, 'index'])->name('quotes.index');
	Route::post('favorite', [QuotesController::class, 'store'])->name('quote.favorite');
	Route::get('favorites', [FavoriteQuotesController::class,'index'])->name('favorites.index');
	Route::delete('favorites/{id}', [FavoriteQuotesController::class,'destroy'])->name('favorites.destroy');

});

