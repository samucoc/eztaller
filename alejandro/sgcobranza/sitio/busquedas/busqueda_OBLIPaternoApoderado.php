<?php

header("Content-type: application/json");
$q = strtolower($_GET['term']);
include "../../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos

$data = array();

$sql = "SET NAMES utf8";
$res = mysql_query($sql, $conexion);


$sql = "SELECT apo_ncorr, `NumeroRutApoderado`, `DigitoRutApoderado`, `PaternoApoderado`, `MaternoApoderado`, `NombresApoderado`, 
                `DireccionParticularApoderado`, `CiudadParticularApoderado`, `TelefonoParticularApoderado`, `TelefonoMovilApoderado`, 
                `CodigoParentesco`, `CodigoEscolaridad`, `CodigoOcupacion`, `TipoApoderado`, `EMailApoderado`, `TipoPagare`, `NumeroRutAval`, 
                `DigitoRutAval`, `PaternoAval`, `MaternoAval`, `NombresAval`, `DireccionAval`, `CiudadAval`
        FROM gescolcl_arcoiris_administracion.Apoderados
        WHERE concat(PaternoApoderado ,' ',MaternoApoderado ,' ', NombresApoderado) like '%".$q."%' 
			limit 0,10";
$res = mysql_query($sql, $conexion);
$i=0;        
while ($row = mysql_fetch_assoc($res)) {
	$ncorr_proveedor               = $row['apo_ncorr'];
	$rut_proveedor                 = $row['NumeroRutApoderado'];
  $nombre_proveedor              = $row['PaternoApoderado'];
  $DigitoRutApoderado            = $row['DigitoRutApoderado'];
  $MaternoApoderado              = $row['MaternoApoderado'];
  $NombresApoderado              = $row['NombresApoderado'];
  $DireccionParticularApoderado  = $row['DireccionParticularApoderado'];
  $CiudadParticularApoderado     = $row['CiudadParticularApoderado'];
  $TelefonoParticularApoderado   = $row['TelefonoParticularApoderado'];
  $TelefonoMovilApoderado        = $row['TelefonoMovilApoderado'];
  $CodigoParentesco              = $row['CodigoParentesco'];
  $CodigoEscolaridad             = $row['CodigoEscolaridad'];
  $CodigoOcupacion               = $row['CodigoOcupacion'];
  $TipoApoderado                 = $row['TipoApoderado'];
  $EMailApoderado                = $row['EMailApoderado'];
  $TipoPagare                    = $row['TipoPagare'];
  $NumeroRutAval                 = $row['NumeroRutAval'];
  $DigitoRutAval                 = $row['DigitoRutAval'];
  $PaternoAval                   = $row['PaternoAval'];
  $MaternoAval                   = $row['MaternoAval'];
  $NombresAval                   = $row['NombresAval'];
  $DireccionAval                 = $row['DireccionAval'];
  $CiudadAval                    = $row['CiudadAval'];
  
  $data[$i] = array('id' => $ncorr_proveedor,
                      'rut' => $rut_proveedor,
                      'value' => strtoupper (($nombre_proveedor).' '.($MaternoApoderado).' '. ($NombresApoderado)),
                      'apellidoPaterno' => strtoupper (($nombre_proveedor)),
                      'DigitoRutApoderado' => ($DigitoRutApoderado),
                      'MaternoApoderado' => strtoupper (($MaternoApoderado)),
                      'NombresApoderado' => strtoupper (($NombresApoderado)),
                      'DireccionParticularApoderado' => strtoupper (($DireccionParticularApoderado)),
                      'CiudadParticularApoderado' => strtoupper (($CiudadParticularApoderado)),
                      'TelefonoParticularApoderado' => ($TelefonoParticularApoderado),
                      'TelefonoMovilApoderado' => ($TelefonoMovilApoderado),
                      'CodigoParentesco' => ($CodigoParentesco),
                      'CodigoEscolaridad' => ($CodigoEscolaridad),
                      'CodigoOcupacion' => ($CodigoOcupacion),
                      'TipoApoderado' => ($TipoApoderado),
                      'EMailApoderado' => strtoupper (($EMailApoderado)),
                      'TipoPagare' => ($TipoPagare),
                      'NumeroRutAval' => ($NumeroRutAval),
                      'DigitoRutAval' => ($DigitoRutAval),
                      'PaternoAval' => ($PaternoAval),
                      'MaternoAval' => ($MaternoAval),
                      'NombresAval' => ($NombresAval),
                      'DireccionAval' => ($DireccionAval),
                      'CiudadAval' => ($CiudadAval));
        $i++;
        
}
echo json_encode($data);
?>