{{-- HEADER CONTAINS CSS LINKS --}}
@include('pages/users/template/section/header')
<link rel="stylesheet" href="{{ asset('css/post_view.css?v=1') }}">
<link rel="stylesheet" href="{{ asset('css/post_feed.css') }}">
</head>
<style>
    .header-card {
        background: rgb(174,181,193);
        background: linear-gradient(156deg, rgba(174,181,193,1) 0%, rgba(255,255,255,1) 26%);
    }
    .wrapper {

    }
    .main {

    }
    .main-content {
        background-color: transparent;
    }
    .modal-content {
        padding: 35px 50px 50px 50px;
        border-radius: 24px;
    }
    .modal-content.activate-withdrawal-content {
        width: 900px;
        height: 300px;
        background-image: url('https://cdn.tewi.club/2023/11/mk9/a73c61ea/layered-waves-haikei.png');
        overflow: none;
    }
    .modal-content.claim-commissions-content {
        width: 900px;
        height: 600px;
        background-image: url('https://cdn.tewi.club/2023/11/mk9/a73c61ea/stacked-waves-haikei_v3.png');
        background-repeat: no-repeat;
        background-size: cover;
        overflow: none;
    }
    .tewi-input {
        border-radius: 12px;
    }
    .referral-tin-input {
        transition: transform 0.3s ease; /* Smooth transition for scaling */
    }
    
    .referral-tin-input.enlarge {
        transform: scale(1.1); /* Adjust the scale value to control the amount of enlargement */
    }

    .text-primary {
        color: #ffd400 !important;
    }

    .table {
        color: #eee;
    }
    td {
        background-color: transparent;
        border: none;
        box-shadow: none;
    }
</style>
<body>
    <div class="wrapper">

        {{-- TOP NAVIGATION --}}
        @include('pages/users/template/section/header_nav')

        <div class="main">

            {{-- SIDABAR --}}
            @include('pages/users/template/section/sidebar')

            <div class="main-content">
                <div class="container-fluid container-xl">
                    <div class="row mb-3">
                        <div class="col-sm-12 col-md-12">
                            <div class="p-3 card">
                                <table class="table">
                                    <tbody style="vertical-align: middle;">
                                        <tr style="font-size: 14px;">
                                            <td>Unclaimed Commissions:</td>
                                            <td>
                                                <b style="font-size: 18px;">₱<span class="referrals-user-commissions">...</span></b>
                                                <button type="button" class="loading-commissions-btn btn btn-secondary btn-sm ml-2" style="font-size: 12px; margin-top: -6px; margin-left: 4px;">
                                                    Loading...
                                                </button>
                                                <button type="button" class="activate-withdrawal-btn btn btn-success btn-sm ml-2" style="font-size: 12px; margin-top: -6px; margin-left: 4px; display: none;">
                                                    <i class="mdi mdi-creation"></i> Activate
                                                </button>
                                                <button type="button" class="claim-commissions-btn btn btn-primary btn-sm ml-2" style="font-size: 12px; margin-top: -6px; margin-left: 4px; display: none;">
                                                    <i class="mdi mdi-cash-multiple"></i> Claim
                                                </button>
                                            </td>
                                        </tr>
                                        <tr style="font-size: 14px;">
                                            <td>Invite Link:</td>
                                            <td>
                                                <span class="referral-qrcode-link-text">{{ url('/') }}/?ref={{ Auth::guard('web')->user()->iagd_number }}</span>
                                                <button type="button" class="referral-link-copy-btn btn btn-secondary btn-sm" style="font-size: 12px; width: 12px; padding-left: 6px;"><i class="mdi mdi-content-copy"></i></button>
                                                <button type="button" id="btnModalReferralQrCodeShow" class="btn btn-secondary btn-sm ml-2" style="font-size: 12px;"><i class="mdi mdi-qrcode"></i> Scannable QR Code</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!--<div class="col-sm-12 col-md-4">-->
                        <!--    <div class="p-3 card d-shadows-primary d-flex flex-column align-items-center">-->
                        <!--        <button type="button" id="btnModalReferralQrCodeShow" class="btn btn-secondary mb-2">-->
                        <!--            <span class="mdi mdi-qrcode"></span> Referral QR Code-->
                        <!--        </button>-->
                        <!--    </div>-->
                        <!--</div>-->
                    </div>
                    <div class="row loading-group mt-5">
                        <div class="col-sm-12 text-center text-primary">
                            <i class="spinner-border" style="width: 128px; height: 128px; opacity: 0.35"></i>
                        </div>
                    </div>
                    <div class="row">
                        @for ($i = 1; $i <= 7; $i++)
                            <div class="col-12 col-md-12 mt-5 mt-md-0 reference-text" data-level="{{ $i }}" style="display: none; padding-bottom: 5px; margin-left: 20px;">
                                <h2 class="text-primary">
                                    Level {{ $i }}
                                </h2>
                            </div>
                            <hr>
                            <div class="col-12 col-md-12 mt-md-0 reference-container" data-level="{{ $i }}" style="display: none; margin-bottom: 85px; margin-left: 20px;"></div>
                        @endfor
                    </div>
                </div>
            </div>
            @include('pages/users/template/section/r-sidebar')
        </div>
    </div>
    {{-- Modals --}}
    @include('pages.users.user_profile.section.modal-referral_qrcod')
    @include('pages.users.user_profile.section.modal-referral_activate_withdrawal')
    @include('pages.users.user_profile.section.modal-referral_claim_commissions')
</body>

{{-- SCRIPTS --}}
@include('pages/users/template/section/scripts')
@include('pages/users/template/section/scripts-var')

<script src="{{ asset('js/qrcode.min.js') }}"></script>
<script src="{{ asset('js/filesaver.min.js') }}"></script>

<script type="text/javascript">
var iagd_number = "{{ Auth::guard('web')->user()->iagd_number }}";
var withdraw_valid = {{ json_encode($data['withdraw_valid']) }};
var withdraw_status = "{{ json_encode($data['withdraw_status']) }}";
if (withdraw_valid == 1) {
    $('.loading-commissions-btn').hide();
    $('.activate-withdrawal-btn').hide();
    $('.claim-commissions-btn').show();
} else {
    $('.loading-commissions-btn').hide();
    $('.claim-commissions-btn').hide();
    $('.activate-withdrawal-btn').show();
}
console.log(withdraw_status);

let user_commission = {{ $data['commissions'][Auth::guard('web')->user()->iagd_number]['claimable'] }};
$('.referrals-user-commissions').text(user_commission.toFixed(2));

/* REFERRAL CODE QR */
new QRCode(document.getElementById("referral-qrcode"), "{{ url('/') }}/?ref={{ Auth::guard('web')->user()->iagd_number }}");
$('#btnModalReferralQrCodeShow').on('click', function () {
    const modalQrCode = $('#modalReferralQrCode');

    modalQrCode.modal('toggle');
});

setTimeout(function() {
    let qrCodeElement = document.getElementById("referral-qrcode");
    let qrCodeCanvas = qrCodeElement.getElementsByTagName('canvas')[0];
    if (qrCodeCanvas) {
        let imgSrc = qrCodeCanvas.toDataURL();  // Convert the canvas to a data URL

        // Define click behavior
        $('.referral-qrcode-download').click(function (e) {
            e.preventDefault();  // prevent navigation
            let imgBlob = dataURItoBlob(imgSrc);  // convert data URL to blob
            saveAs(imgBlob, "qrcode.png");  // trigger download
        });
    } else {
        console.log("No canvas found");
    }
}, 1000);  // Wait 1 second for the QR code to generate

// Function to convert dataURI to blob
function dataURItoBlob(dataURI) {
    let binary = atob(dataURI.split(',')[1]);
    let array = [];
    for (let i = 0; i < binary.length; i++) {
        array.push(binary.charCodeAt(i));
    }
    return new Blob([new Uint8Array(array)], {type: 'image/png'});
}

var photo_path = "{{ asset('img/user/'); }}";
console.log(photo_path);
function buildReferralCard(data, target_container) {
    let full_name = formatName(data.first_name, data.middle_name, data.last_name);
    full_name = trimText(full_name, 20);
    let referred_by = data.referred_by ? data.referred_by : 'none';
    let profile_image = "{{ asset('my_custom_symlink_1/user.png') }}";
    if (data.profile_image) {
        let profile_image = `${photo_path}/${data.profile_image}`;
    }

    let data_card = $(`<div class="hoverable-card card tewi-container-noblur" data-iagd_number="${data.iagd_number}" data-referred_by="${data.referred_by}" style="width: 18rem; display: inline-block; margin-top: 5px; margin-bottom: 25px; margin-right: 33px; top: 25px; border-radius: 0px 0px 16px 0px; border: 1px solid var(--divider-color-primary);">
                          <div class="card-body d-flex flex-column">
                              <img src="${profile_image}" class="rounded-circle" width="48" height="48" style="position: absolute; left: -25px; bottom: 75px; border: 1px solid var(--divider-color-primary); background-color: var(--divider-color-primary);">
                              <h5 class="card-title text-primary font-clemente" style="margin-left: 15px;">${full_name}</h5>
                              <h6 class="card-subtitle mb-2">${data.iagd_number ? data.iagd_number : '<span class="text-muted" style="font-size: 13px;"><i class="bi bi-exclamation-circle-fill" style="vertical-align: 0;"></i> No description specified.</span>'}</h6>
                              <p class="card-text" style="font-size: 13px;">Referred by ${data.referred_by ? data.referred_by : '<span class="text-muted" style="font-size: 13px;"><i class="bi bi-exclamation-circle-fill" style="vertical-align: 0;"></i> No references.</span>'}</p>
                          </div>
                    </div>`);

    // store the original commission as a data attribute
    data_card.data('original_commission', 0);

    $(target_container).append(data_card);
    return true;
}
$(document).on('mouseenter', '.hoverable-card', function () {
    $(this).css('border-color', '#ffcc00');
    $(this).css('transition', 'all 0.2s cubic-bezier(0.22, 0.68, 0, 1.71)');
	$(this).css('transform', 'scale(1.1)');
    let iagd_number = $(this).data('iagd_number');
    let referred_by = $(this).data('referred_by');
    highlightBranch(iagd_number);
    highlightParent(referred_by);
});

$(document).on('mouseleave', '.hoverable-card', function () {
    $(this).css('border-color', 'var(--divider-color-primary)');
    $(this).css('transition', 'all 0.2s cubic-bezier(0.22, 0.68, 0, 1.71)');
	$(this).css('transform', 'scale(1)');
    $('.hoverable-card').css('border-color', 'var(--divider-color-primary)')
    $('.hoverable-card').css('transition', 'all 0.2s cubic-bezier(0.22, 0.68, 0, 1.71)');
	$('.hoverable-card').css('transform', 'scale(1)');
});

function highlightBranch(iagd_number) {
    let cards = $(`.card[data-referred_by="${iagd_number}"]`);
    if(cards.length > 0) {
        cards.css('border-color', '#ffcc00');
        cards.css('transition', 'all 0.2s cubic-bezier(0.22, 0.68, 0, 1.71)');
	    cards.css('transform', 'scale(1.1)');
        cards.each(function() {
            highlightBranch($(this).data('iagd_number'));
        });
    }
}

function highlightParent(referred_by) {
    let card = $(`.card[data-iagd_number="${referred_by}"]`);
    if(card.length > 0) {
        card.css('border-color', '#ffcc00');
        card.css('transition', 'all 0.2s cubic-bezier(0.22, 0.68, 0, 1.71)');
	    card.css('transform', 'scale(1.1)');
        highlightParent(card.data('referred_by'));
    }
}
function formatName(first_name, middle_name, last_name) {
    let formatted_name = "";

    if (last_name) {
        formatted_name = `${last_name}, `;
    }
    if (first_name) {
        formatted_name += first_name;
    }

    return formatted_name;
}
function trimText(text, length) {
    if (text.length > length) {
        return text.substring(0, length) + "...";
    } else {
        return text;
    }
}

var references = @json($data['references']);
console.log(references);
$(document).ready(function () {
    let addedCards = new Set();  // To keep track of added cards

    $.each(references.downline_data, function (index, user) {
        let iagd_number = user.iagd_number;

        // Skip adding the card if it's already been added
        if (addedCards.has(iagd_number)) {
            return;
        }

        // Add the card's unique identifier to the set
        addedCards.add(iagd_number);

        $(`.reference-text[data-level="${user.level}"]`).show();
        $(`.reference-container[data-level="${user.level}"]`).show();
        buildReferralCard(user, `.reference-container[data-level="${user.level}"]`);
        console.log(user.level);
    });
    $('.loading-group').hide();
    $(".referral-link-copy-btn").click(async function(){
        var textToCopy = $(".referral-qrcode-link-text").text();
        try {
            await navigator.clipboard.writeText(textToCopy);
            $(this).prop('disabled', true);
            $(this).html('<i class="mdi mdi-checkbox-marked-circle-outline"></i>');
            setTimeout(function() {
                $(".referral-link-copy-btn").prop('disabled', false);
                $(".referral-link-copy-btn").html('<i class="mdi mdi-content-copy"></i>');
            }, 1500);
            console.log('Text copied to clipboard');
        } catch (err) {
           $(this).prop('disabled', true);
           $(this).html('<i class="mdi mdi-alert"></i>');
            setTimeout(function() {
                $(".referral-link-copy-btn").prop('disabled', false);
                $(".referral-link-copy-btn").html('<i class="mdi mdi-content-copy"></i>');
            }, 1500);
            console.error('Failed to copy text: ', err);
        }
    });
    $('.activate-withdrawal-btn').on('click', function () {
        $('#modalReferralActivateWithdrawal').modal('toggle');
        $('#referral-tin-input').focus();
    });
    $('#referral-tin-input').on('input', function (e) {
        var input = $(this).val();
        var inputNumbers = input.replace(/\D/g,''); // Remove any non-digit characters
        
        // Limit to 12 characters
        if(inputNumbers.length > 12) {
            inputNumbers = inputNumbers.substr(0, 12);
        }

        var formattedInput = '';
        
        // Split the input into groups of 3 digits and add dashes
        for (var i = 0; i < inputNumbers.length; i += 3) {
            if (formattedInput.length > 0) {
                formattedInput += '-';
            }
            formattedInput += inputNumbers.substring(i, Math.min(i + 3, inputNumbers.length));
        }
        
        // Apply animation class if the input is not empty
        // if (formattedInput.length > 0) {
        //     $(this).addClass('enlarge');
        // } else {
        //     $(this).removeClass('enlarge');
        // }

        // Update the input field with the formatted input
        $(this).val(formattedInput);
    }).on('blur', function(e) {
        // Remove animation class when input loses focus
        // $(this).removeClass('enlarge');
    });
    $('.referral-tin-submit-btn').on('click', function() {
		$(this).prop('disabled', true);
		$(this).html('<i class="spinner-border spinner-border-sm" style="font-size: 12px;"></i>');
		$('#referral-tin-input').prop('disabled', true);
		let tin = $('#referral-tin-input').val();
		$.ajax({
			'url': "https://attendance.metaanimals.org/api/v1/referrals/create_referral_user_status",
			'type': 'POST',
			'data': {
				iagd_number: iagd_number,
				tin: tin
			},
			'dataType': 'JSON',
			success: function(response) {
				if (response.code == 2) {
					$('.referral-tin-submit-btn').html('<i class="mdi mdi-checkbox-marked-circle-outline"></i>');
					setTimeout(function() {
                        $('#modalReferralActivateWithdrawal').modal('hide');
                        $('.loading-commissions-btn').hide();
                        $('.activate-withdrawal-btn').hide();
                        $('.claim-commissions-btn').show();
                    }, 1500);
				} else {
					$(".referral-tin-submit-btn").prop('disabled', true);
                    $(".referral-tin-submit-btn").html('<i class="mdi mdi-alert"></i>');
                    setTimeout(function() {
                        $(".referral-tin-submit-btn").prop('disabled', false);
                        $(".referral-tin-submit-btn").html('<i class="mdi mdi-send-check"></i>');
                        $('#referral-tin-input').prop('disabled', false);
                    }, 1500);
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
			    $(".referral-tin-submit-btn").prop('disabled', true);
                $(".referral-tin-submit-btn").html('<i class="mdi mdi-alert"></i>');
                setTimeout(function() {
                    $(".referral-tin-submit-btn").prop('disabled', false);
                    $(".referral-tin-submit-btn").html('<i class="mdi mdi-send-check"></i>');
                    $('#referral-tin-input').prop('disabled', false);
                }, 1500);
				console.log(jqXHR);
				console.log(textStatus);
				console.log(errorThrown);
			}
		});
	});
	$('.claim-commissions-btn').on('click', function () {
        $('#modalReferralClaimCommissions').modal('toggle');
    });
});
</script>

</html>