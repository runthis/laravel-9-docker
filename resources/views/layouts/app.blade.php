<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Laravel 9 template">

    <title>@yield('app-title')</title>

    <link rel="stylesheet" type="text/css" href="{{ mix('css/app.css') }}">

    @stack('styles')

</head>
<body>
    @yield('app-content')

    <script src="{{ mix('js/app.js') }}"></script>

    @stack('scripts')

</body>
</html>
