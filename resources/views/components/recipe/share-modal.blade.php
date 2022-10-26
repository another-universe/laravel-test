<div id="{{ $modalId }}" class="modal fade" tabindex="-1" aria-labelledby="shareModalTitle" data-url="{{ route('recipes.share', compact('recipe')) }}">
<div class="modal-dialog modal-scrollable">
<div class="modal-content">
<header>
<h5 id="shareModalTitle" class="modal-title">
{{ __('recipe/share_modal.title') }}
</h5>

<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</header>

<div class="modal-body">
<ul>
@foreach (__('recipe/share_modal.hints') as $text)
<li>{!! nl2br(e($text), false) !!}</li>
@endforeach
</ul>

<form id="shareForm" role="form">
<fieldset>
<div class="mb-3">
<label class="form-label" for="channel">
{{ __('recipe/share_modal.channel') }}
</label>

<select id="channel" class="form-select" name="channel" required>
<option value="" disabled selected></option>
@foreach ($channels() as $value => $text)
<option value="{{ $value }}">{{ Str::ucfirst($text) }}</option>
@endforeach
</select>

<div class="invalid-feedback"></div>
</div>

<div class="mb-3">
<label class="form-label" for="sender">
{{ __('recipe/share_modal.sender') }}
</label>

<input type="text" id="sender" class="form-control" name="sender">

<div class="invalid-feedback"></div>
</div>

<div>
<label class="form-label" for="recipient">
{{ __('recipe/share_modal.recipient') }}
</label>

<input type="text" id="recipient" class="form-control" name="recipient" required>

<div class="invalid-feedback"></div>
</div>
</fieldset>
</form>

<div class="alert alert-success alert-dismissible d-none" role="alert" aria-live="assertive" aria-atomic="true">
<div>{{ __('recipe/share_modal.success') }}</div>
<button type="button" class="btn-close" aria-label="Close"></button>
</div>

<div class="alert alert-danger alert-dismissible d-none" role="alert" aria-live="assertive" aria-atomic="true">
<div>{{ __('recipe/share_modal.fail') }}</div>
<button type="button" class="btn-close" aria-label="Close"></button>
</div>
</div>

<div class="modal-footer">
<button type="button" class="btn btn-danger" data-bs-dismiss="modal">
{{ __('recipe/share_modal.close') }}
</button>

<button type="button" id="share" class="btn btn-success">
{{ __('recipe/share_modal.share') }}
</button>
</div>
</div>
</div>
</div>
