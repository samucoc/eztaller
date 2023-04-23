<?php 
include('../conex.php');
$link = Conectarse();

echo "<table id='warp_1'><tr>";
echo "<td>Razon Social</td>";
echo "<td>Direccion</td>";
echo "<td>Comuna</td>";
echo "<td>Ciudad</td>";
echo "<td>Obra</td>";
echo "<td>Direccion</td>";
echo "<td>Comuna</td>";
echo "<td>Ciudad</td>";
echo "<td>Vendedor</td>";
echo "<td>Tipo Obra</td>";
echo "<td>Administrador</td>";
echo "</tr><tr>";

$sql="SELECT  clientes.cod_ciudad as ciudad_1,  clientes.cod_comuna as comuna_1 ,  clientes.raz_social ,  
			clientes.direcc_cliente, obra.nombre_obra, obra.direcc_obra,obra.cod_comuna,
			obra.cod_ciudad,obra.cod_personal,obra.tipo_obra,obra.nom_adm
FROM  clientes 
inner join obra
on clientes.cod_cliente = obra.cod_cliente";
$res = mysql_query($sql) or die(mysql_error());
while ($row = mysql_fetch_array($res)){

echo "<tr>";
echo "<td>".$row['raz_social']."</td>";
echo "<td>".$row['direcc_cliente']."</td>";
$sql_cliente = "select *
					from comuna
					where cod_comuna = ".$row['comuna_1']; 
	$res_cliente = mysql_query($sql_cliente,$link) or die(mysql_error());
	while ($row_cliente = mysql_fetch_array($res_cliente)){
		echo "<td>".($row_cliente['comuna'])."</td>";
	}
$sql_cliente = "select *
					from ciudad
					where cod_ciudad = ".$row['ciudad_1']; 
	$res_cliente = mysql_query($sql_cliente,$link) or die(mysql_error());
	while ($row_cliente = mysql_fetch_array($res_cliente)){
		echo "<td>".($row_cliente['ciudad'])."</td>";
	}
echo "<td>".$row['nombre_obra']."</td>";
echo "<td>".($row['direcc_obra'])."</td>";
$sql_cliente = "select *
					from comuna
					where cod_comuna = ".$row['cod_comuna']; 
	$res_cliente = mysql_query($sql_cliente,$link) or die(mysql_error());
	while ($row_cliente = mysql_fetch_array($res_cliente)){
		echo "<td>".($row_cliente['comuna'])."</td>";
	}
$sql_cliente = "select *
					from ciudad
					where cod_ciudad = ".$row['cod_ciudad']; 
	$res_cliente = mysql_query($sql_cliente,$link) or die(mysql_error());
	while ($row_cliente = mysql_fetch_array($res_cliente)){
		echo "<td>".($row_cliente['ciudad'])."</td>";
	}
$sql_cliente = "select  *
					from personal
					where cod_personal = ".$row['cod_personal']; 
	$res_cliente = mysql_query($sql_cliente,$link) or die(mysql_error());
	while ($row_cliente = mysql_fetch_array($res_cliente)){
		echo "<td>".($row_cliente['nombres_personal'])." ".($row_cliente['ap_patpersonal'])." ".($row_cliente['ap_matpersonal'])."</td>";
	}
$sql_cliente = "select *
					from tipo_obra
					where cod_tipo_obra = ".$row['tipo_obra']; 
	$res_cliente = mysql_query($sql_cliente,$link) or die(mysql_error());
	while ($row_cliente = mysql_fetch_array($res_cliente)){
		echo "<td>".($row_cliente['tipo_obra'])."</td>";
	}
echo "<td>".$tipo_obra."</td>";
echo "<td>".$row['nom_adm']."</td>";
echo "</tr><tr>";

	}
echo"</tr></table>";
?>