@if (Session::has('response'))
    @switch(Session::get('response'))
        @case('key_error')
            <div class="custom-alert ca-error position-fixed bottom-0">
                <span><i class="mdi mdi-alert"></i> <strong>Error! </strong> Something's wrong! Please try again.</span>
            </div>
        @break

        @case('iagd_not_found')
            <div class="custom-alert ca-warning position-fixed bottom-0">
                <span><i class="mdi mdi-alert"></i> <strong>Warning! </strong> IAGD number not found</span>
            </div>
        @break

        @case('error_saving_verification')
            <div class="custom-alert ca-warning position-fixed bottom-0">
                <span><i class="mdi mdi-alert"></i> <strong>Warning! </strong> Something's wrong while saving
                    verification</span>
            </div>
        @break

        @case('enter_iagd_num')
            <div class="custom-alert ca-warning position-fixed bottom-0">
                <span><i class="mdi mdi-alert"></i> <strong>Warning! </strong> Enter your IAGD number</span>
            </div>
        @break

        @case('page_expired')
            <div class="custom-alert ca-warning position-fixed bottom-0">
                <span><i class="mdi mdi-alert"></i> <strong>Warning! </strong> Page expired</span>
            </div>
        @break

        @case('resend_after_60')
            <div class="custom-alert ca-warning position-fixed bottom-0">
                <span><i class="mdi mdi-alert"></i> <strong>Warning! </strong> Resend email after 180 seconds</span>
            </div>
        @break

        @case('pass_not_matched')
            <div class="custom-alert ca-warning position-fixed bottom-0">
                <span><i class="mdi mdi-alert"></i> <strong>Warning! </strong> Password did not matched</span>
            </div>
        @break

        @case('already_have_account')
            <div class="custom-alert ca-warning position-fixed bottom-0">
                <span><i class="mdi mdi-alert"></i> <strong>Warning! </strong> Email verified already</span>
            </div>
        @break

        @case('incorrect_cred')
            <div class="custom-alert ca-warning position-fixed bottom-0">
                <span><i class="mdi mdi-alert"></i> <strong>Warning! </strong> Incorrect login credentials</span>
            </div>
        @break

        @case('user_already_in_lounge')
            <div class="custom-alert ca-warning position-fixed bottom-0">
                <span><i class="mdi mdi-alert"></i> <strong>Warning! </strong> Email or IAGD number already registered</span>
            </div>
        @break

        @case('no_email_found')
            <div class="custom-alert ca-warning position-fixed bottom-0">
                <span><i class="mdi mdi-alert"></i> <strong>Warning! </strong> Your IAGD details don't have an email
                    address</span>
            </div>
        @break

        @case('reg_needed')
            <div class="custom-alert ca-warning position-fixed bottom-0">
                <span><i class="mdi mdi-alert"></i> <strong>Warning! </strong> Your need to register
                    address</span>
            </div>
        @break

        @case('no_email_found')
            <div class="custom-alert ca-warning position-fixed bottom-0">
                <span><i class="mdi mdi-alert"></i> <strong>Warning! </strong> You must verifiy your email first</span>
            </div>
        @break

        @case('invalid_pass_res_req')
            <div class="custom-alert ca-warning position-fixed bottom-0">
                <span><i class="mdi mdi-alert"></i> <strong>Warning! </strong> This request is not valid. Send a new password
                    reset request.</span>
            </div>
        @break

        @case('email_sent')
            <div class="custom-alert ca-success position-fixed bottom-0">
                <span><i class="mdi mdi-alert"></i> <strong>Success! </strong> Email sent to your email address</span>
            </div>
        @break

        @case('account_reated')
            <div class="custom-alert ca-success position-fixed bottom-0">
                <span><i class="mdi mdi-alert"></i> <strong>Success! </strong> Account created</span>
            </div>
        @break

        @default
    @endswitch
@endif
@if ($errors->any())
    <div class="custom-alert ca-warning position-fixed bottom-0">
        <span><i class="mdi mdi-alert"></i> <strong>Warning! </strong> {{ $errors->first() }} </span>
    </div>
@endif
