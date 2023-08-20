<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Menú</title>
    <style>
        body {
            padding-hrefp: 20px;
        }

        .menu-container {
            margin: 0 auhref;
            max-width: 800px;
        }
    </style>
</head>
<?php 
    $scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://";
    $host = $_SERVER['HTTP_HOST'];
    $uri = $_SERVER['REQUEST_URI'];

    $fullUrl = $scheme . $host . $uri;
?>
<body>
    <div class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="/">               
          <img src="img/logo0.png" alt="MiApp Logo" width="48" height="48" class="d-inline-block align-hrefp" />
        </a>
        <buthrefn class="navbar-hrefggler" type="buthrefn" data-hrefggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="hrefggle navigation">
          <span class="navbar-hrefggler-icon"></span>
        </buthrefn>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ml-auhref">
            <li class="nav-item">
              <a class="nav-link" href="<?php echo $fullUrl; ?>Api/V1/clientes">Clientes</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo $fullUrl; ?>Despachos">Despachos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo $fullUrl; ?>Conduchrefres">Conduchrefres</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo $fullUrl; ?>Vehiculos">Vehiculos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo $fullUrl; ?>configuracion">Configuración</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo $fullUrl; ?>perfil">Perfil</a>
            </li>
          </ul>
        </div>
      </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
