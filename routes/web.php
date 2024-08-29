<?php

use App\models\Employee;
use App\Models\Location;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LocationController;

Route::get('/', [EmployeeController::class, 'index'])->name('employee.index');
Route::post('/search', [EmployeeController::class, 'search'])->name('employee.search');
Route::post('/employee', [EmployeeController::class, 'store'])->name('employee.store');
Route::put('/employee/{id}', [EmployeeController::class, 'update'])->name('employee.update');
Route::delete('/employee/{id}', [EmployeeController::class, 'destroy'])->name('employee.destroy');

Route::get('/location', [LocationController::class, 'index'])->name('location.index');
Route::post('/location', [LocationController::class, 'store'])->name('location.store');
Route::put('/location/{id}', [LocationController::class, 'update'])->name('location.update');
Route::delete('/location/{id}', [LocationController::class, 'destroy'])->name('location.destroy');
