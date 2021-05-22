<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
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

Route::get('/', fn() => response()->json(['doesApItWerk' => 'Yes!']));

Route::post('/login', [AuthController::class, 'login']);

Route::get('/adminExists', [AuthController::class, 'adminExists']);
Route::post('/createAdmin', [AuthController::class, 'createAdmin']);

Route::middleware('auth:api')->group(function () {

    Route::get('/auth/user', [AuthController::class, 'details']);
    Route::post('/auth/changeName', [AuthController::class, 'changeName']);
    Route::post('/auth/changePassword', [AuthController::class, 'changePassword']);


    /* Categories */
    Route::get('/categories', [CategoryController::class, 'index']);

    /* Products */
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{id}', [ProductController::class, 'show']);

    Route::middleware('admin')->group(function () {

        /* Users */
        Route::get('/users', [UserController::class, 'index']);
        Route::post('/users', [UserController::class, 'create']);
        Route::get('/users/{user}', [UserController::class, 'show']);
        Route::patch('/users/{user}', [UserController::class, 'update']);
        Route::delete('/users/{user}', [UserController::class, 'delete']);


        /* Categories */
        Route::post('/categories', [CategoryController::class, 'create']);
        Route::patch('/categories/{category}', [CategoryController::class, 'update']);
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);


        /* Shifts */
        Route::get('/shifts', [ShiftController::class, 'index']);
        Route::post('/shifts', [ShiftController::class, 'create']);
        Route::get('/shifts/{shift}', [ShiftController::class, 'show']);
        Route::patch('/shifts/{shift}', [ShiftController::class, 'update']);
        Route::delete('/shifts/{shift}', [ShiftController::class, 'destroy']);


        /* Products */
        Route::post('/products', [ProductController::class, 'create']);
        Route::patch('/products/{product}', [ProductController::class, 'update']);
        Route::delete('/products/{product}', [ProductController::class, 'destroy']);
    });

    Route::get('/invoices', [InvoiceController::class, 'index']);
    Route::post('/createInvoice', [InvoiceController::class, 'create']);


});
