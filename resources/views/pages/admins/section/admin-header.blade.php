<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>
		{{ $data['title'] }}
	</title>

	<meta name="csrf-token" content="{{ csrf_token() }}" />


	{{-- BOOTSTRAP --}}
	<link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">

	{{-- MATERIAL ICONS --}}
	<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/@mdi/font@6.5.95/css/materialdesignicons.min.css">

	{{-- DATA TABLE --}}
	<link href="{{ asset('DataTable_B5/dataTables.bootstrap5.min.css') }}" rel="stylesheet">

	{{-- TOASTR --}}
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

	{{-- CUSTOM STYLES --}}
	<link href="{{ asset('css/admin-style.css') }}" rel="stylesheet">
