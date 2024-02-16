<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- BOOTSTRAP -->
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <!-- MATERIAL ICON -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/@mdi/font@6.5.95/css/materialdesignicons.min.css">
    <!-- CUSTOM STYLE -->
    <link href="{{ asset('css/custom-style.css') }}" rel="stylesheet">
</head>
<style type="text/css">
    body {
        background-image: url("{{ asset('img/SDN BANNER 2.png') }}");
        background-attachment: fixed;
        background-position: top;
        background-repeat: no-repeat;
        background-size: cover;
    }
    .custom-back {
        background-image: url("{{ asset('img/SDN BANNER 2.png') }}");
        background-attachment: fixed;
        background-position: top;
        background-repeat: no-repeat;
        background-size: cover;
    }
</style>
<body>
    <div class="container-fluid font-sans text-gray-900 antialiased">
        <div class="row">
            {{ $slot }}
        </div>
    </div>
</body>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}" defer></script>
<!-- BOOTSTRAP JQUERY -->
<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script type="text/javascript">
    function loopDown(){
        $("#icon-move-down").animate({
            marginTop : 10
        },
        500, function() {
            loopUp();
        });
    }

    function loopUp(){
        $("#icon-move-down").animate({
            marginTop : 0
        },
        500, function() {
            loopDown();
        });
    }

    loopDown()
    $(document).ready(function () {
    });
</script>
</html>
