<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta charset="utf-8">
    </head>
    <body style="font: 13px Verdana, Geneva, sans-serif; color: #000; background: #e4e4e4;">
        <div style="width: 900px; background: #fff; margin: 0 auto;">
            <img src="{{ url('assets/email/images/header.jpg') }}" alt="">

            <div style="border-bottom: 2px solid #134093; padding: 20px 0; line-height: 20px;">
                @yield('content')
            </div>

            <div style="color: #4a5157; font-size: 11px; padding: 5px 20px; height: 18px;">
                <div style="float: left;">
                    &copy; {{ date('Y') }} <strong>Teknoza CMS</strong>
                </div>
                <div style="float: right;">
                    
                </div>
            </div>
        </div>
    </body>
</html>