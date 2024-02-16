<div class="modal fade" id="modalReferralClaimCommissions" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
        <div class="modal-content claim-commissions-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="text-primary" style="opacity: 0.5;">
                            <b>Before we proceed...</b>
                        </h3>
                    </div>
                </div>
                <div class="row mt-4" style="overflow: none;">
                    <div class="col-sm-12 mb-2">
                        <span>We need a payout method and your details to continue.</span>
                        <br>
                        <span>Please insert them below.</span>
                    </div>
                    <div class="col-sm-12 mt-2">
                        <label for="referral-claim-claimer"><i class="mdi mdi-account-check"></i> Your Name</label>
                        <input id="referral-claim-claimer" type="text" class="form-control" readonly>
                    </div>
                    <div class="col-sm-12 pt-1" style="background-color: rgba(255, 255, 255, 0.33);">
                        <label for="referral-claim-amount"><i class="mdi mdi-cash"></i> Amount</label>
                        <input id="referral-claim-amount" type="number" class="form-control" step="1">
                    </div>
                    <div class="col-sm-12 pt-1" style="background-color: rgba(255, 255, 255, 0.33);">
                        <label for="referral-claim-payout_method"><i class="mdi mdi-bank-transfer-in"></i> Payout Method</label>
                        <select id="referral-claim-payout_method" class="form-control">
                            <option value="bank_bdo">Bank - BDO</option>
                            <option value="bank_bpi">Bank - BPI</option>
                            <option value="bank_metrobank">Bank - Metrobank</option>
                            <option value="bank_pnb">Bank - PNB</option>
                            <option value="ewallet_gcash">E-Wallet - GCash</option>
                            <option value="ewallet_maya">E-Wallet - Maya</option>
                            <option value="ewallet_shopeepay">E-Wallet - ShopeePay</option>
                        </select>
                    </div>
                    <div class="claim-account_name col-sm-12 pt-1" style="display: none; background-color: rgba(255, 255, 255, 0.33);">
                        <label for="referral-claim-account_name"><i class="mdi mdi-account-cash"></i> Account Name</label>
                        <input id="referral-claim-account_name" type="text" class="form-control">
                    </div>
                    <div class="col-sm-12 pt-1 pb-2" style="background-color: rgba(255, 255, 255, 0.33);">
                        <label for="referral-claim-account_number"><i class="mdi mdi-account-cash"></i> Account Number</label>
                        <input id="referral-claim-account_number" type="text" class="form-control">
                    </div>
                    <div class="col-sm-12 mt-3">
                        <button type="button" class="referral-claim_commissions-submit-btn btn btn-secondary input-group-text w-100"><i class="mdi mdi-lock"></i> Unavailable for now</button>
                        <!--<button type="button" class="referral-claim_commissions-submit-btn btn btn-primary input-group-text w-100"><i class="mdi mdi-cash-multiple"></i> Submit for Processing</button>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>