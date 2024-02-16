{{-- HEADER CONTAINS CSS LINKS --}}
@include('pages/users/template/section/header')
<link rel="stylesheet" href="{{ asset('owlcarousel/assets/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ asset('owlcarousel/assets/owl.theme.default.min.css') }}">

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
                            <h1>Orders</h1>
                            @foreach ($products as $row)
                                <div class="card">
                                <div class="productList">
                                    <div class="price-tag clearfix"><p><b>Price : {{ $row->Price_PerItem }}</b></p></div>
                                        <h5>{{ $row->Product_Name }}</h5>
                                        <p>{{ $row->Description }}</p>
                                        <img class="imgProducts" src="{{ $row->Barcode_Images }}" alt="No Image available">
                                </div>
                                </div>
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>
            @include('pages/users/template/section/r-sidebar')
        </div>
    </div>

    {{-- Include bootstrap modal --}}
    @include('pages/users/template/modals/white-post-emoji')
    @include('pages/users/template/modals/post_feed/modal-delete-post')
    @include('pages/users/template/modals/post_feed/modal-view-reaction')
    @include('pages.users.template.modals.post_feed.modal-share-post')
    {{-- Include custom user toast --}}
    @include('pages/users/template/section/user-toasts')

    {{-- SCRIPTS --}}
    @include('pages/users/template/section/scripts')
    @include('pages/users/template/section/scripts-var')


    <script src="https://unpkg.com/picmo@5.1.0/dist/umd/picmo.js"></script>
    <script src="https://unpkg.com/@picmo/popup-picker@5.1.0/dist/umd/picmo-popup.js"></script>
    <script src="https://unpkg.com/@picmo/renderer-twemoji@5.1.0/dist/umd/picmo-twemoji.js"></script>

    <script src="{{ asset('owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('js/post_view.js?v=4') }}"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            /*
                Picmo emoji
            */
            const container = document.querySelector('#pickerNewemoji');
            const picker = picmo.createPicker({
                rootElement: container
            });

            let postTextarea = $('#postTextarea');

            picker.addEventListener('emoji:select', event => {
                postTextarea.val(postTextarea.val() + event.emoji);
            });
        });
    </script>
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

            /* Owl Carousel 2 */
            $('.owl-carousel').owlCarousel({
                items: 1,
                center: true,
                video: true,
                dots: false
            });

            var videoFull = $('.videoFull');
            videoFull.removeAttr('muted');
            videoFull.attr('volume', 0.5);;

            /* Convert date */
            var localDate = moment(testDateUtc).local();
            var postDateFormatted = localDate.format("MMMM DD YYYY - hh:mm A");
            $('.post_date').html('<small>Date posted on ' + postDateFormatted + '</small>');

            $('.show_comment_section').click();

            var sharedPDate = moment.utc(window.shared_post_created_date);
            var shareLocal = moment(sharedPDate).local();
            var newShareDate = shareLocal.format("MMMM DD YYYY - hh:mm A");
            $('.post_date_shared').html('<small>Date posted on ' + newShareDate + '</small>');

        });


    </script>
</body>



</html>
