<?php 
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

//$sql = "select co_codigo, co_nombre, co_sector, co_empresa, co_comision
//		from sgyonley.cobrador
//		group by co_codigo, co_nombre";
//$res = mysql_query($sql,$conexion) ;
//
//while ($row = mysql_fetch_array($res)){
//	$codigo = $row['co_codigo'];
//	$nombre = $row['co_nombre'];
//	$sector = $row['co_sector'];
//	$empresa = $row['co_empresa'];
//	$comision = $row['co_comision'];
//
//	echo $sql_001 = "insert into sgtrabajadores.trabajadores(nombres,empresa_contr,cod_cobrador,sector_cobrador,comision_cobrador)
//					values('".$nombre."','".$empresa."','".$codigo."','".$sector."','".$comision."')";
//	echo "<br />";
//	$res_001 = mysql_query($sql_001,$conexion);
//	$id = mysql_insert_id();
//	
//	$sql_002 = "select co_codigo, co_nombre, co_sector, co_empresa, co_comision
//				from sgyonley.cobrador
//				where co_codigo = '".$codigo."'";
//	$res_002 = mysql_query($sql_002,$conexion);
//	
//	while($row_002 = mysql_fetch_array($res_002)){
//		$empresa_1 = $row_002['co_empresa'];
//		echo $sql_003 = "insert into sgtrabajadores.trabajadores_tienen_empresa(rut, empe_rut)
//						values('".$id."','".$empresa_1."')";
//		echo "<br />";
//		$res_003 = mysql_query($sql_003,$conexion);
//		
//		}
//	}
$sql = "SELECT * FROM gescolcl_arcoiris_administracion.`alumnos2018` WHERE `BecaColegiatura` > 0 ";
$res = mysql_query($sql,$conexion) ;

while ($row = mysql_fetch_array($res)){
	$PeriodoBeca			 	= '2018';
	
	echo $sql_pd = "select ValorIncorporacion, ValorColegiatura
					from gescolcl_arcoiris_administracion.Aranceles
					where
						CodigoNivel in (	select CodigoNivel
											from gescolcl_arcoiris_administracion.Cursos
											where CodigoCurso in (
																	select CodigoCurso
																	from gescolcl_arcoiris_administracion.alumnos".$PeriodoBeca."
																	where NumeroRutAlumno = '".$row['NumeroRutAlumno']."'
																	)
											) and 
						AnioPeriodo = '".$PeriodoBeca."'"; 
	echo "<br>";
		
	$res_pd = mysql_query($sql_pd, $conexion) or die(mysql_error());
	
	$row_nombre_profe = mysql_fetch_array($res_pd);

    echo $cuota_0 = $row_nombre_profe['ValorIncorporacion'];
	echo "<br>";
	echo $colegiatura = $row_nombre_profe['ValorColegiatura'];
	echo "<br>";
	
	echo $ColegiaturaTipoBeca =	$row['BecaColegiatura'];
	echo "<br>";
	echo $IncorporacionTipoBeca = 		$row['BecaIncorporacion'];
	echo "<br>";
	
	$PorcBecaIncorporacion = ($IncorporacionTipoBeca*100)/$cuota_0 <= 100 ? ($IncorporacionTipoBeca*100)/$cuota_0 : '0';
	$PorcBecaColegiatura = ($ColegiaturaTipoBeca*100)/$colegiatura <= 100 ? ($ColegiaturaTipoBeca*100)/$colegiatura : '0';

	echo $sql_nombre_profe ="update gescolcl_arcoiris_administracion.alumnos".$PeriodoBeca." set 
							PorcBecaIncorporacion = '".round($PorcBecaIncorporacion,2)."',
							PorcBecaColegiatura = '".round($PorcBecaColegiatura,2)."'
						where NumeroRutAlumno='".$row['NumeroRutAlumno']."' ";
	echo "<br>";
	$res_nombre_profe = mysql_query($sql_nombre_profe,$conexion) or die(mysql_error());
}
?>