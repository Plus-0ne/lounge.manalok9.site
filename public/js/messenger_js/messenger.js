$(document).ready(function () {
    /* -------------------------------------------------------------------------- */
    /*                                Set variables                               */
    /* -------------------------------------------------------------------------- */
    var mpage = 1;
    let ruValue = window.room_uuid;
    let user_to_chat = window.user_to_chat;
    /* -------------------------------------------------------------------------- */
    /*                         Toggle button show sidebar                         */
    /* -------------------------------------------------------------------------- */
    $(document).on('click', '.m-menu-icon', function () {
        $('.m-sidebar-conversation').toggleClass('showthis-sidebar');
        $('.conversation-section').toggleClass('showthis-content');
    });

    /* -------------------------------------------------------------------------- */
    /*                              Get all followers                             */
    /* -------------------------------------------------------------------------- */
    function getAllContacts() {
        $.ajax({
            type: "get",
            url: window.baseUrl + "/ajax/all-follows",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                var res = response;


                /* If res.status is success generate sidebar content filled with contacts */
                if (res.status == 'success') {
                    followerRows(res);

                    console.log(res);

                }

                /* If ruValue (room uuid) is null generate default content */
                if (ruValue === null || user_to_chat === null) {
                    defaultConversationContent();

                    return false;
                }

                /* If ruValue (room uuid) is not null get user conversation */
                if (ruValue.length > 0 && user_to_chat.length > 0) {
                    // alert('Get user conversation');
                    let room_uuid = ruValue;
                    let sender_uuid = user_to_chat;
                    userConversation(room_uuid, sender_uuid, 1);
                }


            }
        });
    }

    /* -------------------------------------------------------------------------- */
    /*                     Onload initialize get all followers                    */
    /* -------------------------------------------------------------------------- */
    getAllContacts();

    /* -------------------------------------------------------------------------- */
    /*                        Default conversation content                        */
    /* -------------------------------------------------------------------------- */
    function defaultConversationContent() {
        var cs = $('.conversation-section').html('\
        <div class="w-100 d-flex flex-column text-center mt-5">\
            <div class="w-100"><h3> Start conversation </h3></div>\
            <div class="w-100 fs-text"><p> Connect with everyone </p></div>\
            <div class="big-m-icon w-100">\
                <i class="mdi mdi-chat"></i>\
            </div>\
        </div>\
        ');
        return cs;
    }

    /* -------------------------------------------------------------------------- */
    /*                  Sidebar content show all follower or room                 */
    /* -------------------------------------------------------------------------- */
    function followerRows(res) {
        let all_follows = res.all_follows;
        let aRow = null;

        $.each(all_follows.data, function (f_key, f_value) {

            let senderData = f_value.my_followers;
            let nameee;
            let profimage;
            let lastMessage = f_value.last_message;
            let lastMessageContent;

            /* Show latest message in sidebar */
            if (lastMessage != undefined || lastMessage != null || lastMessage.length > 0) {

                lastMessageContent = lastMessage.message;
                /* Limit message to 25 */
                if (lastMessageContent.length > 20) {
                    lastMessageContent = lastMessageContent.substring(0, 20) + ' ...';
                }
                // lastMessageContent = _.escape(lastMessageContent);
            } else {
                lastMessageContent = 'Start conversation.';
            }

            let lastMsgName;

            if (lastMessage.user_details.uuid == window.myuuid) {
                lastMsgName = 'You';

            } else {
                lastMsgName = lastMessage.user_details.first_name;
            }


            lastMessageContent = lastMsgName + ' : ' + lastMessageContent;

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

            /* Sidebar link */
            aRow = $('<a>', {
                class: "list-group-item list-group-item-action py-2 lh-tight sidebar-content-prof fs-text"
            });

            let headerContent = $('<div>', { class: "d-flex flex-row w-100 align-items-center justify-content-between mt-1" }).appendTo(aRow);

            /* Image and name section */
            headerContent
                .append(
                    $('<div>', {
                        class: "d-flex flex-row justify-content-start align-items-center"
                    })
                        .append(
                            $('<div>', {
                                class: "mess-image-container"
                            })
                                .append(
                                    $('<img>', {
                                        class: "messenger-user-icon", src: profimage
                                    })
                                )
                        )
                        .append(
                            $('<div>', {
                                class: "d-flex flex-column justify-content-top align-items-top"
                            })
                                .append(
                                    $('<div>', {
                                        class: "m-fullname ms-2", text: nameee
                                    })
                                )
                                .append(
                                    $('<small>', {
                                        class: "ms-2 lastMessagetxt"
                                    })
                                        .append(
                                            $('<strong>', {
                                                text: lastMessageContent
                                            })
                                        )
                                )
                        )
                );

            /* Status section */
            headerContent
                /* TODO : Show user is active or offline */
                .append(
                    $('<small>', {
                        class: "m-user-status m-user-active"
                    })
                        .append(
                            $('<i>', {
                                class: "mdi mdi-circle"
                            })
                        )
                );

            aRow.on('click', function () {

                /* Set variables */
                let room_uuid = f_value.room_uuid;
                let sender_uuid = senderData.uuid;

                /* Change url without reload */
                window.history.pushState(null, null, window.baseUrl + '/messenger?ru=' + room_uuid);

                /* Set ruValue to current uuid */
                ruValue = room_uuid;

                /* Generate user conversation */
                userConversation(room_uuid, sender_uuid, mpage);
            });

            $(aRow).appendTo('.m-convo-list');
        });

    }

    /* -------------------------------------------------------------------------- */
    /*                      Search user to start conversation                     */
    /* -------------------------------------------------------------------------- */
    $('#search_user_convers_btn').on('click', function (e) {

        /* Prevent default event */
        e.preventDefault();

        /* This button */
        var thisBtn = $(this);
        var keyword = $('#search_user_convers');

        /* Disable this button */
        thisBtn.attr('disabled', true);

        /* Validate input in search */
        if (keyword.val().length < 1) {
            thisBtn.attr('disabled', false);
            return false;
        }

        /* Create new form data */
        var fd = new FormData();

        fd.append('keyword', keyword.val());

        /* Ajax get all user to start new conversation */
        $.ajax({
            type: "post",
            url: window.thisUrl + '/ajax/messenger/search/users',
            data: fd,
            processData: false,
            contentType: false,
            enctype: "application/x-www-form-urlencoded",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                var res = response;


                if (res.status == 'success') {
                    /* Show modal searchUserModalResult */
                    var mdl = $('#searchUserModalResult');
                    mdl.modal('toggle');

                    /* Search modal contents */
                    searchModalContents(res);
                }
            },
            complete: function () {
                thisBtn.attr('disabled', false);
            }
        });


    });

    /* -------------------------------------------------------------------------- */
    /*                            Search modal contents                           */
    /* -------------------------------------------------------------------------- */
    function searchModalContents(res) {
        var results_container = $('.s-users-results');
        var users = res.users.data;

        /* Create not results found in modal body */
        if (res.users.total < 1) {
            results_container.append(
                $('<div>', {
                    class: 'd-flex flex-row justify-content-center'
                }).append(
                    $('<h6>', {
                        text: '"' + res.search_keyword + '" not found'
                    })
                )
            );

            var sdada = $('.keyword-status-result');

            sdada.html('Search keyword "' + res.search_keyword + '" not found');

            return false;
        }

        var profile_image;
        var completeName;
        var cRes = 0;

        $.each(users, function (ui, uval) {
            cRes++;

            /* Profile image */
            profile_image = window.assetUrl + 'img/user/user.png';
            completeName = 'Guest';

            if (uval.profile_image != null) {
                profile_image = window.assetUrl + '/' + uval.profile_image;
            }

            /* Complete name */
            if (uval.first_name != null || uval.last_name != null) {
                completeName = uval.first_name + ' ' + uval.last_name;
            }

            results_container.append(

                $('<div>', {
                    class: 'd-flex flex-column'
                }).append(
                    $('<div>', {
                        class: 'card d-flex flex-row justify-content-between align-items-center py-2 px-2'
                    }).append(
                        $('<div>', {
                            class: 'd-flex flex-row align-items-center'
                        }).append($('<div>', {
                            class: 'mdl-img-container'
                        }).append($('<img>', {
                            src: profile_image,
                            alt: ''
                        }))
                        ).append($('<div>', {
                            class: 'mdl-name-container ms-2 fs-text',
                            text: completeName
                        })
                        )
                    ).append(
                        $('<div>', {
                            class: 'mdl-action-container'
                        }).append($('<button>', {
                            class: 'btn btn-primary btn-sm',
                            type: 'button',
                            text: 'Create conversation'
                        }).on('click', function () {
                            /* Show modal searchUserModalResult */
                            var mdl = $('#searchUserModalResult');
                            mdl.modal('toggle');

                            /* If user follower exist show conversation else create new conversation and show chat area */

                            if (uval.my_followers.length > 0) {
                                var room_uuid = uval.my_followers[0].room_uuid;
                                var sender_uuid = uval.uuid;


                                window.history.pushState(null, null, window.baseUrl + '/messenger?ru=' + room_uuid);

                                ruValue = room_uuid;

                                userConversation(room_uuid, sender_uuid, 1);
                            } else {


                                let user_uuid = uval.uuid;

                                /* Get user details */
                                userNotInteractedDetails(user_uuid);
                            }
                        })
                        )
                    )
                )
            );
        });

        var sdada = $('.keyword-status-result');
        var redd = 'record';
        if (cRes > 1) {
            redd = 'records'
        }
        sdada.html('Search keyword "' + res.search_keyword + '", found ' + cRes + ' ' + redd + '.');



    }

    /* -------------------------------------------------------------------------- */
    /*                       Get user not interacted details                      */
    /* -------------------------------------------------------------------------- */
    function userNotInteractedDetails(user_uuid) {
        /* Create new form data */
        const fd = new FormData();

        /* Apped values to form data */
        fd.append('user_uuid', user_uuid);

        /* Ajax send request */
        $.ajax({
            type: "post",
            url: window.baseUrl + '/ajax/messenger/user/get',
            data: fd,
            processData: false,
            contentType: false,
            enctype: "application/x-www-form-urlencoded",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                const res = response;

                messenger_chat_stranger(res);
            }
        });

    }
    /* -------------------------------------------------------------------------- */
    /*                    Modal searchUserModalResult on close                    */
    /* -------------------------------------------------------------------------- */
    $('#searchUserModalResult').on('hidden.bs.modal', function () {
        /* This button */
        var thisBtn = $('#search_user_convers_btn');
        var results_container = $('.s-users-results');

        /* Enable this button */
        thisBtn.attr('disabled', false);
        results_container.html("");
    });

    /* -------------------------------------------------------------------------- */
    /*                            Get user conversation                           */
    /* -------------------------------------------------------------------------- */
    function userConversation(room_uuid, sender_uuid, mpage) {

        /* Ajax request get user details and conversations */
        var fd = new FormData();
        fd.append('room_uuid', room_uuid);
        fd.append('sender_uuid', sender_uuid);

        $.ajax({
            type: "post",
            url: window.baseUrl + '/ajax/messenger/conversation/get?page=' + mpage,
            data: fd,
            processData: false,
            contentType: false,
            enctype: "application/x-www-form-urlencoded",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                var res = response;



                if (res.status == 'success') {

                    /* Empty Conversation section */
                    var conversation_section = $('.conversation-section');
                    conversation_section.html("");

                    /* Generate conversation header and textarea */
                    conversastionHeaderFooter(res);
                }
            }
        });
    }

    function conversastionHeaderFooter(res) {

        var cs = $('.conversation-section');
        let textArea = $('<input>', { id: 'message_txt', class: 'chatEmojiTextarea w-auto' });
        let txtAre$div = $('<div>', { id: 'EmojiContainer1' });

        var user_details = res.ChatDetails;

        /* Complete name */
        var complete_name = 'Guest';

        /* TODO : replace user icon with user image */
        var userIcon = $('<span>', { class: 'mdi mdi-account me-2' });

        if (user_details.first_name != null || user_details.last_name != null) {
            complete_name = user_details.first_name + ' ' + user_details.last_name;
        }


        /* Pagination */
        var paginateBtn = '';
        if (res.convo != null) {

            if (res.convo.next_page_url != null) {
                paginateBtn = '\
                <div class="d-flex flex-row justify-content-center align-items-center">\
                <button class="btn btn-primary btn-sm show_older_messages" data-room="'+ res.convo.data[0].room_uuid + '"> Show older messages </button>\
                </div>\
                ';
            }

        }

        /* Messages */
        var messages = conversationSectionUserMessages(res, paginateBtn);

        /* Conversation section content */
        cs.append(
            $('<div>', {
                class: 'd-flex flex-column convo-content'
            }).append(
                $('<div>', {
                    class: 'convo-header d-flex flex-row'
                }).append(
                    $('<div>', {
                        class: 'convo-with-name d-flex flex-row justify-content-start align-items-center fs-text',
                        html: complete_name
                    }).prepend(
                        userIcon
                    )
                ).append(
                    /* TODO : Indicate if user is active or offline */
                    $('<div>', {
                        class: 'ms-3'
                    }).append(
                        $('<small>', {
                            class: 'm-user-active'
                        }).append(
                            $('<i>', {
                                class: 'mdi mdi-circle'
                            })
                        )
                    )
                )
            ).append(
                $('<div>', {
                    id: 'convo-body-id',
                    class: 'convo-body d-flex flex-column-reverse py-3 px-xl-5 px-3 messageroom-' + ruValue
                }).html(
                    messages
                )
            ).append(
                $('<div>', {
                    class: 'convo-footer d-flex flex-row justify-content-center align-items-center'
                }).append(
                    $('<div>', {
                        class: 'd-flex flex-row me-3'
                    }).append(
                        $('<div>', {
                            class: 'convoOptions'
                        }).append(
                            $('<span>', {
                                class: 'mdi mdi-plus-circle'
                            })
                        )
                    )
                ).append(
                    $('<div>', {
                        class: 'w-100'
                    }).append(
                        textArea
                    ).append(
                        txtAre$div
                    )
                ).append(
                    $('<div>', {
                        class: 'd-flex flex-column text-center justify-content-center ms-3'
                    }).append(
                        $('<div>').append(
                            $('<button>', {
                                class: 'btn btn-primary'
                            }).append(
                                $('<span>', {
                                    class: 'mdi mdi-send'
                                })
                            ).on('click', function (e) {
                                /* Prevent default event */
                                e.preventDefault();
                                let thisBtn = $(this);

                                /* Send message to user */
                                let receiver_uuid = user_details.uuid;
                                let message_txt = textArea;
                                sendMessageToUser(receiver_uuid, message_txt, thisBtn);


                            })
                        )
                    )
                )
            )
        );

        /* Initiate emojiarea */
        textArea.emojioneArea();

        if ($('.m-sidebar-conversation').hasClass('showthis-sidebar')) {
            $('.m-sidebar-conversation').toggleClass('showthis-sidebar');
        }

        if ($('.conversation-section').hasClass('showthis-content')) {
            $('.conversation-section').toggleClass('showthis-content');
        }
    }

    /* -------------------------------------------------------------------------- */
    /*                               Message content                              */
    /* -------------------------------------------------------------------------- */
    function conversationSectionUserMessages(res, paginateBtn) {
        var messageByusers = "";
        var chatUser = res.ChatDetails;
        var completeUsername = 'Guest';

        /* Create complete name */
        if (chatUser.first_name != null || chatUser.last_name != null) {
            completeUsername = chatUser.first_name + ' ' + chatUser.last_name;
        }
        /* Check if res.convo exist */
        if (res.convo == null || res.convo == undefined) {
            // messageByusers = '';
            messageByusers = $('<div>', {
                class: 'd-flex flex-column justify-content-center align-items-center'
            });

            messageByusers.append(
                $('<div>', {

                }).append(
                    $('<small>', {
                        class: 'ita-text',
                        text: 'Start conversation with ' + completeUsername
                    })
                )
            );

            return messageByusers;
        }

        /* TODO : Generate all messages */
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

            var str = messageDetails.created_at;
            var date = moment(str);

            var show_ago_time = date.local().fromNow(true) + ' ago';

            var elem = '';

            messageByusers += '\
            <div class="m-message-container d-flex '+ messagePos + ' justify-content-end">\
                <div class="m-message-body '+ borderRad + '">\
                    <div class="m-content-message mb-1 fs-text">\
                        '+ userName + '\
                    </div>\
                    <div class="fs-text text-break">\
                    '+ message + '\
                    </div>\
                    <div class="fs-small mt-1">\
                    '+ show_ago_time + '\
                    </div>\
                </div>\
                <div class="m-message-img '+ imagePos + '">\
                    <img src="'+ prof_image + '" alt="">\
                </div>\
            </div>\
            ';

        });

        messageByusers += paginateBtn;

        return messageByusers;
    }

    /* -------------------------------------------------------------------------- */
    /*                            Send message to user                            */
    /* -------------------------------------------------------------------------- */
    function sendMessageToUser(receiver_uuid, message_txt, thisBtn) {
        let sendto_uuid = receiver_uuid;

        if (message_txt.val().length > 0) {

            thisBtn.attr('disabled', true);

            $.ajax({
                type: "post",
                url: window.baseUrl + '/ajax/send-message',
                data: {
                    sendto_uuid: sendto_uuid,
                    message_txt: message_txt.val()
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    const res = response;



                    /* Update chat section */

                    if (res.status == 'success') {

                        const thisRoom = res.conversation.room_uuid;
                        updateChatMessages(res, thisRoom);

                        updateMessengerSidebar();
                    }

                    $("#message_txt").data("emojioneArea").setText('');
                    message_txt.val("");

                },
                complete: function () {
                    thisBtn.attr('disabled', false);
                }
            });
        }
    }

    /* -------------------------------------------------------------------------- */
    /*               Messenger content if user not interacted before              */
    /* -------------------------------------------------------------------------- */
    function messenger_chat_stranger(res) {

        window.location = window.baseUrl + '/messenger?ru=' + res.ruuid;

        return false;

    }

    /* -------------------------------------------------------------------------- */
    /*                Update message content after message is sent                */
    /* -------------------------------------------------------------------------- */
    function updateChatMessages(res, thisRoom) {
        /* TODO : Update message content get latest chat and append to message body section */
        const cbID = $('#convo-body-id');
        const appendMsg = $('.messageroom-' + thisRoom);

        const messageDetails = res.conversation;
        const sender_details = messageDetails.user_details;

        let messagePos = 'flex-row';
        let borderRad = 'borer-radius-r';
        let triaPos = 'icon-triangle-pos';
        let imagePos = 'ms-3';
        let prof_image = window.assetUrl + 'img/user/user.png';
        let message = messageDetails.message;
        let userName = 'Guest';

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
        let str = messageDetails.created_at;
        let date = moment(str);

        let show_ago_time = date.local().fromNow(true) + ' ago';

        messageByusers = '\
            <div class="m-message-container d-flex '+ messagePos + ' justify-content-end">\
                <div class="m-message-body '+ borderRad + '">\
                    <div class="m-content-message mb-1 fs-text">\
                        '+ userName + '\
                    </div>\
                    <div class="fs-text">\
                    '+ message + '\
                    </div>\
                    <div class="fs-small mt-1">\
                    '+ show_ago_time + '\
                    </div>\
                </div>\
                <div class="m-message-img '+ imagePos + '">\
                    <img src="'+ prof_image + '" alt="">\
                </div>\
            </div>\
            ';

        // cbID.prepend(messageByusers);
        appendMsg.prepend(messageByusers);

    }

    /* -------------------------------------------------------------------------- */
    /*                               Websocket echo                               */
    /* -------------------------------------------------------------------------- */
    Echo.private("messenger.update." + window.myuuid).listen(
        "MessengerUpdate",
        (e) => {

            MessengerUpdate(e);

            updateMessengerSidebar();
        }
    );

    /* -------------------------------------------------------------------------- */
    /*                           Chatbox message update                           */
    /* -------------------------------------------------------------------------- */
    /* Chatbox update */
    function MessengerUpdate(e) {

        if (e.type == 'updateMessages') {
            const fd = new FormData();

            fd.append('conversation_uuid', e.conversationUuid);
            /* Ajax query get message details */
            $.ajax({
                type: "post",
                url: window.baseUrl + '/ajax/messenger/get/message',
                data: fd,
                processData: false,
                contentType: false,
                enctype: "application/x-www-form-urlencoded",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    const res = response;

                    if (res.status == 'success') {
                        const thisRoom = e.room_uuid;
                        updateChatMessages(res, thisRoom);
                    }

                }
            });
        }
    }

    /* -------------------------------------------------------------------------- */
    /*                          Paginate add old message                          */
    /* -------------------------------------------------------------------------- */
    $(document).on('click', '.show_older_messages', function () {

        const room_uuid = $(this).attr('data-room');
        const sender_uuid = window.myuuid;
        mpage++;

        const fd = new FormData();
        fd.append('room_uuid', room_uuid);
        fd.append('sender_uuid', sender_uuid);

        $.ajax({
            type: "post",
            url: window.baseUrl + '/ajax/messenger/conversation/get?page=' + mpage,
            data: fd,
            processData: false,
            contentType: false,
            enctype: "application/x-www-form-urlencoded",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                var res = response;

                if (res.status == 'success') {

                    /* Append old messages */
                    appenOldMessages(res);
                }
            }
        });
    });

    /* -------------------------------------------------------------------------- */
    /*                               Append messages                              */
    /* -------------------------------------------------------------------------- */
    function appenOldMessages(res) {
        var messageByusers = "";
        var chatUser = res.ChatDetails;
        var completeUsername = 'Guest';
        let paginateBtn = '';

        if (res.convo != null) {

            if (res.convo.next_page_url != null) {
                paginateBtn = '\
                <div class="d-flex flex-row justify-content-center align-items-center">\
                <button class="btn btn-primary btn-sm show_older_messages" data-room="'+ res.convo.data[0].room_uuid + '"> Show older messages </button>\
                </div>\
                ';
            }

        }

        /* Create complete name */
        if (chatUser.first_name != null || chatUser.last_name != null) {
            completeUsername = chatUser.first_name + ' ' + chatUser.last_name;
        }
        /* Check if res.convo exist */
        if (res.convo == null || res.convo == undefined) {
            // messageByusers = '';
            messageByusers = $('<div>', {
                class: 'd-flex flex-column justify-content-center align-items-center'
            });

            messageByusers.append(
                $('<div>', {

                }).append(
                    $('<small>', {
                        class: 'ita-text',
                        text: 'Start conversation with ' + completeUsername
                    })
                )
            );

            return messageByusers;
        }

        /* TODO : Generate all messages */
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

            var str = messageDetails.created_at;
            var date = moment(str);

            var show_ago_time = date.local().fromNow(true) + ' ago';

            messageByusers += '\
            <div class="m-message-container d-flex '+ messagePos + ' justify-content-end">\
                <div class="m-message-body '+ borderRad + '">\
                    <div class="m-content-message mb-1 fs-text">\
                        '+ userName + '\
                    </div>\
                    <div class="fs-text">\
                    '+ message + '\
                    </div>\
                    <div class="fs-small mt-1">\
                    '+ show_ago_time + '\
                    </div>\
                </div>\
                <div class="m-message-img '+ imagePos + '">\
                    <img src="'+ prof_image + '" alt="">\
                </div>\
            </div>\
            ';

        });

        $('.show_older_messages').parent().remove();
        messageByusers += paginateBtn;

        $('#convo-body-id').append(messageByusers);
    }

    /* -------------------------------------------------------------------------- */
    /*                          Update messenger sidebar                          */
    /* -------------------------------------------------------------------------- */
    function updateMessengerSidebar() {
        $.ajax({
            type: "get",
            url: window.baseUrl + "/ajax/all-follows",
            success: function (response) {
                var res = response;


                /* If res.status is success generate sidebar content filled with contacts */
                if (res.status == 'success') {

                    $('.m-convo-list').html("");
                    followerRows(res);

                }

            }
        });
    }
});
