<!DOCTYPE html>
<html lang="en">

<head>
    {{-- SEO --}}
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    @include('pages.users.template.section.meta-og')

    <title>
        International Animals Genetic Database
    </title>
    <link rel="stylesheet" href="{{ asset('landing_page/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@mdi/font@6.6.96/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="{{ asset('css/welcome-landing-v2.css') }}">
    <style>
        #qrreader {
            width: 500px;
        }

        .qrreader-container {
            height: 100vh;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="qrreader-container d-flex flex-column justify-content-center align-items-center">
            <div class="d-flex flex-row justify-content-start align-items-start">
                <div class="mb-3">
                    <label for="cameraOptionsSelect" class="form-label">Select Camera</label>
                    <select id="cameraOptionsSelect" class="form-select form-select-sm">
                    </select>
                </div>
            </div>
            <div class="d-flex flex-row justify-content-center align-items-center">
                <div id="qrreader" class="text-center"></div>
            </div>
        </div>
    </div>
</body>
<script src="{{ asset('landing_page/js/jquery-3.6.0.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="{{ asset('landing_page/js/bootstrap.min.js') }}"></script>
{{-- MOMENT JS --}}
<script src="https://momentjs.com/downloads/moment.js"></script>
<script src="https://momentjs.com/downloads/moment-with-locales.min.js"></script>
<script src="https://momentjs.com/downloads/moment-timezone-with-data.js"></script>
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script src="{{ asset('js/qr/scanner.js') }}"></script>
</html>
