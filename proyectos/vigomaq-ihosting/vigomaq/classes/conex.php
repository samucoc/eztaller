<?php

date_default_timezone_set('America/Caracas');  


//echo mysql_connect("190.3.171.83","vigomaq_user","OGh1Ahw4cie6kaix5Gungi9gogieph","vigomaq_intranet") or die(mysql_error(mysql_connect("190.3.171.83","vigomaq_user","OGh1Ahw4cie6kaix5Gungi9gogieph","vigomaq_intranet")));

function Conectarse()
{

   //if (!($link=mysql_connect("186.67.71.235","vigomaq","rtwvhhTE8X75bGyH")))

   if (!($link=mysql_connect("190.3.171.83","vigomaq_user","OGh1Ahw4cie6kaix5Gungi9gogieph")))

   {

	echo "Error conectando a la base de datos.";

      exit();

   }

   if (!mysql_select_db("vigomaq_intranet",$link))

   {

      echo "Error seleccionando la base de datos.";

      exit();

   }

   return $link;

}

?>