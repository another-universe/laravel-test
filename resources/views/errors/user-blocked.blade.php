@extends('layouts.page')

@section('title', __('errors/blocked_user.title'))

@section('content')
<h1>{{ __('errors/blocked_user.title') }}</h1>

<div class="alert alert-danger">
{{ __('errors/blocked_user.message') }}
</div>
@endsection
