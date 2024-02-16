<div class="modal fade" id="modalQrCode" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="modalTitleId" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitleId">QR Code</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="w-100 d-flex justify-content-center">
                    {{-- <img src="data:image/png;base64,{!! base64_encode(QrCode::format('png')->merge(public_path('logo path'),.3,true)->errorCorrection('H')->color(30, 37, 48)->backgroundColor(255,255,255)->margin(2)->size(500)->generate($data['gmd']->uuid)) !!}" alt="" srcset=""> --}}
                    {!! QrCode::errorCorrection('H')->color(30, 37, 48)->backgroundColor(255,255,255)->margin(2)->size(500)->generate($qrUrl = route('user.qr_result_user').'?uuid='.$data['gmd']->uuid) !!}
                </div>
            </div>
            <div class="modal-footer">
                <a href="{{ route('user.qrcode_download') }}?uuid={{ $data['gmd']->uuid }}" class="btn btn-primary btn-sm">
                    <span class="mdi mdi-download-box"></span> Download
                </a>
            </div>
        </div>
    </div>
</div>
