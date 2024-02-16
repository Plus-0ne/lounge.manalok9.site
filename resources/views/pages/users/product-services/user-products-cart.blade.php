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
                                        <span class="mdi mdi-cart"></span> Cart
                                    </h4>
                                </div>
                                <hr>
                                <div class="row">

                                    <div class="d-flex flex-row justify-content-between">
                                        <a href="{{ route('user.products.list') }}" class="btn btn-secondary btn-sm">
                                            <span class="mdi mdi-arrow-left"></span> Products
                                        </a>
                                        <button type="button" class="btn btn-success btn-sm">
                                            <span class="mdi mdi-cart-check"></span> Checkout
                                        </button>
                                    </div>
                                </div>
                                <hr>
                                <style>
                                    .product-cart-check {
                                        font-size: 1.3rem;
                                        color: darkgray;
                                        cursor: pointer;
                                    }

                                    .product-cart-check.checked {
                                        color: green;
                                    }
                                </style>
                                {{-- Display product and services --}}
                                <div class="d-flex flex-wrap">
                                    <div class="col-12 col-xl-6 mb-3">
                                        @foreach ($data['productCart'] as $row)
                                            <div class="card d-flex flex-row align-items-center px-1 py-2 px-xl-3 py-xl-3 mb-3">
                                                <div class="px-2 py-2">
                                                    <span
                                                        class="mdi mdi-check-circle product-cart-check checked"></span>
                                                </div>
                                                <div>
                                                    <div style="width: 60px;">
                                                        <img class="img-fluid"
                                                            src="{{ asset($row->productDetails->image) }}"
                                                            alt="">
                                                    </div>
                                                </div>
                                                <div class="px-2 py-2 col">
                                                    {{ $row->productDetails->name }}
                                                </div>
                                                <div class="px-2 py-2">
                                                    <span class="mdi mdi-delete"></span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="col-12 col-xl-6 px-0 px-xl-3">
                                        <div class="d-flex flex-column">
                                            <div class="px-2 py-2">
                                                <p> <strong class="text-danger">Note</strong> : Before you proceed,
                                                    please verify your information:</p>
                                                <ul>
                                                    <li>
                                                        <div>
                                                            Address :
                                                            <strong>{{ empty(Auth::guard('web')->user()->address) ? 'No address' : Auth::guard('web')->user()->address }}</strong>
                                                        </div>

                                                    </li>
                                                    <li>
                                                        <div>
                                                            Contact # :
                                                            <strong>{{ empty(Auth::guard('web')->user()->contact_number) ? 'No contact number' : Auth::guard('web')->user()->contact_number }}</strong>
                                                        </div>
                                                    </li>
                                                    <li>
                                                        <div>
                                                            Email address :
                                                            <strong>{{ empty(Auth::guard('web')->user()->email_address) ? 'No email address' : Auth::guard('web')->user()->email_address }}</strong>
                                                        </div>
                                                    </li>
                                                </ul>
                                                <p>Click the link to update your information : <a
                                                        href="{{ route('user.user_profile') }}" target="_BLANK">
                                                        Verify Information
                                                    </a></p>


                                                <p>Please download our QR code for payment.</p>
                                                <a class="btn col-12" download
                                                    href="{{ asset('img/381196062_293129843446466_2590890577616570992_n.png') }}">
                                                    <img class="img-fluid"
                                                        src="{{ asset('img/381196062_293129843446466_2590890577616570992_n.png') }}"
                                                        alt="">
                                                </a>
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

    {{-- Include custom user toast --}}
    @include('pages/users/template/section/user-toasts')

    {{-- SCRIPTS --}}
    @include('pages/users/template/section/scripts')
    @include('pages/users/template/section/scripts-var')
    <script src="{{ asset('js/user-products/user-products-cart.js') }}"></script>

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
