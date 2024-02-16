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
                                        Enrollment form  {{ Session::get('healthRecordfilePath') }}
                                    </h4>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="d-flex flex-row justify-content-end">
                                        <a href="{{ route('user.services.list') }}" class="btn btn-secondary btn-sm">
                                            <span class="mdi mdi-arrow-left"></span> return to services
                                        </a>
                                    </div>
                                </div>
                                <hr>
                                {{-- Services form --}}
                                <div class="row">

                                    {{-- First row --}}
                                    <div class="col-12 col-xl-4">
                                        <div class="mb-3">
                                            <label for="petName" class="form-label">
                                                Pet's name
                                            </label>
                                            <input id="petName" type="text"
                                                class="form-control form-control-sm makeThisRequired">
                                            <small id="helpId" class="form-text text-muted">
                                                Enter your pet's name ( <span class="text-danger">Required</span> )
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-12 col-xl-4">
                                        <div class="mb-3">
                                            <label for="petBreed" class="form-label">
                                                Breed
                                            </label>
                                            <input id="petBreed" type="text" class="form-control form-control-sm">
                                            <small id="helpId" class="form-text text-muted">
                                                Enter your pet's breed
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-12 col-xl-4">
                                        <div class="mb-3">
                                            <label for="petColor" class="form-label">
                                                Color
                                            </label>
                                            <input id="petColor" type="text" class="form-control form-control-sm">
                                            <small id="helpId" class="form-text text-muted">
                                                Enter your pet's color
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-12 col-xl-4">
                                        <div class="mb-3">
                                            <label for="petAge" class="form-label">
                                                Age of pet
                                            </label>
                                            <input id="petAge" type="text"
                                                class="form-control form-control-sm numberOnlyInput">
                                            <small id="helpId" class="form-text text-muted">
                                                Enter your pet's age
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-12 col-xl-4">
                                        <div class="mb-3">
                                            <label for="petGender" class="form-label">
                                                Gender
                                            </label>
                                            <input id="petGender" type="text" class="form-control form-control-sm">
                                            <small id="helpId" class="form-text text-muted">
                                                Enter your pet's gender
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    {{-- Second row --}}
                                    <div class="col-12 col-xl-4">
                                        <div class="mb-3">
                                            <label for="petOwner" class="form-label">
                                                Owner's name
                                            </label>
                                            <input id="petOwner" type="text"
                                                class="form-control form-control-sm makeThisRequired"
                                                value="{{ Auth::guard('web')->user()->first_name }} {{ Auth::guard('web')->user()->last_name }}">
                                            <small id="helpId" class="form-text text-muted">
                                                Your name ( <span class="text-danger">Required</span> )
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-12 col-xl-8">
                                        <div class="mb-3">
                                            <label for="currentAddress" class="form-label">
                                                Complete Address
                                            </label>
                                            <input id="currentAddress" type="text"
                                                class="form-control form-control-sm makeThisRequired"
                                                value="{{ Auth::guard('web')->user()->address }}">
                                            <small id="helpId" class="form-text text-muted">
                                                Your current address ( <span class="text-danger">Required</span> )
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-12 col-xl-4">
                                        <div class="mb-3">
                                            <label for="contactNumber" class="form-label">
                                                Contact #
                                            </label>
                                            <input id="contactNumber" type="text"
                                                class="form-control form-control-sm contactNumberValidation"
                                                value="">
                                            <small id="helpId" class="form-text text-muted">
                                                Your Landline number (if available)
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-12 col-xl-4">
                                        <div class="mb-3">
                                            <label for="mobileNumber" class="form-label">
                                                Mobile #
                                            </label>
                                            <input id="mobileNumber" type="text"
                                                class="form-control form-control-sm contactNumberValidation makeThisRequired"
                                                value="{{ Auth::guard('web')->user()->contact_number }}">
                                            <small id="helpId" class="form-text text-muted">
                                                Your mobile number ( <span class="text-danger">Required</span> )
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-12 col-xl-4">
                                        <div class="mb-3">
                                            <label for="emailAddress" class="form-label">
                                                Email address
                                            </label>
                                            <input id="emailAddress" type="text"
                                                class="form-control form-control-sm"
                                                value="{{ Auth::guard('web')->user()->email_address }}">
                                            <small id="helpId" class="form-text text-muted">
                                                Your email address
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-12 col-xl-4">
                                        <div class="mb-3">
                                            <label for="fbAccountLink" class="form-label">
                                                Facebook account / messenger
                                            </label>
                                            <input id="fbAccountLink" type="text"
                                                class="form-control form-control-sm" value="">
                                            <small id="helpId" class="form-text text-muted">
                                                Your facebook account URL/Link
                                            </small>
                                        </div>
                                    </div>
                                    {{--
                                    <div class="col-12 col-xl-4">
                                        <div class="mb-3">
                                            <label for="personalBelongings" class="form-label">
                                                Personal belongings
                                            </label>
                                            <input id="personalBelongings" type="text"
                                                class="form-control form-control-sm" value="">
                                            <small id="helpId" class="form-text text-muted">
                                                Like : Leash , Collar , Vitamins , etc.
                                            </small>
                                        </div>
                                    </div>
                                     --}}
                                </div>

                                <div class="row">
                                    {{-- Third row --}}
                                    {{--
                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="textAreaDogToClass" class="form-label">
                                                Briefly State What Brought Your Dog To Class
                                            </label>
                                            <textarea id="textAreaDogToClass"  name=""
                                                id="" rows="3"></textarea>
                                            <small id="helpId" class="form-text text-muted">
                                                ( <span class="text-danger">Required</span> )
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="textAreaWhatToAccomplish" class="form-label">
                                                Briefly State What You Hope To Accomplish In This Class
                                            </label>
                                            <textarea id="textAreaWhatToAccomplish"  name=""
                                                id="" rows="3"></textarea>
                                            <small id="helpId" class="form-text text-muted">
                                                ( <span class="text-danger">Required</span> )
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="mb-3">
                                            <label for="textAreaWhereAboutUs" class="form-label">
                                                How Did You Hear About Us?
                                            </label>
                                            <textarea id="textAreaWhereAboutUs"  name=""
                                                id="" rows="3"></textarea>
                                            <small id="helpId" class="form-text text-muted">
                                                ( <span class="text-danger">Required</span> )
                                            </small>
                                        </div>
                                    </div>
                                    --}}
                                </div>

                                {{-- Style --}}
                                <style>
                                    .simage-container {
                                        width: 100px;
                                        height: 100px;
                                    }

                                    .simage-container {
                                        max-width: 100%;
                                        max-height: 100%;
                                        object-fit: contain;
                                        object-position: center;
                                    }

                                    .cardCustomService {
                                        border-left: 3px solid #1e2530;
                                    }

                                    .card-service-delete {
                                        padding: 0px;
                                        cursor: pointer;
                                        background-color: transparent;
                                        border: none;
                                        font-size: 1.4rem;
                                    }

                                    .card-service-delete>.mdi-delete {
                                        color: rgb(212, 3, 3);
                                    }
                                </style>
                                <div class="row">
                                    {{-- Fourth row --}}
                                    <label for="">
                                        Applying for
                                    </label>
                                    <div class="mb-3">
                                        <div id="serviceApplyFor">
                                            {{-- <div class="card p-2 p-lg-3 cardCustomService">
                                                <div class="d-flex flex-row align-items-center">
                                                    <div class="service-image">
                                                        <div class="simage-container">
                                                            <img class="img-fluid" src="{{ asset('img/no-preview.jpeg') }}" alt="No image">
                                                        </div>
                                                    </div>
                                                    <div class="service-details w-100 d-flex flex-column justify-content-center">
                                                        <div class="lead">
                                                            Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                                                        </div>
                                                        <div>
                                                            100,000 php
                                                        </div>
                                                        <div>
                                                            <small>
                                                                <span class="badge rounded-pill bg-success">
                                                                    In cart
                                                                </span>
                                                            </small>
                                                        </div>
                                                    </div>
                                                    <div class="service-action-control d-flex flex-column justify-content-center">
                                                        <button type="button" class="card-service-delete">
                                                            <span class="mdi mdi-delete"></span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div> --}}
                                        </div>
                                        {{-- <div class="mt-3">
                                            <button type="button" class="btn btn-primary btn-sm">
                                                <span class="mdi mdi-plus"></span> Add service
                                            </button>
                                        </div> --}}
                                    </div>
                                </div>

                                
                                <hr>
                                <div class="row">
                                    <div class="col-12 text-end">
                                        <button id="enrollPetBtn" type="button" class="btn btn-primary btn-sm">
                                            <span class="mdi mdi-plus"></span> Enroll pet
                                        </button>
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

    {{-- Datalist product & services --}}


    {{-- Include custom user toast --}}
    @include('pages/users/template/section/user-toasts')

    {{-- SCRIPTS --}}
    @include('pages/users/template/section/scripts')
    @include('pages/users/template/section/scripts-var')

    <script src="{{ asset('js/user-services/user-service-enroll.js') }}"></script>

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
