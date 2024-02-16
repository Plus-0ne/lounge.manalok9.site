@include('pages/users/template/section/login-registration-header')

<body class="body">
    <div class="wrapper h-auto" style="display: flex;">
        <div class="container-form w-100 d-flex flex-row justify-content-center p-2">
            <div class="registerpet-container align-self-center">
                <form id="pet_registration" action="{{ route('user.register_pet') }}" method="post">
                    @csrf
                    <input type="hidden" name="pet_type" value="{{ $data['pet_type'] }}">
                    <div class="registerpet-form">
                        <div class="w-100 pt-2 pb-2 mb-3 text-center">
                            <img src="{{ asset('Source/META_LOGO.png') }}" alt="IAGD" width="130px">
                            <h3 class="fw-bold">
                                PET REGISTRATION
                            </h3>
                            <h5>[ <?=strtoupper($data['pet_type'])?> ]</h5>
                        </div>
                        <hr>
                        <div class="d-flex flex-wrap py-2">
                            <div class="w-100 prompts-container px-2">
                                @if (Session::has('status'))
                                    <div class="custom-alert ca-{{ Session::get('custom_alert') }} d-flex align-items-center justify-content-between animate__animated animate__flipInX">
                                        <div class="d-flex align-items-center">
                                            <div class="prompt-img">
                                                <i class="mdi mdi-alert"></i>
                                            </div>
                                            <div class="prompt-text ms-3">
                                                {{ Session::get('message') }}
                                            </div>
                                        </div>
                                        <div class="prompt-img prompt-closes">
                                            <i class="mdi mdi-close"></i>
                                        </div>
                                    </div>
                                @endif
                                @if ($errors->any())
                                    <div class="custom-alert ca-warning position-fixed bottom-0">
                                        <span><i class="mdi mdi-alert"></i> <strong>Warning! </strong> {{ $errors->first() }} </span>
                                    </div>
                                @endif
                            </div>

                            <div class="w-100 pt-2 pb-2 mt-1 text-center">
                                <h5>
                                    Contact Information
                                </h5>
                            </div>
                            <div class="col-12 col-md-6 p-2">
                                <div class="input-container">
                                    <input id="full_name" class="input-control" name="full_name" type="text" placeholder="*Full Name">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 p-2">
                                <div class="input-container">
                                    <input id="contact_number" name="contact_number" class="input-control" type="numer" placeholder="*Phone/Mobile No. (09xxxxxxxxx)" maxlength="11">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 p-2">
                                <div class="input-container">
                                    <input id="email_address" name="email_address" class="input-control" type="email" placeholder="Email address">
                                </div>
                            </div>

                            <div class="col-12 col-md-6 p-2">
                                <div class="input-container">
                                    <input id="facebook_page" class="input-control" name="facebook_page" type="text" placeholder="Facebook Page">
                                </div>
                            </div>

                            <div class="col-12 col-md-6 p-2">
                                <div class="input-container">
                                    <input id="pet_co_owner" class="input-control" name="pet_co_owner" type="text" placeholder="Co-Owner">
                                </div>
                            </div>

                            <hr class="w-100">
                            {{-- PET REGISTRATION FORMS --}}
                            @if ($data['pet_type'] == 'dog')
                                @include('pages/users/template/section/pet-registration/pet-registration-form-dog')
                            @elseif ($data['pet_type'] == 'cat')
                                @include('pages/users/template/section/pet-registration/pet-registration-form-cat')
                            @elseif ($data['pet_type'] == 'rabbit')
                                @include('pages/users/template/section/pet-registration/pet-registration-form-rabbit')
                            @elseif ($data['pet_type'] == 'bird')
                                @include('pages/users/template/section/pet-registration/pet-registration-form-bird')
                            @elseif ($data['pet_type'] == 'other')
                                @include('pages/users/template/section/pet-registration/pet-registration-form-other')
                            @endif

                            <hr class="w-100 mt-3 mb-5">

                            <div class="col-12 col-md-6 py-2 p-2">
                                <button id="backBtn_reg" class="registerpet-btn" type="button">
                                    BACK TO TYPE SELECTION
                                </button>
                            </div>
                            <div class="col-12 col-md-6 py-2 p-2">
                                <button id="submit_registration" class="login-btn" type="submit">
                                    REGISTER PET
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
    var backUrl = "{{ route('user.pet_registration') }}";
    var registration_type = "{{ $data['pet_type'] }}";
</script>
<script src="{{ asset('js/user-pet-registration.js') }}"></script>


</html>
