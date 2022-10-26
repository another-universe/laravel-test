@extends('layouts.page')

@section('title', $recipe->getTitle())

@section('content')
<h1>{{ $recipe->getTitle() }}</h1>

<p>
@can('update', $recipe)
{{
__('recipe/show_page.published_by_you')
}} {{
$recipe->getCreatedAt()->translatedFormat('j F Y \\'.__('date_time.at').' G:i')
}} <a href="{{ route('recipes.edit', compact('recipe')) }}">
{{ __('recipe/show_page.edit') }}
</a>
@else
{{
__('recipe/show_page.published_by_user')
}} {{
$recipe->getUser()?->getNickName() ?? '('.__('recipe/show_page.deleted_user').')'
}} {{
$recipe->getCreatedAt()->translatedFormat('j F Y \\'.__('date_time.at').' G:i')
}}
@endcan
</p>

@if ($recipe->getShortDescription() !== null)
<p>
{!! nl2br(e($recipe->getShortDescription()), false) !!}
</p>
@endif

<article>
{!! nl2br(e($recipe->getText()), false) !!}
</article>

<ul>
<li>
{{
__('recipe/show_page.in_favorites')
}} <span class="badge in-favorites"> {{
$recipe->getInFavorites()
}} </span>
</li>
<li>
{{
__('recipe/show_page.shared')
}} <span class="badge shared"> {{
$recipe->getTimesShared()
}} </span>
</li>
</ul>

@auth
<div class="btn-group">
<button type="button" id="favorite" class="btn btn-link" data-url="{{ route('recipes.favorite_action', compact('recipe')) }}" data-action="{{ $hasInFavorites ? 'remove' : 'add' }}">
<span @class(['d-none' => $hasInFavorites === true])>
{{ __('recipe/show_page.add_to_favorites') }}
</span>
<span @class(['d-none' => $hasInFavorites === false])>
{{ __('recipe/show_page.remove_from_favorites') }}
</span>
</button>

<button type="button" id="shareModalTrigger" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#shareModal">
{{ __('recipe/show_page.share') }}
</button>
</div>

@push('end_of_page')
<x-recipe.share-modal modal-id="shareModal" :recipe="$recipe" />
@endpush

@push('scripts')
<script src="{{ mix('assets/js/show-recipe-page.js') }}" defer></script>
@endpush

@else
<p>{{ __('recipe/show_page.no_authenticated') }}.</p>
@endauth
@endsection
