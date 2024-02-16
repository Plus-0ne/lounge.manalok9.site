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
                    <div class="row">
                        <div class="p-4 gallery_container d-flex flex-wrap">
                            <div class="row px-5">
                                <h5 class="text-light py-3 px-4" style="background-color: #1e2530; margin-top: -2.8rem;">
                                    <a href="{{ url('advertisements') }}" class="me-2">
                                        <i class="mdi mdi-chevron-left text-light"></i>
                                    </a>
                                    {{ $data['ad_data']->title ?? '- - - - -' }}
                                </h5>
                            </div>
                            <div class="col-12 my-2 text-end">
                                <button type="button" class="btn btn-primary btn-size-95-rem shadow"
                                    data-bs-target="#update_ad" data-bs-toggle="modal">
                                    <i class="mdi mdi-square-edit-outline"></i> UPDATE
                                </button>
                            </div>
                            <div class="row p-3 w-100 justify-content-center">
                                <div class="col-12 col-sm-12 col-md-8">
                                    <div class="row">
                                        <div class="col-12 col-sm-12" style="white-space: pre-wrap;">{{ $data['ad_data']->message ?? '- - - - -' }}</div>
                                    </div>
                                    @if (!empty($data['ad_data']->file_path))
                                        <div class="row justify-content-center py-5">
                                            <div class="col-12 col-sm-12 col-md-8 text-center">
                                                <img class="shadow p-0 w-100" src="{{ asset($data['ad_data']->file_path ?? 'img/no_img.jpg') }}">
                                            </div>
                                        </div>
                                    @endif
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
    @include('pages/users/template/modals/modal-update-ad')

</body>

{{-- SCRIPTS --}}
@include('pages/users/template/section/scripts')

<script type="text/javascript">
    $(document).ready(function() {
        @if ($errors->any())
            toastr["warning"]('{{ $errors->first() }}');
        @endif
        @if (Session::has('response'))
            @switch(Session::get('response'))
                @case('key_error')
                    toastr["error"]('Something\'s wrong! Please try again.');
                @break

                @case('ad_updated')
                    toastr["success"]('Ad info successfully updated');
                @break
                @case('ad_fail_update')
                    toastr["warning"]('Updating ad info failed!');
                @break
                @case('ad_not_found')
                    toastr["warning"]('Ad not found');
                @break

                @default
            @endswitch
        @endif
    });
</script>

</html>
