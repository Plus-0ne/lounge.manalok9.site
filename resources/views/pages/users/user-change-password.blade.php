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
                                        Change password
                                    </h6>

                                </div>
                            </div>
                            <div class="form-inp mt-4">
                                <label class="form-label">
                                    Password
                                </label>
                                <input id="pass1" class="form-control" type="password" autocomplete="off">
                            </div>
                            <div class="form-inp mt-4">
                                <label class="form-label">
                                    Verify Password
                                </label>
                                <input id="pass2" class="form-control" type="password" autocomplete="off">
                            </div>
                            <div class="mt-4 d-flex flex-wrap justify-content-end">
                                <button id="submit_changepassword" class="btn btn-primary" type="button">
                                    <i class="mdi mdi-check"></i> Change
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
