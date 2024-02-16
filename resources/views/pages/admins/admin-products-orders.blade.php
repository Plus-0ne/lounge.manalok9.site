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
                            <div class="breadcrumb-text col-12 my-3 text-sm-center text-lg-start">
                                <h5>
                                    Orders
                                </h5>
                                <hr>
                            </div>
                            <div class="col-12 d-flex pb-3">
                                <div class="me-2">
                                    <a class="btn btn-success btn-sm" href="{{ route('admin.products') }}">
                                        <i class="mdi mdi-file-import"></i> Products
                                    </a>

                                </div>
                                <div class="ms-auto">
                                    {{-- <button id="addNewProduct" class="btn btn-secondary btn-sm">
                                        <i class="mdi mdi-account-plus"></i> Add product
                                    </button> --}}
                                </div>
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
                                <div class="table-responsive">
                                    <table id="products" class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Image</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Items</th>
                                                <th scope="col">Payment</th>
                                                <th scope="col">Contact #</th>
                                                <th scope="col">Email address</th>
                                                <th scope="col">Address</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data['productOrders'] as $row)
                                                <tr>
                                                    <td>
                                                        <div style="width: 75px;">
                                                            <img class="w-100"
                                                                src="{{ asset($row->productDetails->image) }}"
                                                                alt="">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        {{ $row->customerDetails->first_name }},
                                                        {{ $row->customerDetails->last_name }}
                                                    </td>
                                                    <td>
                                                        {{ $row->quantity }}
                                                    </td>
                                                    <td>
                                                        {{ $row->quantity * $row->productDetails->price }} PHP
                                                    </td>
                                                    <td>
                                                        {{ $row->customerDetails->contact_number }}
                                                    </td>
                                                    <td>
                                                        {{ $row->customerDetails->email_address }}
                                                    </td>
                                                    <td>
                                                        {{ $row->customerDetails->address }}
                                                    </td>
                                                    <td>
                                                        {{-- 1 = in cart ; 2 = ordering ; 3 = verified order ; 4 = packing; 5 = delivering ; 6 = received ; 7 = cancelled --}}
                                                        @switch($row->status)
                                                            @case(2)
                                                                <span class="badge rounded-pill bg-success">Ordered</span>
                                                            @break

                                                            @case(3)
                                                                <span class="badge rounded-pill bg-primary">Accepted</span>
                                                            @break

                                                            @case(4)
                                                                <span class="badge rounded-pill bg-secondary">Packed</span>
                                                            @break

                                                            @case(5)
                                                                <span class="badge rounded-pill bg-info">Delivering</span>
                                                            @break

                                                            @case(6)
                                                                <span class="badge rounded-pill bg-warning">Recieved</span>
                                                            @break

                                                            @default
                                                                <span class="badge rounded-pill bg-danger">Cancelled</span>
                                                        @endswitch
                                                    </td>
                                                    <td>
                                                        <div class="dropdown open">
                                                            <button class="btn btn-secondary dropdown-toggle btn-sm" type="button"
                                                                id="productOptions" data-bs-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false">
                                                                <span class="mdi mdi-cog"></span> Option
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="productOptions">
                                                                {{-- Disabled accept button --}}
                                                                @if ($row->status == 2)
                                                                <button class="dropdown-item acceptOrder" data-uuid="{{ $row->uuid }}">
                                                                    <span class="mdi mdi-check-circle text-success"></span> Fulfilled
                                                                </button>
                                                                @else
                                                                <button class="dropdown-item" disabled>
                                                                    <span class="mdi mdi-check-circle text-success"></span> Fulfilled
                                                                </button>
                                                                @endif
                                                                {{-- Disabled cancel button if status not 1 --}}
                                                                @if ($row->status == 2)
                                                                <button class="dropdown-item cancelOrder" data-uuid="{{ $row->uuid }}">
                                                                    <span class="mdi mdi-cancel text-danger"></span> Cancel
                                                                </button>
                                                                @else
                                                                <button class="dropdown-item" disabled>
                                                                    <span class="mdi mdi-cancel text-danger"></span> Cancel
                                                                </button>
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- Modals --}}
    @include('pages.admins.section.modals.products-page.add-product')
    {{-- SCRIPTS --}}
    @include('pages/admins/section/admin-scripts')

    {{-- Custom script --}}
    <script src="{{ asset('js/admins_js/admin-products.js') }}"></script>
</body>

</html>
