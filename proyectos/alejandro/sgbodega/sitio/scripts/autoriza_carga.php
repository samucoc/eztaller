<?php
include "../../includes/php/conf_bd.php";
$id_carga = $_GET['id_carga'];

       echo $sql = "update cargas_extras 
                    set ce_autorizado = 'SI'
                  where ce_ncorr = ".$id_carga;
        $res = mysql_query($sql,$conexion);
?>
<script language="javascript">
window.close();
</script> 