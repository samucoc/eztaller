<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <title>Clientes</title>
    <style>
        body {
            padding-hrefp: 20px;
        }

        .menu-container {
            margin: 0 auhref;
            max-width: 800px;
        }
        .table-container {
            display: flex;
            justify-content: center;

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
          <img src="<?php echo $fullUrl; ?>/../../../img/logo0.png" alt="MiApp Logo" width="48" height="48" class="d-inline-block align-hrefp" />
        </a>
        <buthrefn class="navbar-hrefggler" type="buthrefn" data-hrefggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="hrefggle navigation">
          <span class="navbar-hrefggler-icon"></span>
        </buthrefn>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ml-auhref">
            <li class="nav-item">
              <a class="nav-link" href="<?php echo $fullUrl; ?>">Clientes</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="<?php echo $fullUrl; ?>/../despachos">Despachos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo $fullUrl; ?>/../conductores">Conductores</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo $fullUrl; ?>/../vehiculos">Vehiculos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo $fullUrl; ?>/../configuracion">Configuración</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo $fullUrl; ?>/../perfil">Perfil</a>
          </ul>
        </div>
      </div>
    
    <div class="container-fluid">
        <div class="row align-items-center p-5">
            <div class="col">
                <h1>Clientes</h1>
            </div>
            <div class="col-auto ml-auto text-right">
                <button class="btn btn-primary" onclick="openModal()">Agregar Cliente</button>
            </div>
        </div>
    </div>
    <div id="clientModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Agregar Cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form onSubmit={crearOActualizarCliente}>
                        <div class="row">
                        <div class="col-3">
                            Nombre Empresa
                        </div>
                        <div class="col-9">
                                <div class="mb-3">
                                <input type="hidden" class="form-control" placeholder="Nombre Empresa" name="id" onChange={handleChange} />
                                <input type="text" class="form-control" placeholder="Nombre Empresa" name="nombreEmpresa"  onChange={handleChange} />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                            Rut Empresa
                            </div>
                            <div class="col-9">
                                <div class="mb-3">
                                    <input type="text" class="form-control" placeholder="Rut Empresa" name="rutEmpresa"  onChange={handleChange} />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                            Dirección Empresa
                            </div>
                            <div class="col-9">
                                <div class="mb-3">
                                    <input type="text" class="form-control" placeholder="Dirección Empresa" name="direccionEmpresa"  onChange={handleChange} />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-3">
                        Nombre Contacto Empresa
                            </div>
                            <div class="col-9">
                                <div class="mb-3">
                                    <input type="text" class="form-control" placeholder="Nombre Contacto Empresa" name="nombreContactoEmpresa"  onChange={handleChange} />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-3">
                        Teléfono Contacto Empresa
                            </div>
                            <div class="col-9">
                                <div class="mb-3">
                                    <input type="text" class="form-control" placeholder="Teléfono Contacto Empresa" name="telefonoContactoEmpresa"  onChange={handleChange} />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-3">
                        Correo Contacto  Empresa
                            </div>
                            <div class="col-9">
                                <div class="mb-3">
                                    <input type="text" class="form-control" placeholder="Correo Contacto Empresa" name="correoContactoEmpresa"  onChange={handleChange} />
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-3">
                        Nivel Empresa
                            </div>
                            <div class="col-9">
                                <div class="mb-3">
                                    <input type="text" class="form-control" placeholder="Nivel Empresa" name="nivelEmpresa"  onChange={handleChange} />
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Crear</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="table-container">
        <table>
            <thead>
            <tr>
                <th>Nro</th>
                <th>Nombre Empresa</th>
                <th>RUT/DNI</th>
                <th>Dirección</th>
                <th>Nombre de Contacto</th>
                <th>Teléfono de Contacto</th>
                <th>Correo de Contacto</th>
                <th>Nivel</th>
                <th>Acciones</th>
            </tr>
            </thead>
            <tbody>
                <?php foreach($clientes as $cliente): ?>
                <tr>
                    <td><?= $cliente->id; ?></td>
                    <td><?= $cliente->nombreEmpresa; ?></td>
                    <td><?= $cliente->rutEmpresa; ?></td>
                    <td><?= $cliente->direccionEmpresa; ?></td>
                    <td><?= $cliente->nombreContactoEmpresa; ?></td>
                    <td><?= $cliente->telefonoContactoEmpresa; ?></td>
                    <td><?= $cliente->correoContactoEmpresa; ?></td>
                    <td><?= $cliente->nivelEmpresa; ?></td>
                    <td>
                        <button type="button" class="btn btn-primary" onclick="EditarCliente(<?= $cliente->id; ?>)">Editar</button>
                        <button type="button" class="btn btn-danger" onclick="EliminarCliente(<?= $cliente->id; ?>)">Eliminar</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function openModal() {
            $('#clientModal').modal('show');
        }

        function closeModal() {
            $('#clientModal').modal('hide');
        }
        
        function EditarCliente(id) {
            $.ajax({
                url: '<?php echo $fullUrl; ?>/' + id, // Asegúrate de apuntar al controlador y función correctos.
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response) {
                        // Supongo que 'setNuevoCliente' es una función que establece un cliente en un formulario o algo similar.
                        // Tendrías que reescribir o adaptar esa función para trabajar con jQuery.
                        setNuevoCliente(response);
                        openModal();
                    }
                },
                error: function(error) {
                    console.error("Ha ocurrido un error al obtener el cliente: ", error);
                }
            });
        }

        function setNuevoCliente(cliente) {
            // Asume que tienes un formulario con campos para el cliente.
            // Rellena esos campos con la información del cliente.
            $("input[name='id']").val(cliente.id);
            $("input[name='nombreEmpresa']").val(cliente.nombreEmpresa);
            $("input[name='rutEmpresa']").val(cliente.rutEmpresa);
            $("input[name='direccionEmpresa']").val(cliente.direccionEmpresa);
            $("input[name='nombreContactoEmpresa']").val(cliente.nombreContactoEmpresa);
            $("input[name='telefonoContactoEmpresa']").val(cliente.telefonoContactoEmpresa);
            $("input[name='correoContactoEmpresa']").val(cliente.correoContactoEmpresa);
            $("input[name='nivelEmpresa']").val(cliente.nivelEmpresa);
            // Si 'openModal' es una función que muestra un modal, la mantienes como está.
            // Si no, tendrás que implementarla también.
        }


    </script>
</body>

</html>

