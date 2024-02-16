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

            <div class="main-content h-100">
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
                                                            <a class="nav-link" aria-current="page" href="{{ route('user.view_follows') }}?rid={{ $data['gmd']->uuid }}">Follows</a>
                                                        </li>
                                                        <li class="nav-item me-1 me-lg-3">
                                                            <a class="nav-link active" aria-current="page" href="{{ route('user.view_members_pets') }}?rid={{ $data['gmd']->uuid }}">Pets</a>
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
                                            <style>
                                                .p-section-title , .p-section-header , .p-det-container {
                                                    font-size: 0.95rem;
                                                }
                                                .p-img-pholder {
                                                    max-width: 225px;
                                                    max-height: 100%;

                                                }
                                                .p-img-pholder img {
                                                    border-radius: 10%;
                                                    border: 1px solid rgba(0, 0, 0, 0.1);
                                                }
                                                .p-sect-name {
                                                    font-size: 1.25rem;
                                                }
                                                .p-sect-details {
                                                    font-size: 0.75rem;
                                                }
                                                .p-img-container {
                                                }
                                                .p-section-content {
                                                    margin-bottom: 1rem;

                                                    border: 2px rgba(20, 20, 20, 0.1);
                                                    padding: 15px;

                                                    background-color: #fbfbfb;
                                                    border-radius: 20px;
                                                }
                                                .search_btn_f {
                                                    font-size: 1.5rem;
                                                    margin-left: 0.9rem;
                                                    cursor: pointer;
                                                }


                                                .p-section-row {
                                                    width: 100%;
                                                    text-decoration: none;
                                                    color: #000;
                                                }
                                                @media (min-width: 1700px) {
                                                    .p-section-row {
                                                        width: 50%;
                                                    }
                                                }

                                                .pet_mem {
                                                    border-style: dashed;
                                                }
                                                .pet_reg {
                                                    border-style: solid;
                                                    border-color: #dadada;
                                                }
                                            </style>
                                            <div class="card p-4">
                                                <div class="p-section-container">
                                                    <div class="p-section-header d-flex flex-row justify-content-between pb-2 align-items-center">
                                                        <div class="p-section-title d-flex flex-row">
                                                            <h5 class="fw-bold">
                                                                Pets
                                                            </h5>
                                                        </div>
                                                    </div>
                                                    <div class="row pets_section_area">

                                                        {{-- Sample pets section --}}
                                                        {{-- @for($i = 0; $i < 10; $i++)
                                                        <div class="p-section-row">
                                                            <div class="p-section-content">
                                                                <div class="w-100 d-flex flex-row">
                                                                    <div class="p-img-container">
                                                                        <div class="p-img-pholder">
                                                                            <img class="shadow" src="{{ asset('img/no_img.jpg') }}" alt="">
                                                                        </div>
                                                                    </div>
                                                                    <div class="p-det-container d-flex flex-column align-items-center">
                                                                        <div class="w-100 p-sect-name mt-2 fw-bold">
                                                                            Pet Name
                                                                        </div>
                                                                        <div class="w-100 p-sect-details ps-2 py-2">
                                                                            <table>
                                                                                <tbody>
                                                                                    <tr>
                                                                                        <td class="pe-2 text-secondary">
                                                                                            IAGD #:
                                                                                        </td>
                                                                                        <td class="p-sect-details">
                                                                                            Test
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="pe-2 text-secondary">
                                                                                            Gender:
                                                                                        </td>
                                                                                        <td class="p-sect-details">
                                                                                            Test
                                                                                        </td>
                                                                                    </tr>
                                                                                    <tr>
                                                                                        <td class="pe-2 text-secondary">
                                                                                            Birthday:
                                                                                        </td>
                                                                                        <td class="p-sect-details">
                                                                                            Test
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @endfor --}}
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
<script src="{{ asset('js/members_js/view_pets.js') }}"></script>

</html>


