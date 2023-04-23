<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Uf
 *
 * @author Cosme
 */
class Uf {

    /**
     *
     * @var private
     */
    private $url;

    /**
     *
     * @var private
     */
    private $anyo; //para comprobar si el año corresponde
    /**
     *
     * @var string
     * guarda el separador decimal que queremos al final del proceso 
     */
    private $separador_decimal;

    /**
     *
     * @var array_bi
     * contiene un array bidimensional ordenado por [dia][mes]
     */
    private $data;

    /**
     *
     * @param int $anyo
     * @param string $separador_decimal 
     * construye la uf. El año es requerido para cargar la informacion desde el sii
     * disponible 2010/2011/2012
     */
    public function __construct($anyo, $separador_decimal=".") {
        if (!isset($anyo))
                       $anyo = date('Y');

        $this->anyo = $anyo;
        $this->separador_decimal = $separador_decimal;
        $this->getFromSII($anyo);
    }

    /**
     *
     * @param type $anyo 
     * trae los datos del sii cargando la pagina correspondiente al año
     */
    private function getFromSII($anyo) {
        $this->anyo = $anyo;
        $this->url = "http://www.sii.cl/pagina/valores/uf/uf$anyo.htm";
        $ch = curl_init("$this->url");
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_POST, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch) or die("Error obteniendo datos via cURL");
        curl_close($ch);
        $output = explode("<table", $output);
        $output = explode("<tr>", $output[1]);
        $arr_dia = array();
        for ($i = 2; $i < count($output); $i++) {
            $tmp = explode("<th style='text-align:center;'>", $output[$i]);
            $tmp = explode("</th>", $tmp[1]);
            $tmp2 = explode("<td style='text-align:right;'>", $output[$i]);
            for ($o = 0; $o < count($tmp2); $o++) { //aqui es para limpiar los datos
                $tmp2[$o] = str_replace("\n   ", "", str_replace("</td>", "", $tmp2[$o]));
                $tmp2[$o] = str_replace("\n", "", $tmp2[$o]);
                $tmp2[$o] = str_replace("</tr>", "", $tmp2[$o]);
                $tmp2[$o] = str_replace("&nbsp;", "0", $tmp2[$o]);
                $tmp2[$o] = str_replace(".", "", $tmp2[$o]);
                $tmp2[$o] = str_replace(",", $this->separador_decimal, $tmp2[$o]); //aqui cambiamos el separador decimal
                $tmp2[$o] = str_replace("<th style='text-align:center;'>", "", $tmp2[$o]);
                $tmp2[$o] = str_replace("</th>", "", $tmp2[$o]);
            }
            $arr_dia[$tmp[0]] = $tmp2;
        }
        //caso especial 31-12
        $tmp = $arr_dia[31][12];
        $tmp = explode("\r", $tmp);
        $arr_dia[31][12] = $tmp[0];
        $this->data = $arr_dia;
    }

    /**
     *
     * @param date $date
     * @return string
     * devuelve un valor UF de una fecha especifica. En caso de ser de un distinto año al procesado
     * al construir, cambia el año del objeto y vuelve a cargar. Debe venir en dia/mes/anyo4digitos
     */
    public function getDate($date) {
        $date = str_replace("/", "-", $date);
        $fechaTMP = explode("-", $date);
        $dia = (int) $fechaTMP[0];
        $mes = (int) $fechaTMP[1];
        $anyo = (int) $fechaTMP[2];
        if (!isset($this->datos) || $this->anyo != $anyo) {
            //si no estan los datos, lo que seria un super WTF
            //o si el año no corresponde
            $this->getFromSII($anyo);
        }
        return $this->data[$dia][$mes];
    }

}

?>