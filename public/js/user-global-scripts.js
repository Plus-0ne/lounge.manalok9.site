$(document).ready(function () {
    /* Nofity user if new message received */

    Echo.private('messenger.notify.user.' + window.uuid).listen(
        "MessengerNotifyUser", (e) => {
            /* Check if message section is open */
            var message_sectionOpen = $('#convo-body-id');


            if (message_sectionOpen.length < 1) {

                /* TODO : Show message prompts */
                var profileImage = window.urlAssets + 'img/user/user.png';
                if (e.sender_details.profile_image != null) {
                    profileImage = window.urlAssets + '/' + e.sender_details.profile_image;
                }
                var toastContainer = $('.toast-container');
                var toastPrompts = $('\
                <div class="toast toastCustom messengerToast hide" role="alert" aria-live="assertive" aria-atomic="true">\
                        <div class="toast-header tHeaderCustom">\
                            <i class="action-icon mdi mdi-chat"></i>\
                                <strong class="me-auto">New message</strong>\
                                <small>Just now</small>\
                                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>\
                        </div>\
                        <div class="toast-body tBodyCustom">\
                            <img class="tb-image-icon" src="'+ profileImage + '">\
                            '+ e.sender_details.first_name + ' sent a new message.\
                        </div>\
                    </div>\
                ').appendTo(toastContainer);

                $(toastPrompts[0]).toast('show');



            }
            audioNotif.play();
            /* TODO : Update navbar messenger icon */

            // NavBarMessengerBadge();


        });

    /* enable bootstrap popovers */
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl)
    });

    /* -------------------------------------------------------------------------- */
    /*                               Search scripts                               */
    /* -------------------------------------------------------------------------- */
    var upage = 1;
    var ppage = 1;

    function search_all(ps_search_input, upage, ppage) {

        var ps_search_input = ps_search_input;




        if (ps_search_input.val().length < 1) {
            return false;
        }

        $.ajax({
            type: "post",
            url: window.thisUrl+'/ajax/search?upage=' + upage + '&page=' + ppage,
            data: {
                ps_search_input: ps_search_input.val()
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            beforeSend: function () {
                ps_search_input.val("");
            },
            success: function (response) {
                var res = response;

                console.log(res);

                if (res.status == 'success') {

                    const myModal = new bootstrap.Modal(document.getElementById('searchResultModal'), {});

                    myModal.show();

                    detectSearchModalShow(res);

                }
            }

        });

    }

    $(document).on('click', '.search_icon_container', function (e) {

        var ps_search_input = $('#ps_search_input');

        search_all(ps_search_input, upage, ppage);
    });

    $(document).on('keyup', '#ps_search_input', function (e) {

        if (e.key === 'Enter' || e.code === 13) {
            var ps_search_input = $('#ps_search_input');

            search_all(ps_search_input, upage, ppage);
        }
    });

    function userResultGenerate(res) {
        var content;
        var user_result_container = $('#user_result_container');
        var profile_picture;
        var user_complete_name;
        var formattedDate;
        var follower_status;


        $.each(res.mm.data, function (mmI, mmVal) {

            userResultHtml(content, user_result_container, profile_picture, user_complete_name, mmI, mmVal, formattedDate, follower_status);
        });

        $('.resultCountssss').html(res.mm.total);

        if (res.mm.next_page_url != null) {
            user_result_container.append('<div class="px-3 py-2" data-searchStr="' + res.searchString + '">\
                <button type="button" class="btn btn-primary btn-sm show_more_users">More results</button>\
            </div>');

        }
    }


    function userResultHtml(content, user_result_container, profile_picture, user_complete_name, mmI, mmVal, formattedDate, follower_status) {
        content = "";
        formattedDate = "";
        follower_status = "";

        profile_picture = window.urlAssets + 'my_custom_symlink_1/user.png';
        user_complete_name = 'Guest';

        if (mmVal.profile_image != null) {
            profile_picture = window.urlAssets + '/' + mmVal.profile_image;
        }

        if (mmVal.first_name.length > 0 || mmVal.last_name.length > 0) {
            user_complete_name = mmVal.first_name + ' ' + mmVal.last_name;
        }
        /* Format date */
        formattedDate = moment(mmVal.created_at).local().format("YYYY");

        /* Check if follower */
        if (mmVal.my_followers.length > 0) {
            follower_status = '<span class="badge bg-secondary follow_button">\
                Following\
            </span>';
        }
        else if (mmVal.uuid == window.uuid) {
            follower_status = '<span class="badge bg-info follow_button">\
                Me\
            </span>';
        }
        else {
            follower_status = '<span class="badge bg-primary follow_button">\
                Follow\
            </span>';
        }
        content += '<div class="row_user_result px-3 py-3 my-1 d-flex flex-row" data-uuid="' + mmVal.uuid + '">\
                        <div class="image-container-search">\
                            <img src="'+ profile_picture + '" alt="" srcset="">\
                        </div>\
                        <div class="d-flex flex-column ms-3 ff-primary">\
                            <div class="search_details_container d-flex flex-row  align-items-center">\
                                <div>\
                                '+ user_complete_name + ' | '+mmVal.iagd_number+'\
                                </div>\
                                <div class="ms-1">\
                                    <small>\
                                        '+ follower_status + '\
                                    </small>\
                                </div>\
                            </div>\
                            <div class="ff-primary">\
                                <small style="font-size: 0.8rem;">\
                                    Member since '+ formattedDate + '\
                                </small>\
                            </div>\
                        </div>\
                    </div>';

        user_result_container.append(content);

    }

    var searchResultModal = document.getElementById('searchResultModal')
    searchResultModal.addEventListener('hidden.bs.modal', function (event) {
        $('#user_result_container').html("");
    });

    /* -------------------------------------------------------------------------- */
    /*                          Search modal show detect                          */
    /* -------------------------------------------------------------------------- */
    function detectSearchModalShow(res) {
        var searchResultModal = document.getElementById('searchResultModal')
        searchResultModal.addEventListener('shown.bs.modal', function (event) {
            $('#user_result_container').html("");
            userResultGenerate(res);
        });
    }

    /* -------------------------------------------------------------------------- */
    /*                 On click in search result show user profile                */
    /* -------------------------------------------------------------------------- */
    $(document).on('click', '.row_user_result', function (e) {

        e.preventDefault();

        var user_uuid = $(this).attr('data-uuid');

        window.location.href = window.thisUrl + "/view/members-details?rid=" + user_uuid;
    });

    /* -------------------------------------------------------------------------- */
    /*                         Paginate user search result                        */
    /* -------------------------------------------------------------------------- */
    $(document).on('click', '.show_more_users', function () {
        var show_more_users_div = $(this).parent();
        var searchStr = show_more_users_div.attr('data-searchStr');

        upage++;

        $.ajax({
            type: "post",
            url: window.thisUrl+"/ajax/search/user/paginated?upage=" + upage,
            data: {
                searchStr: searchStr
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                var res = response;
                console.log(res);
                if (res.status == 'success') {
                    show_more_users_div.remove();

                    /* Append new user in results */
                    newUserAppend(res);

                }
            }
        });

    });

    /* -------------------------------------------------------------------------- */
    /*                      Function append new user results                      */
    /* -------------------------------------------------------------------------- */
    function newUserAppend(res) {
        var res = res;
        var nuser_content;


        var user_result_container = $('#user_result_container');
        var profile_picture;
        var user_complete_name;
        var formattedDate;
        var follower_status;

        $.each(res.mm.data, function (mmi, mmval) {
            nuser_content = "";
            formattedDate = "";
            follower_status = "";

            profile_picture = window.urlAssets + 'my_custom_symlink_1/user.png';
            user_complete_name = 'Guest';

            if (mmval.profile_image != null) {
                profile_picture = window.urlAssets + '/' + mmval.profile_image;
            }

            if (mmval.first_name.length > 0 || mmval.last_name.length > 0) {
                user_complete_name = mmval.first_name + ' ' + mmval.last_name;
            }
            /* Format date */
            formattedDate = moment(mmval.created_at).local().format("YYYY");

            /* Check if follower */
            if (mmval.my_followers.length > 0) {
                follower_status = '<span class="badge bg-secondary follow_button">\
                    Following\
                </span>';
            }
            else if (mmval.uuid == window.uuid) {
                follower_status = '<span class="badge bg-info follow_button">\
                    Me\
                </span>';
            }
            else {
                follower_status = '<span class="badge bg-primary follow_button">\
                    Follow\
                </span>';
            }
            nuser_content += '<div class="row_user_result px-3 py-3 my-1 d-flex flex-row" data-uuid="' + mmval.uuid + '">\
                            <div class="image-container-search">\
                                <img src="'+ profile_picture + '" alt="" srcset="">\
                            </div>\
                            <div class="d-flex flex-column ms-3 ff-primary">\
                                <div class="search_details_container d-flex flex-row  align-items-center">\
                                    <div>\
                                    '+ user_complete_name + '\
                                    </div>\
                                    <div class="ms-1">\
                                        <small>\
                                            '+ follower_status + '\
                                        </small>\
                                    </div>\
                                </div>\
                                <div class="ff-primary">\
                                    <small style="font-size: 0.8rem; ">\
                                        Member since '+ formattedDate + '\
                                    </small>\
                                </div>\
                            </div>\
                        </div>';

            user_result_container.append(nuser_content);

        });

        if (res.mm.next_page_url != null) {
            user_result_container.append('<div class="px-3 py-2" data-searchStr="' + res.searchString + '">\
                <button type="button" class="btn btn-primary btn-sm show_more_users">More results</button>\
            </div>');

        }
    }

    /* -------------------------------------------------------------------------- */
    /*                     Broadcast and notification listener                    */
    /* -------------------------------------------------------------------------- */
    Echo.private('my.notification.' + window.id)
        .notification((notification) => {

            toastr["success"](notification.message);
            audioNotif.play();
            onLoadNotif();
        });

    Echo.private("notification.reaction." + window.uuid).listen(
        "ReactNotification",
        (e) => {
            toastTemplate(e);
            audioNotif.play();
            onLoadNotif();
        }
    );
    Echo.private("notification.comments." + window.uuid).listen(
        "CommentNotification",
        (e) => {
            toastTemplate(e);
            audioNotif.play();
            onLoadNotif();
        }
    );
    Echo.private("user.create.post." + window.uuid).listen(
        "UserCreatePost",
        (e) => {
            toastTemplate(e);
            audioNotif.play();
            onLoadNotif();
        }
    );


    /* Toasts template */
    function toastTemplate(e) {
        var toastContainer = $('.toast-container');
        var toastPrompts = $('\
                <div class="toast toastCustom messengerToast hide" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="10000">\
                        <div class="toast-header tHeaderCustom">\
                            '+ e.notifIcon + '\
                                <strong class="me-auto">'+ e.notifTitle + '</strong>\
                                <small>Just now</small>\
                                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>\
                        </div>\
                        <div class="toast-body tBodyCustom">\
                            <img class="tb-image-icon" src="'+ e.notifUserImage + '">\
                            '+ e.message + '\
                        </div>\
                    </div>\
                ').appendTo(toastContainer);
        $(toastPrompts[0]).toast('show');
    }

    /* -------------------------------------------------------------------------- */
    /*                           Notification in navbar                           */
    /* -------------------------------------------------------------------------- */
    var npage = 1;

    function load_Notif(npage) {
        var notification_container = $('#notification_container');
        var user_notification = $('.user_notification');
        var alert_dot_inbell = user_notification.find('.alert_dot_inbell');
        $.ajax({
            type: "get",
            url: window.thisUrl+"/ajax/notification/get?page="+npage,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            beforeSend: function () {
                notification_container.html('\
                <div class="d-flex justify-content-center mdi_loading_icon">\
                    <span style="font-size: 1.8rem;">\
                        <i class="mdi mdi-loading mdi-spin"></i>\
                    </span>\
                </div>\
                ');

            },
            success: function (response) {
                var res = response;
                console.log(res);
                notificationTemplate(res);

                if (res.unreadNotification > 0) {
                        alert_dot_inbell.remove();
                        user_notification.append('<small class="alert_dot_inbell">\
                        <span class="position-absolute translate-middle bg-danger border border-light rounded-circle" style="top: 10px; left: 5px;">\
                            <span class="visually-hidden">New Notification</span>\
                        </span>\
                    </small>');
                }
            },
            complete: function () {
                notification_container.find('.mdi_loading_icon').remove();
            }
        });
    }
    $(document).on('click','.user_notification', function () {
        load_Notif(npage);
    });
    /* Load on load */
    function onLoadNotif() {

        var user_notification = $('.user_notification');
        var alert_dot_inbell = user_notification.find('.alert_dot_inbell');

        $.ajax({
            type: "get",
            url: window.thisUrl+"/ajax/notification/get?page=1",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },

            success: function (response) {
                var res = response;

                if (res.unreadNotification > 0) {
                    alert_dot_inbell.remove();
                    user_notification.append('<small class="alert_dot_inbell">\
                        <span class="position-absolute translate-middle bg-danger border border-light rounded-circle" style="top: 10px; left: 5px;">\
                            <span class="visually-hidden">New Notification</span>\
                        </span>\
                    </small>');
                }
            },
        });
    }

    onLoadNotif();

    /* Notification template */
    function notificationTemplate(res) {
        var notification_container = $('#notification_container');
        var notifContent = "";
        var notif = "";
        var sender_details = "";
        var receiver_details = "";
        var sd_image = "";
        var notif_message = "";
        var notifAuthorName = "";
        var notifDate ="";
        var momentDate = "";
        var statusContent = "";
        var changeStatusBackground = "";

        /* Check userNotifications.data length */
        if (res.userNotifications.data.length < 1) {
            notification_container.html('\
            <div class="d-flex justify-content-center no_notif">\
                <span>\
                    No new notification.\
                </span>\
            </div>\
            ');

            return false;
        }

        notification_container.find('.no_notif').remove();

        notifContent = "";
        $.each(res.userNotifications.data, function (nI, nVal) {
            /* Set variables */
            notif = nVal;
            sender_details = nVal.notification_author;
            receiver_details = nVal.notification_receiver;

            /* Set image value */
            sd_image = window.urlAssets+ '/my_custom_symlink_1/user.png';

            if (sender_details.profile_image != null) {
                sd_image = window.urlAssets+ '/'+sender_details.profile_image;
            }

            /* Set notification from name */
            notifAuthorName = 'Guest';
            if (sender_details.first_name != null || sender_details.last_name != null) {
                notifAuthorName = '<span class="userNameLead">'+sender_details.first_name + ' ' +sender_details.last_name+'</span>';
            }
            /* Comment type */
            notif_message = "";
            switch (notif.type) {
                case 'react':
                    notif_message = notifAuthorName +' <span class="ff-primary-light fs-text">reacted to your post</span>';
                break;

                case 'post':
                    notif_message = notifAuthorName +' <span class="ff-primary-light fs-text">published a post</span>';
                break;

                case 'comment':
                    notif_message = notifAuthorName +' <span class="ff-primary-light fs-text">commented to your post</span>';
                break;

                default:
                break;
            }

            /* Convert date to local */
            notifDate = "";
            momentDate = "";

            momentDate = moment(notif.created_at);
            week_name = momentDate.day();
            week_name = weekNameToString(week_name);
            notifDate = week_name + ', '+momentDate.local().format("MMMM DD YYYY - hh:mm A");

            /* Check if already read */
            statusContent = '';
            changeStatusBackground = '';
            if (notif.status == 0) {
                statusContent = '\
                <span class="status-unread-badge position-absolute translate-middle badge rounded-pill bg-danger">\
                    New!\
                    <span class="visually-hidden">unread messages</span>\
                </span>';
                changeStatusBackground = 'statusUnread';
            }

            notifTemplateContent(notification_container,sd_image,notif_message,notifDate,statusContent,notif,changeStatusBackground);

        });

        notification_container.find('.notif-divider').last().remove();



    }

    function notifTemplateContent(notification_container,sd_image,notif_message,notifDate,statusContent,notif,changeStatusBackground) {

        var new_pic = window.urlAssets+ '/my_custom_symlink_1/user.png';
        sd_image = (ImageNotFound(sd_image) == false) ? new_pic :  sd_image;

        notifContent = '\
        <div class="onClickgotoNotif '+changeStatusBackground+'" data-notification_uuid="'+notif.notification_uuid+'" data-type="'+notif.type+'">\
            <div class="d-flex flex-row w-100 px-3 py-2 ">\
                <div class="img-notif-user">\
                    <img class="img-fluid" src="'+sd_image+'" alt="">\
                </div>\
                <div class="d-flex flex-column">\
                    <div class="ms-2 notif-textcontent position-relative">\
                        '+notif_message+'\
                        '+statusContent+'\
                    </div>\
                    <div class="ms-2 notif-date">\
                        <small>\
                            '+notifDate+'\
                        </small>\
                    </div>\
                </div>\
            </div>\
        </div>\
        <div class="notif-divider"></div>\
        ';

        notification_container.append(notifContent);
    }

    /* Check if image exist */
    function ImageNotFound(sd_image) {

        var http = new XMLHttpRequest();
        http.open('HEAD', sd_image, false);
        http.send();
        return http.status != 404;
    }

    /* Get week text */
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

    /* On click on notification */
    $(document).on('click','.onClickgotoNotif', function (e) {
        /* On click post notification uuid and type */
        var notification_uuid = $(this).attr('data-notification_uuid');
        var type = $(this).attr('data-type');

        /* Validate input */
        if (notification_uuid.length < 1 || type.length < 1) {
            /* Throw prompt message */
            alert('Error');
            e.preventDefault();
            return false;
        }

        var fd = new FormData();
        fd.append('notification_uuid',notification_uuid);
        fd.append('type',type);

        $.ajax({
            type: "post",
            url: window.thisUrl+"/ajax/notification/view",
            data: fd,
            processData: false,
            contentType: false,
            dataType: 'json',
            enctype: 'application/x-www-form-urlencoded',
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                var res = response;
                console.log(res);

                if (res.status == 'success') {
                    window.location = res.redirectUrl +'?post_id='+ res.toPost;
                }
            }
        });
    });

    /* -------------------------------------------------------------------------- */
    /*                           Alert Modal animate.css                          */
    /* -------------------------------------------------------------------------- */
    $('.alertModal').on('show.bs.modal', function () {
        $(this).removeClass('animate__bounceOut').addClass('animate__bounceIn');
    });
    $('.alertModal').on('hide.bs.modal', function () {
        $(this).removeClass('animate__bounceIn').addClass('animate__bounceOut');
    });

    /* -------------------------------------------------------------------------- */
    /*                          Details modal animate.css                         */
    /* -------------------------------------------------------------------------- */
    $('.modalDetails').removeClass('fade').addClass('animate__animated animate_faster');

    /* -------------------------------------------------------------------------- */
    /*                                On modal show                               */
    /* -------------------------------------------------------------------------- */
    $('.modalDetails').on('show.bs.modal', function () {
        const thisModal = $(this);
        thisModal.removeClass('animate__slideOutUp').addClass('animate__slideInDown');
    });

    /* -------------------------------------------------------------------------- */
    /*                          On modal icon close click                         */
    /* -------------------------------------------------------------------------- */
    $(document).on('click','.modalDetailsCloseIcon', function () {
        const thisButtonIconModal = $(this).closest('.modalDetails');

        thisButtonIconModal.removeClass('animate__slideInDown').addClass('animate__slideOutUp');
        setTimeout(() => {
            thisButtonIconModal.modal('hide');
        }, 500);
    });

    /* -------------------------------------------------------------------------- */
    /*                         On modal close button click                        */
    /* -------------------------------------------------------------------------- */
    $(document).on('click','.modalDetailsClose', function () {
        const thisButtonCloseModal = $(this).closest('.modalDetails');

        thisButtonCloseModal.removeClass('animate__slideInDown').addClass('animate__slideOutUp');
        setTimeout(() => {
            thisButtonCloseModal.modal('hide');
        }, 500);
    });

});
