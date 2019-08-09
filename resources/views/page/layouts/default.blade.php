<!DOCTYPE HTML>
<html lang="{{ App::getLocale() }}">
    <head>
        <meta charset="UTF-8">
        <title>{{ $meta_title }}</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <meta name="robots" content="index, follow"/>
        <meta name="keywords" content=""/>
        <meta name="description" content=""/>
        <link rel="shortcut icon" href="{{ url('assets/page/images/favicon.png') }}">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.css">

        <style>
            #page-content {
                padding-top: 5%;
            }
            #locale-switcher ul,
            #locale-switcher li {
                padding: 0;
                margin: 0;
                list-style: none;
            }
            #locale-switcher li {
                display: inline-block;
                margin: 0 4px;
            }
            #locale-switcher img {
                display: block;
                padding: 1px;
                background: #fff;
                border: 1px solid #dcdcdc;
            }
        </style>
    </head>
    <body>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="{!! url('/') !!}">Teknoza CMS</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                {!! Module::display('menu', ['shortcode' => 'header']) !!}
            </div>

            <div>
                @if($locales->count() > 1)
                    <ul id="locale-switcher">
                        @foreach($locales as $locale)
                            <li><a href="{{ route('locale', $locale->id) }}"><img src="{{ url('assets/page/images/flags/' . $locale->language . '.png') }}" alt=""></a></li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </nav>

        <div id="page-content">
            @yield('content')
        </div>

        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        <<script src="https://cdn.jsdelivr.net/bxslider/4.2.12/jquery.bxslider.min.js"></script>
        <script>
            $(document).ready(function(){
                $('.slider').bxSlider({captions: true});
            });
        </script>
    </body>
</html>
