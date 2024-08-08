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
                    <div class="row p-3 p-lg-4 dashboard-section ">
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
                                <table id="example" class="table table-striped table-condensed" style="width:100%">
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
                                                        PENDING
                                                        @break
                                                    @case(2)
                                                        APPROVED
                                                        @break
                                                    @default
                                                        REJECTED
                                                @endswitch
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-primary">
                                                        <i class="bi bi-gear"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-bs-toggle="dropdown" aria-expanded="false">
                                                      <span class="visually-hidden">Toggle Dropdown</span>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                      <li><a class="dropdown-item" href="#">Action</a></li>
                                                      <li><a class="dropdown-item" href="#">Another action</a></li>
                                                      <li><a class="dropdown-item" href="#">Something else here</a></li>
                                                      <li><hr class="dropdown-divider"></li>
                                                      <li><a class="dropdown-item" href="#">Separated link</a></li>
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
    {{-- SCRIPTS --}}
    @include('pages/admins/section/admin-scripts')
    <script src="https://cdn.datatables.net/2.1.3/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.1.3/js/dataTables.bootstrap5.js"></script>
    <script>
        $('.table-responsive').on('show.bs.dropdown', function () {
            $('.table-responsive').css( "overflow", "inherit" );
        });

        $('.table-responsive').on('hide.bs.dropdown', function () {
            $('.table-responsive').css( "overflow", "auto" );
        })
        let example = new DataTable('#example',{
            responsive: true,
            columnDefs: [
                {
                    width: '15%',
                    targets: 0
                },
                {
                    width: '15%',
                    targets: 1
                },
                {
                    width: '15%',
                    targets: 2
                },
                {
                    width: '15%',
                    targets: 3
                }
            ],
            language: {
                paginate: {
                    first: '<i class="bi bi-caret-left-fill"></i><i class="bi bi-caret-left-fill" style="margin-left: -10px;"></i>',
                    last: '<i class="bi bi-caret-right-fill"></i><i class="bi bi-caret-right-fill" style="margin-left: -10px;"></i>',
                    next: '<i class="bi bi-caret-right-fill"></i>',
                    previous: '<i class="bi bi-caret-left-fill"></i>'
                }
            }
        });
    </script>
</body>



</html>
