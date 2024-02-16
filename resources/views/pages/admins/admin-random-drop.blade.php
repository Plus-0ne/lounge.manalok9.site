{{-- HEADER CONTAINS CSS LINKS --}}
@include('pages/admins/section/admin-header')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
</head>

<body>
    <div class="wrapper">

        {{-- TOP NAVIGATION --}}
        @include('pages/admins/section/admin-header_nav')

        <div class="main">

            {{-- SIDABAR --}}
            @include('pages/admins/section/admin-sidebar')

            <div class="main-content h-100">
                <div class="container-fluid">
                    <div class="row">
                        <div class="p-4 dashboard-section d-flex flex-wrap">
                            <div class="breadcrumb-text col-12 my-3 text-sm-center text-lg-start">
                                <h5>
                                    <i class="nav-icon mdi mdi-gift"></i> Gift drops
                                </h5>
                                <hr>
                            </div>

                            {{-- Content here --}}

                            <div class="d-flex flex-row">
                                <div>
                                    Action buttons
                                </div>
                                <div>
                                    Status
                                </div>
                            </div>

                            <div class="w-100">
                                <div class="table-responsive">
                                    <table id="rand_drops" class="table table-primary">
                                        <thead>
                                            <tr>
                                                <th scope="col">Column 1</th>
                                                <th scope="col">Column 2</th>
                                                <th scope="col">Column 3</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="">
                                                <td scope="row">R1C1</td>
                                                <td>R1C2</td>
                                                <td>R1C3</td>
                                            </tr>
                                            <tr class="">
                                                <td scope="row">Item</td>
                                                <td>Item</td>
                                                <td>Item</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- SCRIPTS --}}
    @include('pages/admins/section/admin-scripts')

    {{-- Datatables --}}
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#rand_drops').DataTable();
        });
    </script>
</body>


</html>
