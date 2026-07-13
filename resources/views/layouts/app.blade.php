<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $profile?->title ?? 'Portfolio' }} — {{ $profile?->name ?? config('app.name') }}">

    <title>{{ $profile?->name ?? config('app.name') }} | Portfolio</title>

    <link rel="icon" href="{{ asset('favicon.svg') }}" type="image/svg+xml">

    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen selection:bg-purple-200">
    @yield('content')
</body>
</html>
