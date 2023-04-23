<?php 

	include('../conex.php');

			 $link         = Conectarse();
			 $cod_arriendo = $_GET['codarr'];
			 $cod_equipo   = trim($_GET['cod_equipo']);
			 $usuario = $_GET['usuario'];
			 //buscar el arriendo
			 $sql    = "UPDATE equipos_arriendo_temp
			 			SET  inc_accesorio = '1' 
						where cod_equipo =".$cod_equipo." 
							and cod_arriendo = ".$cod_arriendo." and usuario = '".$usuario."'";
			 $res=mysql_query($sql);
			 

?>