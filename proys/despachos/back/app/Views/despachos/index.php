<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <title>Despachos</title>
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
              <a class="nav-link" href="<?php echo $fullUrl; ?>/../clientes">Clientes</a>
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
            </li>
          </ul>
        </div>
      </div>
    
    <div class="container-fluid">
        <div class="row align-items-center p-5">
            <div class="col">
                <h1>Despachos</h1>
            </div>
            <div class="col-auto ml-auto text-right">
                <button class="btn btn-primary" onclick="openModal()">Agregar Despacho</button>
            </div>
        </div>
    </div>
    <!-- Modal Structure -->
    <div class="modal fade" id="despachoModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Agregar Despacho</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="despachoForm">
                        <!-- Fecha Despacho -->
                        <div class="form-group">
                            <input type="date" class="form-control" placeholder="Fecha Despacho" name="fecha" id="fechaDespacho">
                        </div>

                        <!-- Cliente ID -->
                        <div class="form-group">
                            <select class="form-control" name="cliente_id" id="clienteId">
                            <!-- jQuery will populate this dropdown -->
                            </select>
                        </div>

                        <!-- Origen Despacho -->
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Origen Despacho" name="origenDespacho" id="origenDespacho">
                        </div>

                        <!-- Destino Despacho -->
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Destino Despacho" name="destinoDespacho" id="destinoDespacho">
                        </div>

                        <!-- Conductor ID -->
                        <div class="form-group">
                            <select class="form-control" name="conductor_id" id="conductorId">
                            <!-- jQuery will populate this dropdown -->
                            </select>
                        </div>

                        <!-- Vehiculo ID -->
                        <div class="form-group">
                            <select class="form-control" name="vehiculo_id" id="vehiculoId">
                            <!-- jQuery will populate this dropdown -->
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Crear</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Nro Orden</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Origen</th>
                    <th>Destino</th>
                    <th>Conductor</th>
                    <th>Vehiculo</th>
                    <th>Estado Recogido</th>
                    <th>Estado Entregado</th>
                    <th>QR</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($despachos as $despacho): ?>
                <tr>
                    <td><?= $despacho->id; ?></td>
                    <td><?= $despacho->fecha; ?></td>
                    <td><?= $despacho->cliente_id; ?></td>
                    <td><?= $despacho->origenDespacho; ?></td>
                    <td><?= $despacho->destinoDespacho; ?></td>
                    <td><?= $despacho->conductor_id; ?></td>
                    <td><?= $despacho->vehiculo_id; ?></td>
                    <td><?= $despacho->recogido; ?></td>
                    <td><?= $despacho->entregado; ?></td>
                    <td><?= $despacho->id; ?> -- GenerarQR()</td>
                    <td>
                        <button type="button" class="btn btn-primary" onclick="EditarDespacho(<?= $despacho->id; ?>)">Editar</button>
                        <button type="button" class="btn btn-danger" onclick="EliminarDespacho(<?= $despacho->id; ?>)">Eliminar</button>
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
        $(document).ready(function() {

            // Poblar dropdowns usando jQuery (esto es solo un ejemplo)
            let clientes = []; // Aquí irían tus clientes
            clientes.forEach(cliente => {
                $("#clienteId").append(`<option value="${cliente.id}">${cliente.nombreEmpresa}</option>`);
            });

            // Manejar el envío del formulario con jQuery
            $("#despachoForm").submit(function(e) {
                e.preventDefault();
                // Aquí manejas el envío del formulario
            });
        });
        
        function openModal() {
            $('#despachoModal').modal('show');
        }

        function closeModal() {
            $('#despachoModal').modal('hide');
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

