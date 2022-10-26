<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Actions\Recipe\AddRecipeToFavoritesAction;
use App\Actions\Recipe\CreateRecipeAction;
use App\Actions\Recipe\RemoveRecipeFromFavoritesAction;
use App\Actions\Recipe\ShareRecipeAction;
use App\Actions\Recipe\UpdateRecipeAction;
use App\DataTransferObjects\Recipe\CreateRecipeData;
use App\DataTransferObjects\Recipe\ShareRecipeData;
use App\DataTransferObjects\Recipe\UpdateRecipeData;
use App\Http\Controllers\Concerns\Recipe\AuthorizesRequests;
use App\Http\Requests\Recipe\CreateRecipeRequest;
use App\Http\Requests\Recipe\ShareRecipeRequest;
use App\Http\Requests\Recipe\UpdateRecipeRequest;
use App\Kernel\Routing\Controller;
use App\Models\Recipe;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class RecipeController extends Controller
{
    use AuthorizesRequests;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(['auth'])
            ->except(['index', 'show']);

        $this->authorizeResource(Recipe::class, 'recipe');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $recipesPaginator = Recipe::orderByDesc('id')->cursorPaginate();

        return \response()->view('recipe.index', \compact('recipesPaginator'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return \response()->view('recipe.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRecipeRequest $request): RedirectResponse
    {
        $user = $request->user();
        $data = CreateRecipeData::fromRequest($request);

        \app(CreateRecipeAction::class)
            ->execute($user, $data);

        return \redirect()
            ->route('recipes.create')
            ->with('recipe_was_created', true);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Recipe $recipe): Response
    {
        $recipe->loadMissing(['user']);
        $hasInFavorites = $request->user()?->hasRecipeInFavorites($recipe) ?? false;

        return \response()->view('recipe.show', \compact('recipe', 'hasInFavorites'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recipe $recipe): Response
    {
        return \response()->view('recipe.edit', \compact('recipe'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRecipeRequest $request, Recipe $recipe): RedirectResponse
    {
        $data = UpdateRecipeData::fromRequest($request);

        \app(UpdateRecipeAction::class)
            ->execute($recipe, $data);

        return \redirect()
            ->route('recipes.edit', \compact('recipe'))
            ->with('recipe_was_updated', true);
    }

    /**
     * Display a listing of the resource owned by an authenticated user.
     */
    public function ownedByUser(Request $request): Response
    {
        /** @var \App\Models\User */
        $user = $request->user();

        $recipesPaginator = $user->recipes()->orderByDesc('id')->cursorPaginate();

        return \response()->view('recipe.user-recipes', \compact('recipesPaginator'));
    }

    /**
     * Add or remove recipe from favorites.
     */
    public function addOrRemoveFavorite(Request $request, Recipe $recipe): JsonResponse
    {
        /** @var \App\Models\User */
        $user = $request->user();

        $action = match ($request->method()) {
            'POST' => \app(AddRecipeToFavoritesAction::class),
            'DELETE' => \app(RemoveRecipeFromFavoritesAction::class),
        };

        $action->execute($user, $recipe);

        return \response()->json([
            'message' => 'Operation is successful.',
            'actual_value' => $recipe->fresh()?->getInFavorites(),
        ]);
    }

    /**
     * Display a list of resources that are in the favorites of the authenticated user.
     */
    public function favorites(Request $request): Response
    {
        /** @var \App\Models\User */
        $user = $request->user();

        $recipesPaginator = $user
            ->favoriteRecipes()
            ->orderByPivot('id', 'desc')
            ->simplePaginate();

        return \response()->view('recipe.favorites', \compact('recipesPaginator'));
    }

    /**
     * Share recipe.
     */
    public function share(ShareRecipeRequest $request, Recipe $recipe): JsonResponse
    {
        $user = $request->user();
        $data = ShareRecipeData::fromRequest($request);

        \app(ShareRecipeAction::class)
            ->withLocale()
            ->execute($user, $recipe, $data);

        return \response()->json(['message' => 'Operation is successful.']);
    }
}
