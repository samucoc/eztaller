<?php 
ob_start(); 
session_start(); 

$guia = $_GET['num_gd'];

include("../conex.php");

//busca si esta dte
$link=Conectarse();
		$sqlguia = "SELECT * FROM factura WHERE num_factura ='$guia'";						
		
		$resguia = mysql_query($sqlguia,$link) or die(mysql_error()); 
	if (mysql_num_rows($resguia)>0){
		echo "1";
		}
	else{
		//pregunta por el rango acotado
		$sql_num_factura     = "SELECT (COALESCE(num_factura,0)) as ncorr
                    FROM factura
                    where 
                      num_factura > '37750' 
                    order by num_factura desc
                    limit 0,1";
          
          $res_num_factura     = mysql_query($sql_num_factura,$link) or die(mysql_error()); 
          $registro_num_factura= mysql_fetch_array($res_num_factura);
          $num_factura_nuevo = $registro_num_factura['ncorr'];
          if ($registro_num_factura['ncorr']=='') $num_factura_nuevo= 37751;
          else $num_factura_nuevo = $registro_num_factura['ncorr']+1;
         
          if ($num_factura_nuevo=='') $num_factura_nuevo=1;

            $sql_filtro = "select * 
                    from folios_dte
                    where desde <= '".$num_factura_nuevo."' and 
                        hasta >= '".$num_factura_nuevo."' and 
                        tipo = 33";
            $res_filtro = mysql_query($sql_filtro,$link);
            if (mysql_num_rows($res_filtro)==0){
              echo "2";
              }
            else{
            	if (($guia<=$num_factura_nuevo)&&($guia>='37750')){
            		echo "99";
            	}
            	else{
            		echo "3";
            	}

            }

		}
?>