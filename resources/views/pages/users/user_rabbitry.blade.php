{{-- HEADER CONTAINS CSS LINKS --}}
@include('pages/users/template/section/header')

<body>
    <div class="wrapper">

        {{-- TOP NAVIGATION --}}
        @include('pages/users/template/section/header_nav')

        <div class="main">

            {{-- SIDABAR --}}
            @include('pages/users/template/section/sidebar')

            <div class="main-content h-100">
                <div class="container-fluid container-xl">
                    <div class="row py-4">
                        <form action="{{ route('user.add_rabbit') }}" method="post">
                            @csrf
                            <div class="p-4 rounded-3 bg-light section_shadow border border-1 border-light">
                                <div class="row">
                                    <div class="col-0 col-sm-3 text-end">
                                    </div>
                                    <div class="col-6 col-sm-4">
                                        <input type="text" name="petno" class="form-control" placeholder="Rabbit IAGD #" required>
                                    </div>
                                    <div class="col-6 col-sm-5">
                                        <button type="submit" class="btn btn-primary"><i class="mdi mdi-plus"></i> Add Rabbit</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="my-4"></div>

                        <div class="py-4 px-0 rounded-3 bg-light section_shadow border border-1 border-light">
                            <div class="row">
                                <div class="col-12 text-start px-5 ms-sm-1 ms-md-3 ms-lg-5 row" style="margin-top: -3rem;">
                                    <div class="col-auto">
                                        <h5>
                                            <div class="dropdown">
                                                <button class="dropdown-toggle text-light py-3 px-4" style="background-color: #1e2530;" type="button" data-bs-toggle="dropdown">
                                                    <i class="mdi mdi-rabbit pe-1"></i> Rabbits
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('kennel') }}">
                                                            <h5><i class="mdi mdi-dog pe-1"></i> Dogs</h5>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('cattery') }}">
                                                            <h5><i class="mdi mdi-cat pe-1"></i> Cats</h5>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('coop') }}">
                                                            <h5><i class="mdi mdi-bird pe-1"></i> Birds</h5>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="{{ route('other_animal') }}">
                                                            <h5><i class="mdi mdi-help-circle-outline pe-1"></i> Other Animals</h5>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </h5>
                                    </div>
                                    <div class="col-auto mx-auto mx-sm-0">
                                        <a href="rabbitry_unregistered" class="btn btn-success rounded-pill p-3 py-2 py-sm-3 mb-1 fw-bold">
                                            <i class="mdi mdi-rabbit"></i> PRE-REGISTERED RABBITS ({{ $data['rabbitry_count'] }})
                                        </a>
                                    </div>
                                    <div class="col-auto mx-auto mx-sm-0">
                                        <button type="button" class="btn btn-primary btn-size-95-rem shadow p-3 py-2 py-sm-3 mb-1"
                                            data-bs-target="#add_rabbit_unregistered" data-bs-toggle="modal">
                                            <i class="mdi mdi-plus-box-outline"></i> REGISTER RABBIT
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 px-0 pt-4 pb-4">
                                <div class="table-responsive">
                                    <table id="member_rabbits" class="table table-striped w-100">
                                        <thead>
                                            <tr>
                                                <th class="text-center ps-5">

                                                </th>
                                                <th class="text-center">
                                                    IAGD #
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
                                            @if(!empty($data['member_rabbits']) && count($data['member_rabbits']) > 0)
                                                @foreach ($data['member_rabbits'] as $row)
                                                    <tr>
                                                        <td class="text-end align-middle ps-5">
                                                            <img class="shadow" src="{{ asset($row->AdtlInfo->FilePhoto->file_path ?? 'img/no_img.jpg') }}" style="height: 10rem;">
                                                        </td>
                                                        <td class="text-center align-middle">
                                                            {{ $row->PetNo }}
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
                                                            @if($row->Approval == 0)
                                                                <label class="rounded-pill bg-warning text-light px-3 py-1 fw-bold">
                                                                    Pending Approval
                                                                </label>
                                                            @else
                                                                <a href="{{ empty($row->PetNo) ? '#' : 'rabbitry_info/' . $row->PetNo }}" class="btn btn-primary {{ (empty($row->PetNo) ? 'disabled' : '') }}">
                                                                    Info
                                                                </a>
                                                            @endif
                                                            <div class="mb-3">
                                                                <a href="{{ route('user.animal_certifcation') }}?PetUUID={{ $row->PetUUID}}"
                                                                    class="btn btn-info btn-sm {{ empty($row->PetUUID) ? 'disabled' : '' }}">
                                                                    <span class="mdi mdi-certificate"></span> Request certificate
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td class="text-center align-middle" colspan="8">
                                                        <label class="rounded-pill bg-info text-light px-5 py-3 my-2 fw-bold">
                                                            RABBITS LIST IS EMPTY!
                                                        </label>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-12 pt-4 pb-4 text-center">
                                    {{ $data['member_rabbits']->links() }}
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
    @include('pages/users/template/modals/modal-add-rabbit-unregistered')
</body>

{{-- SCRIPTS --}}
@include('pages/users/template/section/scripts')
<script type="text/javascript">
    $(document).ready(function() {
        @if (Session::has('response'))
            @switch(Session::get('response'))
                @case('key_error')
                    toastr["error"]("Something's wrong! Please try again later.", "Error");
                @break

                @case('rabbit_added')
                    toastr["success"]("Rabbit added", "Success");
                @break
                @case('error_rabbit_add')
                    toastr["error"]("Something's wrong! Please try again later.", "Error");
                @break
                @case('rabbit_approval_pending')
                    toastr["warning"]("Rabbit approval pending", "Warning");
                @break
                @case('rabbit_claimed')
                    toastr["warning"]("Rabbit has already been claimed", "Warning");
                @break
                @case('rabbit_not_found')
                    toastr["warning"]("Rabbit not found", "Warning");
                @break

                @case('pet_added')
                    toastr["success"]("Rabbit registration added", "Success");
                @break
                @case('error_pet_add')
                    toastr["error"]("Something's wrong! Please try again later.", "Error");
                @break
                @case('not_allowed')
                    toastr["error"]("Something's wrong! Please try again later.", "Error");
                @break

                @default
            @endswitch
        @endif
        @if ($errors->any())
            toastr["warning"]('{{ $errors->first() }}', "Warning");
        @endif

    });
</script>

</html>
