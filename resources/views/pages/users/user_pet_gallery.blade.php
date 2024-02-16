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
                    <div class="row">
                        <div class="col-12 px-4 pt-4 pb-5 gallery_container d-flex flex-wrap">
                            <div class="p-3 col-12">
                                <h5>
                                    Gallery
                                </h5>
                            </div>
                            <div class="col-12">
                                <hr>
                            </div>
                            <div class="p-3 col-12 text-end">
                                <button class="btn btn-primary" data-bs-target="#upload_img_dog" data-bs-toggle="modal">
                                    <i class="mdi mdi-upload"></i> Upload
                                </button>
                            </div>
                            <div class="d-flex flex-row flex-wrap justify-content-center justify-content-xl-around">
                                @foreach ($data['members_gallery'] as $row)
                                    <div class="col-xl-3 gall-container d-flex justify-content-center mb-5 mx-2">
                                        <a href="{{ route('user.view_pet_details') }}?rid={{ $row->id }}">
                                            <img class="gallery-image align-self-center" src="{{ $row->file_path }}"
                                                alt="" class="img-fluid img-responsive">
                                        </a>
                                        <div class="image-gal-control d-flex flex-row">
                                            <i class="mdi mdi-delete-outline pet-delete"
                                                data-id="{{ $row->id }}"></i>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('pages/users/template/section/r-sidebar')
        </div>
    </div>
    {{-- INCLUDE MODAL TEMPLATE --}}
    @include('pages/users/template/modals/image_modal')
    @include('pages/users/template/modals/modal-upload-image-dog')
    @include('pages/users/template/modals/modal-delete-pet')
</body>

{{-- SCRIPTS --}}
@include('pages/users/template/section/scripts')
<script src="{{ asset('js/members_js/pet_gallery_scripts.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        @if (Session::has('response'))
            @switch(Session::get('response'))
                @case('key_error')
                    toastr["warning"]("Something's wrong, Please try again.");
                @break

                @case('failed_to_save')
                    toastr["warning"]("Failed to save new dog");
                @break

                @case('max_file_upload')
                    toastr["warning"]("You've reached the maximun upload");
                @break

                @case('image_is_null')
                    toastr["warning"]("Image file is null");
                @break

                @case('success_img_save')
                    toastr["success"]("Dog image uploaded");
                @break

                @default
            @endswitch
        @endif
        @if ($errors->any())
            toastr["warning"]('{{ $errors->first() }}');
        @endif
    });
</script>

</html>
