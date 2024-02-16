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
                                    Premium Membership
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
                                <form action="{{ route('admin.Membership_Upgrade') }}" method="get">
                                    <div class="row justify-content-end">
                                        <div class="col-auto">
                                            <div class="input-group mb-3">
                                                <input class="form-control form-select-sm" type="text" name="search"
                                                    placeholder="Search..." value="{{ request('search') }}">
                                                <button class="btn btn-outline-secondary btn-sm" type="submit">
                                                    <i class="mdi mdi-magnify"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 p-3">
                                <div class="table-responsive row p-2">
                                    <table id="membership_upgrade_table" class="table table-striped w-100">
                                        <thead>
                                            <tr>
                                                <th>id</th>
                                                <th>member_status</th>
                                                <th>registration_uuid</th>
                                                <th>user_uuid</th>
                                                <th>iagd_number</th>
                                                <th>first_name</th>
                                                <th>last_name</th>
                                                <th>middle_initial</th>
                                                <th>email_address</th>
                                                <th>contact_number</th>
                                                <th>address</th>
                                                <th>shipping_address</th>
                                                <th>nearest_lbc_branch</th>
                                                <th>name_on_card</th>
                                                <th>fb_url</th>
                                                <th>Referral Code</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!empty($data['membership_upgrade']) && $data['membership_upgrade']->count() > 0)
                                                @foreach ($data['membership_upgrade'] as $row)
                                                    <tr
                                                        @foreach ($row->Uploads as $key => $upload)
														{{ 'data-img_' . $key . '=' . $upload->type . ';' . $upload->file_path . '' }} @endforeach>
                                                        <td class="text-center">
                                                            {{ $row->id ?? '- - -' }}
                                                        </td>
                                                        <td>
                                                            @if (isset($row->MemberAccount) && $row->MemberAccount->is_premium == 1)
                                                                <span
                                                                    class="rounded-pill px-2 py-1 bg-warning text-light"
                                                                    style="white-space: nowrap;">
                                                                    LOUNGE PREMIUM
                                                                </span>
                                                            @else
                                                                <span
                                                                    class="rounded-pill px-2 py-1 bg-secondary text-light"
                                                                    style="white-space: nowrap;">
                                                                    LOUNGE REGULAR
                                                                </span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $row->registration_uuid ?? '- - -' }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $row->user_uuid ?? '- - -' }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $row->iagd_number ?? '- - -' }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $row->first_name ?? '- - -' }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $row->last_name ?? '- - -' }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $row->middle_initial ?? '- - -' }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $row->email_address ?? '- - -' }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $row->contact_number ?? '- - -' }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $row->address ?? '- - -' }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $row->shipping_address ?? '- - -' }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $row->nearest_lbc_branch ?? '- - -' }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $row->name_on_card ?? '- - -' }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $row->fb_url ?? '- - -' }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $row->referral_code ?? '- - -' }}
                                                        </td>
                                                        <td class="text-center">
                                                            <button class="btn-membership-uploads btn btn-info mb-1">
                                                                Uploads
                                                            </button>
                                                            @if (isset($row->MemberAccount) && $row->MemberAccount->is_premium == 0)
                                                                <a href="{{ route('admin.upgrade_membership', ['m_uuid' => $row->user_uuid]) }}"
                                                                    class="btn btn-success mb-1">
                                                                    <i class="nav-icon mdi mdi-account-plus"></i>
                                                                    Upgrade Membership
                                                                </a>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-auto mt-3 mx-auto">
                                        {{ $data['membership_upgrade']->appends(request()->input())->links() }}
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
    {{-- SCRIPTS --}}
    @include('pages/admins/section/admin-scripts')
    <script type="text/javascript">
        $(document).ready(function() {
            @if (Session::has('response'))
                toastr['{{ Session::get('response')['alert'] }}']('{{ Session::get('response')['message'] }}',
                    '{{ Session::get('response')['title'] }}');
            @endif

            $('.btn-membership-uploads').on('click', function() {
                $('#membershipUploadModal').modal('show');
                $('#membershipUploadModal').find('.modal-data').html('')

                $.each($(this).parents('tr').data(), function(i, val) {
                    let data = val.split(';');
                    $('#membershipUploadModal').find('.modal-data').append(
                        $('<div>').attr({
                            'class': 'col-12 col-sm-6 text-center'
                        }).append(
                            $('<div>').attr({
                                'class': 'w-100 fw-bold'
                            }).html(
                                data[0]
                            )
                        ).append(
                            $('<img>').attr({
                                'class': 'rounded-3',
                                'src': '{{ asset('/') }}' + data[1]
                            }).css({
                                'max-height': '300px'
                            })
                        )
                    );
                });
            });

        });
    </script>
</body>


</html>
