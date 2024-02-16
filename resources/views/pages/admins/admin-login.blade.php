<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        {{ $data['title'] }}
    </title>
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/@mdi/font@6.5.95/css/materialdesignicons.min.css">
    <link href="{{ asset('css/login-style.css') }}" rel="stylesheet">
</head>
<style type="text/css">
    .body {
        background-image: url('{{ asset('img/SDN BANNER 2.png') }}');
    }
</style>

<body class="body">
    <div class="wrapper">
        <div class="header">

        </div>

        <div class="container">
            <div class="row">
                <div class="col-12 d-flex flex-wrap justify-content-center">
                    <div class="login-container">
                        <div class="login-form">
                            <form action="{{ route('admin.LoginValidation') }}" method="post">
                                @csrf
                                <div class="mt-4 mb-5 d-flex flex-wrap justify-content-center">
                                    <img class="login-img" src="{{ asset('img/META_LOGO.svg') }}">

                                </div>
                                <div class="form-inp mt-4">
                                    <input class="form-control" type="text" name="email_address" placeholder="Email"
                                        autocomplete="off">
                                </div>
                                <div class="form-inp mt-4">
                                    <input class="form-control" type="password" name="password" placeholder="Password"
                                        autocomplete="off">
                                </div>
                                <div class="mt-4 text-end">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="mdi mdi-login"></i> Login
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer">

    </div>
    @if (Session::has('status'))
        @switch(Session::get('status'))
            @case('not set')
                <div class="custom-alert ca-error position-fixed bottom-0">
                    <span><i class="mdi mdi-alert"></i> <strong>Error! </strong> Something's wrong! Please try again.</span>
                </div>
            @break

            @case('null')
                <div class="custom-alert ca-warning position-fixed bottom-0">
                    <span><i class="mdi mdi-alert"></i> <strong>Warning! </strong> Email Address and Password are
                        required.</span>
                </div>
            @break

            @case('error')
                <div class="custom-alert ca-warning position-fixed bottom-0">
                    <span><i class="mdi mdi-alert"></i> <strong>Warning! </strong> Incorrect Email or Password.</span>
                </div>
            @break

            @case('null admin')
                <div class="custom-alert ca-warning position-fixed bottom-0">
                    <span><i class="mdi mdi-alert"></i> <strong>Warning! </strong> Incorrect Email or Password.</span>
                </div>
            @break

            @default
        @endswitch
    @endif
    <script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            if ($('.custom-alert').length > 0) {
                setTimeout(function() {
                    $('.custom-alert').css({
                        opacity: 0
                    });
                }, 3000);
                setTimeout(function() {
                    $('.custom-alert').remove();
                }, 6000);
            }

            $('.custom-alert').on('click', function(event) {
                event.preventDefault();
                $(this).css({
                    opacity: 0
                });
                setTimeout(function() {
                    $(this).remove();
                }, 3000);
            });
        });
    </script>
</body>

</html>
