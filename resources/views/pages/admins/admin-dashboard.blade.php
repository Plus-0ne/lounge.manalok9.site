{{-- HEADER CONTAINS CSS LINKS --}}
@include('pages/admins/section/admin-header')
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
                        <div class="p-3 p-lg-4 dashboard-section d-flex flex-wrap">
                            <div class="breadcrumb-text col-12 mt-3 text-sm-center text-lg-start">
                                <h3>
                                    Dashboard <small class="text-secondary">(Sample Only)</small>
                                </h3>
                                <small class="text-muted">
                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam repudiandae quis voluptates fugiat quod quas eum, exercitationem, soluta deleniti, veritatis maiores nostrum? Hic quos iure nulla nostrum dolor, amet id.
                                </small>
                                <hr>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-8 p-3">
                                <canvas id="total_members" class="w-lg-100 h-lg-100 h-sm-75 chartsmadm"
                                    style="display:block;"></canvas>
                            </div>
                            <div
                                class="col-12 col-sm-12 col-md-12 col-lg-4 p-3 d-flex flex-column justify-content-start">


                                <div class="dashboard-card-container dashback-members col-12 mb-4">
                                    <div class="dash-card-section">
                                        <div class="dash-inner d-flex flex-column">
                                            <div class="w-100">
                                                <h4> {{ $data['userAccountTotal']->count() }} </h4>
                                            </div>
                                            <div
                                                class="w-100 d-flex flex-row justify-content-between align-items-center">
                                                <div>TOTAL @if ($data['userAccountTotal']->count() > 1)
                                                        MEMBERS
                                                    @else
                                                        MEMBER
                                                    @endif
                                                </div>
                                                <div class="dash-icon">
                                                    <span class="mdi mdi-account-group"></span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>





                                <div class="dashboard-card-container dashback-posts col-12 mb-4">
                                    <div class="dash-card-section">
                                        <div class="dash-inner d-flex flex-column">
                                            <div class="w-100">
                                                <h4> {{ $data['postTotal']->count() }} </h4>
                                            </div>
                                            <div
                                                class="w-100 d-flex flex-row justify-content-between align-items-center">
                                                <div>TOTAL MEMBERS @if ($data['postTotal']->count() > 1)
                                                        POSTS
                                                    @else
                                                        POST
                                                    @endif
                                                </div>
                                                <div class="dash-icon">
                                                    <span class="mdi mdi-post"></span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>


                                <div class="dashboard-card-container dashback-admins col-12 mb-4">
                                    <div class="dash-card-section">
                                        <div class="dash-inner d-flex flex-column">
                                            <div class="w-100">
                                                <h4> {{ $data['adminAccountTotal']->count() }} </h4>
                                            </div>
                                            <div
                                                class="w-100 d-flex flex-row justify-content-between align-items-center">
                                                <div>TOTAL @if ($data['adminAccountTotal']->count() > 1)
                                                        ADMINS
                                                    @else
                                                        ADMIN
                                                    @endif
                                                </div>
                                                <div class="dash-icon">

                                                    <span class="mdi mdi-account-tie"></span>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            /* TOTAL MEMBERS BY MONTH */
            new Chart($('#total_members'), {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov',
                        'Dec'
                    ],
                    datasets: [{
                        data: [86, 114, 106, 106, 107, 111, 133, 221, 783, 2478, 3000, 1044],
                        label: "Members Per Month",
                        borderColor: "#E6A238",
                        borderWidth: 1,
                        pointBackgroundColor: "#E6A238",
                        pointBorderColor: "#E6A238",
                        fill: true
                    }, ]
                },
            });
        });
    </script>
</body>



</html>
