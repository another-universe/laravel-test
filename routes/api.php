<?php

declare(strict_types=1);

use App\Http\Controllers\Api as Controllers;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/registration', Controllers\RegisterController::class)
    ->name('register');

Route::post('/login', Controllers\LoginController::class)
    ->name('login');

Route::delete('/revoke-access-token', [Controllers\LogoutController::class, 'revokeCurrentAccessToken'])
    ->name('revoke_current_access_token');

Route::apiResource('recipes', Controllers\RecipeController::class)
    ->except(['destroy']);

Route::get('/recipes/my-recipes', [Controllers\RecipeController::class, 'ownedByUser'])
    ->name('recipes.my_recipes');

Route::match(['post', 'delete'], '/recipes/favorites/{recipe}', [Controllers\RecipeController::class, 'addOrRemoveFavorite'])
    ->name('recipes.favorite_action');

Route::get('/recipes/favorites', [Controllers\RecipeController::class, 'favorites'])
    ->name('recipes.favorite_recipes');

Route::post('/recipes/{recipe}/share', [Controllers\RecipeController::class, 'share'])
    ->name('recipes.share');
