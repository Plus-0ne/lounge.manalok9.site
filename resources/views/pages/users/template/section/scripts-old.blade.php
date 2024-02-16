<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>


{{-- <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script> --}}


{{-- DATATABLES --}}
<script src="{{ asset('DataTable_B5/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('DataTable_B5/dataTables.bootstrap5.min.js') }}"></script>

{{-- TOAST --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>


{{-- EMOJI SUPPORT --}}
<script type="text/javascript" src="{{ asset('emoji_keyboard/emojionearea.min.js') }}"></script>

{{-- MOMENT JS --}}
<script src="https://momentjs.com/downloads/moment.js"></script>
<script src="https://momentjs.com/downloads/moment-with-locales.min.js"></script>

<script src="https://momentjs.com/downloads/moment-timezone-with-data.js"></script>

{{-- CUSTOM --}}

<script src="{{ asset('js/members_js/users-scripts.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        /* CHECK USER TIMEZONE */
        var timez = moment.tz.guess();
        var cur_timez = '{{ Auth::guard('web')->user()->timezone }}';
        if (cur_timez != timez) {
            $.ajax({
                type: "post",
                url: "UpdateTimezUser",
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
    });
</script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/lara-echo.js') }}"></script>

<script type="text/javascript">

    $(document).ready(function () {
        var audioNotif = new Audio("{{ asset('audio/message-tone-in-the-end.ogg') }}");
        var id = '{{ Auth::guard('web')->user()->id }}';
        var uuid = '{{ Auth::guard('web')->user()->uuid }}';


        Echo.private('my.notification.' + id)
        .notification((notification) => {
            // alert(notification.message);
            toastr["success"](notification.message);
            audioNotif.play();
        });


    });
</script>
<script type="text/javascript">
    window.audioNotif = new Audio("{{ asset('audio/message-tone-in-the-end.ogg') }}");
    window.id = '{{ Auth::guard('web')->user()->id }}';
    window.uuid = '{{ Auth::guard('web')->user()->uuid }}';
    window.urlAssets = "{{ asset('/') }}";
    window.thisUrl = "{{ URL::to('/') }}";
</script>
<script src="{{ asset('js/user-global-scripts.js') }}"></script>
