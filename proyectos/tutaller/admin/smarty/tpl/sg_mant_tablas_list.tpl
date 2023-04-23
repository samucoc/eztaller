<div id="pivot">
<table class="grilla-tab" border="0" cellspacing="0" cellpadding="0" width="100%">

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
			</td>		</tr>
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
			</td>		</tr>
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
			</td>		</tr>
	{/section}

{elseif ($TBL == 'tipo_repuestos')}
	<tr>
		<td class="grilla-tab-fila-titulo" align='center'>Nro Correlativo</td>
		<td class="grilla-tab-fila-titulo" align='center'>Repuesto</td>
		<td class="grilla-tab-fila-titulo" align='center'>Especificacion</td>

		<td class="grilla-tab-fila-titulo" align='center'></td>

		
	</tr>
	{section name=registros loop=$arrRegistros}
		<tr onmouseover='this.style.background="#FFFF88"' onmouseout='this.style.background="white"'>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].ncorr}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].repuesto}</a></td>
			<td class="grilla-tab-fila-campo"><a href='#' onclick="xajax_TraeValor(xajax.getFormValues('Form1'),'{$arrRegistros[registros].ncorr}');">{$arrRegistros[registros].especificacion}</a></td>
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
        <input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="ImprimeDiv('divresultado');">
        <!--<input type="button" name="btnImprimir" value="Imprimir" class="boton" onclick="xajax_Imprime();">-->
                <input type='hidden' id='v_pivot_excel' name='v_pivot_excel' value=''/>
                <!--<input type='button' class="boton" value='Excel' onclick="enviaPivotExcel('Form1');" />-->
                <iframe id='iframe_pivot_excel' name='iframe_pivot_excel' src="" style="display:none; border: 0px; overflow:hidden; margin: 0 auto; text-align: center;"></iframe>
    </td>
</tr>
</table>
</div>