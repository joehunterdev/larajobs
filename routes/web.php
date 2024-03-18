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

Route::get('/', [Controllers\ListingController::class, 'index'])->name('listing.index');

Route::get('/{listing}',[Controllers\ListingController::class, 'show'])
->name('listing.show');

Route::get('/{listing}/apply', [Controllers\ListingController::class, 'apply'])->name('listings.apply');

Route::get('/dashboard',function(){
     return view('dashboard');
})->middleware('auth')->name('dashboard');


//Catch all route
Auth::routes(['register' => false]); //Same as doing /auth.php


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
