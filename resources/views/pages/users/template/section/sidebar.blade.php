<div class="sidebar">
    <div class="sidebar-logo d-flex flex-column align-items-center">
        <div class="logo-section">
            @if (!empty(Auth::guard('web')->user()->profile_image))
                <img src="{{ asset(Auth::guard('web')->user()->profile_image) }}">
            @else
                <img src="{{ asset('my_custom_symlink_1/user.png') }}">
            @endif
        </div>
        <div class="w-100 d-flex flex-column align-items-center justify-content-center my-2">
            <strong>
                Hello, {{ !empty(Auth::guard('web')->user()->first_name) ? Auth::guard('web')->user()->first_name : 'guest' }}!
            </strong>
            <small>
                <small>
                    <small>
                        {{ Auth::guard('web')->user()->iagd_number }}
                    </small>
                </small>
            </small>
        </div>

    </div>

    <div class="sidebar-menu">
        <ul class="nav flex-column mt-3">
            <li class="nav-item d-flex flex-wrap justify-content-between align-item-middle" data-bs-container="body"
                data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-placement="right"
                data-bs-content="Socialize with other IAGD members!">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <div class="d-flex flex-wrap align-items-center px-3">
                        <div class="nav-icon-container">
                            <img class="nav-icon" src="{{ asset('lounge-icons-v1/publication.svg') }}">
                        </div>
                        <div>
                            <span>
                                Feed
                            </span>
                        </div>
                    </div>
                </a>
            </li>
            <li class="nav-item d-flex flex-wrap justify-content-between align-item-middle" data-bs-container="body"
                data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-placement="right"
                data-bs-content="Work in progress! New pet gallery and registration.">
                <a class="nav-link" href="{{ route('user.pet_list') }}">
                    <div class="d-flex flex-wrap align-items-center px-3">
                        <div class="nav-icon-container">
                            <img class="nav-icon" src="{{ asset('lounge-icons-v1/pet.svg') }}">
                        </div>
                        <div>
                            <span>
                                Pets
                            </span>
                        </div>
                    </div>
                </a>

            </li>
            <li class="nav-item d-flex flex-wrap justify-content-between align-item-middle" data-bs-container="body"
                data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-placement="right"
                data-bs-content="View and register your pets here!">
                <a class="nav-link" href="{{ route('kennel') }}">
                    <div class="d-flex flex-wrap align-items-center px-3">
                        <div class="nav-icon-container">
                            <img class="nav-icon" src="{{ asset('lounge-icons-v1/corgi.svg') }}">
                        </div>
                        <div>
                            <span>
                                Pets ( Old )
                            </span>
                        </div>
                    </div>
                </a>

            </li>

            {{-- @if (!empty(Auth::guard('web')->user()->iagd_number)) --}}
            {{-- <li class="nav-item d-flex flex-wrap justify-content-between align-item-middle">
                    <a class="nav-link" href="{{ route('advertisements') }}">
                        <i class="nav-icon mdi mdi-advertisements"></i>
                        <span>
                            Advertisements
                        </span>
                    </a>
                </li> --}}
            {{-- @endif --}}

            {{-- ######################################### Pet gallery will be remove replace with album ######################################### --}}

            {{-- <li class="nav-item d-flex flex-wrap justify-content-between align-item-middle">
                <a class="nav-link" href="{{ route('gallery') }}">
                    <i class="nav-icon mdi mdi-view-gallery"></i>
                    <span>
                        Pet Gallery
                    </span>
                </a>
            </li> --}}

            {{-- ########################################################################################################################### --}}



            <li class="nav-item d-flex flex-wrap justify-content-between align-item-middle" data-bs-container="body"
                data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-placement="right"
                data-bs-content="Explore our premium products!">
                <a class="nav-link" href="{{ route('user.products.list') }}">
                    <div class="d-flex flex-wrap align-items-center px-3">
                        <div class="nav-icon-container">
                            <img class="nav-icon" src="{{ asset('lounge-icons-v1/shopping-bag.svg') }}">
                        </div>
                        <div>
                            <span>
                                Products
                            </span>
                        </div>
                    </div>
                </a>

            </li>

            <li class="nav-item d-flex flex-wrap justify-content-between align-item-middle" data-bs-toggle="popover"
                data-bs-trigger="hover focus" data-bs-placement="right" data-bs-content="Explore our premium services!">
                <a class="nav-link" data-bs-toggle="collapse" href="#membershipDropdown" role="button"
                    aria-expanded="false" data-bs-container="body">
                    <div class="d-flex flex-wrap align-items-center px-3">
                        <div class="nav-icon-container">
                            <img class="nav-icon" src="{{ asset('lounge-icons-v1/adopt.svg') }}">
                        </div>
                        <div>
                            <span>
                                Services
                            </span>
                        </div>
                    </div>
                </a>
                <div class="collapse multi-collapse w-100" id="membershipDropdown">
                    <ul class="nav flex-column w-100">

                        <style>
                            .nav-collapse a {
                                cursor: pointer;
                            }
                        </style>
                        <li class="nav-collapse w-100">
                            <a class="collapse-item" href="{{ route('user.services.list') }}">
                                <div class="d-flex flex-wrap align-items-center">
                                    <div class="collapse-icon-container me-2">
                                        <span class="mdi mdi-dog-service"></span>
                                    </div>
                                    <div>
                                        <span class="collapse-item-text">
                                            Dog Training
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li class="nav-collapse w-100">
                            <a class="collapse-item" href="https://mai.metaanimals.org/insurance/"> {{--  https://mai.metaanimals.org/insurance/ --}} {{-- {{ route('user.insuranceView') }} --}}
                                <div class="d-flex flex-wrap align-items-center">
                                    <div class="collapse-icon-container me-2">
                                        <span class="mdi mdi-shield-car"></span>
                                    </div>
                                    <div>
                                        <span class="collapse-item-text">
                                            Insurance
                                        </span>
                                    </div>
                                </div>

                            </a>
                        </li>

                        @if (Auth::guard('web')->user()->is_premium == '0')
                            <li class="nav-collapse">
                                <a class="collapse-item" href="{{ route('user.be_a_member') }}">
                                    <i class="mdi mdi-account-multiple-plus"></i> Upgrade Membership
                                </a>
                            </li>
                        @endif

                    </ul>
                </div>

            </li>

            <hr>
            <li class="nav-item d-flex flex-wrap justify-content-between align-item-middle">
                <a class="nav-link" href="https://metaanimals.tech/" target="_BLANK" rel="noopener noreferrer"
                    data-bs-container="body" data-bs-toggle="popover" data-bs-trigger="hover focus"
                    data-bs-placement="right" data-bs-content="Visit the official Meta Animals website!">
                    <div class="d-flex flex-wrap align-items-center px-3">
                        <div class="nav-icon-container">
                            <i class="nav-icon mdi mdi-link"></i>
                        </div>
                        <div>
                            <span>
                                Meta Animals
                            </span>
                        </div>
                    </div>


                </a>
            </li>
            <li class="nav-item d-flex flex-wrap justify-content-between align-item-middle">
                <a class="nav-link" href="https://iagd-centralized.metaanimals.org/" target="_BLANK"
                    rel="noopener noreferrer" data-bs-container="body" data-bs-toggle="popover"
                    data-bs-trigger="hover focus" data-bs-placement="right"
                    data-bs-content="Visit the Animal Registry!">
                    <div class="d-flex flex-wrap align-items-center px-3">
                        <div class="nav-icon-container">
                            <i class="nav-icon mdi mdi-link"></i>
                        </div>
                        <div>
                            <span>
                                Animal Registry
                            </span>
                        </div>
                    </div>


                </a>
            </li>
            <li class="nav-item d-flex flex-wrap justify-content-between align-item-middle">
                <a class="nav-link" href="https://www.manalok9.com/" target="_BLANK" rel="noopener noreferrer"
                    data-bs-container="body" data-bs-toggle="popover" data-bs-trigger="hover focus"
                    data-bs-placement="right" data-bs-content="Visit the Manalok9!">
                    <div class="d-flex flex-wrap align-items-center px-3">
                        <div class="nav-icon-container">
                            <i class="nav-icon mdi mdi-link"></i>
                        </div>
                        <div>
                            <span>
                                Manalo K9
                            </span>
                        </div>
                    </div>

                </a>
            </li>
            <li class="nav-item d-flex flex-wrap justify-content-between align-item-middle">
                <a class="nav-link" href="https://metaanimals.tech/sdn/" target="_BLANK" rel="noopener noreferrer"
                    data-bs-container="body" data-bs-toggle="popover" data-bs-trigger="hover focus"
                    data-bs-placement="right" data-bs-content="Visit the Superdog Nutrition!">
                    <div class="d-flex flex-wrap align-items-center px-3">
                        <div class="nav-icon-container">
                            <i class="nav-icon mdi mdi-link"></i>
                        </div>
                        <div>
                            <span>
                                SDN
                            </span>
                        </div>
                    </div>
                </a>
            </li>

            <hr>

            <li class="nav-item d-flex flex-wrap justify-content-between align-item-middle">
                <a class="nav-link" href="https://www.lazada.com.ph/shop/manalo-k9-technologies-international"
                    target="_BLANK" rel="noopener noreferrer" data-bs-container="body" data-bs-toggle="popover"
                    data-bs-trigger="hover focus" data-bs-placement="right" data-bs-content="Visit our Lazada shop!">
                    <div class="d-flex flex-wrap align-items-center px-3">
                        <div class="nav-icon-container">
                            <img class="nav-icon" src="{{ asset('img/lazada_logo.webp') }}" alt="">
                        </div>
                        <div>
                            <span>
                                LAZADA
                            </span>
                        </div>
                    </div>


                </a>
            </li>

            <li class="nav-item d-flex flex-wrap justify-content-between align-item-middle">
                <a class="nav-link" href="https://www.lazada.com.ph/shop/meta-animals-technologies-corporation"
                    target="_BLANK" rel="noopener noreferrer" data-bs-container="body" data-bs-toggle="popover"
                    data-bs-trigger="hover focus" data-bs-placement="right" data-bs-content="Visit our LazMall!">
                    <div class="d-flex flex-wrap align-items-center px-3">
                        <div class="nav-icon-container">
                            <img class="nav-icon" src="{{ asset('img/lazmall_logo.png') }}" alt="">
                        </div>
                        <div>
                            <span>
                                LAZMALL
                            </span>
                        </div>
                    </div>


                </a>
            </li>

            <li class="nav-item d-flex flex-wrap justify-content-between align-item-middle">
                <a class="nav-link" href="https://shopee.ph/manalok9international" target="_BLANK"
                    rel="noopener noreferrer" data-bs-container="body" data-bs-toggle="popover"
                    data-bs-trigger="hover focus" data-bs-placement="right" data-bs-content="Visit our Shopee shop!">
                    <div class="d-flex flex-wrap align-items-center px-3">
                        <div class="nav-icon-container">
                            <img class="nav-icon" src="{{ asset('img/shopee_logo.png') }}" alt="">
                        </div>
                        <div>
                            <span>
                                SHOPEE
                            </span>
                        </div>
                    </div>


                </a>
            </li>

            <li class="nav-item d-flex flex-wrap justify-content-between align-item-middle">
                <a class="nav-link" href="https://shopee.ph/manalok9international" target="_BLANK"
                    rel="noopener noreferrer" data-bs-container="body" data-bs-toggle="popover"
                    data-bs-trigger="hover focus" data-bs-placement="right" data-bs-content="Visit our ShopMall!">
                    <div class="d-flex flex-wrap align-items-center px-3">
                        <div class="nav-icon-container">
                            <img class="nav-icon" src="{{ asset('img/ShopeeMall_logo.png') }}" alt="">
                        </div>
                        <div>
                            <span>
                                SHOPMALL
                            </span>
                        </div>
                    </div>


                </a>
            </li>

            <li class="nav-item d-flex flex-wrap justify-content-between align-item-middle">
                <a class="nav-link" href="https://www.tiktok.com/@metaanimals" target="_BLANK"
                    rel="noopener noreferrer" data-bs-container="body" data-bs-toggle="popover"
                    data-bs-trigger="hover focus" data-bs-placement="right" data-bs-content="Visit our TikTok Shop!">
                    <div class="d-flex flex-wrap align-items-center px-3">
                        <div class="nav-icon-container">
                            <img class="nav-icon" src="{{ asset('img/tiktok_shop_logo.png') }}" alt="">
                        </div>
                        <div>
                            <span>
                                TikTok Shop
                            </span>
                        </div>
                    </div>


                </a>
            </li>

            {{-- <li class="nav-item d-flex flex-wrap justify-content-between align-item-middle">
                <a class="nav-link" href="{{ route('pet_trades') }}">
                    <i class="nav-icon mdi mdi-swap-horizontal-bold"></i>
                    <span>
                        Pet Trading
                    </span>
                </a>
            </li> --}}
            <div class="mt-5"></div>
            <div class="mt-5"></div>
        </ul>
    </div>

    {{-- <img id="doc" src="{{ asset('gif/doc-wave.gif') }}" style="
        position: fixed;
        left: 0;
        bottom: -18%;
        height: 50%;
    "> --}}
</div>
