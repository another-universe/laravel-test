<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="utf-8">
<link href="{{ mix('assets/css/styles.css') }}" rel="stylesheet">
<script src="{{ mix('assets/js/manifest.js') }}" defer></script>
<script src="{{ mix('assets/js/vendor.js') }}" defer></script>
<script src="{{ mix('assets/js/bootstrap.js') }}" defer></script>
@stack('scripts')
<title>@yield('title', '')</title>
</head>
<body>
@stack('start_of_page')
@yield('body', '')
@stack('end_of_page')
</body>
</html>
