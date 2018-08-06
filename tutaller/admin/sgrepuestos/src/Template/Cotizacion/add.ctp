<div class="cotizacion form large-12 medium-9 columns">
	<?= $this->Form->create($cotizacion) ?>
	<fieldset id="campos">
		<legend><?= __('Agregar Cotizacion') ?></legend>
		<?php
		echo $this->Form->input('nomEmpresa',['id'=>'empresa' ,'label'=>'Nombre de Empresa']);
		echo "<div class='input required'><label for='Empresa Comprante'>Empresa Comprante</label></div>";
		echo $this->Form->select('codigoComprador', $options,['required'=>'required','empty' => 'Escoja una Empresa']);
		echo $this->Form->hidden('codigoEmpresa',["id"=>"emp"]);
		echo $this->Form->input('Fecha_Transaccion',['type'=>'text','id'=>'datepicker',"required"=>"required"]);
		?>
		<table>
			<thead>
				<tr>
					<th>Codigo Repuesto</th>
					<th>Nombre Repuesto</th>
					<th>Valor Bruto</th>
					<th>IVA</th>
					<th>Valor Neto</th>
					<th><button style="padding:0.5rem;margin:0px;" id="agregar">Nuevo Producto</button></th>
				</tr>
			</thead>
			<tbody id="repuestos">
				<input type="hidden" id="cant" name="cant">
				<tr>
					<td><input type="text" id="codRepuesto_1" name="codRepuesto_1" required="required"></td>
					<td><input id="prod1" required="required" type="text"></td>
					<td><input id="bruto_1" name="ValorBruto_1" required="required" type="text"></td>
					<td><input id="ivy_1" name="IVA_1" required="required" type="text"></td>
					<td><input id="cesar_1" name="ValorNeto_1" required="required" type="text"></td>
				</tr>
			</tbody>
		</table>
	</fieldset>
	<?= $this->Form->button(__('Aceptar')) ?> 
	<?= $this->Form->end() ?>
</div>
<script type="text/javascript">
//invoca al plugin datepicker
$(document).ready(function(){
    $("#datepicker").datepicker({
      defaultDate:'yy-mm-dd'
    }).datepicker('setDate', new Date());
  });
</script>
<script>
$(document).ready(function(){
	$("#empresa").autocomplete({
		source:"/backup/sgrepuestos/cotizacion/findProveedor",
		minLength: 2,
		select: function(event,ui)
		{
			$("#emp").val(ui.item.mcod);
		}
	});
});
</script>
<script>
/*agrega el detalle de repuestos el id de cada uno de ellos se diferencia por num que es un correlacional
cada vez que se hace click en el boton agregar se agrega un linea de detalle nueva y num se incrementa en 1*/
$(document).ready(function(){
	var num=1;
	$("#cant").val(num);
	$("#agregar").click(function(event) {
		num++;
		var detalle='<tr><td><input id="codRepuesto_'+num+'" name="codRepuesto_'+num+'" required="required" type="text"></td><td><input id="prod'+num+'" required="required" type="text"></td><td><input id="bruto_'+num+'" name="ValorBruto_'+num+'" required="required" type="text"></td><td><input id="ivy_'+num+'" name="IVA_'+num+'" required="required" type="text"></td><td><input id="cesar_'+num+'" name="ValorNeto_'+num+'" required="required" type="text"></td></tr>';
		event.preventDefault();
		$("#repuestos").append(detalle);
		$("#cant").val(num);
		//se le asigna el script de busqueda de nombre segun numero a la nueva linea de detalle
		$("#codRepuesto_"+num).keyup(function() {
			$("#prod"+num).val("");
			$.ajax({
				method:("POST"),
				dataType: "json",
				url: "/backup/sgrepuestos/cotizacion/nomP",
				data: { cod: $("#codRepuesto_"+num).val()}
			}).done(function(data) {
				$("#prod"+num).val(data.TA_BUSQUEDA);
			})
		});
		// autocalcula el valor neto y el iva desde el bruto
		$("#bruto_"+num).change(function() {
			var brut=$("#bruto_"+num).val();
			var net=(brut/1.19).toFixed();
			$("#cesar_"+num).val(net);
			var ivy=brut-net;
			$("#ivy_"+num).val(ivy);

		})
	});  
});
</script>
<script type="text/javascript">
//invoca los nombres de los repuestos para el plugin autocompletar
$(document).ready(function(){
	$("#prod"+$("#cant").val()).autocomplete({
		source:"/backup/sgrepuestos/cotizacion/find",
		minLength: 2,        
		select: function(event,ui)
		{
			$("#codRepuesto_"+$("#cant").val()).val(ui.item.mid);
		}
	});
});
</script>
<script type="text/javascript">
//calcula el iva y el neto desde el valor bruto
$(document).ready(function() {
	$("#bruto_1").change(function() {
		var brut=$("#bruto_1").val();
		var net=(brut/1.19).toFixed();
		$("#cesar_1").val(net);
		var ivy=brut-net;
		$("#ivy_1").val(ivy);
	})
});
</script>
<script type="text/javascript">
$(document).ready(function() {
	$("#codRepuesto_1").keyup(function() {
		$("#prod1").val("");
		$.ajax({
			method:("POST"),
			dataType: "json",
			url: "/backup/sgrepuestos/cotizacion/nomP",
			data: { cod: $("#codRepuesto_1").val()}
		}).done(function(data) {
			$("#prod1").val(data.TA_BUSQUEDA);        
		})
	})
});
</script>