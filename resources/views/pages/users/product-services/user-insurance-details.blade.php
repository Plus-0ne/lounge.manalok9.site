{{-- HEADER CONTAINS CSS LINKS --}}
@include('pages/users/template/section/header')

</head>

<body>
    <div class="wrapper">

        {{-- TOP NAVIGATION --}}
        @include('pages/users/template/section/header_nav')

        <div class="main">

            {{-- SIDEABAR --}}
            @include('pages/users/template/section/sidebar')

            <div class="main-content h-100">
                <div class="container-fluid container-xl">
                    <div class="row">

                        <div class="col-12 write_post_section d-flex flex-wrap">
                            {{-- Content here --}}
                            <div class="d-flex flex-column p-0 p-lg-3 w-100">
                                <div class="col-12">
                                    <h4>
                                        Insurance details
                                    </h4>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="d-flex flex-row justify-content-between">
                                        <a href="{{ route('user.insuranceView') }}" class="btn btn-secondary btn-sm">
                                            <span class="mdi mdi-arrow-left"></span> Return
                                        </a>
                                        @if ($data['insurance']->insruanceAvailedByUser->isNotEmpty())
                                            <button id="availThisInsurance" type="button"
                                                class="btn btn-secondary btn-sm" @disabled(true)>
                                                <span class="mdi mdi-check"></span> Availed already
                                            </button>
                                        @else
                                            <button id="availThisInsurance" type="button"
                                                class="btn btn-primary btn-sm">
                                                <span class="mdi mdi-card-multiple"></span> Avail plan
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                <hr>
                                {{-- Display product and services --}}
                                <div class="d-flex flex-wrap">
                                    <div class="col-12 col-xl-6 d-flex flex-column mb-3 pe-0 pe-xl-3">
                                        <div class="lead">
                                            {{ $data['insurance']->title }}
                                        </div>
                                        <div class="fs-text">
                                            {{ $data['insurance']->description }}
                                        </div>
                                        <div class="fs-text mb-3">
                                            For only <strong>₱ {{ number_format($data['insurance']->price) }}</strong>
                                        </div>
                                        <div class="fs-text">
                                            <div class="ins-img-container">
                                                <img class="img-fluid" src="{{ asset($data['insurance']->image_path) }}"
                                                    alt="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-xl-6 d-flex flex-column mb-3">
                                        <div>
                                            <p class="fs-text"> <strong class="text-danger">Note</strong> : Before you
                                                proceed, please
                                                verify your information:
                                            </p>
                                            <ul>
                                                <li>
                                                    <div class="fs-text">
                                                        Verify your address :
                                                        <strong>{{ empty(Auth::guard('web')->user()->address) ? 'No address' : Auth::guard('web')->user()->address }}</strong>
                                                    </div>

                                                </li>
                                                <li>
                                                    <div class="fs-text">
                                                        Verify your contact number :
                                                        <strong>{{ empty(Auth::guard('web')->user()->contact_number) ? 'No contact number' : Auth::guard('web')->user()->contact_number }}</strong>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="fs-text">
                                                        Verify your email address :
                                                        <strong>{{ empty(Auth::guard('web')->user()->email_address) ? 'No email address' : Auth::guard('web')->user()->email_address }}</strong>
                                                    </div>
                                                </li>
                                            </ul>
                                            <p class="fs-text">Click the link to update your information : <a
                                                    href="{{ route('user.user_profile') }}" target="_BLANK">
                                                    Verify Information
                                                </a></p>


                                            <p class="fs-text">Please download our QR code for payment.</p>
                                            <a class="btn col-12" download
                                                href="{{ asset('img/381167286_793333219236632_9063116107704270138_n.png') }}">
                                                <img class="img-fluid"
                                                    src="{{ asset('img/381196062_293129843446466_2590890577616570992_n.png') }}"
                                                    alt="">
                                            </a>
                                            <p class="mt-3">or scan the QR image</p>
                                            <div class="col-12 col-xl-6 mx-auto">
                                                <img class="img-fluid"
                                                    src="{{ asset('img/381167286_793333219236632_9063116107704270138_n.png') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('pages/users/template/section/r-sidebar')
        </div>
    </div>

    {{-- Modals --}}

    {{-- Include custom user toast --}}
    @include('pages/users/template/section/user-toasts')

    {{-- SCRIPTS --}}
    @include('pages/users/template/section/scripts')
    @include('pages/users/template/section/scripts-var')
    <script src="{{ asset('js/user-services/user-insurance.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            @if (Session::has('status'))
                @switch(Session::get('status'))
                    @case('error')
                    var message = "{{ Session::get('message') }}";

                    toastr["error"](message);
                    @break

                    @case('success')
                    var message = "{{ Session::get('message') }}";
                    toastr["success"](message);
                    @break

                    @default
                @endswitch
            @endif
        });
    </script>

</body>

</html>
