<?php
	session_start();
			
	unset($_SESSION['alycar_nombreusuario']);
	unset($_SESSION['alycar_usuario']);
	unset($_SESSION['alycar_sistemas']);

	//header("Location:http://localhost/rentacar/sitio");
?>	
<script>top.location.href='sg_index.php'</script>	
