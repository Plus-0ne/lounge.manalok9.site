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
                                        Products
                                    </h4>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="d-flex flex-row justify-content-end">
                                        <button id="showMyCartModalButton" type="button" class="btn btn-success btn-sm">
                                            <span class="mdi mdi-cart-outline"></span> My cart
                                        </button>
                                    </div>
                                </div>
                                <hr>
                                {{-- Product list --}}
                                <div class="row">

                                    <div class="col-12 col-xxl-4">
                                        <div class="mb-3">
                                            <label for="pet_name_search" class="form-label">
                                                Search
                                            </label>
                                            <input id="pet_name_search" type="text"
                                                class="form-control form-control-sm" placeholder="Search product"
                                                list="productList">
                                        </div>
                                    </div>

                                </div>

                                {{-- Display product and services --}}
                                <div id="product_container" class="d-flex flex-wrap justify-content-center justify-content-xl-between">
                                    @foreach ($data['products'] as $row)
                                    <div class="card" style="width: 19rem;">
                                        <img src="{{ asset($row->image) }}" class="card-img-top" alt="{{ $row->name }}">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $row->name }}</h5>
                                            <p class="card-text">
                                                <ul>
                                                    <li>
                                                        Price : {{ $row->price }} php
                                                    </li>
                                                    <li>
                                                        Stock : {{ $row->stock }}
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
                                                <button class="btn btn-primary btn-sm addToCartButton" data-uuid="{{ $row->uuid }}" data-maxItems={{ $row->stock }}>
                                                    <span class="mdi mdi-cart-plus"></span> Add to cart
                                                </button>
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
    @include('pages.users.product-services.datalist-product')
    @include('pages.users.product-services.modal-add-to-cart')
    @include('pages.users.product-services.modal-product-cart')

    {{-- Include custom user toast --}}
    @include('pages/users/template/section/user-toasts')

    {{-- SCRIPTS --}}
    @include('pages/users/template/section/scripts')
    @include('pages/users/template/section/scripts-var')

    <script src="{{ asset('js/user-products/user-products.js') }}"></script>
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
