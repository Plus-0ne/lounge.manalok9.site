<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        {{ $page_title }}
    </title>
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@6.5.95/css/materialdesignicons.min.css">
    <style>
        html,body {
            height: 100%;
            padding: 0;
            margin: 0;
            content: "";
            box-sizing: border-box;
            clear: both;
            background-color: #1e2530;

        }
        .main-content {
            color: rgb(243, 243, 243);
        }
        .emoji-sad-container {
            font-size: 5rem;
        }
    </style>
</head>

<body>
    <div class="container-fluid d-flex h-100">
        <div class="w-100 d-flex justify-content-center">
            <div class="main-content align-self-center text-center">
                <div class="emoji-sad-container w-100">
                    <i class="mdi mdi-emoticon-sad-outline"></i>
                </div>
                <h4>
                    {{ $title }} {{ $status }}
                </h4>
                <br>
                <a class="btn btn-primary" href="{{ ($backUrl != null) ? $backUrl : route('user.login') }}">
                    {{ ($backUrl != null) ? "Return to Email confirmation" : "Return to login" }}
                </a>
            </div>
        </div>
    </div>
</body>
<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
</html>
