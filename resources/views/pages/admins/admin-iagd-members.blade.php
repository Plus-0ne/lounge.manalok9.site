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
                            <div class="breadcrumb-text col-12 mt-3 text-sm-center text-lg-start">
                                <h3>
                                    IAGD Members
                                </h3>
                                <small class="text-muted">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam repudiandae quis voluptates fugiat quod quas eum, exercitationem, soluta deleniti, veritatis maiores nostrum? Hic quos iure nulla nostrum dolor, amet id.
                                </small>
                                <hr>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 pt-1 d-flex">
                                <div class="me-2">
                                    <button class="btn btn-primary btn-sm">
                                        <i class="mdi mdi-file-import"></i> Import
                                    </button>

                                </div>
                                <div class="me-2">
                                    <button class="btn btn-primary btn-sm">
                                        <i class="mdi mdi-file-export"></i> Export
                                    </button>
                                </div>
                                <div class="ms-auto">
                                    <button class="btn btn-secondary btn-sm">
                                        <i class="mdi mdi-account-plus"></i> Add Member
                                    </button>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 p-3">
                                <div class="table-responsive p-2">
                                    <table id="iagd_table" class="table table-striped w-100">
                                        <thead>
                                            <tr>
                                                <th>Status</th>
                                                <th>IAGD #</th>
                                                <th>Name</th>
                                                <th>Contact #</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!empty($data['iagd_members']))
                                                @foreach ($data['iagd_members'] as $row)
                                                    <tr>
                                                        <td class="text-center">
                                                            @if (!empty($row->status))
                                                                @switch($row->status)
                                                                    @case('IBGD MEMBER')
                                                                        <span class="badge rounded-pill bg-info">IBGD
                                                                            MEMBER</span>
                                                                    @break

                                                                    @case('ICGD MEMBER')
                                                                        <span class="badge rounded-pill bg-success">ICGD
                                                                            MEMBER</span>
                                                                    @break

                                                                    @case('IFGD MEMBER')
                                                                        <span class="badge rounded-pill bg-warning">IFGD
                                                                            MEMBER</span>
                                                                    @break

                                                                    @case('IRGD MEMBER')
                                                                        <span class="badge rounded-pill bg-secondary">IRGD
                                                                            MEMBER</span>
                                                                    @break

                                                                    @case('PREMIUM MEMBER')
                                                                        <span class="badge rounded-pill bg-primary">PREMIUM
                                                                            MEMBER</span>
                                                                    @break

                                                                    @default
                                                                        Default case...
                                                                @endswitch
                                                            @endif
                                                        </td>
                                                        <td>
                                                            {{ $row->iagd_number }}
                                                        </td>
                                                        <td>
                                                            {{ $row->name }}
                                                        </td>
                                                        <td>
                                                            {{ $row->contact_number }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
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
            $('#iagd_table').DataTable({});
        });
    </script>
</body>


</html>
