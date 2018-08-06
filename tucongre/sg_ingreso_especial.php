<!DOCTYPE html>
<html>
<head>
	<title>Tu Congre v0.1</title>
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

	<style type="text/css">
		html, body {
		   height: 100%;
		}

		body {
		    overflow-x:hidden;
		}

		.wrapper, .row {
		   height: 100%;
		   margin-left:0;
		   margin-right:0;
		}

		.wrapper:before, .wrapper:after,
		.column:before, .column:after {
		    content: "";
		    display: table;
		}

		.wrapper:after,
		.column:after {
		    clear: both;
		}

		#sidebar {
		    background-color: #eee;
		    padding-left: 0;
		    float: left;
		    min-height: 100%;
		}

		#sidebar .collapse.in {
		    display: inline;
		}

		#sidebar > .nav>li>a {
		    white-space: nowrap;
		    overflow: hidden;
		}

		#main {
		    padding: 15px;
		    left: 0;
		}

		/*
		 * off canvas sidebar
		 * --------------------------------------------------
		 */
		@media screen and (max-width: 768px) {
		    #sidebar {
		        min-width: 44px;
		    }
		    
		    #main {
		        width: 1%;
		        left: 0;
		    }
		    
		    #sidebar .visible-xs {
		       display:inline !important;
		    }
		    
		    .row-offcanvas {
		       position: relative;
		       -webkit-transition: all 0.4s ease-in-out;
		       -moz-transition: all 0.4s ease-in-out;
		       transition: all 0.4s ease-in-out;
		    }
		    
		    .row-offcanvas-left.active {
		       left: 45%;
		    }
		    
		    .row-offcanvas-left.active .sidebar-offcanvas {
		       left: -45%;
		       position: absolute;
		       top: 0;
		       width: 45%;
		    }
		} 
		 
		 
		@media screen and (min-width: 768px) {
		  .row-offcanvas {
		    position: relative;
		    -webkit-transition: all 0.25s ease-out;
		    -moz-transition: all 0.25s ease-out;
		    transition: all 0.25s ease-out;
		  }

		  .row-offcanvas-left.active {
		    left: 3%;
		  }

		  .row-offcanvas-left.active .sidebar-offcanvas {
		    left: -3%;
		    position: absolute;
		    top: 0;
		    width: 3%;
		    text-align: center;
		    min-width:42px;
		  }
		  
		  #main {
		    left: 0;
		  }
		}

	</style>
</head>
<body>
	<div class="wrapper">
	    <div class="row row-offcanvas row-offcanvas-left">
	        <!-- sidebar -->
	        <div class="column col-sm-3 col-xs-1 sidebar-offcanvas" id="sidebar">
	        	<?php include('class/nav.php'); ?>
	        </div>
	        <!-- /sidebar -->

	        <!-- main right col -->
	        <div class="column col-sm-9 col-xs-11" id="main">
				<form >
	        	<h3>Ingreso Solicitud Especial</h3>
	        	<br>
	            <?php 
	            	include('class/conexion.php');
					// ¡Oh, no! Existe un error 'connect_errno', fallando así el intento de conexión
					if ($mysqli->connect_errno) {
					    // La conexión falló. ¿Que vamos a hacer? 
					    // Se podría contactar con uno mismo (¿email?), registrar el error, mostrar una bonita página, etc.
					    // No se debe revelar información delicada

					    // Probemos esto:
					    echo "Lo sentimos, este sitio web está experimentando problemas.";

					    // Algo que no se debería de hacer en un sitio público, aunque este ejemplo lo mostrará
					    // de todas formas, es imprimir información relacionada con errores de MySQL -- se podría registrar
					    echo "Error: Fallo al conectarse a MySQL debido a: \n";
					    echo "Errno: " . $mysqli->connect_errno . "\n";
					    echo "Error: " . $mysqli->connect_error . "\n";
					    
					    // Podría ser conveniente mostrar algo interesante, aunque nosotros simplemente saldremos
					    exit;
					}
	            ?>
	            <div class="row">
	            	<div class="col-sm-3 col-xs-3" >
	            		Fecha
	            	</div>
	            	<div class="col-sm-9 col-xs-9" >
	            		<input type="text" name="calendar" id="calendar" class="form-control">
	            	</div>
	            </div>
	            
	        </div>
	        <!-- /main -->
	    </div>
	</div>

	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script type="text/javascript">
		/* off-canvas sidebar toggle */
		$('[data-toggle=offcanvas]').click(function() {
		    $('.row-offcanvas').toggleClass('active');
		    $('.collapse').toggleClass('in').toggleClass('hidden-xs').toggleClass('visible-xs');
		});
		$(document).ready(function(){
            $.datepicker.regional['es'] = {
                  closeText: 'Cerrar',
                  prevText: '<Ant',
                  nextText: 'Sig>',
                  currentText: 'Hoy',
                  monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                  monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
                  dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                  dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
                  dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
                  weekHeader: 'Sm',
                  dateFormat: 'dd/mm/yy',
                  firstDay: 1,
                  isRTL: false,
                  showMonthAfterYear: false,
                  yearSuffix: ''};
	        $.datepicker.setDefaults($.datepicker.regional['es']);                            
			$('#calendar').datepicker();

		});
			
	</script>

</body>
</html>