<div class="articulos index large-12 medium-9 columns">
  <table id="example" class="display" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th>Codigo Cotizacion</th>
            <th>Proveedor</th>
            <th>Comprador</th>
            <th>Fecha Cotizacion</th>
            <th>Opciones</th>
        </tr>
    </thead>

    <tfoot>
        <tr>
            <th>Codigo Cotizacion</th>
            <th>Proveedor</th>
            <th>Comprador</th>
            <th>Fecha Cotizacion</th>
            <th>Opciones</th>
        </tr>
    </tfoot>
</table>
</div>
<script type="text/javascript">
$(document).ready(function() {
    //invoca todas las cotizaciones e invoca al plugin datatables que las formateara como tabla
    $('#example').dataTable( {
        language: {
            lengthMenu:    "Mostrar _MENU_ ",
            search:         "Buscar:",
            infoFiltered:   "",
            info:           "Mostrando fila _START_ a  fila _END_ de _TOTAL_ Elementos",
            zeroRecords:    "No se Encontraron Registros",
            paginate: {
                first:      "Primera",
                previous:   "Anterior",
                next:       "Siguiente",
                last:       "Ultima"
            },
        },
        //desde esta direccion se llama a los datos
        "ajax": '/backup/sgrepuestos/cotizacion/index',
        columns: [
        { data: "codigoCotizacion" },
        { data: "codigoEmpresa" },
        { data: "codigoComprador" },
        { data: "fechaCotizacion" },
        { data: "Opciones" },
        ],
        
    } );    
});    
</script>