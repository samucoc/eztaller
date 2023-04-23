<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<HEAD>
	
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	
	{$xajax_js}
	
	<title>Menu</title>
		<!-- estilos -->
		<LINK href="../estilos/estilo.css" type="text/css" rel="stylesheet">

</head>

<body style="background:#ffffff;"> 
					
	<form id="Form1" name="Form1" method="post" runat="server">
		<table class="curvar" cellpadding="2" cellspacing="2" style="WIDTH: 100%; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
			<tr>
				<td>
					<table border="0" class="tabla-alycar-menu" cellpadding="0" cellspacing="0" style="width: 100%">
						<tr align="left">
							<td colspan="{$contador}">
								{literal}
								<style>
			                        #menu_gral ul li {
			                            width: 10% !important;
			                            }
			                        #menu_gral ul li ul li:hover, #menu_gral ul li ul li{
			                            width: 100% !important;
			                            }
			                            a.disabled {
										  pointer-events: none;
										}

										a:hover {
										  color: #000000;
										}

										a {
										  color: #000000;
										  font-size: 15px;
										}
										a:hover{
										  background-color: #C3E7F2;
										}

										.side-nav li a:not(.button) {
										  color: #447CAD;
										}

										.side-nav li a:not(.button):hover {
										  color: #447CAD;
										}
										* {
										    margin: 0;
										    padding: 0;
										    border: none;
										    position: relative;
										}
										#menu_gral {
										    font-family: sans-serif;
										    width: 100%;
										    margin: 1.5rem auto;
										    height: 30px;
										}
										#menu_gral ul {
										    list-style-type: none; 
										    text-align:center;
										    font-size: 0;
										}
										#menu_gral > ul li {
										    display: inline-block;
										    width: 16.6%;
										    position: relative;
										    background: #E7ECF1;

										}
										#menu_gral li a {
										  background:#447CAD;
										    display: block;
										    width: 100%;
										    text-decoration: none;
										    padding-left: 10px;
										    padding-right: 10px;
										    color: #ffffff;
										}
										#menu_gral ul li ul li a {
										  background:#447CAD;
										    display: block;
										    width: 300%;
										    text-decoration: none;
										    padding-left: 10px;
										    padding-right: 10px;
										    color: #ffffff!important;
										    text-align: left;
										}
										#menu_gral li:hover a, #menu_gral li a:focus {
										  /* color de cada menu al poner el mouse encima*/
										    width: 100%;
										    background: #E7ECF1;
										    color:#1B4978;
										}

										#menu_gral li ul {
										    position: absolute;
										    width: 0;
										    overflow: hidden;
										}
										#menu_gral li:hover ul, #menu_gral li:focus ul {
										  /* es el fondo de color debajo de los submenus*/
										    width: 129%;
										    margin: 0 -4rem -4rem -4rem;
										    padding: 0 4rem 0rem 4rem;
										    z-index: 5;
										}
										#menu_gral li li {
										    display: block;
										    width: 300%;
										    background-color: #000;
										}
										#menu_gral li:hover li a, #menu_gral li:focus li a {
										    width: 100%;
										    font-family: sans-serif;
										    font-size: .9rem;
										    line-height: 1.7rem;
										    border-top: 1px solid #e5e5e5;
										    background: #447CAD;
										}
										#menu_gral li li a:hover, #menu_gral li li a:focus {
										  color: #1B4978!important;
										    width: 100%;
										    background: #E7ECF1; 
										}
			                    </style>
			                    {/literal}
			                    <div id="menu_gral" style="margin-top: 10px !important;">
				                    <ul>
									{section name=registros loop=$arrRegistros}
										<li>
		                				<a href='#' >{$arrRegistros[registros].descripcion}</a>
		                					<ul>
		                				{section name=registrosDet loop=$arrRegistrosDet}
		                					{if ($arrRegistros[registros].menu_ncorr==$arrRegistrosDet[registrosDet].menu_ncorr)}
		                						<li>
												{if ($arrRegistrosDet[registrosDet].mhij_contr=='fancybox')}
						                            <a href='{$arrRegistrosDet[registrosDet].mhij_link}' class='menu_link fancybox.iframe'>{$arrRegistrosDet[registrosDet].mhij_desc}</a>
						                        {else}
						                        	<a href='{$arrRegistrosDet[registrosDet].mhij_link}'>{$arrRegistrosDet[registrosDet].mhij_desc}</a>
						                        {/if}
						                        </li>
											{/if}								
										{/section}
											</ul>
										</li>
									{/section}
										<li>
				       						<img  src="../images/user.png" border='0'>{$nombre_usuario} - {$anio} - (Financiamiento Compartido)
		            					</li>
									</ul>
								</div>
							</td>
						</tr>
					</table>
				<td>
			</tr>
			<tr>
				<td colspan="2">
					<div id="bloque" style="WIDTH: 100%; height:500px ; float: left; border: 1pt solid #B9B9B9; background:#ffffff">
						<iframe name="principal"  id="principal" src="portada.php" frameborder="0" WIDTH="100%" height="600px"></iframe>
					</div>
				</td>
			</tr>
		</table>
	</form>
</body>
</html>
