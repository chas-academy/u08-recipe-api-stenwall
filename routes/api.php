<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RecipeListController;
use App\Http\Controllers\RecipeController;

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
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'lists'

], function ($router) {
    Route::get('/',[ RecipeListController::class, 'index']); // get all lists belonging to logged in user
    Route::post('/',[ RecipeListController::class, 'store']); // create a new list
    Route::put('/{recipeList}',[ RecipeListController::class, 'update']); // update given list
    Route::delete('/{recipeList}',[ RecipeListController::class, 'destroy']); // delete given list
    Route::get('/{recipeList}/recipes',[ RecipeController::class, 'index']); // get all recipes belonging to given list
    Route::post('/{recipeList}/recipes',[ RecipeController::class, 'store']); // add a new recipe to given list
    Route::delete('/{recipeList}/recipes/{recipe}',[ RecipeController::class, 'destroy']); // remove given recipe from given list
    Route::get('/{recipeList}/recipes/{apiId}', [ RecipeController::class, 'checkIfExists']); // check if recipe exists given list
    Route::get('/{apiId}', [ RecipeController::class, 'listsWithRecipe']); // check if recipe exists in users lists
});
