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
     * @return \Illuminate\Http\Response
     */
    public function index(RecipeList $recipeList)
    {
        $user = $recipeList->user;

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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, RecipeList $recipeList)
    {
        $user = $recipeList->user;

        if ($user->id === auth()->user()->id) {

            $validator = Validator::make($request->only('api_id','title', 'img'), [
                'title' => 'required|string',
                'api_id' => 'required|numeric',
                'img' => 'nullable|string|url'
            ]);

            if($validator->fails()){
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RecipeList  $recipeList
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RecipeList $recipeList)
    {
        $validator = Validator::make($request->only('title'), [
            'title' => 'required|string|url'
        ]);

        // $recipeList = auth()->user()->recipeLists()->create([
        //     'title' => $request->title
        // ]);

        // $recipeList->update($this->validateRecipeList());

        // send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json($validator->errors(), 200);
            // return response()->json(['error' => $validator->messages()], 200);
        }

        $recipeList = $recipeList->update([
            'title' => $request->title
        ]);

        // list updated, return success response
        return response()->json([
            'success' => true,
            'message' => 'List title updated',
            'list' => $recipeList
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RecipeList  $recipeList
     * @return \Illuminate\Http\Response
     */
    public function destroy(RecipeList $recipeList, Recipe $recipe)
    {
        $recipeList->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'List deleted successfully'
        ], 200);
    }

    protected function validateRecipeList()
    {
        return request()->validate([
            'title' => 'required|string|between:2,50',
            'recipes' => 'exists:recipes,id'
        ]);
    }
}
