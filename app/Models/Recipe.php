<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $table = 'recipes';
    public $timestamps = true;

    protected $fillable = [
        'title',
        'api_id',
        'img'
    ];

    public function recipeLists()
    {
        return $this->belongsToMany(RecipeList::class, 'recipe_lists_recipes', 'recipe_id', 'recipe_list_id');
    }
}
