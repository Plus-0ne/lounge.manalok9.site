{{-- HEADER CONTAINS CSS LINKS --}}
@include('pages/admins/section/admin-header')
<link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.bootstrap5.css">


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
                    <div class="row p-1 p-lg-4 dashboard-section">
                        <div class="d-flex flex-wrap">
                            <div class="breadcrumb-text col-12 mt-3 text-sm-center text-lg-start">
                                <h3>
                                    Dealers
                                </h3>
                                <small class="text-muted">
                                    List of users applied to be a dealer
                                </small>
                                <hr>
                            </div>


                        </div>
                        <div class="col-12 col-sm-12 col-md-12 p-3 d-flex flex-column justify-content-start">
                            <div class="table-responsive">
                                <table id="dealersTable" class="table table-striped table-condensed">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email address</th>
                                            <th>Contact #</th>
                                            <th>Tel. #</th>
                                            <th>Store location</th>
                                            <th>Status</th>
                                            <th>Option</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data['dealersApplicant'] as $row)
                                        <tr>
                                            <td>{{ $row->last_name }} {{ $row->first_name }} {{ $row->middle_name }} </td>
                                            <td>{{ $row->email_address }} </td>
                                            <td>{{ $row->contact_number }} </td>
                                            <td>{{ $row->tel_number }} </td>
                                            <td>{{ $row->store_location }} </td>
                                            <td>
                                                @switch($row->status)
                                                    @case(1)
                                                        <span class="badge rounded-pill text-bg-primary">
                                                            PENDING
                                                        </span>

                                                        @break
                                                    @case(2)
                                                        <span class="badge rounded-pill text-bg-success">
                                                            APPROVED
                                                        </span>

                                                        @break
                                                    @default
                                                        <span class="badge rounded-pill text-bg-danger">
                                                            REJECTED
                                                        </span>

                                                @endswitch
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-success btn-sm btnShowDealerDetails" data-uuid="{{ $row->uuid }}">
                                                        <i class="bi bi-eye"></i> View
                                                    </button>
                                                    <button type="button" class="btn btn-success btn-sm dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        <span class="visually-hidden">Toggle Dropdown</span>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li class="approvedBtn" data-uuid="{{ $row->uuid }}">
                                                            <a class="dropdown-item" href="javascript:void(0);">
                                                                <i class="bi bi-check me-1"></i> Approve
                                                            </a>
                                                        </li>
                                                        <li class="rejectBtn" data-uuid="{{ $row->uuid }}">
                                                            <a class="dropdown-item" href="javascript:void(0);">
                                                                <i class="bi bi-ban me-1"></i> Reject
                                                            </a>
                                                        </li>
                                                    </ul>
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
    @include('pages.admins.section.modals.dealers.dealers-details')
    {{-- SCRIPTS --}}
    @include('pages/admins/section/admin-scripts')
    <script src="https://cdn.datatables.net/2.1.3/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.3/js/dataTables.bootstrap5.js"></script>
    <script type="module" src="{{ asset('js/admins_js/admin-dealers.js') }}"></script>
</body>



</html>
