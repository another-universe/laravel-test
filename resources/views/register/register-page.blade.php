@extends('layouts.page')

@section('title', __('register/register_page.page_title'))

@section('content')
<h1>{{ __('register/register_page.page_title') }}</h1>

<form id="registerForm" role="form" action="{{ route('register.handle') }}" method="post">
@csrf

<fieldset>
<div class="mb-3 row">
<label class="col-3 col-form-label" for="nickName">
{{ __('register/register_page.nick_name') }}
</label>

<div class="col-9">
<input type="text" id="nickName" name="nick_name" @class(['form-control', 'is-invalid' => $errors->has('nick_name')]) autofocus required value="{{ old('nick_name') }}">

@error('nick_name')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>
</div>

<div class="mb-3 row">
<label class="col-3 col-form-label" for="email">
{{ __('register/register_page.email') }}
</label>

<div class="col-9">
<input type="email" id="email" name="email" @class(['form-control', 'is-invalid' => $errors->has('email')]) required value="{{ old('email') }}">

@error('email')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>
</div>

<div class="mb-3 row">
<label class="col-3 col-form-label" for="password">
{{ __('register/register_page.password') }}
</label>

<div class="col-9">
<div class="input-group">
<input type="password" id="password" name="password" @class(['form-control', 'is-invalid' => $errors->has('password')]) required value="{{ old('password') }}">

<button type="button" id="passwordVisibilityToggler" data-target="#password" class="btn btn-outline-secondary">
<span>{{ __('register/register_page.password_show') }}</span>
<span class="d-none">{{ __('register/register_page.password_hide') }}</span>
</button>

@error('password')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>
</div>
</div>

<div class="mb-3 row">
<div class="offset-3 col-9">
<button type="submit" class="btn btn-primary">
{{ __('register/register_page.submit') }}
</button>
</div>
</div>
</fieldset>
</form>
@endsection

@push('scripts')
<script src="{{ mix('assets/js/register-page.js') }}" defer></script>
@endpush
