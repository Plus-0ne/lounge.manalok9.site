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

                            <div class="d-flex flex-column p-0 p-lg-3 w-100">
                                <div class="col-12">
                                    <h4>
                                        Pet information
                                    </h4>
                                    <small>
                                        Please verify all details before applying for pet certification.
                                    </small>

                                </div>
                                <hr>
                                <div class="row">
                                    <div class="d-flex flex-column justify-content-start align-items-end">
                                        <div class="d-flex flex-wrap w-100 justify-content-between">

                                            <div>
                                                <a class="btn btn-secondary btn-sm mb-2"
                                                    href="{{ route('user.pet_list') }}">
                                                    <span class="mdi mdi-arrow-left"></span>
                                                    Return to list
                                                </a>
                                            </div>

                                            <div class="d-flex flex-column flex-xl-row">
                                                <a class="btn btn-success btn-sm mb-2 me-2" href="{{ route('user.animal_certifcation') }}?PetUUID={{ $data['pDetails']->PetUUID }}">
                                                    <span class="mdi mdi-certificate"></span>
                                                    Request certificate
                                                </a>

                                                <button id="editDog" type="button"
                                                    class="btn btn-primary btn-sm mb-2 me-2 onDevBtn">
                                                    <span class="mdi mdi-file-edit-outline"></span>
                                                    Update
                                                </button>
                                                <button id="delPetBtn" type="button"
                                                    class="btn btn-danger btn-sm mb-2">
                                                    <span class="mdi mdi-delete-outline"></span>
                                                    Delete
                                                </button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <hr>
                                {{-- Content here --}}

                                {{-- Basic information --}}
                                <div class="row">
                                    <div class="mb-3">
                                        <h6 class="lead">
                                            {{ $data['pDetails']->PetName }}'s details
                                        </h6>
                                    </div>
                                    <div class="d-flex flex-column flex-xl-row">
                                        <div class="col-12 col-xl-4 px-0 pe-xl-4 pt-3">
                                            <img src="{{ asset(!empty($data['pDetails']->AdtlInfo->petImage) ? $data['pDetails']->AdtlInfo->petImage->file_path : 'img/no_img.jpg') }}"
                                                class="w-100 img-fluid rounded petImagePicture" alt="">
                                        </div>
                                        <div class="col-12 col-xl-8 px-2 px-xl-4 pt-3 borderleft-line">

                                            {{-- Basic details --}}
                                            <div>
                                                <div class="mb-3">
                                                    <div class="ccolapse-pet-text lead" type="button">
                                                        Basic details <span class="mdi mdi-chevron-down"></span>
                                                    </div>
                                                </div>
                                                <div class="collapse show">
                                                    <dl class="row fs-text">
                                                        <dt class="col-sm-4">
                                                            Name
                                                        </dt>
                                                        <dd class="col-sm-8">
                                                            {{ !empty($data['pDetails']->PetName) ? $data['pDetails']->PetName : 'N/A' }}
                                                        </dd>
                                                        <dt class="col-sm-4">
                                                            Microchip #
                                                        </dt>
                                                        <dd class="col-sm-8">
                                                            {{ !empty($data['pDetails']->AdtlInfo->MicrochipNo) ? $data['pDetails']->AdtlInfo->MicrochipNo : 'N/A' }}
                                                        </dd>

                                                        <dt class="col-sm-4">
                                                            Birtdate
                                                        </dt>
                                                        <dd class="col-sm-8">
                                                            {{ !empty($data['pDetails']->BirthDate) ? $data['pDetails']->BirthDate : 'N/A' }}
                                                        </dd>
                                                        <dt class="col-sm-4">
                                                            Age
                                                        </dt>
                                                        <dd class="col-sm-8">
                                                            {{ !empty($data['pDetails']->AdtlInfo->AgeInMonths) ? $data['pDetails']->AdtlInfo->AgeInMonths : 'N/A' }}
                                                        </dd>

                                                        <dt class="col-sm-4">
                                                            Gender
                                                        </dt>
                                                        <dd class="col-sm-8">
                                                            {{ !empty($data['pDetails']->Gender) ? Str::ucfirst($data['pDetails']->Gender) : 'N/A' }}
                                                        </dd>

                                                        <dt class="col-sm-4">
                                                            Breed
                                                        </dt>
                                                        <dd class="col-sm-8">
                                                            {{ !empty($data['pDetails']->Breed) ? Str::ucfirst($data['pDetails']->Breed) : 'N/A' }}
                                                        </dd>

                                                        <dt class="col-sm-4">
                                                            Eye Color
                                                        </dt>
                                                        <dd class="col-sm-8">
                                                            {{ !empty($data['pDetails']->EyeColor) ? Str::ucfirst($data['pDetails']->EyeColor) : 'N/A' }}
                                                        </dd>

                                                        <dt class="col-sm-4">
                                                            Pet Color
                                                        </dt>
                                                        <dd class="col-sm-8">
                                                            {{ !empty($data['pDetails']->PetColor) ? Str::ucfirst($data['pDetails']->PetColor) : 'N/A' }}
                                                        </dd>

                                                        <dt class="col-sm-4">
                                                            Markings
                                                        </dt>
                                                        <dd class="col-sm-8">
                                                            {{ !empty($data['pDetails']->Markings) ? Str::ucfirst($data['pDetails']->Markings) : 'N/A' }}
                                                        </dd>

                                                        <dt class="col-sm-4">
                                                            Height
                                                        </dt>
                                                        <dd class="col-sm-8">
                                                            {{ !empty($data['pDetails']->Height) ? Str::ucfirst($data['pDetails']->Height) : 'N/A' }}
                                                        </dd>

                                                        <dt class="col-sm-4">
                                                            Weight
                                                        </dt>
                                                        <dd class="col-sm-8">
                                                            {{ !empty($data['pDetails']->Weight) ? Str::ucfirst($data['pDetails']->Weight) : 'N/A' }}
                                                        </dd>

                                                        <dt class="col-sm-4">
                                                            Address / Location
                                                        </dt>
                                                        <dd class="col-sm-8">
                                                            {{ !empty($data['pDetails']->Location) ? Str::ucfirst($data['pDetails']->Location) : 'N/A' }}
                                                        </dd>

                                                        <dt class="col-sm-4">
                                                            Co-owner's name
                                                        </dt>
                                                        <dd class="col-sm-8">
                                                            {{ !empty($data['pDetails']->Co_Owner) ? Str::ucfirst($data['pDetails']->Co_Owner) : 'N/A' }}
                                                        </dd>

                                                        <dt class="col-sm-4">
                                                            Supporting document
                                                        </dt>
                                                        <dd class="col-sm-8">
                                                            @if (!empty($data['pDetails']->OwnerUUID))
                                                                @if ($data['pDetails']->OwnerUUID == Auth::guard('web')->user()->uuid)
                                                                    <a href="{{ !empty($data['pDetails']->AdtlInfo->petSupportingDocuments->file_path) ? URL::to($data['pDetails']->AdtlInfo->petSupportingDocuments->file_path) : 'javascript:void(0);' }}"
                                                                        type="button" class="btn-links"
                                                                        {{ !empty($data['pDetails']->AdtlInfo->petSupportingDocuments->file_path) ? 'download' : '' }}>
                                                                        Download
                                                                    </a>
                                                                @else
                                                                    ---
                                                                @endif
                                                            @else
                                                                ---
                                                            @endif

                                                        </dd>

                                                    </dl>
                                                </div>
                                            </div>

                                            {{-- Veterinarian / Clinic record --}}
                                            <div>
                                                <div class="mb-3">
                                                    <div class="ccolapse-pet-text lead" type="button">
                                                        Veterenary / Clinical details <span
                                                            class="mdi mdi-chevron-down"></span>
                                                    </div>
                                                </div>
                                                <div class="collapse show">
                                                    <dl class="row fs-text">
                                                        <dt class="col-sm-4">
                                                            Vet / Clinic's Name
                                                        </dt>
                                                        <dd class="col-sm-8">
                                                            {{ !empty($data['pDetails']->AdtlInfo->VetClinicName) ? Str::ucfirst($data['pDetails']->AdtlInfo->VetClinicName) : 'N/A' }}
                                                        </dd>
                                                        <dt class="col-sm-4">
                                                            Vet / Clinic's Online Profile (URL/link)
                                                        </dt>
                                                        <dd class="col-sm-8">
                                                            {{ !empty($data['pDetails']->AdtlInfo->VetOnlineProfile) ? Str::ucfirst($data['pDetails']->AdtlInfo->VetOnlineProfile) : 'N/A' }}
                                                        </dd>
                                                        <dt class="col-sm-4">
                                                            Vet / Clinic's record
                                                        </dt>
                                                        <dd class="col-sm-8">
                                                            @if (!empty($data['pDetails']->OwnerUUID))
                                                                @if ($data['pDetails']->OwnerUUID == Auth::guard('web')->user()->uuid)
                                                                    <a href="{{ !empty($data['pDetails']->AdtlInfo->petVetRecord->file_path) ? URL::to($data['pDetails']->AdtlInfo->petVetRecord->file_path) : 'javascript:void(0);' }}"
                                                                        type="button" class="btn-links"
                                                                        {{ !empty($data['pDetails']->AdtlInfo->petVetRecord->file_path) ? 'download' : '' }}>
                                                                        Download
                                                                    </a>
                                                                @else
                                                                    ---
                                                                @endif
                                                            @else
                                                                ---
                                                            @endif

                                                        </dd>

                                                    </dl>
                                                </div>
                                            </div>

                                            {{-- Kennels record --}}
                                            <div>
                                                <div class="mb-3">
                                                    <div class="ccolapse-pet-text lead" type="button">
                                                        Kennel's details <span class="mdi mdi-chevron-down"></span>
                                                    </div>
                                                </div>
                                                <div class="collapse show">
                                                    <dl class="row fs-text">
                                                        <dt class="col-sm-4">
                                                            Name
                                                        </dt>
                                                        <dd class="col-sm-8">
                                                            {{ !empty($data['pDetails']->AdtlInfo->ShelterInfo) ? Str::ucfirst($data['pDetails']->AdtlInfo->ShelterInfo) : 'N/A' }}
                                                        </dd>
                                                        <dt class="col-sm-4">
                                                            Online Profile (URL/link)
                                                        </dt>
                                                        <dd class="col-sm-8">
                                                            {{ !empty($data['pDetails']->AdtlInfo->ShelterOnlineProfile) ? Str::ucfirst($data['pDetails']->AdtlInfo->ShelterOnlineProfile) : 'N/A' }}
                                                        </dd>


                                                    </dl>
                                                </div>
                                            </div>

                                            {{-- Breeders record --}}
                                            <div>
                                                <div class="mb-3">
                                                    <div class="ccolapse-pet-text lead" type="button">
                                                        Breeder's details <span class="mdi mdi-chevron-down"></span>
                                                    </div>
                                                </div>
                                                <div class="collapse show">
                                                    <dl class="row fs-text">
                                                        <dt class="col-sm-4">
                                                            Name
                                                        </dt>
                                                        <dd class="col-sm-8">
                                                            {{ !empty($data['pDetails']->AdtlInfo->BreederInfo) ? Str::ucfirst($data['pDetails']->AdtlInfo->BreederInfo) : 'N/A' }}
                                                        </dd>
                                                        <dt class="col-sm-4">
                                                            Online Profile (URL/link)
                                                        </dt>
                                                        <dd class="col-sm-8">
                                                            {{ !empty($data['pDetails']->AdtlInfo->BreederOnlineProfile) ? Str::ucfirst($data['pDetails']->AdtlInfo->BreederOnlineProfile) : 'N/A' }}
                                                        </dd>


                                                    </dl>
                                                </div>
                                            </div>


                                            {{-- Sire record --}}
                                            <div>
                                                <div class="mb-3">
                                                    <div class="ccolapse-pet-text lead" type="button">
                                                        Sire's details <span class="mdi mdi-chevron-down"></span>
                                                    </div>
                                                </div>
                                                <div class="collapse show">
                                                    <dl class="row fs-text">
                                                        <dt class="col-sm-4">
                                                            Name
                                                        </dt>
                                                        <dd class="col-sm-8">
                                                            {{ !empty($data['pDetails']->AdtlInfo->SireName) ? Str::ucfirst($data['pDetails']->AdtlInfo->SireName) : 'N/A' }}
                                                        </dd>

                                                        <dt class="col-sm-4">
                                                            Breed
                                                        </dt>
                                                        <dd class="col-sm-8">
                                                            {{ !empty($data['pDetails']->AdtlInfo->SireBreed) ? Str::ucfirst($data['pDetails']->AdtlInfo->SireBreed) : 'N/A' }}
                                                        </dd>

                                                        <dt class="col-sm-4">
                                                            IAGD Reg No.
                                                        </dt>
                                                        <dd class="col-sm-8">
                                                            {{ !empty($data['pDetails']->AdtlInfo->SireRegNo) ? $data['pDetails']->AdtlInfo->SireRegNo : 'N/A' }}
                                                        </dd>

                                                        <dt class="col-sm-4">
                                                            Sire's image
                                                        </dt>
                                                        <dd class="col-sm-8">
                                                            @if (!empty($data['pDetails']->OwnerUUID))
                                                                @if ($data['pDetails']->OwnerUUID == Auth::guard('web')->user()->uuid)
                                                                    <a href="{{ !empty($data['pDetails']->AdtlInfo->petSireImage->file_path) ? URL::to($data['pDetails']->AdtlInfo->petSireImage->file_path) : 'javascript:void(0);' }}"
                                                                        type="button" class="btn-links"
                                                                        {{ !empty($data['pDetails']->AdtlInfo->petSireImage->file_path) ? 'download' : '' }}>
                                                                        Download
                                                                    </a>
                                                                @else
                                                                    ---
                                                                @endif
                                                            @else
                                                                ---
                                                            @endif

                                                        </dd>

                                                        <dt class="col-sm-4">
                                                            Sire's supporting document
                                                        </dt>
                                                        <dd class="col-sm-8">
                                                            @if (!empty($data['pDetails']->OwnerUUID))
                                                                @if ($data['pDetails']->OwnerUUID == Auth::guard('web')->user()->uuid)
                                                                    <a href="{{ !empty($data['pDetails']->AdtlInfo->petSireSupportingDocuments->file_path) ? URL::to($data['pDetails']->AdtlInfo->petSireSupportingDocuments->file_path) : 'javascript:void(0);' }}"
                                                                        type="button" class="btn-links"
                                                                        {{ !empty($data['pDetails']->AdtlInfo->petSireSupportingDocuments->file_path) ? 'download' : '' }}>
                                                                        Download
                                                                    </a>
                                                                @else
                                                                    ---
                                                                @endif
                                                            @else
                                                                ---
                                                            @endif

                                                        </dd>


                                                    </dl>
                                                </div>
                                            </div>

                                            {{-- Dam record --}}
                                            <div>
                                                <div class="mb-3">
                                                    <div class="ccolapse-pet-text lead" type="button">
                                                        Dam's details <span class="mdi mdi-chevron-down"></span>
                                                    </div>
                                                </div>
                                                <div class="collapse show">
                                                    <dl class="row fs-text">
                                                        <dt class="col-sm-4">
                                                            Name
                                                        </dt>
                                                        <dd class="col-sm-8">
                                                            {{ !empty($data['pDetails']->AdtlInfo->DamName) ? Str::ucfirst($data['pDetails']->AdtlInfo->DamName) : 'N/A' }}
                                                        </dd>

                                                        <dt class="col-sm-4">
                                                            Breed
                                                        </dt>
                                                        <dd class="col-sm-8">
                                                            {{ !empty($data['pDetails']->AdtlInfo->DamBreed) ? Str::ucfirst($data['pDetails']->AdtlInfo->DamBreed) : 'N/A' }}
                                                        </dd>

                                                        <dt class="col-sm-4">
                                                            IAGD Reg No.
                                                        </dt>
                                                        <dd class="col-sm-8">
                                                            {{ !empty($data['pDetails']->AdtlInfo->DamRegNo) ? $data['pDetails']->AdtlInfo->DamRegNo : 'N/A' }}
                                                        </dd>

                                                        <dt class="col-sm-4">
                                                            Dam's image
                                                        </dt>
                                                        <dd class="col-sm-8">
                                                            @if (!empty($data['pDetails']->OwnerUUID))
                                                                @if ($data['pDetails']->OwnerUUID == Auth::guard('web')->user()->uuid)
                                                                    <a href="{{ !empty($data['pDetails']->AdtlInfo->petDamImage->file_path) ? URL::to($data['pDetails']->AdtlInfo->petDamImage->file_path) : 'javascript:void(0);' }}"
                                                                        type="button" class="btn-links"
                                                                        {{ !empty($data['pDetails']->AdtlInfo->petDamImage->file_path) ? 'download' : '' }}>
                                                                        Download
                                                                    </a>
                                                                @else
                                                                    ---
                                                                @endif
                                                            @else
                                                                ---
                                                            @endif

                                                        </dd>

                                                        <dt class="col-sm-4">
                                                            Dam's supporting document
                                                        </dt>
                                                        <dd class="col-sm-8">
                                                            @if (!empty($data['pDetails']->OwnerUUID))
                                                                @if ($data['pDetails']->OwnerUUID == Auth::guard('web')->user()->uuid)
                                                                    <a href="{{ !empty($data['pDetails']->AdtlInfo->petDamSupportingDocuments->file_path) ? URL::to($data['pDetails']->AdtlInfo->petDamSupportingDocuments->file_path) : 'javascript:void(0);' }}"
                                                                        type="button" class="btn-links"
                                                                        {{ !empty($data['pDetails']->AdtlInfo->petDamSupportingDocuments->file_path) ? 'download' : '' }}>
                                                                        Download
                                                                    </a>
                                                                @else
                                                                    ---
                                                                @endif
                                                            @else
                                                                ---
                                                            @endif

                                                        </dd>


                                                    </dl>
                                                </div>
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
    @if (!empty($data['pDetails']->OwnerUUID))
        @if ($data['pDetails']->OwnerUUID == Auth::guard('web')->user()->uuid)
            @include('pages.users.animal-pages.modal-pet-image-full')
        @endif
    @endif

    @include('pages.users.animal-pages.modal-pet-delete-confirmation')
    {{-- Include custom user toast --}}
    @include('pages/users/template/section/user-toasts')

    {{-- SCRIPTS --}}
    @include('pages/users/template/section/scripts')
    @include('pages/users/template/section/scripts-var')
    <script src="{{ asset('js/animal-pages/pet-information.js') }}"></script>

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
