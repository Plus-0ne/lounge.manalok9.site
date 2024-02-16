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
                                <h3>
                                    Certification request
                                </h3>
                                <small class="text-muted">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam repudiandae quis voluptates fugiat quod quas eum, exercitationem, soluta deleniti, veritatis maiores nostrum? Hic quos iure nulla nostrum dolor, amet id.
                                </small>
                                <hr>

                                <div class="table-responsive w-100">
                                    <table id="tablecert" class="table table-condensed w-100">
                                        <thead>
                                            <th scope="col">Status</th>
                                            <th scope="col">Animal name</th>
                                            <th scope="col">Owner</th>
                                            <th scope="col">Inclusion</th>
                                            <th scope="col">FB account / Contact #</th>
                                            <th scope="col">Action</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($data['cert_req'] as $row)
                                                <tr>
                                                    <td width="120px">
                                                        @switch($row->status)
                                                            @case(1)
                                                                <span class="badge rounded-pill bg-success">Approved</span>
                                                            @break

                                                            @default
                                                                <span class="badge rounded-pill bg-warning">Pending</span>
                                                        @endswitch
                                                    </td>
                                                    <td>
                                                        @if (!empty($row->animalDetails->PetName))
                                                            {{ $row->animalDetails->PetName }}
                                                        @else
                                                            <span>
                                                                - - -
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $row->requestCreator->first_name }}
                                                        {{ $row->requestCreator->last_name }}
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-column">
                                                            @php
                                                                $certOnly = $row->certificate_only;
                                                                $pedigree = $row->include_pedigree_cert;
                                                                $certHolder = $row->certificate_holder;

                                                                if ($certOnly) {
                                                                    echo '<div>
                                                                            <span class="mdi mdi-check text-success"></span> <small>Certificate only</small>
                                                                        </div>';
                                                                }

                                                                if ($pedigree == 1) {
                                                                    echo '<div>
                                                                            <span class="mdi mdi-check text-success"></span> <small>Pedigree</small>
                                                                        </div>';
                                                                }

                                                                if ($certHolder == 1) {
                                                                    echo '<div>
                                                                            <span class="mdi mdi-check text-success"></span> <small>With certifcate holder</small>
                                                                        </div>';
                                                                }

                                                            @endphp
                                                        </div>
                                                    </td>
                                                    <td>
                                                        @if ($row->fb_account != null)
                                                            {{ $row->fb_account }}
                                                        @else
                                                            <small>- - -</small>
                                                        @endif
                                                    </td>
                                                    <td width="140px">
                                                        <div class="dropdown">
                                                            <button class="btn btn-secondary dropdown-toggle btn-sm"
                                                                type="button" id="triggerId" data-bs-toggle="dropdown"
                                                                aria-haspopup="true" aria-expanded="false">
                                                                <span class="mdi mdi-cog"></span> Action
                                                            </button>
                                                            <div class="dropdown-menu" aria-labelledby="triggerId">
                                                                <a class="dropdown-item certActionView"
                                                                    href="javascript::void(0);"
                                                                    data-uuid="{{ $row->uuid }}">
                                                                    <span class="mdi mdi-eye text-info"></span> Details
                                                                </a>
                                                                <a class="dropdown-item certActionReject"
                                                                    href="javascript::void(0);"
                                                                    data-uuid="{{ $row->uuid }}">
                                                                    <span class="mdi mdi-cancel text-danger"></span>
                                                                    Reject
                                                                </a>
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
    @include('pages.admins.section.modals.certification-request-page.modal-certification-request-details')
    {{-- SCRIPTS --}}
    @include('pages/admins/section/admin-scripts')
    <script src="{{ asset('js/admins_js/admin-certification-request.js') }}"></script>
</body>

</html>
