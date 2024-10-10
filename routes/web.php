<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\ETLController;
use App\Http\Controllers\WarehouseEmployeeController;
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



Route::get('/add_car', [CarController::class, 'showAddCarForm'])->name('add_car_form');
Route::post('/add_car', [CarController::class, 'addCar'])->name('add_car');
Route::get('/car/{car_id}', [CarController::class, 'showCar'])->name('show_car');

Route::get('/run-etl', [ETLController::class, 'runETL'])->name('run.etl');




Route::get('/', function () {
    return view('welcome');
});
