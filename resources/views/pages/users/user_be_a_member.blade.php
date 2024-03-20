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
                        <div class="col-12 px-4 pt-4 pb-5 gallery_container d-flex flex-wrap">
                            <div class="p-3 col-12">
                                <h5 class="text-gradient-primary">
                                    Upgrade your IAGD membership
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
                            <div class="row p-3 w-100">
                                {{-- <div class="col-12 col-xl-6 form-desc-for-bam px-1 py-1 px-xl-5 py-xl-5">
                                    <div class="bam-section pb-3">
                                        <div class="bam-short-description">
                                            <div class="des-header py-1">
                                                <span class="dh-text">
                                                    What is IAGD membership ?
                                                </span>
                                            </div>
                                            <div class="des-body">
                                                <span class="db-text">
                                                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Provident nihil libero hic illo eveniet consequatur saepe architecto tenetur dignissimos consectetur! Suscipit hic itaque quo repellendus ad ipsam, porro harum enim?
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bam-section pb-3">
                                        <div class="bam-short-description">
                                            <div class="des-header py-1">
                                                <span class="dh-text">
                                                    Advantage of having a membership
                                                </span>
                                            </div>
                                            <div class="des-body">
                                                <ul class="db-ulist">
                                                    <li>
                                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nulla, nesciunt possimus! Dolore incidunt, eligendi nihil possimus mollitia aperiam a,
                                                    </li>
                                                    <li>
                                                        est nulla vel expedita harum assumenda voluptate natus ducimus, reprehenderit similique.
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="desc-section pb-3">
                                        <div class="desc-short-description">
                                            <div class="des-header py-1">
                                                <span class="dh-text">
                                                    Requirements
                                                </span>
                                            </div>
                                            <div class="des-body">
                                                <ul class="db-ulist">
                                                    <li>
                                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nulla, nesciunt possimus! Dolore incidunt, eligendi nihil possimus mollitia aperiam a,
                                                    </li>
                                                    <li>
                                                        est nulla vel expedita harum assumenda voluptate natus ducimus, reprehenderit similique.
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="desc-section pb-3">
                                        <div class="desc-short-description">
                                            <div class="des-header py-1">
                                                <span class="dh-text">
                                                    How to register
                                                </span>
                                            </div>
                                            <div class="des-body">
                                                <ul class="db-ulist">
                                                    <li>
                                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Nulla, nesciunt possimus! Dolore incidunt, eligendi nihil possimus mollitia aperiam a,
                                                    </li>
                                                    <li>
                                                        est nulla vel expedita harum assumenda voluptate natus ducimus, reprehenderit similique.
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>

                                </div> --}}

                                <div class="col-12 col-xl-12 form-area-for-bam">
                                    <div class="py-1">
                                        <span class="df-text">
                                            Fill up this form
                                        </span>
                                    </div>
                                    <form action="{{ route('user.register_as_a_member') }}" method="post"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="desc-form-section py-1 row">
                                            <div class="mb-3 col-12 col-xl-5">
                                                <label for="inp_first_name" class="form-label">
                                                    <i class="text-danger fw-bold me-1">*</i>First Name
                                                </label>
                                                <input type="text" class="form-control fc-custom-s"
                                                    name="inp_first_name" id="inp_first_name" aria-describedby="helpId"
                                                    placeholder="" value="{{ Auth::guard('web')->user()->first_name }}">
                                                <small id="helpId" class="form-text text-muted">Your given
                                                    name</small>
                                            </div>
                                            <div class="mb-3 col-12 col-xl-5">
                                                <label for="inp_last_name" class="form-label">
                                                    <i class="text-danger fw-bold me-1">*</i>Last Name
                                                </label>
                                                <input type="text" class="form-control fc-custom-s"
                                                    name="inp_last_name" id="inp_last_name" aria-describedby="helpId"
                                                    placeholder="" value="{{ Auth::guard('web')->user()->last_name }}">
                                                <small id="helpId" class="form-text text-muted">Your family
                                                    name</small>
                                            </div>
                                            <div class="mb-3 col-12 col-xl-2">
                                                <label for="inp_middle_initial" class="form-label">
                                                    M. I.
                                                </label>
                                                <input type="text" class="form-control fc-custom-s"
                                                    name="inp_middle_initial" id="inp_middle_initial"
                                                    aria-describedby="helpId" placeholder=""
                                                    value="{{ Auth::guard('web')->user()->middle_initial }}">
                                                <small id="helpId" class="form-text text-muted">Optional</small>
                                            </div>
                                            <div class="mb-3 col-12 col-xl-6">
                                                <label for="inp_email_address" class="form-label">
                                                    <i class="text-danger fw-bold me-1">*</i>Email Address
                                                </label>
                                                <input type="text" class="form-control fc-custom-s"
                                                    name="inp_email_address" id="inp_email_address"
                                                    aria-describedby="helpId" placeholder=""
                                                    value="{{ Auth::guard('web')->user()->email_address }}">
                                                <small id="helpId" class="form-text text-muted">Valid email address
                                                    required</small>
                                            </div>
                                            <div class="mb-3 col-12 col-xl-6">
                                                <label for="inp_contact_number" class="form-label">
                                                    <i class="text-danger fw-bold me-1">*</i>Contact number
                                                </label>
                                                <input type="text" class="form-control fc-custom-s"
                                                    name="inp_contact_number" id="inp_contact_number"
                                                    aria-describedby="helpId" placeholder="09xxxxxxxxx"
                                                    value="{{ Auth::guard('web')->user()->contact_number }}">
                                                <small id="helpId" class="form-text text-muted">11 digit
                                                    number</small>
                                            </div>
                                            <div class="mb-3 col-12 col-xl-12">
                                                <label for="inp_address" class="form-label">
                                                    <i class="text-danger fw-bold me-1">*</i>Address
                                                </label>
                                                <input type="text" class="form-control fc-custom-s"
                                                    name="inp_address" id="inp_address" aria-describedby="helpId"
                                                    placeholder="" value="{{ Auth::guard('web')->user()->address }}">
                                                <small id="helpId" class="form-text text-muted">Your current
                                                    address</small>
                                            </div>
                                            <div class="mb-3 col-12 col-xl-12">
                                                <label for="inp_ship_address" class="form-label">
                                                    <i class="text-danger fw-bold me-1">*</i>Shipping Address
                                                </label>
                                                <input type="text" class="form-control fc-custom-s"
                                                    name="inp_ship_address" id="inp_ship_address"
                                                    aria-describedby="helpId" placeholder="">
                                                <small id="helpId" class="form-text text-muted">Your shipping address
                                                    which we will use when delivering your package.</small>
                                            </div>
                                            <div class="mb-3 col-12 col-xl-12">
                                                <label for="inp_near_lblc" class="form-label">
                                                    <i class="text-danger fw-bold me-1">*</i>Nearest LBC Branch
                                                </label>
                                                <input type="text" class="form-control fc-custom-s"
                                                    name="inp_near_lblc" id="inp_near_lblc" aria-describedby="helpId"
                                                    placeholder="">
                                                <small id="helpId" class="form-text text-muted">When we send a
                                                    package. We will send it to your nearest branch.</small>
                                            </div>

                                            <div class="mb-3 col-12 col-xl-12">
                                                <label for="inp_name_card" class="form-label">
                                                    <i class="text-danger fw-bold me-1">*</i>Name on Card
                                                </label>
                                                <input type="text" class="form-control fc-custom-s"
                                                    name="inp_name_card" id="inp_name_card" aria-describedby="helpId"
                                                    placeholder="">
                                                <small id="helpId" class="form-text text-muted">Name that will
                                                    appear in front of your IAGD membership card</small>
                                            </div>

                                            <div class="mb-3 col-12 col-xl-12">
                                                <label for="inp_fb_url" class="form-label">
                                                    Facebook URL
                                                </label>
                                                <input type="text" class="form-control fc-custom-s"
                                                    name="inp_fb_url" id="inp_fb_url" aria-describedby="helpId"
                                                    placeholder="">
                                                <small id="helpId" class="form-text text-muted">Optional</small>
                                            </div>

                                            <div class="mb-3 col-12 col-xl-12">
                                                <label for="inp_valid_id" class="form-label">
                                                    <i class="text-danger fw-bold me-1">*</i>Upload Valid ID (Max: 3)
                                                </label>
                                                <input type="file" class="form-control fc-custom-s"
                                                    name="valid_id[]" id="inp_valid_id" multiple
                                                    aria-describedby="fileHelpId">
                                                <div id="fileHelpId" class="form-text">Valid IDs Accepted PRIMARY:
                                                    Passport, Drivers License, PRC, UMID, POSTAL, National ID. SECONDARY
                                                    (Provide 2): Company ID, School ID, NBI Clearance, Police Clearance,
                                                    Voters ID, Barangay Clearance</div>
                                                <div id="fileHelpId" class="form-text">Acceptable image format: JPG ,
                                                    JPEG , PNG , BMP or GIF</div>
                                            </div>

                                            <div class="mb-3 col-12 col-xl-12">
                                                <label for="inp_clear_11image" class="form-label">
                                                    <i class="text-danger fw-bold me-1">*</i>Upload Clear 1x1 Image (Max: 2)
                                                </label>
                                                <input type="file" class="form-control fc-custom-s"
                                                    name="clear_11image[]" id="inp_clear_11image" multiple
                                                    aria-describedby="fileHelpId">
                                                <div id="fileHelpId" class="form-text">This image will be use in your
                                                    IAGD membership ID</div>
                                                <div id="fileHelpId" class="form-text">Acceptable image format: JPG ,
                                                    JPEG , PNG , BMP or GIF</div>
                                            </div>


                                            <div class="mb-3 col-12 col-xl-12">
                                                <label for="inp_membership_package" class="form-label">
                                                </label>
                                                    <i class="text-danger fw-bold me-1">*</i>Choose a membership package
                                                <select class="form-control fc-custom-s"
                                                    name="inp_membership_package" id="inp_membership_package" aria-describedby="helpId-package">
                                                    <option>Select a package to show to see more details.</option>
                                                    <option value="0">PACKAGE A: PHP 3,000</option>
                                                    <option value="1">PACKAGE B: PHP 7,000</option>
                                                    <option value="2">PACKAGE C: PHP 12,000</option>
                                                </select>
                                                <small id="helpId-package" class="form-text text-muted">Select a package to show to see more details.</small>

                                            </div>

                                            <div class="mb-3 col-12 col-xl-12">
                                                <label for="inp_payment_proof" class="form-label">
                                                    <i class="text-danger fw-bold me-1">*</i>Upload proof of payment (Max. 2)
                                                </label>
                                                <input type="file" class="form-control fc-custom-s"
                                                    name="payment_proof[]" id="inp_payment_proof" multiple
                                                    aria-describedby="fileHelpId">
                                                <div id="fileHelpId" class="form-text">Needed to validate your
                                                    registration.</div>
                                                <div id="fileHelpId" class="form-text">Acceptable image format: JPG ,
                                                    JPEG , PNG , BMP or GIF</div>
                                            </div>

                                            <div class="mb-3 col-12 col-xl-12 mt-3 mb-4">
                                                <label for="inp_referral_code" class="form-label d-inline">
                                                    Referral:
                                                </label>
                                                <input type="text"
                                                class="form-control w-auto fc-custom-s d-inline" name="inp_referral_code" id="inp_referral_code" aria-describedby="helpId" placeholder="Code/IAGD #" value="{{ Auth::guard('web')->user()->referred_by }}">
                                                <br>
                                                <small id="helpId" class="form-text text-muted">Referral Code or Referrer's IAGD #</small>
                                            </div>
                                            <div class="w-100 mb-3">
                                                <div>
                                                    <p>Please download our QR code for payment.</p>
                                                </div>
                                                <div class="d-flex flex-column">
                                                    <div>
                                                        <a class="btn col-12" download href="{{ asset('img/381167286_793333219236632_9063116107704270138_n.png') }}">

                                                            <img class="img-fluid" src="{{ asset('img/381196062_293129843446466_2590890577616570992_n.png') }}" alt="">
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3 col-12 col-xl-12">
                                                <button id="register_newMember" class="btn btn-primary w-100"
                                                    type="submit">
                                                    <i class="bi bi-arrow-up-circle" style="vertical-align: 0;"></i> <b>Upgrade Your Membership</b>
                                                </button>
                                            </div>

                                            <div class="reg_prompts">

                                            </div>

                                        </div>
                                    </form>
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

<script src="{{ asset('js/members_js/be_a_member.js') }}"></script>

</html>
