<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('../css/app.css') }}">

</head>

<body>
    <x-navbar/>

    {{ $slot }}
</body>
<script src="{{ asset('/js/app.js') }}" defer></script>

</html>
