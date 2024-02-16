@if (Session::has('status'))
    @switch(Session::get('status'))
        @case('key_error')
            <div class="custom-alert ca-warning d-flex align-items-center justify-content-between animate__animated animate__flipInX">
                <div class="d-flex align-items-center">
                    <div class="prompt-img">
                        <i class="mdi mdi-alert"></i>
                    </div>
                    <div class="prompt-text ms-3">
                        {{ Session::get('message') }}
                    </div>
                </div>
                <div class="prompt-img prompt-closes">
                    <i class="mdi mdi-close"></i>
                </div>
            </div>
        @break

        @case('validation_error')
            <div class="custom-alert ca-warning d-flex align-items-center justify-content-between animate__animated animate__flipInX">
                <div class="d-flex align-items-center">
                    <div class="prompt-img">
                        <i class="mdi mdi-alert"></i>
                    </div>
                    <div class="prompt-text ms-3">
                        {{ Session::get('message') }}
                    </div>
                </div>
                <div class="prompt-img prompt-closes">
                    <i class="mdi mdi-close"></i>
                </div>
            </div>
        @break

        @case('email_exist')
            <div class="custom-alert ca-warning d-flex align-items-center justify-content-between animate__animated animate__flipInX">
                <div class="d-flex align-items-center">
                    <div class="prompt-img">
                        <i class="mdi mdi-alert"></i>
                    </div>
                    <div class="prompt-text ms-3">
                        {{ Session::get('message') }}
                    </div>
                </div>
                <div class="prompt-img prompt-closes">
                    <i class="mdi mdi-close"></i>
                </div>
            </div>
        @break

        @case('password_not_matched')
            <div class="custom-alert ca-warning d-flex align-items-center justify-content-between animate__animated animate__flipInX">
                <div class="d-flex align-items-center">
                    <div class="prompt-img">
                        <i class="mdi mdi-alert"></i>
                    </div>
                    <div class="prompt-text ms-3">
                        {{ Session::get('message') }}
                    </div>
                </div>
                <div class="prompt-img prompt-closes">
                    <i class="mdi mdi-close"></i>
                </div>
            </div>
        @break

        @case('account_not_created')
            <div class="custom-alert ca-warning d-flex align-items-center justify-content-between animate__animated animate__flipInX">
                <div class="d-flex align-items-center">
                    <div class="prompt-img">
                        <i class="mdi mdi-alert"></i>
                    </div>
                    <div class="prompt-text ms-3">
                        {{ Session::get('message') }}
                    </div>
                </div>
                <div class="prompt-img prompt-closes">
                    <i class="mdi mdi-close"></i>
                </div>
            </div>
        @break

        @case('account_created')
            <div class="custom-alert ca-success d-flex align-items-center justify-content-between animate__animated animate__flipInX">
                <div class="d-flex align-items-center">
                    <div class="prompt-img">
                        <i class="mdi mdi-check"></i>
                    </div>
                    <div class="prompt-text ms-3">
                        {{ Session::get('message') }}
                    </div>
                </div>
                <div class="prompt-img prompt-closes">
                    <i class="mdi mdi-close"></i>
                </div>
            </div>
        @break

        @case('validate_error')
            <div class="custom-alert ca-warning d-flex align-items-center justify-content-between animate__animated animate__flipInX">
                <div class="d-flex align-items-center">
                    <div class="prompt-img">
                        <i class="mdi mdi-alert"></i>
                    </div>
                    <div class="prompt-text ms-3">
                        {{ Session::get('message') }}
                    </div>
                </div>
                <div class="prompt-img prompt-closes">
                    <i class="mdi mdi-close"></i>
                </div>
            </div>
        @break

        @case('incorrect_cred')
            <div class="custom-alert ca-warning d-flex align-items-center justify-content-between animate__animated animate__flipInX">
                <div class="d-flex align-items-center">
                    <div class="prompt-img">
                        <i class="mdi mdi-alert"></i>
                    </div>
                    <div class="prompt-text ms-3">
                        {{ Session::get('message') }}
                    </div>
                </div>
                <div class="prompt-img prompt-closes">
                    <i class="mdi mdi-close"></i>
                </div>
            </div>
        @break

        {{-- ======================== FORGOT PASSWORD PROMPTS ======================== --}}
        @case('failed_validate')
            <div class="custom-alert ca-warning d-flex align-items-center justify-content-between animate__animated animate__flipInX">
                <div class="d-flex align-items-center">
                    <div class="prompt-img">
                        <i class="mdi mdi-alert"></i>
                    </div>
                    <div class="prompt-text ms-3">
                        {{ Session::get('message') }}
                    </div>
                </div>
                <div class="prompt-img prompt-closes">
                    <i class="mdi mdi-close"></i>
                </div>
            </div>
        @break



        @case('member_not_found')
            <div class="custom-alert ca-warning d-flex align-items-center justify-content-between animate__animated animate__flipInX">
                <div class="d-flex align-items-center">
                    <div class="prompt-img">
                        <i class="mdi mdi-alert"></i>
                    </div>
                    <div class="prompt-text ms-3">
                        {{ Session::get('message') }}
                    </div>
                </div>
                <div class="prompt-img prompt-closes">
                    <i class="mdi mdi-close"></i>
                </div>
            </div>
        @break

        @case('mail_not_sent')
            <div class="custom-alert ca-warning d-flex align-items-center justify-content-between animate__animated animate__flipInX">
                <div class="d-flex align-items-center">
                    <div class="prompt-img">
                        <i class="mdi mdi-alert"></i>
                    </div>
                    <div class="prompt-text ms-3">
                        {{ Session::get('message') }}
                    </div>
                </div>
                <div class="prompt-img prompt-closes">
                    <i class="mdi mdi-close"></i>
                </div>
            </div>
        @break

        @case('mail_sent')
            <div class="custom-alert ca-success d-flex align-items-center justify-content-between animate__animated animate__flipInX">
                <div class="d-flex align-items-center">
                    <div class="prompt-img">
                        <i class="mdi mdi-check"></i>
                    </div>
                    <div class="prompt-text ms-3">
                        {{ Session::get('message') }}
                    </div>
                </div>
                <div class="prompt-img prompt-closes">
                    <i class="mdi mdi-close"></i>
                </div>
            </div>
        @break

        @case('error_saving')
            <div class="custom-alert ca-warning d-flex align-items-center justify-content-between animate__animated animate__flipInX">
                <div class="d-flex align-items-center">
                    <div class="prompt-img">
                        <i class="mdi mdi-alert"></i>
                    </div>
                    <div class="prompt-text ms-3">
                        {{ Session::get('message') }}
                    </div>
                </div>
                <div class="prompt-img prompt-closes">
                    <i class="mdi mdi-close"></i>
                </div>
            </div>
        @break

        @case('wait_for_seconds')
            <div class="custom-alert ca-warning d-flex align-items-center justify-content-between animate__animated animate__flipInX">
                <div class="d-flex align-items-center">
                    <div class="prompt-img">
                        <i class="mdi mdi-alert"></i>
                    </div>
                    <div class="prompt-text ms-3">
                        {{ Session::get('message') }}
                    </div>
                </div>
                <div class="prompt-img prompt-closes">
                    <i class="mdi mdi-close"></i>
                </div>
            </div>
        @break

        @case('verify_email_pls')
            <div class="custom-alert ca-warning d-flex align-items-center justify-content-between animate__animated animate__flipInX">
                <div class="d-flex align-items-center">
                    <div class="prompt-img">
                        <i class="mdi mdi-alert"></i>
                    </div>
                    <div class="prompt-text ms-3">
                        {{ Session::get('message') }}
                    </div>
                </div>
                <div class="prompt-img prompt-closes">
                    <i class="mdi mdi-close"></i>
                </div>
            </div>
        @break

        {{-- =========================== EMAIL VERIFICATION ================================ --}}
        @case('mail_sent_to_email')
        <div class="custom-alert ca-success d-flex align-items-center justify-content-between animate__animated animate__flipInX">
            <div class="d-flex align-items-center">
                <div class="prompt-img">
                    <i class="mdi mdi-alert"></i>
                </div>
                <div class="prompt-text ms-3">
                    {{ Session::get('message') }}
                </div>
            </div>
            <div class="prompt-img prompt-closes">
                <i class="mdi mdi-close"></i>
            </div>
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
