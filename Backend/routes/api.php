<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController, FormsController, QuestionController, ResponseController};
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('v1')->group(function() {
    Route::prefix('authentication')->controller(AuthController::class)->group(function() {
        Route::post('login', 'login');
        Route::post('register', 'register');
        Route::post('logout', 'logout');
        Route::get('me', 'me')->middleware('isLoggedIn');
    });
    Route::prefix('forms')->middleware("isLoggedIn")->controller(FormsController::class)->group(function() {
        Route::post('/', 'createForm');
        Route::get('/', 'getAllForms');
        Route::get('/mine', 'getMyCreatedForms');
        Route::get('/{id}', 'getDetailForm');
    });
    Route::prefix('questions')->middleware("isLoggedIn")->controller(QuestionController::class)->group(function() {
        Route::get('/{id}', 'getDetailQuestion');
    });
    Route::prefix('response')->middleware("isLoggedIn")->controller(ResponseController::class)->group(function() {
        Route::get('/mine', 'getAllMyResponse');
        Route::post('/', 'createResponse');
        Route::get('/', 'getResponseUser');
    });
});