<?php
include "../../includes/php/conf_bd.php";
$id_carga = $_GET['id_carga'];

       $sql = "update cargas_adelantos
                    set ca_autorizado = 'SI'
                  where ca_ncorr = ".$id_carga;
        $res = mysql_query($sql,$conexion);
?>
<html>
<head>
<script>
 if (navigator.userAgent.indexOf("Firefox")!=-1){
   netscape.security.PrivilegeManager.enablePrivilege("UniversalBrowserWrite");
   alert("This will close the window");
   window.open('','_self');
   window.close();
  } else {
   this.focus();self.opener = this;self.close();
  }
</script>
</head>
<body>
	Si esta ventana persiste, favor de cerrarla.

</body>
</html>