<table width="100%" border="0" align="center">
        <tr>
          <td width="52%">
          <div align="center" class="Estilo6 Estilo1 Estilo8 Estilo9  Estilo11 Estilo20">
              <div align="right" class="Estilo21">
                <div align="left" class="Estilo13">Paso 3 </div>
              </div>
          </div>
          </td>
          <td width="48%"><div align="center" class="Estilo6 Estilo1 Estilo8 Estilo9  Estilo12 Estilo20">
              <div align="right" class="Estilo22">
                <div align="right" class="Estilo13">FINALIZAR ARRIENDO</div>
              </div>
          </div>
          </td>
        </tr>
</table>

    <form id="form1" name="form1" method="post" action="">
      <table width="100%" border="0" align="center">
        <tr>
          <td colspan="5"></td>
        </tr>
        <tr>
          <td colspan="5" bgcolor="#06327D">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="5" bgcolor="#06327D"><span class="Estilo7">DATOS</span></td>
        </tr>
        <tr>
          <td>Obra</td>
          <td colspan="3" align="left"><input name="txt_obra" type="text" size="40" maxlength="40" disabled="disabled" /></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Condiciones de Arriendo</td>
          <td align="left"><input name="txt_condicarr" type="text" size="20" maxlength="20" disabled="disabled" /></td>
          <td align="right">Vendedor:</td>
          <td align="left"><input name="ap_patpersonal" type="text" disabled="disabled" size="30" maxlength="30" />          </td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="left">N&deg; OC:</div></td>
          <td align="left"><input name="txt_oc" id="txt_oc" type="text" size="10" maxlength="10" /></td>
          <td align="right">Fecha Emision OC:</td>
          <td><input name="cal-field-1" type="text" id="cal-field-1" size="10" maxlength="10"/>
            <button type="submit" id="cal-button-1">...</button>
            <script type="text/javascript">
            Calendar.setup({
              inputField    : "cal-field-1",
              button        : "cal-button-1",
              align         : "Tr"
            });
            </script></td>
          <td width="5%">&nbsp;</td>
        </tr>
        <tr>
          <td align="left"><div align="left">Tipo Orden de Compra: </div></td>
          <td width="24%" align="left"><select name="tipo_oc" id="tipo_oc" onchange="javascript:cambia_tipo_oc();" >
            <option value="0">ABIERTA</option>
            <option value="1" selected="selected">CERRADA</option>
            <option value="2">SIN O/C</option>
            <option value="3">PENDIENTE</option>
          </select></td>
          <td width="21%" align="right">Fecha Vencimiento OC:</td>
          <td width="23%"><input name="cal-field-3" type="text" id="cal-field-3" size="10" maxlength="10"/>
            <button type="submit" id="cal-button-3">...</button>
            <script type="text/javascript">
            Calendar.setup({
              inputField    : "cal-field-3",
              button        : "cal-button-3",
              align         : "Tr"
            });
          </script></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td align="left"><div align="left">N&deg; GD:</div></td>
          <td align="left"><input name="txt_numgd" type="text" onkeypress="return acceptNum(event)" size="6" maxlength="6" /></td>
          <td align="right">Fecha Emisión GD:</td>
          <td><input name="cal-field-5" type="text" id="cal-field-5" size="10" maxlength="10"/>
          <button type="submit" id="cal-button-5">...</button>
          <script type="text/javascript">
            Calendar.setup({
              inputField    : "cal-field-5",
              button        : "cal-button-5",
              align         : "Tr"
            });
          </script>
          
          </td>
          <td>&nbsp;</td>
        </tr>
        
        <tr>
          <td><div align="left">Tipo de garant&iacute;a: </div></td>
          <td colspan="3" align="left"><div align="left">
          </div>
		  </td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="left">Forma de pago:</div></td>
          <td colspan="3"><div align="left"></div></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td colspan="3">&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="left">Fecha Arriendo Equipo:</div></td>
          <td><input name="cal-field-4" type="text" id="cal-field-4" size="10" maxlength="10"/>
            <button type="submit" id="cal-button-4">...</button>
            <script type="text/javascript">
            Calendar.setup({
              inputField    : "cal-field-4",
              button        : "cal-button-4",
              align         : "Tr"
            });
            </script></td>
          <td><div align="left">Hora Arriendo Equipo:</div></td>
          <td><input name="hora" type="text" id="hora" size="8" maxlength="8" /></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="26" valign="top"><div align="left">Forma entrega:</div></td>
          <td colspan="3"><select name="forma_entrega" >
            <option value="1" selected="selected">RETIRA CLIENTE</option>
            <option value="2" selected="selected">ENTREGA EN OBRA</option>
          </select></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td></td>
          <td colspan="3"></td>
          <td></td>
        </tr>
        <tr>
          <td></td>
          <td colspan="4" align="right"><span class="Estilo71">
            
            <input type="submit" name="OK" id="button" value="Guardar y Seguir" title="Guardar y Finalizar Arriendo" style="background-image:url(images/guardar.png); width:45px; height:45px" class="formato_boton"/>
            
            <!--<input name="OK" type="image" class="boton" title="Guardar y Finalizar Arriendo" value="Guardar y Seguir"  src="images/guardar.png"width="35" height="35" />-->
            
            <input type="submit" name="cancelar" id="button2" value="Cancelar" title="Cancelar Arriendo" style="background-image:url(images/cancelar_arr.png); width:45px; height:45px;" class="formato_boton" onclick="elimina=confirm('&iquest;Esta seguro de Cancelar el Arriendo?');return elimina;"/>
            <!--<input name="cancelar" type="image" class="boton" title="Cancelar Ariendo" value="Cancelar"  src="images/cancelar_arr.png"width="35" height="35" onclick="elimina=confirm('&iquest;Esta seguro de Cancelar el Arriendo?');return elimina;"  />-->
            <input type="button" name="volver" value="Volver"  title="Ir Paso 2" style="background-image:url(images/volver.png); width:40px; height:40px" class="formato_boton" onclick=""/>
           <!-- <input type="image" name="volver" value="Volver"  title="Ir Paso 2" src="images/volver.png" onclick="" width="30" height="30"/>-->
          </span></td>
        </tr>
      </table>
    </form>
