@include(
    'pages/users/template/section/login-registration-header'
)

<body class="body">

    <div class="wrapper" style="display: flex;">
        <div class="container-form w-100 d-flex flex-row justify-content-center p-2">
            <div class="login-container align-self-center">
                <div class="login-form">
                    <div class="w-100 py-2 text-center">
                        <img id="metaanimals-logo" src="{{ asset('img/official-iagd-logo-for-white.png') }}" alt="Internation Animals Genetics Database" width="130px">
                        <div class="mt-5"></div>
                        <h5>
                            Link Google to account
                        </h5>
                    </div>
                    <div class="w-100 py-2 text-center">
                        <p class="text_descript">
                            Your email address is already registered. We can link your Google account to your IAGD account for faster authentication.
                        </p>
                    </div>
                    <div class="col-12 py-2 p-2">
                        <button id="linkMyGaccount" class="login-btn" type="submit">
                            LINK MY GOOGLE
                        </button>
                    </div>
                    <div class="col-12 py-2 p-2">
                        <button id="backBtn_reg" class="createaccount-btn" type="button">
                            BACK TO LOGIN
                        </button>
                    </div>
                </div>

            </div>

        </div>
    </div>
</body>
@include('pages/users/template/section/login-registration-scripts')
<script type="text/javascript">
    var backUrl = "{{ route('user.login') }}";
</script>
<script src="https://accounts.google.com/gsi/client" async defer></script>
<script src="{{ asset('js/user-login.js') }}"></script>
</html>
