<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <meta charset="utf-8">
    </head>
    <body style="font: 13px Verdana, Geneva, sans-serif; color: #000; background: #e4e4e4;">
        <div style="width: 900px; background: #fff; margin: 0 auto;">
            <img src="{{ url('assets/email/images/newsletter_header.jpg') }}" alt="">

            <div style="border-bottom: 2px solid #134093; padding: 20px 0; line-height: 20px;">
                @yield('content')
            </div>

            <div style="color: #8b8b8b; font-size: 11px; padding: 5px 5px; height: 30px;">
                <div style="float: left;">
                    &copy; {{ date('Y') }} <strong>{{ trans('email.newsletter_template_copyrights') }}</strong>
                </div>
                <div style="float: right;">
                    <a href="{{ url('unsubscribe/' . $user->unsubscribe_hash) }}" style="display: inline-block; padding: 5px 8px; border-radius: 4px; background: #2980b9; color: #fff; text-decoration: none;">{{ trans('email.newsletter_template_unsubscribe') }}</a>
                </div>
            </div>
        </div>
    </body>
</html>