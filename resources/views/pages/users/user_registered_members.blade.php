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
                            <form action="{{ route('user.check_iagd_number') }}" method="post">
                                @csrf
                                <div class="mt-4 mb-5">
                                    <div class="col-12 text-center">
                                        <img class="login-img" src="{{ asset('img/META_LOGO.svg') }}">
                                    </div>
                                    <div class="col-12 text-center pt-4">
                                        <h6>
                                            Enter your IAGD Number
                                        </h6>

                                    </div>
                                </div>
                                <div class="form-inp mt-4">
                                    <input class="form-control" type="text" name="iagd_number" placeholder="IAGD No."
                                        autocomplete="off">
                                </div>
                                <small>
                                    ex. ICGD , IFGD , IBGD or IRGD
                                </small>
                                <div class="mt-4 d-flex flex-wrap justify-content-between">
                                    <a class="btn btn-secondary" href="{{ route('user.user_registration') }}">
                                        <i class="mdi mdi-keyboard-return"></i> Back
                                    </a>
                                    <button class="btn btn-primary" type="submit">
                                        <i class="mdi mdi-account-plus"></i> Continue
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
    @include('pages/users/template/section/page-prompts')
    @include(
        'pages/users/template/section/login-registration-scripts'
    )
</body>


</html>
