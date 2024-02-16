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
                                        Insurance plans
                                    </h4>
                                    <small class="text-muted">
                                        Your Whole Pet Family Deserves the Best Care.
                                    </small>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="d-flex flex-row justify-content-end">
                                        <button id="showInsurancePlanAvailed" type="button"
                                            class="btn btn-info btn-sm">
                                            <span class="mdi mdi-view-carousel"></span> View insurance plans
                                        </button>
                                    </div>
                                </div>
                                <hr>
                                {{-- Product list --}}
                                {{-- <div class="row">

                                    <div class="col-12 col-xxl-4">
                                        <div class="mb-3">
                                            <label for="pet_name_search" class="form-label">
                                                Search
                                            </label>
                                            <input id="pet_name_search" type="text"
                                                class="form-control form-control-sm" placeholder="Search insurance"
                                                list="productList">
                                        </div>
                                    </div>

                                </div> --}}
                                {{-- Display product and services --}}
                                <div id="product_container"
                                    class="d-flex flex-wrap justify-content-center justify-content-xl-start">
                                    {{-- {{ dd($data['insurance']) }} --}}
                                    @foreach ($data['insurance'] as $row)
                                        <div class="col-12 col-md mb-3">
                                            <div class="card h-100 responsive-card">
                                                <img src="{{ asset($row->image_path) }}" class="card-img-top"
                                                    alt="{{ $row->title }}">
                                                {{-- <div class="card-body text-center">
                                                    <div class="lead">
                                                        {{ $row->title }}
                                                    </div>
                                                    <div class="card-text">
                                                        ₱ {{ number_format($row->price) }}

                                                    </div>
                                                    <div class="card-text">
                                                        @switch($row->status)
                                                            @case(0)
                                                                <span class="badge rounded-pill bg-danger">Not available</span>
                                                            @break

                                                            @default
                                                                <span class="badge rounded-pill bg-success">Available</span>
                                                        @endswitch
                                                    </div>
                                                </div> --}}
                                                <div class="card-footer bg-light">
                                                    <div class="text-center">
                                                        <button class="btn btn-primary btn-sm viewInsuranceDetails"
                                                            data-insurance_uuid="{{ $row->uuid }}">
                                                            <div class="d-flex flex-row">
                                                                <div class="icon-mdi me-2">
                                                                    <span class="mdi mdi-card-multiple"></span>
                                                                </div>
                                                                <div>
                                                                    Show details
                                                                </div>
                                                            </div>
                                                        </button>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
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
    @include('pages.users.product-services.modal-insurance-availed')

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
