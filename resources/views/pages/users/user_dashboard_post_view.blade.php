{{-- HEADER CONTAINS CSS LINKS --}}
@include('pages/users/template/section/header')
<link rel="stylesheet" href="{{ asset('owlcarousel/assets/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('owlcarousel/assets/owl.theme.default.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/post_view.css?v=1') }}">
<link rel="stylesheet" href="{{ asset('css/post_feed.css') }}">
</head>

<body>
    <div class="wrapper">

        {{-- TOP NAVIGATION --}}
        @include('pages/users/template/section/header_nav')

        <div class="main">

            {{-- SIDEABAR --}}
            @include('pages/users/template/section/sidebar')

            <div class="main-content" style="margin-top: 0;">
                <div class="container-fluid container-xl">
                    <div class="row">
                        <div class="col-12 px-2 px-lg-4 pt-2 pt-lg-4 pb-3 pb-lg-5 mt-4 mt-lg-2 gallery_container">
                            <div class="row" style="position: relative;">
                                <img src="{{ asset('img/transparent-rabbit.png') }}" style="position: absolute; top: -160px; left: -45px; width: 330px; transform: rotate(11deg);">
                                <div class="col-auto" style="z-index: 9;">
                                    <a href="#" class="me-2" onclick="window.history.back()">
                                        <button type="button" class="btn btn-primary" style="margin-top: -65px; z-index: 9;">
                                            <i class="mdi mdi-chevron-left text-light"></i> Back
                                        </button>
                                    </a>
                                </div>
                                @if (Auth::guard('web')->user()->uuid == $data['postData']->first()->uuid)
                                <div class="col-auto ms-auto">
                                    <div class="dropdown open" style="font-size: 1.6rem;">
                                        <button class="custom-post-settings dropdown-toggle dt-custombutton" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                            <i class="mdi mdi-dots-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end dm-custom" aria-labelledby="triggerId" style="z-index: 2">
                                            <button class="dropdown-item" data-post_id="{{ $data['postData']->first()->post_id }}">
                                                <small><i class="mdi mdi-circle-edit-outline"></i> Update</small>
                                            </button>
                                            <button class="dropdown-item delete_this_post" data-post_id="{{ $data['postData']->first()->post_id }}">
                                                <small><i class="mdi mdi-delete-outline"></i> Delete</small>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                            <div class="col-12 mb-3">
                                @if ($data['postAttachments']->count() > 0)
                                    <div class="owl-carousel owl-theme w-100 justify-content-center mt-5">
                                        <?php $arrFormat = ['mp4', 'webm', 'ogg']; ?>
                                        @foreach ($data['postAttachments']->get() as $row)
                                            <div class="item w-100 text-center">
                                                @if (in_array($row->file_extension, $arrFormat))
                                                    <video class="mx-auto videoFull" src="{{ asset($row->file_path) }}"
                                                        type="video/{{ $row->file_extension }}" controls="true"
                                                        muted></video>
                                                @else
                                                    <img class="mx-auto imgFull" src="{{ asset($row->file_path) }}">
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="col-12">
                                <div class="d-flex flex-wrap">
                                    <div class="post_author_details col-12 d-flex flex-row align-items-center">
                                        <div class="postaut-image-container">
                                            <img src="{{ asset(($data['postAuthor']->first()->profile_image != null) ? $data['postAuthor']->first()->profile_image : 'my_custom_symlink_1/user.png') }}"
                                                alt="" srcset="">
                                        </div>
                                        <div class="postaut-text-container d-flex flex-column ps-2 fs-text">
                                            <div>
                                                <div>
                                                    <a class="pf-user-name text-dark" href="{{ url('/') }}/view/members-details?rid={{ $data['postAuthor']->first()->uuid }}">
                                                        {{ $data['postAuthor']->first()->first_name }}
                                                        {{ $data['postAuthor']->first()->last_name }}
                                                    </a>
                                                </div>
                                                <div>
                                                    <small>
                                                        @if ($data['postAuthor']->first()->uuid != Auth::guard('web')->user()->uuid)
                                                            @if ($data['userFollowed']->count() > 0)
                                                                <span class="badge bg-success"> Followed </span>
                                                            @endif
                                                            @if ($data['userFollower']->count() > 0)
                                                                <span class="badge bg-primary"> Follower </span>
                                                            @endif
                                                        @endif
                                                    </small>
                                                </div>
                                            </div>
                                            <small class="post_date fs-extra-small">
                                            </small>
                                        </div>
                                    </div>
                                    <div class="post_message col-12 mb-2 mx-2 fs-text">
                                        {{ $data['postData']->first()->post_message }}
                                    </div>
                                    {{-- If post is share get share images --}}
                                    @if ($data['shareContent'] !== null)
                                        @include('pages/users/template/section/post-view/share-preview')
                                    @endif
                                    <div class="user_post_reaction post_reaction_comments_count col-12 mb-2 text-end">
                                        <div class="d-inline pe-3" data-postid="{{ $data['postData']->first()->post_id }}">
                                            <span class="me-2">
                                                <svg width="20px" height="20px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <g>
                                                        <path fill="none" d="M0 0h24v24H0z"></path>
                                                        <path fill="#0072ff" color="#0072ff" d="M14.6 8H21a2 2 0 0 1 2 2v2.104a2 2 0 0 1-.15.762l-3.095 7.515a1 1 0 0 1-.925.619H2a1 1 0 0 1-1-1V10a1 1 0 0 1 1-1h3.482a1 1 0 0 0 .817-.423L11.752.85a.5.5 0 0 1 .632-.159l1.814.907a2.5 2.5 0 0 1 1.305 2.853L14.6 8zM7 10.588V19h11.16L21 12.104V10h-6.4a2 2 0 0 1-1.938-2.493l.903-3.548a.5.5 0 0 0-.261-.571l-.661-.33-4.71 6.672c-.25.354-.57.644-.933.858zM5 11H3v8h2v-8z"></path>
                                                    </g>
                                                </svg>
                                                <span>
                                                    {{ $data['postData']->first()->PostReaction->where('reaction', 1)->count() }}
                                                </span>
                                            </span>
                                            <span class="me-2">
                                                <svg width="20px" height="20px" viewBox="0 0 1500 1500" xmlns="http://www.w3.org/2000/svg">
                                                    <path class="st0" d="M542.7 1092.6H377.6c-13 0-23.6-10.6-23.6-23.6V689.9c0-13 10.6-23.6 23.6-23.6h165.1c13 0 23.6 10.6 23.6 23.6V1069c0 13-10.6 23.6-23.6 23.6zM624 1003.5V731.9c0-66.3 18.9-132.9 54.1-189.2 21.5-34.4 69.7-89.5 96.7-118 6-6.4 27.8-25.2 27.8-35.5 0-13.2 1.5-34.5 2-74.2.3-25.2 20.8-45.9 46-45.7h1.1c44.1 1 58.3 41.7 58.3 41.7s37.7 74.4 2.5 165.4c-29.7 76.9-35.7 83.1-35.7 83.1s-9.6 13.9 20.8 13.3c0 0 185.6-.8 192-.8 13.7 0 57.4 12.5 54.9 68.2-1.8 41.2-27.4 55.6-40.5 60.3-2.6.9-2.9 4.5-.5 5.9 13.4 7.8 40.8 27.5 40.2 57.7-.8 36.6-15.5 50.1-46.1 58.5-2.8.8-3.3 4.5-.8 5.9 11.6 6.6 31.5 22.7 30.3 55.3-1.2 33.2-25.2 44.9-38.3 48.9-2.6.8-3.1 4.2-.8 5.8 8.3 5.7 20.6 18.6 20 45.1-.3 14-5 24.2-10.9 31.5-9.3 11.5-23.9 17.5-38.7 17.6l-411.8.8c-.2 0-22.6 0-22.6-30z"></path>
                                                    <path class="st0" d="M750 541.9C716.5 338.7 319.5 323.2 319.5 628c0 270.1 430.5 519.1 430.5 519.1s430.5-252.3 430.5-519.1c0-304.8-397-289.3-430.5-86.1z"></path>
                                                    <ellipse class="st1" cx="750.2" cy="751.1" rx="750" ry="748.8"></ellipse>
                                                    <g>
                                                        <path class="st3" d="M755.3 784.1H255.4s13.2 431.7 489 455.8c6.7.3 11.2.1 11.2.1 475.9-24.1 489-455.9 489-455.9H755.3z"></path>
                                                        \
                                                        <path class="st4" d="M312.1 991.7s174.8-83.4 435-82.6c129 .4 282.7 12 439.2 83.4 0 0-106.9 260.7-436.7 260.7-329 0-437.5-261.5-437.5-261.5z"></path>
                                                        <path class="st5" d="M1200.2 411L993 511.4l204.9 94.2"></path>
                                                        <path class="st5" d="M297.8 411L505 511.4l-204.9 94.2"></path>
                                                    </g>
                                                </svg>
                                                <span>
                                                    {{ $data['postData']->first()->PostReaction->where('reaction', 2)->count() }}
                                                </span>
                                            </span>
                                            <span>
                                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="20px" height="20px" viewBox="0 0 544.582 544.582" style="enable-background:new 0 0 544.582 544.582;" xml:space="preserve">
                                                    <g>
                                                        <path fill="#ff0025" color="#ff0025" d="M448.069,57.839c-72.675-23.562-150.781,15.759-175.721,87.898C247.41,73.522,169.303,34.277,96.628,57.839C23.111,81.784-16.975,160.885,6.894,234.708c22.95,70.38,235.773,258.876,263.006,258.876c27.234,0,244.801-188.267,267.751-258.876C561.595,160.732,521.509,81.631,448.069,57.839z"></path>
                                                    </g>
                                                </svg>
                                                <span>
                                                    {{ $data['postData']->first()->PostReaction->where('reaction', 3)->count() }}
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mt-2 d-flex flex-row justify-content-start ff-primary-light">
                                    <button type="button" class="btn btn-secondary react-like-btn post-react-btn" data-react="like" data-post_id="${posts.post_id}" style="width: 64px; margin-right: 5px;">
                                        <svg width="20px" height="20px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <g>
                                                <path fill="none" d="M0 0h24v24H0z"></path>
                                                <path fill="#0072ff" color="#0072ff" d="M14.6 8H21a2 2 0 0 1 2 2v2.104a2 2 0 0 1-.15.762l-3.095 7.515a1 1 0 0 1-.925.619H2a1 1 0 0 1-1-1V10a1 1 0 0 1 1-1h3.482a1 1 0 0 0 .817-.423L11.752.85a.5.5 0 0 1 .632-.159l1.814.907a2.5 2.5 0 0 1 1.305 2.853L14.6 8zM7 10.588V19h11.16L21 12.104V10h-6.4a2 2 0 0 1-1.938-2.493l.903-3.548a.5.5 0 0 0-.261-.571l-.661-.33-4.71 6.672c-.25.354-.57.644-.933.858zM5 11H3v8h2v-8z"></path>
                                            </g>
                                        </svg>
                                        <span class="react-counter-text" style="${react_count[0] <= 0 ? 'display: none;' : ''}">${react_count[0]}</span>
                                    </button>
                                    <button type="button" class="btn btn-secondary react-haha-btn post-react-btn" data-react="haha" data-post_id="${posts.post_id}" style="width: 64px; margin-right: 5px;">
                                        <svg width="20px" height="20px" viewBox="0 0 1500 1500" xmlns="http://www.w3.org/2000/svg">
                                            <path class="st0" d="M542.7 1092.6H377.6c-13 0-23.6-10.6-23.6-23.6V689.9c0-13 10.6-23.6 23.6-23.6h165.1c13 0 23.6 10.6 23.6 23.6V1069c0 13-10.6 23.6-23.6 23.6zM624 1003.5V731.9c0-66.3 18.9-132.9 54.1-189.2 21.5-34.4 69.7-89.5 96.7-118 6-6.4 27.8-25.2 27.8-35.5 0-13.2 1.5-34.5 2-74.2.3-25.2 20.8-45.9 46-45.7h1.1c44.1 1 58.3 41.7 58.3 41.7s37.7 74.4 2.5 165.4c-29.7 76.9-35.7 83.1-35.7 83.1s-9.6 13.9 20.8 13.3c0 0 185.6-.8 192-.8 13.7 0 57.4 12.5 54.9 68.2-1.8 41.2-27.4 55.6-40.5 60.3-2.6.9-2.9 4.5-.5 5.9 13.4 7.8 40.8 27.5 40.2 57.7-.8 36.6-15.5 50.1-46.1 58.5-2.8.8-3.3 4.5-.8 5.9 11.6 6.6 31.5 22.7 30.3 55.3-1.2 33.2-25.2 44.9-38.3 48.9-2.6.8-3.1 4.2-.8 5.8 8.3 5.7 20.6 18.6 20 45.1-.3 14-5 24.2-10.9 31.5-9.3 11.5-23.9 17.5-38.7 17.6l-411.8.8c-.2 0-22.6 0-22.6-30z"></path>
                                            <path class="st0" d="M750 541.9C716.5 338.7 319.5 323.2 319.5 628c0 270.1 430.5 519.1 430.5 519.1s430.5-252.3 430.5-519.1c0-304.8-397-289.3-430.5-86.1z"></path>
                                            <ellipse class="st1" cx="750.2" cy="751.1" rx="750" ry="748.8"></ellipse>
                                            <g>
                                                <path class="st3" d="M755.3 784.1H255.4s13.2 431.7 489 455.8c6.7.3 11.2.1 11.2.1 475.9-24.1 489-455.9 489-455.9H755.3z"></path>
                                                <path class="st4" d="M312.1 991.7s174.8-83.4 435-82.6c129 .4 282.7 12 439.2 83.4 0 0-106.9 260.7-436.7 260.7-329 0-437.5-261.5-437.5-261.5z"></path>
                                                <path class="st5" d="M1200.2 411L993 511.4l204.9 94.2"></path>
                                                <path class="st5" d="M297.8 411L505 511.4l-204.9 94.2"></path>
                                            </g>
                                        </svg>
                                        <span class="react-counter-text" style="${react_count[1] <= 0 ? 'display: none;' : ''}">${react_count[1]}</span>
                                    </button>
                                    <button type="button" class="btn btn-secondary react-love-btn post-react-btn" data-react="heart" data-post_id="${posts.post_id}" style="width: 64px; margin-right: 5px;">
                                        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="20px" height="20px" viewBox="0 0 544.582 544.582" style="enable-background:new 0 0 544.582 544.582;" xml:space="preserve">
                                            <g>
                                                <path fill="#ff0025" color="#ff0025" d="M448.069,57.839c-72.675-23.562-150.781,15.759-175.721,87.898C247.41,73.522,169.303,34.277,96.628,57.839C23.111,81.784-16.975,160.885,6.894,234.708c22.95,70.38,235.773,258.876,263.006,258.876c27.234,0,244.801-188.267,267.751-258.876C561.595,160.732,521.509,81.631,448.069,57.839z"></path>
                                            </g>
                                        </svg>
                                        <span class="react-counter-text" style="${react_count[2] <= 0 ? 'display: none;' : ''}">${react_count[2]}</span>
                                    </button>
                                    <button type="button" class="btn btn-secondary show_comment_section" data-post_id="${posts.post_id}" data-comments_count="${comment_count}" style="width: 64px;"><i class="bi bi-chat-quote-fill"></i> ${comment_count}</button>
                                    <div class="ms-auto">
                                        <button type="button" class="mini-mobile-display btn btn-secondary show_reply_section" data-post_id="${posts.post_id}" data-comments_count="${comment_count}"><i class="bi bi-reply-fill"></i></button>
                                        <button type="button" class="non-mobile-display btn btn-secondary show_reply_section" data-post_id="${posts.post_id}" data-comments_count="${comment_count}"><i class="bi bi-reply-fill"></i> Reply</button>
                                        <button type="button" class="non-mobile-display btn btn-secondary share_this_post" data-post_id="${posts.post_id}" style="width: 64px;"><i class="bi bi-share-fill"></i></button>
                                        <button type="button" class="non-mobile-display btn btn-secondary view_this_post" data-post_id="${posts.post_id}" style="width: 64px;"><i class="bi bi-hash"></i></button>
                                    </div>
                                </div>
                                <div class="pv-comment-container-{{ $data['postData']->first()->post_id }} pv-check-comment-section" data-post_id="{{ $data['postData']->first()->post_id }}"></div>
                                <div class="pv-writecomment-container-{{ $data['postData']->first()->post_id }} px-3 pb-2 px-lg-4 pb-lg-2">
                                    <div class="d-flex flex-row align-items-center">
                                        <div class="pe-3">
                                            <button class="comment-act-btn cab-default"><i class="mdi mdi-plus-circle"></i></button>
                                        </div>
                                        <div class="w-100">
                                            <input type="text" class="eja_{{ $data['postData']->first()->post_id }}" value=""/>
                                        </div>
                                        <div class="ps-3">
                                            <button class="submit_comment comment-act-btn cab-primary" data-post_id="{{ $data['postData']->first()->post_id }}"> <i class="mdi mdi-send"></i> </button>
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

    {{-- Include bootstrap modal --}}
    @include('pages/users/template/modals/white-post-emoji')
    @include('pages/users/template/modals/post_feed/modal-delete-post')
    @include('pages/users/template/modals/post_feed/modal-view-reaction')
    @include('pages.users.template.modals.post_feed.modal-share-post')
    {{-- Include custom user toast --}}
    @include('pages/users/template/section/user-toasts')

    {{-- SCRIPTS --}}
    @include('pages/users/template/section/scripts')
    @include('pages/users/template/section/scripts-var')


    <script src="https://unpkg.com/picmo@5.1.0/dist/umd/picmo.js"></script>
    <script src="https://unpkg.com/@picmo/popup-picker@5.1.0/dist/umd/picmo-popup.js"></script>
    <script src="https://unpkg.com/@picmo/renderer-twemoji@5.1.0/dist/umd/picmo-twemoji.js"></script>

    <script src="{{ asset('owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/post_view.js?v=5') }}"></script>

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

            /* Owl Carousel 2 */
            $('.owl-carousel').owlCarousel({
                items: 1,
                center: true,
                video: true,
                dots: false
            });

            var videoFull = $('.videoFull');
            videoFull.removeAttr('muted');
            videoFull.attr('volume', 0.5);;

            /* Convert date */
            var testDateUtc = moment.utc("{{ $data['postData']->first()->created_at }}");
            var localDate = moment(testDateUtc).local();
            var postDateFormatted = localDate.format("MMMM DD YYYY - hh:mm A");
            $('.post_date').html('<small>' + postDateFormatted + '</small>');

            $('.show_comment_section').click();

            var sharedPDate = moment.utc(window.shared_post_created_date);
            var shareLocal = moment(sharedPDate).local();
            var newShareDate = shareLocal.format("MMMM DD YYYY - hh:mm A");
            $('.post_date_shared').html('<small>' + newShareDate + '</small>');

        });


    </script>
</body>



</html>
