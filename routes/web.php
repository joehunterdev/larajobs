<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', [Controllers\ListingController::class, 'index'])->name('listings.index');

Route::get('/new', [Controllers\ListingController::class, 'create'])->name('listing.create');

Route::get('/dashboard', function () {
     return view('dashboard.index');
})->middleware('auth')->name('dashboard');


Route::get('/{listing}', [Controllers\ListingController::class, 'show'])->name('listing.show');

Route::post('/new', [Controllers\ListingController::class, 'store'])->name('listing.store');

// Route::get('/{listing}/apply', [Controllers\ListingController::class, 'apply'])->name('listing.apply');

//Catch all route
Auth::routes(['register' => false]); //Same as doing /auth.php


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
