{{-- HEADER CONTAINS CSS LINKS --}}
@include('pages/users/template/section/header')
<link rel="stylesheet" href="{{ asset('css/post_view.css?v=1') }}">
<link rel="stylesheet" href="{{ asset('css/post_feed.css') }}">
</head>

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
                        <div class="col-12 px-0 px-lg-4 pt-0 pt-lg-4 pb-0 pb-lg-4 gallery_container d-flex flex-wrap">
                            <div class="p-3 col-12">
                                <div class="row d-flex">
                                    <style>
                                        .profile-icon {
                                            margin: 1rem;
                                        }
                                        .profile-icon > i{
                                            margin-right: 9px;
                                            font-size: 1.1rem;
                                        }
                                        .profile-icon > label{
                                            font-size: 1.1rem;
                                        }
                                        .vm-profile-image {
                                            width: 40%;
                                            border-radius:100%;
                                        }
                                        .post-prof-image {
                                            width: 30px;
                                            height: 30px;
                                            border-radius: 50%;
                                        }
                                        .post-button-container {
                                            padding: 0.2rem 1rem 0.2rem 1rem;
                                            border-radius: 50px;
                                            cursor: pointer;

                                        }
                                        .post-button-container:hover {
                                            /* transition: all ease-in-out 0.1s; */
                                            /* transform: scale(1.1); */
                                        }
                                        .pst-con-like:hover {
                                            background-color: rgb(230, 230, 230);
                                            transition: all ease-in-out 0.2s;
                                            -webkit-transition: all ease-in-out 0.2s;
                                            -moz-transition: all ease-in-out 0.2s;
                                            -ms-transition: all ease-in-out 0.2s;
                                            transform: scale(1.1);
                                            -webkit-transform: scale(1.1);
                                            -ms-transform: scale(1.1);
                                            -moz-transform: scale(1.1);
                                        }
                                        .pst-con-comment:hover {
                                            background-color: rgb(78, 115, 226);
                                            transition: all ease-in-out 0.2s;
                                            -webkit-transition: all ease-in-out 0.2s;
                                            -moz-transition: all ease-in-out 0.2s;
                                            -ms-transition: all ease-in-out 0.2s;
                                            transform: scale(1.1);
                                            -webkit-transform: scale(1.1);
                                            -ms-transform: scale(1.1);
                                            -moz-transform: scale(1.1);
                                        }
                                        .pst-con-like {
                                            color: rgb(97, 97, 97);
                                            background-color: #dfdfdf;
                                            font-size: 0.9rem;
                                        }
                                        /* #40ac16
                                        rgb(255, 255, 255)
                                         */
                                        .pst-con-comment {
                                            color: #fff;
                                            background-color: rgb(65, 105, 225);
                                            font-size: 0.9rem;
                                        }
                                        .text-posts {
                                            white-space: pre-line;
                                            font-size: 0.97rem;
                                        }
                                    </style>
                                    <div class="col-12 col-md-4">
                                        {{-- Include user profile card --}}
                                        @include('pages/users/user_profile/section/profile_user_card')
                                    </div>
                                    <div class="col-12 col-md-8 mt-5 mt-md-0">
                                        <div class="w-100 d-flex flex-column justify-content-start  mb-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    {{-- Profile navigation --}}
                                                    <ul class="nav nav-pills">
                                                        <li class="nav-item me-1 me-lg-3">
                                                            <a class="nav-link" aria-current="page" href="{{ route('user.view_members') }}?rid={{ $data['gmd']->uuid }}">Posts</a>
                                                        </li>
                                                        <li class="nav-item me-1 me-lg-3">
                                                            <div>
                                                            <a class="nav-link" aria-current="page" href="#">Recent viewed post</a>
                                                        </li>
                                                        <li class="nav-item me-1 me-lg-3">
                                                            <a class="nav-link active" aria-current="page" href="{{ route('user.view_comments') }}?rid={{ $data['gmd']->uuid }}">Comments</a>
                                                        </li>
                                                        <li class="nav-item me-1 me-lg-3">
                                                            <a class="nav-link" aria-current="page" href="{{ route('user.view_reacts') }}?rid={{ $data['gmd']->uuid }}">Reacts</a>
                                                        </li>
                                                        <li class="nav-item me-1 me-lg-3">
                                                            <a class="nav-link" aria-current="page" href="{{ route('user.view_follows') }}?rid={{ $data['gmd']->uuid }}">Follows</a>
                                                        </li>
                                                        <li class="nav-item me-1 me-lg-3">
                                                            <a class="nav-link" aria-current="page" href="{{ route('user.view_members_pets') }}?rid={{ $data['gmd']->uuid }}">Pets</a>
                                                        </li>
                                                        {{-- <li class="nav-item me-1 me-lg-3">
                                                            <a class="nav-link" aria-current="page" href="{{ route('user.view_user_album') }}?rid={{ $data['gmd']->uuid }}">Album</a>
                                                        </li>
                                                        <li class="nav-item me-1 me-lg-3">
                                                            <a class="nav-link" aria-current="page" href="{{ route('user.view_members_advertisements') }}?rid={{ $data['gmd']->uuid }}">Ads</a>
                                                        </li> --}}
                                                    </ul>

                                                </div>
                                            </div>
                                        </div>
                                        <style>
                                            .user-comment-link>div:hover {
                                                background-color: #f8f8f8 !important;
                                            }
                                            .comment-container {
                                                padding-top: 12px;
                                            }
                                            .user_comment_description {
                                                /* position: ; */
                                                padding: 6px 15px;
                                                padding-bottom: 13px;
                                                border-radius: 10px;
                                                background-color: #dfdfdf;
                                                /* margin-top: -5px; */
                                                margin-left: -15px;
                                                z-index: 999;
                                            }
                                            .comment-container {
                                                margin-top: -10px;
                                            }
                                        </style>
                                        <div class="w-100">
                                            <div class="usersComments-section">
                                                {{-- Post template --}}
                                                {{-- <a class="user-comment-link text-dark" href="#">
                                                    <div class="pv-comment-container pv-comment-container-test-uuid pv-check-comment-section px-3 py-3 px-lg-4 py-lg-4 ms-3" data-post_id="test-uuid">
                                                        <div class="user_comment_description">
                                                            <small>User commented on test-poster's post</small>
                                                        </div>
                                                        <div class="comment-container vrrr d-flex flex-column mb-3 vrrr-17" data-utcdate="2023-01-24T02:26:37.000000Z">
                                                            <div class="mb-2 d-flex flex-row justify-content-between">
                                                                <div class="pf-user-details d-flex flex-row align-items-center">
                                                                    <div class="pf-user-image me-2">
                                                                        <img src="test-src" alt="">
                                                                    </div>
                                                                    <div>
                                                                        <div class="pf-user-name">
                                                                            test-name
                                                                        </div>
                                                                        <div class="pf-time-count">
                                                                            <small>
                                                                                <span class="badge rounded-pill bg-success">test-days ago</span>
                                                                            </small>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="pf-user-comment">
                                                                test-message
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a> --}}
                                            </div>
                                        </div>
                                        <div class="w-100 text-center">
                                            <button class="btn btn-primary show-more">Show More</button>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('pages/users/template/section/r-sidebar')
        </div>
    </div>
    {{-- Chat window --}}
    @include('pages/users/template/modals/modal-chat-window')
    {{-- Include custom user toast --}}
    @include('pages/users/template/section/user-toasts')
</body>

{{-- SCRIPTS --}}
@include('pages/users/template/section/scripts')
@include('pages/users/template/section/scripts-var')
<script src="{{ asset('js/members_js/members_comments.js?v=2') }}"></script>

<script src="https://unpkg.com/picmo@5.1.0/dist/umd/picmo.js"></script>
<script src="https://unpkg.com/@picmo/popup-picker@5.1.0/dist/umd/picmo-popup.js"></script>
<script src="https://unpkg.com/@picmo/renderer-twemoji@5.1.0/dist/umd/picmo-twemoji.js"></script>

<script type="text/javascript">
    $(document).ready(function () {

    });

</script>

</html>


