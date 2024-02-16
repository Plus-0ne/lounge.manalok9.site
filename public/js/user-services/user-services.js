$(function () {
    /* -------------------------------------------------------------------------- */
    /*                       Add sevice to cart button event                      */
    /* -------------------------------------------------------------------------- */
    $(document).on('click', '.addServiceToCart', function (e) {
        /*
            * Decalare variables
        */
        const thisBtn = $(this);
        const fd = new FormData();

        /*
            * Append input to form data
        */
        fd.append('service_uuid', thisBtn.attr('data-uuid'));

        /*
            * Disable default event
        */
        e.preventDefault();

        /*
            * Disable the button on click
        */
        thisBtn.attr('disabled', true);

        /*
            * Ajax post request
        */
        $.ajax({
            method: "post",
            url: window.currentBaseUrl + '/services/cart/add',
            data: fd,
            cache: false,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {

            },
            success: function (response) {
                const res = response;
                console.log(res);

                if (res.status == 'success') {
                    thisBtn.removeClass('addServiceToCart');
                    thisBtn.removeClass('btn-primary');
                    thisBtn.removeAttr('data-uuid');
                    thisBtn.addClass('btn-secondary');
                    thisBtn.html('<span class="mdi mdi-cart-plus"></span> Added');

                    toastr["success"](res.message);
                    return false;
                }
                toastr['"'+res.status+'"'](res.message);
                /*
                    * Enable the button on complete
                */
                thisBtn.attr('disabled', true);
            },
        });
    });

    /* -------------------------------------------------------------------------- */
    /*                             Show services cart                             */
    /* -------------------------------------------------------------------------- */
    $('#serviceCartBtn').on('click', function (e) {
        /*
            * Declare variables
        */
        const thisBtn = $(this);
        const modalContent = $('#serviceBodyContent');
        const orderedCount = $('#orderedCount');
        /*
            * Disable button
        */
        e.preventDefault();
        thisBtn.attr('disabled',true);

        /*
            * Ajax request get
        */
        $.ajax({
            method: "get",
            url: window.currentBaseUrl + '/services/cart',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {
            },
            success: function (response) {
                const res = response;
                console.log(res);
                if (res.status == 'success') {
                    /*
                        * Check service in cart count
                    */
                    if (res.totalInCart < 1) {
                        orderedCount.html("0");
                        modalContent.html("");
                        modalContent.append(
                            $('<div>',{
                                class : 'd-flex flex-row justify-content-center'
                            }).append(
                                $('<div>', {
                                    class : 'lead'
                                }).append(
                                    $('<span>', {
                                        text : 'Cart is empty!'
                                    })
                                )
                            )
                        );

                        return false;
                    }

                    /*
                        * Set count remove content
                    */
                    orderedCount.html(res.totalInCart);
                    modalContent.html("");

                    fillCartContent(res);
                }
            }
        });


        $('#servicesCartModal').modal('toggle');
    });

    /* -------------------------------------------------------------------------- */
    /*                         On cart service modal hide                         */
    /* -------------------------------------------------------------------------- */
    $('#servicesCartModal').on('hide.bs.modal', function () {
        $('#serviceCartBtn').attr('disabled',false);
        $('#serviceBodyContent').html("");
        $('#serviceBodyContent').append(
            $('<div>',{
                class : 'd-flex flex-row justify-content-center'
            }).append(
                $('<div>', {
                    class : 'lead'
                }).append(
                    $('<span>', {
                        class : 'mdi mdi-loading mdi-spin'
                    })
                )
            )
        );

        $('#orderedCount').html("0");
        $('#totatPriceText').html("Total price : ₱ 0");
    });

    /* -------------------------------------------------------------------------- */
    /*                       Cart content fill with services                      */
    /* -------------------------------------------------------------------------- */
    function fillCartContent(res) {
        const modalContent = $('#serviceBodyContent');
        let totalPrice = 0;
        /*
            * Check if res.cart is nulled or undefined
        */
        if (res.cart === undefined || res.cart < 1 || res.cart.lenght < 1) {
            return false;
        }

        /*
            * Append jquery dynamic tags
        */
        $.each(res.cart, function (cartI, cartVal) {
            if (cartVal.service_details == null || cartVal.service_details == undefined || cartVal.service_details.length < 1) {
                productImage = window.assetUrl + '/img/no-preview.jpeg';
            } else {
                productImage = window.assetUrl + cartVal.service_details.image;
            }

            /*
                * Set total price
            */
            totalPrice +=Number(cartVal.price);

            // 1 = in cart ; 2 = ordering ; 3 = verified order ; 4 = packing; 5 = delivering ; 6 = received ; 7 = cancelled
            switch (cartVal.status) {
                case 2:
                    statuss = '<span class="badge rounded-pill bg-success">Ordered</span>';
                    break;
                case 3:
                    statuss = '<span class="badge rounded-pill bg-success">Order verified</span>';
                    break;
                case 4:
                    statuss = '<span class="badge rounded-pill bg-success">Packed</span>';
                    break;
                case 5:
                    statuss = '<span class="badge rounded-pill bg-success">On deliver</span>';
                    break;
                case 6:
                    statuss = '<span class="badge rounded-pill bg-secondary">Received</span> ';
                    break;
                case 7:
                    statuss = '<span class="badge rounded-pill bg-danger">Cancelled</span>';
                    break;

                default:
                    statuss = '<span class="badge rounded-pill bg-success">In cart</span>';
                    break;
            }

            modalContent.append(
                $('<div>', {
                    class: 'card d-flex flex-row align-items-center px-3 px-xl-3',
                }).append(
                    $('<div>', {
                        class: 'd-flex flex-row justify-content-center'
                    }).append(
                        $('<div>', {
                            for: "cartItemSelect",
                            style: "font-size: 2rem;"
                        }).append(
                            $('<span>', {
                                class: "mdi mdi-check-circle cartItemSelectIcon itemIconCheck",
                                'data-uuid': cartVal.uuid
                            })
                        )
                    )
                ).append(
                    $('<div>', {
                        class: 'py-3',
                    }).append(
                        $('<div>', {
                            class: 'cart-product-image d-flex flex-column justify-content-center align-items-center'
                        }).append(
                            $('<img>', {
                                class: "img-fluid",
                                src: productImage,
                                alt: cartVal.service_details.name,
                            })
                        )
                    )
                ).append(
                    $('<div>', {
                        class: "cart-product-details d-flex flex-column w-100 py-3 ps-3"
                    }).append(
                        $('<label>', {
                            text: cartVal.service_details.name
                        })
                    ).append(
                        $('<label>', {
                            text: '₱ ' + Number(cartVal.price).toLocaleString()
                        })
                    ).append(
                        $('<label>').append(statuss)
                    )
                ).append(
                    $('<div>').append(
                        $('<h4>').append(
                            $('<span>', {
                                class: "mdi mdi-delete deleteCartItem"
                            }).on('click',function (e) {
                                e.preventDefault();

                                const id = cartVal.id;
                                const thisBtn = $(this);
                                const fd = new FormData();

                                fd.append('id',id);

                                $.ajax({
                                    method: "post",
                                    url: window.currentBaseUrl + '/services/cart/delete',
                                    data: fd,
                                    cache: false,
                                    processData: false,
                                    contentType: false,
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    success: function (response) {
                                        const res = response;

                                        console.log(res);

                                        if (res.status == 'success') {
                                            thisBtn.parent().parent().parent().remove();
                                            totalPrice-=Number(cartVal.price);
                                            $('#totatPriceText').html("Total price : ₱ "+ totalPrice.toLocaleString());
                                        }

                                    }
                                });
                            })
                        )
                    )
                )
            );
        });

        $('#totatPriceText').html("Total price : ₱ "+ totalPrice.toLocaleString());
    }
    
    /* -------------------------------------------------------------------------- */
    /*                              Select icon cart                              */
    /* -------------------------------------------------------------------------- */
    // $(document).on('click', '.cartItemSelectIcon', function () {
    //     const thisIcon = $(this);
    //     thisIcon.toggleClass('itemIconCheck');
    // });
});
