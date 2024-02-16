// import Echo from "laravel-echo";

$(document).ready(function () {
    function load_likecounter() {
        $.ajax({
            type: "get",
            url: "CheckUserLiked",
            data: { post_id: post_id },
            success: function (response) {
                $("#like-mdi-icon").empty();
                if (response.status == "true") {
                    $("#like-mdi-icon").html(
                        '<i class="mdi mdi-thumb-up icon-like icn-active"></i>'
                    );
                } else {
                    $("#like-mdi-icon").html(
                        '<i class="mdi mdi-thumb-up-outline icon-like"></i>'
                    );
                }
                $("#like_countss").html(response.like_count);
            },
        });
    }

    load_likecounter();

    setInterval(function () {
        $.ajax({
            type: "get",
            url: "CheckUserLiked",
            data: { post_id: post_id },
            success: function (response) {
                $("#like-mdi-icon").empty();
                if (response.status == "true") {
                    $("#like-mdi-icon").html(
                        '<i class="mdi mdi-thumb-up icon-like icn-active"></i>'
                    );
                } else {
                    $("#like-mdi-icon").html(
                        '<i class="mdi mdi-thumb-up-outline icon-like"></i>'
                    );
                }

                $("#like_countss").html(response.like_count);
            },
        });
    }, 5000);

    $(document).on("click", ".icon-like", function () {
        $.ajax({
            type: "post",
            url: "LikeOrUnlikePost",
            data: { post_id: post_id },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                load_likecounter();
            },
            complete: function () {},
        });
    });

    $("#btn-comment-modal").on("click", function () {
        $("#new_comment").modal("toggle");
    });
    $("#post_comments_emo").emojioneArea({
        search: false,
        pickerPosition: "bottom",
        filtersPosition: "bottom",
    });

    /* GET ALL COMMENT BY POST */
    var date_starts = "0000-00-00 00:00:00";
    var pagen = 1;

    function GetAllComments(post_id, pagen, date_starts) {
        var date_starts = date_starts;
        var pagen = pagen;
        var pid = post_id;
        $.ajax({
            type: "post",
            url: "get_all_comments_thispost?page=" + pagen,
            data: { pid: pid, date_starts: date_starts },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                switch (response.status) {
                    case "key_error":
                        toastr["error"](response.message);
                        break;
                    case "null":
                        $("#comment-section").html(
                            '<div class="text-center"><p> No comment posted </p></div>'
                        );
                        break;
                    case "success":
                        $.each(response.comments.data, function (key, value) {
                            if (value.uuid !== pun) {
                                var frev = "flex-row";
                                var marus = "me-3";
                                var text_loc = "text-start";
                                var c_margin = "lm-right";
                            } else {
                                var frev = "flex-row-reverse";
                                var marus = "ms-3";
                                var text_loc = "text-end";
                                var c_margin = "lm-left";
                            }

                            /* CONVERT DATE TO READABLE DATE TIME */

                            var str = value.created_at;
                            var date = moment(str);
                            var daate = date
                                .utc()
                                .format("YYYY-MM-DD hh:mm:ss A");

                            date_starts = value.created_at;

                            if (value.members_model.profile_image == null) {
                                profile_image = "img/user/user.png";
                            } else {
                                profile_image =
                                    value.members_model.profile_image;
                            }

                            var UserName = value.members_model.first_name;

                            if (UserName == null) {
                                UserName = "Guest";
                            }

                            $("#comment-section").append(
                                '<div class="my-4 d-flex ' +
                                    frev +
                                    '"> \
                                    <div class="prof-img-comment ' +
                                    marus +
                                    '"> \
                                        <img src="' +
                                    profile_image +
                                    '"> \
                                    </div> \
                                    <div class="placeholder-comment w-auto ' +
                                    text_loc +
                                    " " +
                                    c_margin +
                                    '"> \
                                        <h5>' +
                                    UserName +
                                    "</h5> \
                                        " +
                                    value.comment +
                                    " \
                                        <br><small>" +
                                    daate +
                                    " </small>\
                                    </div>\
                                </div>"
                            );
                        });
                        break;

                    default:
                        break;
                }
            },
        });
    }

    $(document).on("click", ".nextpost", function () {
        pagen++;
        GetAllComments(post_id, pagen, date_starts);
    });

    GetAllComments(post_id, pagen, date_starts);

    /* Post new comments */
    $("#submit_post").on("click", function () {
        var pid = post_id;
        var postComment = $(".post_comment_val");
        var punumber = ownpun;

        $.ajax({
            type: "post",
            url: "insert_new_comment",
            data: {
                pid: pid,
                postComment: postComment.val(),
                punumber: punumber,
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                switch (response.status) {
                    case "warning":
                        toastr["warning"](response.message);
                        break;
                    case "success":
                        $("#new_comment").modal("toggle");
                        $(".emojionearea-editor").html("");
                        break;
                    default:
                        break;
                }
            },
            complete: function () {
                $("#new_comment").modal("toggle");
                $(".emojionearea-editor").html("");
                UpdateCommentSection(post_id, date_starts);
            },
        });
    });

    /* UPDATE COMMENT SECTION */
    function UpdateCommentSection(post_id, date_starts) {
        var pid = post_id;

        $.ajax({
            type: "post",
            url: "GetLatestComment",
            data: { pid: pid, date_starts: date_starts },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                var dt = response.comments[0];
                if (dt.uuid !== pun) {
                    var frev = "flex-row";
                    var marus = "me-3";
                    var text_loc = "text-start";
                    var c_margin = "lm-right";
                } else {
                    var frev = "flex-row-reverse";
                    var marus = "ms-3";
                    var text_loc = "text-end";
                    var c_margin = "lm-left";
                }

                /* CONVERT DATE TO READABLE DATE TIME */

                var str = dt.created_at;
                var date = moment(str);
                var daate = date.utc().format("YYYY-MM-DD hh:mm:ss A");

                if (dt.members_model.profile_image == null) {
                    profile_image = "img/user/user.png";
                } else {
                    profile_image = dt.members_model.profile_image;
                }

                var UserName = dt.members_model.first_name;

                if (UserName == null) {
                    UserName = "Guest";
                }

                date_starts = dt.created_at;
                $("#comment-section").prepend(
                    '\
                <div class="my-4 d-flex ' +
                        frev +
                        '"> \
                <div class="prof-img-comment ' +
                        marus +
                        '"> \
                <img src="' +
                        profile_image +
                        '"> \
                </div> \
                <div class="placeholder-comment w-auto ' +
                        text_loc +
                        " " +
                        c_margin +
                        '"> \
                <h5>' +
                        UserName +
                        "</h5> \
                " +
                        dt.comment +
                        " \
                <br><small>" +
                        daate +
                        " </small>\
                </div>\
                </div>"
                );
            },
        });
    }

    /* BROADCAST */
    function post_notification(e) {
        toastr["success"](e.message);
        UpdateCommentSection(post_id, date_starts);
    }
    Echo.private("current.post.notification." + post_id).listen(
        "YourPostNotification",
        (e) => {
            post_notification(e);
        }
    );
});
