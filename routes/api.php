<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\GoalCategoryController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\LeaveTypeSettingController;
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

        Route::get("/leave-types", [LeaveTypeSettingController::class, "index"]);
        Route::post("/leave-types", [LeaveTypeSettingController::class, "store"]);
        Route::put("/leave-types/{id}", [LeaveTypeSettingController::class, "update"]);
        Route::delete("/leave-types/{id}", [LeaveTypeSettingController::class, "destroy"]);

        Route::get("/leaves/request", [LeaveRequestController::class, "index"]);
        Route::post("/leaves/request", [LeaveRequestController::class, "request"]);
        Route::get("/leaves/findEmployee", [LeaveRequestController::class, "searchEmployee"]);
        Route::put("/leaves/{id}/cancel", [LeaveRequestController::class, "canncelLeave"]);
        Route::put("/leaves/{id}/approve-request", [LeaveRequestController::class, "approveRequest"]);
        Route::get("/leaves/pending", [LeaveRequestController::class, "getPendingLeave"]);

        Route::get("/leaves/category", [GoalCategoryController::class, "index"]);
        Route::post("/leaves/category", [GoalCategoryController::class, "store"]);
        Route::put("/leaves/category/{id}", [GoalCategoryController::class, "update"]);
        Route::delete("/leaves/category/{id}", [GoalCategoryController::class, "destroy"]);

        Route::post("/leaves/goals",[GoalController::class, "store"]);
        Route::get("/leaves/goals",[GoalController::class, "index"]);
        Route::put("/leaves/goals",[GoalController::class, "update"]);
        Route::delete("/leaves/goals", [GoalController::class, "destroy"]);
    });
});

