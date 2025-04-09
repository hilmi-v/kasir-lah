<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title.' - '.config('app.name') : config('app.name') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('logo.svg') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen h-full font-sans antialiased bg-base-200 grid md:grid-cols-2">
    <div class="w-full flex items-center justify-center  md:h-dvh ">
        <img src="{{ asset('logo.svg') }}" alt="" class="md:h-96 h-44">
    </div>
    <div class="w-full md:h-dvh">
        {{ $slot }}
    </div>
    <x-toast />

</body>

</html>