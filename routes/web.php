<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;

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

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [IndexController::class,'index'])->name('home');
Route::post('/store' , [IndexController::class,'store']);
Route::get('/ip-address' , [IndexController::class,'getIpWithCityState']);
Route::get('/list' , [IndexController::class,'list']);
Route::get('/add' , [IndexController::class,'add']);
Route::post('/send-mail' , [IndexController::class,'sendMail']);
Route::get('/get-excel-file' , [IndexController::class,'getExcelFile']);

