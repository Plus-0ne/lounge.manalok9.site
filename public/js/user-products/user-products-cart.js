$(function () {
    /* -------------------------------------------------------------------------- */
    /*                               On check click                               */
    /* -------------------------------------------------------------------------- */
    $('.product-cart-check').on('click', function () {
        const thisCheck = $(this);

        thisCheck.toggleClass('checked');
    });
});
