<?php /* Smarty version 2.6.18, created on 2016-04-19 09:41:18
         compiled from sg_informe_porcentaje_asistencia_grafico.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		<?php echo $this->_tpl_vars['xajax_js']; ?>

		
		<title></title>
       <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		
		<!-- validaciones de javascript -->
			<script type="text/javascript" src="../includes_js/funciones.js"></script>
		
		<!-- aqui se puede agregar el cod. para la norma de las páginas... -->
		<link rel="stylesheet" type="text/css" media="all" href="calendario/calendar-brown.css" />
		<!-- librería principal del calendario -->
		<script type="text/javascript" src="calendario/calendar.js"></script>
		<!-- librería para cargar el lenguaje deseado --> 
		<script type="text/javascript" src="calendario/lang/calendar-es.js"></script>
		<!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->
		<script type="text/javascript" src="calendario/calendar-setup.js"></script>
                
                <!-- estilos -->
			<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">
			<LINK href="../estilos/smoothness/jquery-ui-1.10.0.custom.css" type="text/css" rel="stylesheet">	
                            
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-1.9.0.js"></script>
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-ui-1.10.0.custom.js"></script>
                        <script type="text/javascript" src="../includes_js/jquery.maskedinput.1.3.1.js"></script>
                        
		<?php echo '
        <SCRIPT language="javascript">
			function checkAll(theForm, cName, status) {
				for (i=0,n=theForm.elements.length;i<n;i++)
				  if (theForm.elements[i].className.indexOf(cName) !=-1) {
					theForm.elements[i].checked = status;
				  }
				}
			var patron = new Array(2,2,4)
			var patron2 = new Array(1,3,3,3,3)
			function mascara(d,sep,pat,nums){
				if(d.valant != d.value){
					val = d.value
					largo = val.length
					val = val.split(sep)
					val2 = \'\'
					for(r=0;r<val.length;r++){
						val2 += val[r]	
					}
					if(nums){
						for(z=0;z<val2.length;z++){
							if(isNaN(val2.charAt(z))){
								letra = new RegExp(val2.charAt(z),"g")
								val2 = val2.replace(letra,"")
							}
						}
					}
					val = \'\'
					val3 = new Array()
					for(s=0; s<pat.length; s++){
						val3[s] = val2.substring(0,pat[s])
						val2 = val2.substr(pat[s])
					}
					for(q=0;q<val3.length; q++){
						if(q ==0){
							val = val3[q]
						}
						else{
							if(val3[q] != ""){
								val += sep + val3[q]
								}
						}
					}
					d.value = val
					d.valant = val
					}
				}			
		</SCRIPT>
        <script type="text/javascript">
			$(function($) { 
				$(\'#txtFecha1\').mask("99/99/9999");
				$(\'#txtFecha2\').mask("99/99/9999");
				}
			); 		
		</script>
		<script type="text/javascript">
			$(document).ready(function() { 
                            $.datepicker.regional[\'es\'] = {
                                  closeText: \'Cerrar\',
                                  prevText: \'<Ant\',
                                  nextText: \'Sig>\',
                                  currentText: \'Hoy\',
                                  monthNames: [\'Enero\', \'Febrero\', \'Marzo\', \'Abril\', \'Mayo\', \'Junio\', \'Julio\', \'Agosto\', \'Septiembre\', \'Octubre\', \'Noviembre\', \'Diciembre\'],
                                  monthNamesShort: [\'Ene\',\'Feb\',\'Mar\',\'Abr\', \'May\',\'Jun\',\'Jul\',\'Ago\',\'Sep\', \'Oct\',\'Nov\',\'Dic\'],
                                  dayNames: [\'Domingo\', \'Lunes\', \'Martes\', \'Miércoles\', \'Jueves\', \'Viernes\', \'Sábado\'],
                                  dayNamesShort: [\'Dom\',\'Lun\',\'Mar\',\'Mié\',\'Juv\',\'Vie\',\'Sáb\'],
                                  dayNamesMin: [\'Do\',\'Lu\',\'Ma\',\'Mi\',\'Ju\',\'Vi\',\'Sá\'],
                                  weekHeader: \'Sm\',
                                  dateFormat: \'dd/mm/yy\',
                                  firstDay: 1,
                                  isRTL: false,
                                  showMonthAfterYear: false,
                                  yearSuffix: \'\'};
                           $.datepicker.setDefaults($.datepicker.regional[\'es\']);                            
                            $(\'#txtFecha1,#txtFecha2\').datepicker({
                                  showOn: "button",
                                  buttonImage: "../images/calendario.png",
                                  buttonImageOnly: true,
                                  dateFormat : "dd/mm/yy"
                                });
							 $("#OBLI-cboAlumno").autocomplete({
                                source : \'busquedas/busqueda_alumno.php\',
                                select: function( event, ui ) {
                                    var rut = ui.item.id;
                                    document.getElementById(\'OBLIRutAlumno\').value = rut;
                                    }
                                });
                             
                            });
		</script>
		<script type="text/javascript" > 
                        function verificaValor(temp){
                            if (temp==\'\'){
                                document.getElementById(\'OBLI-txtCodCobrador\').value="";
                                }
                            }
			function ImprimeDiv(id)
			{
					var c, tmp;
				
				  	c = document.getElementById(id);
					  
				   	temp = window.open(" ","Impresion.");
				  
				   	temp.document.open();
				   	temp.document.write(\'<head><link href="../estilos/estilo.css" type="text/css" rel="stylesheet"/></head>\'); //Esto es omitible
				   	temp.document.write(c.innerHTML);
				   	temp.document.close();
					  
				   	var is_chrome = function () { return Boolean(temp.chrome); }
					if(is_chrome) {
							setTimeout(function () { // wait until all resources loaded 
								temp.print();  // change window to winPrint
					            temp.close();// change window to winPrint
					        }, 100);
						}
					else{
					   	temp.print();
					   	temp.close();
					}
			}
			function exportar_excel(id_form, id_tabla)
			{
				 // Obtiene el contenido de la tabla indicada
				 var tabla = $("#" + id_tabla).html();
				 // Añade los tags de tabla
				 tabla = "<table>" + tabla + "</table>";
				 // Almacena en el campo oculto los datos a exportar
				 $("#datos_a_enviar").val( tabla );
				 // Activa el formulario, el cual lanza el código en PHP
				 $("#" + id_form).submit();
			}

 		</script> 
		<!-- Load the AJAX API -->
		<script type="text/javascript" src="https://www.google.com/jsapi" > </script>
		<script type="text/javascript" src="https://www.google.com/jsapi?autoload={\'modules\':[{\'name\':\'visualization\',\'version\':\'1\',\'packages\':[\'corechart\']}]}">
		</script>
		'; ?>


		<script type="text/javascript">
				var anio = <?php echo $this->_tpl_vars['anio']; ?>
;
				var periodo = <?php echo $this->_tpl_vars['periodo']; ?>
;
				<?php echo '
		 	
		 	google.setOnLoadCallback(dibujaGrafica);
			 
			/* función de carga de datos, recogemos los datos cargados en el primer 
			archivo (argaDatos.php) mediante AJAX y lo almacenamos en la variable data */
			function dibujaGrafica() {
			 
			var data = $.ajax({
						url: "busquedas/grafico.php?anio="+anio+\'&periodo=\'+periodo,
						dataType:"json",
						async: false
						}).responseText;
			 
			//para que se lea correctamente el array enviado por JSON usamos JSON.parse
			var infoGraf = JSON.parse(data);
			 
			//Creamos y rellenamos la tabla de datos
			var datoFinal = google.visualization.arrayToDataTable(infoGraf);
			 
			//en la parte de options puede personalizarse la gráfica, como títulos, colores...
			 var options = {
		        title: \'Porcentajes de Asistencia\',
		        legend: { position: \'top\', maxLines: 3 },
                
          		bar: {groupWidth: \'95%\'},
		        hAxis: {
		          title: \'Cursos\',
		          gridlines: { count: 10 }
		        },
		        vAxis: {
		          title: \'Porcentajes\'
		        },
			  \'is3D\':true,
			  \'width\':1200,
			  \'height\':300
		      };

      var chart = new google.visualization.ColumnChart(
        document.getElementById(\'chart_div\'));

			chart.draw(datoFinal, options);
			}
		</script>
		'; ?>

	
	</HEAD>
	<body > 
	<!--<body style="background:#ffffff;"> -->
		
		<div id='chart_div' style="width: 1200px; height: 300px"><div>
		
	</body>
</HTML>