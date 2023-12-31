<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class RecipesController extends Controller
{
    public function getRecipes(Request $request) {
        $offset = $request->input('offset');
        $category = $request->input('category');

        if ($category) {
            $recipes = DB::table('recipes')->orderBy('id', 'desc')->where('category', $category)->offset($offset)->take(9)->get();
        } else {
            $recipes = DB::table('recipes')->orderBy('id', 'desc')->offset($offset)->take(9)->get();
        }
        return $recipes;
    }

    public function getUserRecipes(Request $request) {
        $offset = $request->input('offset');
        $user_id = $request->input('user_id');
        $recipes = DB::table('recipes')->orderBy('id', 'desc')->where('author', $user_id)->offset($offset)->take(9)->get();
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

    public function getMeals(Request $request) {
        $meals = DB::table('recipe_meal')->get();
        return $meals;
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
        $spiciness = $request->input('spiciness');
        $difficulty = $request->input('difficulty');
        $cooking_time = $request->input('cooking_time');
        $kitchen_time = $request->input('kitchen_time');
        $meal = $request->input('meal');
        $cooking_methods = $request->input('cooking_methods');
        $dishes = $request->input('dishes');
        $ingredients = $request->input('ingredients');
        $kcal = $request->input('kcal');
        $protein = $request->input('protein');
        $fat = $request->input('fat');
        $carbs = $request->input('carbs');

        $id = DB::table('recipes')->insertGetId([
            'author' => $author,
            'name' => $name,
            'description' => $description,
            'kitchen' => $kitchen,
            'category' => $category,
            'servings' => $servings,
            'spiciness' => $spiciness,
            'difficulty' => $difficulty,
            'cooking_time' => $cooking_time,
            'kitchen_time' => $kitchen_time,
            'meal' => $meal,
            'cooking_methods' => $cooking_methods,
            'dishes' => $dishes,
            'ingredients' => $ingredients,
            'kcal' => $kcal,
            'protein' => $protein,
            'fat' => $fat,
            'carbs' => $carbs
        ]);
        $user_recipes_amount = DB::table('app_users')->where('id', $author)->value('recipes_amount');
        DB::table('app_users')->where('id', $author)->update(['recipes_amount' => $user_recipes_amount + 1]);

        return $id;
    }

    public function updateRecipePhotosUrl(Request $request) {
        $id = $request->input('id');
        $main_banner_url = $request->input('main_banner_url');
        $serving = $request->input('serving');
        $recipe_steps = $request->input('recipe_steps');

        $id = DB::table('recipes')->where('id', $id)->update([
            'main_banner_url' => $main_banner_url,
            'serving' => $serving,
            'recipe_steps' => $recipe_steps
        ]);
        return $id;
    }

    public function getRecipe(Request $request) {
        $id = $request->input('id');
        
        $recipe = DB::table('recipes')->where('id', $id)->get();
        return $recipe;
    }

    public function getRecipeKitchen(Request $request) {
        $id = $request->input('id');
        
        $kitchen = DB::table('national_kitchens')->where('id', $id)->get();
        return $kitchen;
    }

    public function getRecipeCategory(Request $request) {
        $id = $request->input('id');
        
        $category = DB::table('recipe_categories')->where('id', $id)->get();
        return $category;
    }

    public function getRecipeMeal(Request $request) {
        $id = $request->input('id');
        
        $meal = DB::table('recipe_meal')->where('id', $id)->get();
        return $meal;
    }

    public function getRecipeDishes(Request $request) {
        $id = $request->input('id');
        
        $dishes = DB::table('cooking_dishes')->where('id', $id)->get();
        return $dishes;
    }

    public function getRecipeCookingMethods(Request $request) {
        $id = $request->input('id');
        
        $cooking_method = DB::table('cooking_methods')->where('id', $id)->get();
        return $cooking_method;
    }

    public function getProducts(Request $request) {
        $products = DB::table('products')->get();
        return $products;
    }

    public function getProductInfo(Request $request) {
        $id = $request->input('id');

        $product = DB::table('products')->where('id', $id)->get();
        return $product;
    }

    
}
