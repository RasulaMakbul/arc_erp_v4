<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CatalogueController;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Ctalogue
Route::get('/catalogue',[CatalogueController::class,'index'])->name('catalogue');
Route::post('/catalogue/store',[CatalogueController::class,'store'])->name('catalogue.store');
Route::patch('/catalogue/update',[CatalogueController::class,'update'])->name('catalogue.update');