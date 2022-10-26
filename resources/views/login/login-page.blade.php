@extends('layouts.page')

@section('title', __('login/login_page.page_title'))

@section('content')
<h1>{{ __('login/login_page.page_title') }}</h1>

<form id="loginForm" role="form" action="{{ route('login.handle') }}" method="post">
@csrf

<fieldset>
<div class="mb-3 row">
<label class="col-3 col-form-label" for="email">
{{ __('login/login_page.email') }}
</label>

<div class="col-9">
<input type="email" id="email" name="email" @class(['form-control', 'is-invalid' => $errors->has('email')]) autofocus required value="{{ old('email') }}">

@error('email')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>
</div>

<div class="mb-3 row">
<label class="col-3 col-form-label" for="password">
{{ __('login/login_page.password') }}
</label>

<div class="col-9">
<div class="input-group">
<input type="password" id="password" name="password" @class(['form-control', 'is-invalid' => $errors->has('password')]) required value="{{ old('password') }}">

<button type="button" id="passwordVisibilityToggler" data-target="#password" class="btn btn-outline-secondary">
<span>{{ __('login/login_page.password_show') }}</span>
<span class="d-none">{{ __('login/login_page.password_hide') }}</span>
</button>

@error('password')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>
</div>
</div>

<div class="mb-3 row">
<div class="col-6">
<div class="form-check">
<input type="checkbox" id="remember" name="remember" class="form-check-input"{{ empty(old('remember')) ? '' : ' checked' }}>
<label class="form-check-label" for="remember">
{{ __('login/login_page.remember') }}
</label>
</div>
</div>

<div class="col-6">
<button type="submit" class="btn btn-primary">
{{ __('login/login_page.submit') }}
</button>
</div>
</div>
</fieldset>
</form>
@endsection

@push('scripts')
<script src="{{ mix('assets/js/login-page.js') }}" defer></script>
@endpush
