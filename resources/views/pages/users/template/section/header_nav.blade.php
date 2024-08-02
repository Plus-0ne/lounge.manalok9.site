<div class="header d-flex flex-wrap">
    <div
        class="nav-btn-icon col-12 col-sm-12 col-md-12 d-flex flex-wrap justify-content-start justify-content-lg-between justify-content-xl-end align-items-center">

        <div class="d-flex flex-column justify-content-center align-items-center logo-container">
            <div class="logo mb-3 mb-xl-0 d-none d-md-block">
                <img src="{{ asset('lounge-icons-v1/lounge.svg') }}">
            </div>
        </div>
        <div class="col-1 col-lg-0">
            <div class="menu-toggle">
                <i class="menu-icon action-icon mdi mdi-format-align-justify"></i>
            </div>
        </div>
        {{-- Search section --}}
        {{-- <div class="px-3 col-11 col-lg-5 search_container">
            <div class="search_icon_container">
                <span class="mdi mdi-magnify"></span>
            </div>
        </div> --}}
        {{-- Search end --}}
        <div class="non-mobile-display col-0 col-lg-5 ms-0 ms-lg-auto mt-2 mt-lg-0 d-flex flex-row justify-content-end align-items-center px-0 px-lg-3">
            <button type="button" class="btn btn-primary write_a_post-btn" style="width: 250px; float: right; display: none;">
                <i class="bi bi-feather"></i> Write a post</span>
            </button>
        </div>
        <div
            class="col-11 col-lg-auto ms-0 ms-lg-auto mt-2 mt-lg-0 d-flex flex-row justify-content-end align-items-center px-0 px-lg-3">
            <!-- <button type="button" class="mini-mobile-display btn btn-primary write_a_post-btn" style="display: none !important;">
                <i class="bi bi-feather"></i> <b>Write a post</b></span>
            </button> -->
            <div class="px-2">
                <input id="ps_search_input" class="form-control" type="text" name="ps_search_input" placeholder="Search" style="padding-left: 20px;">
                <button type="submit" style="display: none;">Search</button>
            </div>
            <div class="ads_toggle px-2">
                <i class="action-icon mdi mdi-magnify"></i>
            </div>
            <div class="ads_toggle px-2">
                <i class="action-icon mdi mdi-post-outline"></i>
            </div>
            {{-- Cart Icon nav--}}
            {{-- <div>

                <span class="material-symbols-outlined">
                    shopping_cart
                </span>

            </div> --}}

            {{-- <div class="px-2">
                <a class="header-menu-link" href="{{ route('user.insurance') }}" data-bs-toggle="popover"
                    data-bs-trigger="hover focus" data-bs-content="Insurance" data-bs-placement="bottom">
                    <span class="action-icon mdi mdi-shield-plus"></span>
                </a>
            </div>
            <div class="px-2">
                <a class="header-menu-link" href="{{ route('user.training') }}" data-bs-toggle="popover"
                    data-bs-trigger="hover focus" data-bs-content="Dog training" data-bs-placement="bottom">
                    <span class="action-icon mdi mdi-dog-service"></span>
                </a>
            </div>

            <div class="px-2">
                <a class="header-menu-link" href="{{ route('kennel') }}" data-bs-toggle="popover"
                    data-bs-trigger="hover focus" data-bs-content="Pet registration" data-bs-placement="bottom">
                    <i class="action-icon mdi mdi-paw"></i>
                </a>
            </div>

            @if (Auth::guard('web')->user()->is_premium == '0')
                <div class="px-2">
                    <a class="header-menu-link" href="{{ route('user.be_a_member') }}" data-bs-toggle="popover"
                        data-bs-trigger="hover focus" data-bs-content="Upgrade your IAGD membership"
                        data-bs-placement="bottom">
                        <i class="action-icon mdi mdi-card-account-details-star"></i>
                    </a>
                </div>
            @endif --}}

            {{-- Notification Section --}}
            <div class="px-2">
                <div class="w-100">
                    <div class="dropdown">
                        <a class="dropdown-toggle removeCaret header-menu-link user_notification" href="#"
                            role="button" id="user_notification" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="action-icon bi bi-bell"></i>
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
                                    <a href="#" class="btn btn-secondary">
                                        Show all notifications
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
                    {{-- <i class="action-icon mdi mdi-chat"></i> --}}
                    <i class="action-icon bi bi-chat-dots"></i>
                </a>
            </div>

            <div class="px-2">
                <div class="w-100 h-100 d-flex flex-column justify-content-center">
                    <div class="dropdown">
                        <div class="dropdown-toggle removeCaret" id="User_details" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            @if (!empty(Auth::guard('web')->user()->profile_image))
                                <img class="image-nav-prof"
                                    src="{{ asset(Auth::guard('web')->user()->profile_image) }}">
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
                                @if (Auth::guard('web')->user()->adminAccount()->count() > 0)
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
                                    <i class="action-icon-dd bi bi-person-square me-2"></i> Profile
                                    {{-- <i class="action-icon-dd mdi mdi-account me-2"></i> --}}
                                </div>
                            </a>
                            <a class="dropdown-item fs-text"
                                href="{{ route('user.my_referrals') }}">
                                <div class="d-flex align-items-center">
                                    <i class="action-icon-dd bi bi-stars me-2"></i> My Referrals
                                    {{-- <i class=" mdi mdi-account-group me-2"></i>  --}}
                                </div>
                            </a>

                            <a class="dropdown-item fs-text"
                                href="{{ route('dealer') }}">
                                <div class="d-flex align-items-center">
                                    <i class="action-icon-dd bi bi-capsule me-2"></i>  Be a dealer
                                    {{-- <i class="action-icon-dd mdi mdi-account-group me-2"></i> --}}
                                </div>
                            </a>

                            <a class="dropdown-item fs-text" href="{{ route('user.user_profile') }}">
                                <div class="d-flex align-items-center">
                                    <i class="action-icon-dd bi bi-gear me-2"></i> Account
                                    {{-- <i class=" mdi mdi-cog me-2"></i> --}}
                                </div>
                            </a>
                            <a class="dropdown-item fs-text" href="{{ route('logout.user') }}">
                                <div class="d-flex align-items-center">
                                    <i class="action-icon-dd bi bi-box-arrow-right me-2"></i> Sign out
                                    {{-- <i class="action-icon-dd mdi mdi-logout me-2"></i> --}}
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
