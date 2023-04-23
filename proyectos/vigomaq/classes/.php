<?php
function Conectarse()
{
   if (!($link=mysql_connect("186.67.71.229","vigomaq","rtwvhhTE8X75bGyH")))
   //if (!($link=mysql_connect("localhost","root","")))
   {
      echo "Error conectando a la base de datos.";
      exit();
   }
   if (!mysql_select_db("vigomaq_testing",$link))
   {
      echo "Error seleccionando la base de datos.";
      exit();
   }
   return $link;
}
?>
