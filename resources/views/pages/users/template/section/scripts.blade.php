@include('pages/users/template/modals/post_feed/modal-search-result')
@include('pages/users/template/modals/post_feed/modal-share-post')

@env('APP_ENV','production')
@if (Request::url() != route('user.messenger'))
<!-- Messenger Chat Plugin Code -->
<div id="fb-root"></div>
<!-- Your Chat Plugin code -->
<div id="fb-customer-chat" class="fb-customerchat">
</div>

<script>
    var chatbox = document.getElementById('fb-customer-chat');
    chatbox.setAttribute("page_id", "105229334564885");
    chatbox.setAttribute("attribution", "biz_inbox");
</script>

<!-- Your SDK code -->
<script>
    window.fbAsyncInit = function() {
        FB.init({
            xfbml: true,
            version: 'v15.0'
        });
    };

    (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s);
        js.id = id;
        js.src = 'https://connect.facebook.net/en_US/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
@endif
@endenv




<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>


{{-- <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script> --}}


{{-- DATATABLES --}}
<script src="{{ asset('DataTable_B5/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('DataTable_B5/dataTables.bootstrap5.min.js') }}"></script>

{{-- TOAST --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>




{{-- MOMENT JS --}}
<script src="https://momentjs.com/downloads/moment.js"></script>
<script src="https://momentjs.com/downloads/moment-with-locales.min.js"></script>

<script src="https://momentjs.com/downloads/moment-timezone-with-data.js"></script>

{{-- CUSTOM --}}
<script src="https://cdn.jsdelivr.net/npm/howler@2.2.3/dist/howler.core.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- EMOJI SUPPORT --}}
<script type="text/javascript" src="{{ asset('emoji_keyboard/emojionearea.min.js') }}"></script>


<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/lara-echo.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        /* CHECK USER TIMEZONE */
        var timez = moment.tz.guess();
        var cur_timez = '{{ Auth::guard('web')->user()->timezone }}';
        if (cur_timez != timez) {
            $.ajax({
                type: "post",
                url: window.thisUrl + "/UpdateTimezUser",
                data: {
                    timez: timez
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    console.log(response);
                }
            });
        }
        $('body').on('click', '.btn', function(event) {
            let clickedElement = event.target;
            let button = $(clickedElement).closest('.btn');

            setTimeout(function() {
                button.blur();
            }, 300)
        });
    });
</script>
<script type="text/javascript">
    window.audioUrl = "{{ asset('audio/message-tone-in-the-end.ogg') }}";
    var audioNotif = new Howl({
        src: window.audioUrl
    });

    window.id = '{{ Auth::guard('web')->user()->id }}';
    window.uuid = '{{ Auth::guard('web')->user()->uuid }}';
    window.urlAssets = "{{ asset('/') }}";
    window.thisUrl = "{{ URL::to('/') }}";
    window.first_name = '{{ Auth::guard('web')->user()->first_name }}';
    window.profile_image = '{{ Auth::guard('web')->user()->profile_image }}';
</script>
<script src="{{ asset('js/user-global-scripts.js') }}"></script>
<script src="{{ asset('js/members_js/users-scripts.js') }}"></script>
