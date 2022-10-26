@extends('components.page-header.wrapper')

@section('page_header')
<div class="navbar-nav flex-row ms-auto">
<div class="nav-item text-nowrap">
<a href="{{ route('login') }}" class="nav-link px-3">
{{ __('page_header/guest.login') }}
</a>
</div>

<div class="nav-item text-nowrap">
<a href="{{ route('register') }}" class="nav-link px-3">
{{ __('page_header/guest.register') }}
</a>
</div>
</div>
@endsection
