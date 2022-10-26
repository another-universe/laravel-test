@extends('layouts.basic')

@section('body')
<x-page-header />

<div class="container-fluid">

<div class="row">

<main class="col-12 ms-sm-auto px-md-4 fs-6">
<div class="d-flex flex-column justify-content-center align-items-stretch pt-3 pb-2 mb-3">
@yield('content')
</div>
</main>

</div>

</div>
@endsection
