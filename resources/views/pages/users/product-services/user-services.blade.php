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
                                        Services ( <small><small>Under development</small></small> )
                                    </h4>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="d-flex flex-row justify-content-end">
                                        <button id="serviceCartBtn" class="btn btn-success btn-sm">
                                            <span class="mdi mdi-cart"></span> Cart
                                        </button>
                                    </div>
                                </div>
                                <hr>
                                {{-- Services list --}}
                                <div class="row">

                                    <div class="col-12 col-xxl-4">
                                        <div class="mb-3">
                                            <label for="pet_name_search" class="form-label">
                                                Search
                                            </label>
                                            <input id="pet_name_search" type="text"
                                                class="form-control form-control-sm" placeholder="Search Services"
                                                list="servicesList">
                                        </div>
                                    </div>

                                </div>

                                {{-- Display product and services --}}
                                <div id="services_container" class="d-flex flex-wrap justify-content-center justify-content-xl-between">
                                    @foreach ($data['services'] as $row)
                                    <div class="card py-3" style="width: 19rem;">
                                        <img src="{{ asset($row->image) }}" class="card-img-top" alt="{{ $row->name }}">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $row->name }}</h5>
                                            <p class="card-text">
                                                <ul>
                                                    <li>
                                                        Price : {{ $row->price }} php
                                                    </li>
                                                    <li>
                                                        Status : @switch($row->status)
                                                            @case(0)
                                                                <span class="badge rounded-pill bg-danger">Not available</span>
                                                                @break

                                                            @default
                                                                <span class="badge rounded-pill bg-success">Available</span>
                                                        @endswitch
                                                    </li>
                                                </ul>
                                            </p>
                                            <hr>
                                            <div class="text-center">
                                                @if ($row->serviceOrdered()->where([
                                                    ['user_uuid','=',Auth::guard('web')->user()->uuid],
                                                    ['service_uuid','=',$row->uuid],
                                                    ['status','=',1]
                                                ])->count() > 0)
                                                <button class="btn btn-secondary btn-sm" disabled>
                                                    <span class="mdi mdi-cart-plus"></span> Added
                                                </button>
                                                @else
                                                <button class="btn btn-primary btn-sm addServiceToCart" data-uuid="{{ $row->uuid }}">
                                                    <span class="mdi mdi-cart-plus"></span> Add to cart
                                                </button>
                                                @endif

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

    {{-- Datalist product & services --}}
    @include('pages.users.product-services.datalist-services')

    {{-- Modal --}}
    @include('pages.users.product-services.modal-services-cart')

    {{-- Include custom user toast --}}
    @include('pages/users/template/section/user-toasts')

    {{-- SCRIPTS --}}
    @include('pages/users/template/section/scripts')
    @include('pages/users/template/section/scripts-var')

    <script src="{{ asset('js/user-services/user-services.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            @if (Session::has('status'))
                @switch(Session::get('status'))
                    @case('error')
                    let message = "{{ Session::get('message') }}";

                    toastr["error"](message);
                    @break

                    @case('success')
                    let message = "{{ Session::get('message') }}";
                    toastr["success"](message);
                    @break

                    @default
                @endswitch
            @endif
        });
    </script>

</body>

</html>
