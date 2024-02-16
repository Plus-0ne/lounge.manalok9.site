$(document).ready(function () {
    var post_id = $('.submit_comment').data('post_id');
    $('.eja_' + post_id).emojioneArea({
        pickerPosition: "bottom",
        tonesStyle: "radio"
    });
    /* Hover show reaction buttons */
    $(document).on({
        mouseenter: function () {
            var hover_button = $(this);
            var reaction_buttons = hover_button.parent().find('.u_reaction_container');
            /* On hover show all reaction buttons */
            reaction_buttons.css('display', 'flex');
            reaction_buttons.removeClass('animate__animated animate__fadeIn');
            reaction_buttons.addClass('animate__animated animate__fadeIn');
        },
    }, '.hvr_reaction , .u_reaction_container');
    $(document).on('mouseleave', '.u_reaction_container', function () {
        var hover_button = $(this);
        var reaction_buttons = hover_button.parent().find('.u_reaction_container');
        /* On mouse leave hide all reaction buttons */
        reaction_buttons.css('display', 'none');
    });

    $('body').on('touchmove', function () {
        $('.u_reaction_container').css('display', 'none');
    });

    $(document).on('mouseleave', '.hvr_reaction', function () {
        var hover_button = $(this);
        var reaction_buttons = hover_button.parent().find('.u_reaction_container');
        /* On mouse leave hide all reaction buttons */
        reaction_buttons.css('display', 'none');
    });

    $(document).on('scroll', function () {
        $('.u_reaction_container').css('display', 'none');
    });

    /* Function react to post */
    $(document).on('click', '.react_to_post', function () {
        var post_id = $(this).attr('data-postid');
        var reaction_val = $(this).attr('data-postreaction');
        var my_reaction = null;

        $.ajax({
            type: "post",
            url: window.thisUrl+"/ajax/post/reaction/create",
            data: {
                post_id: post_id,
                reaction_val: reaction_val
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                var res = response;
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
                $('.hvrr_' + res.postReacted).html(my_reaction);
            }
        });
    });

    /* Reaction svg template */
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
    /*                              Generate Comments                             */
    /* -------------------------------------------------------------------------- */
    function generateComments(res, post_id) {
        var post_id = post_id;
        var comment_temp;
        var comment_append;
        var showMoreComments = "";

        $.each(res.postComments.data, function (pcI, pcVal) {
            comment_temp = "";
            comment_append = commentFormTemplate(comment_temp, pcI, pcVal,delete_comment_cog);

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
    function commentFormTemplate(comment_temp, pcI, pcVal,delete_comment_cog) {
        pc_postComment = pcVal;
        pc_postCommentAuthor = pcVal.members_model;
        pc_profile_image = window.assetUrl + 'my_custom_symlink_1/user.png';
        pc_posted_comment = "";
        pc_user_name = "";
        pc_user_timezone = moment.tz.guess();
        pc_show_time = "";
        pc_profile_url = window.thisUrl + '/view/members-details?rid=' + pc_postCommentAuthor.uuid;

        /* Check if user has profile image */
        if (pc_postCommentAuthor.profile_image != null) {
            pc_profile_image = window.assetUrl + pc_postCommentAuthor.profile_image;
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

        /* Hide delete if comment is not from auth users */
        if (pc_postCommentAuthor.uuid == window.uuid) {
            delete_comment_cog = '<div class="cog-comment-delete" data-comment_id="'+pc_postComment.id+'" data-post_id="'+post_id+'">\
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
                                            <a href="' + pc_profile_url + '">'+ pc_user_name + '</a>\
                                        </div>\
                                        <div class="pf-time-count">\
                                            <small>\
                                                <span class="badge rounded-pill bg-success">'+ pc_show_time + '</span>\
                                            </small>\
                                        </div>\
                                    </div>\
                                </div>\
                                '+delete_comment_cog+'\
                            </div>\
                            <div class="pf-user-comment">\
                            '+ pc_posted_comment + '\
                            </div>\
                        </div>\
                    </div>';
        return comment_temp;
    }

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

                                // $('.pv-comment-container-' + post_id).find('.vrrr').last().after(appendMyComment(res, post_id,delete_comment_cog));

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

    function appendMyComment(res, post_id,delete_comment_cog) {
        var post_id = post_id;
        var pv_comment_container_id = $('.pv-comment-container-' + post_id);
        var comment_append;

        /* Set all required variables */
        pc_postComment = res.postComments;
        pc_postCommentAuthor = res.postComments.members_model;
        pc_profile_image = window.assetUrl + 'my_custom_symlink_1/user.png';
        pc_posted_comment = "";
        pc_user_name = "";
        pc_user_timezone = moment.tz.guess();
        pc_show_time = "";
        pc_profile_url = window.thisUrl + '/view/members-details?rid=' + pc_postCommentAuthor.uuid;

        /* Check if user has profile image */
        if (pc_postCommentAuthor.profile_image != null) {
            pc_profile_image = window.assetUrl + pc_postCommentAuthor.profile_image;
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

        /* Hide delete if comment is not from auth users */
        if (pc_postCommentAuthor.uuid == window.uuid) {
            delete_comment_cog = '<div class="cog-comment-delete" data-comment_id="'+pc_postComment.id+'" data-post_id="'+post_id+'">\
                <i class="mdi mdi-delete-outline"></i>\
            </div>';
        }
        else {
            delete_comment_cog = "";
        }

        comment_append = "";
        comment_append = '<div class="vrrr d-flex flex-column mb-3 vrrr-'+pc_postComment.id+'" data-utcDate="' + pc_postComment.created_at + '">\
                            <div class="mb-2 d-flex flex-row justify-content-between">\
                                <div class="pf-user-details d-flex flex-row align-items-center">\
                                    <div class="pf-user-image me-2">\
                                        <img src="'+ pc_profile_image + '" alt="">\
                                    </div>\
                                    <div>\
                                        <div class="pf-user-name">\
                                            <a href="' + pc_profile_url + '">'+ pc_user_name + '</a>\
                                        </div>\
                                        <div class="pf-time-count">\
                                            <small>\
                                                <span class="badge rounded-pill bg-success">'+ pc_show_time + '</span>\
                                            </small>\
                                        </div>\
                                    </div>\
                                </div>\
                                '+delete_comment_cog+'\
                            </div>\
                            <div class="pf-user-comment">\
                            '+ pc_posted_comment + '\
                            </div>\
                        </div>\
                    </div>';
        return comment_append;

    }
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
    /*                              Delete this post                              */
    /* -------------------------------------------------------------------------- */
    var delete_this_post_id;

    $(document).on('click','.delete_this_post', function () {

        /* Set variable value */
        delete_this_post_id = $(this).attr('data-post_id');

        const myModal = new bootstrap.Modal(document.getElementById('del_postModal'), {});

        myModal.show();
    });

    $(document).on('click','.delete_post_btnnn', function () {
        console.log(delete_this_post_id);
    });
    /* -------------------------------------------------------------------------- */
    /*                             Update active post                             */
    /* -------------------------------------------------------------------------- */
    Echo.private("active.post.update").listen(
        "PostCommentUpdate",
        (e) => {
            var post_id = e.post_id;
            var res = e;
            var pv_comment_container_id = $('.pv-comment-container-' + post_id);

            if (e.comment_from_uuid != window.ruuid) {
                if (pv_comment_container_id.find('.vrrr').length > 0) {
                    $('.pv-comment-container-' + post_id).find('.vrrr').last().after(appendMyComment(res, post_id,delete_comment_cog));
                }
            }
        }
    );

    /* change comment input style */
    $('.eja').emojioneArea({
        pickerPosition: "bottom",
        tonesStyle: "radio"
    });

    /* Replace url in message with links */
    $('.post_message').html($('.post_message').html().replace(/((http|https|www):\/\/(www\.)?[\w?=&.\/-;#~%-]+(?![\w\s?&.\/;#~%"=-]*>))/g, '<a href="$1" target="_blank">$1</a> '));


    /* -------------------------------------------------------------------------- */
    /*                              Delete this post function                     */
    /* -------------------------------------------------------------------------- */
    var delete_this_post_id;

    $(document).on('click','.delete_this_post', function () {

        /* Set variable value */
        delete_this_post_id = $(this).attr('data-post_id');

        var myModal = $('#del_postModal');

        myModal.modal('show');
    });

    $(document).on('click','.delete_post_btnnn', function () {

        var myModal = $('#del_postModal');
        var post_uuid = delete_this_post_id;


        $.ajax({
            type: "post",
            url: "/ajax/post/delete",
            data: {
                post_uuid : post_uuid
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                var res = response;

                $('.upc_'+res.postToRemove+'').remove();

                myModal.modal('hide');
                window.location.href = window.thisUrl + '/dashboard';

                /* Before the delete_this_post_id variable is cleared remove the post */
                delete_this_post_id = "";
                post_uuid = "";
            }
        });

    });

    $(document).on('click','.delete_post_btn_close', function () {
        var myModal = $('#del_postModal');

        myModal.modal('hide');
    });


    /* -------------------------------------------------------------------------- */
    /*                               Delete comment                               */
    /* -------------------------------------------------------------------------- */
    $(document).on('click','.cog-comment-delete', function () {


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
                comment_id:comment_id,
                post_id:post_id
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                var res = response;

                /* Delete comment in comment section */
                var pv_comment_container_id = $('.pv-comment-container-' + res.postID+'');

                pv_comment_container_id.find('.vrrr-'+res.commentID+'').remove();



            }
        });
    });

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
            url: window.thisUrl + "/ajax/post/reaction/view",
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
                    pc_profile_image = window.assetUrl + 'my_custom_symlink_1/user.png';
                    pc_user_name = "";
                    pc_profile_url = window.thisUrl + '/view/members-details?rid=' + pc_postReactionAuthor.uuid;

                    /* Check if user has profile image */
                    if (pc_postReactionAuthor.profile_image != null) {
                        pc_profile_image = window.assetUrl + pc_postReactionAuthor.profile_image;
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

    /* Filter comment value */
    function encodeHTML(text) {
        return text.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/"/g, '&quot;');
    }

    /* -------------------------------------------------------------------------- */
    /*                     On class share_this_post show modal                    */
    /* -------------------------------------------------------------------------- */
    $(document).on('click', '.share_this_post', function () {
        var post_id = $(this).attr('data-post_id');

        get_post_to_share(post_id);
    });

    /* -------------------------------------------------------------------------- */
    /*                           Get post to share data                           */
    /* -------------------------------------------------------------------------- */
    function get_post_to_share(post_id) {
        sharePost(post_id);
    }
    /* -------------------------------------------------------------------------- */
    /*                           Ajax get post to share                           */
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
    /*                               Share response                               */
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
                $('.share-profile-pic img').attr('src', (userDetails.profile_image == null ? window.assetUrl+'my_custom_symlink_1/user.png': window.assetUrl+'/'+userDetails.profile_image));

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

            default:
                return 'Sunday';
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
                    post_attachment_file_path = window.assetUrl+'/'+paValue.file_path;
                }
                else {
                    post_attachment_ext = paValue.file_extension;
                    post_attachment_file_path = window.assetUrl+'/'+paValue.file_path;
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
                    post_attachment_file_path = window.assetUrl+'/'+paValue.file_path;
                }
                else {
                    post_attachment_ext = paValue.file_extension;
                    post_attachment_file_path = window.assetUrl+'/'+paValue.file_path;
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
                    post_attachment_file_path = window.assetUrl+'/'+paValue.file_path;
                }
                else {
                    post_attachment_ext = paValue.file_extension;
                    post_attachment_file_path = window.assetUrl+'/'+paValue.file_path;
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
});
