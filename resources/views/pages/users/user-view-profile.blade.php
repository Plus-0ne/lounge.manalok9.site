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
                                <div class="card d-shadows-primary">
                                    <div class="card-body">
                                        {{-- Profile navigation --}}
                                        <ul class="nav nav-pills">
                                            <li class="nav-item me-1 me-lg-3">
                                                <a class="nav-link active" aria-current="page" href="{{ route('user.view_members') }}?rid={{ $data['gmd']->uuid }}">Posts</a>
                                            </li>
                                            <li class="nav-item me-1 me-lg-3">
                                                <a class="nav-link" aria-current="page" href="#">Recent viewed post</a>
                                            </li>
                                            <li class="nav-item me-1 me-lg-3">
                                                <a class="nav-link" aria-current="page" href="{{ route('user.view_comments') }}?rid={{ $data['gmd']->uuid }}">Comments</a>
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
                                .user_image img {
                                    width: 39px;
                                    height: 39px;
                                    border-radius: 100%;
                                }
                                .user_post_header {
                                    margin-bottom: 0.55rem;
                                }
                                .user_fullname {
                                    font-size: 15px;
                                }
                                .user_post_reaction {
                                    font-size: 12px;
                                }
                                .user_post_body , .user_post_comments {
                                    font-size: 14px;
                                }
                                .post_date_label {
                                    font-size: 12px;
                                    color: rgb(107, 107, 107);
                                }
                                .u_reaction_control {
                                    position: relative;
                                }
                                .u_reaction_container {
                                    position: absolute;
                                    width: 160px;
                                    display: none;



                                    margin-top: -2px;
                                }
                                .ubackg_reaction {
                                    background-color: rgb(235, 235, 235);
                                    border-radius: 20px;
                                    padding: 0.4rem;
                                    width: 160px;
                                    display: flex;
                                    flex-direction: row;
                                    justify-content: space-evenly;
                                }
                                .ubackg_reaction > span > svg:hover {
                                    cursor: pointer;
                                    transition: all ease-in-out 0.3s;
                                    -webkit-transition: all ease-in-out 0.3s;
                                    -ms-transition: all ease-in-out 0.3s;
                                    transform: scale(1.1);
                                }
                                .hvr_reaction {
                                    cursor: pointer;
                                }
                                .user_post_control {
                                    color: rgb(107, 107, 107);
                                    font-size: 18px;
                                    cursor: pointer;
                                }
                                .user_post_body {
                                    white-space: pre;
                                    white-space: pre-line;
                                    word-break: break-all;
                                }
                                .cus-disabled {
                                    cursor: not-allowed;
                                    color: #a5a5a5;
                                }
                                .post_attach_container {
                                    margin-right: 5px;
                                    border: 1px solid rgb(202, 202, 202);
                                    /* border-radius: 6px; */
                                    padding: 3px;
                                }
                                .post_attach {
                                    max-width: 200px;
                                    width: 100%;
                                    max-height: 200px;
                                    height: 100%;
                                }
                                .post_attach img {
                                    object-fit: contain;
                                    max-width: 200px;
                                    width: 100%;
                                    max-height: 200px;
                                    height: 100%;
                                }
                            </style>
                            <div class="w-100">
                                <div class="usersPosts-section">
                                    {{-- Post template --}}

                                </div>
                                <div class="post_nextpage w-100 pt-4 d-flex justify-content-center">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('pages/users/template/section/r-sidebar')
        </div>
    </div>
    {{-- Modals --}}
    @include('pages.users.user_profile.section.modal-qrcod')
    {{-- Include custom user toast --}}
    @include('pages/users/template/section/user-toasts')
    @include('pages/users/template/modals/post_feed/modal-view-reaction')
</body>

{{-- SCRIPTS --}}
@include('pages/users/template/section/scripts')
@include('pages/users/template/section/scripts-var')
<script src="{{ asset('js/members_js/members_profile.js?v=3') }}"></script>

<script src="https://unpkg.com/picmo@5.1.0/dist/umd/picmo.js"></script>
<script src="https://unpkg.com/@picmo/popup-picker@5.1.0/dist/umd/picmo-popup.js"></script>
<script src="https://unpkg.com/@picmo/renderer-twemoji@5.1.0/dist/umd/picmo-twemoji.js"></script>

<script type="text/javascript">
    $(document).ready(function () {

        /*
            Picmo emoji
        */
        const container = document.querySelector('.emojiContainer');
        const picker = picmo.createPicker({
            rootElement: container,
            showPreview: false,
            showRecents: false,
            showSearch:false
        });

        let postTextarea = $('#message-text');

        picker.addEventListener('emoji:select', event => {
            postTextarea.val(postTextarea.val() + event.emoji);
        });

        $(document).on('click','#emojiBtn', function () {

            const emojiContainer = $('.emojiContainer');

            emojiContainer.toggle();

        });

        /* Hover show reaction buttons */
        $(document).on({
            mouseenter: function () {
                var hover_button = $(this);
                var reaction_buttons = hover_button.parent().find('.u_reaction_container');
                /* On hover show all reaction buttons */
                reaction_buttons.css('display', 'flex');
                reaction_buttons.removeClass('animate__animated animate__fadeIn');
                reaction_buttons.addClass('animate__animated animate__fadeIn');
            },
        },'.hvr_reaction , .u_reaction_container');
        $(document).on('mouseleave','.u_reaction_container', function () {
            var hover_button = $(this);
            var reaction_buttons = hover_button.parent().find('.u_reaction_container');
            /* On mouse leave hide all reaction buttons */
            reaction_buttons.css('display', 'none');
        });

        $('body').on('touchmove', function () {
            $('.u_reaction_container').css('display', 'none');
        });

        $(document).on('mouseleave','.hvr_reaction', function () {
            var hover_button = $(this);
            var reaction_buttons = hover_button.parent().find('.u_reaction_container');
            /* On mouse leave hide all reaction buttons */
            reaction_buttons.css('display', 'none');
        });

        $(document).on('scroll', function () {
            $('.u_reaction_container').css('display', 'none');
        });


    });

</script>

</html>


