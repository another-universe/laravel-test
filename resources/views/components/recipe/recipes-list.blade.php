@if ($isGrouped())
@foreach ($recipeCollection() as $date => $recipes)
<div class="h3">{{ $date }}</div>

<div class="list-group">
@foreach ($recipes as $recipe)
<a href="{{ route('recipes.show', compact('recipe')) }}" class="list-group-item list-group-item-action">
<h5 class="mb-1">{{ $recipe->getTitle() }}</h5>
<p>{{ $description($recipe) }}</p>
</a>
@endforeach
</div>
@endforeach

@else
<div class="list-group">
@foreach ($recipeCollection() as $recipe)
<a href="{{ route('recipes.show', compact('recipe')) }}" class="list-group-item list-group-item-action">
<h5 class="mb-1">{{ $recipe->getTitle() }}</h5>
<p>{{ $description($recipe) }}</p>
</a>
@endforeach
</div>
@endif

{{ $paginationLinks() }}
