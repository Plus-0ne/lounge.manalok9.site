$(document).ready(function () {
    /* rid = Members Number */ // check windows.rid = xnzcjkhadfhalsdas-sample; at the top

    var rid = window.rid;
    var current = location.pathname;
    var assetUrl = window.assetUrl;
    window.lastChatdate = '0000-00-00 00:00:00';
    var defPage = 1;

    /* FUNCTIONS */

    $(".cnav-link").each(function () {
        var cnav_link = $(this);
        if (cnav_link.attr("href").indexOf(current) !== -1) {
            cnav_link.addClass("active-nav");
        }
    });

    $(".cnav-link").on("click", function () {
        if ($(".cnav-link").hasClass("active-nav")) {
            $(".cnav-link").removeClass("active-nav");
        }
        $(this).toggleClass("active-nav");
    });

    $(".mem-toggle-btn").on("click", function () {
        $(".mem-sidebars").toggleClass("res-sidbar-mem");
    });


    $(document).on('click','.btn-toggleseemore', function (e) {
        e.preventDefault();
        var see_more = $(this);
        $(see_more.parent()).toggle();
        $(see_more.parent().next()).toggle();
    });
    $(document).on('click','.btn-showlesss', function (e) {
        e.preventDefault();
        var see_less = $(this);

        $(see_less.parent()).toggle();
        $(see_less.parent().prev()).toggle();
    });

    /* GET PROFILE LIKES */
    function countProfileLikes(rid) {
        var rid = rid;

        $.ajax({
            type: "GET",
            url: "/ajax/countProfileLikes",
            data: {
                rid: rid,
            },
            success: function (response) {
                $(".like_cccc").html(response.prof_count);
            },
        });
    }
    countProfileLikes(rid);

    /* GET PROFILE FOLLOWERS */
    function countProfileFollowers(rid) {
        var rid = rid;

        $.ajax({
            type: "GET",
            url: "/ajax/countProfileFollowers",
            data: {
                rid: rid,
            },
            success: function (response) {
                $(".followers_ccc").html(response.prof_count);
            },
        });
    }
    countProfileFollowers(rid);


    /* Chat body */
    function chat_bodyTemplate(res) {
        $('.message-body').empty();
        if (res.data != null) {
            var getFirstDate = 0;

            $.each(res.data, function (rowKey, RowValue) {

                getFirstDate++;

                if (getFirstDate == 1) {
                    window.lastChatdate = RowValue.created_at;
                }


                var prof_image;
                var sender_details = RowValue.sender_details;
                var my_uuid = window.my_uuid;

                if (sender_details.profile_image == null) {
                    prof_image = window.urlAssets+'my_custom_symlink_1/user.png';
                }
                else
                {
                    prof_image = window.urlAssets+sender_details.profile_image;
                }
                var flex_row = "flex-row";
                if (my_uuid == sender_details.uuid) {
                    var flex_row = 'flex-row-reverse';
                }
                $('.message-body').append('\
                <div class="message-section-row d-flex '+flex_row+' mt-2 mb-2">\
                    <div class="user-icon p-1">\
                        <img width="25px" src="'+prof_image+'" alt="">\
                    </div>\
                    <div class="user-message p-3">\
                        '+RowValue.message+'\
                    </div>\
                </div>\
                ');
            });

            getFirstDate = 0;
        }
        else
        {
            $('.message-body').append('\
            <div class="d-flex justify-content-center">\
                <h6>\
                Start conversation\
                </h6>\
            </div>');
        }
    }
    function chatWindowDetails(res) {
        var res = res;
        var userdata = res.userData;

        /* Full name */
        var fullName;
        if (userdata.first_name != null || userdata.last_name != null) {
            fullName = userdata.first_name + ' ' + userdata.last_name;
        }
        else
        {
            fullName = 'Guest';
        }
        /* Profile Image */
        var profile_image;
        if (userdata.profile_image != null) {
            profile_image = window.assetUrl+userdata.profile_image;
        }
        else
        {
            profile_image = window.assetUrl+'my_custom_symlink_1/user.png';
        }
        $('#userProfileImg').attr('src',profile_image);
        $('#userDataName').html(fullName);
    }

    $(document).on('click','#messageBtn-container', function () {

        var ruuid = window.rid;

        $.ajax({
            type: "post",
            url: "/ajax/message_user",
            data: {
                ruuid : ruuid
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                var res = response;

                if (res.status == 'success') {
                    $('.custom-Chatwindow').toggleClass('cwindow-show');
                    $('.custom-Chatwindow').fadeIn();


                    chatWindowDetails(res);
                    chat_bodyTemplate(res);


                    console.log(res.data);
                }

            }
        });

    });
    $(document).on('click','.message-window-close > i', function () {
        $('.custom-Chatwindow').toggleClass('cwindow-show');
        $('.custom-Chatwindow').fadeOut();
    });



    /* Update message body after sent */
    function updateMessageBody() {
        var ruuid = window.rid;

        $.ajax({
            type: "post",
            url: "/ajax/update_message",
            data: {
                ruuid : ruuid,
                lastChatdate: window.lastChatdate
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                var res = response;
                var getFirstDate = 0;
                $.each(res.data, function (rowKey, RowValue) {

                    getFirstDate++;

                    if (getFirstDate == 1) {
                        window.lastChatdate = RowValue.created_at;
                    }

                    var prof_image;
                    var sender_details = RowValue.sender_details;
                    var my_uuid = window.my_uuid;

                    if (sender_details.profile_image == null) {
                        prof_image = window.assetUrl+'my_custom_symlink_1/user.png';
                    }
                    else
                    {
                        prof_image = window.assetUrl+sender_details.profile_image;
                    }
                    var flex_row = "flex-row";
                    if (my_uuid == sender_details.uuid) {
                        var flex_row = 'flex-row-reverse';
                    }
                    $('.message-body').prepend('\
                    <div class="message-section-row d-flex '+flex_row+' mt-2 mb-2">\
                        <div class="user-icon p-1">\
                            <img width="25px" src="'+prof_image+'" alt="">\
                        </div>\
                        <div class="user-message p-3">\
                            '+RowValue.message+'\
                        </div>\
                    </div>\
                    ');
                });

                getFirstDate = 0;

                console.log(res);
            }
        });


    }
    var id = window.my_id;

    Echo.private('my.notification.' + id).notification((notification) => {
        updateMessageBody();
    });

    $(document).on('click','.send-btn-icon > i', function () {
        var ruuid = window.rid;
        var message_txt = $('#message-text');
        var lastChatdate = lastChatdate;

        $.ajax({
            type: "post",
            url: "/ajax/send_user_message",
            data: {
                ruuid : ruuid,
                message_txt:message_txt.val()
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                console.log(response);
                message_txt.val("");
                updateMessageBody();
            }
        });
    });

    $('#message-text').keypress(function (e) {
        if (e.which == 13) {

            var ruuid = window.rid;
            var message_txt = $('#message-text');

            $.ajax({
                type: "post",
                url: "/ajax/send_user_message",
                data: {
                    ruuid : ruuid,
                    message_txt:message_txt.val()
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    console.log(response);
                    message_txt.val("");
                    updateMessageBody();
                }
            });
        }
    });

    /* Post section template for post page */
    function post_area_temp(post_data) {
        var my_uuid = window.ruuid;
        var post_temp = null;
        var profile_picture = window.urlAssets + 'my_custom_symlink_1/user.png';

        var posts = null;
        var post_creator = null;
        var usersName = 'Anonymous';
        var post_settings = null;
        // var my_followers = null;

        var str;
        var date;
        var dateFormatted;
        var week_name = "";
        var post_visibility = null;

        var post_message;
        var fPost_message;
        var text_withurl;
        var post_body_content;
        var post_message_content;
        var user_has_reaction;
        var react_count;
        var comment_count;

        $.each(post_data.data, function (postIndex, PostValue) {

            /* Default values */
            posts = PostValue;
            post_creator = PostValue.members_model;
            // my_followers = PostValue.members_model.my_followers;

            str = null;
            date = null;
            dateFormatted = null;


            /* Profile picture */
            if (post_creator.profile_image != null) {
                profile_picture = window.urlAssets + post_creator.profile_image;
            }
            else {
                profile_picture = window.urlAssets + 'my_custom_symlink_1/user.png';
            }
            /* Users Name */
            if (post_creator.first_name != null || post_creator.last_name != null) {
                usersName = post_creator.first_name + ' ' + post_creator.last_name;
            }

            /* Hide edit dot if user is not the post creator */

            if (post_creator.uuid == my_uuid) {
                // post_settings = '<div class="post_settings_btn"><i class="mdi mdi-dots-vertical"></i></div>';
                post_settings = "";
                post_settings = '\
                <div class="dropdown open">\
                    <button class="custom-post-settings dropdown-toggle dt-custombutton" type="button" id="triggerId" data-bs-toggle="dropdown" aria-haspopup="true"\
                            aria-expanded="false">\
                            <i class="mdi mdi-dots-vertical"></i>\
                            </button>\
                    <div class="dropdown-menu dropdown-menu-end dm-custom" aria-labelledby="triggerId">\
                        <button class="dropdown-item" data-post_id="'+posts.post_id+'">\
                            <small><i class="mdi mdi-circle-edit-outline"></i> Update</small>\
                        </button>\
                        <button class="dropdown-item delete_this_post" data-post_id="'+posts.post_id+'">\
                            <small><i class="mdi mdi-delete-outline"></i> Delete</small>\
                        </button>\
                    </div>\
                </div>';
            }
            else {
                post_settings = "";
            }

            /* Convert date timestamp */
            str = posts.created_at;
            date = moment(str);
            week_name = date.day();
            week_name = weekNameToString(week_name);

            dateFormatted = date.local().format("MMMM DD YYYY - hh:mm A");


            if (posts.visibility == 'private') {
                post_visibility = '<i class="mdi mdi-lock"></i> <small>Private</small>';
            }
            else {
                post_visibility = '<i class="mdi mdi-earth"></i> <small>Public</small>';
            }

            /* Post content */
            /* Trim post and convert message to text */

            /* If simple post */
            post_message_content = _.escape(posts.post_message);

            if (posts.type == 'post') {

                if (posts.post_message == null) {
                    post_message = "";
                    fPost_message = "";
                }

                if (post_message_content.length > 255) {

                    post_body_content = _.escape(posts.post_message);
                    msg = post_body_content;
                    str = msg.substring(0, 165) + '<br>... <a href="#" class="btn_fullvpost"> <small>Show more</small></a>';

                    post_message = str;
                    fPost_message = _.escape(posts.post_message);
                }
                else {
                    post_message = _.escape(posts.post_message);
                    fPost_message = _.escape(posts.post_message);
                }

                post_attachment = '';

            } else if (posts.type == 'post_attachments') {

                if (posts.post_message == null) {
                    post_message = "";
                    fPost_message = "";
                }

                if (post_message_content.length > 255) {

                    post_body_content = _.escape(posts.post_message);
                    msg = post_body_content;
                    str = msg.substring(0, 165) + '<br>... <a href="#" class="btn_fullvpost"> <small>Show more</small></a>';

                    post_message = str;
                    fPost_message = _.escape(posts.post_message);
                }
                else {
                    post_message = _.escape(posts.post_message);
                    fPost_message = _.escape(posts.post_message);
                }

                post_attachment = '';

                post_attachment_html_content(posts,post_attachment);

            } else if (posts.type == 'shared_post') {

                if (posts.post_message == null) {
                    post_message = "";
                    fPost_message = "";
                }

                if (post_message_content.length > 255) {

                    post_body_content = _.escape(posts.post_message);
                    msg = post_body_content;
                    str = msg.substring(0, 165) + '<br>... <a href="#" class="btn_fullvpost"> <small>Show more</small></a>';

                    post_message = str;
                    fPost_message = _.escape(posts.post_message);
                }
                else {
                    post_message = _.escape(posts.post_message);
                    fPost_message = _.escape(posts.post_message);
                }

                post_attachment = '';
                postActivityTxt = ' shared a post.';
                post_attachment_share_preview(posts);
            } else {
                post_attachment = '';
            }

            /* Post Reaction */
            if (posts.post_reaction.length > 0) {
                switch (posts.post_reaction[0].reaction) {
                    case 1:
                        user_has_reaction = like_svg_template();
                        break;

                    case 2:
                        user_has_reaction = haha_svg_template();
                        break;

                    case 3:
                        user_has_reaction = heart_svg_template();
                        break;

                    default:
                        user_has_reaction = 'React';
                        break;
                }
            }
            else {
                user_has_reaction = 'React';
            }

            /* Reaction count */
            react_count = [posts.total_r1, posts.total_r2, posts.total_r3];

            /* Comment count */
            comment_count = posts.comment_per_post_count;


            htmlContentPost(posts, profile_picture, post_settings, dateFormatted, post_message, fPost_message, usersName, post_visibility, text_withurl, user_has_reaction, react_count, comment_count,week_name,post_attachment);
        });

        /* Show button show more post if next page url is not null */
        if (post_data.next_page_url == null) {
            $('.post_nextpage').html('<p> No more posts to show. </p>');

        }
        else {
            $('.post_nextpage').html('<button id="show_more_post_available" class="btn btn-primary"> More posts </button>');
        }

    }

    /* -------------------------------------------------------------------------- */
    /*                          Show more post available                          */
    /* -------------------------------------------------------------------------- */
    $(document).on('click', '#show_more_post_available', function () {
        defPage++;
        getMorePost(rid,defPage);

    });

    function getMorePost(rid,defPage) {

        var user_uuid = rid;

        $.ajax({
            type: "GET",
            url: window.thisUrl+'/ajax/get-all-post?page='+defPage,
            data: {
                user_uuid : user_uuid
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                var post_data = response;
                console.log(response);
                post_area_temp(post_data);
            }
        });
    }
    function htmlContentPost(posts, profile_picture, post_settings, dateFormatted, post_message, fPost_message, usersName, post_visibility, text_withurl, user_has_reaction, react_count, comment_count,week_name,post_attachment) {
        var show_ago_time = moment(posts.created_at).local().fromNow(true) + ' ago';
        post_temp = '<div class="user_post_container card mt-4 upc_'+posts.post_id+'">\
            <div class="px-3 py-3 px-lg-4 py-lg-4">\
                <div class="user_post_header d-flex flex-row align-items-center justify-content-between">\
                    <div class="user_post_details d-flex flex-column">\
                        <div class="d-flex flex-row align-items-center">\
                            <div class="user_image">\
                                <img src="'+ profile_picture + '" alt="User image">\
                            </div>\
                            <div class="user_fullname ms-3 d-flex flex-column">\
                                <div class="d-flex flex-row">\
                                    <span class="view-full-post" data-id="'+ posts.uuid + '">' + usersName + '</span>\
                                    <small class="ms-2">\
                                        <small>\
                                            <span class="badge rounded-pill bg-success">'+ show_ago_time + '</span>\
                                        </small>\
                                    </small>\
                                </div>\
                                <small>\
                                <span class="post_date_label"> '+ week_name +', '+ dateFormatted + ' ' + post_visibility + '</span>\
                                </small>\
                            </div>\
                        </div>\
                    </div>\
                    <div class="user_post_control">\
                        '+ post_settings + '\
                    </div>\
                </div>\
                <div class="user_post_body mt-3 mb-3 content-body-text_'+ posts.post_id + '" data-id="' + posts.post_id + '">\
                    <div class="post-content-trimmed-txt">\
                        '+ post_message + '\
                    </div>\
                    <div class="post-content-complete-text" style="display: none;">\
                        '+ fPost_message + '\
                    </div>\
                </div>\
                <div class="user_post_attachements">\
                '+ post_attachment + '\
                </div>\
                <div class="user_post_reaction mt-2 justify-content-end d-flex flex-row">\
                    <div class="d-inline pe-3" data-postid="'+ posts.post_id + '">\
                        <span class="me-2">\
                            <svg width="20px" height="20px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">\
                                <g>\
                                    <path fill="none" d="M0 0h24v24H0z"></path>\
                                    <path fill="#0072ff" color="#0072ff" d="M14.6 8H21a2 2 0 0 1 2 2v2.104a2 2 0 0 1-.15.762l-3.095 7.515a1 1 0 0 1-.925.619H2a1 1 0 0 1-1-1V10a1 1 0 0 1 1-1h3.482a1 1 0 0 0 .817-.423L11.752.85a.5.5 0 0 1 .632-.159l1.814.907a2.5 2.5 0 0 1 1.305 2.853L14.6 8zM7 10.588V19h11.16L21 12.104V10h-6.4a2 2 0 0 1-1.938-2.493l.903-3.548a.5.5 0 0 0-.261-.571l-.661-.33-4.71 6.672c-.25.354-.57.644-.933.858zM5 11H3v8h2v-8z"></path>\
                                </g>\
                            </svg>\
                            <span>'+ react_count[0] +'</span>\
                        </span>\
                        <span class="me-2">\
                            <svg width="20px" height="20px" viewBox="0 0 1500 1500" xmlns="http://www.w3.org/2000/svg">\
                                <path class="st0" d="M542.7 1092.6H377.6c-13 0-23.6-10.6-23.6-23.6V689.9c0-13 10.6-23.6 23.6-23.6h165.1c13 0 23.6 10.6 23.6 23.6V1069c0 13-10.6 23.6-23.6 23.6zM624 1003.5V731.9c0-66.3 18.9-132.9 54.1-189.2 21.5-34.4 69.7-89.5 96.7-118 6-6.4 27.8-25.2 27.8-35.5 0-13.2 1.5-34.5 2-74.2.3-25.2 20.8-45.9 46-45.7h1.1c44.1 1 58.3 41.7 58.3 41.7s37.7 74.4 2.5 165.4c-29.7 76.9-35.7 83.1-35.7 83.1s-9.6 13.9 20.8 13.3c0 0 185.6-.8 192-.8 13.7 0 57.4 12.5 54.9 68.2-1.8 41.2-27.4 55.6-40.5 60.3-2.6.9-2.9 4.5-.5 5.9 13.4 7.8 40.8 27.5 40.2 57.7-.8 36.6-15.5 50.1-46.1 58.5-2.8.8-3.3 4.5-.8 5.9 11.6 6.6 31.5 22.7 30.3 55.3-1.2 33.2-25.2 44.9-38.3 48.9-2.6.8-3.1 4.2-.8 5.8 8.3 5.7 20.6 18.6 20 45.1-.3 14-5 24.2-10.9 31.5-9.3 11.5-23.9 17.5-38.7 17.6l-411.8.8c-.2 0-22.6 0-22.6-30z"></path>\
                                <path class="st0" d="M750 541.9C716.5 338.7 319.5 323.2 319.5 628c0 270.1 430.5 519.1 430.5 519.1s430.5-252.3 430.5-519.1c0-304.8-397-289.3-430.5-86.1z"></path>\
                                <ellipse class="st1" cx="750.2" cy="751.1" rx="750" ry="748.8"></ellipse>\
                                <g>\
                                    <path class="st3" d="M755.3 784.1H255.4s13.2 431.7 489 455.8c6.7.3 11.2.1 11.2.1 475.9-24.1 489-455.9 489-455.9H755.3z"></path>\
                                    \
                                    <path class="st4" d="M312.1 991.7s174.8-83.4 435-82.6c129 .4 282.7 12 439.2 83.4 0 0-106.9 260.7-436.7 260.7-329 0-437.5-261.5-437.5-261.5z"></path>\
                                    <path class="st5" d="M1200.2 411L993 511.4l204.9 94.2"></path>\
                                    <path class="st5" d="M297.8 411L505 511.4l-204.9 94.2"></path>\
                                </g>\
                            </svg>\
                            <span>'+ react_count[1] +'</span>\
                        </span>\
                        <span>\
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="20px" height="20px" viewBox="0 0 544.582 544.582" style="enable-background:new 0 0 544.582 544.582;" xml:space="preserve">\
                                <g>\
                                    <path fill="#ff0025" color="#ff0025" d="M448.069,57.839c-72.675-23.562-150.781,15.759-175.721,87.898C247.41,73.522,169.303,34.277,96.628,57.839C23.111,81.784-16.975,160.885,6.894,234.708c22.95,70.38,235.773,258.876,263.006,258.876c27.234,0,244.801-188.267,267.751-258.876C561.595,160.732,521.509,81.631,448.069,57.839z"></path>\
                                </g>\
                            </svg>\
                            <span>'+ react_count[2] +'</span>\
                        </span>\
                    </div>\
                </div>\
            </div>\
            <div class="divider-section"></div>\
            <div class="user_post_reaction_control d-flex flex-row justify-content-evenly">\
                <div class="u_reaction_control">\
                    <span class="hvr_reaction hvrr_'+ posts.post_id + '">\
                        '+ user_has_reaction + '\
                    </span>\
                    <div class="u_reaction_container">\
                        <div class="ubackg_reaction">\
                            <span class="react_to_post" data-postid="'+ posts.post_id + '" data-postreaction="1">\
                                <svg width="28px" height="28px" viewBox="0 0 24 24"\
                                    xmlns="http://www.w3.org/2000/svg">\
                                    <g>\
                                        <path fill="none" d="M0 0h24v24H0z" />\
                                        <path fill="#0072ff" color="#0072ff"\
                                            d="M14.6 8H21a2 2 0 0 1 2 2v2.104a2 2 0 0 1-.15.762l-3.095 7.515a1 1 0 0 1-.925.619H2a1 1 0 0 1-1-1V10a1 1 0 0 1 1-1h3.482a1 1 0 0 0 .817-.423L11.752.85a.5.5 0 0 1 .632-.159l1.814.907a2.5 2.5 0 0 1 1.305 2.853L14.6 8zM7 10.588V19h11.16L21 12.104V10h-6.4a2 2 0 0 1-1.938-2.493l.903-3.548a.5.5 0 0 0-.261-.571l-.661-.33-4.71 6.672c-.25.354-.57.644-.933.858zM5 11H3v8h2v-8z" />\
                                    </g>\
                                </svg>\
                            </span>\
                            <span class="react_to_post" data-postid="'+ posts.post_id + '" data-postreaction="2">\
                                <svg width="28px" height="28px" viewBox="0 0 1500 1500"\
                                    id="Layer_1" xmlns="http://www.w3.org/2000/svg">\
                                    <path class="st0"\
                                        d="M542.7 1092.6H377.6c-13 0-23.6-10.6-23.6-23.6V689.9c0-13 10.6-23.6 23.6-23.6h165.1c13 0 23.6 10.6 23.6 23.6V1069c0 13-10.6 23.6-23.6 23.6zM624 1003.5V731.9c0-66.3 18.9-132.9 54.1-189.2 21.5-34.4 69.7-89.5 96.7-118 6-6.4 27.8-25.2 27.8-35.5 0-13.2 1.5-34.5 2-74.2.3-25.2 20.8-45.9 46-45.7h1.1c44.1 1 58.3 41.7 58.3 41.7s37.7 74.4 2.5 165.4c-29.7 76.9-35.7 83.1-35.7 83.1s-9.6 13.9 20.8 13.3c0 0 185.6-.8 192-.8 13.7 0 57.4 12.5 54.9 68.2-1.8 41.2-27.4 55.6-40.5 60.3-2.6.9-2.9 4.5-.5 5.9 13.4 7.8 40.8 27.5 40.2 57.7-.8 36.6-15.5 50.1-46.1 58.5-2.8.8-3.3 4.5-.8 5.9 11.6 6.6 31.5 22.7 30.3 55.3-1.2 33.2-25.2 44.9-38.3 48.9-2.6.8-3.1 4.2-.8 5.8 8.3 5.7 20.6 18.6 20 45.1-.3 14-5 24.2-10.9 31.5-9.3 11.5-23.9 17.5-38.7 17.6l-411.8.8c-.2 0-22.6 0-22.6-30z" />\
                                    <path class="st0"\
                                        d="M750 541.9C716.5 338.7 319.5 323.2 319.5 628c0 270.1 430.5 519.1 430.5 519.1s430.5-252.3 430.5-519.1c0-304.8-397-289.3-430.5-86.1z" />\
                                    <ellipse class="st1" cx="750.2" cy="751.1" rx="750"\
                                        ry="748.8" />\
                                    <g>\
                                        <path id="mond" class="st3"\
                                            d="M755.3 784.1H255.4s13.2 431.7 489 455.8c6.7.3 11.2.1 11.2.1 475.9-24.1 489-455.9 489-455.9H755.3z" />\
                                        <path id="tong" class="st4"\
                                            d="M312.1 991.7s174.8-83.4 435-82.6c129 .4 282.7 12 439.2 83.4 0 0-106.9 260.7-436.7 260.7-329 0-437.5-261.5-437.5-261.5z" />\
                                        <path id="linker_1_" class="st5"\
                                            d="M1200.2 411L993 511.4l204.9 94.2" />\
                                        <path id="linker_4_" class="st5"\
                                            d="M297.8 411L505 511.4l-204.9 94.2" />\
                                    </g>\
                                </svg>\
                            </span>\
                            <span class="react_to_post" data-postid="'+ posts.post_id + '" data-postreaction="3">\
                                <?xml version="1.0" encoding="iso-8859-1"?>\
                                <!DOCTYPE svg\
                                    PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">\
                                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"\
                                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"\
                                    y="0px" width="28px" height="28px"\
                                    viewBox="0 0 544.582 544.582"\
                                    style="enable-background:new 0 0 544.582 544.582;"\
                                    xml:space="preserve">\
                                    <g>\
                                        <path fill="#ff0025" color="#ff0025"\
                                            d="M448.069,57.839c-72.675-23.562-150.781,15.759-175.721,87.898C247.41,73.522,169.303,34.277,96.628,57.839C23.111,81.784-16.975,160.885,6.894,234.708c22.95,70.38,235.773,258.876,263.006,258.876c27.234,0,244.801-188.267,267.751-258.876C561.595,160.732,521.509,81.631,448.069,57.839z" />\
                                    </g>\
                                    <g></g>\
                                    <g></g>\
                                    <g></g>\
                                    <g></g>\
                                    <g></g>\
                                    <g></g>\
                                    <g></g>\
                                    <g></g>\
                                    <g></g>\
                                    <g></g>\
                                    <g></g>\
                                    <g></g>\
                                    <g></g>\
                                    <g></g>\
                                    <g></g>\
                                </svg>\
                            </span>\
                        </div>\
                    </div>\
                </div>\
                <div>\
                    <span class="show_comment_section" data-post_id="'+ posts.post_id + '">Comments ('+ comment_count +')</span>\
                </div>\
                <div class="ff-primary-regular share_this_post" data-post_id="'+ posts.post_id + '">\
                    <span>Share</span>\
                </div>\
            </div>\
            <div class="divider-section"></div>\
            <div class="pv-comment-container-'+ posts.post_id + ' pv-check-comment-section" data-post_id=' + posts.post_id + '>\
            </div>\
            <div class="divider-section"></div>\
            <div class="pv-writecomment-container-'+ posts.post_id + ' px-3 pb-2 px-lg-4 pb-lg-2">\
                <div class="d-flex flex-row align-items-center">\
                    <div class="pe-3">\
                        <button class="comment-act-btn cab-default"><i class="mdi mdi-plus-circle"></i></button>\
                    </div>\
                    <div class="w-100">\
                        <input type="text" class="eja_'+ posts.post_id + '" value=""/>\
                    </div>\
                    <div class="ps-3">\
                        <button class="submit_comment comment-act-btn cab-primary" data-post_id="'+ posts.post_id + '"> <i class="mdi mdi-send"></i> </button>\
                    </div>\
                </div>\
            </div>\
        </div>';



        /* Append to container */
        $('.usersPosts-section').append(post_temp);

        $('.eja_' + posts.post_id).emojioneArea({
            pickerPosition: "bottom",
            tonesStyle: "radio"
        });

        text_withurl = $('.content-body-text_' + posts.post_id);
        replaceURLWithHTMLLinks(text_withurl);

    }

    /* Like svg template */
    function like_svg_template() {
        return '<span>\
        <svg width="23px" height="23px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">\
        <g>\
        <path fill="none" d="M0 0h24v24H0z"/>\
        <path fill="#0072ff" color="#0072ff" d="M14.6 8H21a2 2 0 0 1 2 2v2.104a2 2 0 0 1-.15.762l-3.095 7.515a1 1 0 0 1-.925.619H2a1 1 0 0 1-1-1V10a1 1 0 0 1 1-1h3.482a1 1 0 0 0 .817-.423L11.752.85a.5.5 0 0 1 .632-.159l1.814.907a2.5 2.5 0 0 1 1.305 2.853L14.6 8zM7 10.588V19h11.16L21 12.104V10h-6.4a2 2 0 0 1-1.938-2.493l.903-3.548a.5.5 0 0 0-.261-.571l-.661-.33-4.71 6.672c-.25.354-.57.644-.933.858zM5 11H3v8h2v-8z"/>\
        </g>\
        </svg>\
        </span>';
    }
    function haha_svg_template() {
        return '<span>\
        <svg width="23px" height="23px" viewBox="0 0 1500 1500" id="Layer_1" xmlns="http://www.w3.org/2000/svg">\
        <path class="st0" d="M542.7 1092.6H377.6c-13 0-23.6-10.6-23.6-23.6V689.9c0-13 10.6-23.6 23.6-23.6h165.1c13 0 23.6 10.6 23.6 23.6V1069c0 13-10.6 23.6-23.6 23.6zM624 1003.5V731.9c0-66.3 18.9-132.9 54.1-189.2 21.5-34.4 69.7-89.5 96.7-118 6-6.4 27.8-25.2 27.8-35.5 0-13.2 1.5-34.5 2-74.2.3-25.2 20.8-45.9 46-45.7h1.1c44.1 1 58.3 41.7 58.3 41.7s37.7 74.4 2.5 165.4c-29.7 76.9-35.7 83.1-35.7 83.1s-9.6 13.9 20.8 13.3c0 0 185.6-.8 192-.8 13.7 0 57.4 12.5 54.9 68.2-1.8 41.2-27.4 55.6-40.5 60.3-2.6.9-2.9 4.5-.5 5.9 13.4 7.8 40.8 27.5 40.2 57.7-.8 36.6-15.5 50.1-46.1 58.5-2.8.8-3.3 4.5-.8 5.9 11.6 6.6 31.5 22.7 30.3 55.3-1.2 33.2-25.2 44.9-38.3 48.9-2.6.8-3.1 4.2-.8 5.8 8.3 5.7 20.6 18.6 20 45.1-.3 14-5 24.2-10.9 31.5-9.3 11.5-23.9 17.5-38.7 17.6l-411.8.8c-.2 0-22.6 0-22.6-30z"/><path class="st0" d="M750 541.9C716.5 338.7 319.5 323.2 319.5 628c0 270.1 430.5 519.1 430.5 519.1s430.5-252.3 430.5-519.1c0-304.8-397-289.3-430.5-86.1z"/><ellipse class="st1" cx="750.2" cy="751.1" rx="750" ry="748.8"/><g><path id="mond" class="st3" d="M755.3 784.1H255.4s13.2 431.7 489 455.8c6.7.3 11.2.1 11.2.1 475.9-24.1 489-455.9 489-455.9H755.3z"/><path id="tong" class="st4" d="M312.1 991.7s174.8-83.4 435-82.6c129 .4 282.7 12 439.2 83.4 0 0-106.9 260.7-436.7 260.7-329 0-437.5-261.5-437.5-261.5z"/><path id="linker_1_" class="st5" d="M1200.2 411L993 511.4l204.9 94.2"/><path id="linker_4_" class="st5" d="M297.8 411L505 511.4l-204.9 94.2"/></g>\
        </svg>\
        </span>';
    }
    function heart_svg_template() {
        return '<span>\
        <?xml version="1.0" encoding="iso-8859-1"?>\
        <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">\
        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"\
        width="23px" height="23px" viewBox="0 0 544.582 544.582" style="enable-background:new 0 0 544.582 544.582;"\
        xml:space="preserve">\
        <g>\
        <path fill="#ff0025" color="#ff0025" d="M448.069,57.839c-72.675-23.562-150.781,15.759-175.721,87.898C247.41,73.522,169.303,34.277,96.628,57.839C23.111,81.784-16.975,160.885,6.894,234.708c22.95,70.38,235.773,258.876,263.006,258.876c27.234,0,244.801-188.267,267.751-258.876C561.595,160.732,521.509,81.631,448.069,57.839z"/>\
        </g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g>\
        </svg>\
        </span>';
    }

    /* Number formatter */
    function numFormater(total_react) {
        return Math.abs(total_react) > 999 ? Math.sign(total_react)*((Math.abs(total_react)/1000).toFixed(1)) + 'k' : Math.sign(total_react)*Math.abs(total_react)
    }
    /* Comment formatter */
    function comFormater(total_comme) {
        return Math.abs(total_comme) > 999 ? Math.sign(total_comme)*((Math.abs(total_comme)/1000).toFixed(1)) + 'k' : Math.sign(total_comme)*Math.abs(total_comme)
    }
    /* -------------------------------------------------------------------------- */
    /*                                Get week name                               */
    /* -------------------------------------------------------------------------- */
    function weekNameToString(week_name) {
        switch (week_name) {
                case 1:
                return 'Monday';

                case 2:
                return 'Tuesday';

                case 3:
                return 'Wednesday';

                case 4:
                return 'Thursday';

                case 5:
                return 'Friday';

                case 6:
                return 'Saturday';

                case 7:
                return 'Sunday';
            default:
                return ' ';
        }
    }
    /* -------------------------------------------------------------------------- */
    /*                  Create html content for post attachments                  */
    /* -------------------------------------------------------------------------- */
    function post_attachment_html_content(posts,post_attachment) {
        var post_attachment_media = '';
        var extension = null;
        var post_attachment_ext = '';
        var post_attachment_file_path = '';
        var pa_array;
        pa_array = [];
        var pa_array2;
        pa_array2 = [];

        /* Get post attachments */
        if (posts.post_attachments.length < 2) {
            $.each(posts.post_attachments, function (paIndex, paValue) {
                /* check for undefiend or null value */
                if (paValue.file_extension === undefined || paValue.file_extension == null) {

                    /* If variable is undefined or null */
                    extension = paValue.file_path.substr((paValue.file_path.lastIndexOf('.') + 1));
                    post_attachment_ext = extension;
                    post_attachment_file_path = window.urlAssets + '/' + paValue.file_path;
                }
                else {
                    post_attachment_ext = paValue.file_extension;
                    post_attachment_file_path = window.urlAssets + '/' + paValue.file_path;
                }
            });


            if (post_attachment_ext == 'mp4' || post_attachment_ext == 'webm' || post_attachment_ext == 'ogg') {
                post_attachment_media = '<video class="postViewModal-btn" src="' + post_attachment_file_path + '" data-post_id="' + posts.post_id + '"></video>';
            }
            else {
                post_attachment_media = '<img class="pf-content-media postViewModal-btn" src="' + post_attachment_file_path + '" alt="Post attachments" style="object-fit:cover" data-post_id="' + posts.post_id + '">';
            }
            post_attachment += '<div class="pf-attachment-content d-flex justify-content-center" style="height:326px;">\
                                                '+ post_attachment_media + '\
                                            </div>';

        } else if (posts.post_attachments.length == 2) {

            /* Get  */

            $.each(posts.post_attachments, function (paIndex, paValue) {
                /* check for undefiend or null value */
                if (paValue.file_extension === undefined || paValue.file_extension == null) {

                    /* If variable is undefined or null */
                    extension = paValue.file_path.substr((paValue.file_path.lastIndexOf('.') + 1));
                    post_attachment_ext = extension;
                    post_attachment_file_path = window.urlAssets + '/' + paValue.file_path;
                }
                else {
                    post_attachment_ext = paValue.file_extension;
                    post_attachment_file_path = window.urlAssets + '/' + paValue.file_path;
                }

                if (post_attachment_ext == 'mp4' || post_attachment_ext == 'webm' || post_attachment_ext == 'ogg') {
                    post_attachment_media = '<video class="postViewModal-btn" src="' + post_attachment_file_path + '" data-post_id="' + posts.post_id + '"></video>';
                }
                else {
                    post_attachment_media = '<img class="pf-content-media postViewModal-btn" src="' + post_attachment_file_path + '" alt="Post attachments" data-post_id="' + posts.post_id + '">';
                }
                pa_array.push({
                    post_a_content: post_attachment_media,
                });

            });

            post_attachment += '<div class="pf-attachment-content-2 d-flex flex-row justify-content-center align-items-center" style="height: 326px;">\
                                            <div class="col-6 pf-media-container-2 h-100 d-flex justify-content-center">\
                                                '+ pa_array[0].post_a_content + '\
                                            </div>\
                                            <div class="col-6 pf-media-container-2 h-100 d-flex justify-content-center">\
                                                '+ pa_array[1].post_a_content + '\
                                            </div>\
                                        </div>';
        } else if (posts.post_attachments.length > 2) {

            /* Get  */

            $.each(posts.post_attachments, function (paIndex, paValue) {
                /* check for undefiend or null value */
                if (paValue.file_extension === undefined || paValue.file_extension == null) {

                    /* If variable is undefined or null */
                    extension = paValue.file_path.substr((paValue.file_path.lastIndexOf('.') + 1));
                    post_attachment_ext = extension;
                    post_attachment_file_path = window.urlAssets + '/' + paValue.file_path;
                }
                else {
                    post_attachment_ext = paValue.file_extension;
                    post_attachment_file_path = window.urlAssets + '/' + paValue.file_path;
                }

                if (post_attachment_ext == 'mp4' || post_attachment_ext == 'webm' || post_attachment_ext == 'ogg') {
                    post_attachment_media = '<video class="postViewModal-btn w-100 h-100" src="' + post_attachment_file_path + '" style="object-fit:cover;" data-post_id="' + posts.post_id + '"></video>';
                }
                else {
                    post_attachment_media = '<img class="w-100 h-100 align-self-center postViewModal-btn" src="' + post_attachment_file_path + '" alt="Post attachments" style="object-fit:cover;" data-post_id="' + posts.post_id + '">';
                }
                pa_array2.push({
                    post_a_content: post_attachment_media,
                });

            });

            post_attachment += '<div class="pf-attachment-content-3 d-flex flex-row" style="height: 326px;">\
                                            <div class="col-6" style="background-color: red; ">\
                                                <div class="d-flex justify-content-center align-items-center h-100" style="object-fit: cover;object-fit: cover;">\
                                                    '+ pa_array2[0].post_a_content + '\
                                                </div>\
                                            </div>\
                                            <div class="h-100 col-6">\
                                                <div class="d-flex justify-content-center align-items-center" style="object-fit: cover; height: 160px;">\
                                                    '+ pa_array2[1].post_a_content + '\
                                                </div>\
                                                <div class="d-flex justify-content-center align-items-center" style="object-fit: cover; height: 160px;">\
                                                    '+ pa_array2[2].post_a_content + '\
                                                </div>\
                                            </div>\
                                        </div>';
        } else {
            post_attachment = '';
        }
    }
    /* Ajax call get all post by user uuid */
    function GetUserPost(rid,defPage) {

        var user_uuid = rid;

        $.ajax({
            type: "GET",
            url: "/ajax/get-all-post?page="+defPage,
            data: {
                user_uuid : user_uuid
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                var post_data = response;
                console.log(response);
                post_area_temp(post_data);
            }
        });
    }
    GetUserPost(rid,defPage);

    /* Function react to post */
    $(document).on('click','.react_to_post', function () {
        var post_id = $(this).attr('data-postid');
        var reaction_val = $(this).attr('data-postreaction');
        var my_reaction = null;

        $.ajax({
            type: "post",
            url: "/ajax/react-to-post",
            data: {
                post_id : post_id,
                reaction_val : reaction_val
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                var res = response;
                console.log(res);
                switch (res.myReaction) {
                    case '1':
                        my_reaction = like_svg_template();
                        break;

                    case '2':
                        my_reaction = haha_svg_template();
                        break;

                    case '3':
                        my_reaction = heart_svg_template();
                        break;

                    default:
                        my_reaction = 'React';
                        break;
                }
                $('.hvrr_'+res.postReacted).html(my_reaction);
            }
        });
    });

    /* Replace url in text with links */
    function replaceURLWithHTMLLinks(text_withurl) {
        var text_urlinks = text_withurl;
        text_urlinks.html( text_urlinks.html().replace(/((http|https|www):\/\/(www\.)?[\w?=&.\/-;#~%-]+(?![\w\s?&.\/;#~%"=-]*>))/g, '<a href="$1" target="_blank">$1</a> '));

    }

    /* Click see more functions */
    $(document).on('click', '.user_post_body', function (e) {
        e.preventDefault();

        var user_post_body = $(this);
        var message_shown = user_post_body.children('div.post-content-trimmed-txt');
        var message_hidden = user_post_body.children('div.post-content-complete-text');

        if (message_shown.css('display') == 'none' || user_post_body.find('.btn_fullvpost').length < 1) {
            window.location = window.thisUrl + '/view/post?post_id=' + user_post_body.data('id');
        } else {
            message_shown.css('display', 'none');
            message_hidden.css('display', 'block');
        }
    });

    /* -------------------------------------------------------------------------- */
    /*                            Show comment section                            */
    /* -------------------------------------------------------------------------- */
    var cPageCount = 1;

    function getAllComments(cPageCount, post_id, pv_comment_container_id, comment_lastDate) {
        /* Get post comments */
        $.ajax({
            type: "post",
            url: "/ajax/post/comment/view?page=" + cPageCount,
            data: {
                post_id: post_id,
                comment_lastDate: comment_lastDate
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                var res = response;
                switch (res.status) {
                    case 'error':
                        alert(res.message);
                        break;

                    case 'info':
                        pv_comment_container_id.html('<div class="w-100 d-flex justify-content-center info-c"><p>' + res.message + '</p></div>');
                        break;

                    case 'success':
                        // pv_comment_container_id.html("");

                        generateComments(res, post_id);

                        console.log(res);
                        break;
                    default:
                        break;
                }
                updateCommentSection();

            },
            complete: function () {
                pv_comment_container_id.find('.custom-spinner').remove();
            }
        });
    }
    $(document).on('click', '.show_comment_section', function () {
        var post_id = $(this).attr('data-post_id');
        var pv_comment_container_id = $('.pv-comment-container-' + post_id);

        pv_comment_container_id.html("");
        cPageCount = 1;
        /* Get all comments */
        getAllComments(cPageCount, post_id, pv_comment_container_id);

    });

    /* -------------------------------------------------------------------------- */
    /*                             Show more comments                             */
    /* -------------------------------------------------------------------------- */
    $(document).on('click', '.btn-showMoreComments', function () {
        var post_id = $(this).attr('data-post_id');
        var pv_comment_container_id = $('.pv-comment-container-' + post_id);
        cPageCount++;
        getAllComments(cPageCount, post_id, pv_comment_container_id);
    });

    function updateCommentSection(post_id) {
        var comment_lastDate = "";
        var post_id = post_id;

        comment_lastDate = $('.pv-check-comment-section').find('.vrrr').last().attr('data-utcDate');
    }
    /* -------------------------------------------------------------------------- */
    /*                              Generate Comments                             */
    /* -------------------------------------------------------------------------- */
    function generateComments(res, post_id) {
        var post_id = post_id;
        var comment_temp;
        var comment_append;
        var showMoreComments = "";

        $.each(res.postComments.data, function (pcI, pcVal) {
            comment_temp = "";
            comment_append = commentFormTemplate(post_id,comment_temp, pcI, pcVal);

            /* append comment to pv-comment-container-'+ posts.post_id + ' */
            $('.pv-comment-container-' + post_id).append(comment_append);
            $('.pv-comment-container-' + post_id).addClass('px-3 py-3 px-lg-4 py-lg-4');
        });

        if (res.postComments.next_page_url != null) {
            $('.pv-comment-container-' + post_id).find('.showMoreContainer').remove();
            showMoreComments = '\
            <div class="showMoreContainer w-100 d-flex justify-content-center">\
                <button class="btn btn-primary btn-sm btn-showMoreComments" data-post_id="'+ post_id + '">\
                    Show more comments\
                </button>\
            </div>';
            $('.pv-comment-container-' + post_id).append(showMoreComments);
        }
        else {
            $('.pv-comment-container-' + post_id).find('.showMoreContainer').remove();
            showMoreComments = '<div class="showMoreContainer w-100 d-flex justify-content-center"> No more comments </div>';
            $('.pv-comment-container-' + post_id).append(showMoreComments);
        }
    }

    var pc_postComment;
    var pc_postCommentAuthor;
    var pc_profile_image;
    var pc_posted_comment;
    var pc_user_name;
    var pc_user_timezone;
    var pc_show_time;
    var delete_comment_cog;
    /* -------------------------------------------------------------------------- */
    /*                              Comment template                              */
    /* -------------------------------------------------------------------------- */
    function commentFormTemplate(post_id,comment_temp, pcI, pcVal,delete_comment_cog) {
        pc_postComment = pcVal;
        pc_postCommentAuthor = pcVal.members_model;
        pc_profile_image = window.urlAssets + 'my_custom_symlink_1/user.png';
        pc_posted_comment = "";
        pc_user_name = "";
        pc_user_timezone = moment.tz.guess();
        pc_show_time = "";
        pc_profile_url = window.thisUrl + '/view/members-details?rid=' + pc_postCommentAuthor.uuid;

        /* Check if user has profile image */
        if (pc_postCommentAuthor.profile_image != null) {
            pc_profile_image = window.urlAssets + pc_postCommentAuthor.profile_image;
        }

        /* Filter comment */
        if (pc_postComment.comment.length > 0) {
            pc_posted_comment = _.escape(pc_postComment.comment);
        }

        /* Fill user name */
        if (pc_postCommentAuthor.first_name.length > 0 || pc_postCommentAuthor.last_name.length > 0) {
            pc_user_name = pc_postCommentAuthor.first_name + ' ' + pc_postCommentAuthor.last_name;
        }

        /* Date with ago */
        pc_show_time = moment(pc_postComment.created_at).local().fromNow(true) + ' ago';

        if (pc_postCommentAuthor.uuid == window.uuid) {
            delete_comment_cog = '<div class="cog-comment-delete" data-comment_id="' + pc_postComment.id + '" data-post_id="' + post_id + '">\
                <i class="mdi mdi-delete-outline"></i>\
            </div>';
        }
        else {
            delete_comment_cog = "";
        }

        comment_temp = pcI;
        comment_temp = '<div class="vrrr d-flex flex-column mb-3 vrrr-'+pc_postComment.id+'" data-utcDate="' + pc_postComment.created_at + '">\
                            <div class="mb-2 d-flex flex-row justify-content-between">\
                                <div class="pf-user-details d-flex flex-row align-items-center">\
                                    <div class="pf-user-image me-2">\
                                        <img src="'+ pc_profile_image + '" alt="">\
                                    </div>\
                                    <div>\
                                        <div class="pf-user-name">\
                                            <a href="' + pc_profile_url + '">' + pc_user_name + '</a>\
                                        </div>\
                                        <div class="pf-time-count">\
                                            <small>\
                                                <span class="badge rounded-pill bg-success">'+ pc_show_time + '</span>\
                                            </small>\
                                        </div>\
                                    </div>\
                                </div>\
                                '+ delete_comment_cog + '\
                            </div>\
                                    <div class="pf-user-comment">\
                                    '+ pc_posted_comment + '\
                                    </div>\
                                </div>\
                            </div>';
        return comment_temp;
    }

    /* -------------------------------------------------------------------------- */
    /*                               VIEW REACTIONS                               */
    /* -------------------------------------------------------------------------- */
    $(document).on('click','.user_post_reaction>div', function () {

        /* Set variable value */
        var post_id = $(this).data('postid');
        var reactionModal = $('#post_reactionModal');
        reactionModal.find('.pv-reaction-container').html('');

        $.ajax({
            type: "post",
            url: "/ajax/post/reaction/view",
            data: {
                post_id: post_id
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            beforeSend: function() {
                reactionModal.find('.pv-reaction-container').html('<div class="custom-spinner mx-auto">\
                        <i class="mdi mdi-loading mdi-spin"></i>\
                    </div>');
            },
            success: function (response) {
                var res = response;

                $.each(res.postReactions, function (pcI, pcVal) {
                    pc_postReaction = pcVal;
                    pc_postReactionAuthor = pcVal.members_model;
                    pc_profile_image = window.urlAssets + 'my_custom_symlink_1/user.png';
                    pc_user_name = "";
                    pc_profile_url = window.thisUrl + '/view/members-details?rid=' + pc_postReactionAuthor.uuid;

                    /* Check if user has profile image */
                    if (pc_postReactionAuthor.profile_image != null) {
                        pc_profile_image = window.urlAssets + pc_postReactionAuthor.profile_image;
                    }

                    /* Fill user name */
                    if (pc_postReactionAuthor.first_name.length > 0 || pc_postReactionAuthor.last_name.length > 0) {
                        pc_user_name = pc_postReactionAuthor.first_name + ' ' + pc_postReactionAuthor.last_name;
                    }

                    /* Get reaction */
                    switch (pc_postReaction.reaction) {
                        case 1:
                            my_reaction = like_svg_template();
                            break;

                        case 2:
                            my_reaction = haha_svg_template();
                            break;

                        case 3:
                            my_reaction = heart_svg_template();
                            break;

                        default:
                            my_reaction = 'React';
                            break;
                    }

                    reaction_append = '<a href="' + pc_profile_url + '" class="list-group-item list-group-item-action">\
                                        <div class="d-flex flex-column my-2">\
                                            <div class="d-flex flex-row justify-content-between">\
                                                <div class="pf-user-details d-flex flex-row align-items-center">\
                                                    <div class="me-2">\
                                                        ' + my_reaction + '\
                                                    </div>\
                                                    <div class="pf-user-image me-2">\
                                                        <img src="'+ pc_profile_image + '" alt="">\
                                                    </div>\
                                                    <div>\
                                                        <div class="pf-user-name">\
                                                            '+ pc_user_name + '\
                                                        </div>\
                                                    </div>\
                                                </div>\
                                            </div>\
                                        </div>\
                                    </a>';
                    /* append reaction to pv-reaction-container-'+ posts.post_id + ' */
                    reactionModal.find('.pv-reaction-container').append(reaction_append);
                });
            },
            complete: function () {
                reactionModal.find('.pv-reaction-container').css('display', 'none').find('.custom-spinner').remove();
                reactionModal.find('.pv-reaction-container').slideDown();
            }
        });


        reactionModal.modal('show');
    });

    /* -------------------------------------------------------------------------- */
    /*                             Create new comment                             */
    /* -------------------------------------------------------------------------- */
    /* -------------------------------------------------------------------------- */
    /*                                Send comment                                */
    /* -------------------------------------------------------------------------- */
    $(document).on('click', '.submit_comment', function (e) {
        var post_id = $(this).attr('data-post_id');
        var comment_txt = $('.eja_' + post_id);

        var textComment_area = comment_txt.parent();
        var emojionearea_editor = textComment_area.find('.emojionearea-editor');

        var thisbtn = $(this);

        var pv_comment_container_id = $('.pv-comment-container-' + post_id);


        thisbtn.prop('disabled', true);
        e.preventDefault();

        $.ajax({
            type: "post",
            url: "/ajax/comment_in_post",
            data: {
                post_uuid: post_id,
                messageTxt: comment_txt.val()
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                var res = response;

                console.log(response);
                emojionearea_editor.data("emojioneArea").setText('');
                comment_txt.val("");

                switch (res.status) {
                    case 'error':
                        toastr["error"](res.message);
                        break;
                    case 'success':
                        /* Find info class to remove */
                        if (pv_comment_container_id.find('.info-c').length > 0) {
                            // pv_comment_container_id.find('.info-c').remove();
                        }

                        if (response.status == 'success') {
                            if (pv_comment_container_id.find('.vrrr').length > 0) {

                                $('.pv-comment-container-' + post_id).find('.vrrr').last().after(appendMyComment(res, post_id, delete_comment_cog));

                            }
                            else {
                                getAllComments(cPageCount, post_id, pv_comment_container_id);
                            }
                        }
                        break;
                    default:
                        break;
                }
                thisbtn.prop('disabled', false);
            }
        });
    });

    /* -------------------------------------------------------------------------- */
    /*                             Append new comment                             */
    /* -------------------------------------------------------------------------- */
    function appendMyComment(res, post_id, delete_comment_cog) {
        var post_id = post_id;
        var pv_comment_container_id = $('.pv-comment-container-' + post_id);
        var comment_append;

        /* Set all required variables */
        pc_postComment = res.postComments;
        pc_postCommentAuthor = res.postComments.members_model;
        pc_profile_image = window.urlAssets + 'my_custom_symlink_1/user.png';
        pc_posted_comment = "";
        pc_user_name = "";
        pc_user_timezone = moment.tz.guess();
        pc_show_time = "";
        pc_profile_url = window.thisUrl + '/view/members-details?rid=' + pc_postCommentAuthor.uuid;

        /* Check if user has profile image */
        if (pc_postCommentAuthor.profile_image != null) {
            pc_profile_image = window.urlAssets +'/'+ pc_postCommentAuthor.profile_image;
        }

        /* Filter comment */
        if (pc_postComment.comment.length > 0) {
            pc_posted_comment = encodeHTML(pc_postComment.comment);
        }

        /* Fill user name */
        if (pc_postCommentAuthor.first_name.length > 0 || pc_postCommentAuthor.last_name.length > 0) {
            pc_user_name = pc_postCommentAuthor.first_name + ' ' + pc_postCommentAuthor.last_name;
        }

        /* Date with ago */
        pc_show_time = moment(pc_postComment.created_at).local().fromNow(true) + ' ago';

        /* Hide delete button if user comments */
        /* Hide delete if comment is not from auth users */
        if (pc_postCommentAuthor.uuid == window.uuid) {
            delete_comment_cog = '<div class="cog-comment-delete" data-comment_id="' + pc_postComment.id + '" data-post_id="' + post_id + '">\
                <i class="mdi mdi-delete-outline"></i>\
            </div>';
        }
        else {
            delete_comment_cog = "";
        }

        comment_append = "";
        comment_append = '<div class="vrrr d-flex flex-column mb-3 vrrr-' + pc_postComment.id + '" data-utcDate="' + pc_postComment.created_at + '">\
                                    <div class="mb-2 d-flex flex-row justify-content-between">\
                                        <div class="pf-user-details d-flex flex-row align-items-center">\
                                            <div class="pf-user-image me-2">\
                                                <img src="'+ pc_profile_image + '" alt="">\
                                            </div>\
                                            <div>\
                                                <div class="pf-user-name">\
                                                    <a href="' + pc_profile_url + '">' + pc_user_name + '</a>\
                                                </div>\
                                                <div class="pf-time-count">\
                                                    <small>\
                                                        <span class="badge rounded-pill bg-success">'+ pc_show_time + '</span>\
                                                    </small>\
                                                </div>\
                                            </div>\
                                        </div>\
                                        '+ delete_comment_cog + '\
                                    </div>\
                                    <div class="pf-user-comment">\
                                    '+ pc_posted_comment + '\
                                    </div>\
                                </div>\
                            </div>';
        return comment_append;

    }

    /* -------------------------------------------------------------------------- */
    /*                            Filter comment value                            */
    /* -------------------------------------------------------------------------- */
    function encodeHTML(text) {
        return text.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/"/g, '&quot;');
    }

    /* -------------------------------------------------------------------------- */
    /*                               Delete comment                               */
    /* -------------------------------------------------------------------------- */
    $(document).on('click', '.cog-comment-delete', function () {


        /* Get post id to delete */
        var comment_id = $(this).attr('data-comment_id');
        var post_id = $(this).attr('data-post_id');

        if (confirm('Delete this comment ?') == false) {
            return false;
        }
        /* Ajax request delete comment */
        $.ajax({
            type: "post",
            url: "/ajax/post/comment/delete",
            data: {
                comment_id: comment_id,
                post_id: post_id
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                var res = response;

                /* Delete comment in comment section */
                var pv_comment_container_id = $('.pv-comment-container-' + res.postID + '');

                pv_comment_container_id.find('.vrrr-' + res.commentID + '').remove();



            }
        });
    });

    /* -------------------------------------------------------------------------- */
    /*                          On click show modal share                         */
    /* -------------------------------------------------------------------------- */
    $(document).on('click', '.share_this_post', function () {
        var post_id = $(this).attr('data-post_id');

        get_post_to_share(post_id);
    });

    /* -------------------------------------------------------------------------- */
    /*                               Get all details                              */
    /* -------------------------------------------------------------------------- */
    function get_post_to_share(post_id) {
        sharePost(post_id);
    }

    /* -------------------------------------------------------------------------- */
    /*                    Get post details for sharing preview                    */
    /* -------------------------------------------------------------------------- */
    function sharePost(post_id) {
        /* Get post data */
        var fd = new FormData();
        fd.append('post_id', post_id);

        $.ajax({
            type: "POST",
            url: window.thisUrl + "/ajax/share/post/get",
            data: fd,
            processData: false,
            contentType: false,
            enctype: "application/x-www-form-urlencoded",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                var res = response;
                getPostResponse(res);
            }
        });
    }

    /* -------------------------------------------------------------------------- */
    /*                           Share get post response                          */
    /* -------------------------------------------------------------------------- */
    function getPostResponse(res) {
        var status = res.status;
        var message = res.message;

        if (status == 'success') {
            var post = res.posts;
            var userDetails = res.posts.members_model;
            var postAttachments = res.posts.uploaded;
        }

        switch (status) {
            case 'error':
                toastr["error"](message);
                break;

            case 'warning':
                toastr["warning"](message);
                break;

            case 'success':
                const myModal = new bootstrap.Modal(document.getElementById('modalShowShare'), {});
                /* Toggle modal */
                myModal.toggle();

                $('#shareTextArea').emojioneArea({
                    pickerPosition: "bottom",
                    tonesStyle: "radio",
                    autocomplete: false
                });

                /* Set user image */
                $('.share-profile-pic img').attr('src', (userDetails.profile_image == null ? window.urlAssets+'my_custom_symlink_1/user.png': window.urlAssets+'/'+userDetails.profile_image));

                /* Set data id with post id */
                $('.share-username').attr('data-id', post.post_id);
                $('#share_post_submit').attr('data-post_id', post.post_id);

                /* Set username complete name */
                var userName = (userDetails.first_name.length > 0 || userDetails.last_name.length > 0) ? userDetails.first_name + ' ' + userDetails.last_name : 'Guest';
                $('.share-username').html(userName);

                /* Moment js format date */
                var str = post.created_at;
                var date = moment(str);
                var week_name = date.day();
                week_name = weekNameToString(week_name);

                dateFormatted = week_name + ', ' + date.local().format("MMMM DD YYYY - hh:mm A");
                $('.share_post_date_label').html(dateFormatted);

                /* Set time ago */
                var show_ago_time = moment(post.created_at).local().fromNow(true) + ' ago';
                $('.sat-span-time').html(show_ago_time);

                /* Fill share_txt_content with post text */
                var arData = sharePostText(post);
                $('#share_txt_content').html(arData[0].postText);
                $('#share_txt_content_extension').html(arData[0].postExtContent);



                /* Check data response */
                console.log(res, arData);

                break;

            default:
                break;
        }
    }

    function sharePostText(post) {
        // share_txt_content
        var postText = post.post_message;
        var postExtContent = '';
        var compVar = [];



        /* Check post type */
        if (post.type == 'post') {
            if (postText === undefined || postText == null || postText.length < 1) {
                postText = '';
            }
            else {
                postText = _.escape(postText);
            }
        } else if (post.type == 'post_attachments') {
            if (postText === undefined || postText == null || postText.length < 1) {
                postText = '';
            }
            else {
                postText = _.escape(postText);
            }
            /* If post_attachment get all files and create a html out to display all files */
            postExtContent = post_attach_preview(post);
        } else if (post.type == 'shared_post') {
            if (postText === undefined || postText == null || postText.length < 1) {
                postText = '';
            }
            else {
                postText = _.escape(postText);
            }
            /* If shared_post then get post details using shared_source uuid the generate html output */
            postExtContent = post_attach_preview(post);
        } else {
            postText = '';
                postExtContent = '';
        }

        compVar.push({
            'postText': postText,
            'postExtContent': postExtContent
        });
        return compVar;
    }

    function post_attach_preview(post) {
        var posts = post;
        var postAtt = post.post_attachments;
        var post_attachment_ext = "";
        var extension = "";
        var post_attachment_file_path = "";
        var post_attachment_media = "";
        var pa_array = [];
        var pa_array2 = [];
        if (postAtt.length == 1) {
            $.each(postAtt, function (paIndex, paValue) {
                /* check for undefiend or null value */
                if (paValue.file_extension === undefined || paValue.file_extension == null) {

                    /* If variable is undefined or null */
                    extension = paValue.file_path.substr((paValue.file_path.lastIndexOf('.') + 1));
                    post_attachment_ext = extension;
                    post_attachment_file_path = window.urlAssets+'/'+paValue.file_path;
                }
                else {
                    post_attachment_ext = paValue.file_extension;
                    post_attachment_file_path = window.urlAssets+'/'+paValue.file_path;
                }
            });


            if (post_attachment_ext == 'mp4' || post_attachment_ext == 'webm' || post_attachment_ext == 'ogg') {
                post_attachment_media = '<video class="share-media-file w-100 postViewModal-btn" src="' + post_attachment_file_path + '" data-post_id="' + posts.post_id + '"></video>';
            }
            else {
                post_attachment_media = '<img class="share-media-file w-100 h-100 postViewModal-btn" src="' + post_attachment_file_path + '" alt="Post attachments" style="object-fit:cover" data-post_id="' + posts.post_id + '">';
            }
        } else if (postAtt.length == 2) {
            $.each(posts.post_attachments, function (paIndex, paValue) {
                /* check for undefiend or null value */
                if (paValue.file_extension === undefined || paValue.file_extension == null) {

                    /* If variable is undefined or null */
                    extension = paValue.file_path.substr((paValue.file_path.lastIndexOf('.') + 1));
                    post_attachment_ext = extension;
                    post_attachment_file_path = window.urlAssets+'/'+paValue.file_path;
                }
                else {
                    post_attachment_ext = paValue.file_extension;
                    post_attachment_file_path = window.urlAssets+'/'+paValue.file_path;
                }

                if (post_attachment_ext == 'mp4' || post_attachment_ext == 'webm' || post_attachment_ext == 'ogg') {
                    post_attachment_media = '<video class="share-media-file w-100 postViewModal-btn" src="' + post_attachment_file_path + '" data-post_id="' + posts.post_id + '"></video>';
                }
                else {
                    post_attachment_media = '<img class="share-media-file w-100 h-100 pf-content-media postViewModal-btn" src="' + post_attachment_file_path + '" alt="Post attachments" data-post_id="' + posts.post_id + '">';
                }
                pa_array.push({
                    post_a_content: post_attachment_media,
                });

            });
        } else if (postAtt.length >= 3) {
            $.each(posts.post_attachments, function (paIndex, paValue) {
                /* check for undefiend or null value */
                if (paValue.file_extension === undefined || paValue.file_extension == null) {

                    /* If variable is undefined or null */
                    extension = paValue.file_path.substr((paValue.file_path.lastIndexOf('.') + 1));
                    post_attachment_ext = extension;
                    post_attachment_file_path = window.urlAssets+'/'+paValue.file_path;
                }
                else {
                    post_attachment_ext = paValue.file_extension;
                    post_attachment_file_path = window.urlAssets+'/'+paValue.file_path;
                }

                if (post_attachment_ext == 'mp4' || post_attachment_ext == 'webm' || post_attachment_ext == 'ogg') {
                    post_attachment_media = '<video class="share-media-file w-100 postViewModal-btn w-100 h-100" src="' + post_attachment_file_path + '" style="object-fit:cover;" data-post_id="' + posts.post_id + '"></video>';
                }
                else {
                    post_attachment_media = '<img class="share-media-file w-100 h-100 w-100 h-100 align-self-center postViewModal-btn" src="' + post_attachment_file_path + '" alt="Post attachments" style="object-fit:cover;" data-post_id="' + posts.post_id + '">';
                }
                pa_array2.push({
                    post_a_content: post_attachment_media,
                });
                console.log(pa_array2);
            });
        }

        if (post.post_attachments.length == 1) {
            /* Post attachment exist */
            return '\
            <div class="share_1_file_container">\
                <div class="share_file_preview">\
                    '+post_attachment_media+'\
                </div>\
            </div>';

        } else if (post.post_attachments.length == 2) {
            /* Post attachment with 2 files */
            return '\
            <div class="share_2_file_extension">\
                <div class="d-flex flex-row">\
                    <div class="share_2_left">\
                        '+pa_array2[0].post_a_content.file_path+'\
                    </div>\
                    <div class="share_2_right">\
                        '+pa_array2[1].post_a_content.file_path+'\
                    </div>\
                </div>\
            </div>';

        } else if (post.post_attachments.length == 3) {
            /* Post attachment with 3 files */
            return '\
            <div class="share_post_attatch_content">\
                <div class="share_file_container d-flex flex-row">\
                    <div class="share-preview-container1 d-flex justify-content-center align-items-center text-center">\
                        <div class="share_preview1 align-self-center">\
                            '+pa_array2[0].post_a_content+'\
                        </div>\
                    </div>\
                    <div class="share-preview-container2 d-flex flex-column">\
                        <div class="share_preview2">\
                            '+pa_array2[1].post_a_content+'\
                        </div>\
                        <div class="share_preview3">\
                            '+pa_array2[2].post_a_content+'\
                        </div>\
                    </div>\
                </div>\
            </div>';
        } else {
            /* Post attachment is not available */
            return '';
        }
    }

    /* -------------------------------------------------------------------------- */
    /*                               Shared preview                               */
    /* -------------------------------------------------------------------------- */
    function post_attachment_share_preview(posts) {


        var posts = posts;
        var divContent;
        if (posts.shared_source === undefined || posts.shared_source == null || posts.shared_source.length < 1 || posts.share_source === undefined || posts.share_source == null || posts.share_source.length < 1) {

            /* TODO Create preview not found */
            divContent = "";
            divContent = '\
            <div class="d-flex justify-content-center">\
            <div class="d-flex flex-row align-items-center">\
            <div class="sp-not-found-icon me-1"><span class="mdi mdi-emoticon-sad-outline"></span></div> \
            <div>Shared post not found!</div>\
            </div>\
            </div>';
            post_attachment += divContent;
            return false;
        }

        var post_source = posts.shared_source;
        var share_source_author = post_source.members_model;

        var usersName = "Guest";
        var profile_picture = window.urlAssets+'/my_custom_symlink_1/user.png';
        var post_visibility = "";
        var str = "";
        var date = "";
        var week_name = "";
        var dateFormatted = "";
        var show_ago_time = moment(post_source.created_at).local().fromNow(true) + ' ago';
        var spa_content ="";
        /* User profile image */
        if (share_source_author.profile_image != null) {


            profile_picture = window.urlAssets+'/'+share_source_author.profile_image;

        }

        /* Users Name */
        if (share_source_author.first_name != null || share_source_author.last_name != null) {
            usersName = share_source_author.first_name + ' ' + share_source_author.last_name;
        }

        /* Elapse time */
        /* Convert date timestamp */
        str = post_source.created_at;
        date = moment(str);
        week_name = date.day();
        week_name = weekNameToString(week_name);

        dateFormatted = date.local().format("MMMM DD YYYY - hh:mm A");

        /* Post visibility */
        if (post_source.visibility == 'private') {
            post_visibility = '<i class="mdi mdi-lock"></i> <small>Private</small>';
        }
        else {
            post_visibility = '<i class="mdi mdi-earth"></i> <small>Public</small>';
        }

        var post_message;
        var fPost_message;
        var message_content;
        message_content = _.escape(post_source.post_message);

        /* Post message */
        if (post_source.post_message === undefined || post_source.post_message == null || message_content.length < 1) {
            post_message = "";
            fPost_message = "";
        }

        if (message_content.length > 255) {

            var post_body_content = _.escape(post_source.post_message);
            var msg = post_body_content;
            var pmStr = msg.substring(0, 165) + '<br>... <a href="#" class="btn_fullvpost"> <small>Show more</small></a>';

            post_message = pmStr;
            fPost_message = _.escape(post_source.post_message);
        }
        else {
            post_message = _.escape(post_source.post_message);
            fPost_message = _.escape(post_source.post_message);
        }
        var post_type_text = "";
        if (post_source.type == 'shared_post') {
            post_type_text = ' share a post.';
        } else if (post_source.type == 'post_attachments') {
            post_type_text = ' published a post with attachment.';
        }
        else {
            post_type_text = ' published a post.';
        }


        divContent = '<div class="card px-2 px-lg-4 py-2 py-lg-4">\
                            <div class="user_post_header d-flex flex-row align-items-center justify-content-between">\
                                <div class="user_post_details d-flex flex-column">\
                                    <div class="d-flex flex-row align-items-center">\
                                        <div class="user_image">\
                                            <img src="'+ profile_picture + '" alt="User image" onerror="">\
                                        </div>\
                                        <div class="user_fullname ms-3 d-flex flex-column">\
                                            <div class="d-flex flex-column flex-lg-row justify-content-start align-items-start align-items-lg-center">\
                                                <div>\
                                                <span class="view-full-post ff-primary-regular" data-id="'+ post_source.uuid + '">' + usersName + '</span>\
                                                <span class="ff-primary-light ms-1">'+ post_type_text + '</span>\
                                                </div>\
                                                <div class="fs-extra-small">\
                                                    <span class="badge rounded-pill bg-success ms-0 ms-lg-2 mb-1">'+ show_ago_time + '</span>\
                                                </div>\
                                            </div>\
                                            <small>\
                                            <span class="post_date_label ff-primary-light">'+ week_name + ', ' + dateFormatted + '  ' + post_visibility + '</span>\
                                            </small>\
                                        </div>\
                                    </div>\
                                </div>\
                            </div>\
                            <div class="user_post_body mt-3 mb-3 content-body-text_'+ post_source.post_id + '" data-id="' + post_source.post_id + '">\
                                <div class="post-content-trimmed-txt">\
                                    '+post_message+'\
                                </div>\
                                <div class="post-content-complete-text" style="display: none;">\
                                    '+fPost_message+'\
                                </div>\
                            </div>\
                            <div class="user_post_attachements">\
                            '+sharePreviewAttachments(posts,spa_content)+'\
                            </div>\
                        </div>';
        post_attachment += divContent;
    }

    /* -------------------------------------------------------------------------- */
    /*                          Share preview attachments                         */
    /* -------------------------------------------------------------------------- */

    function sharePreviewAttachments(posts,spa_content) {
        var spa_content = spa_content;
        var post_attachment_media = '';
        var extension = null;
        var post_attachment_ext = '';
        var post_attachment_file_path = '';
        var pa_array;
        pa_array = [];
        var pa_array2;
        pa_array2 = [];
        spa_content = "";

        var post_source = posts;

        /* Get post attachments */
        if (post_source.shared_source.length < 1) {
            return false;
        }
        if (post_source.source_attachments.length == 1) {
            $.each(post_source.source_attachments, function (paIndex, paValue) {
                /* check for undefiend or null value */
                if (paValue.file_extension === undefined || paValue.file_extension == null) {

                    /* If variable is undefined or null */
                    extension = paValue.file_path.substr((paValue.file_path.lastIndexOf('.') + 1));
                    post_attachment_ext = extension;
                    post_attachment_file_path = window.urlAssets+'/'+paValue.file_path;
                }
                else {
                    post_attachment_ext = paValue.file_extension;
                    post_attachment_file_path = window.urlAssets+'/'+paValue.file_path;
                }
            });


            if (post_attachment_ext == 'mp4' || post_attachment_ext == 'webm' || post_attachment_ext == 'ogg') {
                post_attachment_media = '<video class="postViewModal-btn" src="' + post_attachment_file_path + '" data-post_id="' + post_source.share_source + '"></video>';
            }
            else {
                post_attachment_media = '<img class="pf-content-media postViewModal-btn" src="' + post_attachment_file_path + '" alt="Post attachments" style="object-fit:cover" data-post_id="' + post_source.share_source + '">';
            }
            spa_content = '<div class="pf-attachment-content d-flex justify-content-center" style="height:326px;">\
                                                '+ post_attachment_media + '\
                                            </div>';

        } else if (post_source.source_attachments.length == 2) {

            /* Get  */

            $.each(post_source.source_attachments, function (paIndex, paValue) {
                /* check for undefiend or null value */
                if (paValue.file_extension === undefined || paValue.file_extension == null) {

                    /* If variable is undefined or null */
                    extension = paValue.file_path.substr((paValue.file_path.lastIndexOf('.') + 1));
                    post_attachment_ext = extension;
                    post_attachment_file_path = window.urlAssets+'/'+paValue.file_path;
                }
                else {
                    post_attachment_ext = paValue.file_extension;
                    post_attachment_file_path = window.urlAssets+'/'+paValue.file_path;
                }

                if (post_attachment_ext == 'mp4' || post_attachment_ext == 'webm' || post_attachment_ext == 'ogg') {
                    post_attachment_media = '<video class="postViewModal-btn" src="' + post_attachment_file_path + '" data-post_id="' + post_source.share_source + '"></video>';
                }
                else {
                    post_attachment_media = '<img class="pf-content-media postViewModal-btn" src="' + post_attachment_file_path + '" alt="Post attachments" data-post_id="' + post_source.share_source + '">';
                }
                pa_array.push({
                    post_a_content: post_attachment_media,
                });

            });

            spa_content = '<div class="pf-attachment-content-2 d-flex flex-row justify-content-center align-items-center" style="height: 326px;">\
                                            <div class="col-6 pf-media-container-2 h-100 d-flex justify-content-center">\
                                                '+ pa_array[0].post_a_content + '\
                                            </div>\
                                            <div class="col-6 pf-media-container-2 h-100 d-flex justify-content-center">\
                                                '+ pa_array[1].post_a_content + '\
                                            </div>\
                                        </div>';
        } else if (post_source.source_attachments.length == 3) {

            /* Get  */

            $.each(post_source.source_attachments, function (paIndex, paValue) {
                /* check for undefiend or null value */
                if (paValue.file_extension === undefined || paValue.file_extension == null) {

                    /* If variable is undefined or null */
                    extension = paValue.file_path.substr((paValue.file_path.lastIndexOf('.') + 1));
                    post_attachment_ext = extension;
                    post_attachment_file_path = window.urlAssets+'/'+paValue.file_path;
                }
                else {
                    post_attachment_ext = paValue.file_extension;
                    post_attachment_file_path = window.urlAssets+'/'+paValue.file_path;
                }

                if (post_attachment_ext == 'mp4' || post_attachment_ext == 'webm' || post_attachment_ext == 'ogg') {
                    post_attachment_media = '<video class="postViewModal-btn w-100 h-100" src="' + post_attachment_file_path + '" style="object-fit:cover;" data-post_id="' + post_source.share_source + '"></video>';
                }
                else {
                    post_attachment_media = '<img class="w-100 h-100 align-self-center postViewModal-btn" src="' + post_attachment_file_path + '" alt="Post attachments" style="object-fit:cover;" data-post_id="' + post_source.share_source + '">';
                }
                pa_array2.push({
                    post_a_content: post_attachment_media,
                });

            });

            spa_content = '<div class="pf-attachment-content-3 d-flex flex-row" style="height: 326px;">\
                                            <div class="col-6" style="background-color: red; ">\
                                                <div class="d-flex justify-content-center align-items-center h-100" style="object-fit: cover;object-fit: cover;">\
                                                    '+ pa_array2[0].post_a_content + '\
                                                </div>\
                                            </div>\
                                            <div class="h-100 col-6">\
                                                <div class="d-flex justify-content-center align-items-center" style="object-fit: cover; height: 160px;">\
                                                    '+ pa_array2[1].post_a_content + '\
                                                </div>\
                                                <div class="d-flex justify-content-center align-items-center" style="object-fit: cover; height: 160px;">\
                                                    '+ pa_array2[2].post_a_content + '\
                                                </div>\
                                            </div>\
                                        </div>';
        }
        else {
            spa_content = "";
        }

        return spa_content;
    }

    /* -------------------------------------------------------------------------- */
    /*                              Share post submit                             */
    /* -------------------------------------------------------------------------- */
    $(document).on('click', '#share_post_submit', function (e) {
        e.preventDefault();

        const thisBtn = $(this);
        const fd = new FormData();

        fd.append('post_id', thisBtn.attr('data-post_id'));
        fd.append('share_text_message', $('#shareTextArea').val());


        thisBtn.prop('disabled', true);

        $.ajax({
            type: "post",
            url: window.thisUrl + "/ajax/share/post/create",
            processData: false,
            contentType: false,
            cache: false,
            enctype: 'application/x-www-form-urlencoded',
            data: fd,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            beforeSend: function () {
                thisBtn.html('<i class="mdi mdi-loading mdi-spin"></i> Sharing');
            },
            success: function (response) {
                const res = response;

                switch (res.status) {
                    case 'error':
                        console.log(res.message);
                        break;

                    case 'warning':
                        console.log(res.message);
                        break;

                    case 'success':
                        location.reload();
                        break;

                    default:
                        break;
                }
            },
            complete: function () {
                thisBtn.prop('disabled', false);
                thisBtn.html('<span class="mdi mdi-share"></span> Share');

            }
        });
    });

    $('#btnModalQrCodeShow').on('click', function () {
        const modalQrCode = $('#modalQrCode');

        modalQrCode.modal('toggle');
    });
});
