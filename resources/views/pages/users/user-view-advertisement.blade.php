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
                        <div class="col-12 px-4 pt-4 pb-5 main-content-container d-flex flex-wrap">
                            {{-- <div class="p-3 col-12">
                                <h5>
                                    Profile
                                </h5>
                            </div>
                            <div class="col-12">
                                <hr>
                            </div> --}}
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
                                        .userad-prof-image {
                                            width: 30px;
                                            height: 30px;
                                            border-radius: 50%;
                                        }
                                        .userad-button-container {
                                            padding: 0.2rem 1rem 0.2rem 1rem;
                                            border-radius: 50px;
                                            cursor: pointer;

                                        }
                                        .userad-button-container:hover {
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
                                        .text-userads {
                                            white-space: pre-line;
                                            font-size: 0.97rem;
                                        }
                                    </style>
                                    <div class="col-12 col-md-4">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-center">
                                                    @if (!empty($data['gmd']->profile_image))
                                                        <img class="vm-profile-image" src="{{ asset($data['gmd']->profile_image) }}" alt="{{ $data['gmd']->first_name }}'s profile image">
                                                    @else
                                                        <img class="vm-profile-image" src="{{ asset('my_custom_symlink_1/user.png') }}">
                                                    @endif
                                                </div>
                                                <div class="d-flex justify-content-center mt-3">
                                                    <div class="profile-icon d-flex flex-column justify-content-center text-center">
                                                        <label class="like_cccc"></label>
                                                        <span class="badge rounded-pill bg-success">Likes</span>
                                                    </div>
                                                    <div class="profile-icon d-flex flex-column justify-content-center text-center">
                                                        <label class="followers_ccc"></label>
                                                        <span class="badge rounded-pill bg-primary">Followers</span>
                                                    </div>
                                                </div>
                                                {{-- BASIC DETAILS --}}
                                                <div class="d-flex flex-column justify-content-center mt-3 text-center">
                                                    <h5>
                                                        <strong class="lead">
                                                            {{ $data['gmd']->first_name }} {{ $data['gmd']->last_name }} {{ $data['gmd']->middle_initial }}
                                                        </strong>
                                                    </h5>
                                                    <label>
                                                        {{ Carbon::createFromFormat('Y-m-d', $data['gmd']->birth_date)->toFormattedDateString() }}
                                                    </label>
                                                    <label>
                                                        {{ Str::ucfirst($data['gmd']->gender) }}
                                                    </label>
                                                </div>
                                                <div id="followerBtn-container" class="pt-3 pb-1">
                                                    @if ($data['iFollowed']->count() > 0)
                                                        <a class="btn btn-danger w-100" href="{{ route('user.follow_user') }}?id={{ $data['gmd']->uuid }}&status=unfollow">
                                                            Unfollow
                                                        </a>
                                                    @else
                                                        <a class="btn btn-success w-100" href="{{ route('user.follow_user') }}?id={{ $data['gmd']->uuid }}&status=follow">
                                                            Follow
                                                        </a>
                                                    @endif
                                                </div>
                                                <div id="messageBtn-container" class="pb-3 pt-1">
                                                    <a class="btn btn-info w-100" href="#">
                                                        Message
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-8 mt-5 mt-md-0">
                                        <div class="w-100 d-flex flex-column justify-content-start  mb-4">
                                            <div class="card">
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
                                                            <a class="nav-link" aria-current="page" href="{{ route('user.view_follows') }}?rid={{ $data['gmd']->uuid }}">Follows</a>
                                                        </li>
                                                        <li class="nav-item me-1 me-lg-3">
                                                            <a class="nav-link" aria-current="page" href="{{ route('user.view_user_album') }}?rid={{ $data['gmd']->uuid }}">Album</a>
                                                        </li>
                                                        <li class="nav-item me-1 me-lg-3">
                                                            <a class="nav-link" aria-current="page" href="{{ route('user.view_members_advertisements') }}?rid={{ $data['gmd']->uuid }}">Ads</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="w-100">
                                            <div class="usersAds-section">

                                            </div>
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

{{-- Include custom user toast --}}
@include('pages/users/template/section/user-toasts')


    {{-- Chat window --}}
    @include('pages/users/template/modals/modal-chat-window')

</body>

{{-- SCRIPTS --}}
@include('pages/users/template/section/scripts')
@include('pages/users/template/section/scripts-var')
<script src="{{ asset('js/members_js/members_profile.js?v=1') }}"></script>

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

        /*
        ADVERTISEMENTS
        */
        var page = 1;
        var rid = window.rid;

        function getMemberAdvertisements(rid,pg) {
            // var page = page;
            var rid = rid;

            $.ajax({
                type: "GET",
                url: "/ajax/members-advertisements",
                data: {
                    'rid': rid,
                    'pg': pg
                },
                success: function(response) {
                    var res = response;

                    $('.load_userads_container').remove();

                    if (res.status == 'success') {
                        $.each(res.mem_ad.data, function(row, value) {

                            /* CONVERT DATE */
                            var str = value.created_at;
                            var date = moment(str);
                            var daate = date.utc().format('YYYY-MM-DD hh:mm:ss A');
                            /* Profile image */
                            if (value.members_model.profile_image == null) {
                                var profImage = window.assetUrl+'my_custom_symlink_1/user.png';
                            }
                            else {
                                var profImage = window.assetUrl+''+value.members_model.profile_image;
                            }

                            $('.usersAds-section').append('\
                            <div class="card w-100 mb-3">\
                                <div class="card-body">\
                                    <div class="userad-heading mb-2">\
                                        <div class="userad-header-section1 d-flex">\
                                            <div class="userad-heading-image">\
                                                <img class="userad-prof-image" src="'+profImage+'" alt="'+value.members_model.first_name+'\'s profile image">\
                                            </div>\
                                            <div class="userad-heading-name align-self-center ms-2">\
                                            '+value.members_model.first_name+'\
                                            </div>\
                                        </div>\
                                        <div class="userad-header-section2 d-flex flex-row mt-2">\
                                            <small>\
                                                '+daate+'\
                                            </small>\
                                        </div>\
                                    </div>\
                                    <div class="title-userads py-2" style="display:block;">\
                                        <h5 class="fw-bold">\
                                            '+value.title+'\
                                        </h5>\
                                    </div>\
                                    <div class="text-userads py-2" style="display:block; white-space: pre-wrap;">'+value.message+'</div>\
                                    <div class="img-userads text-center py-2" style="display:block;">\
                                        '+ ((value.file_path != null) ? '<img class="shadow p-0" style="max-height: 400px;" src="{{ asset('') }}' + value.file_path + '">' : '') +'\
                                    </div>\
                                </div>\
                            </div>');
                        });

                        if (res.mem_ad.total > 5) {
                            $('.usersAds-section').append('\
                            <div class="text-center load_userads_container">\
                                <button id="load_more_userads" class="btn btn-primary">Show more</button>\
                            </div>');
                        }
                    }
                    else
                    {
                        $('.usersAds-section').append('\
                        <div class="text-center">\
                            No more ads\
                        </div>');
                    }
                }
            });
        }

        /* LOAD AD */
        getMemberAdvertisements(rid,page);

        /* LOAD MORE AD */
        $(document).on("click", "#load_more_userads", function() {
            page++;
            getMemberAdvertisements(rid,page);
        });
    });


</script>

</html>


