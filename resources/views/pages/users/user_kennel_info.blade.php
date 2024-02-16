{{-- HEADER CONTAINS CSS LINKS --}}
@include('pages/users/template/section/header')

<body>
    <div class="wrapper">

        {{-- TOP NAVIGATION --}}
        @include('pages/users/template/section/header_nav')

        <div class="main">

            {{-- SIDABAR --}}
            @include('pages/users/template/section/sidebar')

            <div class="main-content h-100">
                <div class="container-fluid container-xl">
                    <div class="row">
                        <div class="p-4 gallery_container d-flex flex-wrap">
                            <div class="row px-5">
                                <h5 class="text-light py-3 px-4" style="background-color: #1e2530; margin-top: -2.8rem;">
                                    <a href="{{ url('kennel') }}" class="me-2">
                                        <i class="mdi mdi-chevron-left text-light"></i>
                                    </a>
                                    Dog Profile
                                </h5>
                            </div>
                            @if ($data['pet_data']->OwnerUUID == Auth::guard('web')->user()->uuid || (!empty($data['pet_data']->OwnerIAGDNo) && $data['pet_data']->OwnerIAGDNo == Auth::guard('web')->user()->iagd_number))
                                <div class="col-12 my-2 text-end">
                                    {{-- <a class="btn-cert_gen btn btn-success mb-1" data-id="{{ $data['pet_data']->ID }}">
                                        Certificate
                                    </a>
                                    <a class="btn-pedi_gen btn btn-success mb-1" data-id="{{ $data['pet_data']->ID }}">
                                        Pedigree
                                    </a> --}}

                                    <div class="dropdown d-inline">
                                        <button class="btn btn-info fw-bold mb-1" type="button" data-bs-toggle="dropdown">
                                            @if ($data['pet_data']->Visibility == 1)
                                                <i class="mdi mdi-eye"></i> Public
                                            @elseif ($data['pet_data']->Visibility == 0)
                                                <i class="mdi mdi-eye-off"></i> Private
                                            @endif
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-start">
                                            <li>
                                                @if ($data['pet_data']->Visibility == 1)
                                                    <a class="dropdown-item toggle-visibilityPrivate" href="#">
                                                        <i class="mdi mdi-eye-off"></i> Private
                                                    </a>
                                                @elseif ($data['pet_data']->Visibility == 0)
                                                    <a class="dropdown-item toggle-visibilityPublic" href="#">
                                                        <i class="mdi mdi-eye"></i> Public
                                                    </a>
                                                @endif
                                            </li>
                                        </ul>
                                    </div>

                                    {{-- <button type="button" class="btn btn-primary btn-size-95-rem shadow"
                                        data-bs-target="#update_dog" data-bs-toggle="modal">
                                        <i class="mdi mdi-square-edit-outline"></i> UPDATE
                                    </button> --}}
                                </div>
                            @endif
                            <div class="row p-3 w-100">
                                <div class="col-12 col-sm-12">
                                    <div class="row">
                                        <dl class="col-12 col-sm-12 col-md-12 col-lg-12">
                                            <dt class="text-center text-md-start">
                                                <i class="mdi mdi-paw mdi-24px pe-1"></i> Name:
                                            </dt>
                                            <dd class="pe-md-3 pe-xl-5">
                                                <div class="text-center text-md-start shadow px-4 py-3">
                                                    {{ $data['pet_data']->PetName ?? '- - - - -' }}
                                                </div>
                                            </dd>
                                        </dl>
                                        <dl class="col-12 col-sm-12 col-md-12 col-lg-12">
                                            <dt class="text-center text-md-start">
                                                <i class="mdi mdi-numeric mdi-24px pe-1"></i> Microchip No:
                                            </dt>
                                            <dd class="pe-md-3 pe-xl-5">
                                                <div class="text-center text-md-start shadow px-4 py-3">
                                                    {{ $data['adtl_data']->MicrochipNo ?? '- - - - -' }}
                                                </div>
                                            </dd>
                                        </dl>
                                        <dl class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
                                            <dt class="text-center text-md-start">
                                                <i class="mdi mdi-cake-variant-outline mdi-24px pe-1"></i> Birth Date:
                                            </dt>
                                            <dd class="pe-md-3 pe-xl-5">
                                                <div class="text-center text-md-start shadow px-4 py-3">
                                                    <i class="mdi mdi-calendar-range pe-1"></i> {{ $data['pet_data']->BirthDate ?? '- - - - -' }}
                                                </div>
                                            </dd>
                                        </dl>
                                        <dl class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
                                            <dt class="text-center text-md-start">
                                                <i class="mdi mdi-calendar-month mdi-24px pe-1"></i> Age (in months):
                                            </dt>
                                            <dd class="pe-md-3 pe-xl-5">
                                                <div class="text-center text-md-start shadow px-4 py-3">
                                                    {{ $data['adtl_data']->AgeInMonths ?? '- - - - -' }}
                                                </div>
                                            </dd>
                                        </dl>
                                        <dl class="col-12 col-sm-12 col-lg-12 col-xl-6">
                                            <dt class="text-center text-md-start">
                                                <i class="mdi mdi-gender-male-female mdi-24px pe-1"></i> Gender:
                                            </dt>
                                            <dd class="pe-md-3 pe-xl-5">
                                                <div class="text-center text-md-start shadow px-4 py-3">
                                                    {{ $data['pet_data']->Gender ?? '- - - - -' }}
                                                </div>
                                            </dd>
                                        </dl>
                                        <dl class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
                                            <dt class="text-center text-md-start">
                                                <i class="mdi mdi-dog-side mdi-24px pe-1"></i> Breed:
                                            </dt>
                                            <dd class="pe-md-3 pe-xl-5">
                                                <div class="text-center text-md-start shadow px-4 py-3">
                                                    {{ $data['pet_data']->Breed ?? '- - - - -' }}
                                                </div>
                                            </dd>
                                        </dl>
                                        <dl class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
                                            <dt class="text-center text-md-start">
                                                <i class="mdi mdi-eye mdi-24px pe-1"></i> Eye Color:
                                            </dt>
                                            <dd class="pe-md-3 pe-xl-5">
                                                <div class="text-center text-md-start shadow px-4 py-3">
                                                    {{ $data['pet_data']->EyeColor ?? '- - - - -' }}
                                                </div>
                                            </dd>
                                        </dl>
                                        <dl class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
                                            <dt class="text-center text-md-start">
                                                <i class="mdi mdi-palette mdi-24px pe-1"></i> Pet Color:
                                            </dt>
                                            <dd class="pe-md-3 pe-xl-5">
                                                <div class="text-center text-md-start shadow px-4 py-3">
                                                    {{ $data['pet_data']->PetColor ?? '- - - - -' }}
                                                </div>
                                            </dd>
                                        </dl>
                                        <dl class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
                                            <dt class="text-center text-md-start">
                                                <i class="mdi mdi-star-half-full mdi-24px pe-1"></i> Markings:
                                            </dt>
                                            <dd class="pe-md-3 pe-xl-5">
                                                <div class="text-center text-md-start shadow px-4 py-3">
                                                    {{ $data['pet_data']->Markings ?? '- - - - -' }}
                                                </div>
                                            </dd>
                                        </dl>
                                        <dl class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
                                            <dt class="text-center text-md-start">
                                                <i class="mdi mdi-arrow-up-down mdi-24px pe-1"></i> Height:
                                            </dt>
                                            <dd class="pe-md-3 pe-xl-5">
                                                <div class="text-center text-md-start shadow px-4 py-3">
                                                    {{ $data['pet_data']->Height ?? '- - - - -' }}
                                                </div>
                                            </dd>
                                        </dl>
                                        <dl class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
                                            <dt class="text-center text-md-start">
                                                <i class="mdi mdi-weight mdi-24px pe-1"></i> Weight:
                                            </dt>
                                            <dd class="pe-md-3 pe-xl-5">
                                                <div class="text-center text-md-start shadow px-4 py-3">
                                                    {{ $data['pet_data']->Weight ?? '- - - - -' }}
                                                </div>
                                            </dd>
                                        </dl>
                                        <dl class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
                                            <dt class="text-center text-md-start">
                                                <i class="mdi mdi-map-marker mdi-24px pe-1"></i> Location:
                                            </dt>
                                            <dd class="pe-md-3 pe-xl-5">
                                                <div class="text-center text-md-start shadow px-4 py-3">
                                                    {{ $data['pet_data']->Location ?? '- - - - -' }}
                                                </div>
                                            </dd>
                                        </dl>
                                        <dl class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
                                            <dt class="text-center text-md-start">
                                                <i class="mdi mdi-account-multiple mdi-24px pe-1"></i> Co-Owner:
                                            </dt>
                                            <dd class="pe-md-3 pe-xl-5">
                                                <div class="text-center text-md-start shadow px-4 py-3">
                                                    {{ $data['pet_data']->Co_Owner ?? '- - - - -' }}
                                                </div>
                                            </dd>
                                        </dl>
                                        <div class="col-12"></div>
                                        <dl class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
                                            <dt class="text-center text-md-start">
                                                <i class="mdi mdi-file-image mdi-24px pe-1"></i> Pet Photo:
                                            </dt>
                                            <dd class="pe-md-3 pe-xl-5">
                                                <div class="text-center text-md-start shadow px-4 py-3">
                                                    @if (isset($data['Photo']))
                                                        <img class="mw-100" src="{{ url('/') . '/' . $data['Photo']['file_path'] ?? '- - - - -' }}" style="max-width: 450px; max-height: 450px;">
                                                    @else
                                                        - - - - -
                                                    @endif
                                                </div>
                                            </dd>
                                        </dl>

                                    @if ($data['pet_data']->OwnerUUID == Auth::guard('web')->user()->uuid || (!empty($data['pet_data']->OwnerIAGDNo) && $data['pet_data']->OwnerIAGDNo == Auth::guard('web')->user()->iagd_number))
                                            <dl class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6">
                                                <dt class="text-center text-md-start">
                                                    <i class="mdi mdi-file-document mdi-24px pe-1"></i> Supporting Documents:
                                                </dt>
                                                <dd class="pe-md-3 pe-xl-5">
                                                    <div class="text-center text-md-start shadow px-4 py-3">
                                                        @if (isset($data['PetSupportingDocuments']))
                                                            <a class="download_file" href="{{ url('/') . '/' . $data['PetSupportingDocuments']['file_path'] }}">
                                                                <i class="mdi mdi-download mdi-16px pe-1"></i> {{ $data['PetSupportingDocuments']['file_name'] }}
                                                            </a>
                                                        @else
                                                            - - - - -
                                                        @endif
                                                    </div>
                                                </dd>
                                            </dl>
                                        </div>

                                        {{-- VETERINARY --}}
                                        <div class="row adtl_info_label rounded-2 mt-4">
                                            <div class="col"><hr></div>
                                            <div class="col-auto">
                                                <h4 class="fw-bold">VETERINARY DATA</h4>
                                            </div>
                                            <div class="col"><hr></div>
                                        </div>
                                        <div class="row adtl_info d-none">
                                            <dl class="col-12 col-sm-12 col-md-12 col-lg-12">
                                                <dt class="text-center text-md-start">
                                                    <i class="mdi mdi-hospital-box mdi-24px pe-1"></i> Veterinarian or Clinic's Name:
                                                </dt>
                                                <dd class="pe-md-3 pe-xl-5">
                                                    <div class="text-center text-md-start shadow px-4 py-3">
                                                        {{ $data['adtl_data']->VetClinicName ?? '- - - - -' }}
                                                    </div>
                                                </dd>
                                            </dl>
                                            <dl class="col-12 col-sm-12 col-md-12 col-lg-12">
                                                <dt class="text-center text-md-start">
                                                    <i class="mdi mdi-link mdi-24px pe-1"></i> Veterinarians Online Profile (URL/link):
                                                </dt>
                                                <dd class="pe-md-3 pe-xl-5">
                                                    <div class="text-center text-md-start shadow px-4 py-3">
                                                        {{ $data['adtl_data']->VetOnlineProfile ?? '- - - - -' }}
                                                    </div>
                                                </dd>
                                            </dl>
                                            <dl class="col-12 col-sm-12 col-md-12 col-lg-12">
                                                <dt class="text-center text-md-start">
                                                    <i class="mdi mdi-file-upload mdi-24px pe-1"></i> Dog's veterinary record:
                                                </dt>
                                                <dd class="pe-md-3 pe-xl-5">
                                                    <div class="text-center text-md-start shadow px-4 py-3">
                                                        @if (isset($data['VetRecordDocuments']))
                                                            <a class="download_file" href="{{ url('/') . '/' . $data['VetRecordDocuments']['file_path'] }}">
                                                                <i class="mdi mdi-download mdi-16px pe-1"></i> {{ $data['VetRecordDocuments']['file_name'] }}
                                                            </a>
                                                        @else
                                                            - - - - -
                                                        @endif
                                                    </div>
                                                </dd>
                                            </dl>
                                        </div>

                                        {{-- SHELTER --}}
                                        <div class="row adtl_info_label rounded-2 mt-4">
                                            <div class="col"><hr></div>
                                            <div class="col-auto">
                                                <h4 class="fw-bold">KENNEL DATA</h4>
                                            </div>
                                            <div class="col"><hr></div>
                                        </div>
                                        <div class="row adtl_info d-none">
                                            <dl class="col-12 col-sm-12 col-md-12 col-lg-12">
                                                <dt class="text-center text-md-start">
                                                    <i class="mdi mdi-home mdi-24px pe-1"></i> Kennel Information:
                                                </dt>
                                                <dd class="pe-md-3 pe-xl-5">
                                                    <div class="text-center text-md-start shadow px-4 py-3">
                                                        {{ $data['adtl_data']->ShelterInfo ?? '- - - - -' }}
                                                    </div>
                                                </dd>
                                            </dl>
                                            <dl class="col-12 col-sm-12 col-md-12 col-lg-12">
                                                <dt class="text-center text-md-start">
                                                    <i class="mdi mdi-link mdi-24px pe-1"></i> Kennels Online Profile (URL/link):
                                                </dt>
                                                <dd class="pe-md-3 pe-xl-5">
                                                    <div class="text-center text-md-start shadow px-4 py-3">
                                                        {{ $data['adtl_data']->ShelterOnlineProfile ?? '- - - - -' }}
                                                    </div>
                                                </dd>
                                            </dl>
                                            <dl class="col-12 col-sm-12 col-md-12 col-lg-12">
                                                <dt class="text-center text-md-start">
                                                    <i class="mdi mdi-paw mdi-24px pe-1"></i> Breeder Information:
                                                </dt>
                                                <dd class="pe-md-3 pe-xl-5">
                                                    <div class="text-center text-md-start shadow px-4 py-3">
                                                        {{ $data['adtl_data']->BreederInfo ?? '- - - - -' }}
                                                    </div>
                                                </dd>
                                            </dl>
                                            <dl class="col-12 col-sm-12 col-md-12 col-lg-12">
                                                <dt class="text-center text-md-start">
                                                    <i class="mdi mdi-link mdi-24px pe-1"></i> Breeder Online Profile (URL/link):
                                                </dt>
                                                <dd class="pe-md-3 pe-xl-5">
                                                    <div class="text-center text-md-start shadow px-4 py-3">
                                                        {{ $data['adtl_data']->BreederOnlineProfile ?? '- - - - -' }}
                                                    </div>
                                                </dd>
                                            </dl>
                                        </div>

                                        {{-- SIRE --}}
                                        <div class="row adtl_info_label rounded-2 mt-4">
                                            <div class="col"><hr></div>
                                            <div class="col-auto">
                                                <h4 class="fw-bold">SIRE DATA</h4>
                                            </div>
                                            <div class="col"><hr></div>
                                        </div>
                                        <div class="row adtl_info d-none">
                                            <dl class="col-12 col-sm-12 col-md-12 col-lg-12">
                                                <dt class="text-center text-md-start">
                                                    <i class="mdi mdi-alphabetical mdi-24px pe-1"></i> Name of Sire:
                                                </dt>
                                                <dd class="pe-md-3 pe-xl-5">
                                                    <div class="text-center text-md-start shadow px-4 py-3">
                                                        {{ $data['adtl_data']->SireName ?? '- - - - -' }}
                                                    </div>
                                                </dd>
                                            </dl>
                                            <dl class="col-12 col-sm-12 col-md-12 col-lg-12">
                                                <dt class="text-center text-md-start">
                                                    <i class="mdi mdi-file-image mdi-24px pe-1"></i> Sire Image:
                                                </dt>
                                                <dd class="pe-md-3 pe-xl-5">
                                                    <div class="text-center text-md-start shadow px-4 py-3">
                                                        @if (isset($data['SireImage']))
                                                            <img class="mw-100" src="{{ url('/') . '/' . $data['SireImage']['file_path'] ?? '- - - - -' }}" style="max-width: 450px; max-height: 450px;">
                                                        @else
                                                            - - - - -
                                                        @endif
                                                    </div>
                                                </dd>
                                            </dl>
                                            <dl class="col-12 col-sm-12 col-md-12 col-lg-12">
                                                <dt class="text-center text-md-start">
                                                    <i class="mdi mdi-file-upload mdi-24px pe-1"></i> Other sire supporting documents:
                                                </dt>
                                                <dd class="pe-md-3 pe-xl-5">
                                                    <div class="text-center text-md-start shadow px-4 py-3">
                                                        @if (isset($data['SireSupportingDocuments']))
                                                            <a class="download_file" href="{{ url('/') . '/' . $data['SireSupportingDocuments']['file_path'] }}">
                                                                <i class="mdi mdi-download mdi-16px pe-1"></i> {{ $data['SireSupportingDocuments']['file_name'] }}
                                                            </a>
                                                        @else
                                                            - - - - -
                                                        @endif
                                                    </div>
                                                </dd>
                                            </dl>
                                            <dl class="col-12 col-sm-12 col-md-12 col-lg-12">
                                                <dt class="text-center text-md-start">
                                                    <i class="mdi mdi-dog-side mdi-24px pe-1"></i> Breed:
                                                </dt>
                                                <dd class="pe-md-3 pe-xl-5">
                                                    <div class="text-center text-md-start shadow px-4 py-3">
                                                        {{ $data['adtl_data']->SireBreed ?? '- - - - -' }}
                                                    </div>
                                                </dd>
                                            </dl>
                                            <dl class="col-12 col-sm-12 col-md-12 col-lg-12">
                                                <dt class="text-center text-md-start">
                                                    <i class="mdi mdi-numeric mdi-24px pe-1"></i> IAGD Reg No.:
                                                </dt>
                                                <dd class="pe-md-3 pe-xl-5">
                                                    <div class="text-center text-md-start shadow px-4 py-3">
                                                        {{ $data['adtl_data']->SireRegNo ?? '- - - - -' }}
                                                    </div>
                                                </dd>
                                            </dl>
                                        </div>

                                        {{-- DAM --}}
                                        <div class="row adtl_info_label rounded-2 mt-4">
                                            <div class="col"><hr></div>
                                            <div class="col-auto">
                                                <h4 class="fw-bold">DAM DATA</h4>
                                            </div>
                                            <div class="col"><hr></div>
                                        </div>
                                        <div class="row adtl_info d-none">
                                            <dl class="col-12 col-sm-12 col-md-12 col-lg-12">
                                                <dt class="text-center text-md-start">
                                                    <i class="mdi mdi-alphabetical mdi-24px pe-1"></i> Name of Dam:
                                                </dt>
                                                <dd class="pe-md-3 pe-xl-5">
                                                    <div class="text-center text-md-start shadow px-4 py-3">
                                                        {{ $data['adtl_data']->DamName ?? '- - - - -' }}
                                                    </div>
                                                </dd>
                                            </dl>
                                            <dl class="col-12 col-sm-12 col-md-12 col-lg-12">
                                                <dt class="text-center text-md-start">
                                                    <i class="mdi mdi-file-image mdi-24px pe-1"></i> Dam Image:
                                                </dt>
                                                <dd class="pe-md-3 pe-xl-5">
                                                    <div class="text-center text-md-start shadow px-4 py-3">
                                                        @if (isset($data['DamImage']))
                                                            <img class="mw-100" src="{{ url('/') . '/' . $data['DamImage']['file_path'] ?? '- - - - -' }}" style="max-width: 450px; max-height: 450px;">
                                                        @else
                                                            - - - - -
                                                        @endif
                                                    </div>
                                                </dd>
                                            </dl>
                                            <dl class="col-12 col-sm-12 col-md-12 col-lg-12">
                                                <dt class="text-center text-md-start">
                                                    <i class="mdi mdi-file-upload mdi-24px pe-1"></i> Other dam supporting documents:
                                                </dt>
                                                <dd class="pe-md-3 pe-xl-5">
                                                    <div class="text-center text-md-start shadow px-4 py-3">
                                                        @if (isset($data['DamSupportingDocuments']))
                                                            <a class="download_file" href="{{ url('/') . '/' . $data['DamSupportingDocuments']['file_path'] }}">
                                                                <i class="mdi mdi-download mdi-16px pe-1"></i> {{ $data['DamSupportingDocuments']['file_name'] }}
                                                            </a>
                                                        @else
                                                            - - - - -
                                                        @endif
                                                    </div>
                                                </dd>
                                            </dl>
                                            <dl class="col-12 col-sm-12 col-md-12 col-lg-12">
                                                <dt class="text-center text-md-start">
                                                    <i class="mdi mdi-dog-side mdi-24px pe-1"></i> Breed:
                                                </dt>
                                                <dd class="pe-md-3 pe-xl-5">
                                                    <div class="text-center text-md-start shadow px-4 py-3">
                                                        {{ $data['adtl_data']->DamBreed ?? '- - - - -' }}
                                                    </div>
                                                </dd>
                                            </dl>
                                            <dl class="col-12 col-sm-12 col-md-12 col-lg-12">
                                                <dt class="text-center text-md-start">
                                                    <i class="mdi mdi-numeric mdi-24px pe-1"></i> IAGD Reg No.:
                                                </dt>
                                                <dd class="pe-md-3 pe-xl-5">
                                                    <div class="text-center text-md-start shadow px-4 py-3">
                                                        {{ $data['adtl_data']->DamRegNo ?? '- - - - -' }}
                                                    </div>
                                                </dd>
                                            </dl>
                                        </div>
                                    @else
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('pages/users/template/section/r-sidebar')
        </div>
    </div>
    {{-- INCLUDE MODAL TEMPLATE --}}
    {{-- @include('pages/users/template/modals/modal-update-dog')
    @include('pages/users/template/modals/upload_pet_profile_modal') --}}

    {{-- INCLUDE MODAL TEMPLATE IF OWNER --}}
    @if ($data['pet_data']->OwnerUUID == Auth::guard('web')->user()->uuid || (!empty($data['pet_data']->OwnerIAGDNo) && $data['pet_data']->OwnerIAGDNo == Auth::guard('web')->user()->iagd_number))
        @include('pages/users/template/modals/modal-generate-pet-certificate')
        @include('pages/users/template/modals/modal-generate-pet-pedigree')
    @endif

</body>

{{-- SCRIPTS --}}
@include('pages/users/template/section/scripts')

<script type="text/javascript">
    var pType = 'dog';
    var js_var = @json($data['js_var']);
</script>
<script src="{{ asset('jqueryCropper/cropper.js') }}"></script>
<link href="{{ asset('jqueryCropper/cropper.css') }}" rel="stylesheet">
<script src="{{ asset('jqueryCropper/jquery-cropper.js') }}"></script>
<script src="{{ asset('custom/js/pet-profile.js') }}"></script>
<script src="{{ asset('custom/js/pet-generator.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        @if ($errors->any())
            toastr["warning"]('{{ $errors->first() }}');
        @endif
        @if (Session::has('response'))
            @switch(Session::get('response'))
                @case('key_error')
                    toastr["error"]('Something\'s wrong! Please try again.');
                @break

                @case('dog_updated')
                    toastr["success"]('Pet info successfully updated');
                @break
                @case('dog_fail_update')
                    toastr["warning"]('Updating dog info failed!');
                @break
                @case('pet_not_found')
                    toastr["warning"]('Pet not found');
                @break

                @case('pet_image_upload_success')
                    toastr["success"]('Pet image successfully updated');
                @break
                @case('pet_image_upload_error')
                    toastr["warning"]('Updating pet image failed!');
                @break

                @default
            @endswitch
        @endif
    });
</script>

</html>
