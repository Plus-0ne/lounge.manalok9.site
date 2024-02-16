{{-- HEADER CONTAINS CSS LINKS --}}
@include('pages/admins/section/admin-header')
</head>

<body>
    <div class="wrapper">

        {{-- TOP NAVIGATION --}}
        @include('pages/admins/section/admin-header_nav')

        <div class="main">

            {{-- SIDABAR --}}
            @include('pages/admins/section/admin-sidebar')

            <div class="main-content h-100">
                <div class="container-fluid">
                    <div class="row">
                        <div class="p-3 p-lg-4 dashboard-section d-flex flex-wrap">
                            <div class="breadcrumb-text col-12 my-3 text-sm-center text-lg-start">
                                <h5>
                                    Training tickets
                                </h5>
                                <hr>

                                <div class="table-responsive">
                                    <table id="tableTrainTickets" class="table table-condensed">
                                        <thead>
                                            <th scope="col">Status</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Contact #</th>
                                            <th scope="col">FB link/URL</th>
                                            <th scope="col">Created at</th>
                                            <th scope="col">Action</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($data['trainingTickets'] as $row)
                                                <tr>
                                                    <td>
                                                        @if ($row->status != 1)
                                                        <span class="badge rounded-pill bg-success">Closed</span>
                                                            @else
                                                            <span class="badge rounded-pill bg-info">Active</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{ $row->ticketAuthor->first_name }} {{ $row->ticketAuthor->last_name }} needs assistance for dog training.
                                                    </td>
                                                    <td>
                                                        {{ $row->updated_contact }}
                                                    </td>
                                                    <td>
                                                        {{ $row->facebook_link }}
                                                    </td>
                                                    <td>
                                                        @php
                                                            $dateUtc = Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at, 'UTC');
                                                            $dateLocal = $dateUtc->setTimezone('Asia/Manila');
                                                            $localFormatted = $dateLocal->format('Y-m-d h:i A');
                                                            echo $localFormatted;
                                                        @endphp
                                                    </td>
                                                    <td>
                                                        @if ($row->status == 1)
                                                        <button type="button" class="btn btn-success btn-sm close_ticket" data-uuid="{{ $row->uuid }}">
                                                            <span class="mdi mdi-check"></span> Close
                                                        </button>
                                                        @else
                                                        <label class="text-warning"><span class="mdi mdi-check"></span> This ticket is closed.</label>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- SCRIPTS --}}
    @include('pages/admins/section/admin-scripts')
    <script src="{{ asset('js/admins_js/admin-training-tickets.js') }}"></script>
</body>

</html>
