<!DOCTYPE html>
<html lang="en">
<head>
    <base href="/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>AutoManual</title>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>
<body>

    <div id="app"></div>

    <script src="{{ asset('js/app.js') }}"></script>

    <script defer src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script defer src="{{ asset('plugins/popper/popper.min.js') }}"></script>
    <script defer src="{{ asset('plugins/bootstrap/bootstrap.min.js') }}"></script>
    <script defer src="{{ asset('plugins/nice-select/js/jquery.nice-select.min.js') }}"></script>

    <script>
        window.addEventListener('load', function(){
            $('.nice-select').niceSelect();
        })
    </script>
</body>
</html>
