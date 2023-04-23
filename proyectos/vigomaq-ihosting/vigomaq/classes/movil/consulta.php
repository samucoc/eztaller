<?php 
//conectamos a la base de datos 
mysql_connect("186.67.71.229","vigomaq","rtwvhhTE8X75bGyH"); 
//mysql_connect("localhost","root","");  
//mysql_connect("localhost","root","");
mysql_select_db("vigomaq_intranet"); 
include("../../conex.php");
$link = Conectarse();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>
        </title>
        <link rel="stylesheet" type="text/css" href="../../style.css">
		<style>
        .Estilo17 {color: #FFFFFF; font-style: italic; font-weight: bold; font-size: 12px; font-family: Arial, Helvetica, sans-serif; }
        </style>
                <style>
			.text-align-center {
			  text-align: center;
			}
			.text-align-right {
			  text-align: right;
			}
        </style>
    </head>
<body>
        <div data-role="page" id="page1">
            <div data-role="content">
<h2>
                    Resultado Búsqueda
                </h2>

                <table width="100%" border="0" align="center">
                  <tr>
                    <td width="16%">
                    <?php
if (($_POST['codigo']!='') || ($_POST['equipo']!='') || (isset($_GET['codigo'])) || (isset($_GET['equipo']))) {
	
//inicializo el tipo  de operaci&oacute;n y recibo cualquier cadena que se desee buscar
	$sql = "SELECT * FROM equipo ";

	if ($_POST['codigo'] != ""){
	   $txt_codigo = $_POST["codigo"];
	   $sql .= " where cod_equipo = '$txt_codigo'";
	}
	if ($_GET['codigo'] != ""){
	   $txt_codigo = $_GET["codigo"];
	   $sql .= " where cod_equipo = '$txt_codigo'";
	}
	
	if ($_POST['equipo'] !="") {
	   $txt_equipo = $_POST["equipo"];
	   $sql .= " where nombre_equipo like '%" . $txt_equipo . "%' "; 
	}
	if ($_GET['equipo'] !="") {
	   $txt_equipo = $_GET["equipo"];
	   $sql .= " where nombre_equipo like '%" . $txt_equipo . "%' "; 
	}

	$sql .= " order by cod_equipo ASC";

	$res=mysql_query($sql);
	$numeroRegistros=mysql_num_rows($res);
	$inicio = 0;
	$final = 0;
	if($numeroRegistros<=0)	{
		echo "<div align='center'>";
		echo "<font face='verdana' size='-2'>No se encontraron resultados</font>";
		echo "</div>";
	}else{
		//elementos para el orden
		if(!isset($orden)) {
		   $orden="cod_equipo";
		}
		//fin elementos de orden
	
		//calculo de elementos necesarios para paginacion
		//tama&ntilde;o de la pagina
		$tamPag=20;
	
		//pagina actual si no esta definida y limites
		if(!isset($_GET["pagina"])){
		   $pagina=1;
		   $inicio=1;
		   $final=$tamPag;
		}else{
		   $pagina = $_GET["pagina"];
		}
		//calculo del limite inferior
		$limitInf=($pagina-1)*$tamPag;
	
		//calculo del numero de paginas
		$numPags=ceil($numeroRegistros/$tamPag);
		if(!isset($pagina)) {
		   $pagina=1;
		   $inicio=1;
		   $final=$tamPag;
		}else{
		   $seccionActual=intval(($pagina-1)/$tamPag);
		   $inicio=($seccionActual*$tamPag)+1;
	
		   if($pagina<$numPags)    {
			  $final=$inicio+$tamPag-1;
		   }else{
			  $final=$numPags;
		   }
			if ($final>$numPags){
			  $final=$numPags;
		   }
		}

	//fin de dicho calculo
	
	echo "<div align='center'>";
	echo "<font face='verdana' size='-2'>encontrados ".$numeroRegistros." resultados<br>";
	
	if(isset($txt_codigo))	{
	   
	}
	echo "</font></div>";
	$limitSup=0;
	if ($limitInf==0){
		$limitInf = 20;
		}
	else{
		$limitInf = $limitInf+20;
		}
	if (isset($_GET['pagina'])){
		$constante = $_GET['pagina'];
		$limitSup = (20 * $constante)-20;
		}
	else{
		$constante = 1;
		$limitSup = (20 * $constante)-20;
		}
	
	$sql .= " limit $limitSup, $limitInf;";
	$res = mysql_query($sql);
}	
	
?></td>
                  </tr>
                  <tr>
                    <th bgcolor="#06327D"><div align="center" class="Estilo17"> Guia Despacho</div></th>
                    <th width="25%" bgcolor="#06327D"><div align="center" class="Estilo17">Nombre</div></th>
                    <th width="16%" bgcolor="#06327D"><div align="center" class="Estilo17"><strong>Valor<br />
                      Arriendo / d&iacute;a </strong></div></th>
                    <th width="32%" bgcolor="#06327D"><div align="center" class="Estilo17"><strong>Estado</strong></div></th>
                  </tr>
                  <tr>
                    <?php while($registro=mysql_fetch_array($res))
				{
			?>
                    <td><?php 
                if($registro['cod_estado_equipo'] == 3){
					$sql_1 = "SELECT num_gd
								FROM equipos_arriendo 
								where cod_equipo = ".$registro['cod_equipo']." 
									and estado_equipo_arr = 'NO DEVUELTO'
								order by arrendado_desde desc LIMIT 1";
					$res_1 = mysql_query($sql_1,$link) or die(mysql_error()); 
					$registro_1 = mysql_fetch_array($res_1);
						
					echo $registro_1['num_gd'];
				}
				else{
					echo "Sin Guia de Despacho";
					}
				?></td>
                    <td><?php echo htmlentities($registro['nombre_equipo']) ;?></td>
                    <td align="right"><?php echo "$ ".number_format($registro['valor_unidad_arr'], 0, ",", ".") ; ?></td>
                    <td align="right"><?php 
			  
			  if($registro['cod_estado_equipo'] == 3){
			  	
					
					
					$sql_1 = "SELECT cod_arriendo 
								FROM equipos_arriendo 
								where cod_equipo = ".$registro['cod_equipo']." 
									and estado_equipo_arr = 'NO DEVUELTO'
								order by arrendado_desde desc LIMIT 1";
					$res_1 = mysql_query($sql_1,$link) or die(mysql_error()); 
					$registro_1 = mysql_fetch_array($res_1);
					
					$cod_arriendo_1 =  $registro_1['cod_arriendo'];
					
					$salida = '--';
					
					if($cod_arriendo_1 != ''){
						$sql_2 = "SELECT clientes.raz_social, obra.nombre_obra, arriendo.* FROM arriendo
						left join clientes clientes on arriendo.rut_cliente = clientes.rut_cliente
						left join obra obra on obra.cod_obra =  arriendo.cod_obra
						where cod_arriendo = ".$cod_arriendo_1." limit 1";
						
						
						
						$res_2 = mysql_query($sql_2,$link) or die(mysql_error()); 
						$registro_2 = mysql_fetch_array($res_2);
						
						//print_r ($registro_2);
						
						
						$salida = $registro_2['raz_social'].' <br /> '.$registro_2['nombre_obra'];
					}
					
					
					echo $salida;
					
					
					
					//print_r ($registro_2);
					
					//$salida = 
				
					//echo $salida;
				
			  }else{
			  		$c_est_equipo = $registro['cod_estado_equipo'];
					  $sql2 = "SELECT descripcion_estado FROM vigomaq_intranet.estado_equipo where cod_estado_equipo='$c_est_equipo'"; 
					  $res2 = mysql_query($sql2,$link) or die(mysql_error()); 
					  $registro2 = mysql_fetch_array($res2);
					  if ($registro['cod_estado_equipo']==1) { echo "DISPONIBLE - " ;}else{ echo "NO DISPONIBLE - ";}
					  echo $registro2['descripcion_estado'] ;
			  
			  }
			  
			  
			  
			 ?></td>
                  </tr>
                  <!-- fin tabla resultados -->
                  <?php
}//fin while
echo "</table>";
}//fin if
//a partir de aqui viene la paginacion
?>
                  <br />
                  <table border="0" cellspacing="0" cellpadding="0" align="center">
                    <tr>
                      <td align="center" valign="top"><?php
    if($pagina>1)
    {
		if ($_POST['codigo'] != ""){
    	   echo "<a name='buscarcodigo' class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina-1)."&orden=".$orden."&codigo=".$txt_codigo."&buscarcodigo=buscarcodigo'>";}else{
    	   echo "<a name='buscarnombre' class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina-1)."&orden=".$orden."&equipo=".$txt_equipo."&buscarnombre=buscarnombre'>";
			   }
       echo "<font face='verdana' size='-2'>anterior</font>";
       echo "</a> ";
    }

    for($i=$inicio;$i<=$final;$i++)
    {
       if($i==$pagina)
       {
          echo "<font face='verdana' size='-2'><b>".$i."</b> </font>";
       }else{
		if ($_POST['codigo'] != ""){
    	   echo "<a name='buscarcodigo' class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($i)."&orden=".$orden."&codigo=".$txt_codigo."&buscarcodigo=buscarcodigo'>";}else{
    	   echo "<a name='buscarnombre' class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($i)."&orden=".$orden."&equipo=".$txt_equipo."&buscarnombre=buscarnombre'>"			;
			   }
          echo "<font face='verdana' size='-2'>".$i."</font></a> ";
       }
    }
    if($pagina<$numPags)
   {
		if ($_POST['codigo'] != ""){
    	   echo "<a name='buscarcodigo' class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina+1)."&orden=".$orden."&codigo=".$txt_codigo."&buscarcodigo=buscarcodigo'>";}else{
    	   echo "<a name='buscarnombre' class='p' href='".$_SERVER["PHP_SELF"]."?pagina=".($pagina+1)."&orden=".$orden."&equipo=".$txt_equipo."&buscarnombre=buscarnombre'>"			;
			   }
       echo "<font face='verdana' size='-2'>siguiente</font></a>";
   }
//fin de la paginacion
?></td>
                    </tr>
                  </table>
                  <?php
    mysql_close();
?>
                </table>

    </body>
</html>


