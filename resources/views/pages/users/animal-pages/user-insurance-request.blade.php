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
                                    "Pets are family. They make things more fun and brighter when they are around. However, taking care of them entails some expenses that are needed to be taken care of – Especially for animal health. We understand your worry regarding vet bills. And to assist you in taking care of them. We pride ourselves in introducing – Meta Animals Insurance."
                                </h5>

                            </div>
                            <div class="mb-3">
                                <a href="https://mai.metaanimals.org/insurance" type="button" class="btn btn-primary" target="_BLANK" rel="noopener noreferrer">
                                    Apply for insurance
                                </a>
                            </div>
                            {{-- <div class="mb-3">
                                <h5>
                                    For assistance!
                                </h5>
                                <div class="d-flex flex-column">
                                    <div class="col-12 col-sm-12 col-xl-4 mb-3">
                                        <label for="" class="form-label">
                                            Contact Number
                                        </label>
                                          <input type="text"
                                            class="form-control" placeholder="">
                                    </div>
                                    <div class="col-12 col-sm-12 col-xl-4 mb-3">
                                        <label for="" class="form-label">
                                            Facebook Link/URL
                                        </label>
                                          <input type="text"
                                            class="form-control" placeholder="">
                                    </div>
                                    <div class="col-12 col-sm-12 col-xl-4 mb-3">
                                        <button type="button" class="btn btn-primary">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </div> --}}





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
