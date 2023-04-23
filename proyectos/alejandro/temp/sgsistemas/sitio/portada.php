<?php
session_set_cookie_params('18000'); // 5 HORAS
session_start();
if (!isset($_SESSION['alycar_usuario'])){
	?>
	<script>top.location.href='sg_index.php'</script>
	<?php
}


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<HTML>
	<HEAD>
		<title>Sistema Gestión 2.0</title>
	</HEAD>
	<body bgcolor="#ffffff">
		<form id="Form1" name="Form1" method="post" runat="server">

			<table style="HEIGHT:90%;WIDTH:90%;" border=0 bgcolor="#ffffff"> 
			<tr align="center" bottom="middle"><td> 
			<table border=0 style="WIDTH:30%; color: #ffffff;"> 
				
				<tr>
					<td align= "center" colspan="2" style="FONT-WEIGHT: bold; FONT-SIZE: 12px; FONT-FAMILY: sans-serif;" border=0>
						<?php echo "<img src='../images/logo_banco.png'><br><br><br>";?>
						
					</td>
				</tr>
			
			</td></tr> 
			</table> 

		</form>
	</body>
</HTML>