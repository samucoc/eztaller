<?php
ob_start();
include('conf_bd.php');
global $conexion;

//dias en letras
function dias2letras($dia){
    list($a,$m,$d) = explode('-',$dia);
    $mes_letra = '';
    if ($m=='1') $mes_letra = 'Enero';
    if ($m=='2') $mes_letra = 'Febrero';
    if ($m=='3') $mes_letra = 'Marzo';
    if ($m=='4') $mes_letra = 'Abril';
    if ($m=='5') $mes_letra = 'Mayo';
    if ($m=='6') $mes_letra = 'Junio';
    if ($m=='7') $mes_letra = 'Julio';
    if ($m=='8') $mes_letra = 'Agosto';
    if ($m=='9') $mes_letra = 'Septiembre';
    if ($m=='10') $mes_letra = 'Octubre';
    if ($m=='11') $mes_letra = 'Noviembre';
    if ($m=='12') $mes_letra = 'Diciembre';

    return $d.' de '.$mes_letra.' de '.$a;
}


// funcion que ordena una matriz
function ordenar_matriz_multidimensionada($m,$ordenar,$direccion) {
  usort($m, function($item1, $item2){ return strtoupper($item1[$ordenar]) . ($direccion === 'ASC' ? '>' : '<') . strtoupper($item2[$ordenar]);   } );
  return $m;
}

//funcion resta horas
function RestaHoras($horaIni, $horaFin){
    return (date("H:i:s", strtotime("00:00:00") + strtotime($horaFin) - strtotime($horaIni) ));
}

//funcion valida rut.
//function dv($r){$s=1;for($m=0;$r!=0;$r/=10)$s=($s+$r%10*(9-$m++%6))%11;
//return chr($s?$s+47:75);}

/* string -> string */
function dv($r){
  $s=1;
  for($m=0;$r!=0;$r/=10) $s=($s+$r%10*(9-$m++%6))%11;
  return chr($s?$s+47:75);
}

//valida numeros enteros
function ValidaNumeros ($x) {
    return (is_numeric($x) ? intval($x) == $x : false);
}

//valida el ingreso de fecha correcta
function ValidaFecha ($f) {
	list($dia,$mes,$anio) = explode('/', $f);
	return checkdate($mes, $dia, $anio);
}
//valida numeros decimales
function verifRealConDosDecimales($valor,$signo=3){
    if($signo==1)
        $patron = "/^[0-9]+(.[0-9]{1,2}|[0-9]*)$/";
    elseif($signo==2)
        $patron = "/^-[0-9]+(.[0-9]{1,2}|[0-9]*)$/";
    else
        $patron = "/^-?[0-9]+(.[0-9]{1,2}|[0-9]*)$/";
        
    if(!preg_match($patron,$valor))
        return true;
    else
        return false;
}

//compara fechas
function ComparaFechas ($f1, $f2) {
	list($dia1,$mes1,$anio1) = explode('/', $f1);
	list($dia2,$mes2,$anio2) = explode('/', $f2);

	//$fecha1 = mktime(0, 0, 0, $mes1, $dia1, $anio1);
	//$fecha2 = mktime(0, 0, 0, $mes2, $dia2, $anio2);
	
	return (mktime(0, 0, 0, $mes2, $dia2, $anio2) - mktime(0, 0, 0, $mes1, $dia1, $anio1));
}
function DevuelveDias ($f1, $f2) {
	list($dia1,$mes1,$anio1) = explode('/', $f1);
	list($dia2,$mes2,$anio2) = explode('/', $f2);
	

	$fecha1 = mktime(0, 0, 0, $mes1, $dia1, $anio1);
	$fecha2 = mktime(4, 12, 0, $mes2, $dia2, $anio2);
	
	//resto a una fecha la otra 
	$segundos_diferencia = $fecha1 - $fecha2; 
	//echo $segundos_diferencia; 

	//convierto segundos en días 
	$dias_diferencia = $segundos_diferencia / (60 * 60 * 24); 

	//obtengo el valor absoulto de los días (quito el posible signo negativo) 
	$dias_diferencia = abs($dias_diferencia); 

	//quito los decimales a los días de diferencia 
	$dias_diferencia = floor($dias_diferencia); 

	//echo $dias_diferencia; 
	
	//$total_dias = 0;
	
	//while ($fecha1 < $fecha2){
	//		$total_dias = $total_dias + 1;
	//		$fecha1 += 86400;
	//}
	//$total_dias++;
	
	return $dias_diferencia;
}
function SumaDias($mes, $anio, $dia, $dias)
{
     
	 		$ultimo_dia = date( "d", mktime(0, 0, 0, $mes + 1, 0, $anio) ) ;
      		$dias_adelanto = $dias;
      		$siguiente = $dia + $dias_adelanto;
      		if ($ultimo_dia < $siguiente)
      		{
         		$dia_final = $siguiente - $ultimo_dia;
         		$mes++;
         		if ($mes == '13')
         		{
            		$anio++;
            		$mes = '01';
         		}
         			$fecha_final = $dia_final.'/'.$mes.'/'.$anio;         
      		}
      		else
      		{
  				$fecha_final = $siguiente .'/'.$mes.'/'.$anio;         
      		}
      		return $fecha_final;
 }
function RestaDias($mes, $anio, $dia, $dias)
{
     
	 		$ultimo_dia = date( "d", mktime(0, 0, 0, $mes + 1, 0, $anio) ) ;
      		$dias_adelanto = $dias;
      		$siguiente = $dia + $dias_adelanto;
      		if ($ultimo_dia < $siguiente)
      		{
         		$dia_final = $siguiente - $ultimo_dia;
         		$mes--;
         		if ($mes == '13')
         		{
            		$anio--;
            		$mes = '01';
         		}
         			$fecha_final = $dia_final.'/'.$mes.'/'.$anio;         
      		}
      		else
      		{
  				$fecha_final = $siguiente .'/'.$mes.'/'.$anio;         
      		}
      		return $fecha_final;
 }


//arreglos...
//arreglo de horas
$arrHoras=array(array("IDHora" => "01"), array("IDHora" => "02"), array("IDHora" => "03"),
                array("IDHora" => "04"), array("IDHora" => "05"), array("IDHora" => "06"), array("IDHora" => "07"),
               	array("IDHora" => "08"), array("IDHora" => "09"), array("IDHora" => "10"), array("IDHora" => "11"),
               	array("IDHora" => "12"), array("IDHora" => "13"), array("IDHora" => "14"), array("IDHora" => "15"),
              	array("IDHora" => "16"), array("IDHora" => "17"), array("IDHora" => "18"), array("IDHora" => "19"),
              	array("IDHora" => "20"), array("IDHora" => "21"), array("IDHora" => "22"), array("IDHora" => "23"),
				array("IDHora" => "24"));


//sql para unir tablas...
//SELECT *, comunas_descripcion FROM usuarios,comunas 
//WHERE usuarios.comuna = comunas.id;

//transforma a letras los montos...
function num2letras($num, $fem = true, $dec = true) { 
//if (strlen($num) > 14) die("El n?mero introducido es demasiado grande"); 
   $matuni[2]  = "dos"; 
   $matuni[3]  = "tres"; 
   $matuni[4]  = "cuatro"; 
   $matuni[5]  = "cinco"; 
   $matuni[6]  = "seis"; 
   $matuni[7]  = "siete"; 
   $matuni[8]  = "ocho"; 
   $matuni[9]  = "nueve"; 
   $matuni[10] = "diez"; 
   $matuni[11] = "once"; 
   $matuni[12] = "doce"; 
   $matuni[13] = "trece"; 
   $matuni[14] = "catorce"; 
   $matuni[15] = "quince"; 
   $matuni[16] = "dieciseis"; 
   $matuni[17] = "diecisiete"; 
   $matuni[18] = "dieciocho"; 
   $matuni[19] = "diecinueve"; 
   $matuni[20] = "veinte"; 
   $matunisub[2] = "dos"; 
   $matunisub[3] = "tres"; 
   $matunisub[4] = "cuatro"; 
   $matunisub[5] = "quin"; 
   $matunisub[6] = "seis"; 
   $matunisub[7] = "sete"; 
   $matunisub[8] = "ocho"; 
   $matunisub[9] = "nove"; 

   $matdec[2] = "veint"; 
   $matdec[3] = "treinta"; 
   $matdec[4] = "cuarenta"; 
   $matdec[5] = "cincuenta"; 
   $matdec[6] = "sesenta"; 
   $matdec[7] = "setenta"; 
   $matdec[8] = "ochenta"; 
   $matdec[9] = "noventa"; 
   $matsub[3]  = 'mill'; 
   $matsub[5]  = 'bill'; 
   $matsub[7]  = 'mill'; 
   $matsub[9]  = 'trill'; 
   $matsub[11] = 'mill'; 
   $matsub[13] = 'bill'; 
   $matsub[15] = 'mill'; 
   $matmil[4]  = 'millones'; 
   $matmil[6]  = 'billones'; 
   $matmil[7]  = 'de billones'; 
   $matmil[8]  = 'millones de billones'; 
   $matmil[10] = 'trillones'; 
   $matmil[11] = 'de trillones'; 
   $matmil[12] = 'millones de trillones'; 
   $matmil[13] = 'de trillones'; 
   $matmil[14] = 'billones de trillones'; 
   $matmil[15] = 'de billones de trillones'; 
   $matmil[16] = 'millones de billones de trillones'; 

   $num = trim((string)@$num); 
   if ($num[0] == '-') { 
      $neg = 'menos '; 
      $num = substr($num, 1); 
   }else 
      $neg = ''; 
   while ($num[0] == '0') $num = substr($num, 1); 
   if ($num[0] < '1' or $num[0] > 9) $num = '0' . $num; 
   $zeros = true; 
   $punt = false; 
   $ent = ''; 
   $fra = ''; 
   for ($c = 0; $c < strlen($num); $c++) { 
      $n = $num[$c]; 
      if (! (strpos(".,'''", $n) === false)) { 
         if ($punt) break; 
         else{ 
            $punt = true; 
            continue; 
         } 

      }elseif (! (strpos('0123456789', $n) === false)) { 
         if ($punt) { 
            if ($n != '0') $zeros = false; 
            $fra .= $n; 
         }else 

            $ent .= $n; 
      }else 

         break; 

   } 
   $ent = '     ' . $ent; 
   if ($dec and $fra and ! $zeros) { 
      $fin = ' coma'; 
      for ($n = 0; $n < strlen($fra); $n++) { 
         if (($s = $fra[$n]) == '0') 
            $fin .= ' cero'; 
         elseif ($s == '1') 
            $fin .= $fem ? ' uno' : ' un'; 
         else 
            $fin .= ' ' . $matuni[$s]; 
      } 
   }else 
      $fin = ''; 
   if ((int)$ent === 0) return 'Cero ' . $fin; 
   $tex = ''; 
   $sub = 0; 
   $mils = 0; 
   $neutro = false; 
   while ( ($num = substr($ent, -3)) != '   ') { 
      $ent = substr($ent, 0, -3); 
      if (++$sub < 3 and $fem) { 
         $matuni[1] = 'uno'; 
         $subcent = 'os'; 
      }else{ 
         $matuni[1] = $neutro ? 'un' : 'uno'; 
         $subcent = 'os'; 
      } 
      $t = ''; 
      $n2 = substr($num, 1); 
      if ($n2 == '00') { 
      }elseif ($n2 < 21) 
         $t = ' ' . $matuni[(int)$n2]; 
      elseif ($n2 < 30) { 
         $n3 = $num[2]; 
         if ($n3 != 0) $t = 'i' . $matuni[$n3]; 
         $n2 = $num[1]; 
         $t = ' ' . $matdec[$n2] . $t; 
      }else{ 
         $n3 = $num[2]; 
         if ($n3 != 0) $t = ' y ' . $matuni[$n3]; 
         $n2 = $num[1]; 
         $t = ' ' . $matdec[$n2] . $t; 
      } 
      $n = $num[0]; 
      if ($n == 1) { 
         $t = ' ciento' . $t; 
      }elseif ($n == 5){ 
         $t = ' ' . $matunisub[$n] . 'ient' . $subcent . $t; 
      }elseif ($n != 0){ 
         $t = ' ' . $matunisub[$n] . 'cient' . $subcent . $t; 
      } 
      if ($sub == 1) { 
      }elseif (! isset($matsub[$sub])) { 
         if ($num == 1) { 
            $t = ' mil'; 
         }elseif ($num > 1){ 
            $t .= ' mil'; 
         } 
      }elseif ($num == 1) { 
         $t .= ' ' . $matsub[$sub] . '?n'; 
      }elseif ($num > 1){ 
         $t .= ' ' . $matsub[$sub] . 'ones'; 
      }   
      if ($num == '000') $mils ++; 
      elseif ($mils != 0) { 
         if (isset($matmil[$sub])) $t .= ' ' . $matmil[$sub]; 
         $mils = 0; 
      } 
      $neutro = true; 
      $tex = $t . $tex; 
   } 
   $tex = $neg . substr($tex, 1) . $fin; 
   return ucfirst($tex); 
} 

function cargar_valor($fecha, $inicio, $fin, $monto, $k, $array, $nivel){
	if ($array[$k]['inicio']!=''){
		$array = cargar_valor($fecha, $inicio, $fin, $monto, $k, $array, $nivel+$nivel);
		}
	else{ 
		$array[$k+$nivel]['fecha'] = $fecha;
		$array[$k+$nivel]['inicio'] = $inicio;
		$array[$k+$nivel]['fin'] = $fin;
		$array[$k+$nivel]['monto'] = $monto;
		}
	return $array;
	}
function generaPromedioSemestral($rut, $curso, $ramo, $coeficiente, $anio, $semestre){
      global $conexion;

      $select_notas = "select prueba_ncorr , CoeficientePrueba, NumeroNota  
                from Pruebas
              where  Pruebas.CodigoCurso = '".$curso."' and 
                  Pruebas.CodigoRamo = '".$ramo."' and  
                  Pruebas.AnoAcademico = '".$anio."' and  
                  Pruebas.Semestre = '".$semestre."'";
      $res_notas = mysql_query($select_notas, $conexion) or die(mysql_error());
      $j=1;
      $k=0;
      $z="";
      $total = 0;
      $codigo_ramo = "";
      $promedio_1 = 0;
      while($row_notas = mysql_fetch_array($res_notas)){

        $select_notas_1 = "select Nota, NumeroRutAlumno, NotasAlumnos.CodigoCurso, 
                  NotasAlumnos.CodigoRamo, NotasAlumnos.AnoAcademico, NotasAlumnos.Semestre, 
                  NotasAlumnos.NumeroNota, DescripcionPrueba
              from NotasAlumnos
                inner join Pruebas
                  on Pruebas.NumeroNota = NotasAlumnos.NumeroNota and 
                    Pruebas.CodigoCurso = '".$curso."' and 
                    Pruebas.CodigoRamo = '".$ramo."' and  
                    Pruebas.AnoAcademico = '".$anio."' and  
                    Pruebas.Semestre = '".$semestre."' 
              where  NotasAlumnos.NumeroRutAlumno = '".$rut."' and 
                  NotasAlumnos.CodigoCurso = '".$curso."' and 
                  NotasAlumnos.CodigoRamo = '".$ramo."' and  
                  NotasAlumnos.AnoAcademico = '".$anio."' and  
                  NotasAlumnos.Semestre = '".$semestre."' and 
                  Pruebas.NumeroNota = '".$row_notas['NumeroNota']."'";
        $res_notas_1 = mysql_query($select_notas_1, $conexion) or die(mysql_error());
        $j=0;
        if (mysql_num_rows($res_notas_1)>0){
          while($row_notas_1 = mysql_fetch_array($res_notas_1)){
            for($r=0;$r<$row_notas['CoeficientePrueba'];$r++){
              $total = $row_notas_1['Nota'] + $total;
              $codigo_ramo = $row_notas_1['CodigoRamo'];
              $j++;
              if ($row_notas_1['Nota']>0){
                $k++;
                }
              }
            }
          }
        else{
          for($r=0;$r<$coeficiente;$r++){
            $total = 0 + $total;
            $codigo_ramo = $ramo;
            $j++;
            }
          }
        if ($k>0){
          $promedio_1 = $total/$k;
          }
        else{
          $promedio_1=0;
          }
        } 
      
      $temp = array();

      array_push($temp, array("rut_alumno"      =>  $rut, 
                              "CodigoRamo"      =>  $ramo, 
                              "nota"            =>  round($promedio_1,1,PHP_ROUND_HALF_UP),
                              "semestre"        =>  $semestre
                          ));
      return $temp;
    }
ob_flush();
?>