$(document).ready(function ()
{
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "500",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    var page = 1;
    $(window).scroll(function() {
        if ($(window).scrollTop() + $(window).height() >= $(document).height()) {
            page++;
            loadMoreData(page);
        }
    });
    var view_trade_button =
        '<div class="col-12 px-3 py-2 text-end">\
            <button class="btn btn-primary btn-view_trade">View Trade</button>\
        </div>';
    var cancel_request_button =
        '<div class="col-6 text-end">\
            <label class="bg-warning py-1 px-3 fw-bold text-center p-1 rounded-pill text-light">\
                Request Pending\
            </label>\
        </div>\
        <div class="col-6 px-3 py-2 text-end">\
            <button class="btn btn-danger btn-cancel_trade_request">Cancel Request</button>\
        </div>';
    var request_trade_button =
        '<div class="col-12 px-3 py-2 text-end">\
            <button class="btn btn-success btn-request_trade">Request Trade</button>\
        </div>';
    function loadTable(table) {
        $.each(table, function (key, value)
        {
            /* CONVERT DATE */
            var str = value.created_at;
            var date = moment(str);
            var daate = date.utc().format('YYYY-MM-DD hh:mm:ss A');

            var sts = value.trade_status.toUpperCase();
            var sts_type = 'primary';

            switch (sts) {
                case 'OPEN':
                    sts_type = 'success'
                    break;
                case 'ONGOING':
                    sts_type = 'primary'
                    break;
                case 'CLOSED':
                    sts_type = 'danger'
                    break;
                case 'FULFILLED':
                    sts_type = 'secondary'
                    break;
                default:
                    break;
            }
            var trade_button = '';
            // show view trade button if trade participant
            if (user_iagd_number == value.poster_iagd_number || user_iagd_number == value.requester_iagd_number) {
                trade_button = view_trade_button;
            } // show view request pending if open and current trade
            else if (user_current_trade_no == value.trade_no && sts == 'OPEN') {
                trade_button = cancel_request_button;
            } // show request trade button if trade is open and not poster/requester
            else if (sts == 'OPEN' && user_iagd_number != value.poster_iagd_number && user_iagd_number != value.requester_iagd_number) {
                trade_button = request_trade_button;
            }

            $(".trades_section").append(
                '<div class="trade_section row mx-1 my-4 p-4 rounded-3 bg-light section_shadow border border-1 border-light" data-no="'+value.trade_no+'" data-poster_no="'+value.poster_iagd_number+'" data-requester_no="'+value.requester_iagd_number+'" data-tlid="'+ value.trade_log_no +'">\
                    <div class="col-12 px-3">\
                        <h4>\
                            <label class="bg-'+ sts_type +' py-1 px-3 fw-bold text-center p-1 rounded-pill text-light" style="font-size: 0.85rem; margin-right: 0.5rem;">' + 
                                sts +'\
                            </label>' +
                            value.description +'\
                        </h4>\
                    </div>\
                    <div class="col-6 px-3 py-2 text-start">\
                        Trade #' + value.trade_no +'\
                    </div>\
                    <div class="col-3 px-3 py-2 text-end">\
                        <label class="request-count bg-secondary py-1 px-3 fw-bold text-center p-1 rounded-pill text-light">\
                            <small>\
                                Trade Requests: <span>'+value.trade_log_count+'</span>\
                            </small>\
                        </label>\
                    </div>\
                    <div class="col-3 px-3 py-2 text-end">\
                        <small>'+daate+'</small>\
                    </div>\
                    <div class="col-12">\
                        <hr>\
                    </div>\
                    <div class="col-6 px-3 py-2 d-flex flex-wrap align-item-middle">\
                        <div class="" style="background-image: url(\'https://upload.wikimedia.org/wikipedia/commons/thumb/7/7e/Circle-icons-profile.svg/1024px-Circle-icons-profile.svg.png\');width: 25px; height: 25px; background-size: cover; background-repeat: no-repeat; background-position: center;">\
                        </div>\
                        <div class="my-auto mx-4">' + 
                            value.poster_iagd_number +'\
                        </div>\
                    </div>\
                    <div class="col-6 container-trade-btn px-3 py-2 d-flex flex-wrap align-item-middle">'+
                        trade_button+'\
                    </div>\
                </div>'
                );
        });
    }

    $.ajax({
        url: '/ajax_alltrade?page=1',
        type: "get",
        dataType: 'json',
        success: function (response)
        {
            loadTable(response.data.data);
        }
    });

    function loadMoreData(page) {
        $.ajax({
            url: '/ajax_alltrade?page=' + page,
            type: "get",
            dataType: 'json',
            beforeSend: function() {
                $(".spinner-load-data").show();
            }
        })
        .done(function(response) {
            if (response.data.data.length < 1) {
                return false;
            }
            else
            {
                loadTable(response.data.data);
                $(".spinner-load-data").hide();
            }
        })
        .fail(function(jqXHR, ajaxOptions, thrownError) {
            console.log(thrownError);
        });
    }
    $(document).on('click', '.btn-view_trade', function (e) {
        window.location.href = 'view_trade/'+$(this).parents('.trade_section').attr('data-no');
    });
    $(document).on('click', '.btn-request_trade', function (e) {
        var trade_no = $(this).parents('.trade_section').attr('data-no');
        var trade_button_container = $(this).parents('.container-trade-btn');
        var trade_request_count = $(this).parents('.trade_section').find('.request-count span');

        $.ajax({
            type: "post",
            url: "create_trade_request",
            data: { tradeno : trade_no },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                switch (response) {
                    case 'request_created':
                        toastr["success"]("Trade request successfully sent", "Success!");
                        trade_button_container.html(
                                '<div class="col-6 text-end">\
                                    <label class="bg-warning py-1 px-3 fw-bold text-center p-1 rounded-pill text-light">\
                                        Request Pending\
                                    </label>\
                                </div>\
                                <div class="col-6 px-3 py-2 text-end">\
                                    <button class="btn btn-danger btn-cancel_trade_request">Cancel Request</button>\
                                </div>'
                            );
                        trade_request_count.html(parseInt(trade_request_count.html()) + 1);
                        break;
                    case 'request_failed':
                        toastr["warning"]("Something's wrong! Please try again later.", "Error");
                        break;
                    case 'request_exists':
                        toastr["warning"]("Request Exists!", "Warning");
                        break;
                    case 'requester_has_trades_ongoing':
                        toastr["warning"]("You have ongoing trades.", "Warning");
                        break;
                    case 'trade_ongoing':
                        toastr["warning"]("Trade is ongoing/fulfilled", "Warning");
                        break;
                    case 'poster_requesting':
                        toastr["warning"]("Poster can't request", "Warning");
                        break;
                    case 'trade_not_found':
                        toastr["warning"]("Trade not found", "Warning");
                        break;
                    default:
                        toastr["error"]("Something's wrong! Please try again later.", "Error");
                        break;
                }
            },
            complete: function() {

            },
        });
    });
    $(document).on('click', '.btn-cancel_trade_request', function (e) {
        var trade_no = $(this).parents('.trade_section').attr('data-no');
        var trade_button_container = ($(this).parents('.container-trade-btn'));
        var trade_request_count = $(this).parents('.trade_section').find('.request-count span');

        $.ajax({
            type: "post",
            url: "cancel_trade_request",
            data: { tradeno : trade_no },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                switch (response) {
                    case 'trade_request_cancelled':
                        toastr["success"]("Trade request successfully cancelled", "Success!");
                        trade_button_container.html(
                                '<div class="col-12 px-3 py-2 text-end">\
                                    <button class="btn btn-success btn-request_trade">Request Trade</button>\
                                </div>'
                            );
                        trade_request_count.html(parseInt(trade_request_count.html()) - 1);
                        break;
                    case 'error_trade_request_cancel':
                        toastr["warning"]("Something's wrong! Please try again later.", "Error");
                        break;
                    case 'trade_log_not_found':
                        toastr["warning"]("Trade Request not found", "Warning");
                        break;
                    case 'trade_not_found':
                        toastr["warning"]("Trade not found", "Warning");
                        break;
                    default:
                        toastr["error"]("Something's wrong! Please try again later.", "Error");
                        break;
                }
            },
            complete: function() {

            },
        });
    });
    $("#example1").emojioneArea({
        search: false,
        pickerPosition: "bottom",
        filtersPosition: "bottom"

    });

    // if (user_current_trade_log_no != null && user_current_trade_log_no != '') {
    //     Echo.private('current.trade.notification.' + user_current_trade_log_no)
    //         .listen('YourTradeNotification', (e) => {
    //             if (e.action == 'trade_request_reject') {
    //                 // change button of trade
    //                 $('.trade_section[data-tlid="'+ e.trade_log_id +'"]').find('.container-trade-btn').html(request_trade_button);
    //             }
    //         });
    // }
    // Echo.private('current.trade.notification.' + user_current_trade_log_no)
    //     .stopListening('YourTradeNotification');
});
