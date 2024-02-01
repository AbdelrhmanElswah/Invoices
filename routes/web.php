<?php

use App\Http\Controllers\ProfileController;
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

Route::get('/', function () {
    return view('auth.login');
});
Route::get('/register', function () {
    return view('auth.register');
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

Route::resource('invoices', 'App\Http\Controllers\InvoicesController');

Route::resource('sections', 'App\Http\Controllers\SectionsController');

Route::resource('products', 'App\Http\Controllers\ProductsController');

Route::get('/section/{id}','App\Http\Controllers\InvoicesController@getproduct');

Route::get('/InvoicesDetails/{id}','App\Http\Controllers\InvoicesDetailsController@edit');

Route::get('/edit_invoice/{id}','App\Http\Controllers\InvoicesController@edit');

Route::get('/Status_show/{id}','App\Http\Controllers\InvoicesController@show')->name('Status_show');

Route::post('/Status_Update/{id}','App\Http\Controllers\InvoicesController@Status_Update')->name('Status_Update');

Route::get('/{page}', 'App\Http\Controllers\AdminController@index');