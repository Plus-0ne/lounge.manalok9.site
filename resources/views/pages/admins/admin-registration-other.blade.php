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
                                    Registration - Other
                                </h5>
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
                                <form action="{{ route('admin.Other_Registration') }}" method="get">
                                    <div class="row justify-content-end">
                                        <div class="col-auto">
                                            <div class="input-group mb-3">
                                                <input class="form-control" type="text" name="search"
                                                    placeholder="Search..." value="{{ request('search') }}">
                                                <button class="btn btn-outline-secondary" type="submit">
                                                    <i class="mdi mdi-magnify"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 p-3">
                                <div class="table-responsive row p-2">
                                    <table class="table table-striped w-100">
                                        <thead>
                                            <tr>
                                                <th>PetUUID</th>
                                                <th>OwnerUUID</th>
                                                <th>OwnerIAGDNo</th>
                                                <th>PetName</th>
                                                <th>AnimalType</th>
                                                <th>CommonName</th>
                                                <th>FamilyStrain</th>
                                                <th>ColorMarking</th>
                                                <th>SizeWidth</th>
                                                <th>SizeLength</th>
                                                <th>SizeHeight</th>
                                                <th>Weight</th>
                                                <th>Co_Owner</th>
                                                <th>Status</th>
                                                <th>DateAdded</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!empty($data['registration_other']) && $data['registration_other']->count() > 0)
                                                @foreach ($data['registration_other'] as $row)
                                                    <tr data-pet_uuid="{{ $row->PetUUID ?? '' }}">
                                                        <td class="text-center">
                                                            {{ $row->PetUUID ?? '- - -' }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $row->OwnerUUID ?? '- - -' }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $row->OwnerIAGDNo ?? '- - -' }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $row->PetName ?? '- - -' }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $row->AnimalType ?? '- - -' }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $row->CommonName ?? '- - -' }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $row->FamilyStrain ?? '- - -' }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $row->ColorMarking ?? '- - -' }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $row->SizeWidth ?? '- - -' }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $row->SizeLength ?? '- - -' }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $row->SizeHeight ?? '- - -' }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $row->Weight ?? '- - -' }}
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $row->Co_Owner ?? '- - -' }}
                                                        </td>
                                                        <td class="text-center">
                                                            @if ($row->Status == 0)
                                                                <label
                                                                    class="rounded-pill bg-danger text-dark px-3 py-1 fw-bold">
                                                                    Deleted
                                                                </label><br>
                                                            @elseif($row->Status == 1)
                                                                <label
                                                                    class="rounded-pill bg-secondary text-dark px-3 py-1 fw-bold">
                                                                    Pending Approval
                                                                </label><br>
                                                            @elseif($row->Status == 2)
                                                                <label
                                                                    class="rounded-pill bg-success text-light px-3 py-1 fw-bold">
                                                                    Approved
                                                                </label><br>
                                                            @elseif($row->Status == 3)
                                                                <label
                                                                    class="rounded-pill bg-warning text-light px-3 py-1 fw-bold">
                                                                    Rejected
                                                                </label><br>
                                                            @elseif($row->Status == 4)
                                                                <label
                                                                    class="rounded-pill bg-info text-light px-3 py-1 fw-bold">
                                                                    Need User Verification
                                                                </label><br>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            {{ $row->DateAdded ?? '- - -' }}
                                                        </td>
                                                        <td class="text-center">
                                                            <button class="btn-pet-reg-adtl btn btn-info">
                                                                Adtl Info
                                                            </button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-auto mt-3 mx-auto">
                                        {{ $data['registration_other']->appends(request()->input())->links() }}
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
    @include('pages/admins/section/modals/pet-reg-adtl')

    {{-- SCRIPTS --}}
    <script type="text/javascript">
        const asset_url = '{{ asset('/') }}';
    </script>
    @include('pages/admins/section/admin-scripts')
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
