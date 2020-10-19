<?php
/* Smarty version 3.1.33, created on 2020-10-18 23:44:02
  from 'C:\xampp\htdocs\eztaller\alejandro\sgbodega\smarty\tpl\sg_index.tpl' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.33',
  'unifunc' => 'content_5f8cfd72873258_38748053',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '782e11a5a35579ac9949a5035ae05f20b5fd9ca3' => 
    array (
      0 => 'C:\\xampp\\htdocs\\eztaller\\alejandro\\sgbodega\\smarty\\tpl\\sg_index.tpl',
      1 => 1603075438,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f8cfd72873258_38748053 (Smarty_Internal_Template $_smarty_tpl) {
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN">
<html>
<head>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf8">

<title>Portal Prototipo</title>
<meta content="http://schemas.microsoft.com/intellisense/ie5" name="vs_targetSchema">

<!-- validaciones de javascript -->

	<?php echo '<script'; ?>
 type="text/javascript" src="../includes_js/funciones.js"><?php echo '</script'; ?>
>

<!-- estilos -->
	<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">

<!-- Código del Icono 
<link href="../images/aricon.PNG" type="image/x-icon" rel="shortcut icon" />
-->
<link rel="icon" type="image/x-icon" sizes="32x32" rel="shortcut icon" href="../images/favicon.ico">

</head>

		
<frameset cols="35%,*,35%" border="0" frameborder="0" y framespacing="0">

	<frame name="1" frameborder="0" border="0">
	
	<frameset rows="25%,*,25%" border="0" frameborder="0" y framespacing="0">
			
			<frame name="superior" frameborder="0" scrolling="no" noresize>
			<frame name="login" src="sg_login.php" frameborder="0" border="0" marginheight="0" noresize>
			<frame name="top"  frameborder="0" scrolling="no" noresize>
	
	</frameset>
	
	<frame name="2" frameborder="0" border="0" >

</frameset><noframes></noframes>
</html>
<?php }
}
