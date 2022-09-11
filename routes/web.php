<?php

use App\Http\Controllers\EmployeeController;
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

Route::get('/',[EmployeeController::class,'index'])->name('employee.index');
Route::POST('/store',[EmployeeController::class,'store'])->name('employee.store');
Route::get('/fetchall',[EmployeeController::class,'fetchAll'])->name('fetchAll');
Route::get('/edit',[EmployeeController::class,'edit'])->name('edit');
Route::POST('/update',[EmployeeController::class,'updated'])->name('update');
Route::delete('/delete',[EmployeeController::class,'delete'])->name('delete');