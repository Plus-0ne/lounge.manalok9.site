<div class="sidebar" style="z-index: 1;">
    <div class="sidebar-logo">
        <div class="logo-section text-center d-flex flex-column">

            @if (Auth::guard('web_admin')->check())
                <h5>
                    {{ Auth::guard('web_admin')->user()->department }}
                </h5>
                <span>
                    {{ Auth::guard('web_admin')->user()->userAccount->first_name }}
                    {{ Auth::guard('web_admin')->user()->userAccount->last_name }}
                </span>
                <small>
                    {{ Auth::guard('web_admin')->user()->position }}
                </small>
            @endif

        </div>
    </div>

    <div class="sidebar-menu">
        <ul class="nav flex-column">
            <hr>
            <li class="nav-item d-flex flex-wrap justify-content-between align-item-middle">
                <a class="nav-link" href="{{ route('admin.Dashboard') }}">
                    <i class="nav-icon mdi mdi-view-dashboard"></i>
                    <span>
                        Dashboard
                    </span>
                </a>
            </li>
            <li class="nav-item d-flex flex-wrap justify-content-between align-item-middle">
                <a class="nav-link" data-bs-toggle="collapse" href="#dealers" role="button" aria-expanded="false"
                    aria-controls="multiCollapseExample1">
                    <i class="bi bi-briefcase-fill"></i>
                    <span>
                        Dealers
                    </span>
                </a>
                <div class="collapse multi-collapse" id="dealers">
                    <ul class="nav flex-column">
                        <li class="nav-collapse">
                            <a class="collapse-item" href="{{ route('admin.Dog_Registration') }}">
                                For verification
                            </a>
                        </li>
                        <li class="nav-collapse">
                            <a class="collapse-item" href="{{ route('admin.Cat_Registration') }}">
                                Approved
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            {{-- <li class="nav-item d-flex flex-wrap justify-content-between align-item-middle">
				<a class="nav-link" href="{{ route('admin.users_post') }}">
					<i class="nav-icon mdi mdi-newspaper-variant"></i>
					<span>
						Posts
					</span>
				</a>
			</li>
			<li class="nav-item d-flex flex-wrap justify-content-between align-item-middle">
				<a class="nav-link" href="{{ route('admin.registration') }}">
					<i class="nav-icon mdi mdi-account-plus-outline"></i>
					<span>
						Registration
					</span>
				</a>
			</li> --}}
            <li class="nav-item d-flex flex-wrap justify-content-between align-item-middle">
                <a class="nav-link" href="{{ route('admin.IAGD_Members') }}">
                    <i class="nav-icon mdi mdi-account-group"></i>
                    <span>
                        IAGD Members
                    </span>
                </a>
            </li>
            <li class="nav-item d-flex flex-wrap justify-content-between align-item-middle">
                <a class="nav-link" href="{{ route('admin.Lounge_Members') }}">
                    <i class="nav-icon mdi mdi-account-multiple"></i>
                    <span>
                        Lounge Members
                    </span>
                </a>
            </li>
            <li class="nav-item d-flex flex-wrap justify-content-between align-item-middle">
                <a class="nav-link" href="{{ route('admin.Membership_Upgrade') }}">
                    <i class="nav-icon mdi mdi-account-multiple-plus"></i>
                    <span>
                        Premium Membership
                    </span>
                </a>
            </li>
            <li class="nav-item d-flex flex-wrap justify-content-between align-item-middle">
                <a class="nav-link" data-bs-toggle="collapse" href="#collapse1" role="button" aria-expanded="false"
                    aria-controls="multiCollapseExample1">
                    <i class="nav-icon mdi mdi-dog-side"></i>
                    <span>
                        Pet Registration
                    </span>
                </a>
                <div class="collapse multi-collapse" id="collapse1">
                    <ul class="nav flex-column">
                        <li class="nav-collapse">
                            <a class="collapse-item" href="{{ route('admin.Dog_Registration') }}">
                                Dogs
                            </a>
                        </li>
                        <li class="nav-collapse">
                            <a class="collapse-item" href="{{ route('admin.Cat_Registration') }}">
                                Cats
                            </a>
                        </li>
                        <li class="nav-collapse">
                            <a class="collapse-item" href="{{ route('admin.Rabbit_Registration') }}">
                                Rabbits
                            </a>
                        </li>
                        <li class="nav-collapse">
                            <a class="collapse-item" href="{{ route('admin.Bird_Registration') }}">
                                Birds
                            </a>
                        </li>
                        <li class="nav-collapse">
                            <a class="collapse-item" href="{{ route('admin.Other_Registration') }}">
                                Others
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item d-flex flex-wrap justify-content-between align-item-middle">
                <a class="nav-link" href="{{ route('admin.certification_requests') }}">
                    <i class="nav-icon mdi mdi-certificate"></i>
                    <span>
                        Certifcation Requests
                    </span>
                </a>
            </li>
            <li class="nav-item d-flex flex-wrap justify-content-between align-item-middle">
                <a class="nav-link" href="{{ route('admin.training_tickets') }}">
                    <i class="nav-icon mdi mdi-ticket"></i>
                    <span>
                        Training Tickets
                    </span>
                </a>
            </li>
            <li class="nav-item d-flex flex-wrap justify-content-between align-item-middle">
                <a class="nav-link" href="{{ route('admin.products') }}">
                    <i class="nav-icon mdi mdi-shopping-outline"></i>
                    <span>
                        Products
                    </span>
                </a>
            </li>
            <li class="nav-item d-flex flex-wrap justify-content-between align-item-middle">
                <a class="nav-link" href="{{ route('admin.services') }}">
                    <i class="mdi mdi-dog-service"></i>
                    <span>
                        Services
                    </span>
                </a>
            </li>
            <li class="nav-item d-flex flex-wrap justify-content-between align-item-middle">
                <a class="nav-link" href="{{ route('admin.insuranceView') }}">
                    <i class="mdi mdi-shield-plus"></i>
                    <span>
                        Insurance
                    </span>
                </a>
            </li>
            <hr>
            {{-- <li class="nav-item d-flex flex-wrap justify-content-between align-item-middle">
				<a class="nav-link" href="{{ route('admin.accounts_list') }}">
					<i class="nav-icon mdi mdi-account"></i>
					<span>
						Accounts
					</span>
				</a>
			</li>
			<li class="nav-item d-flex flex-wrap justify-content-between align-item-middle">
				<a class="nav-link" href="{{ route('admin.accounts_list') }}">
					<i class="nav-icon mdi mdi-account-tie"></i>
					<span>
						Admins
					</span>
				</a>
			</li> --}}

            <li class="nav-item d-flex flex-wrap justify-content-between align-item-middle">
                <a class="nav-link" href="{{ route('admin.random_gift_drop') }}">
                    <i class="nav-icon mdi mdi-gift"></i>
                    <span>
                        Gift Drop
                    </span>
                </a>
            </li>


            <hr>
            @if (Auth::guard('web_admin')->user()->roles == 1)
                <li class="nav-item d-flex flex-wrap justify-content-between align-item-middle">
                    <a class="nav-link" data-bs-toggle="collapse" href="#website_settings" role="button"
                        aria-expanded="false" aria-controls="multiCollapseExample1">
                        <i class="nav-icon mdi mdi-application-cog"></i>
                        <span>
                            Website Settings
                        </span>
                    </a>
                    <div class="collapse multi-collapse" id="website_settings">
                        <ul class="nav flex-column">
                            <li class="nav-collapse">
                                <a class="collapse-item" href="#">
                                    Page identity
                                </a>
                            </li>

                            <li class="nav-collapse">
                                <a class="collapse-item" href="#">
                                    Testimonial
                                </a>
                            </li>

                            <li class="nav-collapse">
                                <a class="collapse-item" href="{{ route('admin.accounts_list') }}">
                                    Admin accounts
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif
        </ul>
    </div>
</div>
