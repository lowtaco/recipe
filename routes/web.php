<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShoppingListsController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\RecipesController;
use App\Http\Controllers\PhotoUploadController;
use App\Http\Controllers\SpaController;

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

Route::get('/', [SpaController::class, 'index']);

Route::post('/get-user-shopping-lists', [ShoppingListsController::class, 'getUserLists']);
Route::post('/getShoppingListByRecipe', [ShoppingListsController::class, 'getShoppingListByRecipe']);
Route::post('/create-shopping-list', [ShoppingListsController::class, 'createShoppingList']);
Route::post('/get-list-info', [ShoppingListsController::class, 'getListInfo']);
Route::post('/update-list', [ShoppingListsController::class, 'updateList']);
Route::post('/update-list-info', [ShoppingListsController::class, 'updateListInfo']);
Route::post('/delete-list', [ShoppingListsController::class, 'deleteList']);
Route::post('/invite-user-to-list', [ShoppingListsController::class, 'inviteUserToList']);
Route::post('/findShareListPending', [ShoppingListsController::class, 'findShareListPending']);
Route::post('/countSharedListsInvites', [ShoppingListsController::class, 'countSharedListsInvites']);
Route::post('/get-shopping-list-invites', [ShoppingListsController::class, 'getShoppingListInvites']);
Route::post('/getSharedListStatus', [ShoppingListsController::class, 'getSharedListStatus']);
Route::post('/updateSharedStatus', [ShoppingListsController::class, 'updateSharedStatus']);
Route::post('/declineInviteList', [ShoppingListsController::class, 'declineInviteList']);
Route::post('/aproveInviteList', [ShoppingListsController::class, 'aproveInviteList']);

Route::post('/get-recipes', [RecipesController::class, 'getRecipes']);
Route::get('/get-recipes-kitchens', [RecipesController::class, 'getRecipesKitchens']);
Route::get('/get-recipes-categories', [RecipesController::class, 'getRecipesCategories']);
Route::get('/get-cooking-methods', [RecipesController::class, 'getCookingMethods']);
Route::get('/get-cooking-dishes', [RecipesController::class, 'getCookingDishes']);
Route::get('/get-meals', [RecipesController::class, 'getMeals']);
Route::get('/get-ingredients-units', [RecipesController::class, 'getIngredientsUnits']);
Route::post('/create-recipe', [RecipesController::class, 'createRecipe']);
Route::post('/updateRecipePhotosUrl', [RecipesController::class, 'updateRecipePhotosUrl']);

Route::post('/get-recipe', [RecipesController::class, 'getRecipe']);
Route::post('/get-recipe-kitchen', [RecipesController::class, 'getRecipeKitchen']);
Route::post('/get-recipe-category', [RecipesController::class, 'getRecipeCategory']);
Route::post('/get-recipe-meal', [RecipesController::class, 'getRecipeMeal']);
Route::post('/get-recipe-dishes', [RecipesController::class, 'getRecipeDishes']);
Route::post('/get-recipe-cooking-methods', [RecipesController::class, 'getRecipeCookingMethods']);

Route::post('/auth', [UsersController::class, 'authorize']);
Route::post('/registration', [UsersController::class, 'registerUser']);
Route::post('/get-user-info', [UsersController::class, 'getUserInfo']);
Route::post('/findUserByNickname', [UsersController::class, 'findUserByNickname']);

Route::post('/upload-image', [PhotoUploadController::class, 'store']);