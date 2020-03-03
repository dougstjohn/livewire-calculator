<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Livewire Calculator</title>

        <link href="{{ asset('css/tailwind.min.css') }}" rel="stylesheet" type="text/css">
        @livewireStyles
    </head>
    <body>
        @livewire('calculator')

        @livewireScripts
    </body>
</html>
