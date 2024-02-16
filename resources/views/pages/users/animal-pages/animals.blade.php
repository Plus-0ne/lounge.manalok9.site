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

                        <div class="write_post_section">
                            {{-- Content here --}}

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
