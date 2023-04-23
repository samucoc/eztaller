<?php 
$rut_cliente = $_GET['rut_cliente'];
$num_gd = $_GET['num_gd'];

include("../../conex.php");
$link = Conectarse();

if ($rut_cliente != ''){
	$sql_1 = "select num_gd 
			from gd 
			where num_gd = '$num_gd' 
				and rut_cliente = '$rut_cliente'
			";
	$res_1 = mysql_query($sql_1,$link);
	if (mysql_num_rows($res_1)>0){
		echo "Info: Guia de Despacho ya ingresada asociada al mismo cliente";
		}
	else{
		$sql_2 = "select num_gd 
				from gd 
				where num_gd = '$num_gd' 
					and rut_cliente <> '$rut_cliente'
				";
		$res_2 = mysql_query($sql_2,$link);
		if (mysql_num_rows($res_2)>0){
			echo "Info: Guia de Despacho ya ingresada asociada a otro cliente";
			}
		else{
			$sql_3 = "select num_gd 
					from gd 
					where num_gd = '$num_gd' 
					";
			$res_3 = mysql_query($sql_3,$link);
			if (mysql_num_rows($res_3)>0){
				$sql_4 = "select id_arriendo 
					from gd 
					where num_gd = '$num_gd' 
					";
				$res_4 = mysql_query($sql_4,$link);
				$row_4 = mysql_fetch_array($res_4);
				if ($row_4['id_arriendo']==0)
					echo "Info: Guia de Despacho de Ventas";
				else
					echo "Info: Guia de Despacho ya ingresada";
				}
			else{
				echo "Info: Guia de despacho disponible";
				}
			}
		}
	}
else{
	echo "Debe seleccionar un equipo antes de cambiar.";
	}
?>