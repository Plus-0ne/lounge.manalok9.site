{{-- HEADER CONTAINS CSS LINKS --}}
@include('pages/users/template/section/header')
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
</style>
<body>
    <div class="wrapper">

        {{-- TOP NAVIGATION --}}
        @include('pages/users/template/section/header_nav')

        <div class="main">

            {{-- SIDABAR --}}
            @include('pages/users/template/section/sidebar')

            <div class="main-content">
                <div class="container-fluid container-xl">
                    <div class="row">
                        <div class="col-12 px-4 pt-4 pb-5 gallery_container d-flex flex-wrap">
                            <div class="p-3 col-12">
                                <div class="row d-flex">
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
                                                            <a class="nav-link" aria-current="page" href="#">Recent viewed post</a>
                                                        </li>
                                                        <li class="nav-item me-1 me-lg-3">
                                                            <a class="nav-link" aria-current="page" href="{{ route('user.view_comments') }}?rid={{ $data['gmd']->uuid }}">Comments</a>
                                                        </li>
                                                        <li class="nav-item me-1 me-lg-3">
                                                            <a class="nav-link" aria-current="page" href="{{ route('user.view_reacts') }}?rid={{ $data['gmd']->uuid }}">Reacts</a>
                                                        </li>
                                                        <li class="nav-item me-1 me-lg-3">
                                                            <a class="nav-link active" aria-current="page" href="{{ route('user.view_follows') }}?rid={{ $data['gmd']->uuid }}">Follows</a>
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
                                        <div class="w-100">
                                            {{-- This area contains all user follows and followers --}}

                                            <style>
                                                .f-section-title , .f-section-header , .f-det-container {
                                                    font-size: 0.95rem;
                                                }
                                                .f-img-pholder {
                                                    width: 75px;
                                                    height: 75px;
                                                    border-radius: 50%;
                                                }
                                                .f-img-pholder img {
                                                    width: 100%;
                                                    border-radius: 50%;
                                                }
                                                .f-sect-details {
                                                    font-size: 0.75rem;
                                                }
                                                .f-img-container {
                                                    margin-right: 1rem;
                                                }
                                                .f-section-content {
                                                    margin-bottom: 1rem;
                                                }
                                                .search_btn_f {
                                                    font-size: 1.5rem;
                                                    margin-left: 0.9rem;
                                                    cursor: pointer;
                                                }
                                                .sort-f-search {
                                                    cursor: pointer;
                                                    -webkit-user-select: none;
                                                    -moz-user-select: none;
                                                    -ms-user-select: none;
                                                    -o-user-select: none;
                                                    user-select: none;
                                                }
                                                .f-section-content:hover {
                                                    background-color: #f8f8f8;
                                                    cursor: pointer;
                                                }

                                            </style>
                                            <div class="card p-4">
                                                <div class="f-section-container">
                                                    <div class="f-section-header d-flex flex-row justify-content-between pb-5 align-items-center">
                                                        <div class="f-section-title d-flex flex-row">
                                                            <div class="sort-f-search">
                                                                Followers
                                                            </div>
                                                            <div class="ms-1">
                                                                <i class="mdi mdi-swap-vertical"></i>
                                                            </div>
                                                        </div>
                                                        <div class="f-section-control d-flex flex-row">
                                                              <input id="find_user_follower" type="text" class="form-control form-control-sm" name="" placeholder="Search follower">
                                                              <div class="search_btn_f">
                                                                <i class="mdi mdi-magnify"></i>
                                                              </div>
                                                        </div>
                                                    </div>
                                                    <div class="row follower_section_area">

                                                        {{-- Sample follower section --}}
                                                        {{-- <div class="f-section-content col-12 col-sm-12 col-md-6">
                                                            <div class="w-100 d-flex flex-row">
                                                                <div class="f-img-container">
                                                                    <div class="f-img-pholder">
                                                                        <img src="{{ asset('img/user/4e4bbddc-9462-494a-a21b-a51e2f94e829/62cfb971e3329.jpg') }}" alt="">
                                                                    </div>
                                                                </div>
                                                                <div class="f-det-container d-flex flex-column align-items-center">
                                                                    <div class="w-100 f-sect-name">
                                                                        Sample Name
                                                                    </div>
                                                                    <div class="w-100 f-sect-details">
                                                                        <div>
                                                                            Since August 22 2022 - 02:18 PM
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> --}}
                                                    </div>
                                                </div>
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
    {{-- Chat window --}}
    @include('pages/users/template/modals/modal-chat-window')
    {{-- Include custom user toast --}}
    @include('pages/users/template/section/user-toasts')
</body>

{{-- SCRIPTS --}}
@include('pages/users/template/section/scripts')
@include('pages/users/template/section/scripts-var')
{{-- <script src="{{ asset('js/members_js/members_profile.js?v=1') }}"></script> --}}
<script src="{{ asset('js/members_js/view_follower.js?v=1') }}"></script>

</html>


