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



// $sql = "select FechaIngreso, FechaNacimiento , NumeroRutAlumno

// 		from gescolcl_arcoiris_administracion.Alumnos2016";

// 		



$sql = "select 	NumeroRutAlumno, NumeroRutApoderado

 		from gescolcl_arcoiris_administracion.Alumnos_20160615

 		";



$res = mysql_query($sql,$conexion) or die(mysql_error());



while($row = mysql_fetch_array($res)){



	//list($dia_n_2,$mes_n_2,$anio_n_2) = explode('/',$row['FechaPrueba']);

	//list($dia_n_1,$mes_n_1,$anio_n_1) = explode('/',$row['FechaIngresoNotaPrueba']);

	

	$mov_ncorr = $row['NumeroRutAlumno'];

	$CiudadParticularAlumno = $row['NumeroRutApoderado'];

			

	// if ($mes_n=='ene'){

	// 	$mes_n = '1';

	// }

	// elseif ($mes_n=='feb'){

	// 	$mes_n = '2';

	// }

	// elseif ($mes_n=='mar'){

	// 	$mes_n = '3';

	// }

	// elseif ($mes_n=='abr'){

	// 	$mes_n = '4';

	// }

	// elseif ($mes_n=='may'){

	// 	$mes_n = '5';

	// }

	// elseif ($mes_n=='jun'){

	// 	$mes_n = '6';

	// }

	// elseif ($mes_n=='jul'){

	// 	$mes_n = '7';

	// }

	// elseif ($mes_n=='ago'){

	// 	$mes_n = '8';

	// }

	// elseif ($mes_n=='sep'){

	// 	$mes_n = '9';

	// }

	// elseif ($mes_n=='oct'){

	// 	$mes_n = '10';

	// }

	// elseif ($mes_n=='nov'){

	// 	$mes_n = '11';

	// }

	// elseif ($mes_n=='dic'){

	// 	$mes_n = '12';

	// }

			

	echo $sql_1 = "update gescolcl_arcoiris_administracion.alumnos

				set 

				NumeroRutApoderado = '".$CiudadParticularAlumno."'

				where

				NumeroRutAlumno = '".$mov_ncorr."'

				 ";

	$res_1 = mysql_query($sql_1,$conexion) or die(mysql_error());



	}

/*

$sql_pre = "select NumeroRutAlumno, AnoInicioColegiatura,  CodigoCurso, NumeroLista 

				from gescolcl_arcoiris_administracion.alumnos 

				where CodigoCurso < '100' and Matriculado = '1'

				order by CodigoCurso asc, NumeroLista asc";

$res_pre = mysql_query($sql_pre,$conexion) or die(mysql_error());

$i=1;

while ($row_pre = mysql_fetch_array($res_pre)){

	$sql_matri =	"INSERT INTO gescolcl_arcoiris_administracion.Matriculas( `NumeroRutAlumno`, `Anio`, `Fecha`, `CodigoCurso`, `NroMatricula`, `NroLista`) 

					VALUES ('".$row_pre['NumeroRutAlumno']."','".$row_pre['AnoInicioColegiatura']."','2016-03-01',

							'".str_pad($row_pre['CodigoCurso'], 3, "0", STR_PAD_LEFT)."','".$i."','".$row_pre['NumeroLista']."')";

	$res_matri = mysql_query($sql_matri,$conexion);

	$i++;

	}



$sql_pre = "select NumeroRutAlumno, AnoInicioColegiatura,  CodigoCurso, NumeroLista 

				from gescolcl_arcoiris_administracion.alumnos 

				where CodigoCurso between '100' and '299' and 

					Matriculado = '1'

				order by CodigoCurso asc, NumeroLista asc";

$res_pre = mysql_query($sql_pre,$conexion) or die(mysql_error());

$i=1;

while ($row_pre = mysql_fetch_array($res_pre)){

	$sql_matri =	"INSERT INTO gescolcl_arcoiris_administracion.Matriculas( `NumeroRutAlumno`, `Anio`, `Fecha`, `CodigoCurso`, `NroMatricula`, `NroLista`) 

					VALUES ('".$row_pre['NumeroRutAlumno']."','".$row_pre['AnoInicioColegiatura']."','2016-03-01',

							'".$row_pre['CodigoCurso']."','".$i."','".$row_pre['NumeroLista']."')";

	$res_matri = mysql_query($sql_matri,$conexion);

	$i++;

	}





$sql_pre = "select NumeroRutAlumno, AnoInicioColegiatura,  CodigoCurso, NumeroLista 

				from gescolcl_arcoiris_administracion.alumnos 

				where CodigoCurso between '300' and '399' and 

					Matriculado = '1'

				order by CodigoCurso asc, NumeroLista asc";

$res_pre = mysql_query($sql_pre,$conexion) or die(mysql_error());

$i=1;

while ($row_pre = mysql_fetch_array($res_pre)){

	$sql_matri =	"INSERT INTO gescolcl_arcoiris_administracion.Matriculas( `NumeroRutAlumno`, `Anio`, `Fecha`, `CodigoCurso`, `NroMatricula`, `NroLista`) 

					VALUES ('".$row_pre['NumeroRutAlumno']."','".$row_pre['AnoInicioColegiatura']."','2016-03-01',

							'".$row_pre['CodigoCurso']."','".$i."','".$row_pre['NumeroLista']."')";

	$res_matri = mysql_query($sql_matri,$conexion);

	$i++;

	}





*/



?>