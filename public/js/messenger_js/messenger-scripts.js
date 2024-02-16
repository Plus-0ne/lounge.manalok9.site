$(document).ready(function () {

    var myuuid = window.myuuid;
    window.lastChatdate = '0000-00-00 00:00:00';
    window.last_message_at = '0000-00-00 00:00:00';



    /* Toggle button */
    $(document).on('click', '.m-menu-icon', function () {
        $('.m-sidebar-conversation').toggleClass('showthis-sidebar');
        $('.conversation-section').toggleClass('showthis-content');
    });

    /* Get conversation by convo uuid */
    function ConvoContainerTemp(res, myuuid, room_uuid) {

        $('.conversation-section').empty();

        var conv_textBody = $('.conversation-textbody');
        var messageByusers = "";
        var ChatDetails = res.ChatDetails;

        var chatWName;
        var countMessage = 0;

        if (res.message != 'null') {
            $.each(res.convo.data, function (cKey, cValue) {
                var messageDetails = cValue;
                var sender_details = cValue.sender_details;

                var messagePos = 'flex-row';
                var borderRad = 'borer-radius-r';
                var triaPos = 'icon-triangle-pos';
                var imagePos = 'ms-3';
                var prof_image = window.assetUrl + 'img/user/user.png';
                var message = messageDetails.message;
                var userName = 'Guest';

                /* Set room uuid */
                room_uuid = cValue.room_uuid;

                /* Get last message */
                countMessage++;

                if (countMessage == 1) {
                    window.lastChatdate = cValue.created_at;
                }

                /* Message position */
                if (sender_details.uuid != myuuid) {
                    messagePos = 'flex-row-reverse';
                    borderRad = 'borer-radius-l';
                    triaPos = 'icon-triangle-pos-reverse';
                    imagePos = 'me-3';
                }

                /* Message profile image */
                if (sender_details.profile_image != null) {
                    prof_image = window.assetUrl + sender_details.profile_image;
                }

                /* Username */
                if (sender_details.first_name != null || sender_details.last_name != null) {
                    userName = sender_details.first_name + ' ' + sender_details.last_name;
                }

                message = _.escape(message);

                messageByusers += '\
                <div class="m-message-container d-flex '+ messagePos + ' justify-content-end">\
                    <div class="m-message-body '+ borderRad + '">\
                        <div class="'+ triaPos + '">\
                            <i class="mdi mdi-triangle"></i>\
                        </div>\
                        <div class="m-content-message mb-1">\
                            '+ userName + '\
                        </div>\
                        <small>\
                        '+ message + '\
                        </small>\
                    </div>\
                    <div class="m-message-img '+ imagePos + '">\
                        <img src="'+ prof_image + '" alt="">\
                    </div>\
                </div>\
                ';
            });
        }


        if (ChatDetails.first_name == 'null' || ChatDetails.last_name == 'null') {
            chatWName = 'Guest';
        }
        else {
            chatWName = ChatDetails.first_name + ' ' + ChatDetails.last_name;
        }

        $('.conversation-section').html('\
                <div id="chatWithuser" class="chatWithuser-class convo-content d-flex flex-column" data-useruuid="'+ ChatDetails.uuid + '" data-room_uuid="' + room_uuid + '">\
                    <div class="convo-header d-flex flex-row">\
                        <div class="convo-with-name">\
                            '+ chatWName + '\
                        </div>\
                        <div class="ms-3">\
                            <small class="m-user-active">\
                                Online <i class="mdi mdi-circle"></i>\
                            </small>\
                        </div>\
                    </div>\
                    <div class="convo-body d-flex flex-column-reverse py-3 px-xl-5 px-3">\
                        '+ messageByusers + '\
                    </div>\
                    <div class="convo-footer d-flex flex-row">\
                        <div class="d-flex flex-column me-3">\
                            <div class="convoOptions">\
                                <i class="mdi mdi-image"></i>\
                            </div>\
                            <div class="convoOptions">\
                                <i class="mdi mdi-link-variant"></i>\
                            </div>\
                        </div>\
                        <div class="w-100">\
                            <textarea id="message_txt" class="chatEmojiTextarea"></textarea>\
                            <div id="EmojiContainer1">\
                            </div>\
                        </div>\
                        <div class="d-flex flex-column text-center justify-content-center ms-3">\
                            <div class="send-button-chat">\
                                <i class="mdi mdi-send"></i>\
                            </div>\
                        </div>\
                    </div>\
                </div>\
        ');

        /* Load emoji */
        $(".chatEmojiTextarea").emojioneArea();
        if ($('.m-sidebar-conversation').hasClass('showthis-sidebar')) {
            $('.m-sidebar-conversation').toggleClass('showthis-sidebar');
        }

        if ($('.conversation-section').hasClass('showthis-content')) {
            $('.conversation-section').toggleClass('showthis-content');
        }


    }


    $(document).on('click', '.convo-btn', function (e) {
        e.preventDefault();

        var room_uuid = $(this).attr('data-convouuid');
        var sender_uuid = $(this).attr('data-useruuid');

        $.ajax({
            type: "post",
            url: "/ajax/get-conversation",
            data: {
                room_uuid: room_uuid,
                sender_uuid: sender_uuid
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                console.log(response);

                var res = response;

                var convsection = $('.conversation-section');

                convsection.empty();

                ConvoContainerTemp(res, myuuid);

            }
        });
    });


    /* Send message */
    function UpdateMyChat() {
        var room_uuids = $('#chatWithuser').attr('data-room_uuid');

        $.ajax({
            type: "post",
            url: "/ajax/update_messengerChatContent",
            data: {
                room_uuid: room_uuids,
                created_at: window.lastChatdate
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                var res = response;
                var getLatestChats = res.getLatestChats;
                var sender_details = res.getLatestChats.sender_details;

                var messagePos = 'flex-row';
                var borderRad = 'borer-radius-r';
                var triaPos = 'icon-triangle-pos';
                var imagePos = 'ms-3';
                var prof_image = window.assetUrl + 'img/user/user.png';
                var userName = 'Guest';


                window.lastChatdate = res.getlastChatDateTime;

                console.log(response);

                $.each(getLatestChats, function (cKey, cValue) {

                    /* Message position */
                    if (cValue.sender_details.uuid != myuuid) {
                        messagePos = 'flex-row-reverse';
                        borderRad = 'borer-radius-l';
                        triaPos = 'icon-triangle-pos-reverse';
                        imagePos = 'me-3';
                    }

                    /* Message profile image */
                    if (cValue.sender_details.profile_image != null) {
                        prof_image = window.assetUrl + cValue.sender_details.profile_image;
                    }

                    /* Username */
                    if (cValue.sender_details.first_name != null || cValue.sender_details.last_name != null) {
                        userName = cValue.sender_details.first_name + ' ' + cValue.sender_details.last_name;
                    }

                    message = _.escape(cValue.message);

                    $('.convo-body').prepend('\
                        <div class="m-message-container d-flex '+ messagePos + ' justify-content-end">\
                            <div class="m-message-body '+ borderRad + '">\
                                <div class="'+ triaPos + '">\
                                    <i class="mdi mdi-triangle"></i>\
                                </div>\
                                <div class="m-content-message mb-1">\
                                    '+ userName + '\
                                </div>\
                                <small>\
                                '+ message + '\
                                </small>\
                            </div>\
                            <div class="m-message-img '+ imagePos + '">\
                                <img src="'+ prof_image + '" alt="">\
                            </div>\
                        </div>\
                        ');
                });
            }
        });
    }
    $(document).on('click', '.send-button-chat > i', function () {
        var sendto_uuid = $('#chatWithuser').attr('data-useruuid');
        var message_txt = $('#message_txt');

        if (message_txt.val().length > 0) {
            $.ajax({
                type: "post",
                url: "/ajax/send-message",
                data: {
                    sendto_uuid: sendto_uuid,
                    message_txt: message_txt.val()
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    console.log(response);
                    UpdateMyChat();
                    $(".emojionearea-editor").html("");
                    message_txt.val("");
                    // $('.m-convo-list').empty();
                    updateSidebarList();
                }
            });
        }

    });

    /* Chatbox update */
    function MessengerUpdate(e) {
        if (e.type == 'updateMessages') {

            /* Update messages in chat body get last chat*/

            /* Room uuid for both users */
            var room_uuids = $('#chatWithuser').attr('data-room_uuid');

            /* If room uuid is null return false */
            if (room_uuids == null) {
                return false;
            }

            /* Ajax request get latest chat */
            $.ajax({
                type: "post",
                url: "/ajax/update_messengerChatContent",
                data: {
                    room_uuid: room_uuids,
                    created_at: window.lastChatdate
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    var res = response;
                    var getLatestChats = res.getLatestChats;
                    var sender_details = res.getLatestChats.sender_details;

                    var messagePos = 'flex-row';
                    var borderRad = 'borer-radius-r';
                    var triaPos = 'icon-triangle-pos';
                    var imagePos = 'ms-3';
                    var prof_image = window.assetUrl + 'img/user/user.png';
                    var userName = 'Guest';


                    window.lastChatdate = res.getlastChatDateTime;

                    console.log(response);

                    $.each(getLatestChats, function (cKey, cValue) {

                        /* Message position */
                        if (cValue.sender_details.uuid != myuuid) {
                            messagePos = 'flex-row-reverse';
                            borderRad = 'borer-radius-l';
                            triaPos = 'icon-triangle-pos-reverse';
                            imagePos = 'me-3';
                        }

                        /* Message profile image */
                        if (cValue.sender_details.profile_image != null) {
                            prof_image = window.assetUrl + cValue.sender_details.profile_image;
                        }

                        /* Username */
                        if (cValue.sender_details.first_name != null || cValue.sender_details.last_name != null) {
                            userName = cValue.sender_details.first_name + ' ' + cValue.sender_details.last_name;
                        }

                        message = _.escape(cValue.message);

                        $('.convo-body').prepend('\
                        <div class="m-message-container d-flex '+ messagePos + ' justify-content-end">\
                            <div class="m-message-body '+ borderRad + '">\
                                <div class="'+ triaPos + '">\
                                    <i class="mdi mdi-triangle"></i>\
                                </div>\
                                <div class="m-content-message mb-1">\
                                    '+ userName + '\
                                </div>\
                                <small>\
                                '+ message + '\
                                </small>\
                            </div>\
                            <div class="m-message-img '+ imagePos + '">\
                                <img src="'+ prof_image + '" alt="">\
                            </div>\
                        </div>\
                        ');

                        // audioNotif.play();

                    });
                }
            });
        }
    }

    /* Broadcast to users update chat box*/
    Echo.private("messenger.update." + myuuid).listen(
        "MessengerUpdate",
        (e) => {
            MessengerUpdate(e);
        }
    );

    function updateSidebarList() {
        var last_message_at = window.last_message_at;

        $.ajax({
            type: "post",
            url: "/ajax/get_last_message_at",
            data: {
                last_message_at: last_message_at
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                console.log(response);

                var res = response;

                var contactlist = $('.m-convo-list');
                var contactlist_children = contactlist.children();
                var sidebar_content = res.all_follows;

                $.each(sidebar_content, function (key, value) {
                    $(contactlist_children).each(function (i, el) {
                        var lastMessageDetails = value.last_message;

                        var lastMessage = lastMessageDetails.message;
                        var lastMessageFromName = 'Guest';

                        if (el.id == 'roomuuid_' + value.room_uuid) {
                            $('#' + el.id + '').insertBefore(contactlist_children.first());


                            /* ================== Find lastMessagetxt ================== */
                            /* Limit message to 25 */
                            if (lastMessage.length > 25) {
                                lastMessage = lastMessage.substring(0, 25) + ' ...';
                            }

                            /* Last message name */
                            if (lastMessageDetails.user_details.first_name != null || lastMessageDetails.user_details.last_name != null) {
                                lastMessageFromName = lastMessageDetails.user_details.first_name;
                            }

                            $('#' + el.id + '').find('.lastMessagetxt').html('\
                            '+ lastMessageFromName + ' : ' + lastMessage + '\
                            ');

                            if (lastMessageDetails.sender_uuid != myuuid) {
                                audioNotif.play();
                            }

                        }
                    });
                });

            }
        });
    }
    /* Broadcast to users update messenger list */
    Echo.private("messenger.update.sidebarlist." + myuuid).listen(
        "MessengerUpdateList",
        (e) => {
            /* Todo : Update chat list */
            /* Move element to top when new message receive */
            /* Update last message displayed */

            /* */
            updateSidebarList();
        }
    );


    /* -------------------------------------------------------------------------- */
    /*                          New conversation function                         */
    /* -------------------------------------------------------------------------- */

    /* -------------------------------------------------------------------------- */
    /*                              Get all followers                             */
    /* -------------------------------------------------------------------------- */
    function getAllFollows() {
        $.ajax({
            type: "get",
            url: window.baseUrl + "/ajax/all-follows",
            success: function (response) {
                var res = response;
                console.log(res);
                if (res.status == 'success') {
                    /* If followers found get follower and fill sidebar */
                    followerRows(res);
                }

                /* Conversation container default content */
                $('.conversation-section').html('\
                <div class="w-100 d-flex flex-column text-center mt-5">\
                    <div class="w-100"><h3>'+ res.message + '</h3></div>\
                    <div class="w-100"><p> Connect with everyone </p></div>\
                    <div class="big-m-icon w-100">\
                        <i class="mdi mdi-chat"></i>\
                    </div>\
                </div>\
                ');
            }
        });
    }

    /* -------------------------------------------------------------------------- */
    /*                  Sidebar content show all follower or room                 */
    /* -------------------------------------------------------------------------- */
    function followerRows(res) {
        var all_follows = res.all_follows;
        var aRow = null;
        /* Set sidebar last message at */
        window.last_message_at = res.sidebar_lastmessage_at;

        $.each(all_follows.data, function (f_key, f_value) {

            var senderData = f_value.my_followers;
            var nameee;
            var profimage;
            var useruuid = senderData.uuid;

            var lastMessage = 'lastMessageDetails.message';
            var lastMessageFromName = 'Guest';

            if (senderData.uuid == myuuid) {
                useruuid = senderData.uuid;
            }

            /* User name */
            if (senderData.first_name == null || senderData.last_name == null) {
                nameee = 'Guest';
            }
            else {
                nameee = senderData.first_name + ' ' + senderData.last_name;
            }

            /* User profile image */
            if (senderData.profile_image == null) {
                profimage = window.assetUrl + 'img/user/user.png';
            }
            else {
                profimage = window.assetUrl + '/' + senderData.profile_image;
            }

            /* Limit message to 25 */
            if (lastMessage.length > 25) {
                lastMessage = lastMessage.substring(0, 25) + ' ...';
            }

            /* Last message name */
            // if (lastMessageDetails.user_details.first_name != null || lastMessageDetails.user_details.last_name != null) {
            //     lastMessageFromName = 'lastMessageDetails.user_details.first_name';
            // }
            aRow = "";
            aRow = '\
            <a id="roomuuid_'+ f_value.room_uuid + '" href="#" class="list-group-item list-group-item-action py-2 lh-tight convo-btn" aria-current="true" data-useruuid="' + useruuid + '" data-convouuid="' + f_value.room_uuid + '">\
                <div class="d-flex w-100 align-items-center justify-content-between mt-1">\
                    <div>\
                        <img class="messenger-user-icon" src="'+ profimage + '" alt="' + nameee + '">\
                        <label class="m-fullname mb-1">\
                            ' + nameee + '\
                        </label>\
                    </div>\
                    <small class="m-user-status m-user-active">\
                        <i class="mdi mdi-circle"></i>\
                    </small>\
                </div>\
                <div class="lastmessage-section w-100 mb-2 mt-2 text-start">\
                    <small class="lastMessagetxt">\
                        '+ lastMessageFromName + ' : ' + lastMessage + '\
                    </small>\
                </div>\
            </a>';
            $('.m-convo-list').append(aRow);
        });

    }

    /* -------------------------------------------------------------------------- */
    /*                    Initiate getAllFollows() on page load                   */
    /* -------------------------------------------------------------------------- */
    getAllFollows();

    /* TODO : Message conversation */
    /* TODO : Group messaging */
});
