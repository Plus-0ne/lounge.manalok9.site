{{-- HEADER CONTAINS CSS LINKS --}}
@include('pages/users/template/section/header')
<style>
    .gallery-image {
        height: 90%;
        object-fit: cover;
    }

</style>

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
                        <div class="col-12 px-4 pt-4 pb-5 gallery_container d-flex flex-wrap">
                            <div class="p-3 col-10">
                                <h5>
                                    Post Details
                                </h5>
                            </div>
                            <div class="p-3 col-2 text-end">
                                <a href="{{ route('dashboard') }}">
                                    <i class="mdi mdi-close-thick mdi-24px" role="button"></i>
                                </a>
                            </div>
                            <div class="p-3 col-12 text-end">
                                @if ($data['post_data']->uuid == Auth::guard('web')->user()->uuid)
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-primary dropdown-toggle btn-sm"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="mdi mdi-cog"></i> Option
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <a class="dropdown-item" href="#">
                                                    <i class="mdi mdi-square-edit-outline"></i> Update
                                                </a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="#">
                                                    <i class="mdi mdi-delete-outline"></i> Remove
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                @endif
                            </div>
                            <div class="p-3 col-12">
                                <p>
                                    {{ $data['post_data']->post_message }}
                                </p>
                            </div>
                            <div class="p-3 col-12">
                                <p>
                                    Date posted :
                                    {{ Carbon::createFromFormat('Y-m-d H:i:s', $data['post_data']->created_at)->format('D M d , Y - h:i:s A') }}
                                </p>
                            </div>
                            <div class="p-3 col-12 d-flex justify-content-between align-item-middle">
                                <div class="d-flex justify-content-start">
                                    <div class="me-4 text-center">
                                        <h3 id="like-mdi-icon">
                                        </h3>
                                        <small id="like_countss"></small>
                                    </div>
                                    <div class="me-4 text-center">
                                        {{-- <h3>
                                            <i class="mdi mdi-comment"></i>
                                        </h3>
                                        <small>{{ $data['PostComments_c'] }}</small> --}}
                                    </div>
                                </div>
                                <div class="">
                                    <button id="btn-comment-modal" class="btn btn-primary btn-sm">
                                        <i class="mdi mdi-comment-plus"></i> Add Comment
                                    </button>
                                </div>
                            </div>
                            <div class="p-3 col-12">
                                <hr>
                                <div class="w-100 d-flex justify-content-between align-middle">
                                    <div class="label-comments">
                                        <h5>
                                            Comments
                                        </h5>
                                    </div>
                                    <div class="sort-comment">
                                        <h5>
                                            <i class="mdi mdi-sort"></i>
                                        </h5>
                                    </div>
                                </div>
                                <hr>
                                <div id="comment-section" class="py-4">


                                </div>

                                <div class="text-center">
                                    <button class="nextpost btn btn-primary btn-sm">
                                        View other post
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('pages/users/template/section/r-sidebar')
        </div>
    </div>
    @include('pages/users/template/modals/modal-post-comment')
    {{-- Include custom user toast --}}
    @include('pages/users/template/section/user-toasts')
</body>

{{-- SCRIPTS --}}
@include('pages/users/template/section/scripts-var')
@include('pages/users/template/section/scripts')

<script src="{{ asset('js/members_js/view_post.js') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {


        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-bottom-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "500",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }
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
