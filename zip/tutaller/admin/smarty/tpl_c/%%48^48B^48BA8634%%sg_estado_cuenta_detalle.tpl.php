<?php /* Smarty version 2.6.18, created on 2016-03-29 12:21:44
         compiled from sg_estado_cuenta_detalle.tpl */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

	<HEAD>
		
		<?php echo $this->_tpl_vars['xajax_js']; ?>

		
		<title></title>
       <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
		
		<!-- validaciones de javascript -->
			<script type="text/javascript" src="../includes_js/funciones.js"></script>
		
		<!-- librerias para popup submodal -->
			<link rel="stylesheet" type="text/css" href="submodal/subModal.css" /> 
			<script type="text/javascript" src="submodal/common.js"></script>
			<script type="text/javascript" src="submodal/subModal.js"></script>
		
		<!-- aqui se puede agregar el cod. para la norma de las páginas... -->
		<link rel="stylesheet" type="text/css" media="all" href="calendario/calendar-brown.css" />
		<!-- librería principal del calendario -->
		<script type="text/javascript" src="calendario/calendar.js"></script>
		<!-- librería para cargar el lenguaje deseado --> 
		<script type="text/javascript" src="calendario/lang/calendar-es.js"></script>
		<!-- librería que declara la función Calendar.setup, que ayuda a generar un calendario en unas pocas líneas de código -->
		<script type="text/javascript" src="calendario/calendar-setup.js"></script>
                
                <!-- estilos -->
			<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">
			<LINK href="../estilos/smoothness/jquery-ui-1.10.0.custom.css" type="text/css" rel="stylesheet">	
                            
		<!-- atajos de teclado -->
			<script type="text/javascript" src="../includes_js/shortshut.js"></script>

			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-1.9.0.js"></script>
			<script type="text/javascript" src="../includes_js/jqueryui/js/jquery-ui-1.10.0.custom.js"></script>
            <script type="text/javascript" src="../includes_js/jquery.maskedinput.1.3.1.js"></script>		
		<?php echo '
		<script type="text/javascript">
			 $(window).load(function(){
				 xajax_Grabar(xajax.getFormValues(\'Form1\'));
				 });
		</script>
		'; ?>

	
	</HEAD>
	<body style="background:#ffffff;"> 
					
        <div id="divcontenedor" align="left" style="margin:2px; padding: 2px;">
            <table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 99%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
                <tr>
                    <td>
                        <form id="Form1" name="Form1" method="post" runat="server">
                            <br>
                            <table border="0" cellpadding="0" cellspacing="0" style="width: 100%">
                                <tr align="left" valign="middle">
                                    <td style="width: 7%" align='right'><img src="../images/Coins-48.png"></td>
                                    <td style="width: 93%"><label class="form-titulo">&nbsp;&nbsp;Detalle Estado Cuenta</label></td>
                                </tr>
                            </table>
                            <br>
                            <input type="hidden" name="empresa" id="empresa" value="<?php echo $this->_tpl_vars['empresa']; ?>
"/>
                            <input type="hidden" name="tipo" id="tipo" value="<?php echo $this->_tpl_vars['tipo']; ?>
"/>
                            <input type="hidden" name="octanaje" id="octanaje" value="<?php echo $this->_tpl_vars['octanaje']; ?>
"/>
                            <input type="hidden" name="inicio" id="inicio" value="<?php echo $this->_tpl_vars['inicio']; ?>
"/>
                            <input type="hidden" name="fin" id="fin" value="<?php echo $this->_tpl_vars['fin']; ?>
"/>
                            <input type="hidden" name="depto" id="depto" value="<?php echo $this->_tpl_vars['depto']; ?>
"/>

                        </form>
                    </td>
                </tr>
            </table>
        </div>
        <div id="divlistado" align="left" style="display: none; margin-left:2px; padding: 2px;">
            <table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
                <tr>
                    <td>
                        <table border="0" class="tabla-alycar" cellpadding="0" cellspacing="0" style="width: 100%">
                            <tr align="left">
                                <td>
                                    <div id='divabonos'><div>
                                </td>
                            </TR>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
	</body>
</HTML>