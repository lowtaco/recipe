<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RecipesController extends Controller
{
    public function getRecipes(Request $request) {
        $recipes = DB::table('recipes')->get();
        return $recipes;
    }

    public function getRecipesKitchens(Request $request) {
        $recipes = DB::table('national_kitchens')->get();
        return $recipes;
    }

    public function getRecipesCategories(Request $request) {
        $recipes = DB::table('recipe_categories')->get();
        return $recipes;
    }

    public function getCookingMethods(Request $request) {
        $recipes = DB::table('cooking_methods')->get();
        return $recipes;
    }

    public function getCookingDishes(Request $request) {
        $recipes = DB::table('cooking_dishes')->get();
        return $recipes;
    }

    public function getIngredientsUnits(Request $request) {
        $recipes = DB::table('ingredients_units')->get();
        return $recipes;
    }

    public function createRecipe(Request $request) {
        $author = $request->input('author');
        $name = $request->input('name');
        $description = $request->input('description');
        $main_banner = $request->input('main_banner');
        $kitchen = $request->input('kitchen');
        $category = $request->input('category');
        $servings = $request->input('servings');
        $cooking_time = $request->input('cooking_time');
        $kitchen_time = $request->input('kitchen_time');
        $meal = $request->input('meal');
        $cooking_methods = $request->input('cooking_methods');
        $dishes = $request->input('dishes');
        $ingredients = $request->input('ingredients');
        $serving = $request->input('serving');

        $id = DB::table('recipes')->insertGetId([
            'author' => $author,
            'name' => $name,
            'description' => $description,
            'kitchen' => $kitchen,
            'category' => $category,
            'servings' => $servings,
            'cooking_time' => $cooking_time,
            'kitchen_time' => $kitchen_time,
            'meal' => $meal,
            'cooking_methods' => $cooking_methods,
            'dishes' => $dishes,
            'ingredients' => $ingredients,
            'serving' => $serving,
        ]);
        return $id;
    }

    public function updateRecipePhotosUrl(Request $request) {
        $id = $request->input('id');
        $main_banner_url = $request->input('main_banner_url');
        $serving_photo_url = $request->input('serving_photo_url');
        $recipe_steps = $request->input('recipe_steps');

        $id = DB::table('recipes')->where('id', $id)->update([
            'main_banner_url' => $main_banner_url,
            'serving_photo_url' => $serving_photo_url,
            'recipe_steps' => $recipe_steps
        ]);
        return $id;
    }

    public function getRecipe(Request $request) {
        $id = $request->input('id');
        
        $recipe = DB::table('recipes')->where('id', $id)->get();
        return $recipe;
    }
}