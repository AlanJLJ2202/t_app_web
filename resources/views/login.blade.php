<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ mix('/css/global.css') }}">
    <title>Login</title>
    <style>
        /* Estilos para el spinner de carga */
        .spinner {
            display: none; /* Ocultar el spinner por defecto */
            width: 40px;
            height: 40px;
            margin: 50px auto;
            border: 4px solid #f3f3f3;
            border-top: 4px solid green;
            border-radius: 50%;
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .alert {
            color: red;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="login">
        <div class="login-contenido">
            <div class="login-contenido-recuadro">
                <div class="informacion">
                    <h1>LOGIN</h1>
                    <div class="spinner" id="spinner"></div> <!-- Spinner de carga -->
                    <form action="{{ route('login') }}" method="POST">
                        <div class="field">
                            <label for="">Correo</label>
                            <input type="text" name="email" value="{{ old('email') }}">
                        </div>
                        <div class="field">
                            <label for="">Contraseña</label>
                            <input type="password" name="password">
                        </div>
                        @csrf
                        <div class="boton">
                            <button type="submit" onclick="showSpinner()">Entrar</button>
                        </div>
                    </form>
                    @if(session('alert'))
                        <div class="alert alert-danger">
                            {{ session('alert')['msg'] }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        function showSpinner() {
            document.getElementById("spinner").style.display = "block"; // Mostrar el spinner
        }
    </script>
    
</body>
</html>
