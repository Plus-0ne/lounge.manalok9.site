{{-- HEADER CONTAINS CSS LINKS --}}
@include('pages/users/template/section/header')
{{-- <link rel="stylesheet" href="{{ asset('owlcarousel/assets/owl.carousel.min.css') }}"> --}}
{{-- <link rel="stylesheet" href="{{ asset('owlcarousel/assets/owl.theme.default.min.css') }}"> --}}
<link rel="stylesheet" href="{{ asset('css/post_feed.css') }}">
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
                        {{-- Content here --}}
                        <div class="write_post_section">
                            <div class="d-flex flex-row">
                                <div>
                                    <a href="@if (url()->previous()) {{ url()->previous() }} @else {{ route('dashboard') }} @endif"
                                        class="btn btn-secondary btn-sm">
                                        <span class="mdi mdi-chevron-left text-light"></span>
                                        {{ $data['animalDetails']->first()->PetName }}'s
                                    </a>
                                </div>
                            </div>

                            <hr>

                            <div class="mb-3">
                                <div class="lead">
                                    Note : The cost of the Pet Unified Certificate is 500 Pesos(700 Pesos with IAGD
                                    Certificate Holder). ACES will contact you once they have confirmed your request.
                                </div>

                            </div>
                            <div class="mb-3">
                                <div class="w-100">
                                    <strong class="text-danger">Note</strong> : Before you proceed, please verify your
                                    information:
                                </div>
                            </div>
                            <div class="mb-3">
                                <ol>
                                    <li>
                                        Email address : <strong>{{ Auth::guard('web')->user()->email_address }}</strong>
                                    </li>
                                    <li>
                                        Contact number :
                                        <strong>{{ Auth::guard('web')->user()->contact_number }}</strong>
                                    </li>
                                    <li>
                                        Current address : <strong>{{ Auth::guard('web')->user()->address }}</strong>
                                    </li>

                                </ol>
                                <div class="w-100">
                                    Click the link to verify your information then reload the page : <a
                                        href="{{ route('user.user_profile') }}" target="_BLANK">
                                        <span class="mdi mdi-share"></span> Verify information
                                    </a>
                                </div>
                            </div>
                            <div class="mb-3">

                                <h6>
                                    Unified IAGD certification for {{ $data['animalDetails']->first()->PetName }} ?
                                </h6>
                                <div class="form-check">
                                    <input id="withCertificateHolder" class="form-check-input" type="checkbox" checked>
                                    <label class="form-check-label" for="withCertificateHolder">
                                        With Certificate Holder
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input id="certificateOnly" class="form-check-input" type="checkbox">
                                    <label class="form-check-label" for="certificateOnly">
                                        Unified Certificate Only
                                    </label>
                                </div>

                            </div>
                            <div class="mb-3">
                                <h6>
                                    Enter your Facebook account name or an alternative Contact Number .
                                </h6>
                                <div class="pe-2">
                                    <input id="fb_account" type="text" class="form-control form-control-sm" placeholder="Ex: https://www.facebook.com/example-username/ or +639152571000">
                                    <small class="text-danger">
                                        Optional not required
                                    </small>
                                </div>
                            </div>

                            <div class="d-flex flex-row mb-3">
                                <button id="submitNewRequestCert" class="btn btn-primary btn-sm"
                                    @if ($data['certificationRequest'] > 0) disabled @endif>
                                    <span class="mdi mdi-file-send"></span> Request certification
                                </button>
                            </div>
                            @if ($data['certificationRequest'] > 0)
                                <div class="mb-3">
                                    <span class="badge rounded-pill bg-success">
                                        Your certification request is currently in progress.
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @include('pages/users/template/section/r-sidebar')
        </div>
    </div>
    {{-- Include custom user toast --}}
    @include('pages/users/template/section/user-toasts')

    {{-- SCRIPTS --}}

    @include('pages/users/template/section/scripts')
    @include('pages/users/template/section/scripts-var')

    <script src="{{ asset('js/animal-pages/request-certification.js') }}"></script>

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
