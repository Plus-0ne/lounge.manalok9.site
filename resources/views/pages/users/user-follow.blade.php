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
                                    Follows
                                </h5>
                            </div>
                            <div class="col-12">
                                <hr>
                            </div>
                            <div class="p-3 col-12">
                                <div class="col-12 d-flex justify-content-between align-items-center">
                                    <h6>
                                        Followers
                                    </h6>
                                    <input type="text" placeholder="Find a follower">
                                </div>
                                <div class="p-3">

                                </div>
                                <div class="w-100 row">
                                    <style>
                                        div.follower-container {
                                            padding: 1rem;
                                        }
                                        div.follower-image {
                                            width: 80px;
                                        }
                                        div.follower-image img {
                                            width: 100%;
                                            border-radius: 100%;
                                        }
                                        div.follower-details {
                                            padding-left: 15px;
                                        }
                                    </style>

                                    @if ($data['followers']->count() > 0)
                                        @foreach ($data['followers']->get() as $row)
                                        <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4 col-xxl-3 follower-container d-flex flex-row align-items-center">
                                            <div class="follower-image">
                                                @if ($row->followerDetails->profile_image == null)
                                                <img src="{{ asset('my_custom_symlink_1/user.png') }}">
                                                @else
                                                <img src="{{ asset($row->followerDetails->profile_image) }}">
                                                @endif
                                            </div>
                                            <div class="follower-details d-flex flex-column">
                                                <div class="w-100 align-self-center">
                                                    <h6>
                                                        <a href="{{ route('user.view_members') }}?rid={{ $row->followerDetails->uuid }}">
                                                            {{ $row->followerDetails->first_name }} {{ $row->followerDetails->last_name }}
                                                        </a>
                                                    </h6>
                                                </div>
                                                <div class="w-100 align-self-center">
                                                    <p>
                                                        <small>Follower since {{ $row->created_at }}</small>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    @else
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4 col-xxl-3 follower-container d-flex flex-row align-items-center">
                                        <div class="follower-details d-flex flex-column">
                                            <div class="w-100 align-self-center">
                                                <h6>
                                                    No one followed you!
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    @endif




                                </div>


                                <div class="p-5">

                                </div>



                                <div class="col-12 d-flex justify-content-between">
                                    <h6>
                                        Following
                                    </h6>
                                    <input type="text" placeholder="Person you followed">
                                </div>
                                <div class="p-3"></div>
                                <div class="w-100 row">
                                    <style>
                                        div.follower-container {
                                            padding: 1rem;
                                        }
                                        div.follower-image {
                                            width: 80px;
                                        }
                                        div.follower-image img {
                                            width: 100%;
                                            border-radius: 100%;
                                        }
                                        div.follower-details {
                                            padding-left: 15px;
                                        }
                                    </style>

                                    @if ($data['following']->count() > 0)
                                    @foreach ($data['following']->get() as $row)
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4 col-xxl-3 follower-container d-flex flex-row align-items-center">
                                        <div class="follower-image">
                                            @if ($row->followingDetails->profile_image == null)
                                            <img src="{{ asset('my_custom_symlink_1/user.png') }}">
                                            @else
                                            <img src="{{ asset($row->followingDetails->profile_image) }}">
                                            @endif
                                        </div>
                                        <div class="follower-details d-flex flex-column">
                                            <div class="w-100 align-self-center">
                                                <h6>
                                                    <a href="{{ route('user.view_members') }}?rid={{ $row->followingDetails->uuid }}">
                                                        {{ $row->followingDetails->first_name }} {{ $row->followingDetails->last_name }}
                                                    </a>
                                                </h6>
                                            </div>
                                            <div class="w-100 align-self-center">
                                                <p>
                                                    <small>Followed since {{ $row->created_at }}</small>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                    @else
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-4 col-xxl-3 follower-container d-flex flex-row align-items-center">
                                    <div class="follower-details d-flex flex-column">
                                        <div class="w-100 align-self-center">
                                            <h6>
                                                Find someone to follow
                                            </h6>
                                        </div>
                                    </div>
                                    </div>
                                    @endif





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
</body>

{{-- SCRIPTS --}}
@include('pages/users/template/section/scripts')


</html>
