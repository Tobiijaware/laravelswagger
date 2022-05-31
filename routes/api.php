<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});



// Route for admin permissions
Route::prefix('admin')->group(function() {
    Route::post('/login', [AuthController::class, 'adminLogin']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::get('/view-employees', [UserController::class, 'viewEmployees'])->middleware(['auth:api', 'scope:view']);
Route::get('/view-single-employee/{id}', [UserController::class, 'viewSingleEmployees'])->middleware(['auth:api', 'scope:view']);
Route::put('/update-employees/{id}', [UserController::class, 'updateEmployees'])->middleware(['auth:api', 'scope:update']);

Route::get('/index', [UserController::class, 'index']);

Route::post('/create-employees', [UserController::class, 'createEmployees']);
Route::post('/createusers', [UserController::class, 'createusers']);
