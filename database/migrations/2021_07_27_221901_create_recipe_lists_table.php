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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->timestamps();
            
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

        // create pivot table for recipe_lists_recipes
        Schema::create('recipe_lists_recipes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('list_id');
            $table->unsignedBigInteger('recipe_id');
            $table->timestamps();

            $table->foreign('list_id')
                ->references('id')
                ->on('recipe_lists')
                ->onDelete('cascade');

            $table->foreign('recipe_id')
                ->references('id')
                ->on('recipes')
                ->onDelete('cascade');

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
