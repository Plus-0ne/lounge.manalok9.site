<!DOCTYPE html>
<html lang="en">

@include('pages/landing/section/landing-header')

<style>
    /* =================== GOOGLE FONTS ====================== */
    @import url('https://fonts.googleapis.com/css2?family=Montserrat&family=Roboto&display=swap');


    /* =================== CSS VARIABLES ====================== */
    :root {
        --li-primary: #1e2530;
        --li-light: #fcfcfc;
        --li-tcolor-light: #fcfcfc;
        --li-tcolor-dark: #292929;
        --li-fsize-px16: 16px;
        --li-fsize-rem1: 1rem;
        --li-fstyle-primary: font-family: 'Roboto', sans-serif;
        --li-fstyle-secondary: font-family: 'Montserrat', sans-serif !important;
    }

    /* =================== GLOBAL ====================== */
    html,
    body {
        background-color: var(--li-primary);
        min-height: 100%;
        height: 100%;
        content: "";
        clear: both;
        box-sizing: border-box;
        padding: 0;
        margin: 0;
        overflow-x: hidden;
    }

    /* =================== LOADING ====================== */
    #loading-screen-fixed {
        position: absolute;
        min-width: 100%;
        width: 100%;
        min-height: 100%;
        height: 100%;
        background-color: var(--li-primary);
        z-index: 999;
    }

    .loading-img-logo img {
        width: 130px;
    }

    .loading-img-txt h6 {
        color: var(--li-tcolor-light);
    }

    .loading-img-txt p i {
        color: var(--li-tcolor-light);
        font-size: 30px;
        margin-right: 9px;
    }

    /* =================== WRAPPER ====================== */
    .wrapper {
        min-height: 100vh;
        display: flex;
        font-family: var(--li-fstyle-primary);
        color: var(--li-text-primary);
        position: relative;
    }

    .header {
        padding-top: 1rem;
    }

    .img-iden-1 {
        width: 330px;
    }

    .nav-custom-btn {
        text-decoration: none;

    }

    .nav-content-link {
        color: var(--li-tcolor-dark);
        font-size: 14px;
        padding-left: 18px;
        padding-right: 18px;
        background-color: var(--li-light);
        min-width: 150px;
        text-align: center;
        padding-top: 6px;
        padding-bottom: 6px;
        font-weight: bold;
    }

    .main-content {
        min-height: 100%;
        font-family: 'Montserrat', sans-serif !important;
        color: var(--li-tcolor-light);

    }

    .image-container {
        width: 240px;
    }

    .image-content {
        width: 240px;
    }

    .image-content img {
        width: 100%;
        object-fit: contain;
    }

    .image-description h3 {
        font-weight: bold;
    }

    .image-description p {
        font-size: 14px;
    }

    .padd-bot {
        padding-bottom: 100px;
    }

    .padd-top {
        padding-top: 100px;
    }

    .image-content {
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
        -webkit-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
        -moz-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
        -ms-box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);


    }

    .image-content:hover img {
        transform: scale(1.03);
        -webkit-transform: scale(1.03);
        -moz-transform: scale(1.03);
        -ms-transform: scale(1.03);

        transition: all 0.3s ease-in-out;
        -webkit-transition: all 0.3s ease-in-out;
        -moz-transition: all 0.3s ease-in-out;
        -ms-transition: all 0.3s ease-in-out;
    }

</style>

<body>
    {{-- PAGE LOADER --}}
    <div id="loading-screen-fixed">
        <div class="d-flex flex-column justify-content-center h-100">
            <div class="loading-img-txt w-100 text-center mt-3">
                <p class="align-self-center">
                    <i class="mdi mdi-loading mdi-spin"></i>
                </p>
                <h6>
                    Loading...
                </h6>
            </div>
        </div>
    </div>

    {{-- WRAPPER --}}
    <div class="wrapper">
        <div class="container-fluid container-xl">
            <div class="header">
                <div class="d-flex flex-row justify-content-between">
                    <div class="img-identity">
                        <img class="img-iden-1" src="{{ asset('landing_page/img/IAGD-Banner-Logo---white.png') }}"
                            alt="Intertnational Animals Genetics Database">
                        <img class="img-iden-1"
                            src="{{ asset('landing_page/img/META-ANIMALS-BANNER-TYPE-LOGO-HD.png') }}"
                            alt="Meta Animals Technology">

                    </div>
                    <div class="nav-menu-custom d-flex flex-row">
                        <a class="nav-custom-btn me-3" href="{{ route('user.login') }}">
                            <div class="nav-content-link">
                                LOGIN
                            </div>
                        </a>
                        <a class="nav-custom-btn" href="{{ route('user.user_registration') }}">
                            <div class="nav-content-link">
                                REGISTER
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="main-content">
                <div class="d-flex flex-wrap justify-content-around justify-content-xl-between">


                    {{-- PADD BOTTOM --}}
                    <div
                        class="image-container d-flex flex-column justify-content-center alig-items-center padd-bot mt-5">
                        <div class="image-content">
                            <img src="{{ asset('landing_page/img/main-content-images/maincontent1.png') }}"
                                alt="ICGD">
                        </div>
                        <div class="image-description pt-2">
                            <h3>
                                ICGD
                            </h3>
                            <p>
                                International Canine Genetics Database
                            </p>
                        </div>
                    </div>

                    {{-- PADD TOP --}}
                    <div
                        class="image-container d-flex flex-column justify-content-center alig-items-center padd-top mt-5">
                        <div class="image-content">
                            <img src="{{ asset('landing_page/img/main-content-images/maincontent2.png') }}"
                                alt="ICGD">
                        </div>
                        <div class="image-description pt-2">
                            <h3>
                                IFGD
                            </h3>
                            <p>
                                International Feline Genetics Database
                            </p>
                        </div>
                    </div>

                    {{-- PADD BOTTOM --}}
                    <div
                        class="image-container d-flex flex-column justify-content-center alig-items-start padd-bot mt-5">
                        <div class="image-content">
                            <img src="{{ asset('landing_page/img/main-content-images/maincontent.png') }}" alt="ICGD">
                        </div>
                        <div class="image-description pt-2">
                            <h3>
                                Manalo K9
                            </h3>
                            <p>
                                <br>
                            </p>
                        </div>
                    </div>

                    {{-- PADD TOP --}}
                    <div
                        class="image-container d-flex flex-column justify-content-center alig-items-center padd-top mt-5">
                        <div class="image-content">
                            <img src="{{ asset('landing_page/img/main-content-images/maincontent3.png') }}"
                                alt="ICGD">
                        </div>
                        <div class="image-description pt-2">
                            <h3>
                                IRGD
                            </h3>
                            <p>
                                International Rabbit Genetics Database
                            </p>
                        </div>
                    </div>

                    {{-- PADD BOTTOM --}}
                    <div
                        class="image-container d-flex flex-column justify-content-center alig-items-center padd-bot mt-5">
                        <div class="image-content">
                            <img src="{{ asset('landing_page/img/main-content-images/maincontent4.png') }}"
                                alt="ICGD">
                        </div>
                        <div class="image-description pt-2">
                            <h3>
                                IBGD
                            </h3>
                            <p>
                                International Bird Genetics Database
                            </p>
                        </div>
                    </div>




                </div>
            </div>
        </div>
    </div>
</body>

@include('pages/landing/section/landing-scripts')

<script type="text/javascript">
    $(document).ready(function() {
        $('#loading-screen-fixed').fadeIn();


    });
    $(window).on('load', function() {
        $('#loading-screen-fixed').fadeOut();
        $('#loading-screen-fixed').remove();
    });
</script>

</html>
