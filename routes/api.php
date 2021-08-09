<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RecipeListController;

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

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    // Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'lists'

], function ($router) {
    Route::get('/',[ RecipeListController::class, 'index']);
    Route::post('/',[ RecipeListController::class, 'store']);
    Route::get('/{recipeList}',[ RecipeListController::class, 'show']);
    Route::patch('/{recipeList}',[ RecipeListController::class, 'update']);
    Route::delete('/{recipeList}',[ RecipeListController::class, 'destroy']);
});
