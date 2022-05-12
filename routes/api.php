<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::group(['middleware' => ['apiJwt']], function(){

    Route::get('/me', [AuthController::class, 'me']);


    Route::get('/role', [RoleController::class, 'list']);
    Route::get('/role/{id}', [RoleController::class, 'getById']);
    Route::put('/role/{id}', [RoleController::class, 'update']);
    Route::delete('/role/{id}', [RoleController::class, 'delete']);
    Route::post('/role', [RoleController::class, 'create']);
});
