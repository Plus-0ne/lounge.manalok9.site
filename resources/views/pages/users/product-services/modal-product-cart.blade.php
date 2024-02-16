<style>
    .cart-product-image {
        width: 150px;
        height: 150px;

    }

    .cart-product-image img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        object-position: center;
    }
</style>
<div class="modal fade modalCustomAnimation" id="modalShowMyCart" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog"
    aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">
                    <span class="mdi mdi-cart-outline"></span> Cart
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="w-100 mb-3">
                    <p> <strong class="text-danger">Note</strong> : Before you proceed, please verify your information:</p>
                    <ul>
                        <li>
                            <div>
                                Verify your address :
                                <strong>{{ empty(Auth::guard('web')->user()->address) ? 'No address' : Auth::guard('web')->user()->address }}</strong>
                            </div>

                        </li>
                        <li>
                            <div>
                                Verify your contact number :
                                <strong>{{ empty(Auth::guard('web')->user()->contact_number) ? 'No contact number' : Auth::guard('web')->user()->contact_number }}</strong>
                            </div>
                        </li>
                        <li>
                            <div>
                                Verify your email address :
                                <strong>{{ empty(Auth::guard('web')->user()->email_address) ? 'No email address' : Auth::guard('web')->user()->email_address }}</strong>
                            </div>
                        </li>
                    </ul>
                    <p>Click the link to update your information : <a href="{{ route('user.user_profile') }}" target="_BLANK">
                        Verify Information
                    </a></p>


                    <p>Please download our QR code for payment.</p>
                    <a class="btn col-12" download href="{{ asset('img/381167286_793333219236632_9063116107704270138_n.png') }}">
                        <img class="img-fluid" src="{{ asset('img/381196062_293129843446466_2590890577616570992_n.png') }}" alt="">
                    </a>
                    <hr>
                </div>
                <div id="myCartContent" class="d-flex flex-column py-3 py-xl-3">



                </div>

            </div>
            <div class="modal-footer" style="height: auto;">


                <div class="w-100">
                    <button id="cartCheckout" type="button" class="btn btn-primary btn-sm">
                        <span class="mdi mdi-cart-check"></span> Checkout
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
