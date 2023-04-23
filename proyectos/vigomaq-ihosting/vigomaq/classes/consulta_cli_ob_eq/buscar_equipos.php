<?php 
include("../../conex.php");
$link = Conectarse();

$sql_eq_no_dev = "
		select distinct equipos_arriendo.num_gd, equipo.nombre_equipo, arriendo.rut_cliente, clientes.raz_social, 
					obra.nombre_obra, obra.direcc_obra,	equipos_arriendo.estado_equipo_arr	
		from equipos_arriendo
			inner join arriendo
				on equipos_arriendo.cod_arriendo = arriendo.cod_arriendo
			inner join clientes
				on clientes.rut_cliente = arriendo.rut_cliente
			inner join obra
				on arriendo.cod_obra = obra.cod_obra
			inner join equipo
				on equipos_arriendo.cod_equipo = equipo.cod_equipo
		where equipos_arriendo.estado_equipo_arr in ('NO DEVUELTO','DEVUELTO-NO FACTURADO')
		order by arriendo.rut_cliente
		 ";
$res_eq_no_dev = mysql_query($sql_eq_no_dev,$link) or die();
?>
<table id='warp_1'>
<tr>
    <td>	Guia de Despacho
    </td>
    <td>	Rut
    </td>
    <td>	Razon Social
    </td>
    <td>	Obra
    </td>
    <td>	Direccion Obra
    </td>
    <td>	Equipo
    </td>
    <td>	Estado Equipo
    </td>
</tr>
<?php
while($row_eq_no_dev = mysql_fetch_array($res_eq_no_dev)){
	echo "<tr>"; 
	echo "<td>".$row_eq_no_dev['num_gd']."</td>";
	echo "<td>".$row_eq_no_dev['rut_cliente']."</td>";
	echo "<td>".$row_eq_no_dev['raz_social']."</td>";
	echo "<td>".utf8_encode($row_eq_no_dev['nombre_obra'])."</td>";
	echo "<td>".iconv("UTF-8", "UTF-8//IGNORE",(($row_eq_no_dev['direcc_obra'])))."</td>";
	echo "<td>".utf8_encode($row_eq_no_dev['nombre_equipo'])."</td>";
	echo "<td>".$row_eq_no_dev['estado_equipo_arr']."</td>";
	echo "</tr>"; 
	}
?>
</table>