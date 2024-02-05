<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{mix('/css/dashboard.css')}}">
    <link rel="stylesheet" href="{{mix('/css/dashboard_cargos.css')}}">
    <title>Login</title>
</head>

<body style="margin: 0;">
    <div id="app">
        @if(Auth::user()->tipo == 'ahorro')
            <dashboard_ahorros :vuser="{{ Auth::user() }}"></dashboard_ahorros>
        @else
            <dashboard_cargos :vuser="{{ Auth::user() }}"></dashboard_cargos>
        @endif
    </div>
</body>

<script src="{{ mix('js/transaccion.js') }}"></script>
</html>
