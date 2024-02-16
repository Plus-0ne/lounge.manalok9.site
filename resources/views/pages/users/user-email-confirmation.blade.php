@include(
    'pages/users/template/section/login-registration-header'
)

<body class="body">

    <div class="wrapper" style="display: flex;">
        <div class="container-form w-100 d-flex flex-row justify-content-center p-2">
            <div class="login-container align-self-center">
                <div class="login-form">
                    <div class="w-100 py-2 text-center">
                        <img src="{{ asset('img/official-iagd-logo-for-white.png') }}" alt="Internation Animals Genetics Database" width="130px">
                        <div class="mt-5"></div>
                        <h5>
                            Enter your email address
                        </h5>
                    </div>
                    <form action="{{ route('user.verify_email_address') }}" method="post">
                        @csrf
                        <div class="w-100 promptss-v2">
                            @include('pages/users/template/section/prompts-v2')
                        </div>
                        <div class="w-100 py-2">
                            <input id="timezzz" type="hidden" name="timez">
                            <div class="input-container mb-4">
                                <input id="email_address" class="input-control" name="email_address" type="email" placeholder="example@example.com"
                                value="{{ old('email_address') }}">
                            </div>
                        </div>
                        <div class="w-100 py-2 mt-2">
                            <button id="verify_emailAddress" class="login-btn" type="submit">
                                SUBMIT
                            </button>
                        </div>
                        <div class="w-100 py-2 mt-2">
                            <button id="backBtn_reg" class="createaccount-btn" type="button">
                                BACK TO LOGIN
                            </button>
                        </div>
                    </form>
                </div>

            </div>

        </div>
    </div>
</body>
@include('pages/users/template/section/login-registration-scripts')
<script class="text/javascript">
    var backUrl = "{{ route('user.login') }}";
</script>
<script src="{{ asset('js/user-login.js') }}"></script>
</html>
