$(document).ready(function () {

    /* Global variable */
    var rid = window.rid;
    var current = location.pathname;
    var assetUrl = window.assetUrl;
    window.lastChatdate = '0000-00-00 00:00:00';
    var fpage = 1;



    /* Get all followers */
    GetUserFollower(fpage,rid)

    /* User follower card template */
    function UserfollowerTemplate(res) {
        var str = null;
        var date = null;
        var dateformatted = null;
        var follower = null;
        var follower_details = null;
        var user_fullname = null;
        var user_image = null;

        $.each(res.userFollower.data, function (ufIndex, ufValue) {

            /* Set variables */
            follower = ufValue;

            follower_details = ufValue.members_model;

            if (typeof ufValue.members_model === 'undefined' || ufValue.members_model == null) {
                follower_details = ufValue.follow_details;
            }


            user_fullname = 'Anonymous';
            user_image = window.assetUrl+'my_custom_symlink_1/user.png';
            user_profile_url = window.thisUrl + '/view/members-details?rid=' + follower_details.uuid;

            /* Convert time stamp to readable time */
            str = follower.created_at;
            date = moment(str);
            dateformatted = date.utc().format("MMMM DD YYYY - hh:mm A");

            /* Create full name of user */
            if (follower_details.first_name != null || follower_details.last_name != null) {
                user_fullname = follower_details.first_name + ' ' + follower_details.last_name;
            }

            /* Set user image */
            if (follower_details.profile_image != null) {
                user_image = window.assetUrl+follower_details.profile_image;
            }

            $('.follower_section_area').append('<div class="f-section-content col-12 col-sm-12 col-md-6 pt-3" onclick="window.location=\'' + user_profile_url + '\'">\
                <div class="w-100 d-flex flex-row">\
                    <div class="f-img-container">\
                        <div class="f-img-pholder">\
                            <img src="'+user_image+'" alt="">\
                        </div>\
                    </div>\
                    <div class="f-det-container d-flex flex-column align-items-center">\
                        <div class="w-100 f-sect-name">\
                            '+user_fullname+'\
                        </div>\
                        <div class="w-100 f-sect-details">\
                            <div>\
                                Since '+dateformatted+'\
                            </div>\
                        </div>\
                    </div>\
                </div>\
            </div>');
        });
    }

    function GetUserFollower(fpage,rid) {
        var searchString = $('#find_user_follower').val();
        var titleSearch = $('.sort-f-search').text();
        $.ajax({
            type: "POST",
            url: "/ajax/get_user_follower?page="+fpage,
            data: {
                rid: rid,
                searchString : searchString,
                titleSearch: titleSearch
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                var res = response;

                /* Log response */
                console.log(res);

                /* Trigger user follower template function */
                UserfollowerTemplate(res);
            }
        });
    }

    /* Search user follower */
    $(document).on('click','.search_btn_f > i', function () {

        $('.follower_section_area').empty();

        GetUserFollower(fpage,rid);

    });

    /* Keyup clear filters */
    $(document).on('keyup','#find_user_follower', function () {
        var searchString = $(this).val();

        if (searchString.length < 1) {
            $('.follower_section_area').empty();
            GetUserFollower(fpage,rid);
        }
    });

    /* Change followers to following */
    $(document).on('click','.sort-f-search', function () {
        var sort_title = $(this);

        $('.follower_section_area').empty();

        if (sort_title.text() == 'Followers') {
            sort_title.html('Following');
            GetUserFollower(fpage,rid);
        }
        else
        {
            sort_title.html('Followers');
            GetUserFollower(fpage,rid);
        }
    });
});
