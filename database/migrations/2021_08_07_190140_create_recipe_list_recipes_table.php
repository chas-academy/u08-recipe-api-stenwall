<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipeListRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipe_list_recipes', function (Blueprint $table) {
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
        Schema::dropIfExists('recipe_list_recipes');
        // Schema::table('recipe_list_recipes', function (Blueprint $table) {
        //     $table->dropUnique('recipe_list_recipe_unique');
        //   });
    }
}
