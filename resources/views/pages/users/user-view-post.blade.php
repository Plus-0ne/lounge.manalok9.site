{{-- HEADER CONTAINS CSS LINKS --}}
@include('pages/users/template/section/header')

<body class="mem-details-body">
    <div class="memprof-header">
        <div class="container-fluid container-xxl">
            <div class="d-flex flex-row justify-content-between">
                <div class="header-control py-3 d-flex flex-row">
                    <div class="head-controller align-self-center">
                        <a href="{{ route('dashboard') }}">
                            <i class="mdi mdi-close"></i>
                        </a>

                    </div>
                    <span class="ms-3 align-self-center">Members Profile</span>
                </div>
                <div class="d-flex">
                    <i class="mdi mdi-format-align-justify mem-toggle-btn align-self-center"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="my-5">

    </div>
    <div class="container-fluid container-xxl">
        <div class="mem-main-wrapper d-flex flex-row">
            <div class="mem-sidebars">
                @include(
                    'pages/users/template/section/members-profile-nav'
                )
            </div>
            <div class="mem-wrapper">
                <div class="px-5">
                    <h3>
                        Posts
                    </h3>
                    <div class="mem-content">

                    </div>
                    <div class="spin-container w-100 text-center p-4">

                    </div>
                    <div class="w-100 text-center">
                        <button id="load_more_post" class="btn btn-primary">
                            Load more post
                        </button>
                    </div>
                    <div class="p-4"></div>
                </div>
            </div>
        </div>
    </div>


{{-- Include custom user toast --}}
@include('pages/users/template/section/user-toasts')
</body>

{{-- SCRIPTS --}}
@include('pages/users/template/section/scripts-var')
@include('pages/users/template/section/scripts')

<script src="{{ asset('js/members_js/members_profile.js?v=1') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        var page = 1;
        var rid = window.rid;


        function getMemberDetails(rid, page) {
            var page = page;
            var rid = rid;

            $.ajax({
                type: "GET",
                url: "/ajax/members-details?page=" + page,
                data: {
                    'rid': rid
                },
                beforeSend: function() {
                    $('.spin-container').html('<div class="custom-spinner">\
                            <i class="mdi mdi-loading mdi-spin"></i>\
                        </div>');
                },
                success: function(response) {
                    var res = response;

                    $.each(res.mem_post.data, function(row, value) {

                        /* CONVERT DATE */
                        var str = value.created_at;
                        var date = moment(str);
                        var daate = date.utc().format('YYYY-MM-DD hh:mm:ss A');

                        $('.mem-content').append('<div class="mem_post_container my-4">\
                            <div class="mem_post_message">\
                                <p>\
                                    ' + value.post_message + ' \
                                </p>\
                            </div>\
                            <div class="mem_post_date mb-2">\
                                <small>\
                                    ' + daate + ' \
                                </small>\
                            </div>\
                            <div class="mem_post_status d-flex w-100">\
                                <div class="clk-icon custom-pills-badges cpb-success me-3">\
                                    <div class="icon-container">\
                                        <i class="mdi mdi-thumb-up"></i> ' + value.post_reaction_count + ' \
                                    </div>\
                                </div>\
                                <div class="clk-icon custom-pills-badges cpb-secondary">\
                                    <div class="icon-container">\
                                        <i class="mdi mdi-comment"></i> ' + value.post_comments_count + '\
                                    </div>\
                                </div>\
                            </div>\
                        </div>');
                    });

                    console.log(response);
                },
                complete: function() {
                    $('.spin-container').empty();
                }
            });
        }

        /* LOAD POST */
        getMemberDetails(rid, page);

        /* LOAD MORE POST */
        $("#load_more_post").on("click", function() {
            page++;
            getMemberDetails(rid, page);
        });
    });
</script>

</html>
