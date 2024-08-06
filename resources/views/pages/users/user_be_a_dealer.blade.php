{{-- HEADER CONTAINS CSS LINKS --}}
@include('pages/users/template/section/header')
</head>

<body>
    <div class="wrapper">

        {{-- TOP NAVIGATION --}}
        @include('pages/users/template/section/header_nav')

        <div class="main">

            {{-- SIDABAR --}}
            @include('pages/users/template/section/sidebar')

            <div class="main-content">
                <div class="container-fluid container-xl">
                    <div class="row">
                        <div class="col-12 px-1 pt-3 pb-3 px-lg-3 gallery_container d-flex flex-wrap">
                            <div class="p-3 col-12">
                                <h5 class="text-gradient-primary">
                                    Become one of our dealers
                                </h5>
                            </div>
                            <hr>
                            {{-- Be a member custom style --}}
                            <style>
                                .dh-text {
                                    font-size: 1.1rem;
                                    font-family: 'Roboto', sans-serif;
                                    letter-spacing: 0.5pt;

                                }

                                .df-text {
                                    font-size: 1.1rem;
                                    font-family: 'Roboto', sans-serif;
                                    letter-spacing: 0.5pt;
                                    /* color: #fff; */
                                }

                                .db-text {
                                    font-size: 0.85rem;
                                    font-family: 'Roboto', sans-serif;
                                    letter-spacing: 0.25pt;
                                }

                                .db-ulist {
                                    font-size: 0.85rem;
                                    font-family: 'Roboto', sans-serif;
                                    letter-spacing: 0.25pt;
                                }

                                .desc-form-section {
                                    font-size: 0.85rem;
                                    font-family: 'Roboto', sans-serif;
                                    letter-spacing: 0.25pt;
                                    /* color: #fff; */
                                }

                                .form-area-for-bam {
                                    padding: 1.5rem;
                                    /*border: 1px solid rgb(216, 216, 216);*/
                                    /* background-color: #1e2530; */
                                }

                                .form-desc-for-bam {
                                    padding: 1rem;
                                    border: 1px solid transparent;
                                }

                                .fc-custom-s {
                                    font-size: 0.9rem;
                                    font-family: 'Roboto', sans-serif;
                                }
                            </style>
                            <div class="p-1 w-100">

                                <div class="col-12 col-xl-12 form-area-for-bam">
                                    <div class="mb-3">
                                        <label>
                                            Please check if the details are correct
                                        </label>
                                    </div>

                                    <div class="desc-form-section py-1 row">
                                        <div class="mb-3 col-12 col-xl-5">
                                            <label for="first_name" class="form-label">
                                                First Name <i class="text-danger fw-bold me-1">*</i>
                                            </label>
                                            <input type="text" class="form-control fc-custom-s" name="first_name"
                                                id="first_name" aria-describedby="helpId" placeholder=""
                                                value="{{ Auth::guard('web')->user()->first_name }}">
                                            <small id="helpId" class="form-text text-muted">Your given
                                                name</small>
                                        </div>
                                        <div class="mb-3 col-12 col-xl-5">
                                            <label for="last_name" class="form-label">
                                                Last Name <i class="text-danger fw-bold me-1">*</i>
                                            </label>
                                            <input type="text" class="form-control fc-custom-s" name="last_name"
                                                id="last_name" aria-describedby="helpId" placeholder=""
                                                value="{{ Auth::guard('web')->user()->last_name }}">
                                            <small id="helpId" class="form-text text-muted">
                                                Your family name
                                            </small>
                                        </div>
                                        <div class="mb-3 col-12 col-xl-2">
                                            <label for="middle_name" class="form-label">
                                                M. I.
                                            </label>
                                            <input type="text" class="form-control fc-custom-s"
                                                name="middle_name" id="middle_name"
                                                aria-describedby="helpId" placeholder=""
                                                value="{{ Auth::guard('web')->user()->middle_initial }}">
                                            <small id="helpId" class="form-text text-muted">
                                                Optional
                                            </small>
                                        </div>
                                        <div class="mb-3 col-12 col-xl-6">
                                            <label for="email_address" class="form-label">
                                                Email Address
                                            </label>
                                            <input type="text" class="form-control fc-custom-s" name="email_address"
                                                id="email_address" aria-describedby="helpId" placeholder=""
                                                value="{{ Auth::guard('web')->user()->email_address }}">
                                            <small id="helpId" class="form-text text-muted">
                                                Your email address if available
                                            </small>
                                        </div>
                                        <div class="mb-3 col-12 col-xl-3">
                                            <label for="contact_number" class="form-label">
                                                Contact number <i class="text-danger fw-bold me-1">*</i>
                                            </label>
                                            <input type="text" class="form-control fc-custom-s"
                                                name="contact_number" id="contact_number"
                                                aria-describedby="helpId" placeholder="09xxxxxxxxx"
                                                value="{{ Auth::guard('web')->user()->contact_number }}">
                                            <small id="helpId" class="form-text text-muted">
                                                Your mobile number
                                            </small>
                                        </div>
                                        <div class="mb-3 col-12 col-xl-3">
                                            <label for="telephone_number" class="form-label">
                                                Telephone number
                                            </label>
                                            <input type="text" class="form-control fc-custom-s"
                                                name="telephone_number" id="telephone_number"
                                                aria-describedby="helpId" placeholder="xxxxxxxx"
                                                value="">
                                            <small id="helpId" class="form-text text-muted">
                                                Your telephone number if available
                                            </small>
                                        </div>
                                        <div class="mb-3 col-12 col-xl-12">
                                            <label for="store_address" class="form-label">
                                                Address <i class="text-danger fw-bold me-1">*</i>
                                            </label>
                                            <input type="text" class="form-control fc-custom-s" name="store_address"
                                                id="store_address" aria-describedby="helpId" placeholder=""
                                                value="{{ Auth::guard('web')->user()->address }}">
                                            <small id="helpId" class="form-text text-muted">
                                                Your complete store address
                                            </small>
                                        </div>

                                        <div class="mb-3 col-12 col-xl-6">
                                            <label for="image_file" class="form-label">
                                                Upload ID with your address <i class="text-danger fw-bold me-1">*</i>
                                            </label>

                                            <input id="image_file" type="file" class="form-control form-control-sm"/>
                                            <div id="fileHelpId" class="form-text">
                                                This help us verify your identity ( Accepted file format : JPG,JPEG,PNG )
                                            </div>

                                            {{-- <label for="inp_address" class="form-label">
                                                <i class="text-danger fw-bold me-1">*</i>Address
                                            </label>
                                            <input type="text" class="form-control fc-custom-s" name="inp_address"
                                                id="inp_address" aria-describedby="helpId" placeholder=""
                                                value="{{ Auth::guard('web')->user()->address }}">
                                            <small id="helpId" class="form-text text-muted">
                                                Your store address
                                            </small> --}}
                                        </div>
                                        <div class="mb-3 col-12 col-xl-6">
                                            <label for="" class="form-label">
                                                Upload preview
                                            </label>
                                            <div id="previewImageContainer" class="d-flex justify-content-center align-content-center">
                                                <i class="bi bi-images" style="font-size: 10rem;"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="w-100 text-start">
                                        <button id="btnSubmitDealerForm" type="button" class="btn btn-primary">
                                            <i class="bi bi-hand-index-thumb me-1"></i> Apply
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

    {{-- Include custom user toast --}}
    @include('pages/users/template/section/user-toasts')

</body>

{{-- SCRIPTS --}}
@include('pages/users/template/section/scripts')
{{-- <script type="module">
    import { swalConfirmation } from "/js/swalPrompts.js";
</script> --}}

<script type="module" src="{{ asset('js/dealers.js') }}"></script>

</html>
