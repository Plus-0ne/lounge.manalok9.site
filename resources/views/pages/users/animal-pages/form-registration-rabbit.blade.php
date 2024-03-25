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

            <div class="main-content">
                <div class="container-fluid container-xl">
                    <div class="row">

                        <div class="col-12 write_post_section d-flex flex-wrap">

                            <div class="d-flex flex-column p-0 p-lg-3 w-100">
                                <div class="col-12">
                                    <h4>
                                        Register your rabbit 
                                    </h4>
                                    <small>
                                        Please fill in the required field below. If there is no information to
                                        input, please enter "N/A" or "Nothing to input." Thank you.
                                    </small>

                                </div>
                                <hr>
                                {{-- Content here --}}

                                {{-- Basic information --}}
                                <div class="row">
                                    <div class="mb-2">
                                        <h6 class="lead">
                                            Basic information
                                        </h6>
                                    </div>
                                    <div class="col-12 col-sm-12 col-xxl-4">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">
                                                <span class="mdi mdi-paw"></span> Name
                                            </label>
                                            <input id="name" type="text" class="form-control form-control-sm"
                                                aria-describedby="helpId">
                                            <small id="helpId" class="form-text text-muted">
                                                Enter rabbit's name
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-xxl-4">
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between justify-content-xl-start">
                                                <label for="microchip" class="form-label">
                                                    <span class="mdi mdi-numeric"></span> Microchip Number

                                                </label>
                                                <div class="InputhelpIcon ms-2" data-bs-toggle="popover"
                                                data-bs-trigger="manual" data-bs-placement="top"
                                                data-bs-content="A rabbit microchip is a tiny electronic device that is implanted under the skin of a cat, usually between the shoulder blades. It's about the size of a grain of rice. Each microchip contains a unique identification number that can be read using a compatible microchip scanner. This identification number is linked to the cat's owner's information in a database.">
                                                    <span class="mdi mdi-help-circle"></span>
                                                </div>
                                            </div>
                                            <input id="microchip" type="text" class="form-control form-control-sm"
                                                aria-describedby="helpId">
                                            <small id="helpId" class="form-text text-muted">
                                                Enter rabbit's microchip number ( <i class="text-danger">If available</i> )
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12 col-xxl-4">
                                        <div class="mb-3">
                                            <label for="birth_date" class="form-label">
                                                <span class="mdi mdi-cake"></span> Birth date
                                            </label>
                                            <input id="birth_date" type="date" class="form-control form-control-sm"
                                                aria-describedby="helpId">
                                            <small id="helpId" class="form-text text-muted">
                                                Enter rabbit's birthdate
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12 col-xxl-4">
                                        <div class="mb-3">
                                            <label for="age" class="form-label">
                                                <span class="mdi mdi-calendar"></span> Age
                                            </label>
                                            <input id="age" type="text" class="form-control form-control-sm"
                                                aria-describedby="helpId">
                                            <small id="helpId" class="form-text text-muted">
                                                Enter rabbit's age
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12 col-xxl-4">
                                        <div class="mb-3">
                                            <label for="gender" class="form-label">
                                                <span class="mdi mdi-gender-female"></span> Gender
                                            </label>
                                            <select id="gender" class="form-select form-select-sm">
                                                <option value="male" selected>Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                            <small id="helpId" class="form-text text-muted">
                                                Enter rabbit's gender
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12 col-xxl-4">
                                        <div class="mb-3">
                                            <label for="breed" class="form-label">
                                                <span class="mdi mdi-dog-side"></span> Breed
                                            </label>
                                            <input id="breed" type="text" class="form-control form-control-sm" list="rabbit_breeds"
                                                aria-describedby="helpId">
                                            <small id="helpId" class="form-text text-muted">
                                                Enter rabbit's Breed
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12 col-xxl-4">
                                        <div class="mb-3">
                                            <label for="eye_color" class="form-label">
                                                <span class="mdi mdi-eye-check"></span> Eye color
                                            </label>
                                            <input id="eye_color" type="text" class="form-control form-control-sm"
                                                aria-describedby="helpId">
                                            <small id="helpId" class="form-text text-muted">
                                                Enter rabbit's eye color
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12 col-xxl-4">
                                        <div class="mb-3">
                                            <label for="color" class="form-label">
                                                <span class="mdi mdi-palette"></span> Pet Color
                                            </label>
                                            <input id="color" type="text" class="form-control form-control-sm"
                                                aria-describedby="helpId">
                                            <small id="helpId" class="form-text text-muted">
                                                Enter rabbit's color
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12 col-xxl-4">
                                        <div class="mb-3">
                                            <label for="markings" class="form-label">
                                                <span class="mdi mdi-star"></span> Markings
                                            </label>
                                            <input id="markings" type="text" class="form-control form-control-sm"
                                                aria-describedby="helpId">
                                            <small id="helpId" class="form-text text-muted">
                                                Enter rabbit's markings
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12 col-xxl-4">
                                        <div class="mb-3">
                                            <label for="height" class="form-label">
                                                <span class="mdi mdi-arrow-expand-vertical"></span> Height
                                            </label>
                                            <input id="height" type="text" class="form-control form-control-sm"
                                                aria-describedby="helpId">
                                            <small id="helpId" class="form-text text-muted">
                                                Enter rabbit's height in centimeters
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12 col-xxl-4">
                                        <div class="mb-3">
                                            <label for="weight" class="form-label">
                                                <span class="mdi mdi-scale"></span> Weight
                                            </label>
                                            <input id="weight" type="text" class="form-control form-control-sm"
                                                aria-describedby="helpId">
                                            <small id="helpId" class="form-text text-muted">
                                                Enter rabbit's weight in centimeters
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12 col-xxl-4">
                                        <div class="mb-3">
                                            <label for="address_location" class="form-label">
                                                <span class="mdi mdi-map-marker-radius"></span> Address / Location
                                            </label>
                                            <input id="address_location" type="text" class="form-control form-control-sm"
                                                aria-describedby="helpId">
                                            <small id="helpId" class="form-text text-muted">
                                                Enter rabbit's address / location
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12 col-xxl-4">
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between justify-content-xl-start">
                                                <label for="co_owner" class="form-label">
                                                    <span class="mdi mdi-account-multiple"></span>Co-owner's name

                                                </label>
                                                <div class="InputhelpIcon ms-2" data-bs-toggle="popover"
                                                data-bs-trigger="manual" data-bs-placement="top"
                                                data-bs-content="Co-ownership of a rabbit refers to a situation where two or more individuals share ownership and responsibility for a single rabbit. This could be for various reasons, such as family members sharing the care of a pet, friends who decide to jointly adopt a rabbit, or breeders who collaborate on raising and showing rabbits.">
                                                    <span class="mdi mdi-help-circle"></span>
                                                </div>
                                            </div>
                                            <input id="co_owner" type="text" class="form-control form-control-sm"
                                                aria-describedby="helpId">
                                            <small id="helpId" class="form-text text-muted">
                                                Enter co-owner's name ( <i class="text-danger">If available</i> )
                                            </small>
                                        </div>
                                    </div>


                                    <div class="col-12 col-sm-12 col-xxl-4">
                                        <div class="mb-3">
                                            <label for="pet_image" class="form-label">
                                                <span class="mdi mdi-camera"></span>
                                                Pet image
                                            </label>
                                            <input id="pet_image" type="file" class="form-control form-control-sm"
                                                aria-describedby="fileHelpId">
                                            <small id="fileHelpId" class="form-text">
                                                Upload your pet's image : acceptable format (jpeg, jpg, png, webp, gif)
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12 col-xxl-4">
                                        <div class="mb-3">
                                            <div class="d-flex justify-content-between justify-content-xl-start">
                                                <label for="supp_doc" class="form-label">
                                                    <span class="mdi mdi-file-document-multiple"></span>
                                                    Supporting document

                                                </label>
                                                <div class="InputhelpIcon ms-2" data-bs-toggle="popover"
                                                data-bs-trigger="manual" data-bs-placement="top"
                                                data-bs-content="A &quot;rabbit supporting document&quot; refers to any document or paperwork that provides additional information or evidence related to a rabbit. These documents are often required or helpful in various situations to demonstrate ownership, health status, or compliance with certain regulations.">
                                                    <span class="mdi mdi-help-circle"></span>
                                                </div>
                                            </div>
                                            <input id="supp_doc" type="file" class="form-control form-control-sm"
                                                aria-describedby="fileHelpId">
                                            <small id="fileHelpId" class="form-text">
                                                Upload your pet's supporting documents : acceptable format (jpeg, jpg,
                                                png, webp, gif, doc, docx, pdf)
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                {{-- Veterinarian / Clinic information --}}
                                <br>
                                <div class="row">
                                    <div class="mb-2">
                                        <h6 class="lead">
                                            Veterinarian / Clinic information
                                        </h6>
                                    </div>

                                    <div class="col-12 col-sm-12 col-xxl-4">
                                        <div class="mb-3">
                                            <label for="cveterenary_name" class="form-label">
                                                <span class="mdi mdi-hospital"></span>
                                                Veterinarian / Clinic's Name
                                            </label>
                                            <input id="cveterenary_name" type="text" class="form-control form-control-sm"
                                                aria-describedby="helpId">
                                            <small id="helpId" class="form-text text-muted">
                                                Enter veterinarian / clinic's Name
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12 col-xxl-4">
                                        <div class="mb-3">
                                            <label for="cveterenary_url" class="form-label">
                                                <span class="mdi mdi-link"></span>
                                                Veterinarians Online Profile (URL/link)
                                            </label>
                                            <input id="cveterenary_url" type="text" class="form-control form-control-sm"
                                                aria-describedby="helpId">
                                            <small id="helpId" class="form-text text-muted">
                                                Enter veterinarians Online Profile (URL/link)
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12 col-xxl-4">
                                        <div class="mb-3">
                                            <label for="cveter_record" class="form-label">
                                                <span class="mdi mdi-file-document-multiple"></span>
                                                Clinic / Veterinary record
                                            </label>
                                            <input id="cveter_record" type="file" class="form-control form-control-sm"
                                                aria-describedby="fileHelpId">
                                            <small id="fileHelpId" class="form-text">
                                                Upload cat's record (only when applicable) : acceptable format (jpeg,
                                                jpg, png, webp, gif)
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                {{-- Animal Facility information --}}
                                <br>
                                <div class="row">
                                    <div class="mb-2">
                                        <h6 class="lead">
                                            Animal Facility information
                                        </h6>
                                    </div>

                                    <div class="col-12 col-sm-12 col-xxl-4">
                                        <div class="mb-3">
                                            <label for="kennel_name" class="form-label">
                                                <span class="mdi mdi-home"></span>
                                                Name
                                            </label>
                                            <input id="kennel_name" type="text" class="form-control form-control-sm"
                                                aria-describedby="helpId">
                                            <small id="helpId" class="form-text text-muted">
                                                Enter Animal Facility Name
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12 col-xxl-4">
                                        <div class="mb-3">
                                            <label for="kennel_link" class="form-label">
                                                <span class="mdi mdi-link"></span>
                                                Online Profile (URL/link)
                                            </label>
                                            <input id="kennel_link" type="text" class="form-control form-control-sm"
                                                aria-describedby="helpId">
                                            <small id="helpId" class="form-text text-muted">
                                                Enter Animal Facility Online Profile (URL/link)
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                {{-- Breeder information --}}
                                <br>
                                <div class="row">
                                    <div class="mb-2">
                                        <h6 class="lead">
                                            Breeder information
                                        </h6>
                                    </div>

                                    <div class="col-12 col-sm-12 col-xxl-4">
                                        <div class="mb-3">
                                            <label for="breeder_name" class="form-label">
                                                <span class="mdi mdi-paw"></span>
                                                Name
                                            </label>
                                            <input id="breeder_name" type="text" class="form-control form-control-sm"
                                                aria-describedby="helpId">
                                            <small id="helpId" class="form-text text-muted">
                                                Enter breeder's Name
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12 col-xxl-4">
                                        <div class="mb-3">
                                            <label for="breeder_link" class="form-label">
                                                <span class="mdi mdi-link"></span>
                                                Online Profile (URL/link)
                                            </label>
                                            <input id="breeder_link" type="text" class="form-control form-control-sm"
                                                aria-describedby="helpId">
                                            <small id="helpId" class="form-text text-muted">
                                                Enter breeder's Online Profile (URL/link)
                                            </small>
                                        </div>
                                    </div>
                                </div>


                                {{-- Sire information --}}
                                <br>
                                <div class="row">
                                    <div class="mb-2">
                                        <h6 class="lead">
                                            Sire information
                                        </h6>
                                    </div>

                                    <div class="col-12 col-sm-12 col-xxl-4">
                                        <div class="mb-3">
                                            <label for="sire_name" class="form-label">
                                                <span class="mdi mdi-alphabetical"></span>
                                                Name
                                            </label>
                                            <input id="sire_name" type="text" class="form-control form-control-sm"
                                                aria-describedby="helpId">
                                            <small id="helpId" class="form-text text-muted">
                                                Enter sire's name
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12 col-xxl-4">
                                        <div class="mb-3">
                                            <label for="sire_breed" class="form-label">
                                                <span class="mdi mdi-dog-side"></span>
                                                Breed
                                            </label>
                                            <input id="sire_breed" type="text" class="form-control form-control-sm"
                                                list="rabbit_breeds" aria-describedby="helpId">
                                            <small id="helpId" class="form-text text-muted">
                                                Enter sire's breed
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12 col-xxl-4">
                                        <div class="mb-3">
                                            <label for="sire_iagd_num" class="form-label">
                                                <span class="mdi mdi-numeric"></span>
                                                IAGD Reg No.
                                            </label>
                                            <input id="sire_iagd_num" type="text" class="form-control form-control-sm"
                                                aria-describedby="helpId">
                                            <small id="helpId" class="form-text text-muted">
                                                Enter sire's IAGD Reg No.
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12 col-xxl-4">
                                        <div class="mb-3">
                                            <label for="sire_image" class="form-label">
                                                <span class="mdi mdi-camera"></span>
                                                Sire's image
                                            </label>
                                            <input id="sire_image" type="file" class="form-control form-control-sm"
                                                aria-describedby="fileHelpId">
                                            <small id="fileHelpId" class="form-text">
                                                Upload sire's supporting documents : acceptable format (jpeg, jpg, png,
                                                webp, gif)
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12 col-xxl-4">
                                        <div class="mb-3">
                                            <label for="sire_supp_doc" class="form-label">
                                                <span class="mdi mdi-file-document-multiple"></span>
                                                Sire's supporting document
                                            </label>
                                            <input id="sire_supp_doc" type="file" class="form-control form-control-sm"
                                                aria-describedby="fileHelpId">
                                            <small id="fileHelpId" class="form-text">
                                                Upload sire's supporting documents : acceptable format (jpeg, jpg, png,
                                                webp, gif)
                                            </small>
                                        </div>
                                    </div>


                                </div>


                                {{-- Dam information --}}
                                <br>
                                <div class="row">
                                    <div class="mb-2">
                                        <h6 class="lead">
                                            Dam information
                                        </h6>
                                    </div>

                                    <div class="col-12 col-sm-12 col-xxl-4">
                                        <div class="mb-3">
                                            <label for="dam_name" class="form-label">
                                                <span class="mdi mdi-alphabetical"></span>
                                                Name
                                            </label>
                                            <input id="dam_name" type="text" class="form-control form-control-sm"
                                                aria-describedby="helpId">
                                            <small id="helpId" class="form-text text-muted">
                                                Enter dam's name
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12 col-xxl-4">
                                        <div class="mb-3">
                                            <label for="dam_breed" class="form-label">
                                                <span class="mdi mdi-dog-side"></span>
                                                Breed
                                            </label>
                                            <input id="dam_breed" type="text" class="form-control form-control-sm"
                                                list="rabbit_breeds" aria-describedby="helpId">
                                            <small id="helpId" class="form-text text-muted">
                                                Enter dam's breed
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12 col-xxl-4">
                                        <div class="mb-3">
                                            <label for="dam_iagd_num" class="form-label">
                                                <span class="mdi mdi-numeric"></span>
                                                IAGD Reg No.
                                            </label>
                                            <input id="dam_iagd_num" type="text" class="form-control form-control-sm"
                                                aria-describedby="helpId">
                                            <small id="helpId" class="form-text text-muted">
                                                Enter dam's IAGD Reg No.
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12 col-xxl-4">
                                        <div class="mb-3">
                                            <label for="dam_image" class="form-label">
                                                <span class="mdi mdi-camera"></span>
                                                Dam's image
                                            </label>
                                            <input id="dam_image" type="file" class="form-control form-control-sm"
                                                aria-describedby="fileHelpId">
                                            <small id="fileHelpId" class="form-text">
                                                Upload dam's supporting documents : acceptable format (jpeg, jpg, png,
                                                webp, gif)
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-12 col-sm-12 col-xxl-4">
                                        <div class="mb-3">
                                            <label for="dam_supp_doc" class="form-label">
                                                <span class="mdi mdi-file-document-multiple"></span>
                                                Dam's supporting document
                                            </label>
                                            <input id="dam_supp_doc" type="file" class="form-control form-control-sm"
                                                aria-describedby="fileHelpId">
                                            <small id="fileHelpId" class="form-text">
                                                Upload dam's supporting documents : acceptable format (jpeg, jpg, png,
                                                webp, gif)
                                            </small>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="row">
                                    <div class="d-flex flex-column justify-content-start align-items-end">
                                        <div class="d-flex flex-row w-100 justify-content-between">

                                            <div>
                                                <a class="btn btn-secondary btn-sm" href="{{ route('user.pet_list') }}">
                                                    <span class="mdi mdi-arrow-left"></span>
                                                    Return to list
                                                </a>
                                            </div>

                                            <div>
                                                <button id="registerRabbitButton" type="button" class="btn btn-primary btn-sm">
                                                    <span class="mdi mdi-plus"></span>
                                                    Register
                                                </button>
                                            </div>
                                        </div>

                                        <div id="reg-prompt-container" class="vertical-middle mt-3">
                                            {{-- Sample content for registration response status --}}
                                            {{-- <div class="text-success"> --}}
                                                {{-- <span class="mdi mdi-check-bold"></span> --}}
                                                {{-- <span class="mdi mdi-close-thick"></span> --}}
                                                {{-- <span class="mdi mdi-alert"></span> --}}
                                                {{-- <span class="mdi mdi-information-outline"></span> --}}
                                                {{-- Sample content for registration response status. --}}
                                            {{-- </div> --}}
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
    @include('pages.users.animal-pages.datalist-rabbit-breeds')
    {{-- Include custom user toast --}}
    @include('pages/users/template/section/user-toasts')

    {{-- SCRIPTS --}}
    @include('pages/users/template/section/scripts')
    @include('pages/users/template/section/scripts-var')

    <script src="{{ asset('js/animal-pages/rabbit-registration.js') }}"></script>

    <script type="text/javascript">

        $(document).ready(function() {
            /* Session preset */
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
