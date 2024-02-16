$(document).ready(function () {
    /* rid = Members Number */ // check windows.rid = xnzcjkhadfhalsdas-sample; at the top

    var rid = window.rid;
    var current = location.pathname;
    var assetUrl = window.assetUrl;

    /* Default page for post */
    var defPage = 1;


    /* Ajax call get all post by user uuid */
    function GetUserComment(rid,defPage) {

        var user_uuid = rid;

        $.ajax({
            type: "GET",
            url: "/ajax/get-all-comment?page="+defPage,
            data: {
                user_uuid : user_uuid
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                var comment = response;

                var comment_val = null;
                var commenter_det = null;
                var poster_det = null;
                var post_det = null;
                var comment_show_time = null;
                var commenter_img = null;

                var comment_temp = null;

                $.each(comment.data, function (i, val) {
                    comment_val = val;
                    commenter_det = comment_val.members_model;
                    poster_det = comment_val.post_feed.members_model;
                    post_det = comment_val.post_feed;
                    comment_show_time = moment(comment_val.created_at).local().fromNow(true) + ' ago';

                    if (commenter_det.profile_image != null && commenter_det.profile_image.length > 0) {
                        commenter_img = window.thisUrl + '/' + commenter_det.profile_image;
                    } else {
                        commenter_img = window.assetUrl + 'my_custom_symlink_1/user.png';
                    }

                    comment_temp = '<a class="user-comment-link text-dark" href="' + window.thisUrl + '/view/post?post_id=' + post_det.post_id + '">\
                        <div class="user_post_container card px-4 pb-1 pt-4 mb-3">\
                            <div>\
                                <div class="user_comment_description">\
                                    <small><b>' + (commenter_det.first_name ?? '') + (' ' + commenter_det.last_name ?? '') + '</b> commented on <b>' + (poster_det.first_name ?? '') + (' ' + poster_det.last_name ?? '') + '</b>\'s post</small>\
                                </div>\
                            </div>\
                            <div class="comment-container vrrr d-flex flex-column mb-3 vrrr-17">\
                                <div class="mb-2 d-flex flex-row justify-content-between">\
                                    <div class="pf-user-details d-flex flex-row align-items-center">\
                                        <div class="pf-user-image me-2">\
                                            <img src="' + commenter_img + '" alt="">\
                                        </div>\
                                        <div>\
                                            <div class="pf-user-name">\
                                            ' + (commenter_det.first_name ?? '') + (' ' + commenter_det.last_name ?? '') + '\
                                            </div>\
                                            <div class="pf-time-count">\
                                                <small>\
                                                    <span class="badge rounded-pill bg-success">' + comment_show_time + '</span>\
                                                </small>\
                                            </div>\
                                        </div>\
                                    </div>\
                                </div>\
                                <div class="pf-user-comment">\
                                    ' + comment_val.comment + '\
                                </div>\
                            </div>\
                        </div>\
                    </a>';

                    $('.usersComments-section').append(comment_temp);
                });

                if (comment.next_page_url == null) $('.show-more').parent().html('No more comments');
            }
        });
    }
    GetUserComment(rid,defPage);

    $('.show-more').on('click', function() {
        defPage++;
        GetUserComment(rid,defPage);
    });

});
