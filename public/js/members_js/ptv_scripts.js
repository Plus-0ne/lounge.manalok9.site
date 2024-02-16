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

    $('#poster_pet_no').on('change', function() {
        if ($(this).val().length > 0) {
            let selected_pet = $('#poster_pets').find('option[value="' + $(this).val() + '"]');

            $('#poster_pet_name').text(selected_pet.val());
            $('#poster_pet_breed').text(selected_pet.attr('data-breed'));
            $('#poster_pet_date_of_birth').text(selected_pet.attr('data-date_of_birth'));
            $('#poster_pet_gender').text(selected_pet.attr('data-gender'));

            if ($('#poster_pet_details').hasClass('d-none')) {
                $('#poster_pet_details').removeClass('d-none');
            }
            if (!$('#poster_pet_none').hasClass('d-none')) {
                $('#poster_pet_none').addClass('d-none');
            }
        } else {

        }
    });

    function loadTable(table) {
        $.each(table, function (key, value)
        {
            if ($('.trade_request[data-tlid="'+ value.id +'"]').length < 1) {
                $(".trade_requests_section").append(
                    '<div class="col-12 p-2 my-1 border border-2 border-dark rounded-3 trade_request" data-tlid="'+ value.id +'" style="display: none;">\
                        <div class="row">\
                            <div class="col-3">\
                                <img class="rounded-circle w-100" src="'+ assets_folder + value.members_model.profile_image +'">\
                            </div>\
                            <div class="col-9">\
                                <div class="col-12">\
                                    <h4>'+
                                        value.members_model.first_name +' '+ value.members_model.last_name+'\
                                    </h4>\
                                </div>\
                                <div class="col-12">\
                                    <i>'+
                                        value.members_model.iagd_number+'\
                                    </i>\
                                </div>\
                                <div class="col-12 pt-2">\
                                    <button type="button" class="btn btn-success m-1 btn-accept_trade_request">\
                                        <i class="nav-icon mdi mdi-check-bold"></i>\
                                        Accept\
                                    </button>\
                                    <button type="button" class="btn btn-danger m-1 btn-reject_trade_request">\
                                        <i class="nav-icon mdi mdi-close-thick"></i>\
                                        Reject\
                                    </button>\
                                </div>\
                            </div>\
                        </div>\
                    </div>'
                    );
                $('.trade_request[data-tlid="'+ value.id +'"]').fadeIn();
            }
        });
    }
    function loadRequests() {
        $('.loading_requests').show();
        $.ajax({
            url: '/ajax_allrequest',
            type: "get",
            dataType: 'json',
            data: { tradeno : user_current_trade_no },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response)
            {
                loadTable(response.data);
            },
            complete: function (response)
            {
                $('.loading_requests').hide();
            }
        });
    }
    loadRequests();


    $(document).on('click', '.btn-reject_trade_request', function (e) {
        var trade_log_id = $(this).parents('.trade_request').attr('data-tlid');
        var trade_request = $(this).parents('.trade_request');

        $.ajax({
            type: "post",
            url: "/reject_trade_request",
            data: { trade_log_id : trade_log_id },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                switch (response) {
                    case 'trade_request_rejected':
                        toastr["success"]("Trade request successfully rejected", "Success!");
                        trade_request.fadeOut('fast', function() {
                            trade_request.remove();
                            if ($('.trade_request').length < 1) {
                                $('.trade_requests_none').fadeIn();
                            }
                        });
                        break;
                    case 'error_trade_request_reject':
                        toastr["warning"]("Something's wrong! Please try again later.", "Error");
                        break;
                    case 'trade_log_not_found':
                        toastr["warning"]("Trade Request not found", "Warning");
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

    $(document).on('click', '.btn-accept_trade_request', function (e) {
        var trade_log_id = $(this).parents('.trade_request').attr('data-tlid');
        var trade_request = $(this).parents('.trade_request');

        $.ajax({
            type: "post",
            url: "/accept_trade_request",
            data: { trade_log_id : trade_log_id },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                switch (response) {
                    case 'trade_request_accepted':
                        toastr["success"]("Trade request successfully accepted", "Success!");
                        // trade_request.fadeOut('fast', function() {
                        //     trade_request.remove();
                        //     if ($('.trade_request').length < 1) {
                        //         $('.trade_requests_none').fadeIn();
                        //     }
                        // });
                        break;
                    case 'error_trade_request_accept':
                        toastr["warning"]("Something's wrong! Please try again later.", "Error");
                        break;
                    case 'trade_log_not_found':
                        toastr["warning"]("Trade Request not found", "Warning");
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

    /* BROADCAST */
    Echo.private('current.trade.notification.' + user_current_trade_log_no)
        .listen('YourTradeNotification', (e) => {
            if (e.action == 'trade_request_send') {
                loadRequests();
                $('.trade_requests_none').fadeOut();
            } else if (e.action == 'trade_request_cancel') {
                $('.trade_request[data-tlid="'+ e.trade_log_id +'"]').fadeOut('fast', function() {
                    $('.trade_request[data-tlid="'+ e.trade_log_id +'"]').remove();
                    if ($('.trade_request').length < 1) {
                        $('.trade_requests_none').fadeIn();
                    }
                });

            }
        });
});
