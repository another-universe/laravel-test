@extends('layouts.page')

@section('title', __('recipe/favorites_page.page_title'))

@section('content')
<h1>{{ __('recipe/favorites_page.page_title') }}</h1>

@if ($recipesPaginator->isNotEmpty())
<x-recipe.recipes-list :paginator="$recipesPaginator" :group="false" />
@else
<p>{{ __('recipe/favorites_page.no_results') }}.</p>
@endif
@endsection
