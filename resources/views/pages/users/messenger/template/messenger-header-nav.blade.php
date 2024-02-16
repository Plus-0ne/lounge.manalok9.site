<div class="header d-flex flex-wrap">
    <div class="nav-btn-icon col-12 col-sm-12 col-md-12 d-flex flex-wrap justify-content-start justify-content-lg-between justify-content-xl-end align-items-center">
        <div class="menu-toggle col-auto">
            <i class="m-menu-icon action-icon mdi mdi-format-align-justify"></i>
        </div>
        {{-- Search section --}}
        <div class="px-3 col-11 col-lg-5 search_container">
            <div class="search_icon_container">
                <i class="mdi mdi-magnify"></i>
            </div>
            <input id="ps_search_input" class="form-control" type="text" name="ps_search_input" placeholder="Search">
            <button type="submit" style="display: none;">Search</button>
        </div>
        {{-- Search end --}}
        <div class="col-12 col-lg-auto ms-0 ms-lg-auto mt-2 mt-lg-0 d-flex flex-row justify-content-end align-items-center px-0 px-lg-3">
            <div class="pe-2 px-lg-2">
                <a class="header-menu-link" href="{{ route('dashboard') }}">
                    <i class="action-icon mdi mdi-newspaper"></i>
                </a>
            </div>
            {{-- <div class="ads_toggle px-2">
                <i class="action-icon mdi mdi-post-feed"></i>
            </div> --}}

            {{-- Notification Section --}}
            <div class="px-2">
                <div class="w-100">
                    <div class="dropdown">

                        <a class="dropdown-toggle removeCaret header-menu-link user_notification" href="#" role="button" id="user_notification" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="action-icon mdi mdi-bell"></i>

                        </a>

                        <div class="dropdown-menu mt-3 custom-dm-s" aria-labelledby="user_notification">
                            <div
                                class="px-3 pt-2 pb-3 w-100 notification-header-dm d-flex flex-row justify-content-between align-items-center">
                                <label class="ff-primary-light">
                                    <span>
                                        Notifications
                                    </span>
                                </label>
                                <div class="ff-primary-light">
                                    <i class="mdi mdi-bell"></i>

                                </div>
                            </div>
                            <div id="notification_container" class="w-100 d-flex flex-column">
                                {{-- Notification contents here --}}

                            </div>
                            <div class="px-3 pt-3 pb-2 w-100 notification-footer-dm d-flex flex-column text-end">
                                <div>
                                    <a href="#" class="btn btn-info btn-sm">
                                        Show all notification
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Messenger button --}}
            <div class="px-2">
                <a class="header-menu-link" href="{{ route('user.messenger') }}">
                    <i class="action-icon mdi mdi-chat"></i>
                </a>
            </div>

            <div class="px-2">
                <div class="w-100 h-100 d-flex flex-column justify-content-center">
                    <div class="dropdown">
                        <div class="dropdown-toggle removeCaret" id="User_details" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            @if (!empty(Auth::guard('web')->user()->profile_image))
                                <img class="image-nav-prof" src="{{ asset(Auth::guard('web')->user()->profile_image) }}">
                            @else
                                <img class="image-nav-prof" src="{{ asset('my_custom_symlink_1/user.png') }}">
                            @endif
                        </div>
                        <div class="dropdown-menu mt-3" aria-labelledby="User_details">
                            @if (Auth::guard('web_admin')->check())
                                <a class="dropdown-item fs-text" href="{{ route('admin.Dashboard') }}">
                                    <div class="d-flex align-items-center">
                                        <i class="action-icon-dd mdi mdi-view-dashboard me-2"></i> Visit admin
                                    </div>
                                </a>
                            @else
                                @if (Auth::guard('web')->user()->with('adminAccount')->count() > 0)
                                    <a class="dropdown-item fs-text" href="{{ route('admin.admin_sign_validation') }}">
                                        <div class="d-flex align-items-center">
                                            <i class="action-icon-dd mdi mdi-view-dashboard me-2"></i> Sign-in as admin
                                        </div>
                                    </a>
                                @endif

                            @endif
                            <a class="dropdown-item fs-text"
                                href="{{ route('user.view_members') }}?rid={{ Auth::guard('web')->user()->uuid }}">
                                <div class="d-flex align-items-center">
                                    <i class="action-icon-dd mdi mdi-account me-2"></i> Profile
                                </div>
                            </a>
                            <a class="dropdown-item fs-text"
                                href="{{ route('user.user_profile') }}">
                                <div class="d-flex align-items-center">
                                    <i class="action-icon-dd mdi mdi-cog me-2"></i> Account
                                </div>
                            </a>
                            <a class="dropdown-item fs-text" href="{{ route('logout.user') }}">
                                <div class="d-flex align-items-center">
                                    <i class="action-icon-dd mdi mdi-logout me-2"></i> Sign out
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
