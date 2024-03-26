{{-- HEADER CONTAINS CSS LINKS --}}
@include('pages/users/template/section/header')

<body>
    <div class="wrapper">

        {{-- TOP NAVIGATION --}}
        @include('pages/users/template/section/header_nav')

        <div class="main">

            {{-- SIDABAR --}}
            @include('pages/users/template/section/sidebar')

            <div class="main-content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- NEW TRADE -->
                        <form action="{{ route('user.create_trade') }}" method="post">
                            @csrf
                            <div class="p-4 rounded-3 bg-light section_shadow border border-1 border-light">
                                <div class="p-3 post_title">
                                    <h5><i class="mdi mdi-swap-horizontal-bold"></i> New Trade</h5>
                                </div>

                                <div class="p-3">
                                    <textarea id="example1" name="trade_description" class="form-control" rows="5" placeholder="Trade Description"></textarea>
                                </div>
                                <div class="p-3 text-end">
                                    <button type="submit" class="btn btn-primary">Publish Trade</button>
                                </div>
                            </div>
                        </form>
                        <!-- TRADE DIVIDER -->
                        <div class="mx-auto trades_divider"></div>
                        <!-- TRADE SECTION -->
                        <div class="trades_section">
                            <!-- TRADE 1 -->

                        </div>
                        <div class="spinner-load-data w-100 text-center" style="display: none;">
                            <div class="lds-facebook">
                                <div></div>
                                <div></div>
                                <div></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('pages/users/template/section/r-sidebar')
        </div>
    </div>
</body>

{{-- SCRIPTS --}}
<script>
    var user_iagd_number = "{{ Auth::guard('web')->user()->iagd_number }}";
    var user_current_trade_no = "{{ $data['current_trade_log']->trade_no ?? NULL }}";
    var user_current_trade_log_no = "{{ $data['current_trade_log']->trade_log_no ?? NULL }}";
    var user_current_trade_log_status = "{{ $data['current_trade_log']->log_status ?? NULL }}";
</script>
@include('pages/users/template/section/scripts')
<script src="{{ asset('/js/members_js/pt_scripts.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        @if (Session::has('response'))
            @switch(Session::get('response'))
                @case('key_error')
                    toastr["error"]("Something's wrong! Please try again later.", "Error");
                @break

                @case('trade_created')
                    toastr["success"]("Trade successfully posted", "Success!");
                @break
                @case('trade_failed')
                    toastr["warning"]("Something's wrong! Please try again later.", "Error");
                @break
                @case('trade_not_found')
                    toastr["warning"]("Something's wrong! Please try again later.", "Error");
                @break

                @default
            @endswitch
        @endif
        @if ($errors->any())
            toastr["warning"]('{{ $errors->first() }}', "Warning");
        @endif
    });
</script>

</html>
