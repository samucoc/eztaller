<div class="cotizacion index large-10 medium-9 columns">
	<?= $this->Form->input("codigoCotizacion",['label'=>'Ingrese Numero de Guia','id'=>'cod'])?>
	<div id="mensaje"></div>
	<div id="frame" class="cotizacion view large-12 medium-10 columns" style="display:none">
		<?= $this->Html->css('base.css') ?>
		<?= $this->Html->css('cake.css') ?>
		<h2 id="titulo"></h2>
		<div class="row">
			<div class="columns strings">
				<h6 class="subheader"><?= __('Empresa Proveedora') ?></h6>
				<p id="nomEmpresa"></p>
				<h6 class="subheader"><?= __('Empresa Comprante') ?></h6>
				<p id="empComprante"></p>
				<h6 class="subheader"><?= __('Fecha Cotizacion') ?></h6>
				<p id="fechaCotizacion"></p>
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
</div>
<script type="text/javascript">
$(document).ready(function() {
	$("#cod").keyup(function() {
    /*cada vez que el valor de cod cambia se invoca a un ajax
    este ajax busca los datos segun el valor de cod y los agrega a cada parrafo*/
    var valor=cod.value;
    $.ajax({
    	method:("POST"),
    	dataType: "json",
     //en esta direccion se buscan los datos
     url: "/backup/sgrepuestos/cotizacion/busqueda",
     data: { id: valor},
     error: function (){
      //si hay un error se manda un mensaje y se hace invisible el bloque donde esta la tabla
      document.getElementById('frame').style.display="none";
      $("#mensaje").html("No hay cotizaciones Disponibles"); 
  }
}).done(function(data) {
    //se agregan los datos a cada parrafo y se hace visible el bloque
    document.getElementById('frame').style.display="block";
    $("#titulo").html("Guia Nº"+data.codigoCotizacion);
    $("#nomEmpresa").html(data.codigoEmpresa);
    $("#fechaCotizacion").html(data.fechaCotizacion);
    $("#empComprante").html(data.codigoComprador);
    //se llama al plugin datatable que formateara el detalle de la cotizacion
    $('#example').dataTable( {
    	destroy:true,
    	info:false,
    	ordering: false,
    	paging: false,
    	searching: false,
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
        //desde esta direccion se obtienen los datos
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
});
});
</script>
<script>
$(document).ready(function() {
  // cada vez que se borra la informacion de cod se hace invisible el bloque y se borra el mensaje si lo hubiera
  $("#cod").val("");
  $("#cod").keypress(function() {
  	var valor=cod.value;
  	if (valor=" ") {
  		document.getElementById('frame').style.display="none";
  		$("#mensaje").html("");
  	};
  });
});
</script>
<script>
function ImprimeDiv(id)
{
  //copia los datos actuales en una ventana nueva y luego los manda a imprimir
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