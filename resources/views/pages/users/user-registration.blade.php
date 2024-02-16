@include('pages/users/template/section/login-registration-header')

<body class="body">
    <div class="wrapper" style="display: flex;">
        <div class="container-form w-100 d-flex flex-row justify-content-center p-2">
            <div class="createaccount-container align-self-center">
                <form action="{{ route('user.create_account') }}" method="post">
                    @csrf
                    <input id="timezzz" type="hidden" name="timez" value="">
                    <div class="createaccount-form">
                        <div class="w-100 pt-2 pb-2 mb-3 text-center">
                            <img src="{{ asset('img/official-iagd-logo-for-white.png') }}" alt="Internation Animals Genetics Database" width="130px">
                            <div class="mt-5"></div>
                            <h5>
                                Create account
                            </h5>
                        </div>
                        <div class="d-flex flex-wrap py-2">
                            <div class="w-100 promptss-v2 px-2">
                                @include('pages/users/template/section/prompts-v2')
                            </div>

                            <div class="col-12 col-md-6 p-2">
                                <div class="input-container">
                                    <input id="first_name" class="input-control" name="first_name" type="text" placeholder="First Name"
                                    value="{{ (Session::has('register_this_googleacount.googlegiven_name')) ? Session::get('register_this_googleacount.googlegiven_name') : '' }}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 p-2">
                                <div class="input-container">
                                    <input id="last_name" class="input-control" name="last_name" type="text" placeholder="Last Name"
                                    value="{{ (Session::has('register_this_googleacount.googlefamily_name')) ? Session::get('register_this_googleacount.googlefamily_name') : '' }}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 p-2">
                                <div class="input-container">
                                    <select id="gender" class="input-control" name="gender">
                                        <option selected disabled hidden>Sex</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 p-2">
                                <div class="input-container">
                                    <input id="birth_date" name="birth_date" class="input-control dateInput" type="text" placeholder="Birth Date">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 p-2">
                                <div class="input-container">
                                    <input id="contact_number" name="contact_number" class="input-control" type="text" placeholder="Phone/Mobile No.">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 p-2">
                                <div class="input-container">
                                    <input id="email_address" name="email_address" class="input-control {{ (Session::has('register_this_email')) ? 'input-disabled' : '' }}" type="email" placeholder="Email address"
                                    value="{{ (Session::has('register_this_email')) ? Session::get('register_this_email') : '' }}" {{ (Session::has('register_this_email')) ? 'disabled' : '' }}>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 p-2">
                                <div class="input-container">
                                    <input id="password1" name="password1" class="input-control" type="password" placeholder="Password">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 p-2">
                                <div class="input-container">
                                    <input id="password2" name="password2" class="input-control" type="password" placeholder="Verify password">
                                </div>
                            </div>
                            <div class="col-12 col-md-12 p-2">
                                <div class="input-container">
                                    <input id="referral_code" name="referral_code" class="input-control" type="text" placeholder="Referral code ( Member Lounge IAGD # - if available )" @readonly(true)>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 py-2 p-2 mt-5">
                                <button id="submit_account" class="login-btn" type="submit">
                                    SIGN UP
                                </button>
                            </div>
                            <div class="col-12 col-md-6 py-2 p-2 mt-5">
                                <button id="backBtn_reg" class="createaccount-btn" type="button">
                                    BACK TO LOGIN
                                </button>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>

@include('pages/users/template/section/login-registration-scripts')
<script type="text/javascript">
    var backUrl = "{{ route('user.login') }}";
</script>
<script src="{{ asset('js/user-login.js') }}?timestamp={{ time() }}"></script>


</html>
