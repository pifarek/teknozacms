<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>{{ trans('admin.template_title') }}</title>
        <link rel="shortcut icon" href="{{ url('assets/administrator/images/favicon.png') }}">
        <link href="{{ url('assets/administrator/css/build.css') }}" rel="stylesheet" />
    </head>
    <body class="page-login">

        @yield('content')

        <script src="{{ url('assets/administrator/js/vendors.min.js') }}"></script>
        <script src="{{ url('assets/administrator/js/app.min.js') }}"></script>
    </body>
</html>