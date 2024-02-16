$(document).ready(function () {
    /* -------------------------------------------------------------------------- */
    /*                              Global variables                              */
    /* -------------------------------------------------------------------------- */
    let productUuid = null;
    let productStock = null;

    /* -------------------------------------------------------------------------- */
    /*                           Show modal add to cart                           */
    /* -------------------------------------------------------------------------- */
    $('.addToCartButton').on('click', function () {
        productUuid = $(this).attr('data-uuid');
        productStock = $(this).attr('data-maxItems');
        $('#quantity').val('1');

        $('#modalAddToCart').modal('toggle');

    });

    /* -------------------------------------------------------------------------- */
    /*                     On bs close set productUuid to null                    */
    /* -------------------------------------------------------------------------- */
    $('#modalAddToCart').on('hidden.bs.modal', function () {
        productUuid = null;
        productStock = null;
        $('#addToCartItem').attr('disabled', false);
    });

    /* -------------------------------------------------------------------------- */
    /*                          Number only in input text                         */
    /* -------------------------------------------------------------------------- */
    $("#quantity").on("keydown", function (event) {
        // Allow: backspace, delete, tab, escape, enter, and .
        if (
            $.inArray(event.keyCode, [46, 8, 9, 27, 13]) !== -1) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if (
            (event.shiftKey || event.keyCode < 48 || event.keyCode > 57) &&
            (event.keyCode < 96 || event.keyCode > 105)
        ) {
            event.preventDefault();
        }
    });

    /* -------------------------------------------------------------------------- */
    /*                        Min and max value of quantity                       */
    /* -------------------------------------------------------------------------- */
    $('#quantity').on('input', function (e) {
        let curVal = $(this).val();
        if (curVal === '') {
            $(this).val('1');
            return;
        }
        curVal = Math.min(Math.max(parseInt(curVal), 1), productStock); // Ensure it's within range
        $(this).val(curVal);
    });

    /* -------------------------------------------------------------------------- */
    /*                              Add item to cart                              */
    /* -------------------------------------------------------------------------- */
    $('#addToCartItem').on('click', function (e) {
        const quantity = $('#quantity');
        const fd = new FormData();

        fd.append('uuid', productUuid);
        fd.append('quantity', quantity.val());

        $(this).attr('disabled', true);
        $.ajax({
            method: "post",
            url: window.currentBaseUrl + '/products/cart/add',
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
                    $('#modalAddToCart').modal('toggle');
                }
            }, complete: function () {
                $(this).attr('disabled', false);
            }
        });
    });

    /* -------------------------------------------------------------------------- */
    /*                                Show my cart                                */
    /* -------------------------------------------------------------------------- */
    $('#showMyCartModalButton').on('click', function () {
        $('#modalShowMyCart').modal('toggle');
        $.ajax({
            type: "get",
            url: window.currentBaseUrl + '/products/cart',
            success: function (response) {
                const res = response;

                console.log(res);
                if (res.status == 'success') {
                    cartContentItems(res);
                }
            }
        });

    });

    /* -------------------------------------------------------------------------- */
    /*                                Cart on show                                */
    /* -------------------------------------------------------------------------- */
    $(document).on('#modalShowMyCart', 'hidden.bs.modal', function () {
        let myCartContent = $('#myCartContent');
        myCartContent.html("");
    });

    /* -------------------------------------------------------------------------- */
    /*                            Cart content template                           */
    /* -------------------------------------------------------------------------- */
    function cartContentItems(res) {
        /*
            * Create cart items
        */
        let myCartContent = $('#myCartContent');
        let productImage = null;
        let statuss = null;
        myCartContent.html("");

        /*
            * Check if cart json is empty
        */
        if (res.myCart == null || res.myCart == undefined || res.myCart.length < 1) {
            myCartContent.append(
                $('<div>', {
                    class : 'text-center'
                }).append(
                    $('<div>',{
                        class : 'lead d-flex flex-row w-100 justify-content-center align-items-center'
                    })
                    .append('Your cart is empty!')
                )
            )
            return false;

        }


        $.each(res.myCart, function (cartI, cartVal) {

            if (cartVal.product_details == null || cartVal.product_details == undefined || cartVal.product_details.length < 1) {
                productImage = window.assetUrl + '/img/no-preview.jpeg';
            } else {
                productImage = window.assetUrl + cartVal.product_details.image;
            }

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

            myCartContent.append(
                $('<div>', {
                    class: 'card d-flex flex-row align-items-center px-3 px-xl-3',
                }).append(
                    $('<div>', {
                        class: 'me-3'
                    }).append(
                        $('<label>', {
                            for: "cartItemSelect",
                            style: "font-size: 3rem;"
                        }).append(
                            $('<span>', {
                                class: "mdi mdi-check-circle cartItemSelectIcon itemIconCheck",
                                'data-uuid': cartVal.uuid
                            })
                        )
                    )
                ).append(
                    $('<div>', {
                        class: 'me-3 py-3',
                    }).append(
                        $('<div>', {
                            class: 'cart-product-image d-flex flex-column justify-content-center align-items-center'
                        }).append(
                            $('<img>', {
                                class: "img-fluid",
                                src: productImage,
                                alt: cartVal.product_details.name,
                            })
                        )
                    )
                ).append(
                    $('<div>', {
                        class: "cart-product-details d-flex flex-column w-100 py-3 me-3"
                    }).append(
                        $('<label>', {
                            text: 'Product: ' + cartVal.product_details.name
                        })
                    ).append(
                        $('<label>', {
                            text: 'Price per item: ₱ ' + cartVal.product_details.price
                        })
                    ).append(
                        $('<label>', {
                            text: 'Quantity in cart: ' + cartVal.quantity
                        })
                    ).append(
                        $('<label>', {
                            text: 'Total payment : ₱ ' +  cartVal.price
                        })
                    ).append(
                        $('<label>').append(statuss)
                    )
                ).append(
                    $('<div>').append(
                        $('<h4>').append(
                            $('<span>', {
                                class: "mdi mdi-delete deleteCartItem"
                            }).on('click', function (e) {
                                /*
                                    * Remove in cart
                                */
                                const productId = cartVal.id;

                                const fd = new FormData();
                                const thisBtn = $(this);
                                fd.append('id', productId);

                                thisBtn.attr('disabled', true);
                                $.ajax({
                                    method: "post",
                                    url: window.currentBaseUrl + '/products/cart/remove',
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
                                        }

                                    }, complete: function () {
                                        thisBtn.attr('disabled', false);
                                    }
                                });

                            })
                        )
                    )
                )
            );
        });
    }

    /* -------------------------------------------------------------------------- */
    /*                              Select icon cart                              */
    /* -------------------------------------------------------------------------- */
    $(document).on('click', '.cartItemSelectIcon', function () {
        const thisIcon = $(this);

        thisIcon.toggleClass('itemIconCheck');


    });

    /* -------------------------------------------------------------------------- */
    /*                                Cart checkout                               */
    /* -------------------------------------------------------------------------- */
    $('#cartCheckout').on('click', function (e) {
        const uuidArray = [];

        $('.itemIconCheck').each(function (index, element) {
            const el = $(element);
            const uuid = el.attr('data-uuid');
            uuidArray.push(uuid);
        });

        const fd = new FormData();
        fd.append('uuidArray', JSON.stringify(uuidArray));

        const thisBtn = $(this);

        thisBtn.attr('disabled',true);

        $.ajax({
            method: 'post',
            url: window.currentBaseUrl + '/products/cart/checkout',
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
                    $('#modalShowMyCart').modal('hide');
                }
            },
            complete: function () {
                thisBtn.attr('disabled',false);
            }
        });
    });


});
