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
                <div class="container-fluid">
                    <div class="row py-4">
                        <form action="{{ route('user.add_advertisement') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="p-4 rounded-3 bg-light section_shadow border border-1 border-light">
                                <div class="row justify-content-center">
                                    <div class="col-9 py-1">
                                        <input id="ad_title" type="text" name="ad_title" class="form-control" placeholder="Title...">
                                    </div>
                                    <div class="col-9 py-1">
                                        <textarea id="ad_message" name="ad_message" class="form-control" placeholder="Message..." rows="5"></textarea>
                                    </div>
                                    <div class="col-5 py-1">
                                        {{-- <button type="button" class="btn btn-primary">
                                            <i class="mdi mdi-attachment"></i> Image
                                        </button> --}}
                                        <input class="form-control" type="file" name="file_path">
                                    </div>
                                    <div class="col-4 text-end py-1">
                                        <button type="submit" class="btn btn-primary"><i class="mdi mdi-plus"></i> Add Advertisement</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="my-4"></div>

                        <div class="py-4 px-0 rounded-3 bg-light section_shadow border border-1 border-light">
                            <div class="col-8 col-sm-6 col-md-5 col-lg-5 col-xl-4 text-start px-5 ms-sm-1 ms-md-3 ms-lg-5">
                                <h5 class="text-light py-3 px-4" style="background-color: #1e2530; margin-top: -2.8rem;">
                                    <i class="mdi mdi-advertisements pe-2"></i> Advertisements
                                </h5>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 px-0 pt-4">
                                <div class="table-responsive">
                                    <table id="member_advertisements" class="table table-striped w-100">
                                        <thead>
                                            <tr>
                                                <th class="text-center ps-5">
                                                    
                                                </th>
                                                <th class="text-center">
                                                    Title
                                                </th>
                                                <th class="text-center">
                                                    Date Created
                                                </th>
                                                <th class="text-center pe-5">
                                                    
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty($data['member_advertisements']) && count($data['member_advertisements']) > 0)
                                                @foreach ($data['member_advertisements'] as $row)
                                                    <tr>
                                                        <td class="text-end align-middle ps-5">

                                                        </td>
                                                        <td class="text-center align-middle ps-5">
                                                            {{ $row->title }}
                                                        </td>
                                                        <td class="text-center align-middle">
                                                            {{ $row->created_at }}
                                                        </td>
                                                        <td class="text-center align-middle pe-5">
                                                            <a href="advertisements_info/{{ $row->uuid }}" class="btn btn-primary">
                                                                Info
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td class="text-center align-middle" colspan="8">
                                                        <label class="rounded-pill bg-info text-light px-5 py-3 my-2 fw-bold">
                                                            ADVERTISEMENTS LIST IS EMPTY!
                                                        </label>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-12 pt-4 pb-4 text-center">
                                    {{ $data['member_advertisements']->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @include('pages/users/template/section/r-sidebar')
        </div>
    </div>
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

                @case('ad_created')
                    toastr["success"]("Advertisement added", "Success");
                @break
                @case('ad_failed')
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

        $("#ad_message").emojioneArea({
            search: false,
            pickerPosition: "bottom",
            filtersPosition: "bottom",
        });
    });
</script>

</html>
