<!DOCTYPE html>

<html>

	<head>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />

		<title></title>

	</head>

	<body>

		<div id="container" style="min-height: 600px; max-height: 1200px; width: 1150px; margin: 0 auto"></div>

	</body>

	<script src="https://code.highcharts.com/highcharts.js"></script>

	<script src="https://code.highcharts.com/modules/exporting.js"></script>

	<script type="text/javascript">

		Highcharts.chart('container', {

		    chart: {

		        type: 'column'

		    },

		    title: {

		        text: 'Estadística de Recaudación Anual'

		    },

		    subtitle: {

		    	<?php 

		    	echo "text: 'Período ".$_GET['anio']."'";

		       	?>

		    },

		    xAxis: {

		        categories: [

		        			'Enero ','Febrero',

		        			'Marzo','Abril',

		        			'Mayo','Junio',

		        			'Julio','Agosto',

		        			'Septiembre','Octubre',

		        			'Noviembre','Diciembre'

		        			],

		        title: {

		            text: null

		        }

		    },

		    yAxis: {

		        min: 0,

		        title: {

		            text: 'Pesos',

		            align: 'high'

		        },

		        labels: {

		            overflow: 'justify'

		        }

		    },

		    tooltip: {

		        valueSuffix: ' pesos'

		    },

		    plotOptions: {

		        bar: {

		            dataLabels: {

		                enabled: true

		            }

		        }

		    },

	   	    legend: {

		        layout: 'vertical',

		        align: 'right',

		        verticalAlign: 'top',

		        x: -40,

		        y: 80,

		        floating: true,

		        borderWidth: 1,

		        backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'),

		        shadow: true

		    },

		    credits: {

		        enabled: false

		    },

		    series: [

		    	<?php 

		    		include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

		        	global $conexion;

					    

					/*	

					$sql_boletas = "select distinct nombre

									from gescolcl_arcoiris_administracion.TipoPagoBoleta";

					$res_boletas = mysql_query($sql_boletas,$conexion) or die(mysql_error());

					$str = "";

					while($row_boletas = mysql_fetch_array($res_boletas)){

						$str .= "{";

						$str .=  "name: '".$row_boletas['nombre']."',";

						$str .=  "data: [";

						for($i = 1; $i<=12 ; $i++){

							$sql_boletas_1 = "select year(FechaBoleta), month(FechaBoleta) ,COALESCE(sum(ValorBoleta),0) as ValorBoleta

									from gescolcl_arcoiris_administracion.Movimientos

										inner join gescolcl_arcoiris_administracion.TipoPagoBoleta

											on Movimientos.TipoPagoBoleta = TipoPagoBoleta.tpb_ncorr

									where nombre = '".$row_boletas['nombre']."' and 

										year(FechaBoleta) = '".$_GET['anio']."' and 

										month(FechaBoleta) = '".$i."' and

										EstadoBoleta = '1'

									group by year(FechaBoleta), month(FechaBoleta) , TipoPagoBoleta, nombre

											";

							$res_boletas_1  = mysql_query($sql_boletas_1 ,$conexion) or die(mysql_error());

							if (mysql_num_rows($res_boletas_1)>0){

								while($row_boletas_1  = mysql_fetch_array($res_boletas_1 )){

									$str .=  $row_boletas_1 ['ValorBoleta'].',';

									}

								}

							else{

									$str .=  '0,';

								}

							}

						$str = substr($str, 0,strlen($str)-1);

						$str .=  "]";

						$str .=  "},";

						}

					*/

					$anios = explode(',',$_GET['anio']);

					foreach ($anios as $anio) {

						$str .= "{";

						$mes_ele="";

						$str .=  "name: '".$anio."',";

						$str .=  "data: [";

						for($i = 1; $i<=12 ; $i++){

							$sql_boletas_1 = "select year(FechaBoleta), month(FechaBoleta) ,COALESCE(sum(ValorBoleta),0) as ValorBoleta

									from gescolcl_arcoiris_administracion.Movimientos

										inner join gescolcl_arcoiris_administracion.TipoPagoBoleta

											on Movimientos.TipoPagoBoleta = TipoPagoBoleta.tpb_ncorr

									where year(FechaBoleta) in (".$anio.") and 

											month(FechaBoleta) = '".$i."' and

										EstadoBoleta = '1'

									group by year(FechaBoleta), month(FechaBoleta)

											";

							$res_boletas_1  = mysql_query($sql_boletas_1 ,$conexion) or die(mysql_error());

							if (mysql_num_rows($res_boletas_1)>0){

								while($row_boletas_1  = mysql_fetch_array($res_boletas_1 )){

									$str .=  $row_boletas_1 ['ValorBoleta'].',';

									}

								}

							else{

									$str .=  '0,';

								}

							}

						$str = substr($str, 0,strlen($str)-1);

						$str .=  "]";

						$str .=  "},";

					}

					$str = substr($str, 0,strlen($str)-1);

					echo $str;

				?>

		    ],

		    exporting: {

				        url: 'http://export.highcharts.com/index-utf8-encode.php'

				}

		});



	</script>

</html>