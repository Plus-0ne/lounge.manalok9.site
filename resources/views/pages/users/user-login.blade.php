@include('pages/users/template/section/login-registration-header')

<body class="body">

    <div class="wrapper" style="display: flex;">
        <div class="container-form w-100 d-flex flex-row justify-content-center p-2">
            <div class="login-container align-self-center">
                <div class="login-form">
                    <div class="w-100 py-2 text-center mb-4">
                        <img id="metaanimals-logo" src="{{ asset('lounge-icons-v1/lounge.svg') }}"
                            alt="International Animals Genetics Database" width="210px">
                        {{-- <h5>
                            Lounge
                        </h5> --}}
                    </div>
                    <div class="w-100 promptss-v2">
                        @include('pages/users/template/section/prompts-v2')
                    </div>
                    <div class="w-100 py-2">
                        <div class="form-group mb-4">
                            <input id="unique_id" class="form-control" name="unique_id" type="text"
                                placeholder="Email address">
                        </div>
                        <div class="form-group mb-2" style="position: relative;">
                            <input id="password" class="form-control" name="password" type="password"
                                placeholder="Password">
                            <span class="show_pass"><i class="mdi mdi-eye-outline"></i></span>
                        </div>
                    </div>
                    <div class="w-100 d-flex justify-content-between remandfpass">
                        <small>
                            <input class="form-check-input" type="checkbox" id="rememberMe" name="rememberMe">
                            <label class="form-check-label" for="rememberMe">
                                Remember me
                            </label>
                        </small>
                        <small>
                            <a class="forgot-pass" href="{{ route('user.forgot_password') }}">
                                Forgot password?
                            </a>
                        </small>
                    </div>
                    <div class="w-100 py-2 mt-3 text-center">
                        <button id="submit_logincred" class="btn btn-primary w-100" type="submit">
                            <i class="bi bi-key-fill"></i> Log In
                        </button>
                    </div>
                    <hr class="w-100">
                    <div class="w-100 d-flex flex-wrap justify-content-center">
                        {{-- GOOGLE BUTTON --}}
                        {{-- <div id="googleSignin" class="mt-2"></div> --}}
                        <div id="g_id_onload"
                            data-client_id="748264524555-7q9eo5iul341e58r4dd43t72dm8tulmi.apps.googleusercontent.com"
                            data-context="signin" data-ux_mode="popup" data-callback="googleLoginValidation"
                            data-auto_prompt="false">
                        </div>

                        <div class="g_id_signin" data-type="standard" data-shape="rectangular" data-theme="outline"
                            data-text="signin_with" data-size="large" data-logo_alignment="center" data-width="316">
                        </div>
                        {{-- FACEBOOK BUTTON --}}
                        {{-- <div class="fb-login-button mt-2" data-width="318" data-size="large"
                            data-button-type="login_with" data-layout="default" data-auto-logout-link="true"
                            data-use-continue-as="true" onlogin="checkLoginState();"></div> --}}
                    </div>
                    <hr class="w-100">
                    <div class="moaccount text-center">
                        <small>
                            <a class="btn btn-secondary w-100 create_account_link" href="{{ route('user.email_confirmation') }}"> Register a new account</a>
                        </small>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @include('pages.users.template.section.scripts-var')
    @include('pages/users/template/section/login-registration-scripts')

    <script src="{{ asset('js/user-login.js') }}"></script>
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#metaanimals-logo').click(function(e) {
                e.preventDefault();
                window.location.href = '{{ route('user.landing') }}';
            });
        });
    </script>
    <script type="text/javascript">
        window.googleLoginValidation = (response) => {

            const url = window.thisUrl + '/ajax/validate-g-login';
            const data = {
                cred: response.credential,
                timez: moment.tz.guess()
            };

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    body: JSON.stringify(data)
                })
                .then(response => response.json())
                .then(result => {
                    if (result.status == 'success') {
                        $('.promptss-v2').html('<div class="custom-alert ca-success d-flex align-items-center justify-content-between animate__animated animate__flipInX">\
                                                    <div class="d-flex align-items-center">\
                                                        <div class="prompt-img">\
                                                            <i class="mdi mdi-check"></i>\
                                                        </div>\
                                                        <div class="prompt-text ms-3">\
                                                            ' + result.message + '\
                                                        </div>\
                                                    </div>\
                                                    <div class="prompt-img prompt-closes">\
                                                        <i class="mdi mdi-close"></i>\
                                                    </div>\
                                                </div>');

                        window.location.href = result.redirectUrl;
                    } else {
                        $('.promptss-v2').html('<div class="custom-alert ca-warning d-flex align-items-center justify-content-between animate__animated animate__flipInX">\
                                                    <div class="d-flex align-items-center">\
                                                        <div class="prompt-img">\
                                                            <i class="mdi mdi-alert"></i>\
                                                        </div>\
                                                        <div class="prompt-text ms-3">\
                                                            ' + result.message + '\
                                                        </div>\
                                                    </div>\
                                                    <div class="prompt-img prompt-closes">\
                                                        <i class="mdi mdi-close"></i>\
                                                    </div>\
                                                </div>');

                        if (result.redirectUrl) {
                            window.location.href = result.redirectUrl;
                        }
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        }
    </script>
</body>


</html>
