@extends('layouts.page')

@section('title', __('recipe/edit_page.page_title'))

@section('content')
<h1>{{ __('recipe/edit_page.page_title') }}</h1>

@if (session()->exists('recipe_was_updated'))
<div id="recipeWasUpdated" class="alert alert-success alert-dismissible" role="alert" aria-live="assertive" aria-atomic="true">
<p>{{ __('recipe/edit_page.updated') }}.</p>
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<x-recipe.form :action-url="route('recipes.update', compact('recipe'))" :recipe="$recipe" />
@endsection

@push('scripts')
<script src="{{ mix('assets/js/edit-recipe-page.js') }}" defer></script>
@endpush
