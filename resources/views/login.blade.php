<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ mix('/css/global.css') }}">
    <title>Login</title>
</head>
<body>
    <div class="login">
        <div class="login-contenido">
            <div class="login-contenido-recuadro">
                <div class="informacion">
                    <h1>LOGIN</h1>
                    <form action="{{ route('login') }}" method="POST">
                        <div class="field">
                            <label for="">Correo</label>
                            <input type="text">
                        </div>
                        <div class="field">
                            <label for="">Contraseña</label>
                            <input type="password">
                        </div>
                        <div class="boton">
                            <button type="submit">Entrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>
