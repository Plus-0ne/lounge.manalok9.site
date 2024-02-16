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
                                <h5>
                                    Insurance
                                </h5>
                                <small class="text-muted">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam repudiandae quis voluptates fugiat quod quas eum, exercitationem, soluta deleniti, veritatis maiores nostrum? Hic quos iure nulla nostrum dolor, amet id.
                                </small>
                                <hr>
                            </div>
                            <div class="col-12 d-flex pb-1">
                                {{-- <div class="me-2">
                                    <a class="btn btn-success btn-sm" href="{{ route('admin.serviceEnrollments') }}">
                                        <i class="mdi mdi-file-import"></i> Services Enrollments
                                    </a>

                                </div> --}}
                                <div class="ms-auto">
                                    <a class="btn btn-primary btn-sm" href="{{ route('admin.insuranceFormCreate') }}?step=1">
                                        <i class="mdi mdi-account-plus"></i> Add new insurance plan
                                    </a>
                                    {{-- <button id="addNewInsurance" class="btn btn-primary btn-sm">
                                        <i class="mdi mdi-account-plus"></i> Add insurance
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
                                <hr>
                                <div class="table-responsive">
                                    <table id="insuranceTable" class="table table-striped table-condensed">
                                        <thead>
                                            <tr>
                                                <th scope="col">Image</th>
                                                <th scope="col">Title</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Discounted</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- Todos : Update table information , add delete , update --}}
                                            @foreach ($data['insurance'] as $row)
                                                <tr>
                                                    <td width="150px" class="align-middle">
                                                        <div class="ins-tbl-img">
                                                            <img src="{{ asset($row->image_path) }}" alt=""
                                                                srcset="">
                                                        </div>
                                                    </td>
                                                    <td class="align-middle">
                                                        {{ Str::ucfirst($row->title) }}
                                                    </td>
                                                    <td class="align-middle">
                                                        ₱ {{ number_format($row->price) }}
                                                    </td>
                                                    <td width="120px" class="align-middle">
                                                        @if ($row->available_discount == 0)
                                                            <span class="badge rounded-pill bg-primary">
                                                                No
                                                            </span>
                                                        @else
                                                            <span class="badge rounded-pill bg-success">
                                                                Yes
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td width="120px" class="align-middle">
                                                        @if ($row->status == 0)
                                                            <span class="badge rounded-pill bg-danger">
                                                                Unavailable
                                                            </span>
                                                        @else
                                                            <span class="badge rounded-pill bg-success">
                                                                Available
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td width="100px" class="text-center align-middle">
                                                        <div class="dropdown open">
                                                            <button class="btn btn-secondary dropdown-toggle btn-sm"
                                                                type="button" id="triggerId" data-bs-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false">
                                                                <span class="mdi mdi-cog"></span> Option
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="triggerId">
                                                                <button class="dropdown-item btn-sm wipPrompt">
                                                                    <span class="mdi mdi-information text-primary"></span>Details
                                                                </button>
                                                                <button class="dropdown-item btn-sm wipPrompt">
                                                                    <span class="mdi mdi-update text-info"></span>Update
                                                                </button>
                                                                <button class="dropdown-item btn-sm deleteInsuranceOption" data-uuid="{{ $row->uuid }}">
                                                                    <span class="mdi mdi-delete text-danger"></span>Delete
                                                                </button>
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

    {{-- SCRIPTS --}}
    @include('pages/admins/section/admin-scripts')

    {{-- Custom script --}}
    <script src="{{ asset('js/admins_js/admin-insurance.js') }}"></script>
</body>

</html>
