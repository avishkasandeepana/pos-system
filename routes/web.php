<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\loginController;

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


Route::get('/',[loginController::class,'loginPage'])->middleware('alreadyLogged')->name('loginpage');
Route::post('/login',[loginController::class,'login'])->name('login')->middleware('alreadyLogged');
Route::post('/register',[loginController::class,'register'])->name('register');
Route::get('/dashboard',[loginController::class,'dashboard'])->name('dashboard')->middleware('isLoggedIn');
Route::get('/logout',[loginController::class,'logout'])->name('logout');


