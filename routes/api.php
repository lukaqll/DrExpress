<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\SpecController;
use App\Http\Controllers\UfController;
use App\Http\Controllers\UserController;
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


    Route::get('/roles', [RoleController::class, 'list']);
    Route::get('/roles/{id}', [RoleController::class, 'getById']);
    Route::put('/roles/{id}', [RoleController::class, 'update']);
    Route::delete('/roles/{id}', [RoleController::class, 'delete']);
    Route::post('/roles', [RoleController::class, 'create']);
    Route::get('/roles/{id}/permissions', [RoleController::class, 'getRolePermissions']);

    Route::get('/permissions', [PermissionController::class, 'list']);
    Route::get('/permissions/{id}', [PermissionController::class, 'getById']);
    Route::put('/permissions/{id}', [PermissionController::class, 'update']);
    Route::delete('/permissions/{id}', [PermissionController::class, 'delete']);
    Route::post('/permissions', [PermissionController::class, 'create']);

    Route::get('/operators', [UserController::class, 'list']);
    Route::put('/operators/{id}/password', [UserController::class, 'updatePassword']);
    Route::put('/operators/{id}/toggle-status', [UserController::class, 'toggleStatus']);
    Route::get('/operators/me', [UserController::class, 'getMe']);
    Route::put('/operators/me/update', [UserController::class, 'updateMe']);
    Route::put('/operators/me/update-password', [UserController::class, 'updateMePassword']);
    Route::get('/operators/{id}', [UserController::class, 'getById']);
    Route::put('/operators/{id}', [UserController::class, 'update']);
    Route::post('/operators', [UserController::class, 'create']);

    Route::get('/category', [CategoryController::class, 'list']);
    Route::get('/category/tree', [CategoryController::class, 'treeList']);
    Route::get('/category/{id}', [CategoryController::class, 'getById']);
    Route::put('/category/{id}', [CategoryController::class, 'update']);
    Route::delete('/category/{id}', [CategoryController::class, 'delete']);
    Route::post('/category', [CategoryController::class, 'create']);

    Route::post('/category/{id}/specs', [SpecController::class, 'create']);
    Route::post('/spec/{id}/item', [SpecController::class, 'createItem']);
    Route::put('/spec-item/{idItem}', [SpecController::class, 'updateItem']);
    Route::get('/spec/{id}', [SpecController::class, 'getById']);
    Route::put('/spec/{id}', [SpecController::class, 'update']);
    Route::delete('/spec/{id}', [SpecController::class, 'delete']);
    Route::delete('/spec-item/{id}', [SpecController::class, 'deleteItem']);

    /**
     * address
     */
    Route::get('/uf', [UfController::class, 'list']);
    Route::get('/uf/{id}', [UfController::class, 'getById']);
    Route::put('/uf/{id}', [UfController::class, 'update']);
    Route::post('/uf', [UfController::class, 'create']);
    // Route::delete('/uf/{id}', [UfController::class, 'delete']);
    
    Route::get('/uf/{id}/cities', [UfController::class, 'getCities']);
    Route::post('/uf/{id}/city', [CityController::class, 'create']);
    Route::get('/city', [CityController::class, 'list']);
    Route::get('/city/{id}', [CityController::class, 'getById']);
    Route::put('/city/{id}', [CityController::class, 'update']);
    // Route::delete('/city/{id}', [CityController::class, 'delete']);
    
    Route::get('/city/{id}/district', [CityController::class, 'getDistricts']);
    Route::post('/city/{id}/district', [DistrictController::class, 'create']);
    Route::get('/district', [DistrictController::class, 'list']);
    Route::get('/district/{id}', [DistrictController::class, 'getById']);
    Route::put('/district/{id}', [DistrictController::class, 'update']);
    // Route::delete('/district/{id}', [DistrictController::class, 'delete']);

    /**
     * sellers
     */
    Route::get('/seller', [SellerController::class, 'list']);
    Route::put('/seller/{id}/password', [SellerController::class, 'updatePassword']);
    Route::put('/seller/{id}/toggle-status', [SellerController::class, 'toggleStatus']);
    Route::get('/seller/me', [SellerController::class, 'getMe']);
    Route::put('/seller/me/update', [SellerController::class, 'updateMe']);
    Route::put('/seller/me/update-password', [SellerController::class, 'updateMePassword']);
    Route::get('/seller/{id}', [SellerController::class, 'getById']);
    Route::put('/seller/{id}', [SellerController::class, 'update']);
    Route::post('/seller', [SellerController::class, 'create']);


});
