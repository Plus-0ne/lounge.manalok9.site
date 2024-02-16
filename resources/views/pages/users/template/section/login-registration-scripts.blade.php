<script src="{{ asset('js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
{{-- MOMENT JS --}}
<script src="https://momentjs.com/downloads/moment.js"></script>
<script src="https://momentjs.com/downloads/moment-with-locales.min.js"></script>

<script src="https://momentjs.com/downloads/moment-timezone-with-data.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var timez = moment.tz.guess();
        $('#tiemxx').val(timez);
        var domain_name_text = '{{ Request::getHost() }}';
    });
</script>
