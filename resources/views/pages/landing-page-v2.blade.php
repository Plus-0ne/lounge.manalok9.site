<!DOCTYPE html>
<html lang="en">

<head>
    {{-- SEO --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    @include('pages.users.template.section.meta-og')

    <title>
        International Animals Genetic Database
    </title>
    <link rel="stylesheet" href="{{ asset('landing_page/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@6.6.96/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="{{ asset('css/welcome-landing-v2.css') }}">
    <style>
        .container-l img {
            width: 80%;
            height: fit-content;
        }

        .main {
            /* min-height: 100vh; */
        }

        .container-l {
            min-height: 100vh;
        }

        .form-email-lookup {
            background-color: #fff;
            border-radius: 3px;
        }

        .fel-header {
            color: rgb(34, 34, 34);
        }

        .lp-button {
            background-color: transparent;
            color: #fff;
            padding: 1rem 1.5rem 1rem 1.5rem;
            border: 1px solid #fff;
            border-radius: 5px;
            transition: all ease-in-out 0.2s;
            -webkit-transition: all ease-in-out 0.2s;
            -moz-transition: all ease-in-out 0.2s;
            -ms-transition: all ease-in-out 0.2s;
            text-decoration: none;
        }

        .lp-button:hover {
            background-color: #fff;
            color: rgb(34, 34, 34);
            border: 1px solid rgb(34, 34, 34);
        }

        .fonts-1rem {
            font-size: 1rem;
        }

        .fonts-1-3rem {
            font-size: 0.65rem;
        }

        @media (min-width: 576px) {
            .fonts-1-3rem {
                font-size: 0.65rem;
            }
        }

        @media (min-width: 768px) {
            .fonts-1-3rem {
                font-size: 0.65rem;
            }
        }

        @media (min-width: 992px) {
            .fonts-1-3rem {
                font-size: 1.3rem;
            }

            .container-l img {
                width: 50%;
                height: fit-content;
            }
        }

        @media (min-width: 1200px) {
            .fonts-1-3rem {
                font-size: 1.3rem;
            }
        }

        .analytics {
            position: fixed;
            top: 0;
            right: 0;
            background-color: #b00;
            padding: 5px 0 10px 20px;
            font-size: 1rem;
            font-weight: bold;
            color: #fff;
            text-shadow: 3px 3px 2px rgba(86, 1, 1, 1);
            border-radius: 0 0 0 15px;
        }

        .analytics .registered {
            position: relative;
            top: 0;
            background-color: #f11;
            padding: 5px 15px 10px 20px;
            font-size: 1rem;
            font-weight: bold;
            color: #fff;
            text-shadow: 3px 3px 2px rgba(86, 1, 1, 1);
            border-radius: 0 0 0 15px;
        }
    </style>
</head>

<body>
    <div class="analytics">
        Online: <i class="ps-1 pe-3">{{ $analytics['users_online'] ?? '?' }}</i>
        <span class="registered">
            Members: <i class="ps-1 pe-2">{{ $analytics['users_registered'] ?? '?' }}</i>
        </span>
 

                        @if (Route::has('user.login'))
                            @auth
                                <a href="{{ route('dashboard') }}"  class="lp-button fonts-1-3rem mt-1 " style="border:none">
                                    Visit Lounge
                                </a>
                            @else
                                <a href="{{ route('user.login') }}"  class="lp-button fonts-1-3rem mt-1 " style="border:none" >
                                    Sign-in
                                </a>
                            @endauth
                        @endif
  
    </div>

    <div class="wrapper">
        <div class="main">
            <div class="main-content d-flex flex-wrap">
                <div
                    class="container-l col-12 col-md-6 col-lg-4 d-flex flex-column justify-content-center align-items-middle">
                    <div class="form-email-lookup ms-auto me-auto col-11 col-md-8 p-3 p-lg-4 animate__animated animate__fadeIn">
                        <div class="fel-header pt-5 d-flex justify-content-center font-family-poppins-sans-serif">
                            <h4>
                                Register account
                            </h4>
                        </div>
                        <div class="pt-1 pb-1 pt-lg-5 pb-lg-5">
                            <div class="promptss-v2 mb-2">

                            </div>
                            <div class="d-flex flex-column">
                                <input id="email_address" type="email" class="form-control p-3 font-family-poppins-sans-serif" name=""
                                    id="" aria-describedby="helpId" placeholder="Email Address"
                                    autocomplete="off">
                                <button id="verify_emailAddress" class="btn btn-primary mt-3 p-2 p-lg-3 btn-lg">
                                    <span style="font-size: 1rem;" class="font-family-poppins-sans-serif">
                                        Register
                                    </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="container-l col-12 col-md-6 col-lg-8 d-flex flex-column justify-content-center align-items-middle mt-5">
                    <img class="ms-auto me-auto animate__animated animate__fadeIn" src="{{ asset('img/official-iagd-logo-V2.png') }}"
                        alt="International Animals Genetics Database">
                    <div class="d-flex flex-wrap justify-content-center animate__animated animate__fadeIn">
                        <a href="https://metaanimals.tech/" class="lp-button fonts-1-3rem me-3 mt-4 font-family-poppins-sans-serif" target="_blank" rel="noopener noreferrer">
                            Official Meta Animals Website
                        </a>
                        @if (Route::has('user.login'))
                            @auth
                                <a href="{{ route('dashboard') }}" class="lp-button fonts-1-3rem mt-4 font-family-poppins-sans-serif">
                                    Visit Lounge
                                </a>
                            @else
                                <a href="{{ route('user.login') }}" class="lp-button fonts-1-3rem mt-4 font-family-poppins-sans-serif">
                                    Sign-in
                                </a>
                            @endauth
                        @endif
                    </div>

                    <div class="d-flex flex-wrap justify-content-center p-5">
                        <video class="mx-auto w-100 animate__animated animate__fadeIn" src="{{ asset('/videos/MEMBER-LOUNGE-TUTORIAL.mp4') }}"
                            type="video/mp4" autoplay muted loop controls="true" volume="1.0" {{-- poster="{{asset('/img/MEMBER-LOUNGE-TUTORIAL-thumbnail.png')}}" --}}
                            style="max-width: 750px;"></video>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <footer class="footer">
        <div class="container-fluid p-4 pb-0">
            <hr>
            {{-- Footer Content Section --}}
            <section class="">
                <div class="row">
                    <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3 font-family-poppins-sans-serif">
                        <h6 class="text-uppercase mb-4 font-weight-bold">
                            IAGD by Meta Animals
                        </h6>
                        <p class="size08rem justify-content text-wrap">
                        <p>The International Animals Genetics Database (IAGD) is the all-animal registry arm of Meta
                            Animals Technologies Corporation.</p>
                        <p>It is a documentation system that has physical (hardcopy certificates) and online components.
                        </p>
                        <p>Unlike old-school registries, it uses the latest hi-tech tools available that pet owners and
                            animal establishment managers alike can utilize, such as individual profile QR codes, an
                            online community called the Lounge, social media links, as well as levels of verification
                            (LoVe) for individual animals that include notarized owner affidavit, veterinarian
                            certificate of identity, microchip data, DNA profiles and parent verification test result
                            inputs.</p>
                        </p>
                    </div>
                    <hr class="w-100 clearfix d-md-none" />
                    <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3 font-family-poppins-sans-serif">
                        <h6 class="text-uppercase mb-4 font-weight-bold">Products</h6>
                        <p class="size08rem">
                            <a href="https://metaanimals.tech/sdn/" class="text-white" target="_blank" rel="noopener noreferrer">SDN</a>
                        </p>
                    </div>
                    <hr class="w-100 clearfix d-md-none" />
                    <div class="col-md-3 col-lg-2 col-xl-2 mx-auto mt-3 font-family-poppins-sans-serif">
                        <h6 class="text-uppercase mb-4 font-weight-bold">
                            Useful links
                        </h6>
                        <p class="size08rem">
                            <a href="https://metaanimals.tech" class="text-white" target="_blank" rel="noopener noreferrer">Meta Animals Official
                                Website</a>
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
                            @endauth
                        @endif
                        <p class="size08rem">
                            <a href="{{ route('user.terms_condition') }}" class="text-white" target="_blank" rel="noopener noreferrer">Terms &
                                condition</a>
                        </p>
                        <p class="size08rem">
                            <a href="{{ route('user.cookies_policy') }}" class="text-white" target="_blank" rel="noopener noreferrer">Cookies
                                policy</a>
                        </p>
                        <p class="size08rem">
                            <a href="{{ route('user.privacy_policy') }}" class="text-white" target="_blank" rel="noopener noreferrer">Privacy
                                policy</a>
                        </p>
                        <p class="size08rem">
                            <a class="text-white" thereisnohelp>Help</a>
                        </p>
                    </div>

                    {{-- Footer Divider --}}
                    <hr class="w-100 clearfix d-md-none" />

                    <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3 font-family-poppins-sans-serif">
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
                            © 2022 Copyright: <a class="text-white" href="https://metaanimals.tech/"
                                target="_blank" rel="noopener noreferrer">Meta Animals</a>
                        </div>
                    </div>
                    <div class="col-md-5 col-lg-4 ml-lg-0 text-center text-md-end">

                        <a href="https://www.facebook.com/metaanimalstech"
                            class="btn btn-outline-light btn-floating m-1" role="button">
                            <i class="mdi mdi-facebook"></i>
                        </a>

                        <a href="https://www.youtube.com/@manalok9" class="btn btn-outline-light btn-floating m-1"
                            role="button">
                            <i class="mdi mdi-youtube"></i>
                        </a>

                        <a href="https://twitter.com/manalok9" class="btn btn-outline-light btn-floating m-1"
                            role="button">
                            <i class="mdi mdi-twitter"></i>
                        </a>

                        <a href="https://www.instagram.com/metaccd/" class="btn btn-outline-light btn-floating m-1"
                            role="button">
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
{{-- MOMENT JS --}}
<script src="https://momentjs.com/downloads/moment.js"></script>
<script src="https://momentjs.com/downloads/moment-with-locales.min.js"></script>

<script src="https://momentjs.com/downloads/moment-timezone-with-data.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var timez = moment.tz.guess();
        $('#tiemxx').val(timez);
    });
</script>
<script src="{{ asset('js/user-login.js') }}"></script>

</html>
