<div class="modal fade modalCustomAnimation" id="servicesCartModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">
                    <span class="mdi mdi-cart"></span> My cart (<span id="orderedCount">0</span>)
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="w-100 mb-3">
                    <div>
                        <p>Please download our QR code for payment.</p>
                    </div>
                    <div class="d-flex flex-column">
                        <div>
                            <a class="btn col-12" download href="{{ asset('img/381167286_793333219236632_9063116107704270138_n.png') }}">

                                <img class="img-fluid" src="{{ asset('img/381196062_293129843446466_2590890577616570992_n.png') }}" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div id="serviceBodyContent">
                    <div class="d-flex flex-row justify-content-center">
                        <div class="lead">
                            <span class="mdi mdi-loading mdi-spin"></span>
                        </div>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <div class="d-flex flex-row justify-content-between w-100">
                    <div id="totatPriceText">
                        Total price : ₱ 0
                    </div>
                    <a href="{{ route('user.services.serviceCheckout') }}" class="btn btn-primary btn-sm">
                        <span class="mdi mdi-cart-check"></span> Checkout
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
