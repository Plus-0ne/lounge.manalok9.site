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
                                    Admin accounts ( Under construction )
                                </h5>
                                <hr>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 p-3 d-flex justify-content-between">
                                <div class="d-flex flex-row">

                                </div>
                                <div>
                                    <div class="ms-auto">
                                        <a class="btn btn-secondary btn-sm" href="{{ route('admin.admin_account_form') }}">
                                            <i class="mdi mdi-account-plus"></i> Add Account
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 p-3">
                                <div class="table-responsive p-2">
                                    <table id="accounts_table" class="table table-striped w-100">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Email address</th>
                                                <th>Department</th>
                                                <th>Position</th>
                                                <th>Roles</th>
                                                <th>Start date</th>
                                                <th style="width: 100px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- {{ dd($data['adminAccounts']) }} --}}
                                            @foreach ($data['adminAccounts'] as $row)
                                            <tr>
                                                <td>
                                                    {{ $row->userAccount->first_name }} {{ $row->userAccount->last_name }}
                                                </td>
                                                <td>
                                                    {{ $row->email_address }}
                                                </td>
                                                <td>
                                                    {{ $row->department }}
                                                </td>
                                                <td>
                                                    {{ $row->position }}
                                                </td>
                                                <td>
                                                    {{ $row->roles }}
                                                </td>
                                                <td>
                                                    {{ $row->created_at }}
                                                </td>
                                                <td>
                                                    <button id="rowActionbtn" type="button" class="btn btn-danger btn-sm" data-id="{{ $row->id }}">
                                                        <span class="mdi mdi-delete"></span> Delete
                                                    </button>
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
    <script src="{{ asset('js/admins_js/admin-accounts.js') }}"></script>
</body>

</html>
