<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

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
use App\Http\Resources\RecipeResource;
use App\Kernel\Routing\Controller;
use App\Models\Recipe;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
    public function index(): JsonResponse
    {
        $recipes = Recipe::with(['user'])->orderByDesc('id')->paginate();

        return RecipeResource::collection($recipes)->response();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRecipeRequest $request): JsonResponse
    {
        $user = $request->user();
        $data = CreateRecipeData::fromRequest($request);

        $recipe = \app(CreateRecipeAction::class)
            ->execute($user, $data);

        return RecipeResource::make($recipe)
            ->additional(['message' => 'Recipe was created.'])
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Recipe $recipe): JsonResponse
    {
        $recipe->loadMissing(['user']);

        return RecipeResource::make($recipe)->response();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRecipeRequest $request, Recipe $recipe): JsonResponse
    {
        $data = UpdateRecipeData::fromRequest($request);

        \app(UpdateRecipeAction::class)
            ->execute($recipe, $data);

        return RecipeResource::make($recipe)
            ->additional(['message' => 'Recipe was updated.'])
            ->response();
    }

    /**
     * Display a listing of the resource owned by an authenticated user.
     */
    public function ownedByUser(Request $request): JsonResponse
    {
        /** @var \App\Models\User */
        $user = $request->user();

        $recipes = $user->recipes()->orderByDesc('id')->paginate();

        return RecipeResource::collection($recipes)->response();
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

        return \response()->json(['message' => 'Operation is successful.']);
    }

    /**
     * Display a list of resources that are in the favorites of the authenticated user.
     */
    public function favorites(Request $request): JsonResponse
    {
        /** @var \App\Models\User */
        $user = $request->user();

        $recipes = $user
            ->favoriteRecipes()
            ->with(['user'])
            ->orderByPivot('id', 'desc')
            ->paginate();

        return RecipeResource::collection($recipes)->response();
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
