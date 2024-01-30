<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="robots" content="noindex"/>
        <meta id="token" name="csrf-token" content="{{csrf_token()}}">
        <title>Admin</title>    
        <link rel="stylesheet" href="{{mix('/css/admin.css')}}">
    </head>
    <body>
        <div class="spinner">
            <div id="loading"></div>
        </div>
        <header class="Admin-header">
            <h2>ADMIN</h2>
            <a>
                <span class="material-icons">
                    logout
                </span>
                Cerrar sesión
            </a>
        </header>
    	<div class="Admin-container">
    		<nav class="Admin-menu">
    			<ul>
                    <li id="menu-invitados">
                        <a>
                            <span class="material-icons">
                                corporate_fare
                            </span>
                            Empresas
                        </a>
                    </li>
                    <li id="menu-colaborador">
                        <a>
                            <span class="material-icons">
                                groups
                            </span>
                            Colaboradores
                        </a>
                    </li>
					<li id="menu-vacantes">
                        <a>
                            <span class="material-icons">
                                work
                            </span>
                            Vacantes
                        </a>
                    </li>
					<li id="menu-encuestas">
                        <a>
                            <span class="material-icons">
                                poll
                            </span>
                            Encuestas
                        </a>
                    </li>
    			</ul>
    		</nav>
    		<div class="Admin-panel">
    			{{-- @yield('contenido') --}}
    		</div>
    	</div>

    </body>
</html>
