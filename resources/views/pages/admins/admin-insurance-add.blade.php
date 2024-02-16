{{-- HEADER CONTAINS CSS LINKS --}}
@include('pages/admins/section/admin-header')
</head>

<body>
    <div class="wrapper">

        {{-- TOP NAVIGATION --}}
        @include('pages/admins/section/admin-header_nav')

        <div class="main">

            {{-- SIDABAR --}}
            @include('pages/admins/section/admin-sidebar')

            <div class="main-content h-100">
                <div class="container-fluid">
                    <div class="row">
                        <div class="p-3 p-lg-4 dashboard-section d-flex flex-wrap">
                            <div class="breadcrumb-text col-12 mt-3 pb-1 text-sm-center text-lg-start">
                                <h3>
                                    Create new insurance
                                </h3>
                                <small class="text-muted">
                                    Please ensure that you fill out all the required inputs with accurate information to
                                    complete the form successfully.
                                </small>
                                <hr>
                            </div>
                            <div class="col-12 d-flex pb-1">
                                <div class="me-2">
                                    <a class="btn btn-secondary btn-sm" href="{{ route('admin.insuranceView') }}">
                                        <i class="mdi mdi-arrow-left"></i> Return
                                    </a>

                                </div>
                                {{-- <div class="ms-auto">

                                </div> --}}

                            </div>
                            <div class="col-12">
                                @if ($errors->any())
                                    <div class="alert alert-danger d-flex align-items-center justify-content-between"
                                        role="alert">
                                        <div>
                                            <span class="mdi mdi-alert me-1" style="font-size: 1.4rem;"></span>
                                            {{ $errors->first() }}
                                        </div>
                                        <div>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    </div>
                                @endif
                                @if (Session::has('status'))
                                    @switch(Session::get('status'))
                                        @case('success')
                                            <div class="alert alert-success d-flex align-items-center justify-content-between"
                                                role="alert">
                                                <div>
                                                    <span class="mdi mdi-check-circle me-1" style="font-size: 1.4rem;"></span>
                                                    {{ Session::get('message') }}
                                                </div>
                                                <div>
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                        aria-label="Close"></button>
                                                </div>
                                            </div>
                                        @break

                                        @default
                                            <div class="alert alert-danger d-flex align-items-center justify-content-between"
                                                role="alert">
                                                <div>
                                                    <span class="mdi mdi-alert me-1" style="font-size: 1.4rem;"></span>
                                                    {{ Session::get('message') }}
                                                </div>
                                                <div>
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                        aria-label="Close"></button>
                                                </div>
                                            </div>
                                    @endswitch
                                @endif
                            </div>
                            {{-- page content --}}

                            <div class="page-content col-12">
                                <hr>
                                {{-- Section 1 --}}
                                <div class="row">
                                    <div class="lead">
                                        Details
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex flex-row justify-content-center">
                                            <div class="form-wiz-img">
                                                <img id="insuranceImage" src="{{ asset('img/no-preview.jpeg') }}"
                                                    alt="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3">
                                        <div class="mb-3">
                                            <label for="" class="form-label">Choose image</label>
                                            <input id="imageFile" type="file" class="form-control form-control-sm"
                                                accept=".jpg,.png,.jpeg">
                                            <div id="fileHelpId" class="form-text">
                                                Select insurance image
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3">
                                        <div class="mb-3">
                                            <label for="title" class="form-label">
                                                Title
                                            </label>
                                            <input id="title" type="text" class="form-control form-control-sm"
                                                autocomplete="off">
                                            <small id="helpId" class="form-text text-muted">
                                                Enter insurance title
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3">
                                        <div class="mb-3">
                                            <label for="price" class="form-label">
                                                Price
                                            </label>
                                            <input id="price" type="text" class="form-control form-control-sm numberOnlyInput"
                                                pattern="[0-9.]*" autocomplete="off">
                                            <small id="helpId" class="form-text text-muted">
                                                Enter insurance amount
                                            </small>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-3">
                                        <div class="mb-3">
                                            <label for="" class="form-label">
                                                Coverage period
                                            </label>
                                            <div class="d-flex flex-row">
                                                <div class="col-4">
                                                    <select id="coverageType"
                                                        class="form-select form-select-sm form-input-group-left">
                                                        <option value="days" selected>
                                                            Days
                                                        </option>
                                                        <option value="weeks">
                                                            Weeks
                                                        </option>
                                                        <option value="months">
                                                            Months
                                                        </option>
                                                        <option value="years">
                                                            Years
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="col-8">
                                                    <input id="coveragePeriod" type="text"
                                                        class="form-control form-control-sm numberOnlyInput form-input-group-right"
                                                        aria-describedby="coveragePeriodHelp"
                                                        placeholder="Enter number of months" autocomplete="off">
                                                </div>
                                            </div>
                                            <small id="helpId" class="form-text text-muted">
                                                Select and enter the number
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-6">
                                        <div class="mb-3">
                                            <label for="description" class="form-label">
                                                Description
                                            </label>
                                            <textarea id="description" class="form-control form-control-sm"rows="3"></textarea>
                                            <small id="helpId" class="form-text text-muted">
                                                Enter insurance description ( <strong class="text-danger">Not
                                                    required</strong> )
                                            </small>
                                        </div>
                                    </div>

                                    <div class="col-12 col-lg-6">
                                        <div class="mb-3">
                                            <label for="notes" class="form-label">
                                                Notes
                                            </label>
                                            <textarea id="notes" class="form-control form-control-sm"rows="3"></textarea>
                                            <small id="helpId" class="form-text text-muted">
                                                Enter insurance notes ( <strong class="text-danger">Not
                                                    required</strong> )
                                            </small>
                                        </div>
                                    </div>

                                </div>

                                {{-- Section 2 --}}
                                <div class="row mb-3">
                                    <div class="lead mb-3">
                                        Furbabies benefits
                                    </div>
                                    <div id="furbabiesBenefitsSection">
                                        <div class="w-100 d-flex justify-content-center p-1 p-lg-3">
                                            <small>
                                                No babies benefits added
                                            </small>
                                        </div>
                                        <div
                                            class="d-flex flex-column flex-lg-row align-items-center p-1 p-lg-3 form-wiz-cart-items">
                                            <div class="d-flex flex-column">
                                                <div>
                                                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nesciunt,
                                                    magni? Non maiores pariatur optio neque! Asperiores deserunt, quo
                                                    tempore atque hic optio earum, nostrum delectus recusandae vero,
                                                    culpa natus quisquam?
                                                </div>
                                                <div>
                                                    9999999
                                                </div>
                                            </div>
                                            <div class="bene-action-icon delete">
                                                <span class="mdi mdi-delete"></span>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="mt-3">
                                        <button class="btn btn-primary btn-sm">
                                            <span class="mdi mdi-plus"></span> Add babies benefits
                                        </button>
                                    </div>
                                </div>

                                {{-- Section 3 --}}
                                <div class="row mb-3">
                                    <div class="lead mb-3">
                                        Furparents benefits
                                    </div>
                                    <div id="furParentsBenefitSection">
                                        <div class="w-100 d-flex justify-content-center p-1 p-lg-3">
                                            <small>
                                                No babies benefits added
                                            </small>
                                        </div>
                                        <div
                                            class="d-flex flex-column flex-lg-row align-items-center p-1 p-lg-3 form-wiz-cart-items">
                                            <div class="d-flex flex-column">
                                                <div>
                                                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nesciunt,
                                                    magni? Non maiores pariatur optio neque! Asperiores deserunt, quo
                                                    tempore atque hic optio earum, nostrum delectus recusandae vero,
                                                    culpa natus quisquam?
                                                </div>
                                                <div>
                                                    9999999
                                                </div>
                                            </div>
                                            <div class="bene-action-icon delete">
                                                <span class="mdi mdi-delete"></span>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="mt-3">
                                        <button class="btn btn-primary btn-sm">
                                            <span class="mdi mdi-plus"></span> Add parent benefits
                                        </button>
                                    </div>

                                </div>

                                {{-- Section 4 --}}
                                <div class="row mb-3">
                                    <div class="lead mb-3">
                                        Requirements
                                    </div>
                                    <div id="insuranceRequirementsSection">
                                        <div class="w-100 d-flex justify-content-center p-1 p-lg-3">
                                            <small>
                                                No babies benefits added
                                            </small>
                                        </div>
                                        <div
                                            class="d-flex flex-column flex-lg-row align-items-center p-1 p-lg-3 form-wiz-cart-items">
                                            <div class="d-flex flex-column">
                                                <div>
                                                    Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nesciunt,
                                                    magni? Non maiores pariatur optio neque! Asperiores deserunt, quo
                                                    tempore atque hic optio earum, nostrum delectus recusandae vero,
                                                    culpa natus quisquam?
                                                </div>
                                                <div>
                                                    9999999
                                                </div>
                                            </div>
                                            <div class="bene-action-icon delete">
                                                <span class="mdi mdi-delete"></span>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="mt-3">
                                        <button class="btn btn-primary btn-sm">
                                            <span class="mdi mdi-plus"></span> Add requirements
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- Form control --}}
                            <div class="col-12">
                                <hr>
                                <div class="d-flex flex-column">
                                    <div class="mb-3">
                                        <button id="submitNewInsurance" class="btn btn-success btn-sm">
                                            <span class="mdi mdi-plus"></span> Save insurance
                                        </button>
                                    </div>
                                    <div id="formPrompts">
                                        {{-- Form response status and message --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Modals --}}

    {{-- SCRIPTS --}}
    @include('pages/admins/section/admin-scripts')

    {{-- Custom script --}}
    <script src="{{ asset('js/admins_js/admin-insurance.js') }}"></script>
</body>

</html>
