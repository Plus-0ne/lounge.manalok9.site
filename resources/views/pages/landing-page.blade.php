<!DOCTYPE html>
<html lang="en">
<head>
    {{-- SEO --}}
    <meta name="title" content="IAGD International Animals Genetics Database">
    <meta name="description" content="is a modern, hi-tech, online all-animal registry that has multiple layers of verification. All">
    <meta name="keywords" content="IAGD,iagd,International,Animals,Genetics,Database,Meta,Metaanimals,Meta Animals,Doc Abel Manalo,Manalo,Manalok9">
    <meta name="robots" content="index, follow">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="language" content="English">
    <meta name="author" content="Meta Animals">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        Welcome to IAGD | International Animal Genetics Database
    </title>
    <link rel="stylesheet" href="{{ asset('landing_page/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@6.6.96/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="{{ asset('css/welcome-landing.css') }}">
</head>
<body>

    {{-- Wrapper --}}
    <div class="wrapper">

        {{-- Header Navigation Section --}}
        <div class="container-fluid p-0">
            <div class="w-100 header-nav d-flex flex-row">
                @if (Route::has('user.login'))
                    <div class="ms-auto">
                        <a href="https://metaanimals.tech/" class="l-header-link" target="_blank">Official Meta Animals Website</a>
                        <a href="{{ route('user.pet_registration') }}" class="l-header-link">Register Pet</a>
                        @auth
                            <a href="{{ route('dashboard') }}" class="l-header-link">Visit Lounge</a>
                        @else
                            <a href="{{ route('user.login') }}" class="l-header-link">Sign-in</a>
                            <a href="{{ route('user.email_confirmation') }}" class="l-header-link">Create account</a>
                        @endauth
                    </div>
                @endif
            </div>
        </div>

        {{-- Hero Section --}}
        <div class="main-content d-flex justify-content-center align-items-center">
            <video id="videbackg" src="{{ asset('videos/Pexels Videos 2796080.mp4') }}" autoplay muted loop>
                <small>Video by cottonbro studio from Pexels: https://www.pexels.com/video/dog-jumping-towards-her-master-2796080/</small>
            </video>
            <div class="hero-section p-3 w-100 d-flex justify-content-center">
                <img class="hero-image" src="{{ asset('img/iagd-international-animal-genetics-database-logo.png') }}" alt="">
            </div>
        </div>
    </div>

    {{-- Footer section --}}
    <footer class="footer">
        <div class="container-fluid p-4 pb-0">

            {{-- Footer Content Section --}}
            <section class="">
              <div class="row">
                <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                    <h6 class="text-uppercase mb-4 font-weight-bold">
                        IAGD by Meta Animals
                    </h6>
                    <p class="size08rem">
                        Is a modern, hi-tech, online all-animal registry that has multiple layers of verification. All
                    </p>
                </div>
                <hr class="w-100 clearfix d-md-none" />
                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                    <h6 class="text-uppercase mb-4 font-weight-bold">Products</h6>
                    <p class="size08rem">
                        <a href="https://metaanimals.tech/sdn/" class="text-white" target="_blank">SDN</a>
                    </p>
                </div>
                <hr class="w-100 clearfix d-md-none" />
                <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3">
                    <h6 class="text-uppercase mb-4 font-weight-bold">
                        Useful links
                    </h6>
                    <p class="size08rem">
                        <a href="https://metaanimals.tech" class="text-white" target="_blank">Meta Animals Official Website</a>
                    </p>
                    <p class="size08rem">
                        <a href="{{ route('user.pet_registration') }}" class="text-white">Register Pet</a>
                    </p>
                    @if (Route::has('user.login'))
                        @auth
                            <p class="size08rem">
                                <a href="{{ route('dashboard') }}" class="text-white">Visit Lounge</a>
                            </p>
                        @else
                            <p class="size08rem">
                                <a href="{{ route('user.login') }}" class="text-white">Sign-in</a>
                            </p>
                            <p class="size08rem">
                                <a href="{{ route('user.email_confirmation') }}" class="text-white">Create account</a>
                            </p>
                        @endauth
                    @endif
                    <p class="size08rem">
                        <a class="text-white">Help</a>
                    </p>
                </div>

                {{-- Footer Divider --}}
                <hr class="w-100 clearfix d-md-none" />

                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
                    <h6 class="text-uppercase mb-4 font-weight-bold">Contact</h6>
                    <p class="size08rem">
                        Tel # - (02) 8647 1356
                    </p>
                    <p class="size08rem">
                        Sun - 0922-253-6908
                    </p>
                    <p class="size08rem">
                        TM - 09678417135
                    </p>
                    <p class="size08rem">
                        Globe Landline - 7118 8400
                    </p>
                    <p class="size08rem">
                        Viber - 09678417135
                    </p>
                    <p class="size08rem">
                        WhatsApp - 09678417135
                    </p>
                    <p class="size08rem">
                        Email Address - corporatemetaanimals@gmail.com
                    </p>
                </div>
              </div>
            </section>
            <hr class="my-3">

            {{-- Footer Branding --}}
            <section class="p-3 pt-0">
              <div class="row d-flex align-items-center">
                <div class="col-md-7 col-lg-8 text-center text-md-start">
                  <div class="p-3 size08rem">
                    © 2022 Copyright: <a class="text-white" href="https://metaanimals.tech/" target="_blank">Meta Animals</a>
                  </div>
                </div>
                <div class="col-md-5 col-lg-4 ml-lg-0 text-center text-md-end">

                    <a href="https://www.facebook.com/metaanimalstech" class="btn btn-outline-light btn-floating m-1" role="button">
                        <i class="mdi mdi-facebook"></i>
                    </a>

                    <a href="https://www.youtube.com/@manalok9" class="btn btn-outline-light btn-floating m-1" role="button">
                        <i class="mdi mdi-youtube"></i>
                    </a>

                    <a href="https://twitter.com/manalok9" class="btn btn-outline-light btn-floating m-1" role="button">
                        <i class="mdi mdi-twitter"></i>
                    </a>

                    <a href="https://www.instagram.com/metaccd/" class="btn btn-outline-light btn-floating m-1" role="button">
                        <i class="mdi mdi-instagram"></i>
                    </a>

                </div>

              </div>
            </section>
          </div>
    </footer>

</body>
<script src="{{ asset('landing_page/js/jquery-3.6.0.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="{{ asset('landing_page/js/bootstrap.min.js') }}"></script>
</html>
