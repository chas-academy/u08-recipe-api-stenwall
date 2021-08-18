<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Recipe;
use App\Models\RecipeList;

class RecipeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(RecipeList $recipeList)
    {
        $user = $recipeList->user;

        // check if given list belongs to current user
        if ($user->id === auth()->user()->id) {
            $recipes = $recipeList->recipes;

            if ($recipes->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'This list does not have any recipes yet.'
                ], 200);
            } else {
                return response()->json([
                    'success' => true,
                    'recipes' => $recipes
                ], 200);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No recipe list with this id belongs to current user.'
            ], 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, RecipeList $recipeList)
    {
        $user = $recipeList->user;

        // check if given list belongs to current user
        if ($user->id === auth()->user()->id) {
            $validator = Validator::make($request->only('api_id', 'title', 'img'), [
                'title' => 'required|string',
                'api_id' => 'required|numeric',
                'img' => 'nullable|string|url'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 200);
            }

            // find given recipe in table 'recipes'
            $recipe = Recipe::where('api_id', $request->api_id)->first();
    
            // if recipe doesn't exist in 'recipes', create it
            if (!$recipe) {
                $recipe = $recipeList->recipes()->create([
                    'title' => $request->title,
                    'api_id' => $request->api_id,
                    'img' => $request->img
                ]);
            } else {
                // if recipe exists in 'recipes', check if it is attach to given list, else attach it
                if ($recipeList->recipes()->where('recipe_id', $recipe->id)->exists()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'The recipe is already in this list.'
                    ], 200);
                } else {
                    $recipeList->recipes()->attach($recipe->id);
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Recipe successfully saved to list',
                'recipe' => $recipe
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No recipe list with this id belongs to current user.'
            ], 401);
        }
    }

    /**
    * Check if resource exists.
    *
    * @param  \App\Models\RecipeList  $recipeList
    * @param  \App\Models\Recipe  $recipe
    * @return \Illuminate\Http\JsonResponse
    */
    public function checkIfExists(RecipeList $recipeList, $apiId)
    {
        $user = $recipeList->user;

        // check if given list belongs to current user
        if ($user->id === auth()->user()->id) {

            $recipe = Recipe::where('api_id', $apiId)->first();

            // find given recipe in table 'recipes'
            if (!$recipe) {
                return response()->json([
                    'success' => true,
                    'exists' => false,
                    'message' => 'This recipe does not exist in any list.'
                ], 200);
    
            } else {
                // check if given recipe is attach to given list
                if ($recipeList->recipes()->where('recipe_id', $recipe->id)->doesntExist()) {
                    return response()->json([
                        'success' => true,
                        'exists' => false,
                        'message' => 'This recipe does not exist in any of this users lists.'
                    ], 200);

                } else {
                    return response()->json([
                        'success' => true,
                        'exists' => true,
                        'recipe' => $recipe
                    ], 200);
                }
            }

        } else {
            return response()->json([
                'success' => false,
                'message' => 'No recipe list with this id belongs to current user.'
            ], 401);
        }
    }

    /**
    * Check if resource exists.
    *
    * @param  \App\Models\Recipe  $recipe
    * @param  \App\Models\RecipeList  $recipeList
    * @return \Illuminate\Http\JsonResponse
    */
    public function listsWithRecipe($apiId)
    {
        $recipeList = auth()->user()->recipeLists()->whereHas('recipes', function ($query) use ($apiId) {
            $query->where('api_id', '=', intval($apiId));
        })->get();

        return response()->json([
            'success' => true,
            'list' => $recipeList
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RecipeList  $recipeList
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(RecipeList $recipeList, Recipe $recipe)
    {
        $user = $recipeList->user;

        // check if given list belongs to current user
        if ($user->id === auth()->user()->id) {
            // check if given recipe is attach to given list, if so detach it
            if ($recipeList->recipes()->where('recipe_id', $recipe->id)->doesntExist()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No recipe with this id exists in current list.'
                ], 200);
            } else {
                $recipeList->recipes()->detach($recipe->id);

                return response()->json([
                    'success' => true,
                    'message' => 'Recipe successfully removed from list'
                ], 200);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No recipe list with this id belongs to current user.'
            ], 401);
        }
    }
}
