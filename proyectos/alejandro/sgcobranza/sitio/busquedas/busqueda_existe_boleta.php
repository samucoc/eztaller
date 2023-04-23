<?php
ob_start();
session_start();
$q = strtolower($_GET['q']);

include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

include "../../includes/php/validaciones.php"; //validaciones



$data = array();


	$sql = "SELECT * 
	        FROM gescolcl_arcoiris_administracion.Movimientos
	        WHERE NumeroBoleta = '".$q."' 
	            ";

	$res = mysql_query($sql, $conexion);

	$i=0; 

	if (mysql_num_rows($res)>0){
		$row = mysql_fetch_array($res);
		$valor_boleta = $row['ValorBoleta'];
		$vigente = $row['EstadoBoleta'] == '1' ? 'vigente' : 'no vigente';
		$sql = "select concat(PaternoApoderado,' ',MaternoApoderado,', ',NombresApoderado) as str1, 
						concat(PaternoAlumno,' ',MaternoAlumno,', ',NombresAlumno,' - ',Cursos.NombreCurso) as str2
				from gescolcl_arcoiris_administracion.alumnos".$row['PeriodoMovimiento']."
					inner join gescolcl_arcoiris_administracion.Cursos on gescolcl_arcoiris_administracion.alumnos".$row['PeriodoMovimiento'].".CodigoCurso = gescolcl_arcoiris_administracion.Cursos.CodigoCurso
					inner join gescolcl_arcoiris_administracion.Apoderados on gescolcl_arcoiris_administracion.Apoderados.NumeroRutApoderado = gescolcl_arcoiris_administracion.alumnos".$row['PeriodoMovimiento'].".NumeroRutApoderado
				where gescolcl_arcoiris_administracion.alumnos".$row['PeriodoMovimiento'].".NumeroRutAlumno = '".$row['NumeroRutAlumno']."'	";
		$res = mysql_query($sql, $conexion);
		$row = mysql_fetch_array($res);
		echo '1|Apoderado: '.$row['str1'].'|Alumno: '.$row['str2'].'|Valor: '.$valor_boleta.'|Estado: '.$vigente;
		}   
	else{
		echo "0";
		}    
?>