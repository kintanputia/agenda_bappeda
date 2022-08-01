<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\AuthController;

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
    return view('login');
});
Route::post('/', [AuthController::class, 'login'])->name('login');

Route::group(['middleware' => 'PreventBack'], function(){
    Route::group(['middleware' => 'LoginMiddleware'], function(){
        Route::get('/dashboard', [AgendaController::class,'index'])->name('index');
        Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::post('simpanagenda',[AgendaController::class, 'store'])->name('simpanagenda');
        Route::post('/addLokasi',[AgendaController::class, 'insert_lokasi']);
        Route::get('/delete/{id}', [AgendaController::class, 'destroy']);
        Route::get('/detail/{id}', [AgendaController::class, 'show']);
        Route::get('/edit/{id}', [AgendaController::class, 'edit']);
        Route::post('/edit_process', [AgendaController::class, 'edit_process'])->name('edit_process');
        Route::get('/add', [AgendaController::class,'create']);
        
        // Route::get('/tv', [AgendaController::class,'tampilan_tv']);
        Route::get('/tv/fetchdata', [AgendaController::class,'fetchdata']);
        Route::get('/getStatus',[AgendaController::class, 'get_status']);
        Route::get('/getRuangan',[AgendaController::class, 'get_ruangan']);
        Route::post('/getKetersediaan',[AgendaController::class, 'get_ketersediaan']);
        Route::get('/getStatusEdit/{id}',[AgendaController::class, 'get_status_edit']);
        Route::get('/getLokasi', [AgendaController::class, 'get_lokasi']);
    });
});
Route::get('/tv', [AgendaController::class,'tampilan_tv']);