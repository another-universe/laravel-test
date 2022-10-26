@extends('layouts.page')

@section('title', __('recipe/user_recipes_page.page_title'))

@section('content')
<h1>{{ __('recipe/user_recipes_page.page_title') }}</h1>

@if ($recipesPaginator->isNotEmpty())
<x-recipe.recipes-list :paginator="$recipesPaginator" :group="true" />
@else
<p>{{ __('recipe/user_recipes_page.no_results') }}.</p>
@endif
@endsection
