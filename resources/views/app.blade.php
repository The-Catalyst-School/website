<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
</head>
<body>
    @routes
    @inertia
    <script src="{{ mix('/js/app.js') }}" defer></script>
    <div id="background"></div>
</body>
</html>
