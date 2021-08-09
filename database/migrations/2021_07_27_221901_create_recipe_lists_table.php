<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipeListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipe_lists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->timestamps();
        });

        // create pivot table for recipe_lists_recipes
        Schema::create('recipe_lists_recipes', function (Blueprint $table) {
            $table->id();
            $table->´foreignId('list_id')->constrained()->cascadeOnDelete();
            $table->´foreignId('recipe_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['list_id', 'recipe_id'], 'list_recipe_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipe_lists');
    }
}
