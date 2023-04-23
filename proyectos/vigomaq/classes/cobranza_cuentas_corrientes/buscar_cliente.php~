<?php

header("Content-type: application/json");
$q = strtolower($_GET['term']);
include("../conex.php");
$link=Conectarse();
				
$data = array();

$sql = "SELECT `cod_cliente`, `cod_ciudad`, `cod_comuna`, `cod_tipocli`, `rut_cliente`, `dv_cliente`, `raz_social`, `giro_cliente`, `cod_area`, `fono_cliente`, `movil_cliente`, `direcc_cliente`, `nom_resp_emp1`, `email_resp_emp1`, `cargo_resp1`, `movil_resp1`, `nom_resp_emp2`, `email_resp_emp2`, `cargo_resp2`, `movil_resp2`, `nom_resp_emp3`, `email_resp_emp3`, `cargo_resp3`, `movil_resp3`, `cond_env_fact` FROM clientes
        WHERE raz_social like '%".$q."%'
	limit 0,10";
$res = mysql_query($sql, $link) or die(mysql_error());
$i=0;        
while ($row = mysql_fetch_assoc($res)) {
	$cod_cliente = $row['cod_cliente'];
	$nombre_proveedor = $row['raz_social'];
	$data[$i] = array('id' => $cod_cliente,
                            'value' => $nombre_proveedor,
                            'name' => $nombre_proveedor);
        $i++;
        
}
echo json_encode($data);
?>
