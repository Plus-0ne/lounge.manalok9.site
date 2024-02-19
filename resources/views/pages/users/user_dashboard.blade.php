{{-- HEADER CONTAINS CSS LINKS --}}
@include('pages/users/template/section/header')
{{-- <link rel="stylesheet" href="{{ asset('owlcarousel/assets/owl.carousel.min.css') }}"> --}}
{{-- <link rel="stylesheet" href="{{ asset('owlcarousel/assets/owl.theme.default.min.css') }}"> --}}
<link rel="stylesheet" href="{{ asset('css/post_feed.css') }}">
</head>

<body>
    <div class="post-hover-image_preview-container" style="display: none; position: absolute; pointer-events: none; transition: 0s; z-index: 99999;">
        <div class="">
            <img class="post-hover-image_preview" width="450" height="450" src="#" style="object-fit: contain; opacity: 1;">
        </div>
    </div>
    <div class="wrapper">

        {{-- TOP NAVIGATION --}}
        @include('pages/users/template/section/header_nav')

        <div class="main" style="height: 105vh;">

            {{-- SIDEABAR --}}
            @include('pages/users/template/section/sidebar')

            <div class="main-content">
                <div class="container-fluid container-xl">
                    <div class="row">
                        <!-- WRITE POST -->
                        <form id="form-post-content" action="{{ route('user.create_new_post') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="write_post_section" style="display: none;">
                                <div class="post_title pb-2">
                                    <label class="ff-primary-light fs-heading">
                                    <span class="text-gradient-primary">{{ !empty(Auth::guard('web')->user()->first_name) ? 'Hello, ' . Auth::guard('web')->user()->first_name . '!' : '' }}</span> What's on your mind?
                                    </label>
                                </div>

                                <div class="post_title_input pb-2">
                                    <textarea id="postTextarea" name="post_msg" class="form-control" rows="5" placeholder=""></textarea>
                                </div>
                                <div
                                    class="w-100 d-flex flex-column flex-xl-row justify-content-between align-items-center">
                                    <div
                                        class="w-75 d-flex justify-content-between justify-content-xl-start pb-2 align-items-center">
                                        {{-- <div class="post-control-icon">
                                            <i class="mdi mdi-attachment"></i>
                                        </div> --}}
                                        <div class="post-control-icon">
                                            <i class="mdi mdi-file-image-plus add_image_to_post"></i>
                                        </div>
                                        <div class="post-control-icon" data-bs-toggle="modal"
                                            data-bs-target="#insert_emojiinPost">
                                            <i class="mdi mdi-emoticon"></i>
                                        </div>
                                        {{-- <div class="post-control-icon">
                                            <i class="mdi mdi-delete"></i>
                                        </div> --}}

                                        <div class="post-control-icon">

                                            <div class="dropdown">
                                                <a class="set-post-status dropdown-toggle" href="#" role="button"
                                                    id="dropdownMenuLink" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <i class="mdi mdi-earth"></i> <small>Public</small>

                                                </a>
                                                <input id="post_visibility" type="hidden" name="post_visible"
                                                    value="public">
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                    <li>
                                                        <a id="set_post_visibility_public" class="dropdown-item"
                                                            href="#">
                                                            <small style="margin-top: -2px;">Public</small>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a id="set_post_visibility_private" class="dropdown-item"
                                                            href="#">
                                                            <small style="margin-top: -2px;">Private</small>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="post_action text-end">
                                        <button id="publish_post_btn" class="btn btn-primary post-button-submit">Publish
                                            Post</button>
                                    </div>
                                </div>
                                <div class="post_image_container">
                                </div>
                                <div class="post_attachment_preview d-flex flex-wrap p-1">
                                </div>
                            </div>
                        </form>
                        <!-- POST SECTION -->
                        <div class="posts_loader mt-5">
                            <div class="text-center slide-in">
                                <i class="spinner-border" style="font-size: 24px; width: 128px; height: 128px; color: rgba(255, 255, 255, 0.16);"></i>
                            </div>
                        </div>
                        {{-- <div class="posts_section" style="display: none;">


                        </div> --}}

                        <div class="col-12 post-section-container">
                        </div>
                        <div class="post_nextpage w-100 pt-4 d-flex justify-content-center">

                        </div>
                    </div>
                </div>
            </div>
            @include('pages/users/template/section/r-sidebar')
        </div>
    </div>
    {{-- Include bootstrap modal --}}
    @include('pages/users/template/modals/white-post-emoji')
    @include('pages/users/template/modals/post_feed/modal-delete-post')
    @include('pages/users/template/modals/post_feed/modal-view-reaction')
    {{-- Include custom user toast --}}
    @include('pages/users/template/section/user-toasts')

    {{-- SCRIPTS --}}

    @include('pages/users/template/section/scripts')
    @include('pages/users/template/section/scripts-var')


    <script src="https://unpkg.com/picmo@5.1.0/dist/umd/picmo.js"></script>
    <script src="https://unpkg.com/@picmo/popup-picker@5.1.0/dist/umd/picmo-popup.js"></script>
    <script src="https://unpkg.com/@picmo/renderer-twemoji@5.1.0/dist/umd/picmo-twemoji.js"></script>

    <script src="{{ asset('/js/post-feed.js?v=') }}@php echo time(); @endphp"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            /*
                Picmo emoji
            */
            const container = document.querySelector('#pickerNewemoji');
            const picker = picmo.createPicker({
                rootElement: container
            });

            let postTextarea = $('#postTextarea');

            picker.addEventListener('emoji:select', event => {
                postTextarea.val(postTextarea.val() + event.emoji);
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            @if (Session::has('status'))
                @switch(Session::get('status'))
                    @case('error')
                    var message = "{{ Session::get('message') }}";

                    toastr["error"](message);
                    @break

                    @case('success')
                    var message = "{{ Session::get('message') }}";
                    toastr["success"](message);
                    @break

                    @default
                @endswitch
            @endif
        });
    </script>

</body>

</html>
