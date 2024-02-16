<x-guest-layout>
    <div class="content-body d-flex flex-wrap justify-content-center col-12 col-sm-12 col-md-12 py-5">

        @if (Route::has('user.login'))
            <div class="landing-header fixed top-0 right-0 px-6 py-4 sm:block">
                {{-- <a href="{{ route('user.pet_registration') }}" class="text-sm text-yellow-500 me-5">Register Pet</a> --}}
                @auth
                    <a href="{{ route('dashboard') }}" class="text-sm text-yellow-500 ">Lounge</a>
                @else
                    <a href="{{ route('user.login') }}" class="text-sm text-yellow-500">Log in</a>
                    <a href="{{ route('user.email_confirmation') }}" class="ml-4 text-sm text-yellow-500">Register</a>
                @endauth
            </div>
        @endif
        <div class="content-logo-button max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="col-12 col-sm-12 mx-auto meta-logo">
                <img class="mx-auto" src="{{ asset('/Source') }}/META_LOGO.svg" width="500" height="500">
            </div>
            <div class="col-12 col-sm-12 mx-auto mb-5">
                <div class="hexagon-menu clear">
                    <div class="hexagon-item">
                        <div class="hex-item">
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                        <div class="hex-item">
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                        <a href="http://icgd.manalok9.com" class="hex-content" target="_blank">
                            <span class="hex-content-inner">
                                {{-- <span class="icon">
                                    <i class="fas fa-dog"></i>
                                </span> --}}
                                <img class="mx-auto" src="{{ asset('/Source') }}/dog.svg" width="50"
                                    height="50">
                                <span class="title">ICGD</span>
                            </span>
                            <svg viewBox="0 0 173.20508075688772 200" height="200" width="174" version="1.1"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M86.60254037844386 0L173.20508075688772 50L173.20508075688772 150L86.60254037844386 200L0 150L0 50Z"
                                    fill="#1e2530"></path>
                            </svg>
                        </a>
                    </div>
                    <div class="hexagon-item">
                        <div class="hex-item">
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                        <div class="hex-item">
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                        <a href="http://ifgd.manalok9.com" class="hex-content" target="_blank">
                            <span class="hex-content-inner">
                                {{-- <span class="icon">
                                    <i class="fas fa-cat"></i>
                                </span> --}}
                                <img class="mx-auto" src="{{ asset('/Source') }}/cat.svg" width="50"
                                    height="50">
                                <span class="title">IFGD</span>
                            </span>
                            <svg viewBox="0 0 173.20508075688772 200" height="200" width="174" version="1.1"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M86.60254037844386 0L173.20508075688772 50L173.20508075688772 150L86.60254037844386 200L0 150L0 50Z"
                                    fill="#1e2530"></path>
                            </svg>
                        </a>
                    </div>
                    <div class="hexagon-item">
                        <div class="hex-item">
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                        <div class="hex-item">
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                        <a href="http://manalok9.com" class="hex-content" target="_blank">
                            <span class="hex-content-inner">
                                {{-- <span class="icon">
                                    <i class="fas fa-cat"></i>
                                </span> --}}
                                <img class="mx-auto" src="{{ asset('/Source') }}/ManaloK9 icon.svg" width="50"
                                    height="50">
                                <span class="title">MANALOK9</span>
                            </span>
                            <svg viewBox="0 0 173.20508075688772 200" height="200" width="174" version="1.1"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M86.60254037844386 0L173.20508075688772 50L173.20508075688772 150L86.60254037844386 200L0 150L0 50Z"
                                    fill="#1e2530"></path>
                            </svg>
                        </a>
                    </div>
                    <div class="hexagon-item">
                        <div class="hex-item">
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                        <div class="hex-item">
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                        <a href="http://irgd.manalok9.com" class="hex-content" target="_blank">
                            <span class="hex-content-inner">
                                {{-- <span class="icon">
                                    <i class="fas fa-carrot"></i>

                                </span> --}}
                                <img class="mx-auto" src="{{ asset('/Source') }}/rabbit_icon.svg" width="50"
                                    height="50">
                                <span class="title">IRGD</span>
                            </span>
                            <svg viewBox="0 0 173.20508075688772 200" height="200" width="174" version="1.1"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M86.60254037844386 0L173.20508075688772 50L173.20508075688772 150L86.60254037844386 200L0 150L0 50Z"
                                    fill="#1e2530"></path>
                            </svg>
                        </a>
                    </div>
                    <div class="hexagon-item">
                        <div class="hex-item">
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                        <div class="hex-item">
                            <div></div>
                            <div></div>
                            <div></div>
                        </div>
                        <a href="http://ibgd.manalok9.com" class="hex-content" target="_blank">
                            <span class="hex-content-inner">
                                {{-- <span class="icon">
                                    <i class="fas fa-cat"></i>
                                </span> --}}
                                <img class="mx-auto" src="{{ asset('/Source') }}/bird.svg" width="50"
                                    height="50">
                                <span class="title">IBGD</span>
                            </span>
                            <svg viewBox="0 0 173.20508075688772 200" height="200" width="174" version="1.1"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M86.60254037844386 0L173.20508075688772 50L173.20508075688772 150L86.60254037844386 200L0 150L0 50Z"
                                    fill="#1e2530"></path>
                            </svg>
                        </a>
                    </div>
                </div>

            </div>

        </div>
        {{-- <div class="bg-light text-dark shadow p-1" style="position: fixed; bottom: 0; right: 0; font-size: 0.9rem;">
            <table>
                <tr>
                    <td class="fw-bold ps-2 pe-2">Users Online: </td>
                    <td class="text-center pe-3">{{ $analytics['users_online'] ?? '00'}}</td>

                    <td class="fw-bold pe-2">Registered: </td>
                    <td class="text-center pe-3">{{ $analytics['users_registered'] ?? '00'}}</td>

                    <td class="fw-bold pe-2">Total Visits: </td>
                    <td class="text-center pe-2">{{ $analytics['visitor_count'] ?? '00'}}</td>
                </tr>
            </table>
        </div> --}}
    </div>
</x-guest-layout>
