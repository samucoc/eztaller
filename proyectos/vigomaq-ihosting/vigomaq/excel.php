<?php
  	    {
			include("conex.php");
			$link=Conectarse();

	    }
	 ?>
<?php 
require_once('conex.php');
$sql = "
SELECT 
    *
FROM
    rentabilidad
ORDER BY
    fecha ASC
";
 
$r = mysql_query( $sql ) or trigger_error( mysql_error($link), E_USER_ERROR );
$return = '';
if( mysql_num_rows($r)>0){
    $return .= '<table border=1>';
    $cols = 0;
    while($rs = mysql_fetch_row($r)){
        $return .= '<tr>';
        if($cols==0){
            $cols = sizeof($rs);
            $cols_names = array();
            for($i=0; $i<$cols; $i++){
                $col_name = mysql_field_name($r,$i);
                $return .= '<th>'.htmlspecialchars($col_name).'</th>';
                $cols_names[$i] = $col_name;
            }
            $return .= '</tr><tr>';
        }
        for($i=0; $i<$cols; $i++){
            
            if($cols_names[$i] == 'fechaAlta'){ #Fromateo el registro en formato Timestamp
                $return .= '<td>'.htmlspecialchars(date('d/m/Y H:i:s',$rs[$i])).'</td>';
            }else if($cols_names[$i] == 'activo'){ #Estado lógico del registro, en vez de 1 o 0 le muestro Si o No.
                $return .= '<td>'.htmlspecialchars( $rs[$i]==1? 'SI':'NO' ).'</td>';
            }else{
                $return .= '<td>'.htmlspecialchars($rs[$i]).'</td>';
            }
        }
        $return .= '</tr>';
    }
    $return .= '</table>';
    mysql_free_result($r);
}

header("Content-type: application/vnd-ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=export.xls");
echo utf8_decode($return);  
?>