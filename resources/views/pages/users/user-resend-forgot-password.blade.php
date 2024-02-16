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
                        <div class="login-form">
                            <div class="mt-4 mb-5">
                                <div class="col-12 text-center">
                                    <img class="login-img" src="{{ asset('img/official-iagd-logo-for-white.png') }}" alt="Internation Animals Genetics Database">
                                </div>
                                <div class="col-12 text-center pt-4">
                                    <h6>
                                        We sent a mail to your email address
                                    </h6>

                                </div>
                            </div>
                            <div class="mt-4 d-flex justify-content-center">
                                <p>
                                    Didn't receive a mail? Just click the button resend
                                </p>
                            </div>
                            <div class="mt-4 d-flex flex-wrap justify-content-between">
                                <a class="btn btn-secondary" href="{{ url()->previous() }}">
                                    <i class="mdi mdi-keyboard-return"></i> Back
                                </a>
                                <button id="resend_mail" class="btn btn-primary" type="button">
                                    <i class="mdi mdi-check"></i> Resend
                                </button>
                            </div>
                            <div class="mt-4 d-flex flex-wrap justify-content-center">
                                <div class="page_prompts">

                                </div>
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
    <script src="{{ asset('custom/js/forgot-password.js') }}"></script>
</body>


</html>
