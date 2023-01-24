<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AdminAuthController;

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

Route::post('/user/create', [UserController::class, 'createNewUser']);
Route::post('/user/access', [UserController::class, 'accessUserAccount']);

Route::prefix('admin')->group(function(){
    Route::post('register', [AdminAuthController::class, 'adminRegister']);
    Route::post('login', [AdminAuthController::class, 'adminLogin']);
    Route::middleware(['auth:sanctum', 'ability:subject-create'])->group(function (){
        Route::post('create_subject', [SubjectController::class, 'create']);
        Route::post('create_question', [QuestionController::class, 'create']);
        Route::post('create_answer', [AnswerController::class, 'create']);
    });
});
