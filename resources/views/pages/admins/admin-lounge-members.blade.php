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
                                    Lounge Members
                                </h3>
                                <small class="text-muted">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam repudiandae quis voluptates fugiat quod quas eum, exercitationem, soluta deleniti, veritatis maiores nostrum? Hic quos iure nulla nostrum dolor, amet id.
                                </small>
                                <hr>
                            </div>
                            {{-- <div class="col-12 col-sm-12 col-md-12 p-3 d-flex">
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
							</div> --}}
                            <div class="col-12 col-sm-12 col-md-12 px-3">
                                <form action="{{ route('admin.Lounge_Members') }}" method="get">
                                    <div class="row justify-content-end">
                                        <div class="col-auto">
                                            <div class="input-group mb-3">
                                                <input class="form-control form-control-sm" type="text" name="search"
                                                    placeholder="Search..." value="{{ request('search') }}">
                                                <button class="btn btn-outline-secondary btn-sm" type="submit">
                                                    <i class="mdi mdi-magnify"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <style>
                                table .dropdown-menu {
                                    position: fixed !important;
                                    top: 50% !important;
                                    left: 92% !important;
                                    transform: translate(-92%, -50%) !important;
                                }
                            </style>
                            <div class="col-12 col-sm-12 col-md-12 p-3">
                                <div class="table-responsive row p-2">
                                    <table id="membership_upgrade_table" class="table table-striped w-100">
                                        <thead>
                                            <tr>
                                                <th class="text-center align-middle">Membership</th>
                                                <th class="text-center align-middle">Profile Image</th>
                                                <th class="text-center align-middle">IAGD Number</th>
                                                <th class="text-center align-middle">Email Address</th>

                                                <th class="text-center align-middle">Name</th>
                                                <th class="text-center align-middle">Gender</th>
                                                <th class="text-center align-middle">Birth Date</th>
                                                <th class="text-center align-middle">Contact Number</th>
                                                {{-- <th>Address</th> --}}

                                                <th class="text-center align-middle">Referral #</th>
                                                <th class="text-center align-middle">Option</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!empty($data['lounge_members']) && $data['lounge_members']->count() > 0)
                                                @foreach ($data['lounge_members'] as $row)
                                                    <tr>
                                                        <td class="text-center align-middle">
                                                            @if ($row->is_premium == 1)
                                                                <small>
                                                                    <span
                                                                        class="rounded-pill px-2 py-1 bg-warning text-light"
                                                                        style="white-space: nowrap;">
                                                                        PREMIUM
                                                                    </span>
                                                                </small>
                                                            @else
                                                                <small>
                                                                    <span
                                                                        class="rounded-pill px-2 py-1 bg-secondary text-light"
                                                                        style="white-space: nowrap;">
                                                                        REGULAR
                                                                    </span>
                                                                </small>
                                                            @endif
                                                        </td>
                                                        <td class="text-center align-middle">
                                                            <div class="d-flex justify-content-center">
                                                                <div class="ml-img-container">
                                                                    <img src="@if (!empty($row->profile_image)) {{ asset($row->profile_image) }}
                                                                    @else
                                                                    {{ asset('img/user/user.png') }} @endif"
                                                                        alt="{{ $row->first_name }} {{ $row->middle_name }} {{ $row->last_name }}">
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-center align-middle">
                                                            {{ $row->iagd_number ?? '- - -' }}
                                                        </td>
                                                        <td class="text-center align-middle">
                                                            {{ $row->email_address ?? '- - -' }}
                                                        </td>

                                                        <td class="text-center align-middle">
                                                            {{ $row->first_name }} {{ $row->middle_name }}
                                                            {{ $row->last_name }}
                                                        </td>
                                                        <td class="text-center align-middle">
                                                            {{ $row->gender ? Str::ucfirst($row->gender) : '- - -' }}
                                                        </td>
                                                        <td class="text-center align-middle">
                                                            {{ $row->birth_date ?? '- - -' }}
                                                        </td>
                                                        <td class="text-center align-middle">
                                                            {{ $row->contact_number ?? '- - -' }}
                                                        </td>
                                                        {{-- <td class="text-center">
                                                            {{ $row->address ?? '- - -' }}
                                                        </td> --}}

                                                        <td class="text-center align-middle">
                                                            {{ $row->referred_by ?? '- - -' }}
                                                        </td>
                                                        <td class="text-center align-middle">
                                                            <div class="dropdown open">
                                                                <button class="btn btn-secondary btn-sm dropdown-toggle"
                                                                    type="button" id="loungeOptionsDropDown"
                                                                    data-bs-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">
                                                                    <span class="mdi mdi-cog"></span>
                                                                    Options
                                                                </button>
                                                                <div class="dropdown-menu"
                                                                    aria-labelledby="loungeOptionsDropDown">
                                                                    <a class="dropdown-item" href="{{ route('user.view_members') }}?rid={{ $row->uuid }}" target="_BLANK">
                                                                        <span class="mdi mdi-account-search text-info"></span>
                                                                        View user
                                                                    </a>
                                                                    <button
                                                                        class="dropdown-item showModalUpdateReferral"
                                                                        type="button" data-uuid="{{ $row->uuid }}"
                                                                        data-referredBy="{{ $row->referred_by }}">
                                                                        <span class="mdi mdi-update text-warning"></span>
                                                                        Update referral
                                                                    </button>
                                                                    <a class="dropdown-item" href="#">
                                                                        <span class="mdi mdi-cancel text-danger"></span>
                                                                        Disable account
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-auto mt-3 mx-auto">
                                        {{ $data['lounge_members']->appends(request()->input())->links() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- MODALS --}}
    @include('pages/admins/section/modals/membership-uploads')
    @include('pages.admins.section.modals.lounge-members.update-referral')
    {{-- SCRIPTS --}}
    @include('pages/admins/section/admin-scripts')
    <script src="{{ asset('js/admins_js/admin-lounge-members.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            @if (Session::has('response'))
                toastr['{{ Session::get('response')['alert'] }}']('{{ Session::get('response')['message'] }}',
                    '{{ Session::get('response')['title'] }}');
            @endif

        });
    </script>
</body>


</html>
