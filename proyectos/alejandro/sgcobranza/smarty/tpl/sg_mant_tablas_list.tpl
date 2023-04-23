<div id="pivot">
<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">
<!--
	<tr>
    	<td colspan="10" class="grilla-tab-fila-titulo" align='right'>Cantidad de filas: {$cant_filas}</td>
	</tr>
-->
	<tr>
    	<td colspan="10" class="grilla-tab-fila-titulo" align='center'>Listado de {$TITULO_TABLA}</td>
	</tr>
{if ($TBL == 'vehiculos')}
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Marca</td>
		<td class="grilla-tab-fila-titulo" align='center'>Modelo</td>
		<td class="grilla-tab-fila-titulo" align='center'>A&ntilde;o</td>
		<td class="grilla-tab-fila-titulo" align='center'>Color</td>
		<td class="grilla-tab-fila-titulo" align='center'>Tipo Vehiculo</td>
		<td class="grilla-tab-fila-titulo" align='center'>Patente </td>
		<td class="grilla-tab-fila-titulo" align='center'>Fecha adquisicion</td>
		<td class="grilla-tab-fila-titulo" align='center'>Empresa </td>
		<td class="grilla-tab-fila-titulo" align='center'>Valor Comercial</td>
		<td class="grilla-tab-fila-titulo" align='center'>Valor Comercial Actual</td>
		<td class="grilla-tab-fila-titulo" align='center'>Rendimiento por Litro </td>
		<td class="grilla-tab-fila-titulo" align='center'>Tipo de Combustible</td>
		<td class="grilla-tab-fila-titulo" align='center'>Estado</td>
		<td class="grilla-tab-fila-titulo" align='center'>Mes Revision Tecnica</td>
		<td class="grilla-tab-fila-titulo" align='center'>Empresa Aseguradora</td>
		<!--<td class="grilla-tab-fila-titulo" align='center'>Monto Prima</td>
		<td class="grilla-tab-fila-titulo" align='center'>Mes de Termino de seguro</td>-->
		<td class="grilla-tab-fila-titulo" align='center'></td>
	</tr>
	{section name=registros loop=$arrRegistros}
		<tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
			<td class="grilla-tab-fila-campo">
                            <a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].marca}</a>
                        </td>
			<td class="grilla-tab-fila-campo">
                            <a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].modelo}</a>
                        </td>
			<td class="grilla-tab-fila-campo">
                            <a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].anio}</a>
                        </td>
			<td class="grilla-tab-fila-campo">
                            <a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].color}</a>
                        </td>
			<td class="grilla-tab-fila-campo">
                            <a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].tipo_veh}</a>
                        </td>
			<td class="grilla-tab-fila-campo">
                            <a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].patente}</a>
                        </td>
			<td class="grilla-tab-fila-campo">
                            <a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].fecha_adq}</a>
                        </td>
			<td class="grilla-tab-fila-campo">
                            <a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].empresa}</a>
                        </td>
			<td class="grilla-tab-fila-campo">
                            <a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].valor}</a>
                        </td>
			<td class="grilla-tab-fila-campo">
                            <a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].valor_actual}</a>
                        </td>
			<td class="grilla-tab-fila-campo">
                            <a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].rend}</a>
                        </td>
			<td class="grilla-tab-fila-campo">
                            <a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].tipo_comb}</a>
                        </td>
			<td class="grilla-tab-fila-campo">
                            <a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].estado}</a>
                        </td>
			<td class="grilla-tab-fila-campo">
                            <a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].rev_tec}</a>
                        </td>
			<td class="grilla-tab-fila-campo">
                            <a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].emp_aseg}</a>
                        </td>
			<!--<td class="grilla-tab-fila-campo">
                            <a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].mont_prima}</a>
                        </td>
                        <td class="grilla-tab-fila-campo">
                            <a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].term_seguro}</a>
                        </td>-->
			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">
				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '{$arrRegistros[registros].ncorr}');" width="16"></a>
			</td>
		</tr>
	{/section}
{elseif ($TBL == 'personas')}
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Rut</td>
		<td class="grilla-tab-fila-titulo" align='center'>Nombre</td>
		<td class="grilla-tab-fila-titulo" align='center'>Apellido Paterno</td>
		<td class="grilla-tab-fila-titulo" align='center'>Apellido Materno</td>
		<td class="grilla-tab-fila-titulo" align='center'></td>
	</tr>
	{section name=registros loop=$arrRegistros}
		<tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].rut}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].nombre}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].ape_pat}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].ape_mat}</a></td>
			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">
				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '{$arrRegistros[registros].ncorr}');" width="16"></a>
			</td>
		</tr>
	{/section}
{elseif ($TBL == 'usuarios')}
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Nombre</td>
		<td class="grilla-tab-fila-titulo" align='center'>Usuario</td>
		<td class="grilla-tab-fila-titulo" align='center'>Password</td>
		<td class="grilla-tab-fila-titulo" align='center'>Perfil</td>
		<td class="grilla-tab-fila-titulo" align='center'></td>
	</tr>
	{section name=registros loop=$arrRegistros}
		<tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].nombre}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].usuario}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">XXXXXXXXXXX</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].perfil}</a></td>
			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">
				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '{$arrRegistros[registros].ncorr}');" width="16"></a>
			</td>
		</tr>
	{/section}
{elseif ($TBL == 'perfiles')}
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Nombre</td>
		<td class="grilla-tab-fila-titulo" align='center'>Descripcion</td>
		<td class="grilla-tab-fila-titulo" align='center'>Codigo</td>
		<td class="grilla-tab-fila-titulo" align='center'></td>
	</tr>
	{section name=registros loop=$arrRegistros}
		<tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].nombre}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].descripcion}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].codigo}</a></td>
			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">
				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '{$arrRegistros[registros].ncorr}');" width="16"></a>
			</td>
		</tr>
	{/section}
{elseif ($TBL == 'usuarios_perfiles_menu')}
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Perfil</td>
		<td class="grilla-tab-fila-titulo" align='center'>Menu</td>
		<td class="grilla-tab-fila-titulo" align='center'>Pagina</td>
		<td class="grilla-tab-fila-titulo" align='center'>Orden</td>
		<td class="grilla-tab-fila-titulo" align='center'></td>
	</tr>
	{section name=registros loop=$arrRegistros}
		<tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].perfil}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].menu}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].pagina}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].orden}</a></td>
			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">
				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '{$arrRegistros[registros].ncorr}');" width="16"></a>
			</td>
		</tr>
	{/section}

{elseif ($TBL == 'menues')}
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Descripcion</td>
		<td class="grilla-tab-fila-titulo" align='center'>Perfil Acceso</td>
		<td class="grilla-tab-fila-titulo" align='center'>Orden Menu</td>
		<td class="grilla-tab-fila-titulo" align='center'></td>
	</tr>
	{section name=registros loop=$arrRegistros}
		<tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].descripcion}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].perfil}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].orden}</a></td>
			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">
				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '{$arrRegistros[registros].ncorr}');" width="16"></a>
			</td>
		</tr>
	{/section}
{elseif ($TBL == 'menues_hijos')}
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Menu Padre</td>
		<td class="grilla-tab-fila-titulo" align='center'>Sub Menu</td>
		<td class="grilla-tab-fila-titulo" align='center'>Descripcion</td>
		<td class="grilla-tab-fila-titulo" align='center'>Link de acceso</td>
		<td class="grilla-tab-fila-titulo" align='center'>Perfil de acceso</td>
		<td class="grilla-tab-fila-titulo" align='center'>Orden</td>
		<td class="grilla-tab-fila-titulo" align='center'>Mostrar</td>
		<td class="grilla-tab-fila-titulo" align='center'></td>
	</tr>
	{section name=registros loop=$arrRegistros}
		<tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].padre}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].sub_menu}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].descripcion}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].link}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].perfil}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].orden}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].mostrar}</a></td>
			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">
				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '{$arrRegistros[registros].ncorr}');" width="16"></a>
			</td>
		</tr>
	{/section}

{elseif ($TBL == 'correos')}
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Nombre</td>
		<td class="grilla-tab-fila-titulo" align='center'>Usuario</td>
		<td class="grilla-tab-fila-titulo" align='center'>Correo Electronico</td>
		<td class="grilla-tab-fila-titulo" align='center'></td>
	</tr>
	{section name=registros loop=$arrRegistros}
		<tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].nombre}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].usuario}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].correo}</a></td>
			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">
				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '{$arrRegistros[registros].ncorr}');" width="16"></a>
			</td>
		</tr>
	{/section}

{elseif ($TBL == 'Horas')}
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Tipo de Horario</td>
		<td class="grilla-tab-fila-titulo" align='center'>Codigo Hora</td>
		<td class="grilla-tab-fila-titulo" align='center'>Descripcion</td>
		<td class="grilla-tab-fila-titulo" align='center'></td>
	</tr>
	{section name=registros loop=$arrRegistros}
		<tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].tipo_horario}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].codigo_hora}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].descripcion}</a></td>
			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">
				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '{$arrRegistros[registros].ncorr}');" width="16"></a>
			</td>
		</tr>
	{/section}

{elseif ($TBL == 'proveedor')}
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Rut</td>
		<td class="grilla-tab-fila-titulo" align='center'>DV</td>
		<td class="grilla-tab-fila-titulo" align='center'>Nombre</td>
		<td class="grilla-tab-fila-titulo" align='center'>Giro</td>
		<td class="grilla-tab-fila-titulo" align='center'>Direccion</td>
		<td class="grilla-tab-fila-titulo" align='center'></td>
	</tr>
	{section name=registros loop=$arrRegistros}
		<tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].nombre}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].rut}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].direccion}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].telefono}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].email}</a></td>
			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">
				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '{$arrRegistros[registros].ncorr}');" width="16"></a>
			</td>
		</tr>
	{/section}

{elseif ($TBL == 'clientes')}
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Razon Social</td>
		<td class="grilla-tab-fila-titulo" align='center'>Rut</td>
		<td class="grilla-tab-fila-titulo" align='center'>Direccion</td>
		<td class="grilla-tab-fila-titulo" align='center'>Telefono</td>
		<td class="grilla-tab-fila-titulo" align='center'>Correo Electronico</td>
		<td class="grilla-tab-fila-titulo" align='center'></td>
	</tr>
	{section name=registros loop=$arrRegistros}
		<tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].nombre}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].rut}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].direccion}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].telefono}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].email}</a></td>
			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">
				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '{$arrRegistros[registros].ncorr}');" width="16"></a>
			</td>
		</tr>
	{/section}

{elseif ($TBL == 'prestadores')}
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Razon Social</td>
		<td class="grilla-tab-fila-titulo" align='center'>Rut</td>
		<td class="grilla-tab-fila-titulo" align='center'>Direccion</td>
		<td class="grilla-tab-fila-titulo" align='center'>Telefono</td>
		<td class="grilla-tab-fila-titulo" align='center'>Correo Electronico</td>
		<td class="grilla-tab-fila-titulo" align='center'></td>
	</tr>
	{section name=registros loop=$arrRegistros}
		<tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].nombre}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].rut}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].direccion}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].telefono}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].email}</a></td>
			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">
				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '{$arrRegistros[registros].ncorr}');" width="16"></a>
			</td>
		</tr>
	{/section}
{elseif ($TBL == 'trabajadores_tienen_cargas')}
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Rut</td>
		<td class="grilla-tab-fila-titulo" align='center'>Nombres</td>
		<td class="grilla-tab-fila-titulo" align='center'>Apellido Paterno</td>
		<td class="grilla-tab-fila-titulo" align='center'>Apellido Materno</td>
		<td class="grilla-tab-fila-titulo" align='center'>Fecha Nacimiento</td>
		<td class="grilla-tab-fila-titulo" align='center'>Edad</td>
		<td class="grilla-tab-fila-titulo" align='center'>Parentesco</td>
		<td class="grilla-tab-fila-titulo" align='center'>Estado</td>
		<td class="grilla-tab-fila-titulo" align='center'></td>
	</tr>
	{section name=registros loop=$arrRegistros}
		<tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].rut}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].nombre}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].apellido_paterno}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].apellido_materno}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].fecha_nac|date_format:"%d/%m/%Y"}</a></td>
            <td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].edad}</a></td>
            <td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].parentesco}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].estado}</a></td>
			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">
				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '{$arrRegistros[registros].ncorr}');" width="16"></a>
			</td>
		</tr>
	{/section}
{elseif ($TBL == 'alumnos')}
    <tr>
		<td class="grilla-tab-fila-titulo" align='center'>Nro Lista</td>
		<td class="grilla-tab-fila-titulo" align='center'>Nombres</td>
		<td class="grilla-tab-fila-titulo" align='center'>Curso</td>
		<td class="grilla-tab-fila-titulo" align='center'></td>
	</tr>
	{section name=registros loop=$arrRegistros}
		<tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].rut}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].nombres}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].curso}</a></td>
			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">
				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '{$arrRegistros[registros].ncorr}');" width="16"></a>
			</td>
		</tr>
	{/section}
{elseif ($TBL == 'Postulantes')}
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Nombres</td>
		<td class="grilla-tab-fila-titulo" align='center'>Curso</td>
		<td class="grilla-tab-fila-titulo" align='center'></td>
	</tr>
	{section name=registros loop=$arrRegistros}
		<tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].nombres}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].curso}</a></td>
			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">
				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '{$arrRegistros[registros].ncorr}');" width="16"></a>
			</td>
		</tr>
	{/section}
{elseif ($TBL == 'Profesores')}
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Rut</td>
		<td class="grilla-tab-fila-titulo" align='center'>Nombres</td>
		<td class="grilla-tab-fila-titulo" align='center'>Direccion</td>
		<td class="grilla-tab-fila-titulo" align='center'>Especialidad</td>  
		<td class="grilla-tab-fila-titulo" align='center'></td>
	</tr>
	{section name=registros loop=$arrRegistros}
		<tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].rut}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].apellido_paterno} {$arrRegistros[registros].apellido_materno}, {$arrRegistros[registros].nombre}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].direccion}</a></td>
            <td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].telefono}</a></td>
			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">
				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '{$arrRegistros[registros].ncorr}');" width="16"></a>
			</td>
		</tr>
	{/section}
{elseif ($TBL == 'Apoderados')}
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Rut</td>
		<td class="grilla-tab-fila-titulo" align='center'>Nombres</td>
		<td class="grilla-tab-fila-titulo" align='center'>Apellido Paterno</td>
		<td class="grilla-tab-fila-titulo" align='center'>Apellido Materno</td>
		<td class="grilla-tab-fila-titulo" align='center'>Direccion</td>
		<td class="grilla-tab-fila-titulo" align='center'>Telefono</td>
		<td class="grilla-tab-fila-titulo" align='center'></td>
	</tr>
	{section name=registros loop=$arrRegistros}
		<tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].rut}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].nombre}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].apellido_paterno}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].apellido_materno}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].direccion}</a></td>
            <td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].telefono}</a></td>
			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">
				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '{$arrRegistros[registros].ncorr}');" width="16"></a>
			</td>
		</tr>
	{/section}
{elseif ($TBL == 'Niveles')}
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Nombre Nivel</td>
		<td class="grilla-tab-fila-titulo" align='center'>Resolucion Autoriza</td>
		<td class="grilla-tab-fila-titulo" align='center'>Fecha Resolucion Autoriza</td>
		<td class="grilla-tab-fila-titulo" align='center'>Resolucion Cierre</td>
		<td class="grilla-tab-fila-titulo" align='center'>Fecha Resolucion Cierre</td>
		<td class="grilla-tab-fila-titulo" align='center'></td>
	</tr>
	{section name=registros loop=$arrRegistros}
		<tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].nombre_nivel}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].resolucion_autoriza}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].FechaResolucionAutoriza}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].ResolucionCierre}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].FechaResolucionCierre}</a></td>
			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">
				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '{$arrRegistros[registros].ncorr}');" width="16"></a>
			</td>
		</tr>
	{/section}
{elseif ($TBL == 'Asignaturas')}
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Curso</td>
		<td class="grilla-tab-fila-titulo" align='center'>Asignatura</td>
		<td class="grilla-tab-fila-titulo" align='center'>Profesor</td>
		<td class="grilla-tab-fila-titulo" align='center'></td>
	</tr>
	{section name=registros loop=$arrRegistros}
		<tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].curso}_{$arrRegistros[registros].asignatura}_{$arrRegistros[registros].profesor}');">{$arrRegistros[registros].curso}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].curso}_{$arrRegistros[registros].asignatura}_{$arrRegistros[registros].profesor}');">{$arrRegistros[registros].asignatura}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].curso}_{$arrRegistros[registros].asignatura}_{$arrRegistros[registros].profesor}');">{$arrRegistros[registros].profesor}</a></td>
			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">
				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '{$arrRegistros[registros].ncorr}');" width="16"></a>
			</td>
		</tr>
	{/section}
{elseif ($TBL == 'Pruebas')}
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Curso</td>
		<td class="grilla-tab-fila-titulo" align='center'>Asignatura</td>
		<td class="grilla-tab-fila-titulo" align='center'>Profesor</td>
		<td class="grilla-tab-fila-titulo" align='center'>Descripcion Prueba</td>
		<td class="grilla-tab-fila-titulo" align='center'></td>
	</tr>
	{section name=registros loop=$arrRegistros}
		<tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].curso}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].asignatura}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].profesor}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].descripcion_prueba}</a></td>
			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">
				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '{$arrRegistros[registros].ncorr}');" width="16"></a>
			</td>
		</tr>
	{/section}
{elseif ($TBL == 'Retiros')}
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Nombre Alumno</td>
		<td class="grilla-tab-fila-titulo" align='center'>Curso Alumno</td>
		<td class="grilla-tab-fila-titulo" align='center'>Descripcion</td>
		<td class="grilla-tab-fila-titulo" align='center'></td>
	</tr>
	{section name=registros loop=$arrRegistros}
		<tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].alumno}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].curso}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].observacion}</a></td>
			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">
				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '{$arrRegistros[registros].ncorr}');" width="16"></a>
			</td>
		</tr>
	{/section}
{elseif ($TBL == 'HojasDeVida')}
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Fecha</td>
		<td class="grilla-tab-fila-titulo" align='center' width="5%">Tipo</td>
		<td class="grilla-tab-fila-titulo" align='center'>Motivo</td>
		<td class="grilla-tab-fila-titulo" align='center'>Descripcion</td>
		<td class="grilla-tab-fila-titulo" align='center'></td>
	</tr>
	{section name=registros loop=$arrRegistros}
		<tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].fecha|date_format:"%d/%m/%Y"}</a></td>
			{if $arrRegistros[registros].tipo == 'Positiva'}
            <td class="grilla-tab-fila-campo" style="background-color:#C30" onclick=	"xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">
            </td>
			{else}	
            <td class="grilla-tab-fila-campo" style="background-color:#356AA0" onclick=	"xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">
            </td>
            {/if}
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].motivo}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].observacion}</a></td>
			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">
				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '{$arrRegistros[registros].ncorr}');" width="16"></a>
			</td>
		</tr>
	{/section}
{elseif ($TBL == 'Eximisiones')}
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Alumno</td>
		<td class="grilla-tab-fila-titulo" align='center'>Fecha</td>
		<td class="grilla-tab-fila-titulo" align='center'></td>
	</tr>
	{section name=registros loop=$arrRegistros}
		<tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].alumno}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].fecha|date_format:"%d/%m/%Y"}</a></td>
			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">
				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '{$arrRegistros[registros].ncorr}');" width="16"></a>
			</td>
		</tr>
	{/section}
{elseif ($TBL == 'Talonarios')}
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Desde</td>
		<td class="grilla-tab-fila-titulo" align='center'>Hasta</td>
		<td class="grilla-tab-fila-titulo" align='center'>Fecha</td>
		<td class="grilla-tab-fila-titulo" align='center'>Observacion</td>
		<td class="grilla-tab-fila-titulo" align='center'></td>
	</tr>
	{section name=registros loop=$arrRegistros}
		<tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].desde}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].hasta}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].fecha|date_format:"%d/%m/%Y"}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].observacion}</a></td>
			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">
				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '{$arrRegistros[registros].ncorr}');" width="16"></a>
			</td>
		</tr>
	{/section}
{elseif ($TBL == 'Movimientos')}
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Numero Boleta</td>
		<td class="grilla-tab-fila-titulo" align='center'>Fecha</td>
		<td class="grilla-tab-fila-titulo" align='center'>Alumno</td>
		<td class="grilla-tab-fila-titulo" align='center'>Valor</td>
		<td class="grilla-tab-fila-titulo" align='center'>Estado</td>
		<td class="grilla-tab-fila-titulo" align='center'>Tipo Pago</td>
		<td class="grilla-tab-fila-titulo" align='center'></td>
	</tr>
	{section name=registros loop=$arrRegistros}
		<tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].nro_boleta}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].fecha|date_format:"%d/%m/%Y"}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].alumno}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].valor}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].estado}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].tipo_pago}</a></td>
			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">
				{if ($USUARIO == 'sige')}
					<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '{$arrRegistros[registros].ncorr}');" width="16"></a>
				{/if}
			</td>
		</tr>
	{/section}
{elseif ($TBL == 'Becas')}
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Alumno</td>
		<td class="grilla-tab-fila-titulo" align='center'>Cursos</td>
		<td class="grilla-tab-fila-titulo" align='center'>Periodo</td>
		<td class="grilla-tab-fila-titulo" align='center'>Incorporacion</td>
		<td class="grilla-tab-fila-titulo" align='center'>Colegiatura</td>
		<td class="grilla-tab-fila-titulo" align='center'>Tipo Beca</td>
		<td class="grilla-tab-fila-titulo" align='center'></td>
	</tr>
	{section name=registros loop=$arrRegistros}
		<tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].alumno}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].NombreCurso}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].periodo}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].incorporacion}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].colegiatura}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].tipo_beca}</a></td>
			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">
				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '{$arrRegistros[registros].ncorr}');" width="16"></a>
			</td>
		</tr>
	{/section}
{elseif ($TBL == 'TipoBeca')}
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Descripcion</td>
		<td class="grilla-tab-fila-titulo" align='center'>Cuota 0</td>
		<td class="grilla-tab-fila-titulo" align='center'>Colegiatura</td>
		<td class="grilla-tab-fila-titulo" align='center'></td>
	</tr>
	{section name=registros loop=$arrRegistros}
		<tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].descripcion}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].cuota_0}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].colegiatura}</a></td>
			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">
				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '{$arrRegistros[registros].ncorr}');" width="16"></a>
			</td>
		</tr>
	{/section}
{elseif ($TBL == 'Compromisos')}
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Alumno</td>
		<td class="grilla-tab-fila-titulo" align='center'>Periodo</td>
		<td class="grilla-tab-fila-titulo" align='center'>Fecha</td>
		<td class="grilla-tab-fila-titulo" align='center'>Descripcion</td>
		<td class="grilla-tab-fila-titulo" align='center'></td>
	</tr>
	{section name=registros loop=$arrRegistros}
		<tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].alumno}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].periodo}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].fecha|date_format:"%d/%m/%Y"}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].descripcion}</a></td>
			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">
				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '{$arrRegistros[registros].ncorr}');" width="16"></a>
			</td>
		</tr>
	{/section}
{elseif ($TBL == 'Bitacoras')}
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Fecha Gestion</td>
		<td class="grilla-tab-fila-titulo" align='center' style="width: 50%">Descripcion</td>
		<td class="grilla-tab-fila-titulo" align='center'>Fecha Compromiso</td>
		<td class="grilla-tab-fila-titulo" align='center'></td>
	</tr>
	{section name=registros loop=$arrRegistros}
		<tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
			<td class="grilla-tab-fila-campo" align="center"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].fecha}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].descripcion}</a></td>
			<td class="grilla-tab-fila-campo" align="center"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">
				{if $arrRegistros[registros].fecha_1 <> '0000-00-00'}
				{$arrRegistros[registros].fecha_1}
				{else}
				{/if}
			</a></td>
			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">
				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '{$arrRegistros[registros].ncorr}');" width="16"></a>
			</td>
		</tr>
	{/section}
{elseif ($TBL == 'Aranceles')}
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Nombre</td>
		<td class="grilla-tab-fila-titulo" align='center'>Periodo</td>
		<td class="grilla-tab-fila-titulo" align='center'>Cuota Inicial</td>
		<td class="grilla-tab-fila-titulo" align='center'>Colegiatura</td>
		<td class="grilla-tab-fila-titulo" align='center'></td>
	</tr>
	{section name=registros loop=$arrRegistros}
		<tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].nombre}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].periodo}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].incorporacion}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].colegiatura}</a></td>
			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">
				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '{$arrRegistros[registros].ncorr}');" width="16"></a>
			</td>
		</tr>
	{/section}
{elseif ($TBL == 'Cursos')}
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Codigo</td>
		<td class="grilla-tab-fila-titulo" align='center'>Descripcion</td>
		<td class="grilla-tab-fila-titulo" align='center'>Arancel</td>
		<td class="grilla-tab-fila-titulo" align='center'></td>
	</tr>
	{section name=registros loop=$arrRegistros}
		<tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].codigo}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].descripcion}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].arancel}</a></td>
			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">
				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '{$arrRegistros[registros].ncorr}');" width="16"></a>
			</td>
		</tr>
	{/section}
{elseif ($TBL == 'Devoluciones')}
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Nro Devolucion</td>
		<td class="grilla-tab-fila-titulo" align='center'>Fecha</td>
		<td class="grilla-tab-fila-titulo" align='center'>Nro Boleta</td>
		<td class="grilla-tab-fila-titulo" align='center'>Monto</td>
		<td class="grilla-tab-fila-titulo" align='center'>Glosa</td>
		<td class="grilla-tab-fila-titulo" align='center'></td>
	</tr>
	{section name=registros loop=$arrRegistros}
		<tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].numero}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].fecha|date_format:"%d/%m/%Y"}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].nro_boleta}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].monto}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].glosa}</a></td>
			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">
				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '{$arrRegistros[registros].ncorr}');" width="16"></a>
			</td>
		</tr>
	{/section}
{else}
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Codigo</td>
		<td class="grilla-tab-fila-titulo" align='center'>Descripcion</td>
		<td class="grilla-tab-fila-titulo" align='center'></td>
	</tr>
	{section name=registros loop=$arrRegistros}
		<tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].ncorr}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].desc}</a></td>
			<td class="grilla-tab-fila-campo" style="WIDTH: 5%;">
				<a href="#" style="cursor: hand;"><img src="../images/basicos/eliminar.png" border=0 title="Eliminar"   onclick="xajax_EliminarItem(xajax.getFormValues('Form1'), '{$arrRegistros[registros].ncorr}');" width="16"></a>
			</td>
		</tr>
	{/section}
{/if}
	<tr>
    <td colspan='16' class="grilla-tab-fila-titulo">
    	<a href="#" style="cursor: hand;"><img src="../images/basicos/imprimir.png" border=0 title="Imprimir" onclick="ImprimeDiv('divresultado');" width="32"></a>
    </td>
    
    </tr>
</table>
</div>