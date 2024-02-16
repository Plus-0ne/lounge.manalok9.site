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
                                    Services enrollments
                                </h5>
                                <hr>
                            </div>
                            <div class="col-12 d-flex pb-3">
                                <div class="me-2">
                                    <a class="btn btn-secondary btn-sm" href="{{ route('admin.services') }}">
                                        <span class="mdi mdi-arrow-left"></span> Return to services
                                    </a>

                                </div>
                                <div class="ms-auto">
                                    {{-- <button id="addNewServices" class="btn btn-secondary btn-sm">
                                        <i class="mdi mdi-account-plus"></i> Add services
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
                                <table id="serviceEnrollments" class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Status</th>
                                            <th scope="col">Pet Name</th>
                                            <th scope="col">Owner</th>
                                            <th scope="col">Mobile #</th>
                                            <th scope="col">Email Address</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['serviceEnrollments'] as $row)
                                        <tr>
                                            <td>
                                                @switch($row->status)
                                                    @case(1)
                                                        <span class="badge rounded-pill bg-primary">Enrolling</span>
                                                        @break

                                                    @default
                                                    <span class="badge rounded-pill bg-primary">Unknown</span>
                                                @endswitch
                                            </td>
                                            <td>
                                                {{ Str::ucfirst($row->petName) }}
                                            </td>
                                            <td>
                                                {{ Str::ucfirst($row->petOwner) }}
                                            </td>
                                            <td>
                                                {{ $row->mobileNumber }}
                                            </td>
                                            <td>
                                                {{ $row->emailAddress }}
                                            </td>
                                            <td>
                                                <div class="dropdown open">
                                                    <button class="btn btn-secondary dropdown-toggle btn-sm" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                            <span class="mdi mdi-cog-outline"></span> Action
                                                            </button>
                                                    <div class="dropdown-menu" aria-labelledby="triggerId">
                                                        <button class="dropdown-item" href="#">
                                                            <span class="mdi mdi-eye"></span> View
                                                        </button>
                                                        <button class="dropdown-item" href="#">
                                                            <span class="mdi mdi-cancel"></span> Reject
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

    {{-- SCRIPTS --}}
    @include('pages/admins/section/admin-scripts')

    {{-- Custom script --}}
    <script src="{{ asset('js/admins_js/admin-services.js') }}"></script>
</body>

</html>
