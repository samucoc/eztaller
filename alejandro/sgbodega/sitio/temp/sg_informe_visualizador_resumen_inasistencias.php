<!DOCTYPE html>
<html>
	<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<title></title>
	</head>
	<body>
		<div id="container" style="min-width: 310px; max-width: 1200px; height: 2400px; margin: 0 auto"></div>
	</body>
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
	<script type="text/javascript">
		Highcharts.chart('container', {
		    chart: {
		        type: 'column'
		    },
		    title: {
		        text: 'Resumen Inasistencias'
		    },
		    xAxis: {
		        categories: [
		        	<?php 
		        		include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
		        		global $conexion;
					    
						$sql_ve = "select  NombreCurso, CodigoCurso from Cursos	where Cursos.CodigoCurso < '399' 	";
	
						$res_ve = mysql_query($sql_ve, $conexion);
						while ($line_ve = mysql_fetch_row($res_ve)){
							$str .=  "'".$line_ve[0]."',";
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
		            text: 'Inasistencias',
		            align: 'high'
		        },
		        labels: {
		            overflow: 'justify'
		        }
		    },
		    tooltip: {
		        valueSuffix: ''
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
					$anio = $_GET['anio'];
					$str='';
					for($mes='3';$mes<=12;$mes++){
						$mes_ele="";
				    	if ($mes=='3'){
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
						$str .= "{";
						$str .=  "name: '".$mes_ele."',";
						$str .=  "data: [";
						$sql_ve = "select  NombreCurso, CodigoCurso from Cursos	where Cursos.CodigoCurso < '399' ";
	
						$res_ve = mysql_query($sql_ve, $conexion);
						while ($line_ve = mysql_fetch_row($res_ve)){
							$select_notas = "select COALESCE(count(NumeroRutAlumno),0) as contador, month(FechaInasistencia) as mes
									from Inasistencias
									where  NumeroRutAlumno in (select NumeroRutAlumno
																from alumnos".$anio."
																where CodigoCurso = '".$line_ve[1]."' )
									and month(FechaInasistencia) = '".$mes."' 
									AND year(FechaInasistencia) = '".$anio."'
									group by year(FechaInasistencia),month(FechaInasistencia)";
							$res_notas = mysql_query($select_notas, $conexion) or die(mysql_error());
							if (mysql_num_rows($res_notas)>0){
								while($row_boletas_1  = mysql_fetch_array($res_notas )){
									$str .=  $row_boletas_1 ['contador'].',';
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