<?php

use App\Http\Controllers\AdminAuth\AuthController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('admin_auth')->group(function(){
    Route::post('login', [AuthController::class, 'adminLogin']);
    Route::get('signout', [AuthController::class, 'adminSignout']);
    Route::post('register', [AuthController::class, 'adminRegister']);
});
