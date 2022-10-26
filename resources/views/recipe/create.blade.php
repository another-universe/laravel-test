@extends('layouts.page')

@section('title', __('recipe/create_page.page_title'))

@section('content')
<h1>{{ __('recipe/create_page.page_title') }}</h1>

@if (session()->exists('recipe_was_created'))
<div id="recipeWasCreated" class="alert alert-success alert-dismissible" role="alert" aria-live="assertive" aria-atomic="true">
<p>{{ __('recipe/create_page.created') }}!</p>
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<x-recipe.form :action-url="route('recipes.store')" :recipe="null" />
@endsection

@push('scripts')
<script src="{{ mix('assets/js/create-recipe-page.js') }}" defer></script>
@endpush
