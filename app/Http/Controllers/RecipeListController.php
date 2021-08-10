<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\RecipeList;
use App\Models\User;


class RecipeListController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recipeList = RecipeList::all();

        return response()->json([
            'success' => true,
            'list' => $recipeList
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RecipeList  $recipeList
     * @return \Illuminate\Http\Response
     */
    public function show(RecipeList $recipeList)
    {
        if (!$recipeList) {
            return response()->json([
                'success' => false,
                'message' => 'Sorry, list not found.'
            ], 400);
        }
    
        return response()->json([
            'success' => true,
            'list' => $recipeList
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->only('title'), [
            'title' => 'required|string|between:2,50'
        ]);

        if($validator->fails()){
            return response()->json($validator->errors(), 200);
       }

        // request is valid, create new list
        $recipeList = auth()->user()->recipeLists()->create([
            'title' => $request->title
        ]);

        return response()->json([
            'success' => true,
            'message' => 'List created successfully',
            'list' => $recipeList
        ], 201);
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
            'title' => 'required|string|between:2,50'
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
    public function destroy(RecipeList $recipeList)
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
