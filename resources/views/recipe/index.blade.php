@extends('layouts.page')

@section('title', __('recipe/index_page.page_title'))

@section('content')
<h1>{{ __('recipe/index_page.page_title') }}</h1>

@if ($recipesPaginator->isNotEmpty())
<x-recipe.recipes-list :paginator="$recipesPaginator" :group="true" />
@else
<p>{{ __('recipe/index_page.no_results') }}.</p>
@endif
@endsection
