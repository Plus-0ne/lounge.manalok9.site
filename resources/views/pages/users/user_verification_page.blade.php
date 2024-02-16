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
                    <div class="login-container-page">
                        <div class="login-form">
                            <div class="mt-4 mb-5">
                                <div class="col-12 text-center">
                                    <img class="login-img" src="{{ asset('img/official-iagd-logo-for-white.png') }}" alt="Internation Animals Genetics Database">
                                </div>
                                <div class="col-12 text-center pt-4">
                                    <h6>
                                        Verify IAGD No.
                                    </h6>

                                </div>
                            </div>
                            <small>
                                A link has been sent to your email address, Check your email inbox or spam emails
                            </small>
                            <div class="mt-4 d-flex flex-wrap justify-content-between">
                                <a class="btn btn-secondary" href="{{ route('user.user_registered_members') }}">
                                    <i class="mdi mdi-keyboard-return"></i> Back
                                </a>
                                <a class="btn btn-primary" href="{{ route('user.resend_email') }}">
                                    <i class="mdi mdi-send"></i> Send verification
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer">

    </div>
    @include('pages/users/template/section/page-prompts')
    @include(
        'pages/users/template/section/login-registration-scripts'
    )
</body>


</html>
