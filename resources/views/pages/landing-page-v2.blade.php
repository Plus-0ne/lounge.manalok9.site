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
    <link href="{{ asset('css/bootstrap-icons.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@6.6.96/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="{{ asset('css/welcome-landing-v3.css?v=2') }}">
    <style>
        body {
            background: rgb(14,0,36);
            background: linear-gradient(0deg, rgba(14,0,36,1) 36%, rgba(0,0,0,1) 79%, rgba(0,0,0,1) 100%);
        }
        .container-l img {
            width: 80%;
            height: fit-content;
        }

        .main {
            /* min-height: 100vh; */
        }

        .container-l {
            min-height: 75vh;
        }

        .form-email-lookup {
            color: white;
        }

        .fel-header {
            color: white;
        }

        .lp-button {
            padding: 1rem 1.5rem 1rem 1.5rem;
        }

        .lp-button:hover {

        }

        .fonts-1rem {
            font-size: 1rem;
        }

        .fonts-1-3rem {
            font-size: 0.7rem;
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

        .btn {
            border-radius: 24px;
        }
        .btn:focus,.btn:active:focus,.btn.active:focus,
        .btn.focus,.btn:active.focus,.btn.active.focus {
            outline: none;
            box-shadow: none;
        }
        .btn .non-mica:focus {
            transition: none !important;
            transform: scale(1) !important;
        }
        .btn .non-mica:active {
            transform: scale(1) !important;
        }
        .btn:focus {
            transition: all 0.2s cubic-bezier(0.22, 0.68, 0, 1.71);
            transform: scale(0.9);
        }
        .btn:active {
            transform: scale(1.0);
        }
        /* .btn:active {
            transition: all 0.08s cubic-bezier(0.22, 0.68, 0, 1.71);
            transform: scale(1);
        } */
        .btn-primary {
            background-color: rgb(114 0 189 / 75%);
            border: 2px solid transparent;
            border-top: 1px solid rgb(135 135 135 / 25%);
        }
        .btn-primary:hover, .btn-primary:focus, .btn-primary:active {
            background-color: rgba(100, 1, 167, 0.75);
            border: 2px solid transparent;
            border-top: 1px solid rgb(135 135 135 / 25%);
        }
        .btn-primary:disabled, .btn-primary.disabled {
            background-color: rgba(53, 0, 88, 0.75);
            border: 2px solid transparent;
            border-top: 1px solid rgba(56, 19, 73, 0.5);
        }
        .btn-secondary {
            background-color: rgba(49, 44, 87, 0.5);
            border: 2px solid transparent;
            border-top: 1px solid rgba(88, 88, 88, 0.25);
            /* color: var(--font-color-family); */
        }
        .btn-secondary:hover, .btn-secondary:focus, .btn-secondary:active {
            background-color: rgba(49, 44, 87, 0.75);
            border: 2px solid transparent;
            border-top: 1px solid rgba(88, 88, 88, 0.25);
        }
        .btn-secondary:disabled, .btn-secondary.disabled {
            background-color: rgba(49, 44, 87, 0.75);
            border: 2px solid transparent;
            border-top: 1px solid rgba(49, 44, 87, 0.75);
        }
        .btn-ssm {
            border-radius: 8px;
            font-size: 11px;
            padding: 4px;
        }
        .analytics-members-count {
            display: block;
            font-size: 64px;
            font-family: courier;
            opacity: 0;
            transition: 0.5s;
        }
        .form-control {
            background-color: rgba(0, 0, 0, 0.33);
            color: #eee;
            border-radius: 12px 0px 0px 12px;
            border: none;
        }
        .form-control:focus, .form-control:active {
            background-color: rgba(0, 0, 0, 0.33);
            color: #eee;
            z-index: 1 !important;
            outline: none !important;
            box-shadow: none !important;
        }
        .input-group, .promptss-v2 {
            max-width: 100%;
        }
        .verify_emailAddress, .register-button {
            font-size: 0.7rem;
        }

        @media (min-width: 576px) {
            .fonts-1-3rem {
                font-size: 0.7rem;
            }
            .container-l img {
                width: 65%;
                height: fit-content;
            }
            .verify_emailAddress, .register-button {
                font-size: 0.7rem;
            }
            .input-group, .promptss-v2 {
                max-width: 400px;
            }
        }

        @media (min-width: 768px) {
            .fonts-1-3rem {
                font-size: 1.3rem;
            }
            .container-l img {
                width: 65%;
                height: fit-content;
            }
            .verify_emailAddress, .register-button {
                font-size: 1rem;
            }
            .input-group, .promptss-v2 {
                max-width: 100%;
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
            .verify_emailAddress, .register-button {
                font-size: 1rem;
            }
            .input-group, .promptss-v2 {
                max-width: 100%;
            }
        }

        @media (min-width: 1200px) {
            .fonts-1-3rem {
                font-size: 1.3rem;
            }
            .verify_emailAddress, .register-button {
                font-size: 1rem;
            }
            .input-group, .promptss-v2 {
                max-width: 100%;
            }
        }
    </style>
</head>

<body>
    <!-- <div class="analytics">
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
  
    </div> -->

    <div class="wrapper">
        <div class="main">
            <div class="main-content d-flex flex-wrap">
                <div class="container-l col-12 d-flex flex-column justify-content-center align-items-middle mt-2">
                    <img class="ms-auto me-auto animate__animated animate__fadeIn" src="{{ asset('img/official-iagd-logo-V2.png') }}"
                        alt="International Animals Genetics Database">
                    <div class="d-flex flex-wrap justify-content-center animate__animated animate__fadeIn">
                        <a href="https://manalok9.com/" class="lp-button btn btn-secondary fonts-1-3rem me-3 mt-4 font-family-poppins-sans-serif" target="_blank" rel="noopener noreferrer">
                            Official Meta Animals Website
                        </a>
                        @if (Route::has('user.login'))
                            @auth
                                <a href="{{ route('dashboard') }}" class="lp-button btn btn-primary fonts-1-3rem mt-4 font-family-poppins-sans-serif">
                                    <i class="bi bi-cup-hot-fill" style="vertical-align: 0;"></i> Visit Lounge
                                </a>
                            @else
                                <a href="{{ route('user.login') }}" class="lp-button btn btn-primary fonts-1-3rem mt-4 font-family-poppins-sans-serif">
                                    <i class="bi bi-cup-hot-fill" style="vertical-align: 0;"></i> Sign-in
                                </a>
                            @endauth
                        @endif
                    </div>
                    <div class="text-center mt-3">
                        <layflags-rolling-number class="analytics-members-count">{{ $analytics['users_registered'] }}</layflags-rolling-number>
                        <div class="analytics-members-text-label" style="opacity: 0; position: relative;"><i class="bi bi-people-fill" style="position: absolute; font-size: 144px; opacity: 0.04; top: -133px;"></i> members registered</div>
                    </div>
                    <div class="form-email-lookup ms-auto me-auto col-11 col-md-8" style="opacity: 0;">
                        <div class="mt-3 pt-1 pb-1 pt-lg-5 pb-lg-5 text-center">
                            <div class="promptss-v2 mb-2" style="width: 520px; margin: 0 auto;">
                            </div>
                            <div class="input-group mb-3" style="margin: 0 auto; width: 525px;">
                            	<input type="email" class="email_address form-control font-family-poppins-sans-serif" name=""
                                aria-describedby="helpId" placeholder="Your Email (e.g. hello@example.com)"
                                autocomplete="off" style="display: inline-block;">
                            	<button class="verify_emailAddress btn btn-secondary btn-lg input-group-text" style="width: 125px;
                                    padding: 15px 0px;
                                    margin-bottom: 1px;
                                    margin-left: -5px;
                                    border-radius: 0px 12px 12px 0px;">
	                                <span class="register-button font-family-poppins-sans-serif">
	                                    Register
	                                </span>
	                            </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer">
        <div class="container-fluid p-4 pb-0">
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
            <div class="my-3"></div>

            {{-- Footer Branding --}}
            <section class="p-3 pt-0">
                <div class="row d-flex align-items-center">
                    <div class="col-md-7 col-lg-8 text-center text-md-start">
                        <div class="p-3 size08rem">
                            © 2024 Copyright: <a class="text-white" href="https://manalok9.com/"
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
<script type="module" src="https://unpkg.com/@layflags/rolling-number@1.0.0/rolling-number.js"></script>
<script type="text/javascript">
    function rotateGradient(element, angle) {
        element.css('background', `linear-gradient(${angle}deg, rgba(14,0,36,1) 36%, rgba(0,0,0,1) 79%, rgba(0,0,0,1) 100%)`);
    }
    $(document).ready(function() {
        var timez = moment.tz.guess();
        $('#tiemxx').val(timez);

        rotateGradient($('body'), 0); 

        $('body').animate({ rotation: 90 }, {
            duration: 500, 
            step: function(currentAngle) {
                rotateGradient($('body'), currentAngle); 
            },
            complete: function() {
                setTimeout(function() {
                    rotateGradient($('body'), 90); 
                    $('body').animate({ rotation: 135 }, {
                        duration: 500, 
                        step: function(currentAngle) {
                            rotateGradient($('body'), currentAngle); 
                        }
                    });
                }, 250); 
            }
        }); 

        // setTimeout(function() {
        //     $('body').animate({ rotation: 135 }, {
        //         duration: 1000,
        //         step: function(currentAngle) {
        //             rotateGradient($('body'), currentAngle); 
        //         }
        //     }); 
        // }, 2000);

        $('.analytics-members-count').css('opacity', 1);
        setTimeout(function() {
            $('.analytics-members-text-label').css('transition', '0.5s');
            $('.analytics-members-text-label').css('opacity', 1);
        }, 750);
        setTimeout(function() {
            $('.form-email-lookup').css('transition', '0.5s');
            $('.form-email-lookup').css('opacity', 1);
        }, 1250);
    });
</script>
<script src="{{ asset('js/user-login.js?v=3') }}"></script>

</html>
