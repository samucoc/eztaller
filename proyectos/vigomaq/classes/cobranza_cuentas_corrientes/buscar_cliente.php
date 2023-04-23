<?php

header("Content-type: application/json");
$q = strtolower($_GET['term']);
include("../conex.php");
$link=Conectarse();
				
$data = array();

$sql = "SELECT distinct `cod_cliente`, tipo_cliente, `rut_cliente`, `dv_cliente`, `raz_social`, `giro_cliente`, `cod_area`, `fono_cliente`, `movil_cliente`, `direcc_cliente`, `nom_resp_emp1`, `email_resp_emp1`, `cargo_resp1`, `movil_resp1`, `nom_resp_emp2`, `email_resp_emp2`, `cargo_resp2`, `movil_resp2`, `nom_resp_emp3`, `email_resp_emp3`, `cargo_resp3`, `movil_resp3`, `cond_env_fact` 
	FROM clientes
		inner join tipo_cliente
			on tipo_cliente.cod_tipocli = clientes.cod_tipocli
        WHERE raz_social like '%".$q."%' or rut_cliente like '".$q."%'
	limit 0,10";
$res = mysql_query($sql, $link) or die(mysql_error());
$i=0;        
while ($row = mysql_fetch_assoc($res)) {
	$cod_cliente = $row['cod_cliente'];
	$nombre_proveedor = $row['raz_social'];
	$rut_cliente = $row['rut_cliente'];
	$fono = $row['fono_cliente'];
	$movil = $row['movil_cliente'];
	$resp = $row['nom_resp_emp1'];
	$tipo_cliente = $row['tipo_cliente'];
	$email = $row['email_resp_emp1'];
	$cond_envio = $row['cond_env_fact'];

	$data[$i] = array('id' => $cod_cliente,
                            'value' => $rut_cliente.' - '.$nombre_proveedor,
                            'name' => $rut_cliente.' - '.$nombre_proveedor,
			    'fono_resp'	 	=> $fono,
			    'movil_resp' 	=> $movil,
			    'tipo_cliente'	=> $tipo_cliente,
			    'email_resp'	=> $email,
			    'resp'		=> $resp,
			    'cond_envio'	=> $cond_envio);
        $i++;
        
}
echo json_encode($data);
?>
