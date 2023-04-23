<table width="100%" border="0" align="center">
    <tr>
      <td width="52%"><div align="center" class="Estilo6 Estilo1 Estilo8 Estilo9  Estilo11 Estilo20">
          <div align="right" class="Estilo21">
            <div align="left" class="Estilo13">Paso 2 </div>
          </div>
      </div></td>
      <td width="48%"><div align="center" class="Estilo6 Estilo1 Estilo8 Estilo9  Estilo12 Estilo20">
          <div align="right" class="Estilo22">
            <div align="right" class="Estilo13">SELECCION DE EQUIPO</div>
          </div>
      </div></td>
    </tr>

      <td height="162" colspan="2"valign="top">
      <form method="POST" name="frmDatos" id="frmDatos">
          <table width="100%"  align="center" border="0">
              <tr>
                <td colspan="5"><table width="100%" border="0" align="center">
                  <tr>
                    <td colspan="5" bgcolor="#06327D"><div align="left" class="Estilo7">
					</div></td><div align="left"> 
          </div>
                  </tr>
                  <tr>
                    <td colspan="5" bgcolor="#06327D"><span class="Estilo7">
                      <span class='mini_titulo'>
	            </span>
                    </span></td>
                  </tr>
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td align="center" valign="middle">&nbsp;</td>
                  </tr>
                  <tr>
                    <td width="22%"><div align="left">C&oacute;digo</div></td>
                    <td width="2%">: </td>
                    <td width="62%"><div align="left">
                      <input  name="txt_codigo" type="text" onkeypress="Nom(this.form,'buscarcodigo')"/>
                      <input type="submit" name="buscarcodigo" id="button" value="Buscar" style="background-image:url(images/ver.png); width:16px; height:16px" class="formato_boton" title="Buscar Equipo por Código" />
                    </div></td>
                    <td width="9%">&nbsp;</td>
                    <td width="5%" align="center" valign="middle">&nbsp;</td>
                  </tr>
                  <tr>
                    <td><div align="left">Nombre</div></td>
                    <td>: </td>
                    <td><div align="left">
                      <input  name="txt_nombre" type="text" onkeypress="Nom(this.form,'buscarnombre')"/>
                      <input type="submit" name="buscarnombre" id="button2" value="Buscar" style="background-image:url(images/ver.png); width:16px; height:16px" class="formato_boton" title="Buscar Equipo por Nombre" />
                      </div></td>
                    <td>&nbsp;</td>
                    <td>
</td>
                  </tr>
                  <tr>
                    <td colspan="5"></td>
                  </tr>
                </table></td>
              </tr>
              <tr><br />

              </tr>
            </table>
            <table class="sortable" id="unique_id" width="100%" border="0" align="center" cellpadding="1" cellspacing="1" >
                <tr title="Clic para mostrar contenido" class="CONT" onmouseover="this.style.cursor='hand';this.style.cursor='pointer';" onclick="asignar_valor(this)">
                  <th width="21%">
              <input type="hidden" name="txt_cod" size="20" maxlength="30" />
              <input type="hidden" name="txt_equipo" size="25" maxlength="25" /></th>
                  <th colspan="2">&nbsp;</th>
                  <th width="15%">&nbsp;</th>
                  <th width="15%">&nbsp;</th>
                  <th width="10%" align="right">&nbsp;</th>
                </tr>
                <tr>
                  <th colspan="6" bgcolor="#06327D"><div align="center" class="Estilo7">Equipos Seleccionados</div></th>
                </tr>
                <tr>
                  <th bgcolor="#06327D"><div align="center" class="Estilo17">C&oacute;dgo Equipo</div></th>
                  <th width="33%" bgcolor="#06327D"><div align="center" class="Estilo17">Nombre</div></th>
                  <th width="21%" bgcolor="#06327D"><div align="center" class="Estilo17">Imagen</div></th>
                  <th bgcolor="#06327D"><div align="center" class="Estilo17">Incluye Accesorios</div></th>
                  <th bgcolor="#06327D"><div align="center" class="Estilo17">Ficha pdf</div></th>
                  <th bgcolor="#06327D">
                    <span class="Estilo17 Estilo13 Estilo15">Quitar</span></th>
                </tr>
                <tr bordercolor="#FFFFFF"  class="CONT" onmouseover="this.style.cursor='hand';this.style.cursor='pointer';" onclick="asignar_valor(this)">
                  <td align="left"> </td>
                  <td align="left"></td>
                  <td align="left" bgcolor="#FFFFFF"></td>
                  <td align="left" bgcolor="#FFFFFF"><div align="center">
                    <input name="incluyeaccesorio[]" type="checkbox" id="incluye_accesorio[]" value=""  />
                  </div></td>
                  <td align="left" bgcolor="#FFFFFF">
						<a  href="files/ficha_tecnica/001.pdf" target="_blank">Ver Ficha Tecnica pdf</a>                 </td>
                  <td align="center" bgcolor="#FFFFFF"><input type="image" name="borrar" value="Borrar" title="Eliminar Equipo del arriendo" src="images/error.png" onclick="elimina=confirm('�Esta seguro de no incluir el Equipo en el arriendo?');return elimina;" /></td>
                </tr>
                <tr>
                  <td height="15" bordercolor="#FFFFFF" class="CONT">-----------------------</td>
                  <td bordercolor="#FFFFFF" class="CONT">------------------------------------</td>
                  <td align="left" bgcolor="#FFFFFF">---------------------</td>
                  <td class="CONT">&nbsp;</td>
                  <td class="CONT">----------------</td>
                  <td class="CONT">----------</td>
              </tr>
                <tr>
                  <td height="15" bordercolor="#FFFFFF" class="CONT">&nbsp;</td>
                  <td bordercolor="#FFFFFF" class="CONT">&nbsp;</td>
                  <td align="left" bgcolor="#FFFFFF">&nbsp;</td>
                  <td colspan="3" class="CONT" align="right">
                  
                    <input type="submit" name="paso1" value="paso1" style="background-image:url(images/volver.png); width:40px; height:40px" class="formato_boton" />
                    <!--<input type="image" name="paso1"  class="boton" title="Ir Paso 1" value="paso1"  src="images/volver.png" width="30"  height="30"/>-->
                  
                  
                    <span class="Estilo71">
                    <input type="submit" name="cancelar" value="Cancelar" onclick="elimina=confirm('&iquest;Esta seguro de Cancelar el Arriendo?');return elimina;" style="background-image:url(images/cancelar_arr.png); width:40px; height:40px" class="formato_boton" />
                   
                   <!-- <input name="cancelar" type="image" class="boton" title="Cancelar Arriendo" value="Cancelar"  src="images/cancelar_arr.png" width="35" height="35" onclick="elimina=confirm('&iquest;Esta seguro de Cancelar el Arriendo?');return elimina;"  />-->
                    
                    
                    <input type="submit" name="OK" id="button3" value="Continuar" style="background-image:url(images/siguiente.png); width:40px; height:40px" class="formato_boton" title="Ir Paso 3"/>
                   <!--<input name="OK" type="image" class="boton" title="Ir Paso 3" value="Continuar"  src="images/siguiente.png" width="30"  height="30"/>-->
                  </span></td>
              </tr>
        </table>
      </form>
      </td>
    </tr>
  </table>