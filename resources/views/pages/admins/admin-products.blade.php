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
                            <div class="breadcrumb-text col-12 mt-3 text-sm-center text-lg-start">
                                <h3>
                                    Products
                                </h3>
                                <small class="text-muted">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam repudiandae quis voluptates fugiat quod quas eum, exercitationem, soluta deleniti, veritatis maiores nostrum? Hic quos iure nulla nostrum dolor, amet id.
                                </small>
                                <hr>
                            </div>
                            <div class="col-12 d-flex pb-1">
                                <div class="me-2">
                                    <a class="btn btn-success btn-sm" href="{{ route('admin.productOrders') }}">
                                        <i class="mdi mdi-file-import"></i> Product orders
                                    </a>

                                </div>
                                <div class="ms-auto">
                                    <button id="addNewProduct" class="btn btn-secondary btn-sm">
                                        <i class="mdi mdi-account-plus"></i> Add product
                                    </button>
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
                                <hr>
                                <table id="products" class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Image</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Stock</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['products'] as $row)
                                            <tr>
                                                <td>
                                                    <div style="width: 75px;">
                                                        <img class="w-100" src="{{ asset($row->image) }}" alt="">
                                                    </div>
                                                </td>
                                                <td>
                                                    {{ $row->name }}
                                                </td>
                                                <td>
                                                    {{ $row->description }}
                                                </td>
                                                <td>
                                                    {{ $row->price }}
                                                </td>
                                                <td>
                                                    {{ $row->stock }}
                                                </td>
                                                <td>
                                                    {{ $row->status }}
                                                </td>
                                                <td>

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
    {{-- Modals --}}
    @include('pages.admins.section.modals.products-page.add-product')
    {{-- SCRIPTS --}}
    @include('pages/admins/section/admin-scripts')

    {{-- Custom script --}}
    <script src="{{ asset('js/admins_js/admin-products.js') }}"></script>
</body>

</html>
