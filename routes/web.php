<?php

declare(strict_types=1);

use App\Http\Controllers\Web as Controllers;
use Illuminate\Support\Facades\Route;

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

Route::get('/', Controllers\HomeController::class)
    ->name('home');

Route::any('/logout', [Controllers\LogoutController::class, 'logoutCurrentDevice'])
    ->name('logout.current_device');

Route::get('/registration', [Controllers\RegisterController::class, 'showRegisterPage'])
    ->name('register');

Route::post('/registration', [Controllers\RegisterController::class, 'handle'])
    ->name('register.handle');

Route::get('/login', [Controllers\LoginController::class, 'showLoginPage'])
    ->name('login');

Route::post('/login', [Controllers\LoginController::class, 'handle'])
    ->name('login.handle');

Route::resource('recipes', Controllers\RecipeController::class)
    ->except(['destroy']);

Route::get('/recipes/my-recipes', [Controllers\RecipeController::class, 'ownedByUser'])
    ->name('recipes.my_recipes');

Route::match(['post', 'delete'], '/recipes/favorites/{recipe}', [Controllers\RecipeController::class, 'addOrRemoveFavorite'])
    ->name('recipes.favorite_action');

Route::get('/recipes/favorites', [Controllers\RecipeController::class, 'favorites'])
    ->name('recipes.favorite_recipes');

Route::post('/recipes/{recipe}/share', [Controllers\RecipeController::class, 'share'])
    ->name('recipes.share');
