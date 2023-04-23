<table width="100%" border="0" align="center">
    <tr>
      <td width="52%"><div align="center" class="Estilo6 Estilo1 Estilo8 Estilo9  Estilo11 Estilo20">
          <div align="right" class="Estilo21">
            <div align="left" class="Estilo13">Paso 1 </div>
          </div>
      </div></td>
      <td width="48%"><div align="center" class="Estilo6 Estilo1 Estilo8 Estilo9  Estilo12 Estilo20">
          <div align="right" class="Estilo22">
            <div align="right" class="Estilo13">CLIENTE / OBRA </div>
          </div>
      </div></td>
    </tr>
    <tr>
      <td colspan="2" valign="top" bgcolor="#06327D"><div align="left"><span class="Estilo7">DATOS CLIENTE </span></div></td>
    </tr>
    <tr>
      <td colspan="2" valign="top"><form method="POST" name="frmDatos" id="frmDatos"><table width="100%" border="0" align="center">
  <tr>
    <td><table width="100%" border="0" align="left">
      <tr>
        <td colspan="4">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="5" height="2"></td>
      </tr>
      <tr>
        <td width="149"><div align="left">Rut: </div></td>
        <td width="295" colspan="3"><div align="left">
          
          <input name="txt_rut" type="text" id="rut" value="" size="12" maxlength="12" />
          
          <input type="submit" name="buscarcodigo" id="button" value="Buscar" onclick="javascript:rut_formato()" style="background-image:url(images/ver.png); width:20px; height:20px" title="Buscar Cliente por Rut" class="formato_boton" />
          
         <!-- <input type="image" name="buscarcodigo" value="Buscar" title="Buscar Cliente por Rut" class="searchbutton" src="images/ver.png" onclick="javascript:rut_formato()"/>-->        [11.111.111-1]</div></td>
        <td width="131" align="center" valign="middle" class="Estilo23">&nbsp;</td>
      </tr>
      <tr>
        <td><div align="left">Raz&oacute;n Social :</div></td>
        <td colspan="3"><div align="left">
          <input  name="txt_razonsoc" type="text" value="" size="50" maxlength="50" disabled="disabled"/>
        </div></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><div align="left">Giro:</div></td>
        <td colspan="3"><div align="left">
          
          <input name="txt_giro" type="text" size="50" maxlength="50" disabled="disabled"/>
          </div></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><div align="left">Direcci&oacute;n:</div></td>
        <td colspan="3"><div align="left">
          
          <input name="txt_direccion" type="text" size="50" maxlength="50" disabled="disabled" />
          </div></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><div align="left">Ciudad:</div></td>
        <td colspan="3" align="left"><div align="left">
          
          <input name="txt_ciudad" type="text" size="40" maxlength="40" disabled />
          </option>
          </div></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><div align="left">Comuna:</div></td>
        <td colspan="3" align="left"><div align="left">
          
          <input name="txt_comuna" type="text" size="40" maxlength="40" disabled="disabled"/>
          </option>
          </div></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><div align="left">Fono:</div></td>
        <td colspan="3"><div align="left">
          
          <input name="txt_cod_area" type="text" onkeypress="return acceptNum(event)" size="4" maxlength="8" disabled="disabled"/>
          <input name="txt_fono" type="text" onkeypress="return acceptNum(event)" size="8" maxlength="8" disabled="disabled"/>
          </div></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>Contacto:</td>
        <td colspan="3"><div align="left">
          
          <input name="txt_nomresp" type="text" size="50" maxlength="50" disabled="disabled" />
          </div></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td><div align="left">Email Contacto:</div></td>
        <td colspan="3" align="left">
          <input name="txt_email" type="text" size="50" maxlength="50" disabled="disabled"/>
        </td>
        <td align="right">&nbsp;</td>
      </tr>
      <tr>
        <td height="15">&nbsp;</td>
        <td colspan="3">&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="5" valign="top" bgcolor="#06327D"><div align="left"><span class="Estilo7">Obra Seleccionada</span></div></td>
        </tr>
      <tr>
        <td height="15"><div align="left">Nombre:</div></td>
        <td colspan="3"><input name="txt_codobra" type="text" value="" size="6" maxlength="6"/>
          <input type="text" name="txt_obra" size="45" maxlength="45" value="" disabled="disabled"/></td>
        <td>
          <input type="submit" name="OK" id="button2" value="Guardar y Seguir" style="background-image:url(images/siguiente.png); width:40px; height:40px" class="formato_boton" />
        </td>
      </tr>
      <tr>
        <td></td>
        <td colspan="3"></td>
        <td></td>
      </tr>
    </table></td>
  </tr>
</table>

        <table class="sortable" id="unique_id" width="100%" border="0" align="center" cellpadding="1" cellspacing="1" >
          <tr title="Clic para seleccionar Obra" class="CONT" onmouseover="this.style.cursor='hand';this.style.cursor='pointer';" onclick="asignar_valor(this)">
            <th bgcolor="#06327D"><span class="Estilo17">Cod.  Obra </span></th>
            <th bgcolor="#06327D"><span class="Estilo17">
 Nombre Obra </span></th>
            <th bgcolor="#06327D" class="CONT"><span class="Estilo17">Autorizado 1</span></th>
            <th bgcolor="#06327D" class="CONT"><span class="Estilo17 Estilo13 Estilo15">Autorizado 2</span></th>
            </tr>
          <tr bordercolor="#FFFFFF" bgcolor="#B4B4B4" title="Clic para seleccionar Obra" class="CONT" onmouseover="this.style.cursor='hand';this.style.cursor='pointer';" onclick="asignar_valor(this)">
            <td bgcolor="#FFFFFF">&nbsp;</td>
            <td bgcolor="#FFFFFF">&nbsp;</td>
            <td bgcolor="#FFFFFF">&nbsp;</td>
            <td align="center" bgcolor="#FFFFFF">&nbsp;</td>
            </tr>
		</table>
      </form></td>
    </tr>
  </table>
