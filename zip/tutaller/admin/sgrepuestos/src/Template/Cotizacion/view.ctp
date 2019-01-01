<div id="frame" class="cotizacion view large-10 medium-9 columns">
    <?= $this->Html->css('base.css') ?>
    <?= $this->Html->css('cake.css') ?>
    <h2>Cotizacion Nº <?= h($cotizacion->codigoCotizacion) ?></h2>
    <div class="row">
        <div class="columns strings">
            <h6 class="subheader"><?= __('Codigo Cotizacion') ?></h6>
            <p><?= h($cotizacion->codigoCotizacion) ?></p>
            <?=$this->Form->hidden('cod',["id"=>"cod", "value"=>$cotizacion->codigoCotizacion])?>
            <h6 class="subheader"><?= __('Empresa Proveedora') ?></h6>
            <p><?= h($cotizacion->codigoEmpresa) ?></p>
            <h6 class="subheader"><?= __('Empresa Compradora') ?></h6>
            <p><?= h($cotizacion->codigoComprador) ?></p>
            <h6 class="subheader"><?= __('Fecha Cotizacion') ?></h6>
            <p><?= h($cotizacion->fechaCotizacion) ?></p>
            <table id="example" class="display" cellspacing="0" width="100%">
                <thead>
                    <tr>
                        <th>Nombre Repuesto</th>
                        <th>Valor Bruto</th>
                        <th>IVA</th>
                        <th>Valor Neto</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
        //busca el detalle de la cotizacion e invoca al plugin datatables que lo formateara como tabla
        $(document).ready(function() {
            var valor=$("#cod").val();
            $('#example').dataTable( {
                "info":false,
                "ordering": false,
                "paging": false,
                "searching": false,
                language: {
                    lengthMenu:    "Mostrar _MENU_ ",
                    search:         "Buscar:",
                    info:           "Mostrando _START_ a  _END_ de _TOTAL_ Elementos",
                    zeroRecords:    "No se Encontraron Registros",
                    paginate: {
                        first:      "Primera",
                        previous:   "Anterior",
                        next:       "Siguiente",
                        last:       "Ultima"
                    },
                },
                "ajax": {
                    //desde esta direccion se invoca los detalles de la cotizacion
                    "url": "/backup/sgrepuestos/detalle_cotizacion/relleno",
                    "type": "POST",
                    "data": {"term":valor},
                },
                columns: [
                { data: "codigoRepuesto" },
                { data: "valorBruto" },
                { data: "IVA" },
                { data: "valorNeto" },
                ],

            } );    
});    
</script>
<script>
function ImprimeDiv(id)
{
    //crea una ventana nueva le asigna los datos que ya existian en el bloque frame y lo imprime
    var c, tmp;
    c = document.getElementById(id);
    tmp = window.open(" ","Impresión.");
    tmp.document.open();
    tmp.document.write(c.innerHTML);
    tmp.document.close();
    tmp.print();
    tmp.close();
}
</script>