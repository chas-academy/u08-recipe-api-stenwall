<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $table = 'recipes';
    public $timestamps = true;

    public function recipeLists()
    {
        return $this->belongsToMany(RecipeList::class);
    }
}
