@include('pages/users/template/section/scripts-var')

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>

{{-- DATATABLES --}}
<script src="{{ asset('DataTable_B5/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('DataTable_B5/dataTables.bootstrap5.min.js') }}"></script>

{{-- MOMENT JS --}}
<script src="https://momentjs.com/downloads/moment.js"></script>
<script src="https://momentjs.com/downloads/moment-with-locales.min.js"></script>
<script src="https://momentjs.com/downloads/moment-timezone-with-data.js"></script>

{{-- TOAST --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="{{ asset('js/admin-scripts.js') }}"></script>
