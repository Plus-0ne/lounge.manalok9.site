{{-- HEADER CONTAINS CSS LINKS --}}
@include('pages/users/template/section/header')

<style type="text/css">
    .gallery_container {
        background-color: #ffffff;
        border-radius: 5px;
        -webkit-box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1),
            0 6px 6px rgba(0, 0, 0, 0.2);
        -moz-box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1),
            0 6px 6px rgba(0, 0, 0, 0.2);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1), 0 6px 6px rgba(0, 0, 0, 0.2);
        clear: both;
        box-sizing: border-box;
    }
</style>
<body>
    <div class="wrapper">

        {{-- TOP NAVIGATION --}}
        @include('pages/users/template/section/header_nav')

        <div class="main">

            {{-- SIDABAR --}}
            @include('pages/users/template/section/sidebar')

            <div class="main-content h-100">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12 px-4 pt-4 pb-5 gallery_container d-flex flex-wrap">
                            <div class="col-12 p-3">
                                <h4>
                                    <i class="mdi mdi-swap-horizontal-bold"></i> {{ $data['trade_data']->description }}
                                </h4>
                                <h6 class="ms-4">
                                    Trade Request #{{ $data['trade_data']->trade_no }}
                                    @php
                                        switch ($data['trade_data']->trade_status) {
                                            case 'open':
                                                $status_color = 'success';
                                                break;
                                            case 'ongoing':
                                                $status_color = 'primary';
                                                break;
                                            case 'closed':
                                                $status_color = 'danger';
                                                break;
                                            case 'fulfilled':
                                                $status_color = 'secondary';
                                                break;
                                            default:
                                                $status_color = '';
                                                break;
                                        }
                                    @endphp
                                    <label class="bg-{{ $status_color }} py-1 px-3 fw-bold text-center p-1 rounded-pill text-light" style="font-size: 0.85rem; margin-left: 0.5rem;">{{ strtoupper($data['trade_data']->trade_status) }}</label>
                                </h6>
                            </div>
                            <div class="col-12">
                                <hr>
                            </div>
                            <div class="col-5">
                                <div class="row">
                                    <div class="col-12 my-3">
                                        <h4>
                                            My Offer
                                        </h4>
                                        <hr>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label class="form-label">
                                            Select Pet
                                        </label>
                                        <input class="form-select" list="poster_pets" name="poster_pet_no" id="poster_pet_no" placeholder="Select Pet">

                                        <datalist id="poster_pets">
                                            @if (isset($data['test_animals']) && count($data['test_animals']) > 0)
                                                @foreach ($data['test_animals'] as $row)
                                                    <option value="{{ $row->rabbit_name }}"
                                                        data-breed="{{ $row->breed }}"
                                                        data-date_of_birth="{{ $row->date_of_birth }}"
                                                        data-gender="{{ $row->gender }}">
                                                        {{ strtoupper($row->rabbit_no) }}
                                                    </option>
                                                @endforeach
                                            @else
                                                <option value="Edge">
                                                <option value="Firefox">
                                                <option value="Chrome">
                                                <option value="Opera">
                                                <option value="Safari">
                                            @endif
                                        </datalist>
                                    </div>
                                    <div class="col-12 my-1 border border-dark p-3 rounded-4">
                                        <div id="poster_pet_details" class="row d-none">
                                            <div class="col-4">
                                                <img class="w-100" src="https://post.medicalnewstoday.com/wp-content/uploads/sites/3/2020/02/322868_1100-800x825.jpg" alt="">
                                            </div>
                                            <div class="col-8">
                                                <table>
                                                    <tbody>
                                                        <tr class="py-1">
                                                            <td class="fw-bold">Name:</td>
                                                            <td id="poster_pet_name" class="ps-2"></td>
                                                        </tr>
                                                        <tr class="py-1">
                                                            <td class="fw-bold">Breed:</td>
                                                            <td id="poster_pet_breed" class="ps-2"></td>
                                                        </tr>
                                                        <tr class="py-1">
                                                            <td class="fw-bold">DOB:</td>
                                                            <td id="poster_pet_date_of_birth" class="ps-2"></td>
                                                        </tr>
                                                        <tr class="py-1">
                                                            <td class="fw-bold">Gender:</td>
                                                            <td id="poster_pet_gender" class="ps-2"></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div id="poster_pet_none" class="row">
                                            <div class="col-12 text-center">
                                                <h5>No Pet Selected</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 my-3">
                                        <label class="form-label">
                                            Cash
                                        </label>
                                        <input class="form-control" type="number" step="0.0001" 
                                            value="{{ ((isset($data['poster_data']->cash_amount) && $data['poster_data']->cash_amount > 0) ? $data['poster_data']->cash_amount : '0.00') }}" name="trade_cash">
                                    </div>
                                </div>
                            </div>

                            <div class="col-2 d-flex justify-content-center align-items-center">
                                <i class="mdi mdi-swap-horizontal-bold mdi-48px"></i>
                            </div>

                            <div class="col-5">
                                {{-- CHECK IF REQUESTER EXISTS --}}
                                <div class="row request_list" style="{{ (!empty($data['requester_data']) ? 'display: none;' : '') }}">
                                    <div class="col-12 my-3">
                                        <h4>
                                            Trade Requests
                                        </h4>
                                        <hr>
                                    </div>
                                    <div class="row py-2 px-4 trade_requests_section">
                                    </div>
                                    <div class="col-12 my-2 text-center loading_requests" style="display: none;">
                                        <i class="mdi mdi-spin mdi-loading mdi-48px"></i>
                                    </div>
                                </div>
                                <div class="row trade_requests_none" style="{{ (!empty($data['requester_data']) || !empty($data['trade_requests']) ? 'display: none;' : '') }}">
                                    <div class="col-12 mb-3 bg-warning text-center p-3 rounded-pill text-light">
                                        <h5>[ NO REQUESTS ]</h5>
                                    </div>
                                </div>
                                <div class="row request_offer" style="{{ (empty($data['requester_data']) ? 'display: none;' : '') }}">
                                    <div class="col-12 my-3">
                                        <h4>
                                            User #00001's Offer
                                        </h4>
                                    </div>
                                    <div class="col-12 my-3">
                                        <label class="form-label">
                                            Select Pet
                                        </label>
                                        <input class="form-select" list="requester_pets" name="trade_pet" id="trade_pet" placeholder="Select Pet">

                                        <datalist id="requester_pets">
                                            @if (isset($data['test_animals']) && count($data['test_animals']) > 0)
                                                @foreach ($data['test_animals'] as $row)
                                                    <option value="{{ $row->rabbit_name }}">
                                                @endforeach
                                            @else
                                                <option value="Edge">
                                                <option value="Firefox">
                                                <option value="Chrome">
                                                <option value="Opera">
                                                <option value="Safari">
                                            @endif
                                        </datalist>
                                    </div>
                                    <div class="col-12 my-1 border border-dark p-3 rounded-4">
                                        <div class="row">
                                            @if (!empty($data['requester_data']->animal_no))
                                                <div class="col-4">
                                                    <img class="w-100" src="https://post.medicalnewstoday.com/wp-content/uploads/sites/3/2020/02/322868_1100-800x825.jpg" alt="">
                                                </div>
                                                <div class="col-8">
                                                    <table>
                                                        <tbody>
                                                            <tr>
                                                                <td class="fw-bold">Name:</td>
                                                                <td>Rudolf</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold">Breed:</td>
                                                                <td>Test</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold">DOB:</td>
                                                                <td>January 10, 2020</td>
                                                            </tr>
                                                            <tr>
                                                                <td class="fw-bold">Gender:</td>
                                                                <td>Male</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <div class="col-12 text-center">
                                                    <h5>No Pet Selected</h5>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12 my-3">
                                        <label class="form-label">
                                            Cash
                                        </label>
                                        <input class="form-control" type="number" step="0.0001" value="0.00" name="trade_cash">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-5">
                                        @if ($data['poster_data']->accepted == 1)
                                            <div class="col-12 mb-3 bg-success text-center p-3 rounded-pill text-light">
                                                <i class="mdi mdi-check-bold"></i> Trade Accepted
                                            </div>
                                        @else
                                            <div class="col-12 mb-3 bg-danger text-center p-3 rounded-pill text-light">
                                                <i class="mdi mdi-close-thick"></i> Not Accepted
                                            </div>
                                            @if (!empty($data['trade_data']->requester_iagd_no))
                                                <div class="col-12 my-3 text-center">
                                                    <button type="button" class="btn btn-success btn-lg">
                                                        <i class="mdi mdi-check-bold"></i>
                                                        Accept
                                                    </button>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                    <div class="col-2"></div>
                                    <div class="col-5">
                                        @if (!empty($data['requester_data']->animal_no))
                                            @if (!empty($data['requester_data']->accepted == 1))
                                                <div class="col-12 mb-3 bg-success text-center p-3 rounded-pill text-light">
                                                    <i class="mdi mdi-check-bold"></i> Trade Accepted
                                                </div>
                                            @else
                                                <div class="col-12 mb-3 bg-danger text-center p-3 rounded-pill text-light">
                                                    <i class="mdi mdi-close-thick"></i> Not Accepted
                                                </div>
                                                <div class="col-12 my-3 text-center">
                                                    <button type="button" class="btn btn-success btn-lg">
                                                        <i class="mdi mdi-check-bold"></i>
                                                        Accept
                                                    </button>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @if ($data['trade_data']->trade_status == 'open' || $data['trade_data']->trade_status == 'ongoing')
                                <div class="col-12">
                                    <hr>
                                </div>
                                <div class="col-12 text-end">
                                    <form action="{{ route('user.close_trade') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="tradeno" value="{{ $data['trade_data']->trade_no }}">
                                        <button type="submit" class="btn btn-warning btn-lg">
                                            <i class="mdi mdi-close-thick"></i>
                                            Close Trade
                                        </button>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @include('pages/users/template/section/r-sidebar')
        </div>
    </div>
</body>

{{-- SCRIPTS --}}
<script>
    var assets_folder = "{{ asset('/') }}";
    var user_iagd_number = "{{ Auth::guard('web')->user()->iagd_number }}";
    var user_current_trade_no = "{{ $data['trade_data']->trade_no ?? NULL }}";
    var user_current_trade_log_no = "{{ $data['trade_data']->trade_log_no ?? NULL }}";
    var user_current_trade_log_status = "{{ $data['trade_data']->log_status ?? NULL }}";
</script>
@include('pages/users/template/section/scripts')
<script src="{{ asset('/js/members_js/ptv_scripts.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        @if (Session::has('response'))
            @switch(Session::get('response'))
                @case('key_error')
                    toastr["error"]("Something's wrong! Please try again later.", "Error");
                @break

                @default
            @endswitch
        @endif
        @if ($errors->any())
            toastr["warning"]('{{ $errors->first() }}', "Warning");
        @endif
    });
</script>

</html>