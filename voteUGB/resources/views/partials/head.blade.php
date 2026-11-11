<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="description" content="UGB Vote — plateforme de vote en ligne pour l'élection des représentants étudiants de l'Université Gaston Berger.">
<meta name="theme-color" content="#522504">
<title>@hasSection('titre')@yield('titre') · @endif{{ 'UGBvote' }}</title>
<link rel="icon" href="{{ asset('favicon.ico') }}">
<link rel="preload" href="{{ asset('fonts/sora-latin-wght-normal.woff2') }}" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="{{ asset('fonts/inter-latin-wght-normal.woff2') }}" as="font" type="font/woff2" crossorigin>
<link rel="stylesheet" href="{{ asset('assets/app.css') }}?v={{ filemtime(public_path('assets/app.css')) }}">
<script src="{{ asset('assets/theme.js') }}?v={{ filemtime(public_path('assets/theme.js')) }}"></script>
<script src="{{ asset('assets/app.js') }}?v={{ filemtime(public_path('assets/app.js')) }}" defer></script>
