<?php /* Smarty version 2.6.18, created on 2017-02-06 20:55:08
         compiled from sg_informes_certificado_alumno_regular_list.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'sg_informes_certificado_alumno_regular_list.tpl', 56, false),)), $this); ?>
<div id='pivot'>
    <table>
    	<tr>
    		<td colspan="4" align="right" style="background-image:url('<?php echo $this->_tpl_vars['Logo']; ?>
');
        										width:100px; height:100px;
        										-webkit-print-color-adjust:exact;"></td>
  		</tr>
    </table>
    <br />    
    <br />    
    <br />    
    <br />  
    <h1 style="font-size: 36px" align="center">CERTIFICADO DE ALUMNO REGULAR</h1>
    <br />    
    <br /> 

    <table width="100%">
        <tr>
            <td align="right" width="25%">
            
            </td>
            <td align="right" width="25%">
                <img src="<?php echo $this->_tpl_vars['Foto']; ?>
" width="200" style="-webkit-print-color-adjust:exact;"/>
            </td>
            <td align="right" width="25%">
            </td>
            <td align="right" width="25%">
            </td>
        </tr>
    </table>
    <p >
    	    <div style="padding-left: 12%; font-size: 14px; text-align: left">
            MARCIA GONZ&Aacute;LEZ HENR&Iacute;QUEZ, Directora del <?php echo $this->_tpl_vars['nombre_colegio']; ?>

            </div>
        <br />
        <br />
            <div style="padding-left: 12%; font-size: 14px; text-align: left">de Villa Alemana,   RBD: <?php echo $this->_tpl_vars['RBD']; ?>
, certifica que don (a)  <?php echo $this->_tpl_vars['nombre_alumno']; ?>
,</div>
        <br />
        <br />
            <div style="padding-left: 12%; font-size: 14px; text-align: left">R.U.T.: <?php echo $this->_tpl_vars['rut']; ?>
,  alumno (a) <?php echo $this->_tpl_vars['nombre_curso']; ?>
 <?php echo $this->_tpl_vars['anio']; ?>
,</div>
        <br />
        <br />
            <div style="padding-left: 12%; font-size: 14px; text-align: left">asiste regularmente a clases en nuestro establecimiento.  </div>
        <br />
        <br />
            <div style="padding-left: 12%; font-size: 14px; text-align: left">Se extiende el presente certificado para </div>
        <br />
        <br />
            <div style="padding-left: 12%; font-size: 14px; text-align: left"><?php echo $this->_tpl_vars['observacion']; ?>
 </div>
       <br />
        <br />
       <br />
        <br />
       <br />
        <br />
            <div style="padding-left: 75%; font-size: 14px">Villa Alemana, <?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d-%m-%Y") : smarty_modifier_date_format($_tmp, "%d-%m-%Y")); ?>
</div>
    </p>
    <br />  
    <br />    
 	<!--
    
    -->
</div>