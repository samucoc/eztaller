<?php

include "../includes/php/conf_bd.php"; //archivo de coneccion al servidor y base de datos
//include "../includes/php/conf_bd_antigua.php"; //archivo de coneccion al servidor de yonley
include "../includes/php/validaciones.php"; 
include "../includes/php/class.phpmailer.php";
include "../includes/php/class.pop3.php";
include "../includes/php/class.smtp.php";

function Enviar($arrRegistros){
	global $conexion;
        
        $mail             = new PHPMailer(); // defaults to using php "mail()"

        $mail->From = 'no-reply@cyonley.com' ;
        $mail->FromName =  'No Reply';

        $mail->IsSMTP(); // telling the class to use SMTP
        $mail->Host       = "mail.cyonley.com"; // SMTP server
        $mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
        
        $address = "ssilva@cyonley.com";
        $mail->AddAddress($address, "John Doe");

        $mail->Subject    = "Email autogenerado, ".date("Y");

        $mail->MsgHTML("Email de prueba");

        $mail->Send();
        
}

function Grabar($data){
	global $conexion;
        
	$cod_prod                       =       $_GET["cod_prod"];
        $descr_prod                     =       $_GET["descr_prod"];
        $familia 			= 	$_GET["familia"];
	$subfamilia			= 	$_GET["subfamilia"];
	$estado_producto        	= 	$_GET["estado_producto"];
	$movimiento                     =       $_GET['movimiento'];
        
	
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
				a.ta_codigo as codigo_antiguo,
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
			
			$codigo_antiguo = $line_pd[2];
			$familia 		= $line_pd[5];
			$subfamilia 	= $line_pd[6];
			
			
			//busca familia
				$sql_f = "select fa_nombre from sgbodega.familias where fa_codigo = '".$line_pd[3]."'";
				$res_f = mysql_query($sql_f, $conexion);
				$familia = @mysql_result($res_f,0,"fa_nombre");
			//fin
			
			//busca subfamilia
				$sql_sf = "select sf_nombre from sgbodega.subfamilias where sf_subcodigo = '".$line_pd[4]."'";
				$res_sf = mysql_query($sql_sf, $conexion);
				$subfamilia = @mysql_result($res_sf,0,"sf_nombre");
			//fin
			
			
			$codigo = $line_pd[1];
			$codigo_antiguo = $line_pd[2];
			
                        //14/10/2010 se saca el filtro por empresa (b.empe_rut = '".$empresa."' and)		
			//busca todos los aumentos a bodega central (movim 1)
			$sql_saumentos 	= "select mdet_nu as nu, mdet_cantidad as cantidad
								from 
								sgbodega.movim_detalle a, sgbodega.movim b
								
								where
								a.mdet_codigo = '".$codigo."' and
								a.movim_ncorr = b.movim_ncorr and
								b.movim_tipo = '1' and
								b.movim_estado = 'FINALIZADO'";
			$res_saumentos 	= 	mysql_query($sql_saumentos, $conexion);
			$aumentos_n 	= 	0;
			$aumentos_u 	= 	0;
			while ($line_saumentos = mysql_fetch_row($res_saumentos)) {
				$nu 		= 	$line_saumentos[0];
				$cantidad	= 	$line_saumentos[1];
			
				if ($nu == 'N'){
					$aumentos_n 	= 	$aumentos_n + $cantidad;
				}
				if ($nu == 'U'){
					$aumentos_u 	= 	$aumentos_u + $cantidad;
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
								b.movim_estado = 'FINALIZADO'";
			$res_trasp_con 	= 	mysql_query($sql_trasp_con, $conexion);
			$trasp_con_n 	= 	0;
			$trasp_con_u 	= 	0;
			while ($line_trasp_con = mysql_fetch_row($res_trasp_con)) {
				$nu 		= 	$line_trasp_con[0];
				$cantidad	= 	$line_trasp_con[1];
			
				if ($nu == 'N'){
					$trasp_con_n 	= 	$trasp_con_n + $cantidad;
				}
				if ($nu == 'U'){
					$trasp_con_u 	= 	$trasp_con_u + $cantidad;
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
								b.movim_estado = 'FINALIZADO'";
			$res_dev_vend 	= 	mysql_query($sql_dev_vend, $conexion);
			$dev_vend_n 	= 	0;
			$dev_vend_u 	= 	0;
			while ($line_dev_vend = mysql_fetch_row($res_dev_vend)) {
				$nu 		= 	$line_dev_vend[0];
				$cantidad	= 	$line_dev_vend[1];
			
				if ($nu == 'N'){
					$dev_vend_n 	= 	$dev_vend_n + $cantidad;
				}
				if ($nu == 'U'){
					$dev_vend_u 	= 	$dev_vend_u + $cantidad;
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
								b.movim_estado = 'FINALIZADO'";
			$res_trasp 	= 	mysql_query($sql_trasp, $conexion);
			$trasp_n 	= 	0;
			$trasp_u 	= 	0;
			while ($line_trasp = mysql_fetch_row($res_trasp)) {
				$nu 		= 	$line_trasp[0];
				$cantidad	= 	$line_trasp[1];
			
				if ($nu == 'N'){
					$trasp_n 	= 	$trasp_n + $cantidad;
				}
				if ($nu == 'U'){
					$trasp_u 	= 	$trasp_u + $cantidad;
				}
			}
			//fin

			/*
			//busca todos los aumentos por devoluciones de clientes (devoluciones que genera existencia que afecta bodega tdev_ncorr = 1)
			//busqueda por codigo antiguo
			$sql_dev_clie 	= "select b.sv_nu as nu, b.sv_cantidad as cantidad

								from 
								d_guiadev a, sub_guiadev b
								
								where
								b.sv_codbus = '".$codigo_antiguo."' and
								b.sv_conf_bodega = 'SI' and 
								b.sv_guiadv = a.gd_guia and
								a.gd_fecha > '2010-09-26' and
								(a.tdev_ncorr = '1' OR a.tdev_ncorr = '0')";
			
			$res_dev_clie 	= 	mysql_query($sql_dev_clie, $conexion);
			$dev_clie_n 	= 	0;
			$dev_clie_u 	= 	0;
			while ($line_dev_clie = mysql_fetch_row($res_dev_clie)) {
				$nu 		= 	$line_dev_clie[0];
				$cantidad	= 	$line_dev_clie[1];
			
				if ($nu == 'N'){
					$dev_clie_n 	= 	$dev_clie_n + $cantidad;
				}
				if ($nu == 'U'){
					$dev_clie_u 	= 	$dev_clie_u + $cantidad;
				}
			}
			*/
			
			//busqueda por codigo nuevo
			$sql_dev_clienew 	= "select b.sv_nu as nu, b.sv_cantidad as cantidad

								from 
								sgyonley.d_guiadev a, sgyonley.sub_guiadev b
								
								where
								b.sv_codbus = '".$codigo."' and
								b.sv_conf_bodega = 'SI' and 
								b.sv_guiadv = a.gd_guia and
								a.tdev_ncorr = '1'";
			
			$res_dev_clienew 	= 	mysql_query($sql_dev_clienew, $conexion);
			$dev_clie_n_new 	= 	0;
			$dev_clie_u_new 	= 	0;
			while ($line_dev_clienew = mysql_fetch_row($res_dev_clienew)) {
				$nu 		= 	$line_dev_clienew[0];
				$cantidad	= 	$line_dev_clienew[1];
			
				if ($nu == 'N'){
					$dev_clie_n_new 	= 	$dev_clie_n_new + $cantidad;
				}
				if ($nu == 'U'){
					$dev_clie_u_new 	= 	$dev_clie_u_new + $cantidad;
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
								b.movim_estado = 'FINALIZADO'";
			$res_aum_vend 	= 	mysql_query($sql_aum_vend, $conexion);
			$aum_vend_n 	= 	0;
			$aum_vend_u 	= 	0;
			while ($line_aum_vend = mysql_fetch_row($res_aum_vend)) {
				$nu 		= 	$line_aum_vend[0];
				$cantidad	= 	$line_aum_vend[1];
			
				if ($nu == 'N'){
					$aum_vend_n 	= 	$aum_vend_n + $cantidad;
				}
				if ($nu == 'U'){
					$aum_vend_u 	= 	$aum_vend_u + $cantidad;
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
								b.movim_estado = 'FINALIZADO'";
			$res_dev_pro 	= 	mysql_query($sql_dev_pro, $conexion);
			$dev_pro_n 	= 	0;
			$dev_pro_u 	= 	0;
			while ($line_dev_pro = mysql_fetch_row($res_dev_pro)) {
				$nu 		= 	$line_dev_pro[0];
				$cantidad	= 	$line_dev_pro[1];
			
				if ($nu == 'N'){
					$dev_pro_n 	= 	$dev_pro_n + $cantidad;
				}
				if ($nu == 'U'){
					$dev_pro_u 	= 	$dev_pro_u + $cantidad;
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
								b.movim_estado = 'FINALIZADO'";
			$res_cp 	= 	mysql_query($sql_cp, $conexion);
			$desc_cp_n 	= 	0;
			$desc_cp_u 	= 	0;
			while ($line_cp = mysql_fetch_row($res_cp)) {
				$nu 		= 	$line_cp[0];
				$cantidad	= 	$line_cp[1];
			
				if ($nu == 'N'){
					$desc_cp_n 	= 	$desc_cp_n + $cantidad;
				}
				if ($nu == 'U'){
					$desc_cp_u 	= 	$desc_cp_u + $cantidad;
				}
			}
			//fin
			
			$stock_nuevo = $aumentos_n + $trasp_con_n + $dev_vend_n + $dev_clie_n + $dev_clie_n_new - $aum_vend_n - $dev_pro_n - $desc_cp_n;
			$stock_usado = $aumentos_u + $trasp_con_u + $dev_vend_u + $dev_clie_u + $dev_clie_u_new - $aum_vend_u - $dev_pro_u - $desc_cp_u;
			
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
                        // busco datos de la venta - Usado mes actual o anterior
                        $sql_tvm = "select sgyonley.ventas_detalle_antigua.vent_cant
				from 
				sgyonley.ventas_antigua
                                    inner join  sgyonley.ventas_detalle_antigua
                                        on sgyonley.ventas_antigua.vent_num_folio =  sgyonley.ventas_detalle_antigua.vent_ncorr 
                                where sgyonley.ventas_detalle_antigua.arti_codigo = ".$codigo."
                                    and sgyonley.ventas_detalle_antigua.arti_nu = 'U'
                                    and sgyonley.ventas_antigua.vent_fecha between '".$fecha_inicio."' and '".$fecha_termino."'
                                    and sgyonley.ventas_antigua.vent_estado_ingreso not in ('A','N','B','D','P')";
                       
                        $res_tvm = mysql_query($sql_tvm,$conexion) OR die(mysql_error());
                        $ventas_men_usa = 0;
                        while ($row_tvm = @mysql_fetch_row($res_tvm)){
                            $ventas_men_usa   = $ventas_men_usa + $row_tvm[0];
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
                        // busco datos de la venta - Usado promedio tres meses atras
                        $sql_tvm = "select sgyonley.ventas_detalle_antigua.vent_cant
				from 
				sgyonley.ventas_antigua
                                    inner join  sgyonley.ventas_detalle_antigua
                                        on sgyonley.ventas_antigua.vent_num_folio =  sgyonley.ventas_detalle_antigua.vent_ncorr 
                                where sgyonley.ventas_detalle_antigua.arti_codigo = ".$codigo."
                                    and sgyonley.ventas_detalle_antigua.arti_nu = 'U'
                                    and sgyonley.ventas_antigua.vent_fecha between '".$fecha_inicio."' and '".$fecha_termino."'
                                    and sgyonley.ventas_antigua.vent_estado_ingreso not in ('A','N','B','D','P')";
                       
                        $res_tvm = mysql_query($sql_tvm,$conexion) OR die(mysql_error());
                        $ventas_tri_usa  =0;
                        while ($row_tvm = @mysql_fetch_row($res_tvm)){
                            $ventas_tri_usa   = $ventas_tri_usa  + $row_tvm[0]/3;
                            }
//                        todos = 0
//                        mensual =1
//                        3 meses =2
//                        sin movimientos = 3                        
                        if ($movimiento==3){
                            if (($ventas_men_nuevo>0)||($ventas_men_usa>0)||($ventas_tri_nuevo>0)||($ventas_tri_usa>0)){
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
                                                            "codigo_antiguo"	=> 	$line_pd[2],
                                                            "stock_nuevo"	=> 	$stock_nuevo,
                                                            "stock_usa"		=> 	$stock_usado,
                                                            "ventas_men_estado"	=> 	$ventas_men_estado,
                                                            "ventas_men_nuevo"	=> 	$ventas_men_nuevo,
                                                            "ventas_men_usa"	=> 	$ventas_men_usa,
                                                            "ventas_tri_estado"	=> 	$ventas_tri_estado,
                                                            "ventas_tri_nuevo"	=> 	$ventas_tri_nuevo,
                                                            "ventas_tri_usa"	=> 	$ventas_tri_usa,
                                                            "ventas_tri_no_estado"	=> 	$ventas_tri_no_estado));
                            }
                        if (($cod_prod=='')){
                            array_push($arrRegistros, array("item"		=>	$i,
                                                            "familia"		=>	$familia,
                                                            "subfamilia"	=>	$subfamilia,
                                                            "descripcion"	=> 	$line_pd[0],
                                                            "codigo" 		=> 	$line_pd[1],
                                                            "codigo_antiguo"	=> 	$line_pd[2],
                                                            "stock_nuevo"	=> 	$stock_nuevo,
                                                            "stock_usa"		=> 	$stock_usado,
                                                            "ventas_men_estado"	=> 	$ventas_men_estado,
                                                            "ventas_men_nuevo"	=> 	$ventas_men_nuevo,
                                                            "ventas_men_usa"	=> 	$ventas_men_usa,
                                                            "ventas_tri_estado"	=> 	$ventas_tri_estado,
                                                            "ventas_tri_nuevo"	=> 	$ventas_tri_nuevo,
                                                            "ventas_tri_usa"	=> 	$ventas_tri_usa,
                                                            "ventas_tri_no_estado"	=> 	$ventas_tri_no_estado));
                            }
			$i++;
		}
	}else{
		
	}
        Enviar( $arrRegistros);

}
?>