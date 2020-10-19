<?php
ob_start();
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
//include "../includes/php/sgbodega.php"; 
include "../includes/php/validaciones.php"; 


$asignatura = $_GET['asignatura'];
$anio = $_GET['anio'];
$curso = $_GET['curso'];
$semestre = $_GET['semestre'];
$prueba = $_GET['prueba'];


$select_prueba = "select 	DescripcionPrueba, NombreCurso, Ramos.Descripcion, 
							concat(PaternoProfesor,' ',MaternoProfesor,', ', NombresProfesor) as profesor
							from Pruebas
								inner join Cursos 
									on Cursos.CodigoCurso = Pruebas.CodigoCurso
								inner join Ramos 
									on Ramos.CodigoRamo = Pruebas.CodigoRamo
								inner join Profesores 
									on Profesores.NumeroRutProfesor = Pruebas.NumeroRutProfesor
							where   Pruebas.NumeroNota = '".$prueba."' and 
									 Pruebas.CodigoCurso = '".$curso."' and 
									 Pruebas.CodigoRamo = '".$asignatura."' and  
									 Pruebas.AnoAcademico = '".$anio."' and  
									 Pruebas.Semestre = '".$semestre."' ";
$res_prueba = mysql_query($select_prueba,$conexion);
$row_prueba = mysql_fetch_array($res_prueba);
echo '<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">';
echo '<script>
		function ImprimeDiv(id)
			{
					var c, tmp;
				
				  	c = document.getElementById(id);
					  
				   	temp = window.open(" ","Impresion.");
				  
				   	temp.document.open();
				   	temp.document.write(c.innerHTML);
				   	temp.document.close();
					  
				   	var is_chrome = function () { return Boolean(temp.chrome); }
					if(is_chrome) {
							setTimeout(function () { 
								temp.print();  
					            temp.close();
					        }, 100);
						}
					else{
					   	temp.print();
					   	temp.close();
					}
			}
		</script>';

$str="";
				$str .="<div id='divabonos'>
							<table class='grilla-tab' border='0' cellspacing='0' cellpadding='0' width='100%'>";
				$str .="<tr>";
					$str .="<td class='grilla-tab-fila-titulo' align='left' colspan='2'>Informe de Prueba</td>";
					
				$str .="</tr>";
				$str .="<tr>";
					$str .="<td class='grilla-tab-fila-titulo' align='left' >Curso</td>";
					$str .="<td class='grilla-tab-fila-campo' align='left' >".$row_prueba['NombreCurso']."</td>";
				$str .="</tr>";
				$str .="<tr>";
					$str .="<td class='grilla-tab-fila-titulo' align='left' >Asignatura</td>";
					$str .="<td class='grilla-tab-fila-campo' align='left' >".$row_prueba['Descripcion']."</td>";
				$str .="</tr>";
				$str .="<tr>";
					$str .="<td class='grilla-tab-fila-titulo' align='left' >Profesor</td>";
					$str .="<td class='grilla-tab-fila-campo' align='left' >".$row_prueba['profesor']."</td>";
				$str .="</tr>";
				$str .="<tr>";
					$str .="<td class='grilla-tab-fila-titulo' align='left' >Numero de Nota</td>";
					$str .="<td class='grilla-tab-fila-campo' align='left' >".$prueba."</td>";
				$str .="</tr>";
				$str .="<tr>";
					$str .="<td class='grilla-tab-fila-titulo' align='left' >Descripcion</td>";
					$str .="<td class='grilla-tab-fila-campo' align='left' >".$row_prueba['DescripcionPrueba']."</td>";
				$str .="</tr>";


			$str .= '</table>';
	$select_notas_1 = "select Nota
									from NotasAlumnos
									where CodigoCurso = '".$curso."' and 
											CodigoRamo = '".$asignatura."' and  
											AnoAcademico = '".$anio."' and  
											Semestre = '".$semestre."' and
											NumeroNota = '".$prueba."'";
	$res_notas_1 = mysql_query($select_notas_1, $conexion) or die(mysql_error());
	$total = 0;
	$insuficiente = 0;
	$suficiente = 0;
	$bueno=0;
	$muy_bueno=0;
	while($row_notas_1 = mysql_fetch_array($res_notas_1)){
		$nota = str_replace(',', '.', $row_notas_1['Nota']);
		if ($nota<='3.9'){
			$insuficiente++;
			}
		
		if (($nota>='4')&&($nota<='4.9')){
			$suficiente++;
			}
		
		if (($nota>='5')&&($nota<='5.9')){
			$bueno++;
			}
		
		if ($nota>='6'){
			$muy_bueno++;
			}
		
		$total++;
		}

		$porc_is = round(($insuficiente*100)/$total);
		$porc_s = round(($suficiente*100)/$total);
		$porc_b = round(($bueno*100)/$total);
		$porc_mb = round(($muy_bueno*100)/$total);


				$str .="<table class='grilla-tab' border='0' cellspacing='0' cellpadding='0' width='100%'>";
				$str .="<tr>";
					$str .="<td class='grilla-tab-fila-titulo' colspan='3'>Resumen</td>";
				$str .="</tr>";
				$str .="<tr>";
					$str .="<td class='grilla-tab-fila-titulo' align='left' >Insuficiente</td>";
					$str .="<td class='grilla-tab-fila-campo' align='left' >".$insuficiente."</td>";
					$str .="<td class='grilla-tab-fila-campo' align='left' >$porc_is %</td>";
				$str .="</tr>";
					$str .="<tr>";
					$str .="<td class='grilla-tab-fila-titulo' align='left' >Suficiente</td>";
					$str .="<td class='grilla-tab-fila-campo' align='left' >".$suficiente."</td>";
					$str .="<td class='grilla-tab-fila-campo' align='left' >$porc_s %</td>";
				$str .="</tr>";
				$str .="<tr>";
					$str .="<td class='grilla-tab-fila-titulo' align='left' >Bueno</td>";
					$str .="<td class='grilla-tab-fila-campo' align='left' >".$bueno."</td>";
					$str .="<td class='grilla-tab-fila-campo' align='left' >$porc_b %</td>";
				$str .="</tr>";
				$str .="<tr>";
					$str .="<td class='grilla-tab-fila-titulo' align='left' >Muy Bueno</td>";
					$str .="<td class='grilla-tab-fila-campo' align='left' >".$muy_bueno."</td>";
					$str .="<td class='grilla-tab-fila-campo' align='left' >$porc_mb %</td>";
				$str .="</tr>";
				
				$str .= '</table>';



			$str .="<table class='grilla-tab' border='0' cellspacing='0' cellpadding='0' width='100%'>";
				$str .="<tr>";
					$str .="<td class='grilla-tab-fila-titulo' align='left' >Plan de Accion convenido</td>";
					$str .="<td class='grilla-tab-fila-campo' align='left' ><textarea name='observacion' id='observacion' rows='5' ></textarea></td>";
				$str .="</tr>";
				
			$imprimir =  "ImprimeDiv('divabonos');";
			$str .= '
				    <tr>
				        <td colspan="16" class="grilla-tab-fila-titulo">
				             <a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="'.$imprimir.'" width="32"></a>
				    
				        </td>
				    </tr>

			</table></div>';




echo $str;
				



ob_flush();
?>
