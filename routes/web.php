<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AuthMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('{any?}', function () {
    return view('welcome');
})->where('any', '^(?!api).*$');


// Route::get('/login', action: [UserController::class, 'showLoginForm'])->name('loginForm');
// Route::post('/login', [UserController::class, 'login'])->name('login');

// Route::middleware([AuthMiddleware::class])->group(function () {
//     Route::get('/dashboard', [DashboardController::class,'index'])->name('dashboard.index');

//     Route::resource('/department', DepartmentController::class);
//     Route::post('/employee/search', [EmployeeController::class, 'search'])->name(name: 'employee.search');
//     Route::get('/employee/line-manager', [EmployeeController::class, 'showSearchForm'])->name(name: 'employee.line-manager');
//     Route::post('employee/line-manager', [EmployeeController::class, 'addLineManager'])->name(name: 'employee.line-manager.select');

//     Route::get('employee/designation', [EmployeeController::class, 'designation'])->name(name: 'employee.designation');
//     Route::post('employee/designation', [EmployeeController::class, 'addDesignation'])->name(name: 'employee.designation.select');
//     Route::resource('/employee', EmployeeController::class);

//     Route::get('/logout', [UserController::class, 'logout'])->name('logout');


//     Route::post('/designation/search', [DesignationController::class, 'search'])->name(name: 'designation.search');
//     Route::get('/designation', [DesignationController::class, 'index'])->name(name: 'designation.index');
//     Route::get('/designation/show/{id}', [DesignationController::class, 'show'])->name(name: 'designation.show');
//     Route::get('/designation/edit/{id}', [DesignationController::class, 'edit'])->name(name: 'designation.edit');
//     Route::get('/designation/create', [DesignationController::class, 'create'])->name(name: 'designation.create');
//     Route::post('/designation', [DesignationController::class, 'store'])->name(name: 'designation.store');
//     Route::put('/designation/{id}', [DesignationController::class, 'update'])->name(name: 'designation.update');
//     Route::delete('designation/{id}', [DesignationController::class,'destroy'])->name(  name:'designation.destroy');
// });