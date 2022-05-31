<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\FavoriteProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ServedDistrictController;
use App\Http\Controllers\SpecController;
use App\Http\Controllers\StockLogController;
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

    Route::get('/admin/home', [HomeController::class, 'adminHome']);

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
    Route::get('/operators/{id}', [UserController::class, 'getById']);
    Route::put('/operators/{id}', [UserController::class, 'update']);
    Route::post('/operators', [UserController::class, 'create']);

    Route::get('/category', [CategoryController::class, 'list']);
    Route::get('/category/tree', [CategoryController::class, 'treeList']);
    Route::get('/category/{id}', [CategoryController::class, 'getById']);
    Route::put('/category/{id}', [CategoryController::class, 'update']);
    Route::delete('/category/{id}', [CategoryController::class, 'delete']);
    Route::post('/category', [CategoryController::class, 'create']);

    Route::get('/brand', [BrandController::class, 'list']);
    Route::get('/brand/{id}', [BrandController::class, 'getById']);
    Route::put('/brand/{id}', [BrandController::class, 'update']);
    Route::delete('/brand/{id}', [BrandController::class, 'delete']);
    Route::post('/brand', [BrandController::class, 'create']);

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
    Route::get('/user/me/address', [AddressController::class, 'getMe']);
    Route::post('/user/me/address', [AddressController::class, 'createMe']);
    Route::get('/address/{id}', [AddressController::class, 'getById']);
    Route::put('/address/me/{id}', [AddressController::class, 'updateMe']);

    Route::get('/user/{id}/address', [AddressController::class, 'getByUser']);
    Route::post('/user/{id}/address', [AddressController::class, 'create']);
    Route::get('/address/{id}', [AddressController::class, 'getById']);
    Route::put('/address/{id}', [AddressController::class, 'update']);

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
    Route::put('/seller/me/config', [SellerController::class, 'updateConfigMe']);
    Route::get('/seller/{id}', [SellerController::class, 'getById']);
    Route::put('/seller/{id}', [SellerController::class, 'update']);
    Route::post('/seller', [SellerController::class, 'create']);

    /**
     * geral users
     */
    Route::put('/user/me/update-password', [UserController::class, 'updateMePassword']);
    Route::post('/user/me/upload-picture', [UserController::class, 'uploadPicture']);
    Route::post('/user/me/upload-banner', [UserController::class, 'uploadBanner']);


    /**
     * products
     */
    Route::post('/product', [ProductController::class, 'create']);
    Route::get('/product/me', [ProductController::class, 'listMe']);
    Route::get('/product/me/{id}', [ProductController::class, 'getMe']);
    Route::put('/product/{id}/general', [ProductController::class, 'generalUpdate']);
    Route::put('/product/{id}/other-data', [ProductController::class, 'otherDataUpdate']);
    Route::put('/product/{id}/update-category', [ProductController::class, 'updateCategory']);
    Route::put('/product/{id}/update-specs', [ProductController::class, 'updateSpecs']);
    Route::post('/product/{id}/toggle-status', [ProductController::class, 'toggleStatus']);
    Route::delete('/product/{id}', [ProductController::class, 'delete']);

    // images
    Route::post('/product/{id}/upload-image', [ProductImageController::class, 'uploadImage']);
    Route::post('/product/{id}/remove-image', [ProductImageController::class, 'removeImage']);
    Route::post('/product/{id}/set-principal-image', [ProductImageController::class, 'setPrincipalImage']);

    /**
     * stock
     */
    Route::post('/stock/entry', [StockLogController::class, 'entry']);
    Route::post('/stock/out', [StockLogController::class, 'out']);


    /**
     * served districts
     */
    Route::post('/served-district', [ServedDistrictController::class, 'create']);
    Route::get('/served-district', [ServedDistrictController::class, 'list']);
    Route::get('/served-district/{id}', [ServedDistrictController::class, 'getById']);
    Route::put('/served-district/{id}', [ServedDistrictController::class, 'update']);
    Route::delete('/served-district/multiple', [ServedDistrictController::class, 'multipleDelete']);
    Route::delete('/served-district/{id}', [ServedDistrictController::class, 'delete']);

    /**
     * favorite products
     */
    Route::get('/favorite-product', [FavoriteProductController::class, 'list']);
    Route::post('/favorite-product', [FavoriteProductController::class, 'toggle']);

    /**
     * cart
     */
    Route::post('/cart/add-item', [CartController::class, 'addItem']);
    Route::get('/cart', [CartController::class, 'get']);
    Route::put('/cart-item/amount/{id}', [CartController::class, 'updateItemAmount']);
    Route::delete('/cart-item/{id}', [CartController::class, 'removeItem']);

});

/**
 * public
 */
Route::get('/product/slug/{slug}', [ProductController::class, 'getBySlug']);