<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido a PoliticFriends</title>
    <style type="text/css">
        /* Estilos base */
        body, html {
            margin: 0;
            padding: 0;
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            line-height: 1.6;
            color: #333333;
            background-color: #f7f7f7;
        }
        
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        .header {
            text-align: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #eeeeee;
            margin-bottom: 20px;
        }
        
        .logo {
            max-width: 150px;
            height: auto;
        }
        
        h1, h2 {
            color: #2c3e50;
            margin-top: 0;
        }
        
        .content {
            padding: 0 15px;
        }
        
        .credentials {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
            border-left: 4px solid #D25252;
        }
        
        .credentials li {
            margin-bottom: 8px;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eeeeee;
            text-align: center;
            font-size: 14px;
            color: #7f8c8d;
        }
        
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #D25252;
            color: #ffffff !important;
            text-decoration: none;
            border-radius: 4px;
            font-weight: bold;
            margin: 15px 0;
        }
        
        .warning {
            background-color: #fff3cd;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
            border-left: 4px solid #ffc107;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><span style="color: #D25252;">Politic</span>Friends</h1>
            <h3>¡Bienvenido a PoliticFriends!</h3>
        </div>
        
        <div class="content">
            <h2>¡Hola {{ $usuario->name }}!</h2>
            
            <p>Nos alegra darte la bienvenida a nuestra plataforma. Tu cuenta ha sido creada con éxito y ya puedes comenzar a disfrutar de todos nuestros servicios.</p>
            
            <div class="credentials">
                <p><strong>Tus datos de acceso:</strong></p>
                <ul>
                    <li><strong>Correo electrónico:</strong> {{ $usuario->email }}</li>
                    <li><strong>Contraseña temporal:</strong> {{ $password }}</li>
                </ul>
            </div>
            
            <div class="warning">
                <p>🔒 <strong>Por tu seguridad:</strong> Te recomendamos cambiar esta contraseña inmediatamente después de iniciar sesión por primera vez.</p>
            </div>
            
            <!-- Botón de acción principal -->
            <div style="text-align: center;">
                <a href="https://PoliticFriends.com/login" class="btn">Iniciar Sesión</a>
            </div>
            
            <p>Si tienes alguna pregunta o necesitas ayuda, no dudes en contactar a nuestro equipo de soporte.</p>
        </div>
        
        <div class="footer">
            <p>Saludos cordiales,<br><strong>Equipo PoliticFriends</strong></p>
            <p>
                <small>
                    © 2026 PoliticFriends. Todos los derechos reservados.<br>
                    <a href="https://PoliticFriends.com" style="color: #D25252;">Visita nuestro sitio web</a>
                </small>
            </p>
        </div>
    </div>
</body>
</html>