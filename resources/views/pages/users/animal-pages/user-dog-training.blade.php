{{-- HEADER CONTAINS CSS LINKS --}}
@include('pages/users/template/section/header')
{{-- <link rel="stylesheet" href="{{ asset('owlcarousel/assets/owl.carousel.min.css') }}"> --}}
{{-- <link rel="stylesheet" href="{{ asset('owlcarousel/assets/owl.theme.default.min.css') }}"> --}}
<link rel="stylesheet" href="{{ asset('css/post_feed.css') }}">
</head>

<body>
    <div class="wrapper">

        {{-- TOP NAVIGATION --}}
        @include('pages/users/template/section/header_nav')

        <div class="main">

            {{-- SIDEABAR --}}
            @include('pages/users/template/section/sidebar')

            <div class="main-content h-100">
                <div class="container-fluid container-xl">
                    <div class="row">
                        {{-- Content here --}}
                        <div class="write_post_section">
                            <div class="d-flex flex-row">
                                <div>
                                    <a href="@if (url()->previous()) {{ url()->previous() }} @else {{ route('dashboard') }} @endif"
                                        class="btn btn-secondary btn-sm">
                                        <span class="mdi mdi-chevron-left text-light"></span>
                                        Back
                                    </a>
                                </div>
                            </div>

                            <hr>

                            <div class="mb-3">
                                <h5>
                                    "We are very familiar in training a wide variety of dogs from German Shepherds,
                                    Belgian Malinois, Pitbull, American Bully, Rottweiler, Shih Tzu, English Bully,
                                    Alaskan Malamute, Pug, Chow chow, Golden Retriever, Maltese, Labrador, Aspin,
                                    Doberman, Japanese Spitz, Pomeranian, Beagle, Anatolian mastiff, Poodle, Rhodesian
                                    Ridgeback, Jack Russel Terrier, Dutch Shepherd, St. Bernard German Pointer, Husky
                                    more!"
                                </h5>

                            </div>
                            <div class="mb-3">
                                <h5>
                                    For assitance!
                                </h5>
                                <div class="d-flex flex-column">
                                    <div class="col-12 col-sm-12 col-xl-4 mb-3">
                                        <label for="updated_contact" class="form-label">
                                            Updated contact number
                                        </label>
                                        <input id="updated_contact" type="text" class="form-control form-control-sm" placeholder="+630000000000">
                                        <div id="updated_contacthelpText"></div>
                                    </div>
                                    <div class="col-12 col-sm-12 col-xl-4 mb-3">
                                        <label for="facebook_link" class="form-label">
                                            Facebook Link/URL
                                        </label>
                                        <input id="facebook_link" type="text" class="form-control form-control-sm" placeholder="">
                                    </div>
                                    <div class="col-12 col-sm-12 col-xl-4 mb-3">
                                        <button id="avail_dog_registration" type="button" class="btn btn-primary">
                                            Submit
                                        </button>
                                    </div>
                                    <div id="prompt_sections" class="col-12">

                                    </div>
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

    {{-- SCRIPTS --}}

    @include('pages/users/template/section/scripts')
    @include('pages/users/template/section/scripts-var')
    <script src="{{ asset('js/animal-pages/avail-dog-training.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            @if (Session::has('status'))
                @switch(Session::get('status'))
                    @case('error')
                    var message = "{{ Session::get('message') }}";

                    toastr["error"](message);
                    @break

                    @case('success')
                    var message = "{{ Session::get('message') }}";
                    toastr["success"](message);
                    @break

                    @default
                @endswitch
            @endif
        });
    </script>

</body>

</html>
