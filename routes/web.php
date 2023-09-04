<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShoppingListsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RecipesController;
use App\Http\Controllers\PhotoUploadController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('main');
});

Route::post('/get-user-shopping-lists', [ShoppingListsController::class, 'getUserLists']);
Route::post('/create-shopping-list', [ShoppingListsController::class, 'createShoppingList']);
Route::post('/get-list-info', [ShoppingListsController::class, 'getListInfo']);
Route::post('/update-list', [ShoppingListsController::class, 'updateList']);
Route::post('/update-list-info', [ShoppingListsController::class, 'updateListInfo']);
Route::post('/delete-list', [ShoppingListsController::class, 'deleteList']);

Route::get('/get-recipes', [RecipesController::class, 'getRecipes']);
Route::get('/get-recipes-kitchens', [RecipesController::class, 'getRecipesKitchens']);
Route::get('/get-recipes-categories', [RecipesController::class, 'getRecipesCategories']);
Route::get('/get-cooking-methods', [RecipesController::class, 'getCookingMethods']);
Route::get('/get-cooking-dishes', [RecipesController::class, 'getCookingDishes']);
Route::get('/get-ingredients-units', [RecipesController::class, 'getIngredientsUnits']);
Route::post('/create-recipe', [RecipesController::class, 'createRecipe']);
Route::post('/updateRecipePhotosUrl', [RecipesController::class, 'updateRecipePhotosUrl']);
Route::post('/get-recipe', [RecipesController::class, 'getRecipe']);

Route::post('/auth', [UsersController::class, 'authorize']);
Route::post('/registration', [UsersController::class, 'registerUser']);

Route::post('/upload-image', [PhotoUploadController::class, 'store']);