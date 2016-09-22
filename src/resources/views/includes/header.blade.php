<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>@yield('page-title')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('img/favicon.ico') }}" />
    <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
</head>
<body>
    <div class="container">
        @include('projectsquare-payment::partials.header')
    </div>