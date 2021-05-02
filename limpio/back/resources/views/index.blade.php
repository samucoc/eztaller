<!doctype html>
<html lang="{{ app()->getLocale() }}">
<VirtualHost *:8000>
    ServerAdmin operaciones@desarrollosocial.cl
    DocumentRoot "${INSTALL_DIR}/www/habitalidad_backend/public"
    ServerName habitabilidad.mideplan.cl
    ServerAlias habitabilidad.mideplan.cl
    ErrorLog logs/habitabilidad.mideplan.cl-error_log
    CustomLog logs/habitabilidad.mideplan.cl-access_log common
    Options Indexes FollowSymLinks

    <Directory "${INSTALL_DIR}/www/habitalidad_backend/public">
    Options +Indexes +Includes +FollowSymLinks +MultiViews
    AllowOverride All
    Require local
    </Directory>
</VirtualHost>

<VirtualHost *:80>
    ServerAdmin operaciones@desarrollosocial.cl
    DocumentRoot "${INSTALL_DIR}/www/habitabilidad_frontend/dist"
    ServerName habitabilidad.mideplan.cl
    ServerAlias habitabilidad.mideplan.cl
    ErrorLog logs/habitabilidad.mideplan.cl-error_log
    CustomLog logs/habitabilidad.mideplan.cl-access_log common
    Options Indexes FollowSymLinks

    <Directory "${INSTALL_DIR}/www/habitabilidad_frontend/dist">
    Options +Indexes +Includes +FollowSymLinks +MultiViews
    AllowOverride All
    Require local
    </Directory>
</VirtualHost>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Capitaliva v1 - Eztaller</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 40px;
        }

        .sub-title {
            font-size: 12px;
            font-weight: bold;
            opacity: 0.4;
        }

        .links>a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        .text-right {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="flex-center position-ref full-height">

        <div class="content">
            <div class="title">
                Capitalia
            </div>
            <div class="sub-title text-right">Versión 1.0</div>
        </div>
    </div>
</body>

</html>