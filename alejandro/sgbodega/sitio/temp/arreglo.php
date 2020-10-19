<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
include "../includes/php/validaciones.php"; //validaciones


// $sql = "INSERT INTO `alumnos_back`(`NumeroRutAlumno`, `DigitoRutAlumno`, `PaternoAlumno`, `MaternoAlumno`, `NombresAlumno`, `DireccionParticularAlumno`, `CiudadParticularAlumno`, `TelefonoParticularAlumno`, `CodigoNivel`, `CodigoCurso`, `BecaIncorporacion`, `BecaColegiatura`, `DiaVencimiento`, `FechaIngreso`, `FechaRetiro`, `TipoPagoIncorporacion`, `MesInicioIncorporacion`, `AnoInicioIncorporacion`, `MesInicioColegiatura`, `AnoInicioColegiatura`, `TipoBeca`, `ValorAnoAnterior`, `TipoSaldo`, `Matriculado`, `CodigoTipoBeca`, `MotivoCondicional`, `FechaNacimiento`, `SexoAlumno`, `OtroColegio`, `ColegioAnterior`, `NumeroRutApoderado`)
// 	SELECT `NumeroRutAlumno`, `DigitoRutAlumno`, `PaternoAlumno`, `MaternoAlumno`, `NombresAlumno`, `DireccionParticularAlumno`, `CiudadParticularAlumno`, `TelefonoParticularAlumno`, `CodigoNivel`, `CodigoCurso`, `BecaIncorporacion`, `BecaColegiatura`, `DiaVencimiento`, `FechaIngreso`, `FechaRetiro`, `TipoPagoIncorporacion`, `MesInicioIncorporacion`, `AnoInicioIncorporacion`, `MesInicioColegiatura`, `AnoInicioColegiatura`, `TipoBeca`, `ValorAnoAnterior`, `TipoSaldo`, '0', `CodigoTipoBeca`, `MotivoCondicional`, `FechaNacimiento`, `SexoAlumno`, `OtroColegio`, `ColegioAnterior`, `NumeroRutApoderado` FROM `Alumnos` WHERE NumeroRutAlumno NOT IN (select NumeroRutAlumno from alumnos_back)";
// $res = mysql_query($sql,$conexion) or die(mysql_error());

// $sql_001 =	"SELECT * FROM `alumnos2017` WHERE `DigitoRutAlumno` = ''";
// $res_001 = 	mysql_query($sql_001,$conexion);
// while($row_001 = mysql_fetch_array($res_001)){

// 	$dv = dv($row_001['NumeroRutAlumno']);

// 	$sql_002 = "update alumnos2017 set 
// 					DigitoRutAlumno = '".$dv."'
// 				where NumeroRutAlumno = '".$row_001['NumeroRutAlumno']."'";
// 	$res_002 = mysql_query($sql_002);

// 	}

// $sql_001 =	"SELECT * FROM `alumnos2019` WHERE `EMailAlumno` = '' or `EMailAlumno` is null ";
// $res_001 = 	mysql_query($sql_001,$conexion);
// while($row_001 = mysql_fetch_array($res_001)){
// 	$sql_99 = "select * from Apoderados where NumeroRutApoderado = '".$row_001['NumeroRutApoderado']."'";
// 	$res_99 = mysql_query($sql_99,$conexion);
// 	$row_99 = mysql_fetch_array($res_99);
// 	$sql_002 = "update alumnos2019 set 
//  					EMailAlumno = '".$row_99['EMailApoderado']."'
//  				where NumeroRutAlumno = '".$row_001['NumeroRutAlumno']."'";
//  	$res_002 = mysql_query($sql_002);
// }

// $sql = "	SELECT NumeroRutAlumno, `NombresAlumno`, `MaternoAlumno`, `PaternoAlumno`
// 				FROM alumnos2019
// 				where  EMailAlumno in ('','@','.','X','x','0')";
// $res = mysql_query($sql, $conexion);
// while ($row = mysql_fetch_assoc($res)) {
// 	echo $row['NumeroRutAlumno'].' '.$row['NombresAlumno'].' '.$row['PaternoAlumno'].' '.$row['MaternoAlumno'];
// 	echo "<br>";
// 	}

// $sql_001 =	"SELECT * FROM `alumnos2019` ";
// $res_001 = 	mysql_query($sql_001,$conexion);
// while($row_001 = mysql_fetch_array($res_001)){

// 	$rut = $row_001['NumeroRutAlumno'];

// 	$sql_002 = "update alumnos2019 set 
// 					FotoAlumno = 'uploads/fotos_alumnos/".$rut.".JPG'
// 				where NumeroRutAlumno = '".$row_001['NumeroRutAlumno']."'";
// 	$res_002 = mysql_query($sql_002);

// 	}
// function validaRut($rut){
//     if(strpos($rut,"-")==false){
//         $RUT[0] = substr($rut, 0, -1);
//         $RUT[1] = substr($rut, -1);
//     }else{
//         $RUT = explode("-", trim($rut));
//     }
//     $elRut = str_replace(".", "", trim($RUT[0]));
//     $factor = 2;
//     for($i = strlen($elRut)-1; $i >= 0; $i--):
//         $factor = $factor > 7 ? 2 : $factor;
//         $suma += $elRut{$i}*$factor++;
//     endfor;
//     $resto = $suma % 11;
//     $dv = 11 - $resto;
//     if($dv == 11){
//         $dv=0;
//     }else if($dv == 10){
//         $dv="k";
//     }else{
//         $dv=$dv;
//     }
//    if($dv == trim(strtolower($RUT[1]))){
//        return true;
//    }else{
//        return false;
//    }
// }
// $sql_001 =	"SELECT * FROM `alumnos2020` ";
// $res_001 = 	mysql_query($sql_001,$conexion);
// while($row_001 = mysql_fetch_array($res_001)){

// 	$rut = $row_001['NumeroRutAlumno'];
// 	$DV = $row_001['DigitoRutAlumno'];

// 	if(validaRut($rut.'-'.$DV)==true){
//         echo "El rut ".$rut." es v&aacute;lido ".$row_001['PaternoAlumno'].' '.$row_001['MaternoAlumno'].' '.$row_001['NombresAlumno'];
//     }else{
//         echo "El rut ".$rut." no es incorrecto ".$row_001['PaternoAlumno'].' '.$row_001['MaternoAlumno'].' '.$row_001['NombresAlumno'];
//     	}
// 	echo "<br>";
// 	}
// 	echo "<br>";
// 	echo "<br>";
// 	echo "<br>";
// 	echo "<br>";

// $sql_001 =	"SELECT * FROM `Apoderados` ";
// $res_001 = 	mysql_query($sql_001,$conexion);
// while($row_001 = mysql_fetch_array($res_001)){

// 	$rut = $row_001['NumeroRutApoderado'];
// 	$DV = $row_001['DigitoRutApoderado'];

// 	if(validaRut($rut.'-'.$DV)==true){
//         echo "El rut ".$rut." es v&aacute;lido ".$row_001['PaternoApoderado'].' '.$row_001['MaternoApoderado'].' '.$row_001['NombresApoderado'];
//     }else{
//         echo "El rut ".$rut." no es incorrecto ".$row_001['PaternoApoderado'].' '.$row_001['MaternoApoderado'].' '.$row_001['NombresApoderado'];
//     	}
// 	echo "<br>";
// 	}

$sql_001 =   "SELECT * FROM `Matriculas` where Anio = '2020' ";
$res_001 =   mysql_query($sql_001,$conexion);
while($row_001 = mysql_fetch_array($res_001)){
    echo $sql_002 = "update alumnos2020 
                set CodigoCurso = '".$row_001['CodigoCurso']."' 
                where NumeroRutAlumno = '".$row_001['NumeroRutAlumno']."'";
    echo "<br>";
    $res_002 = mysql_query($sql_002,$conexion);
}




?>