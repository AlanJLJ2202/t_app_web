<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{mix('/css/listas.css')}}">
    <title>Listas de compras</title>
</head>

<body style="margin: 0;">
    <div id="app">
        <listas_compras :vuser="{{ Auth::user() }}"></listas_compras>
    </div>
</body>

<script src="{{ mix('js/listas_compras.js') }}"></script>
</html>
