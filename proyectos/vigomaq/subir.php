<?php 
ob_start(); 
session_start(); 
//conectamos a la base de datos 
mysql_connect("186.67.71.235","vigomaq","rtwvhhTE8X75bGyH"); 
//mysql_connect("localhost","root","");  
//mysql_connect("localhost","root","");
mysql_select_db("vigomaq_intranet"); 

if(isset($_SESSION['usuario']))$usuario=$_SESSION['usuario'];else $usuario=false; 
if(isset($_SESSION['tipo_usuario']))$tipo_usuario=$_SESSION['tipo_usuario'];else $tipo_usuario=false;
if (!$_SESSION['usuario']) {
    header("Location: ./login.php");
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="shortcut icon" href="http://intranet.vigomaq_intranet.cl/favicon.ico">
</head>
<body>

<form name="formu" id="formu" action="recibido2.php" method="post" enctype="multipart/form-data">
	 <dl>            
   <dt>
     <label>Imagen principal a Subir :</label>
	         <?php
			{
				$valor1 = $_GET["id"];
				echo "Codigo: $valor1";
				$codigo = $valor1;
			}
		?>
   </dt>
   <dd><div id="adjuntos">
   <input type="file" name="archivos[]" /><br />
   </div></dd>    
   <dd><input type="hidden" name="idpropiedad" value="<?php echo $valor1; ?>"><input type="submit" value="Enviar" id="envia" name="envia" /></dd>
     </dl>
</form>

<script type="text/javascript">
var numero = 0; 
evento = function (evt) { 
   return (!evt) ? event : evt;
}

addCampo = function () { 
   nDiv = document.createElement('div');
   nDiv.className = 'archivo';
   nDiv.id = 'file' + (++numero);
   nCampo = document.createElement('input');
   nCampo.name = 'archivos[]';
   nCampo.type = 'file';
   a = document.createElement('a');
   a.name = nDiv.id;
   a.href = '#';
   a.onclick = elimCamp;
   a.innerHTML = 'Eliminar';
   nDiv.appendChild(nCampo);
   nDiv.appendChild(a);
   container = document.getElementById('adjuntos');
   container.appendChild(nDiv);
}
elimCamp = function (evt){
   evt = evento(evt);
   nCampo = rObj(evt);
   div = document.getElementById(nCampo.name);
   div.parentNode.removeChild(div);
}
rObj = function (evt) { 
   return evt.srcElement ?  evt.srcElement : evt.target;
}
</script>

</body>
</html>
