<?php
session_start();

require_once 'includes/xajax/xajax.inc.php'; //archivo de configuracion de ajax
include "../includes/php/conf_smarty.php";//archivo de configuracion de smarty
include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 
include "../includes/php/class.phpmailer.php";
include "../includes/php/class.pop3.php";
include "../includes/php/class.smtp.php";
include "../includes/php/PHPExcel.php";
include "../includes/php/PHPExcel/Reader/Excel2007.php";

$xajax = new xajax();

$xajax->setRequestURI("sg_informe_movimientos_mensuales.php");
$xajax->setCharEncoding("ISO-8859-1");
$xajax->decodeUTF8InputOn();

function Enviar($data,$arrRegistros){
    $mail             = new PHPMailer(true);
    $body             = "";
    
    $cod_prod           =       $data["OBLI-txtCodProducto"];
    $descr_prod         =       $data["OBLI-txtDescProducto"];
    $familia 		= 	$data["cboFamilia"];
    $subfamilia		= 	$data["cboSubFamilia"];
    $estado_producto    = 	$data["cboEstadoProducto"];
    $movimiento         =       $data['cboMovimientos'];

    $objReader = new PHPExcel_Reader_Excel2007();
    $objPHPExcel = $objReader->load("ejemplo.xlsx"); //cargamos el archivo excel (extensión *.xlsx)
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel); //objeto de PHPExcel, para escribir en el excel
    
    $body               .= "<a href='http://192.168.1.50/yonley/sgcompras/sitio/pivot_excel_interno.php?cod_prod=".$cod_prod."&descr_prod=".$descr_prod."&familia=".$familia."&subfamilia=".$subfamilia."&estado_producto=".$estado_producto."&movimiento=".$movimiento."'>Enlace de Descarga</a>";
    $body               .= "<table>";
    $body               .= "<tr><td>Familia</td><td>SubFamilia</td><td>Descripcion</td><td>Codigo</td><td>Stock Nuevo</td><td>Ventas Ultimo Mes Stock Nuevo</td><td>Ventas Promedio Ultimos 3 Meses Stock Nuevo</td></tr>";
    $i=0;
    foreach ($arrRegistros as $order){
        $body             .= "<tr>";
        $body           .= "<td>".$order['familia']."</td>";
        $objPHPExcel->getActiveSheet()->setCellValue("A".$i, $order['familia']);
        $body           .= "<td>".$order['subfamilia']."</td>";
        $objPHPExcel->getActiveSheet()->setCellValue("B".$i, $order['subfamilia']);
        $body           .= "<td>".utf8_encode($order['descripcion'])."</td>";
        $objPHPExcel->getActiveSheet()->setCellValue("C".$i, $order['descripcion']);
        $body           .= "<td>".$order['codigo']."</td>";
        $objPHPExcel->getActiveSheet()->setCellValue("D".$i, $order['codigo']);
        $body           .= "<td>".round($order['stock_nuevo'])."</td>";
        $objPHPExcel->getActiveSheet()->setCellValue("E".$i, round($order['stock_nuevo']));
        $body           .= "<td>".round($order['ventas_men_nuevo'])."</td>";
        $objPHPExcel->getActiveSheet()->setCellValue("F".$i, round($order['ventas_men_nuevo']));
        $body           .= "<td>".round($order['ventas_tri_nuevo'])."</td>";
        $objPHPExcel->getActiveSheet()->setCellValue("G".$i, round($order['ventas_tri_nuevo']));
        $body           .= "</tr>";
        $i++;
        }
    $body               .= "</table>";

    $mail->IsSMTP(); // telling the class to use SMTP                                                            "subfamilia"	=>	$subfamilia,
    $mail->Host       = "mail.cyonley.com"; // SMTP server
    $mail->SMTPDebug  = 0   ;               // enables SMTP debug information (for testing)
                                            // 1 = errors and messages
                                            // 2 = messages only

    $mail->From = 'no-reply@cyonley.com';
    $mail->FromName = 'No Responder';

    $mail->Subject    = "Informe Movimientos Mensuales generado a las ".date("d-m-Y H:i:s");
    
    $objWriter->save("ejemplo.xlsx");//guardamos el archivo excel
    
    $mail->AddAttachment("ejemplo.xlsx");    
    $mail->MsgHTML($body);

    $address = "ssilva@cyonley.com";
    $mail->AddAddress($address, "Samuel Silva");

    if(!$mail->Send()) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    } else {
      //echo "Message sent!";
    }
    
}

function Grabar($data){
	global $conexion;
	global $miSmarty;
        set_time_limit(100000);
        
	$objResponse = new xajaxResponse('ISO-8859-1');
	
	$cod_prod                       =       $data["OBLI-txtCodProducto"];
        $descr_prod                     =       $data["OBLI-txtDescProducto"];
        $familia 			= 	$data["cboFamilia"];
	$subfamilia			= 	$data["cboSubFamilia"];
	$estado_producto        	= 	$data["cboEstadoProducto"];
	$movimiento                     =       $data['cboMovimientos'];
        
	$objResponse->addScript("document.getElementById('divlistado').style.display='none';");
	
	if (($familia != '') && ($familia != 'Todas')){
		$and = " and a.ta_familia = '".$familia."'";
	}
	if (($subfamilia != '') && ($subfamilia != 'Todas')){
		$and .= " and a.ta_subfamilia = '".$subfamilia."'";
	}
        
	
	// busca todos los productos
	$sql_pd = "select 
				concat(a.ta_busqueda,' ',a.ta_descripcion) as descripcion,
				a.ta_ncorr as codigo,
				a.ta_familia as familia,
				a.ta_subfamilia as subfamilia
				
				from 
				sgbodega.tallasnew a
				
				where
                                a.ta_empresa != '' and
				a.ta_estado like '%".$estado_producto."%' and
				a.ta_familia != '' and a.ta_subfamilia != '' and
				concat(a.ta_busqueda,' ',a.ta_descripcion) like '%".$descr_prod."%'
                                $and";
	
	$res_pd = mysql_query($sql_pd, $conexion);
	if (mysql_num_rows($res_pd) > 0){
		$arrRegistros		= 	array();
		$i 					= 	1;
		while ($line_pd = mysql_fetch_row($res_pd)) {
			
			$familia 	= $line_pd[2];
			$subfamilia 	= $line_pd[3];
			
			
			//busca familia
				$sql_f = "select fa_nombre from sgbodega.familias where fa_codigo = '".$familia."'";
				$res_f = mysql_query($sql_f, $conexion);
				$familia = @mysql_result($res_f,0,"fa_nombre");
			//fin
			
			//busca subfamilia
				$sql_sf = "select sf_nombre from sgbodega.subfamilias where sf_subcodigo = '".$subfamilia."'";
				$res_sf = mysql_query($sql_sf, $conexion);
				$subfamilia = @mysql_result($res_sf,0,"sf_nombre");
			//fin
			
			
			$codigo = $line_pd[1];
			
                        //14/10/2010 se saca el filtro por empresa (b.empe_rut = '".$empresa."' and)		
			//busca todos los aumentos a bodega central (movim 1)
			$sql_saumentos 	= "select mdet_nu as nu, mdet_cantidad as cantidad
								from 
								sgbodega.movim_detalle a, sgbodega.movim b
								
								where
								a.mdet_codigo = '".$codigo."' and
								a.movim_ncorr = b.movim_ncorr and
								b.movim_tipo = '1' and
								b.movim_estado = 'FINALIZADO' and
                                                                mdet_nu = 'N'";
			$res_saumentos 	= 	mysql_query($sql_saumentos, $conexion);
			$aumentos_n 	= 	0;
			$aumentos_u 	= 	0;
			while ($line_saumentos = mysql_fetch_row($res_saumentos)) {
				$nu 		= 	$line_saumentos[0];
				$cantidad	= 	$line_saumentos[1];
			
				if ($nu == 'N'){
					$aumentos_n 	= 	$aumentos_n + $cantidad;
				}
			}
			
			//busca todos los aumentos por traspasos de concon (movim 8)
			$sql_trasp_con 	= "select mdet_nu as nu, mdet_cantidad as cantidad
								from 
								sgbodega.movim_detalle a, sgbodega.movim b
								
								where
								a.mdet_codigo = '".$codigo."' and
								a.movim_ncorr = b.movim_ncorr and
								b.movim_tipo = '8' and
								b.movim_estado = 'FINALIZADO' and
                                                                mdet_nu = 'N'";
			$res_trasp_con 	= 	mysql_query($sql_trasp_con, $conexion);
			$trasp_con_n 	= 	0;
			$trasp_con_u 	= 	0;
			while ($line_trasp_con = mysql_fetch_row($res_trasp_con)) {
				$nu 		= 	$line_trasp_con[0];
				$cantidad	= 	$line_trasp_con[1];
			
				if ($nu == 'N'){
					$trasp_con_n 	= 	$trasp_con_n + $cantidad;
				}
			}
			
			//busca todos los aumentos por devoluciones de vendedor (movim 4)
			$sql_dev_vend 	= "select mdet_nu as nu, mdet_cantidad as cantidad
								from 
								sgbodega.movim_detalle a, sgbodega.movim b
								
								where
								a.mdet_codigo = '".$codigo."' and
								a.movim_ncorr = b.movim_ncorr and
								b.movim_tipo = '4' and
								b.movim_estado = 'FINALIZADO' and
                                                                mdet_nu = 'N'";
			$res_dev_vend 	= 	mysql_query($sql_dev_vend, $conexion);
			$dev_vend_n 	= 	0;
			$dev_vend_u 	= 	0;
			while ($line_dev_vend = mysql_fetch_row($res_dev_vend)) {
				$nu 		= 	$line_dev_vend[0];
				$cantidad	= 	$line_dev_vend[1];
			
				if ($nu == 'N'){
					$dev_vend_n 	= 	$dev_vend_n + $cantidad;
				}
			}
			//fin
			
			//busca todos los aumentos por traspasos desde con con (movim 8)
			$sql_trasp 	= "select mdet_nu as nu, mdet_cantidad as cantidad
								from 
								sgbodega.movim_detalle a, sgbodega.movim b
								
								where
								a.mdet_codigo = '".$codigo."' and
								a.movim_ncorr = b.movim_ncorr and
								b.movim_tipo = '8' and
								b.movim_estado = 'FINALIZADO' and
                                                                mdet_nu = 'N'";
			$res_trasp 	= 	mysql_query($sql_trasp, $conexion);
			$trasp_n 	= 	0;
			$trasp_u 	= 	0;
			while ($line_trasp = mysql_fetch_row($res_trasp)) {
				$nu 		= 	$line_trasp[0];
				$cantidad	= 	$line_trasp[1];
			
				if ($nu == 'N'){
					$trasp_n 	= 	$trasp_n + $cantidad;
				}
			}
			//fin

			//busqueda por codigo nuevo
			$sql_dev_clienew 	= "select b.sv_nu as nu, b.sv_cantidad as cantidad

								from 
								sgyonley.d_guiadev a, sgyonley.sub_guiadev b
								
								where
								b.sv_codbus = '".$codigo."' and
								b.sv_conf_bodega = 'SI' and 
								b.sv_guiadv = a.gd_guia and
								a.tdev_ncorr = '1' and
                                                                b.sv_nu = 'N'";
			
			$res_dev_clienew 	= 	mysql_query($sql_dev_clienew, $conexion);
			$dev_clie_n_new 	= 	0;
			$dev_clie_u_new 	= 	0;
			while ($line_dev_clienew = mysql_fetch_row($res_dev_clienew)) {
				$nu 		= 	$line_dev_clienew[0];
				$cantidad	= 	$line_dev_clienew[1];
			
				if ($nu == 'N'){
					$dev_clie_n_new 	= 	$dev_clie_n_new + $cantidad;
				}
			}
			//fin
			
			//busca decuentos por aumento a vendedor (movim 2)
			$sql_aum_vend 	= "select mdet_nu as nu, mdet_cantidad as cantidad
								from 
								sgbodega.movim_detalle a, sgbodega.movim b
								
								where
								a.mdet_codigo = '".$codigo."' and
								a.movim_ncorr = b.movim_ncorr and
								b.movim_tipo = '2' and
								b.movim_estado = 'FINALIZADO' and
                                                                mdet_nu = 'N'";
			$res_aum_vend 	= 	mysql_query($sql_aum_vend, $conexion);
			$aum_vend_n 	= 	0;
			$aum_vend_u 	= 	0;
			while ($line_aum_vend = mysql_fetch_row($res_aum_vend)) {
				$nu 		= 	$line_aum_vend[0];
				$cantidad	= 	$line_aum_vend[1];
			
				if ($nu == 'N'){
					$aum_vend_n 	= 	$aum_vend_n + $cantidad;
				}
			}
			//fin
			
			//busca decuentos por devolucion a proveedor (movim 3)
			$sql_dev_pro 	= "select mdet_nu as nu, mdet_cantidad as cantidad
								from 
								sgbodega.movim_detalle a, sgbodega.movim b
								
								where
								a.mdet_codigo = '".$codigo."' and
								a.movim_ncorr = b.movim_ncorr and
								b.movim_tipo = '3' and
								b.movim_estado = 'FINALIZADO' and
                                                                mdet_nu = 'N'";
			$res_dev_pro 	= 	mysql_query($sql_dev_pro, $conexion);
			$dev_pro_n 	= 	0;
			$dev_pro_u 	= 	0;
			while ($line_dev_pro = mysql_fetch_row($res_dev_pro)) {
				$nu 		= 	$line_dev_pro[0];
				$cantidad	= 	$line_dev_pro[1];
			
				if ($nu == 'N'){
					$dev_pro_n 	= 	$dev_pro_n + $cantidad;
				}
			}
			//fin
			
			//busca descuentos por cuentas personales (movim 9)
			$sql_cp 	= "select mdet_nu as nu, mdet_cantidad as cantidad
								from 
								sgbodega.movim_detalle a, sgbodega.movim b
								
								where
								a.mdet_codigo = '".$codigo."' and
								a.movim_ncorr = b.movim_ncorr and
								b.movim_tipo = '9' and
								b.movim_estado = 'FINALIZADO' and
                                                                mdet_nu = 'N'";
			$res_cp 	= 	mysql_query($sql_cp, $conexion);
			$desc_cp_n 	= 	0;
			$desc_cp_u 	= 	0;
			while ($line_cp = mysql_fetch_row($res_cp)) {
				$nu 		= 	$line_cp[0];
				$cantidad	= 	$line_cp[1];
			
				if ($nu == 'N'){
					$desc_cp_n 	= 	$desc_cp_n + $cantidad;
				}
			}
			//fin
			
			$stock_nuevo = $aumentos_n + $trasp_con_n + $dev_vend_n + $dev_clie_n + $dev_clie_n_new - $aum_vend_n - $dev_pro_n - $desc_cp_n;
			
                        $fecha_inicio   =   "";
                        $fecha_termino  =   "";
                        
                        $nro_mes_anterior  = mktime(0, 0, 0, date("m")-1, date("d"),   date("Y"));
                        $fecha_mes_anterior = date("Y-m-d",$nro_mes_anterior);
                        $cant_dias_mes_anterior = date("t",$nro_mes_anterior);
                        $hoy_array      =   explode("-",$fecha_mes_anterior);
                        $fecha_inicio   =   $hoy_array[0].'-'.$hoy_array[1].'-1';
                        $fecha_termino  =   $hoy_array[0].'-'.$hoy_array[1].'-'.$cant_dias_mes_anterior;

                        
                        // busco datos de la venta - Nuevo mes actual o anterior
                        $sql_tvm = "select sgyonley.ventas_detalle_antigua.vent_cant
				from 
				sgyonley.ventas_antigua
                                    inner join  sgyonley.ventas_detalle_antigua
                                        on sgyonley.ventas_antigua.vent_num_folio =  sgyonley.ventas_detalle_antigua.vent_ncorr 
                                where sgyonley.ventas_detalle_antigua.arti_codigo = ".$codigo."
                                    and sgyonley.ventas_detalle_antigua.arti_nu = 'N'
                                    and sgyonley.ventas_antigua.vent_fecha between '".$fecha_inicio."' and '".$fecha_termino."'
                                    and sgyonley.ventas_antigua.vent_estado_ingreso not in ('A','N','B','D','P')";
                       
                        $res_tvm = mysql_query($sql_tvm,$conexion) OR die(mysql_error());
                        $ventas_men_nuevo=0;
                        while ($row_tvm = @mysql_fetch_row($res_tvm)){
                            $ventas_men_nuevo   = $ventas_men_nuevo + $row_tvm[0];
                            }
                        //calculo fecha de 3 meses atras
                        $nro_mes_anterior  = mktime(0, 0, 0, date("m")-3, date("d"),   date("Y"));
                        $fecha_mes_anterior = date("Y-m-d",$nro_mes_anterior);
                        $cant_dias_mes_anterior = date("t",$nro_mes_anterior);
                        $hoy_array      =   explode("-",$fecha_mes_anterior);
                        $fecha_inicio   =   $hoy_array[0].'-'.$hoy_array[1].'-1';
                        
                        // busco datos de la venta - Nuevo promedio 3 meses atras
                        $sql_tvm = "select sgyonley.ventas_detalle_antigua.vent_cant
				from 
				sgyonley.ventas_antigua
                                    inner join  sgyonley.ventas_detalle_antigua
                                        on sgyonley.ventas_antigua.vent_num_folio =  sgyonley.ventas_detalle_antigua.vent_ncorr 
                               where sgyonley.ventas_detalle_antigua.arti_codigo = ".$codigo."
                                    and sgyonley.ventas_detalle_antigua.arti_nu = 'N'
                                    and sgyonley.ventas_antigua.vent_fecha between '".$fecha_inicio."' and '".$fecha_termino."'
                                    and sgyonley.ventas_antigua.vent_estado_ingreso not in ('A','N','B','D','P')";
                       
                        $res_tvm = mysql_query($sql_tvm,$conexion) OR die(mysql_error());
                        $ventas_tri_nuevo =0;
                        while ($row_tvm = @mysql_fetch_row($res_tvm)){
                            $ventas_tri_nuevo   = $ventas_tri_nuevo + $row_tvm[0]/3;
                            }
//                        todos = 0
//                        mensual =1
//                        3 meses =2
//                        sin movimientos = 3                        
                        if ($movimiento==3){
                            if (($ventas_men_nuevo>0)||($ventas_tri_nuevo>0)){
                                $ventas_tri_no_estado='NO';
                                }
                            else{
                                $ventas_tri_no_estado='SI';
                                $ventas_men_estado='SI';
                                $ventas_tri_estado='SI';
                                }
                            }
                        else{
                                $ventas_tri_no_estado='SI';
                                if (($movimiento==0)){
                                    $ventas_men_estado='SI';
                                    $ventas_tri_estado='SI';
                                    }
                                if (($movimiento==1)){
                                    $ventas_men_estado='SI';
                                    $ventas_tri_estado='NO';
                                    }
                                if (($movimiento==2)){
                                    $ventas_men_estado='NO';
                                    $ventas_tri_estado='SI';
                                    }
                            }
                        if (($cod_prod == $line_pd[1])&&($cod_prod!='')&&($cod_prod!=' '))  { 
                            array_push($arrRegistros, array("item"		=>	$i,
                                                            "familia"		=>	$familia,
                                                            "subfamilia"	=>	$subfamilia,
                                                            "descripcion"	=> 	$line_pd[0],
                                                            "codigo" 		=> 	$line_pd[1],
                                                            "stock_nuevo"	=> 	$stock_nuevo,
                                                            "ventas_men_estado"	=> 	$ventas_men_estado,
                                                            "ventas_men_nuevo"	=> 	$ventas_men_nuevo,
                                                            "ventas_tri_estado"	=> 	$ventas_tri_estado,
                                                            "ventas_tri_nuevo"	=> 	$ventas_tri_nuevo,
                                                            "ventas_tri_no_estado"	=> 	$ventas_tri_no_estado));
                            }
                        if (($cod_prod=='')){
                            array_push($arrRegistros, array("item"		=>	$i,
                                                            "familia"		=>	$familia,
                                                            "subfamilia"	=>	$subfamilia,
                                                            "descripcion"	=> 	$line_pd[0],
                                                            "codigo" 		=> 	$line_pd[1],
                                                            "stock_nuevo"	=> 	$stock_nuevo,
                                                            "ventas_men_estado"	=> 	$ventas_men_estado,
                                                            "ventas_men_nuevo"	=> 	$ventas_men_nuevo,
                                                            "ventas_tri_estado"	=> 	$ventas_tri_estado,
                                                            "ventas_tri_nuevo"	=> 	$ventas_tri_nuevo,
                                                            "ventas_tri_no_estado"	=> 	$ventas_tri_no_estado));
                            }
			$i++;
                       
		}
		       
		// asigno las sesiones para el ordenamiento
		$_SESSION["alycar_matriz"] 				= 	$arrRegistros;
		
		
		$miSmarty->assign('arrRegistros', $arrRegistros);
		
		//$objResponse->addScript("xajax_Ordenar(xajax.getFormValues('Form1'), 'familia');");
		
		$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informe_movimientos_mensuales_list.tpl'));
		//$objResponse->addAssign("divabonos", "innerHTML", $sql_saumentos);
		
	}else{
		
		$objResponse->addAssign("divabonos", "innerHTML", "No Existen Registros");
	}
	
	$objResponse->addScript("document.getElementById('divlistado').style.display='block';");
	$objResponse->addScript("para()");
        Enviar($data,$arrRegistros);
	return $objResponse->getXML();
}
function Ordenar($data, $campo){
	global $conexion;
	global $miSmarty;
	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$orden_asc 	= 'ASC';
	$orden_desc = 'DESC';
	if ($_SESSION["alycar_orden"] == $campo.$orden_asc){
		$campo_orden 		= 	$campo.$orden_desc;
		$direccion_orden	=	$orden_desc;
	}else{
		$campo_orden 		= 	$campo.$orden_asc;
		$direccion_orden	=	$orden_asc;
	}		
	
	$arrRegistros = array();
	$arrRegistros = ordenar_matriz_multidimensionada($_SESSION["alycar_matriz"],$campo,$direccion_orden);
	$_SESSION["alycar_orden"] = $campo_orden;
	
	$miSmarty->assign('arrRegistros', $arrRegistros);
	$objResponse->addAssign("divabonos", "innerHTML", $miSmarty->fetch('sg_informe_movimientos_mensuales_list.tpl'));
	
	
	return $objResponse->getXML();
}

function MuestraRegistro($data, $campo1, $campo2, $obj1, $obj2){
	global $conexion;
	
        $objResponse = new xajaxResponse('ISO-8859-1');
	
        $objResponse->addAssign("$obj1", "value", $campo1);
	$objResponse->addAssign("$obj2", "value", $campo2);
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'cboFamilia','sgbodega.familias','','Todas','fa_codigo', 'fa_nombre', '')");
	//$objResponse->addScript("xajax_CargaSubFamilias(xajax.getFormValues('Form1'))");
        return $objResponse->getXML();
}

function CargaDesc($data, $tabla, $campo1, $campo2, $objeto1, $objeto2, $c_and){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	//mysql_select_db("sgyonley", $conexion);
	
	$ncorr 		= 	$data["$objeto1"];
	
	if (($tabla == 'sgbodega.tallas') OR ($tabla == 'sgbodega.tallasnew')){
		$sql = "select ta_ncorr, ta_descripcion, ta_busqueda, ta_venta from sgbodega.tallasnew where $campo1 = '".$ncorr."'";
		$res = mysql_query($sql, $conexion);
		
		$objResponse->addAssign("OBLI-txtDescProducto", "value", @mysql_result($res,0,"ta_busqueda")." ".@mysql_result($res,0,"ta_descripcion"));
                $objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'cboFamilia','sgbodega.familias','','Todas','fa_codigo', 'fa_nombre', '')");
	
		//$objResponse->addScript("xajax_CalculaTotalesLinea(xajax.getFormValues('Form1'))");
	
	}else{
		
		$sql = "select $campo2 as descripcion from $tabla where $campo1 = '".$ncorr."' $and";
		$res = mysql_query($sql, $conexion);
		$objResponse->addAssign("$objeto2", "value", @mysql_result($res,0,"descripcion"));
	}	
	
	return $objResponse->getXML();
}
function CargaSelect($data, $select, $tabla, $codigo, $descripcion, $campo1, $campo2, $opt){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addAssign("$select","innerHTML",""); 		
	$sql = "select $campo1 as codigo, $campo2 as descripcion from ".$tabla;
	$res = mysql_query($sql, $conexion);
	if (mysql_num_rows($res) > 0) {
            $objResponse->addCreate("$select","option",""); 		
            $objResponse->addAssign("$select","options[0].value", $codigo);
            $objResponse->addAssign("$select","options[0].text", $descripcion); 	
            $j = 1;
            while ($line = mysql_fetch_array($res)) {
                    $objResponse->addCreate("$select","option",""); 		
                    $objResponse->addAssign("$select","options[".$j."].value", $line[0]);
                    $objResponse->addAssign("$select","options[".$j."].text", $line[1]); 	
                    $j++;
            }
        }
	return $objResponse->getXML();
}

function CargaSubFamilias($data){
    global $conexion;	
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$familia	=	$data["cboFamilia"];
	
        $objResponse->addAssign("OBLI-txtCodProducto", "value", "");
	$objResponse->addAssign("OBLI-txtDescProducto", "value", "");
	
	$objResponse->addAssign("cboSubFamilia","innerHTML",""); 		
	
	if 	($familia != 'Todas' &&  $familia != ''){
		$sql = "select SF_SUBCODIGO as codigo, SF_NOMBRE as descripcion from sgbodega.subfamilias WHERE SF_CODIGO = '".$familia."' ORDER BY SF_NOMBRE ASC";
	}else{
		$sql = "select SF_SUBCODIGO as codigo, SF_NOMBRE as descripcion from sgbodega.subfamilias WHERE SF_CODIGO != '' group by SF_NOMBRE ORDER BY SF_NOMBRE ASC";
	}	
		$res = mysql_query($sql, $conexion);
		if (mysql_num_rows($res) > 0) {
			$objResponse->addCreate("cboSubFamilia","option",""); 		
			$objResponse->addAssign("cboSubFamilia","options[0].value", '');
			$objResponse->addAssign("cboSubFamilia","options[0].text", 'Todas'); 	
			$j = 1;
			while ($line = mysql_fetch_array($res)) {
				$objResponse->addCreate("cboSubFamilia","option",""); 		
				$objResponse->addAssign("cboSubFamilia","options[".$j."].value", $line[0]);
				$objResponse->addAssign("cboSubFamilia","options[".$j."].text", $line[1]); 	
				$j++;
			}
		}
	//}
	
	return $objResponse->getXML();
}

function CargaPagina($data){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	//carga familias
	$objResponse->addScript("xajax_CargaSelect(xajax.getFormValues('Form1'),'cboFamilia','sgbodega.familias','','Todas','fa_codigo', 'fa_nombre', '')");
	
	//$objResponse->addScript("document.getElementById('OBLI-cboEmpresa').focus();");

	return $objResponse->getXML();
}          
function LlamaDetalle($data, $codigo, $descripcion){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$fecha_desde		= 	$data["OBLI-txtFechaDesde"];
	$fecha_hasta		= 	$data["OBLI-txtFechaHasta"];
	$cobrador			= 	$data["OBLI-txtCodCobrador"];
	$nombre_cobrador	= 	$data["OBLI-txtDescCobrador"];
	$empresa 			= 	$data["OBLI-cboEmpresa"];
	$ult_guia 			= 	$data["txtUltGuia"];
	
	list($dia1,$mes1,$anio1) = split('[/.-]', $fecha_desde);$fecha1 	= $anio1."-".$mes1."-".$dia1;
	list($dia2,$mes2,$anio2) = split('[/.-]', $fecha_hasta);$fecha2 	= $anio2."-".$mes2."-".$dia2;
	
	$objResponse->addScript("showPopWin('sg_existencia_movimientos_vendedor_detalle.php?codigo=$codigo&descripcion=$descripcion&fecha1=$fecha1&fecha2=$fecha2&cobrador=$cobrador&empresa=$empresa', '$codigo $descripcion', 700, 280, null);");
	
	return $objResponse->getXML();
}
function Imprime(){
    global $conexion;
    $objResponse = new xajaxResponse('ISO-8859-1');
	
	$objResponse->addScript("ImprimeDiv('divabonos');");
	
	return $objResponse->getXML();
}

$xajax->registerFunction("MuestraRegistro");
$xajax->registerFunction("Grabar");
$xajax->registerFunction("Ordenar");
$xajax->registerFunction("CargaPagina");
$xajax->registerFunction("CargaDesc");
$xajax->registerFunction("CargaSelect");
$xajax->registerFunction("LlamaDetalle");
$xajax->registerFunction("CargaSubFamilias");
$xajax->registerFunction("Imprime");

$xajax->processRequests();
$miSmarty->assign('xajax_js', $xajax->getJavascript());

$miSmarty->assign('COD_VENDEDOR', $_GET["cod_vendedor"]);
$miSmarty->assign('VENDEDOR', $_GET["nombre_vendedor"]);
$miSmarty->assign('DESDE', $_GET["desde"]);
$miSmarty->assign('HASTA', $_GET["hasta"]);

$miSmarty->display('sg_informe_movimientos_mensuales.tpl');

?>

