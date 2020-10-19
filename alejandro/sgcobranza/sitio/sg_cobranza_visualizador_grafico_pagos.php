<!DOCTYPE html>

<html>

	<head>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />

		<title></title>

	</head>

	<body>

		<div id="container" style="min-height: 600px; max-height: 1200px; width: 3600px; margin: 0 auto"></div>

	</body>

	<script src="https://code.highcharts.com/highcharts.js"></script>

	<script src="https://code.highcharts.com/modules/exporting.js"></script>

	<script type="text/javascript">

		Highcharts.chart('container', {

		    chart: {

		        type: 'column'

		    },

		    title: {

		        text: 'Estadística de Recaudación Mensual'

		    },

		    subtitle: {

		    	<?php 

		    	$mes = $_GET['mes'];

		    	$mes_ele="";

		    	if ($mes== '1'){

		    			$mes_ele = 'Enero';

		    			}

		    	elseif ($mes=='2'){

		    			$mes_ele = 'Febrero';

		    			}

		    	elseif ($mes=='3'){

		    			$mes_ele = 'Marzo';

		    			}

		    	elseif ($mes=='4'){

		    			$mes_ele = 'Abril';

		    			}

		    	elseif ($mes=='5'){

		    			$mes_ele = 'Mayo';

		    			}

		    	elseif ($mes=='6'){

		    			$mes_ele = 'Junio';

		    			}

		    	elseif ($mes=='7'){

		    			$mes_ele = 'Julio';

		    			}

		    	elseif ($mes=='8'){

		    			$mes_ele = 'Agosto';

		    			}

		    	elseif ($mes=='9'){

		    			$mes_ele = 'Septiembre';

		    			}

		    	elseif ($mes=='10'){

		    			$mes_ele = 'Octubre';

		    			}

		    	elseif ($mes=='11'){

		    			$mes_ele = 'Noviembre';

		    			}

		    	elseif ($mes=='12'){

		    			$mes_ele = 'Diciembre';

		    			}

		        echo "text: 'Período ".$mes_ele." de ".$_GET['anio']."'";

		       	?>

		    },

		    xAxis: {

		        categories: [

		        	<?php 

		        		include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

		        		global $conexion;

					    

						$anio = $_GET['anio'];

						$mes = $_GET['mes'];

						$str="";

						$t = date("t",mktime(0,0,0,$mes,1,$anio));

						for($i = 1; $i<=$t ; $i++){

							$str .=  "'".$i."/".$mes."/".$anio."',";

							}

						$str = substr($str, 0,strlen($str)-1);

						echo $str;

		        	?>

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

					$sql_boletas = "select distinct nombre

									from gescolcl_arcoiris_administracion.Movimientos

										inner join gescolcl_arcoiris_administracion.TipoPagoBoleta

											on Movimientos.TipoPagoBoleta = TipoPagoBoleta.tpb_ncorr

									where year(FechaBoleta) = '".$anio."' and month(FechaBoleta) = '".$mes."' 

									group by nombre";

					$res_boletas = mysql_query($sql_boletas,$conexion) or die(mysql_error());

					$str = "";

					while($row_boletas = mysql_fetch_array($res_boletas)){

						$str .= "{";

						$str .=  "name: '".$row_boletas['nombre']."',";

						$str .=  "data: [";

						$t = date("t",mktime(0,0,0,$mes,1,$anio));

						for($i = 1; $i<=$t ; $i++){

							$sql_boletas_1 = "select FechaBoleta, COALESCE(sum(ValorBoleta),0) as ValorBoleta

									from gescolcl_arcoiris_administracion.Movimientos

										inner join gescolcl_arcoiris_administracion.TipoPagoBoleta

											on Movimientos.TipoPagoBoleta = TipoPagoBoleta.tpb_ncorr

									where nombre = '".$row_boletas['nombre']."' and 

										FechaBoleta = '".$anio."-".$mes."-".$i."' and

										EstadoBoleta = '1'

									group by TipoPagoBoleta asc, nombre

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