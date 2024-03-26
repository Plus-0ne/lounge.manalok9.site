{{-- HEADER CONTAINS CSS LINKS --}}
@include('pages/users/template/section/header')

<body>
    <div class="wrapper">

        {{-- TOP NAVIGATION --}}
        @include('pages/users/template/section/header_nav')

        <div class="main">

            {{-- SIDABAR --}}
            @include('pages/users/template/section/sidebar')

            <div class="main-content">
                <div class="container-fluid container-xl">
                    <div class="row">
                        <div class="p-4 rounded-3 bg-light section_shadow border border-1 border-light">
                            <div class="row">
                                <div class="col-12 text-end">
                                    <button type="button" class="btn btn-primary btn-size-95-rem shadow"
                                        data-bs-target="#add_dog_unregistered" data-bs-toggle="modal">
                                        <i class="mdi mdi-plus-box-outline"></i> REGISTER DOG
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="my-4"></div>

                        <div class="py-4 px-0 rounded-3 bg-light section_shadow border border-1 border-light">
                            <div class="row">
                                <div class="col-12 text-start px-5 ms-sm-1 ms-md-3 ms-lg-5 row" style="margin-top: -3rem;">
                                    <div class="col-auto">
                                        <h5 class="text-light py-3 px-4" style="background-color: #475c7c;">
                                            <i class="mdi mdi-dog pe-2"></i> IAGD DOG REGISTRATION
                                        </h5>
                                    </div>
                                    <div class="col-auto mx-auto ms-sm-0">
                                        <a href="kennel" class="btn btn-success rounded-pill p-3 py-2 py-sm-3 mb-1 fw-bold">
                                            <i class="mdi mdi-dog"></i> Registered Dogs ({{ $data['kennel_count'] }})
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 px-0 pt-4">
                                <div class="table-responsive">
                                    <table id="member_dogs" class="table table-striped w-100">
                                        <thead>
                                            <tr>
                                                <th class="text-center ps-5">

                                                </th>
                                                <th class="text-center">
                                                    Name
                                                </th>
                                                <th class="text-center">
                                                    Birth Date
                                                </th>
                                                <th class="text-center">
                                                    Gender
                                                </th>
                                                <th class="text-center">
                                                    Location
                                                </th>
                                                <th class="text-center">
                                                    Breed
                                                </th>
                                                <th class="text-center pe-5">

                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty($data['member_dogs']) && count($data['member_dogs']) > 0)
                                                @foreach ($data['member_dogs'] as $row)
                                                    <tr>
                                                        <td class="text-end align-middle ps-5">
                                                            <img class="shadow" src="{{ asset($row->AdtlInfo->FilePhoto->file_path ?? 'img/no_img.jpg') }}" style="height: 10rem;">
                                                        </td>
                                                        <td class="text-center align-middle">
                                                            {{ $row->PetName }}
                                                        </td>
                                                        <td class="text-center align-middle">
                                                            {{ $row->BirthDate }}
                                                        </td>
                                                        <td class="text-center align-middle">
                                                            {{ $row->Gender }}
                                                        </td>
                                                        <td class="text-center align-middle">
                                                            {{ $row->Location }}
                                                        </td>
                                                        <td class="text-center align-middle">
                                                            {{ $row->Breed }}
                                                        </td>
                                                        <td class="text-center align-middle pe-5">
                                                            @if($row->Status == 1)
                                                                <label class="rounded-pill bg-warning text-dark px-3 py-1 fw-bold">
                                                                    Pending Approval
                                                                </label><br>
                                                            @elseif($row->Status == 2)
                                                                <label class="rounded-pill bg-success text-light px-3 py-1 fw-bold">
                                                                    Approved
                                                                </label><br>
                                                            @elseif($row->Status == 3)
                                                                <label class="rounded-pill bg-danger text-light px-3 py-1 fw-bold">
                                                                    Rejected
                                                                </label><br>
                                                            @elseif($row->Status == 4)
                                                                <label class="rounded-pill bg-info text-light px-3 py-1 fw-bold">
                                                                    Need User Verification
                                                                </label><br>
                                                            @endif
                                                            @if($row->Status == 1 || $row->Status == 4)
                                                                @if (Auth::guard('web')->user()->is_premium == '0')
                                                                    <a href="{{ route('user.be_a_member') }}" class="btn btn-info mt-1" data-bs-container="body" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-placement="left" data-bs-content="Upgrade your account to fully register your pet!">
                                                                        <i class="mdi mdi-account-multiple-plus"></i> Upgrade Your Membership
                                                                    </a><br>
                                                                @endif
                                                            @endif
                                                            <a href="kennel_unregistered_info/{{ $row->PetUUID }}" class="btn btn-primary mt-1 btn-sm">
                                                                <i class="mdi mdi-eye"></i> Verify pet
                                                            </a><br>
                                                            <a href="cancel_dog_registration/{{ $row->PetUUID }}" class="cancel-registration btn btn-danger mt-1 btn-sm">
                                                                <i class="mdi mdi-close"></i>Cancel
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td class="text-center align-middle" colspan="8">
                                                        <label class="rounded-pill bg-info text-light px-5 py-3 my-2 fw-bold">
                                                            DOGS LIST IS EMPTY!
                                                        </label>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-12 pt-4 pb-4 text-center">
                                    {{ $data['member_dogs']->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @include('pages/users/template/section/r-sidebar')
        </div>
    </div>
    {{-- INCLUDE MODAL TEMPLATE --}}
    @include('pages/users/template/modals/modal-add-dog-unregistered')
    @include('pages/users/template/modals/modal-upload-pet-receipt')
</body>

{{-- SCRIPTS --}}
@include('pages/users/template/section/scripts')
<script src="{{ asset('custom/js/pet-registration.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        @if (Session::has('response'))
            @switch(Session::get('response'))
                @case('key_error')
                    toastr["error"]("Something's wrong! Please try again later.", "Error");
                @break

                @case('pet_added')
                    toastr["success"]("Dog added", "Success");
                @break
                @case('error_pet_add')
                    toastr["error"]("Something's wrong! Please try again later.", "Error");
                @break
                @case('not_allowed')
                    toastr["error"]("Something's wrong! Please try again later.", "Error");
                @break


                @case('receipt_upload_success')
                    toastr["success"]("Receipt added", "Success");
                @break
                @case('receipt_upload_error')
                    toastr["error"]("Something's wrong! Please try again later.", "Error");
                @break

                @case('registration_cancel_success')
                    toastr["success"]("Registration cancelled.", "Success");
                @break
                @case('registration_cancel_fail')
                    toastr["error"]("Something's wrong! Please try again later.", "Error");
                @break

                @default
            @endswitch
        @endif
        @if ($errors->any())
            toastr["warning"]('{{ $errors->first() }}', "Warning");
        @endif


        $('.upload-receipt').on('click', function() {
            UploadReceipt($(this), 'unregistered_dog', '{{ asset("/") }}');
        });
    });
</script>

</html>
