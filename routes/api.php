<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api')->name('refresh');
    Route::post('/me', [AuthController::class, 'me'])->middleware('auth:api')->name('me');
    
});

Route::group(['middleware'=>'api','prefix'=> 'common'], function () {
    Route::middleware(['auth:api'])->group(function () {
        Route::get('/department', [DepartmentController::class,"index"]);
        Route::post('/department', [DepartmentController::class,"store"]);
        Route::get('/department/{id}/edit', [DepartmentController::class,"edit"]);
        Route::put('/department/{id}', [DepartmentController::class,"update"]);
        Route::delete('/department/{id}', [DepartmentController::class,"destroy"]);

        Route::get('/designation', [DesignationController::class,"index"]);
        Route::post('/designation', [DesignationController::class,"store"]);
        Route::get('/designation/{id}/edit', [DesignationController::class,"edit"]);
        Route::put('/designation/{id}', [DesignationController::class,"update"]);
        Route::delete('/designation/{id}', [DesignationController::class,"destroy"]);

        Route::post("/employee", [EmployeeController::class,"store"]);
        Route::get( "/employee", [EmployeeController::class,"index"]);
        Route::post("/employee/{id}",[EmployeeController::class,"update"]);
        Route::delete("/employee/{id}",[EmployeeController::class,"destroy"]);
        Route::get("/employee/{id}",[EmployeeController::class,"view"]);
        Route::post("/employee/updatePhoto/{id}", [EmployeeController::class,"updateImage"]);

    });
});

