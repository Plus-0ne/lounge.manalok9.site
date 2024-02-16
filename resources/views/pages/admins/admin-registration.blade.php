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
                        <div class="p-4 dashboard-section d-flex flex-wrap">
                            <div class="breadcrumb-text col-12 my-3 text-sm-center text-lg-start">
                                <h5>
                                    IAGD Members
                                </h5>
                                <hr>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 p-3 d-flex">
                                <div class="me-2">
                                    <button class="btn btn-primary">
                                        <i class="mdi mdi-file-import"></i> Import
                                    </button>

                                </div>
                                <div class="me-2">
                                    <button class="btn btn-primary">
                                        <i class="mdi mdi-file-export"></i> Export
                                    </button>
                                </div>
                                <div class="ms-auto">
                                    <button class="btn btn-secondary">
                                        <i class="mdi mdi-account-plus"></i> Add Member
                                    </button>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 p-3">
                                <div class="table-responsive p-2">
                                    <table id="registration_table" class="table table-striped w-100">
                                        <thead>
                                            <tr>
                                                <th width="75px">Status</th>
                                                <th width="100px">Registry</th>
                                                <th>Name</th>
                                                <th>Email Address</th>
                                                <th>Contact #</th>
                                                <th width="100px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data['mem_data'] as $row)
                                                <tr>
                                                    <td>
                                                        @if ($row['membership_status'] == 'new')
                                                            <span
                                                                class="badge rounded-pill bg-success">{{ strtoupper($row['membership_status']) }}</span>
                                                        @else
                                                            <span class="badge rounded-pill bg-error">N/A</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{-- SWITCH CASE FOR REGISTRY --}}
                                                        @switch($row['from_registry'])
                                                            @case(1)
                                                                <span class="badge rounded-pill bg-success">
                                                                    ICGD
                                                                </span>
                                                            @break

                                                            @case(2)
                                                                <span class="badge rounded-pill bg-success">
                                                                    IBGD
                                                                </span>
                                                            @break

                                                            @case(3)
                                                                <span class="badge rounded-pill bg-success">
                                                                    IFGD
                                                                </span>
                                                            @break

                                                            @case(4)
                                                                <span class="badge rounded-pill bg-success">
                                                                    IRGD
                                                                </span>
                                                            @break

                                                            @default
                                                                <span class="badge rounded-pill bg-success">
                                                                    N/A
                                                                </span>
                                                        @endswitch
                                                    </td>
                                                    <td>
                                                        {{ $row['name'] }}
                                                    </td>
                                                    <td>
                                                        {{ $row['email_address'] }}
                                                    </td>
                                                    <td>
                                                        {{ $row['contact_number'] }}
                                                    </td>
                                                    <td>
                                                        <div class="dropdown">
                                                            <a class="btn btn-primary btn-sm dropdown-toggle"
                                                                href="#" role="button" id="registration_action"
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                                <i class="mdi mdi-account-cog-outline"></i> Option
                                                            </a>

                                                            <ul class="dropdown-menu"
                                                                aria-labelledby="registration_action">
                                                                <li>
                                                                    <a class="dropdown-item" href="#">
                                                                        <i class="mdi mdi-account-details"></i> Details
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item"
                                                                        href="{{ route('admin.sendmail_verification') }}?id={{ $row['id'] }}">
                                                                        <i class="mdi mdi-account-check"></i> Approve
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="dropdown-item" href="#">
                                                                        <i class="mdi mdi-account-cancel"></i> Reject
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
    </div>

    {{-- SCRIPTS --}}
    @include('pages/admins/section/admin-scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            $('#registration_table').DataTable({});
            $('.table-responsive').on('show.bs.dropdown', function() {
                $('.table-responsive').css("overflow", "inherit");
            });
        });
    </script>
</body>


</html>
