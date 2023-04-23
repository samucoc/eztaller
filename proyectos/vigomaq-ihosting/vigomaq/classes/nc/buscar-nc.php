<?php 
ob_start(); 
session_start(); 

$guia = $_GET['num_gd'];

include("../conex.php");

//busca si esta dte
$link=Conectarse();
		$sqlguia = "SELECT * FROM nota_credito WHERE num_nota_cred ='$guia'";						
		
		$resguia = mysql_query($sqlguia,$link) or die(mysql_error()); 
	if (mysql_num_rows($resguia)>0){
		echo "1";
		}
	else{
		//pregunta por el rango acotado
		$sql_num_factura     = "SELECT (COALESCE(num_nota_cred  ,0)) as ncorr
                  FROM nota_credito
                  WHERE num_nota_cred  > 725
                  order by num_nota_cred   desc";
          
          $res_num_factura     = mysql_query($sql_num_factura,$link) or die(mysql_error()); 
          $registro_num_factura= mysql_fetch_array($res_num_factura);
          $num_factura_nuevo = $registro_num_factura['ncorr'];
          if ($registro_num_factura['ncorr']=='') $num_factura_nuevo= 726;
          else $num_factura_nuevo = $registro_num_factura['ncorr']+1;
         
          if ($num_factura_nuevo=='') $num_factura_nuevo=1;

            $sql_filtro = "select * 
                    from folios_dte
                    where desde <= '".$num_factura_nuevo."' and 
                        hasta >= '".$num_factura_nuevo."' and 
                        tipo = 61";
            $res_filtro = mysql_query($sql_filtro,$link);
            if (mysql_num_rows($res_filtro)==0){
              echo "2";
              }
            else{
            	if (($guia<=$num_factura_nuevo)&&($guia>='725')){
            		echo "99";
            	}
            	else{
            		echo "3";
            	}

            }

		}
?>