<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ShiftController;
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

Route::get('/', fn() => response()->json(['doesApItWerk' => 'Yes!']));


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::get('/shifts', [ShiftController::class, 'index']);
Route::post('/shifts', [ShiftController::class, 'create']);
Route::get('/shifts/{shift}', [ShiftController::class, 'show']);
Route::patch('/shifts/{shift}', [ShiftController::class, 'update']);
Route::delete('/shifts/{shift}', [ShiftController::class, 'destroy']);

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


//Route::middleware(['auth:api'])-> group(function() {
Route::middleware('auth:api')-> group(function() {

    Route::get('/products', function() {
        return response()->json(['products inside auth middleware' => 'Yes!']);
    });

});




//    Route::get('details', 'AuthController@details');
//    Route::post('logout', 'AuthController@logout');
//
//    Route::resource('transactions', 'TransactionsController');
//    Route::resource('accounts', 'AccountController');
//    Route::resource('categories', 'CategoryController');
