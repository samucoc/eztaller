<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		{$xajax_js}
		
		<title> Informe de Precargas </title>
       <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		
		<!-- librerias para popup submodal -->
			<link rel="stylesheet" type="text/css" href="submodal/subModal.css" /> 
			<script type="text/javascript" src="submodal/common.js"></script>
			<script type="text/javascript" src="submodal/subModal.js"></script>
		
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
		
		<!-- validaciones de javascript -->
			<script type="text/javascript" src="../includes_js/funciones.js"></script>
		
		<!-- mascara para fecha -->
			<script type="text/javascript" src="../includes_js/jquery-1.4.2.min.js"></script>
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-1.9.0.js"></script>
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-ui-1.10.0.custom.js"></script>
			<script type="text/javascript" src="../includes_js/jquery.maskedinput.1.3.1.js"></script>
					
			<LINK href="../estilos/smoothness/jquery-ui-1.10.0.custom.css" type="text/css" rel="stylesheet">	

		{literal}
		<SCRIPT language="javascript">
       		$(document).ready(function() { 
            	$('#txtFechaInicio').mask("99/99/9999");
            	$('#txtFechaFin').mask("99/99/9999");
            	$("#trabajador").autocomplete({
                  source : 'busquedas/busqueda_persona.php',
                  select: function( event, ui ) {
                      var rut = ui.item.id;
                      document.getElementById('txtTrabajador').value = rut;
                      }
                  });
                $( "#exportarexcel" ).button().click(function() {
                  var test = $('#divlistado');
                  window.open('data:application/vnd.ms-excel,' + 
                        encodeURIComponent(test[0].outerHTML));
                  });
          });                        

     var patron = new Array(2,2,4)
      var patron2 = new Array(1,3,3,3,3)
      function mascara(d,sep,pat,nums){
        if(d.valant != d.value){
          val = d.value
          largo = val.length
          val = val.split(sep)
          val2 = ''
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
          val = ''
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
      function checkAll(theForm, cName, status) {
        for (i=0,n=theForm.elements.length;i<n;i++)
          if (theForm.elements[i].className.indexOf(cName) !=-1) {
          theForm.elements[i].checked = status;
          }
        }

    </SCRIPT>
    
		<script type="text/javascript" > 
			function limpiar(){
        var temp = document.getElementById('trabajador').value;
        if (temp==''){
            document.getElementById('rut_trab').value="";
            }
          } 
			function ImprimeDiv(id)
			{
					var c, tmp;
				
				   c = document.getElementById(id);
					  
				   tmp = window.open(" ","Impresión.");
				  
				   tmp.document.open();
				   tmp.document.write('<head><link href="../estilos/estilo.css" type="text/css" rel="stylesheet"/></head>'); //Esto es omitible
				   tmp.document.write(c.innerHTML);
				   tmp.document.close();
				   tmp.print();
				   tmp.close();
			}
			
			function enviaPivotExcel(nombreformulario)
			{
			document.forms[nombreformulario].elements['v_pivot_excel'].value=document.getElementById('pivot').innerHTML;
			document.getElementById(nombreformulario).target = 'iframe_pivot_excel'; 
			document.getElementById(nombreformulario).method="post";
			document.getElementById(nombreformulario).action="pivot_excel.php";
			document.getElementById(nombreformulario).submit();
			}	
			
		 function enviaBuscar(nombreformulario)
			{
			document.getElementById('pivot').innerHTML="";document.getElementById('pivot_filter').innerHTML="";document.getElementById('div_grafico').innerHTML="";
			document.getElementById(nombreformulario).target =""; 
			document.getElementById(nombreformulario).method="";
			document.getElementById(nombreformulario).action="";
			document.getElementById(nombreformulario).submit();
			}
		function sumar(todos){
        	var elemento = document.getElementById(todos).checked;
        	var res = todos.split("_"); 
          	
	        if (elemento==true){
	        		if (document.getElementById("arr_folios").value!='') 
	            		document.getElementById("arr_folios").value = document.getElementById("arr_folios").value +','+res[0];
	          		else
	            		document.getElementById("arr_folios").value = res[0];  
	          
	          		if (document.getElementById("arr_folios_vdet").value!='') 
	            		document.getElementById("arr_folios_vdet").value = document.getElementById("arr_folios_vdet").value +','+res[1];
	          		else
	            		document.getElementById("arr_folios_vdet").value = res[1];  
	          
	          }
	        else{
	          
		          var arr  = document.getElementById("arr_folios").value.split(",");
		          var posBorrar=arr.indexOf(res[0]);
		          
		          arr.splice(posBorrar, 1);
		          document.getElementById("arr_folios").value = arr.join(",");
	          		
	          		arr.splice(posBorrar, 1);
		         	document.getElementById("arr_folios_vdet").value = arr.join(",");
	          
	        	}
	    	}
		</script> 
		{/literal}
	</HEAD>
	<body style="background:#ffffff;"> 
					
		<form id="Form1" name="Form1" method="post" runat="server">
			<div id="divcontenedor" align="left" style="margin-left:2px; padding: 2px;">
			
				<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
					<tr>
						<td>
							<table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
								<tr align="left">
									<td colspan='2'>
										<div id='divresultado'></div>
									</td>
								</TR>
							</table>
						</td>
					</tr>
				</table>
				
			</div>
		</form>
	</body>
</HTML>