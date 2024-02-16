{{-- HEADER CONTAINS CSS LINKS --}}
@include('pages/admins/section/admin-header')

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
                                    Select user
                                </h5>
                                <hr>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 p-3 d-flex justify-content-between">
                                {{-- TODO : Admin form - Select from lounge user and assign role to create his/her admin account --}}
                                <div class="table-responsive w-100">
                                    <table id="usersMembers" class="table table-condensed">
                                        <thead>
                                            <th style="width: 100px"> Image </th>
                                            <th> Name </th>
                                            <th> Email address </th>
                                            <th> Contact # </th>
                                            <th> Action </th>
                                        </thead>
                                        <tbody>
                                            @foreach ($data['users'] as $row)
                                            <tr>
                                                <td class="align-middle">
                                                    <div class="dt-user-prof-img img-dt-round">
                                                        <img class="img-dt-round" src="{{ asset('img/user/user.png') }}" alt="">
                                                    </div>
                                                </td>
                                                <td class="align-middle">
                                                    {{ Str::ucfirst($row->first_name) }} {{ Str::ucfirst($row->last_name) }}
                                                </td>

                                                <td class="align-middle">
                                                    @if ($row->is_email_verified == 1)
                                                        <span class="mdi mdi-check-circle text-success"></span>
                                                        @else
                                                        <span class="mdi mdi-check-circle text-muted"></span>
                                                    @endif
                                                    {{ $row->email_address }}
                                                </td>

                                                <td class="align-middle">
                                                    {{ $row->contact_number }}
                                                </td>

                                                <td>
                                                    <button class="btn btn-primary btn-sm btnNewAdminForm" data-uuid={{ $row->uuid }}>
                                                        <span class="mdi mdi-plus"></span> Add
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
    @include('pages.admins.admin-accounts.modal-accounts-form')
    {{-- SCRIPTS --}}
    @include('pages/admins/section/admin-scripts')
    <script src="{{ asset('js/admins_js/admin-accounts-form.js') }}"></script>
</body>

</html>
