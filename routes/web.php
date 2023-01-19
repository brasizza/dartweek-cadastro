<?php

use App\Http\Controllers\CertificadoController;
use App\Http\Controllers\ConclusaoController;
use Illuminate\Support\Facades\Route;

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
//     return view('landpage.index');
// });


Route::get('/' ,[ConclusaoController::class,'index']);
Route::get('/certificado' ,[CertificadoController::class,'findBySignature']);

