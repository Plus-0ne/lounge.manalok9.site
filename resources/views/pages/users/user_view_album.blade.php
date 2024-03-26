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
                                                            <a class="nav-link" aria-current="page" href="{{ route('user.view_follows') }}?rid={{ $data['gmd']->uuid }}">Follows</a>
                                                        </li>
                                                        <li class="nav-item me-1 me-lg-3">
                                                            <a class="nav-link active" aria-current="page" href="{{ route('user.view_user_album') }}?rid={{ $data['gmd']->uuid }}">Album</a>
                                                        </li>
                                                        <li class="nav-item me-1 me-lg-3">
                                                            <a class="nav-link" aria-current="page" href="{{ route('user.view_members_advertisements') }}?rid={{ $data['gmd']->uuid }}">Ads</a>
                                                        </li>
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
                                                .album-img-container {
                                                    object-fit: contain;
                                                    width: 160.156px;
                                                    height: 90.078px;
                                                }
                                                .album-img-content {
                                                    width: 100%;
                                                    height: 100%;
                                                    border-radius: 3px;
                                                }
                                            </style>
                                            <div class="card p-4">
                                                <div class="f-section-container">
                                                    <div class="f-section-header d-flex flex-row justify-content-between pb-5 align-items-center">
                                                        <div class="f-section-title d-flex flex-row">
                                                            <div class="sort-f-search">
                                                                Album
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row album_archive">

                                                        {{-- Sample album section --}}
                                                        {{-- <div class="w-100">
                                                            <div class="w-100">
                                                                <label for="">
                                                                    November
                                                                </label>
                                                            </div>
                                                            <div class="d-flex flex-row">
                                                                <div class="col-12 col-sm-12 col-md-4 col-lg-3 p-3">
                                                                    <div class="album-img-container">
                                                                        <img class="album-img-content" src="{{ asset('my_custom_symlink_1/user.png') }}" alt="">
                                                                    </div>
                                                                </div>

                                                                <div class="col-12 col-sm-12 col-md-4 col-lg-3 p-3">
                                                                    <div class="album-img-container">
                                                                        <img class="album-img-content" src="{{ asset('my_custom_symlink_1/user.png') }}" alt="">
                                                                    </div>
                                                                </div>

                                                                <div class="col-12 col-sm-12 col-md-4 col-lg-3 p-3">
                                                                    <div class="album-img-container">
                                                                        <img class="album-img-content" src="{{ asset('my_custom_symlink_1/user.png') }}" alt="">
                                                                    </div>
                                                                </div>

                                                                <div class="col-12 col-sm-12 col-md-4 col-lg-3 p-3">
                                                                    <div class="album-img-container">
                                                                        <img class="album-img-content" src="{{ asset('my_custom_symlink_1/user.png') }}" alt="">
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
<script src="{{ asset('js/members_js/users_album.js') }}"></script>

</html>


