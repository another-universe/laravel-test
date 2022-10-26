@extends('components.page-header.wrapper')

@section('page_header')
<div class="navbar-nav flex-row">
<div class="nav-item text-nowrap">
<a href="{{ route('recipes.my_recipes') }}" class="nav-link px-3">
{{ __('page_header/user.your_recipes') }}
</a>
</div>

<div class="nav-item text-nowrap">
<a href="{{ route('recipes.create') }}" class="nav-link px-3">
{{ __('page_header/user.create') }}
</a>
</div>

<div class="nav-item text-nowrap">
<a href="{{ route('recipes.favorite_recipes') }}" class="nav-link px-3">
{{ __('page_header/user.favorites') }}
</a>
</div>
</div>

<div class="navbar-nav flex-row ms-auto">
<div class="nav-item text-nowrap">
<button type="submit" role="link" form="_logout" class="nav-link px-3">
{{ __('page_header/user.logout') }}
</button>
</div>
</div>
@endsection

@push('end_of_page')
<form id="_logout" style="display: none;" action="{{ route('logout.current_device') }}" method="post">
@csrf
</form>
@endpush
