<div class="detalleCotizacion index large-12 medium-9 columns">
    <?php 
    echo $this->Form->select('repuesto', $repuesto,['id'=>'repuesto']);
    echo $this->Form->button('Buscar', ['id'=>'buscar']);
    ?>
    <div id='mensaje'></div>
    <div id='frame' style="display:none">
        <table id="example" class="display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Guia</th>
                    <th>Repuesto</th>
                    <th>Valor Neto</th>
                    <th>Fecha Cotizacion</th>
                    <th>Opciones</th>
                </tr>
            </thead>

            <tfoot>
                <tr>
                    <th>Guia</th>
                    <th>Repuesto</th>
                    <th>Valor Neto</th>
                    <th>Fecha Cotizacion</th>
                    <th>Opciones</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    $("#buscar").click(function() {
        //hasce visible al bloque donde va a ir la tabla
        document.getElementById('frame').style.display="block";
        //el mensaje de error por defecto no existe
        $("#mensaje").html(""); 
        //asigna los valores de marca y de repuesto
        var repuesto=$('#repuesto').val();
        $('#example').dataTable( {
            //invoca el plugin datatables que invocara via ajax los datos necesarios y los formateara en una tabla
            paging:false,
            destroy: true,
            language: {
                lengthMenu:    "Mostrar _MENU_ ",
                search:         "Buscar:",
                infoFiltered:   "",
                info:           "Mostrando _START_ a  _END_ de _TOTAL_ Elementos",
                zeroRecords:    "No Registros encontrados",
                paginate: {
                    first:      "Primera",
                    previous:   "Anterior",
                    next:       "Siguiente",
                    last:       "Ultima"
                },
            },
            "ajax": {
                //esta es la direccion desde donde saldran los datos
                "url": '/backup/sgrepuestos/detalleCotizacion/index',
                "data": {"repuesto":repuesto},
                "error": function ()
                {
                //si hay un error se hace invisible el bloque y se manda un mensaje
                document.getElementById('frame').style.display="none";
                $("#mensaje").html("Cotizacion no Encontrada"); 
            }
        },
        columns: [
        { data: "codigoCotizacion" },
        { data: "codigoRepuesto" },
        { data: "valorNeto" },
        { data: "fechaCotizacion" },
        { data: "Opciones" },
        ],
    });
})
});
</script>