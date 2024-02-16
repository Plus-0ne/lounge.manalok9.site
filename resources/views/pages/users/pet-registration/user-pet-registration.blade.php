@include(
    'pages/users/template/section/login-registration-header'
)

<body class="body">

    <div class="wrapper" style="display: flex;">
        <div class="container-form w-100 d-flex flex-row justify-content-center p-2">
            <div class="login-container align-self-center">
                <div class="login-form">
                    <div class="w-100 py-2 text-center">
                        <img src="{{ asset('Source/META_LOGO.png') }}" alt="IAGD" width="130px">
                        <h5>
                            What type of pet are you registering?
                        </h5>
                    </div>
                    <form action="{{ route('user.pet_registration_form') }}" method="get">
                        <div class="w-100 promptss-v2">
                            @include('pages/users/template/section/prompts-v2')
                        </div>
                        <div class="w-100 py-2">
                            <div class="input-container mb-4">
                                <select id="pet_type" class="input-control" name="type">
                                    <option value="dog">Dog</option>
                                    <option value="cat">Cat</option>
                                    <option value="rabbit">Rabbit</option>
                                    <option value="bird">Bird</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="w-100 py-2 mt-2">
                            <button id="select_pet" class="login-btn" type="submit">
                                SUBMIT
                            </button>
                        </div>
                        <div class="w-100 py-2 mt-2">
                            <button id="backBtn_reg" class="createaccount-btn" type="button">
                                BACK
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
    var backUrl = "{{ url('/') }}";
</script>
<script src="{{ asset('js/user-pet-registration.js') }}"></script>
</html>
