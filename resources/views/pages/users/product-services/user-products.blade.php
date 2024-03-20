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
                            {{-- Content here --}}
                            <div class="d-flex flex-column p-0 p-lg-3 w-100">
                                {{-- Product list --}}
                                <div class="row mb-3">
                                    <div class="col-12 col-xxl-4">
                                        <div class="row">
                                            <div class="col-sm-12 col-md-8">
                                                <input id="pet_name_search" type="text"
                                                    class="form-control form-control-sm" placeholder="Search product"
                                                    list="productList">
                                            </div>
                                            <div class="col-sm-12 col-md-4">
                                                <button id="showMyCartModalButton" type="button" class="btn btn-success btn-sm" style="float: right; display: inline-block;">
                                                    <span class="mdi mdi-cart-outline"></span> My Cart
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- Display product and services --}}
                                <div id="product_container" class="d-flex flex-wrap justify-content-center justify-content-xl-between">
                                    @foreach ($data['products'] as $row)
                                    <div class="card" style="width: 20.5rem;">
                                        <div class="d-flex align-items-center" style="width: 310px; height: 310px; overflow: none;">
                                            <img src="{{ asset($row->image) }}" class="card-img-top" alt="Product image" style="object-fit: contain;">
                                        </div>
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $row->name }}</h6>
                                            <p class="card-text">
                                                <ul style="list-style-type: none;">
                                                    <li>
                                                        <b>₱{{ number_format($row->price, 2) }}</b>
                                                    </li>
                                                    <li>
                                                        Stock: {{ $row->stock }}
                                                    </li>
                                                    <li>
                                                        @switch($row->status)
                                                            @case(0)
                                                                <span class="badge rounded-pill bg-danger"><i class="bi bi-exclamation-triangle"></i> Unavailable</span>
                                                                @break
                                                            @default
                                                                <span class="badge rounded-pill bg-success"><i class="bi bi-check2-circle"></i> Available</span>
                                                        @endswitch
                                                    </li>
                                                </ul>
                                            </p>
                                        </div>
                                        <div class="card-footer text-center">
                                            <button class="btn btn-primary btn-sm addToCartButton" data-uuid="{{ $row->uuid }}" data-maxItems={{ $row->stock }}>
                                                <span class="mdi mdi-cart-plus"></span> Add to cart
                                            </button>
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
