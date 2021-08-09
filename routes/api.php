<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::post('auth/register', [AuthController::class, 'register'])->middleware('guest');

// Route::group([
//     'middleware' => 'api',
//     'prefix' => 'auth'

// ], function ($router) {
    Route::post('auth/login', [AuthController::class, 'login'])->middleware('api');
//     Route::post('/register', [AuthController::class, 'register']);
    Route::post('auth/logout', [AuthController::class, 'logout'])->middleware('api');
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('auth/user-profile', [AuthController::class, 'userProfile'])->middleware('api');
// });

// Route::group([
//     'middleware' => 'api',
//     'prefix' => 'lists'

// ], function ($router) {
//     Route::get('/',[ RecipeListController::class, 'index']);
//     Route::post('/store',[ RecipeListController::class, 'store']);
//     Route::get('/{id}',[ RecipeListController::class, 'show']);
//     Route::put('/{id}',[ RecipeListController::class, 'update']);
//     Route::delete('/{id}',[ RecipeListController::class, 'destroy']);
// });
