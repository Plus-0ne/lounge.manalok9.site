$(document).ready(function () {
    toastr.options = {
        closeButton: true,
        debug: false,
        newestOnTop: false,
        progressBar: true,
        positionClass: "toast-bottom-right",
        preventDuplicates: false,
        onclick: null,
        showDuration: "500",
        hideDuration: "1000",
        timeOut: "5000",
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
    };

    var page = 1;
    var ruuid = window.ruuid;
    var assetUrl = window.assetUrl;

    function infiniteScroll() {
        if ($(window).scrollTop() + $(window).innerHeight() >= $(document).innerHeight()) {
            page++;
            loadMoreData(page,ruuid);

            return;
        }


    }


    var topPosition = $(window).scrollTop();
    var viewHeight = $(window).innerHeight();
    var nweViewheight;
    var addposandHeight = topPosition + viewHeight;

    function moBileinfiniteScroll(nweViewheight) {

        if (addposandHeight > nweViewheight) {
            page++;
            loadMoreData(page,ruuid);
            nweViewheight = addposandHeight;
        }
    }

    $(window).on('scroll',infiniteScroll);
    $(window).on('touchmove',moBileinfiniteScroll);


    /**
     *
     * CREATE PAGINATION ON ZOOM OUT
     */
    function postSectionTemplate(profi_image,post_by,post_by_name,vd_settings,dateformatted,post_visible,post_message,reactionLike,row_val,prLike,reactionHaha,prHaha,reactionHeart,prHeart,commentsPerPost,SorticontPercomment,fPost_message,post_attachments) {
        var last_comment_att;
        $.each(row_val.post_last_comment, function (plcI, plcVal) {
            last_comment_att = plcVal.created_at;
        });

        $(".posts_section").append('\
                    <div class="px-4 py-3 posted_section thisPostRow tpr_'+row_val.post_id+'" data-postid="'+row_val.post_id+'">\
                        <div class="px-3 py-1 posted_header d-flex flex-wrap align-item-middle">\
                            <div class="posted_header_usericon" style="background-image: url('+profi_image+');">\
                            </div>\
                            <div class="my-auto mx-4 posted_username view-m-profile" data-rid="' + post_by.uuid + '">\
                                '+post_by_name+' \
                            </div>\
                            <div class="align-self-center view-full-post" data-id="'+row_val.post_id+'">\
                                <i class="mdi mdi-eye"></i>\
                                <small> View post</small>\
                            </div>\
                            '+vd_settings+'\
                            <div class="col-12"><hr></div>\
                        </div>\
                        <div class="content-body-text_'+row_val.post_id+'">\
                            <div class="px-3 mb-3 posted_date d-flex flex-column">\
                                <small> '+dateformatted+' </small> <small> '+post_visible+' </small>\
                            </div >\
                            <div class="px-3 py-2 posted_message message_shown" style="display:block;">\
                                '+post_message+'\
                            </div>\
                            <div class="px-3 py-2 posted_message message_hidden" style="display:none;">\
                                '+fPost_message+'\
                            </div>\
                            <div>\
                            '+post_attachments+'\
                            </div>\
                        </div>\
                        <div class="px-3 py-2 post_actions d-flex flex-wrap justify-content-between" >\
                        </div>\
                        <div class="px-3 py-2 post_actions d-flex flex-wrap justify-content-between" >\
                            <div class="" data-pid="" data-uid="">\
                                <div class="reaction-container d-flex flex-row">\
                                    <div class="'+reactionLike+' d-flex flex-column align-items-center me-3">\
                                        <div class="reaction-content reaction-like d-flex justify-content-center me-1 position-relative" data-pid="'+row_val.post_id+'"\
                                            data-uid="'+post_by.uuid+'">\
                                            <span>\
                                                <svg width="18px" height="18px" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">\
                                                    <g>\
                                                        <path fill="none" d="M0 0h24v24H0z"/>\
                                                        <path fill="#ffffff" color="#ffffff" d="M14.6 8H21a2 2 0 0 1 2 2v2.104a2 2 0 0 1-.15.762l-3.095 7.515a1 1 0 0 1-.925.619H2a1 1 0 0 1-1-1V10a1 1 0 0 1 1-1h3.482a1 1 0 0 0 .817-.423L11.752.85a.5.5 0 0 1 .632-.159l1.814.907a2.5 2.5 0 0 1 1.305 2.853L14.6 8zM7 10.588V19h11.16L21 12.104V10h-6.4a2 2 0 0 1-1.938-2.493l.903-3.548a.5.5 0 0 0-.261-.571l-.661-.33-4.71 6.672c-.25.354-.57.644-.933.858zM5 11H3v8h2v-8z"/>\
                                                    </g>\
                                                </svg>\
                                            </span>\
                                            '+prLike+'\
                                        </div>\
                                    </div>\
                                    <div class="'+reactionHaha+' d-flex flex-column align-items-center me-3">\
                                        <div class="reaction-content reaction-haha d-flex justify-content-center me-1 position-relative" data-pid="'+row_val.post_id+'"\
                                        data-uid="'+post_by.uuid+'">\
                                            <span>\
                                                <svg width="18px" height="18px" viewBox="0 0 1500 1500" id="Layer_1" xmlns="http://www.w3.org/2000/svg">\
                                                    <path class="st0" d="M542.7 1092.6H377.6c-13 0-23.6-10.6-23.6-23.6V689.9c0-13 10.6-23.6 23.6-23.6h165.1c13 0 23.6 10.6 23.6 23.6V1069c0 13-10.6 23.6-23.6 23.6zM624 1003.5V731.9c0-66.3 18.9-132.9 54.1-189.2 21.5-34.4 69.7-89.5 96.7-118 6-6.4 27.8-25.2 27.8-35.5 0-13.2 1.5-34.5 2-74.2.3-25.2 20.8-45.9 46-45.7h1.1c44.1 1 58.3 41.7 58.3 41.7s37.7 74.4 2.5 165.4c-29.7 76.9-35.7 83.1-35.7 83.1s-9.6 13.9 20.8 13.3c0 0 185.6-.8 192-.8 13.7 0 57.4 12.5 54.9 68.2-1.8 41.2-27.4 55.6-40.5 60.3-2.6.9-2.9 4.5-.5 5.9 13.4 7.8 40.8 27.5 40.2 57.7-.8 36.6-15.5 50.1-46.1 58.5-2.8.8-3.3 4.5-.8 5.9 11.6 6.6 31.5 22.7 30.3 55.3-1.2 33.2-25.2 44.9-38.3 48.9-2.6.8-3.1 4.2-.8 5.8 8.3 5.7 20.6 18.6 20 45.1-.3 14-5 24.2-10.9 31.5-9.3 11.5-23.9 17.5-38.7 17.6l-411.8.8c-.2 0-22.6 0-22.6-30z"/><path class="st0" d="M750 541.9C716.5 338.7 319.5 323.2 319.5 628c0 270.1 430.5 519.1 430.5 519.1s430.5-252.3 430.5-519.1c0-304.8-397-289.3-430.5-86.1z"/><ellipse class="st1" cx="750.2" cy="751.1" rx="750" ry="748.8"/><g><path id="mond" class="st3" d="M755.3 784.1H255.4s13.2 431.7 489 455.8c6.7.3 11.2.1 11.2.1 475.9-24.1 489-455.9 489-455.9H755.3z"/><path id="tong" class="st4" d="M312.1 991.7s174.8-83.4 435-82.6c129 .4 282.7 12 439.2 83.4 0 0-106.9 260.7-436.7 260.7-329 0-437.5-261.5-437.5-261.5z"/><path id="linker_1_" class="st5" d="M1200.2 411L993 511.4l204.9 94.2"/><path id="linker_4_" class="st5" d="M297.8 411L505 511.4l-204.9 94.2"/></g>\
                                                </svg>\
                                            </span>\
                                            '+prHaha+'\
                                        </div>\
                                    </div>\
                                    <div class="'+reactionHeart+' d-flex flex-column align-items-center me-3">\
                                        <div class="reaction-content reaction-heart d-flex justify-content-center me-1 position-relative" data-pid="'+row_val.post_id+'"\
                                        data-uid="'+post_by.uuid+'">\
                                            <span>\
                                                <?xml version="1.0" encoding="iso-8859-1"?>\
                                                <!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">\
                                                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"\
                                                width="18px" height="18px" viewBox="0 0 544.582 544.582" style="enable-background:new 0 0 544.582 544.582;"\
                                                xml:space="preserve">\
                                                <g>\
                                                    <path fill="#ffffff" color="#ffffff" d="M448.069,57.839c-72.675-23.562-150.781,15.759-175.721,87.898C247.41,73.522,169.303,34.277,96.628,57.839\
                                                    C23.111,81.784-16.975,160.885,6.894,234.708c22.95,70.38,235.773,258.876,263.006,258.876\
                                                    c27.234,0,244.801-188.267,267.751-258.876C561.595,160.732,521.509,81.631,448.069,57.839z"/>\
                                                </g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g>\
                                            </svg>\
                                        </span>\
                                        '+prHeart+'\
                                    </div>\
                                </div>\
                            </div>\
                        </div>\
                        <div class="ctrl-comment-btn ctrl-post-btn-comment" data-pid="' + row_val.post_id + '">\
                            <i class="mdi mdi-comment"></i>\
                            '+row_val.comment_per_post_count+'\
                        </div>\
                    </div>\
                    <div><hr></div>\
                        '+SorticontPercomment+'\
                        <div class="post_comment_section pcs_'+ row_val.post_id +'" data-postid="' + row_val.post_id + '" data-page-count="1" data-last-message_at="'+last_comment_att+'">\
                            '+commentsPerPost+'\
                        </div>\
                    <div><hr></div>\
                    <div class="d-flex flex-row justify-content-center align-items-center textComment-area p-2">\
                        <div class="ex-comment-controll d-flex align-items-center">\
                        </div>\
                        <div class="w-100 ms-1 me-1">\
                            <input type="text" class="form-control commentWithEmoji load_emoji_'+row_val.post_id+'" value=""/>\
                        </div>\
                        <div class="send-comment-section d-flex align-items-center">\
                            <i class="mdi mdi-send"></i>\
                        </div>\
                    </div>\
                </div>\
            <div class= "mx-4 posted_divider" ></div>');

            /* ex-comment-control */
            // <div class="p-1">\
            //                     <i class="mdi mdi-image"></i>\
            //                 </div>\
            //                 <div class="p-1">\
            //                     <i class="mdi mdi-attachment"></i>\
            //                 </div>\

            // /* Initiate emojione */
            // /*  */
            $('.load_emoji_'+row_val.post_id).emojioneArea({
                pickerPosition: "top",
                search:false
            });

            /* Replace url string with links */
            var text_withurl = $('.content-body-text_'+row_val.post_id);
            replaceURLWithHTMLLinks(text_withurl);

    }

    /* Replace url with links */
    function replaceURLWithHTMLLinks(text_withurl) {
        var text_urlinks = text_withurl;
        text_urlinks.html( text_urlinks.html().replace(/((http|https|www):\/\/(www\.)?[\w?=&.\/-;#~%-]+(?![\w\s?&.\/;#~%"=-]*>))/g, '<a href="$1" target="_blank">$1</a> '));

    }


    function htmlPostOutput(res,ruuid,assetUrl) {
        var commentsPerPost;

        $.each(res.data.data, function (row_index, row_val) {
            var posts = row_val;
            var post_by = row_val.members_model;
            var post_reaction = row_val.post_reaction;
            var my_followers = row_val.members_model.my_followers;

            /* Check if name is empty */
            if (post_by.first_name == null || post_by.last_name == null) {
                var post_by_name = 'Guest';
            }
            else {
                var post_by_name = post_by.first_name +' '+post_by.last_name;
            }
            /* Trim post and convert message to text */
            var post_message = posts.post_message;
            var fPost_message = _.escape(post_message);

            if (post_message == null || fPost_message == null) {
                post_message = "";
                fPost_message = "";
            }
            else
            {


                if (post_message.length > 165) {
                    var msg = _.escape(post_message);
                    var str = msg.substring(0 ,165)+'<br>... <a href="#" class="btn_fullvpost"> <small>Show more</small></a>';
                    var post_message = str;
                }
                else
                {
                    var post_message = _.escape(post_message);
                }
            }

            /* Get Profile image */
            var profi_image;
            if (post_by.profile_image == null) {
                profi_image = window.assetUrl+'my_custom_symlink_1/user.png';
            }
            else
            {
                profi_image = window.assetUrl+post_by.profile_image;
            }

            /* Check if Auth user like a post */
            var reactionLike = "";
            var reactionHaha = "";
            var reactionHeart = "";

            if (post_reaction.length < 1) {
                reactionLike = "";
                reactionHaha = "";
                reactionHeart = "";
            }
            $.each(post_reaction, function (rIndex, rVal) {
                if (ruuid == rVal.uuid && rVal.reaction == 1) {
                    reactionLike = "reaction-section";
                    reactionHaha = "";
                    reactionHeart = "";
                }
                if (ruuid == rVal.uuid && rVal.reaction == 2) {
                    reactionLike = "";
                    reactionHaha = "reaction-section";
                    reactionHeart = "";
                }
                if (ruuid == rVal.uuid && rVal.reaction == 3) {
                    reactionLike = "";
                    reactionHaha = "";
                    reactionHeart = "reaction-section";
                }
            });

            /* Get reaction counts */
            var prLike = "";
            if (posts.prLike > 0) {
                prLike = '<span class="reactionCounts position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">'+posts.prLike+'</span>'
            }
            var prHaha = "";
            if (posts.prHaha > 0) {
                prHaha = '<span class="reactionCounts position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">'+posts.prHaha+'</span>'
            }
            var prHeart = "";
            if (posts.prHeart > 0) {
                prHeart = '<span class="reactionCounts position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">'+posts.prHeart+'</span>'
            }

            /* Convert date timestamp */
            var str = posts.created_at;
            var date = moment(str);
            var dateformatted = date.utc().format("MMMM DD YYYY - hh:mm A");

            /* Post Visibility */
            var post_visible;
            if (posts.visibility == 'private') {
                post_visible = '<i class="mdi mdi-lock"></i> <small>Private</small>';
            }
            else
            {
                post_visible = '<i class="mdi mdi-earth"></i> <small>Public</small>';
            }

            var vd_settings = "";
            if (posts.uuid == ruuid) {
                vd_settings = '\
                <div class="my-auto ms-auto d-flex flex-row" data-rid="' + posts.post_id + '">\
                <div class="px-1 posts-vd-options">\
                <i class="mdi mdi-square-edit-outline"></i>\
                </div>\
                <div class="px-1 posts-vd-options delete_this_post" data-rid="' + posts.post_id + '">\
                <i class="mdi mdi-delete"></i>\
                </div>\
                </div>\
                ';
            }
            else
            {
                vd_settings = "";
            }

            /* Post attachment */
            var post_attachments = "";
            var post_attach_content = "";

            if (row_val.type == "post_attachments") {

                $.each(row_val.post_attachments, function (attachIndex, attachValue) {
                     post_attach_content += '<div class="post_att_container">\
                                                <div class="post_att">\
                                                    <img src="'+window.assetUrl+''+attachValue.file_type+'" alt="attachValue.file_path">\
                                                </div>\
                                            </div>';
                });

                post_attachments = '<div class="px-3 py-2">\
                <div class="d-flex flex-row">\
                    '+post_attach_content+'\
                </div>\
                </div>';
            }


            /* Get all comments per post */
            if (row_val.comment_per_post_count < 1) {

                SorticontPercomment = "";
                commentsPerPost  = '\
                <div class="comment_area text-center px-5 no_comment_'+posts.post_id+'">\
                        <small> <i class="mdi mdi-comment-multiple"></i> No comments </small>\
                </div>\
                ';
            }
            else
            {
                if (row_val.comment_per_post_count > 0) {
                    SorticontPercomment = "";
                    SorticontPercomment = '<div class="px-2 pb-3 text-end">\
                        <small class="sort-this-comments stc_' + row_val.post_id + '" data-sortcommentPostid="' + row_val.post_id + '" data-sortedat="oldest">\
                            <i class="mdi mdi-sort"></i> Oldest first\
                        </small>\
                    </div>';
                }
                else
                {
                    SorticontPercomment ="";
                }

                commentsPerPost = "";

                $.each(posts.comment_per_post, function (comKey, comVal) {
                    var commentOwnDet = comVal.user_comment_owner;

                    var commentUserProfImage = window.assetUrl+'my_custom_symlink_1/user.png';
                    var commentNameUser = 'Guest';

                    if (commentOwnDet.first_name != null || commentOwnDet.last_name != null) {
                        commentNameUser = commentOwnDet.first_name +' '+commentOwnDet.last_name;
                    }

                    if (commentOwnDet.profile_image != null) {
                        commentUserProfImage = commentOwnDet.profile_image;
                    }


                    commentsPerPost  += '\
                    <div class="comment_area comment_area_'+posts.post_id+' animate__animated animate__fadeIn px-1 px-xl-4 py-1" data-page-count="1">\
                        <div class="d-flex flex-row">\
                            <div class="comment-profile">\
                                <img width="30px" src="'+commentUserProfImage+'" alt="">\
                            </div>\
                            <div class="comment-content">\
                                <div class="comment-txtInPost d-flex flex-column">\
                                    <strong>'+commentNameUser+'</strong>\
                                    <span>'+comVal.comment+'</span>\
                                </div>\
                            </div>\
                        </div>\
                    </div>\
                    ';
                });

                if (row_val.comment_per_post_count > 1) {
                    commentsPerPost += '\
                    <div class="comment_area animate__animated animate__fadeIn text-center px-5 py-3 smc_Section smc_Section_'+posts.post_id+'">\
                            <a href="#" class="btn btn-outline-dark btn-sm showMoreComments" data-postid="'+posts.post_id+'">\
                                <small> <i class="mdi mdi-comment-multiple"></i> Show comments </small>\
                            </a>\
                    </div>\
                    ';
                }

            }

            if (posts.visibility == 'private' && posts.uuid == ruuid) {
                /* This is my post */

                postSectionTemplate(profi_image,post_by,post_by_name,vd_settings,dateformatted,post_visible,post_message,reactionLike,row_val,prLike,reactionHaha,prHaha,reactionHeart,prHeart,commentsPerPost,SorticontPercomment,fPost_message,post_attachments);
            }
            else if (posts.visibility == 'private') {
                if (my_followers.length > 0) {
                    $.each(my_followers, function (mf_key, mf_val) {
                        if (mf_val.uuid == ruuid) {
                            postSectionTemplate(profi_image,post_by,post_by_name,vd_settings,dateformatted,post_visible,post_message,reactionLike,row_val,prLike,reactionHaha,prHaha,reactionHeart,prHeart,commentsPerPost,SorticontPercomment,fPost_message,post_attachments);
                        }
                    });
                }
            }
            else
            {
                postSectionTemplate(profi_image,post_by,post_by_name,vd_settings,dateformatted,post_visible,post_message,reactionLike,row_val,prLike,reactionHaha,prHaha,reactionHeart,prHeart,commentsPerPost,SorticontPercomment,fPost_message,post_attachments);
            }

        });
    }

    function GetAllPosts(ruuid,assetUrl) {
        var ruuid = ruuid;
        var assetUrl = assetUrl;

        $.ajax({
            url: "/ajax_allpost?page=1",
            type: "get",
            dataType: "json",
            success: function (response) {
                var res = response;
                console.log(res);

                htmlPostOutput(res,ruuid,assetUrl);
            },
        });
    }

    GetAllPosts(ruuid,assetUrl);

    function loadMoreData(page,ruuid) {
        var ruuid = ruuid;
        var assetUrl = assetUrl;

        $.ajax({
            url: "/ajax_allpost?page=" + page,
            type: "get",
            dataType: "json",
            beforeSend: function () {
                $(".spinner-load-data").show();
            },
            success: function (response) {
                var res = response;
                console.log(res);
                htmlPostOutput(res,ruuid,assetUrl);
            }
        })
    }





    /* =============== Post reaction =============== */
    $(document).on('click','.reaction-like', function () {

        var reactionvalue = 1;
        var pid = $(this).attr("data-pid");
        var uid = $(this).attr("data-uid");
        var reaction = $(this);
        var reactionCounts = $(this).children('.reactionCounts');
        var reactionSection = $(this).parent();
        var reactionContainer =  $(this).parent().parent();

        var reaction_like = reactionContainer.find('div > .reaction-like');
        var reaction_haha = reactionContainer.find('div > .reaction-haha');
        var reaction_heart = reactionContainer.find('div > .reaction-heart');

        $.ajax({
            type: "post",
            url: "/ajax/post_reaction",
            data: {
                pid: pid,
                uid: uid,
                reactionvalue:reactionvalue
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                var res = response;

                if (res.isLiked == true) {
                    reactionContainer.children('div').removeClass('reaction-section');
                    reactionSection.addClass('reaction-section');

                    if (reaction_like.find('.reactionCounts').length < 1) {
                        if (res.CountLike > 0) {
                            reaction_like.append('<span class="reactionCounts position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">'+res.CountLike+'</span>');
                        }
                        else
                        {
                            reaction_like.children('.reactionCounts').remove();
                        }
                    }
                    else
                    {
                        if (res.CountLike > 0) {
                            reaction_like.append('<span class="reactionCounts position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">'+res.CountLike+'</span>');
                        }
                        else
                        {
                            reaction_like.children('.reactionCounts').remove();
                        }

                    }


                    if (reaction_haha.find('.reactionCounts').length < 1) {
                        if (res.CountHaha > 0) {
                            reaction_haha.append('<span class="reactionCounts position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">'+res.CountHaha+'</span>');
                        }
                        else
                        {
                            reaction_haha.children('.reactionCounts').remove();
                        }
                    }
                    else
                    {
                        if (res.CountHaha > 0) {
                            reaction_haha.append('<span class="reactionCounts position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">'+res.CountHaha+'</span>');
                        }
                        else
                        {
                            reaction_haha.children('.reactionCounts').remove();
                        }

                    }

                    if (reaction_heart.find('.reactionCounts').length < 1) {
                        if (res.CountHeart > 0) {
                            reaction_heart.append('<span class="reactionCounts position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">'+res.CountHeart+'</span>');
                        }
                        else
                        {
                            reaction_heart.children('.reactionCounts').remove();
                        }
                    }
                    else
                    {
                        if (res.CountHeart > 0) {
                            reaction_heart.append('<span class="reactionCounts position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">'+res.CountHeart+'</span>');
                        }
                        else
                        {
                            reaction_heart.children('.reactionCounts').remove();
                        }

                    }
                }
                else
                {
                    reactionSection.removeClass('reaction-section');
                    if (reaction_like.find('.reactionCounts').length < 1) {
                        if (res.CountLike > 0) {
                            reaction_like.append('<span class="reactionCounts position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">'+res.CountLike+'</span>');
                        }
                        else
                        {
                            reaction_like.children('.reactionCounts').remove();
                        }
                    }
                    else
                    {
                        if (res.CountLike > 0) {
                            reaction_like.append('<span class="reactionCounts position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">'+res.CountLike+'</span>');
                        }
                        else
                        {
                            reaction_like.children('.reactionCounts').remove();
                        }

                    }
                }
            }
        });

    });
    $(document).on('click','.reaction-haha', function () {
        var reactionvalue = 2;
        var pid = $(this).attr("data-pid");
        var uid = $(this).attr("data-uid");
        var reaction = $(this);
        var reactionCounts = $(this).children('.reactionCounts');
        var reactionSection = $(this).parent();
        var reactionContainer =  $(this).parent().parent();

        var reaction_like = reactionContainer.find('div > .reaction-like');
        var reaction_haha = reactionContainer.find('div > .reaction-haha');
        var reaction_heart = reactionContainer.find('div > .reaction-heart');

        $.ajax({
            type: "post",
            url: "/ajax/post_reaction",
            data: {
                pid: pid,
                uid: uid,
                reactionvalue:reactionvalue
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                var res = response;

                if (res.isLiked == true) {
                    reactionContainer.children('div').removeClass('reaction-section');
                    reactionSection.addClass('reaction-section');

                    if (reaction_like.find('.reactionCounts').length < 1) {
                        if (res.CountLike > 0) {
                            reaction_like.append('<span class="reactionCounts position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">'+res.CountLike+'</span>');
                        }
                        else
                        {
                            reaction_like.children('.reactionCounts').remove();
                        }
                    }
                    else
                    {
                        if (res.CountLike > 0) {
                            reaction_like.append('<span class="reactionCounts position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">'+res.CountLike+'</span>');
                        }
                        else
                        {
                            reaction_like.children('.reactionCounts').remove();
                        }

                    }


                    if (reaction_haha.find('.reactionCounts').length < 1) {
                        if (res.CountHaha > 0) {
                            reaction_haha.append('<span class="reactionCounts position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">'+res.CountHaha+'</span>');
                        }
                        else
                        {
                            reaction_haha.children('.reactionCounts').remove();
                        }
                    }
                    else
                    {
                        if (res.CountHaha > 0) {
                            reaction_haha.append('<span class="reactionCounts position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">'+res.CountHaha+'</span>');
                        }
                        else
                        {
                            reaction_haha.children('.reactionCounts').remove();
                        }

                    }

                    if (reaction_heart.find('.reactionCounts').length < 1) {
                        if (res.CountHeart > 0) {
                            reaction_heart.append('<span class="reactionCounts position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">'+res.CountHeart+'</span>');
                        }
                        else
                        {
                            reaction_heart.children('.reactionCounts').remove();
                        }
                    }
                    else
                    {
                        if (res.CountHeart > 0) {
                            reaction_heart.append('<span class="reactionCounts position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">'+res.CountHeart+'</span>');
                        }
                        else
                        {
                            reaction_heart.children('.reactionCounts').remove();
                        }

                    }
                }
                else
                {
                    reactionSection.removeClass('reaction-section');
                    if (reaction_haha.find('.reactionCounts').length < 1) {
                        if (res.CountHaha > 0) {
                            reaction_haha.append('<span class="reactionCounts position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">'+res.CountHaha+'</span>');
                        }
                        else
                        {
                            reaction_haha.children('.reactionCounts').remove();
                        }
                    }
                    else
                    {
                        if (res.CountHaha > 0) {
                            reaction_haha.append('<span class="reactionCounts position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">'+res.CountHaha+'</span>');
                        }
                        else
                        {
                            reaction_haha.children('.reactionCounts').remove();
                        }

                    }

                }
            }
        });

    });
    $(document).on('click','.reaction-heart', function () {
        var reactionvalue = 3;
        var pid = $(this).attr("data-pid");
        var uid = $(this).attr("data-uid");
        var reaction = $(this);
        var reactionCounts = $(this).children('.reactionCounts');
        var reactionSection = $(this).parent();
        var reactionContainer =  $(this).parent().parent();

        var reaction_like = reactionContainer.find('div > .reaction-like');
        var reaction_haha = reactionContainer.find('div > .reaction-haha');
        var reaction_heart = reactionContainer.find('div > .reaction-heart');

        $.ajax({
            type: "post",
            url: "/ajax/post_reaction",
            data: {
                pid: pid,
                uid: uid,
                reactionvalue:reactionvalue
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                var res = response;

                if (res.isLiked == true) {
                    reactionContainer.children('div').removeClass('reaction-section');
                    reactionSection.addClass('reaction-section');

                    if (reaction_like.find('.reactionCounts').length < 1) {
                        if (res.CountLike > 0) {
                            reaction_like.append('<span class="reactionCounts position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">'+res.CountLike+'</span>');
                        }
                        else
                        {
                            reaction_like.children('.reactionCounts').remove();
                        }
                    }
                    else
                    {
                        if (res.CountLike > 0) {
                            reaction_like.append('<span class="reactionCounts position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">'+res.CountLike+'</span>');
                        }
                        else
                        {
                            reaction_like.children('.reactionCounts').remove();
                        }

                    }


                    if (reaction_haha.find('.reactionCounts').length < 1) {
                        if (res.CountHaha > 0) {
                            reaction_haha.append('<span class="reactionCounts position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">'+res.CountHaha+'</span>');
                        }
                        else
                        {
                            reaction_haha.children('.reactionCounts').remove();
                        }
                    }
                    else
                    {
                        if (res.CountHaha > 0) {
                            reaction_haha.append('<span class="reactionCounts position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">'+res.CountHaha+'</span>');
                        }
                        else
                        {
                            reaction_haha.children('.reactionCounts').remove();
                        }

                    }

                    if (reaction_heart.find('.reactionCounts').length < 1) {
                        if (res.CountHeart > 0) {
                            reaction_heart.append('<span class="reactionCounts position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">'+res.CountHeart+'</span>');
                        }
                        else
                        {
                            reaction_heart.children('.reactionCounts').remove();
                        }
                    }
                    else
                    {
                        if (res.CountHeart > 0) {
                            reaction_heart.append('<span class="reactionCounts position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">'+res.CountHeart+'</span>');
                        }
                        else
                        {
                            reaction_heart.children('.reactionCounts').remove();
                        }

                    }
                }
                else
                {
                    reactionSection.removeClass('reaction-section');
                    if (reaction_heart.find('.reactionCounts').length < 1) {
                        if (res.CountHeart > 0) {
                            reaction_heart.append('<span class="reactionCounts position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">'+res.CountHeart+'</span>');
                        }
                        else
                        {
                            reaction_heart.children('.reactionCounts').remove();
                        }
                    }
                    else
                    {
                        if (res.CountHeart > 0) {
                            reaction_heart.append('<span class="reactionCounts position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">'+res.CountHeart+'</span>');
                        }
                        else
                        {
                            reaction_heart.children('.reactionCounts').remove();
                        }

                    }

                }
            }
        });

    });

    function getLatestComments(post_uuid,latest_created_at,showMoreComments) {

        var post_uuid = post_uuid;
        var created_at = latest_created_at;

        $.ajax({
            type: "post",
            url: '/ajax/get_latest_comments',
            data: {
                post_uuid: post_uuid,
                created_at: created_at,
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                var res = response;

                /* Set new data-last-message_at */
                $('.pcs_'+post_uuid).attr('data-last-message_at',res.new_created_at);

                commentAreaFor = $('.pcs_'+post_uuid);

                /* Append new comments to comment section */
                $.each(res.new_comments, function (newCindex, newCvalue) {

                    commentOwnDet = newCvalue.members_model;
                    commentUserProfImage = window.assetUrl+'my_custom_symlink_1/user.png';
                    commentNameUser = 'Guest';

                    if (commentOwnDet.first_name != null || commentOwnDet.last_name != null) {
                        commentNameUser = commentOwnDet.first_name +' '+commentOwnDet.last_name;
                    }

                    if (commentOwnDet.profile_image != null) {
                        commentUserProfImage = commentOwnDet.profile_image;
                    }

                    commentAreaFor.append('\
                    <div class="comment_area comment_area_'+newCvalue.post_id+' px-1 px-xl-4 py-1" data-page-count="1" data-comment-at="'+newCvalue.created_at+'">\
                        <div class="d-flex flex-row">\
                            <div class="comment-profile">\
                                <img width="30px" src="'+commentUserProfImage+'" alt="">\
                            </div>\
                            <div class="comment-content">\
                                <div class="comment-txtInPost d-flex flex-column">\
                                    <strong>'+commentNameUser+'</strong>\
                                    <span>'+newCvalue.comment+'</span>\
                                </div>\
                            </div>\
                        </div>\
                    </div>\
                    ');
                });

                $(showMoreComments.parent()).insertAfter(commentAreaFor.find('.comment_area').last());

            }
        });
    }
    /* send-comment-section submit comment */

    $(document).on('click','.send-comment-section', function (e) {

        var textComment_area = $(this).parent();
        var messageTxt = textComment_area.find('.commentWithEmoji');
        var post_uuid = textComment_area.parent().attr('data-postid');
        var emojionearea_editor = textComment_area.find('.emojionearea-editor');

        /* Update comment section change to paginated */
        var showMoreComments = $('.smc_Section_'+post_uuid).find('.showMoreComments');

        var thisbtn = $(this);
        thisbtn.prop('disabled',true);
        e.preventDefault();
        $.ajax({
            type: "post",
            url: "/ajax/comment_in_post",
            data: {
                post_uuid:post_uuid,
                messageTxt:messageTxt.val()
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {


                emojionearea_editor.data("emojioneArea").setText('');
                messageTxt.val("");

                /* Get latest comments */
                var latest_created_at = $('.pcs_'+post_uuid).attr('data-last-message_at');
                getLatestComments(post_uuid,latest_created_at,showMoreComments);

                /* remove no_comment_postuuid */
                $('.pcs_'+post_uuid).find('.no_comment_'+post_uuid).remove();

                thisbtn.prop('disabled',false);
            }
        });


    });


    /* Function for pagination comments */
    function get_paginated_comments(res,commentAreaFor,smc_Section,showMoreComments) {
        var comments = res.PostComments;
        var commentOwnDet;
        var commentUserProfImage;
        var commentNameUser;

        $.each(comments.data, function (comKey, comVal) {

            commentOwnDet = comVal.members_model;
            commentUserProfImage = window.assetUrl+'my_custom_symlink_1/user.png';
            commentNameUser = 'Guest';

            if (commentOwnDet.first_name != null || commentOwnDet.last_name != null) {
                commentNameUser = commentOwnDet.first_name +' '+commentOwnDet.last_name;
            }

            if (commentOwnDet.profile_image != null) {
                commentUserProfImage = commentOwnDet.profile_image;
            }

            commentAreaFor.append('\
            <div class="comment_area comment_area_'+comVal.post_id+' px-1 px-xl-4 py-1" data-page-count="1" data-comment-at="'+comVal.created_at+'">\
                <div class="d-flex flex-row">\
                    <div class="comment-profile">\
                        <img width="30px" src="'+commentUserProfImage+'" alt="">\
                    </div>\
                    <div class="comment-content">\
                        <div class="comment-txtInPost d-flex flex-column">\
                            <strong>'+commentNameUser+'</strong>\
                            <span>'+comVal.comment+'</span>\
                        </div>\
                    </div>\
                </div>\
            </div>\
            ');
        });

        $(smc_Section).insertAfter(commentAreaFor.find('.comment_area').last());

        if (comments.next_page_url == null) {
            showMoreComments.html('No more comments');
            commentAreaFor.find('.comment_area').last().remove();
        }
    }

    function commentGetPaginated(showMoreComments,sortComments) {
        /* Post id */
        var post_id = showMoreComments.attr('data-postid');

        /* Created at */
        var comment_created_at = '0000-00-00 00:00:00';

        /* Sort value */
        var sortComments = sortComments;
        if ($('.stc_'+post_id).attr('data-sortedat') == 'oldest') {
            sortComments = 'newest';
        }
        else {
            sortComments = 'oldest';
        }
        /* Show more button div parent container */
        var smc_Section = showMoreComments.parent();

        /* Comment area for this post id */
        var commentAreaFor = $('.pcs_'+post_id);

        var pageCount = commentAreaFor.attr('data-page-count');

        if (pageCount == 1) {
            commentAreaFor.empty();
        }

        /* ajax get comments */
        $.ajax({
            type: "post",
            url: '/ajax/get_paginate_comments?page='+pageCount,
            data: {
                post_id: post_id,
                comment_created_at: comment_created_at,
                sortComments : sortComments
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {


                pageCount++;
                commentAreaFor.attr('data-page-count',pageCount);
                var res = response;
                console.log(res);

                /* Empty commentAreaFor */
                get_paginated_comments(res,commentAreaFor,smc_Section,showMoreComments);

                /* Last comment update */
                $('.pcs_'+post_id).attr('data-last-message_at',res.last_comment_at);

            }
        });
    }
    $(document).on('click','.showMoreComments', function (e) {
        e.preventDefault();

        var showMoreComments = $(this);
        var sortComments = 'newest';
        commentGetPaginated(showMoreComments,sortComments);

    });

    /* Sort post comments */

    $(document).on('click','.sort-this-comments', function (e) {
        e.preventDefault();

        /* Sort button */
        var labelButtonSort = $(this);

        /* Post UUID */
        var sortComment = labelButtonSort.attr('data-sortcommentPostid');

        /* Sort default value */
        var sortDefaultVal = labelButtonSort.attr('data-sortedat');

        var ascOrDesc = "";

        if (sortDefaultVal == 'oldest') {
            labelButtonSort.attr('data-sortedat','latest');
            labelButtonSort.html('<i class="mdi mdi-sort"></i> Latest first');
            ascOrDesc = 'asc';
        } else if (sortDefaultVal == 'latest') {
            labelButtonSort.attr('data-sortedat','oldest');
            labelButtonSort.html('<i class="mdi mdi-sort"></i> Oldest first');
            ascOrDesc = 'desc';
        }
        else {
            labelButtonSort.attr('data-sortedat','latest');
            labelButtonSort.html('<i class="mdi mdi-sort"></i> Latest first');
            ascOrDesc = 'asc';
        }

        /* Post id */
        var post_id = sortComment;

        /* Created at */
        var comment_created_at = '0000-00-00 00:00:00';

        /* Sort value */
        var sortComments = 'newest';

        if (ascOrDesc == 'desc') {
            sortComments = 'newest';
        }
        else {
            sortComments = 'oldest';
        }

        /* Show more button div parent container */
        var smc_Section = $('.smc_Section_'+post_id);
        var showMoreComments = smc_Section.find('.showMoreComments');

        /* Comment area for this post id */
        var commentAreaFor = smc_Section.parent().parent().parent().find('.pcs_'+post_id);

        var pageCount = 1;

        /* Reset comments section */
        commentAreaFor.empty();
        /* ajax get comments */
        $.ajax({
            type: "post",
            url: '/ajax/get_paginate_comments?page='+pageCount,
            data: {
                post_id: post_id,
                comment_created_at: comment_created_at,
                sortComments : sortComments
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                /* Empty commentAreaFor */
                commentAreaFor.empty();

                pageCount++;
                commentAreaFor.attr('data-page-count',pageCount);

                var res = response;
                console.log(res);


                get_paginated_comments(res,commentAreaFor,smc_Section,showMoreComments);

                /* Update last comments */
                $('.pcs_'+post_id).attr('data-last-message_at',res.last_comment_at);

            }
        });
    });

    /* Show more */
    $(document).on('click','.btn_fullvpost', function (e) {
        e.preventDefault();

        var message_shown = $(this).parent();
        var message_hidden = $(this).parent();
        var post_message_container = message_shown.parent();

        message_shown.toggle();
        post_message_container.find('.message_hidden').toggle();

    });
    /* Onload get all notifications */









});
