<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\RuanganController;

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

Route::get('/', [AgendaController::class,'index'])->name('index');
Route::post('simpanagenda',[AgendaController::class, 'store'])->name('simpanagenda');
Route::post('/addLokasi',[AgendaController::class, 'insert_lokasi']);
Route::get('/delete/{id}', [AgendaController::class, 'destroy']);
Route::get('/detail/{id}', [AgendaController::class, 'show']);
Route::get('/edit/{id}', [AgendaController::class, 'edit']);
Route::post('/edit_process', [AgendaController::class, 'edit_process'])->name('edit_process');
Route::get('/getLokasi', [AgendaController::class, 'get_lokasi']);
Route::get('/add', [AgendaController::class,'create']);
Route::get('/tv', [AgendaController::class,'tampilan_tv']);
Route::get('/tv/fetchdata', [AgendaController::class,'fetchdata']);
Route::get('/getStatus',[AgendaController::class, 'get_status']);
Route::get('/getStatusEdit/{id}',[AgendaController::class, 'get_status_edit']);