<form role="form" id="recipeForm" action="{{ $actionUrl }}" method="post">
@csrf

@if ($recipe !== null)
@method('put')
@endif

<fieldset>
<div class="mb-3 row">
<label class="col-3 col-form-label" for="title">
{{ __('recipe/form.title') }}
</label>

<div class="col-9">
<input type="text" id="title" name="title" @class(['form-control', 'is-invalid' => $errors->has('title')]) maxlength="150" autofocus required value="{{ old('title', $recipe?->getTitle()) }}">

@error('title')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>
</div>

<div class="mb-3 row">
<label class="col-3 col-form-label" for="shortDescription">
{{ __('recipe/form.short_description') }}
</label>

<div class="col-9">
<textarea id="shortDescription" name="short_description" @class(['form-control', 'is-invalid' => $errors->has('short_description')]) maxlength="255">{{ old('short_description', $recipe?->getShortDescription()) }}</textarea>

@error('short_description')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>
</div>

<div class="mb-3 row">
<label class="col-3 col-form-label" for="text">
{{ __('recipe/form.text') }}
</label>

<div class="col-9">
<textarea id="text" name="text" @class(['form-control', 'is-invalid' => $errors->has('text')]) maxlength="10000" rows="2" required>{{ old('text', $recipe?->getText()) }}</textarea>

@error('text')
<div class="invalid-feedback">{{ $message }}</div>
@enderror
</div>
</div>

<div class="mb-3 row">
<div class="offset-3 col-9">
<button type="submit" class="btn btn-primary">
@if ($recipe !== null)
{{ __('recipe/form.save') }}
@else
{{ __('recipe/form.create') }}
@endif
</button>
</div>
</div>
</fieldset>
</form>
