@include(
    'pages/users/template/section/login-registration-header'
)

<body class="body">
    <div class="wrapper">
        <div class="header">

        </div>

        <div class="container">
            <div class="row">
                <div class="col-12 d-flex flex-wrap justify-content-center">
                    <div class="login-container">
                        <form action="{{ route('user.register_user_pass') }}" method="post">
                            @csrf
                            <div class="login-form">
                                <div class="mt-4 mb-5">
                                    <div class="col-12 text-center">
                                        <img class="login-img" src="{{ asset('img/META_LOGO.svg') }}">
                                    </div>
                                    <div class="col-12 text-center pt-4">
                                        <h6>
                                            Create password for your account
                                        </h6>

                                    </div>
                                </div>
                                <div class="form-inp mt-4">
                                    <input id="tiemxx" type="hidden" name="timezonee" autocomplete="off">
                                    <input id="pass1" class="form-control" type="password" name="pass1"
                                        placeholder="Password" autocomplete="off">
                                </div>
                                <div class="form-inp mt-4">
                                    <input id="pass2" class="form-control" type="password" name="pass2"
                                        placeholder="Verify password" autocomplete="off">
                                </div>
                                <div class="mt-4 d-flex flex-wrap justify-content-end">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="mdi mdi-lock"></i> Create Password
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer">

    </div>
    <div class="promptssss"></div>
    @include('pages/users/template/section/page-prompts')
    @include(
        'pages/users/template/section/login-registration-scripts'
    )
</body>

</html>
