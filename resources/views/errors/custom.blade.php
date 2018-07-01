<!doctype html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
        <style>
            html, body {
                background: #215096;
                color: #fff;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <div style="padding-top: 20%">
                <h1>Internal Server Error</h1>

                <h5>Contact page administrator or try again later.</h5>
            </div>
            @if(config('app.debug'))
                <div class="alert alert-warning">{{ $exception->getMessage() }}</div>

                <?php dump($exception);?>
            @endif

        </div>
    </body>
</html>