<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta name="google-signin-client_id" content="748264524555-7q9eo5iul341e58r4dd43t72dm8tulmi.apps.googleusercontent.com">
    <title>
        {{ $data['title'] }}
    </title>
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/@mdi/font@6.5.95/css/materialdesignicons.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <link href="{{ asset('css/bootstrap-icons.min.css') }}" rel="stylesheet">

    <link href="{{ asset('css/login-style.css?v=2') }}" rel="stylesheet">

</head>
