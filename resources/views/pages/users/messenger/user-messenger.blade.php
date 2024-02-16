{{-- HEADER CONTAINS CSS LINKS --}}
@include('pages/users/template/section/header')
<link rel="stylesheet" href="{{ asset('css/messenger.css') }}">

<body>

    <div class="m-wrapper">

        @include('pages/users/messenger/template/messenger-header-nav')

        <div class="m-main d-flex flex-row">
            <div class="m-sidebar-conversation">
                <div class="m-convo-title px-3 pb-3 pt-4">
                    <label class="form-label" for="search_user_convers">
                        Start conversation  <span class="badge rounded-pill bg-danger">Beta</span>
                    </label>
                    <input id="search_user_convers" class="form-control mb-1 fs-text" type="text" placeholder="Search" autocomplete="off">
                    <button id="search_user_convers_btn" class="btn btn-primary btn-sm w-100">
                        <span class="mdi mdi-magnify"></span> Search
                    </button>
                </div>
                <div class="p-3 d-flex flex-row justify-content-between fs-text">
                    <div>
                        <span>
                            Conversations
                        </span>
                    </div>
                    {{-- <div>
                        <i class="mdi mdi-plus"></i> Create message
                    </div> --}}
                </div>
                <div class="m-convo-list">
                    {{-- List of conversation room --}}
                </div>
            </div>
            <div class="conversation-section">
                {{-- Conversation --}}
            </div>
        </div>
    </div>
    {{-- Include modals --}}
    @include('pages.users.messenger.modals.search-user-result')
    {{-- Include custom user toast --}}
    @include('pages/users/template/section/user-toasts')

</body>
@include('pages/users/template/section/scripts')
@include('pages/users/template/section/scripts-var')
{{-- <script src="{{ asset('js/messenger_js/messenger-scripts.js') }}"></script> --}}
<script src="{{ asset('js/messenger_js/messenger.js') }}"></script>

</html>
