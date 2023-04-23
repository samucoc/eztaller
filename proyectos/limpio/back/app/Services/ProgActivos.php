<?php


namespace App\Services;


use App\Calle;
use Illuminate\Support\Facades\DB;

class ProgActivos
{
    /**
     * Devuelve los programas que no estan activos dado las familias y el programa al que pertenecen
     * @param array $programasId
     * @param array $familiasId
     * @return array
     */
    public function getProgramasInactivosById(array $programasId, array $familiasId)
    {
        $ssoFamilyIds = [];
        $ccvTransIds = [];

        // Separo los programas de sso familia y ccv transversal
        foreach ($programasId as $index => $programaId) {
            if ($programaId == 0) {
                $ssoFamilyIds[] = $familiasId[$index];
            } else {
                $ccvTransIds[] = $familiasId[$index];
            }
        }

        // Obtengo los programas inactivos de sso familia
        $querySsoFamily = QueriesProd::getProgramasInactivosSsoFamilyByIdQuery($ssoFamilyIds);
        $resultSsoFamily = count($ssoFamilyIds) > 0 ? DB::connection('consul_hab')->select($querySsoFamily) : [];

        // Obtengo los programas inactivos de cvv transversal
        $queryCcvTrans = QueriesProd::getProgramasInactivosCcvTransByIdQuery($ccvTransIds);
        $resultCcvTrans = count($ccvTransIds) > 0 ? DB::connection('consul_hab')->select($queryCcvTrans) : [];

        // Mezclo ambos array de resultados y los devuelvo
        return array_merge($resultSsoFamily, $resultCcvTrans);
    }

    /**
     * Devuelve los programas asociados a los integrantes de las familias diferentes al programa origen dado
     * @param $familiaId
     * @param $programaId
     * @return array
     */
    public function getProgramasDiferentesByFamiliaId($familiaId, $programaId)
    {
        // Obtengo los ruts de los integrantes de la familia correspondiente al programa
        $result = $this->getIntegrantesByFamiliaId($familiaId, $programaId);

        // Obtengo los programas dado los ruts para sso familia
        $querySsoFamily = QueriesProd::getProgramasSsoFamilyByFamiliaIdQuery($result);
        $resultSsoFamily = DB::connection('consul_hab')->select($querySsoFamily);

        // Obtengo los programas dado los ruts para cvv transversal
        $queryCcvTrans = QueriesProd::getProgramasCcvTransByFamiliaIdQuery($result);
        $resultCcvTrans = DB::connection('consul_hab')->select($queryCcvTrans);

        // Mezclo ambos array de resultados
        $arr = array_merge($resultSsoFamily, $resultCcvTrans);

        // Selecciono los programas diferentes al pasado por parametro
        return array_filter($arr, function ($programa) use ($programaId) {
            return $programa->programa_id != $programaId;
        });
    }

    /**
     * Devuelve los integrantes de la familia dado el id de la familia y el programa origen
     * @param $familiaId
     * @param $programaId
     * @return array
     */
    public function getIntegrantesByFamiliaId($familiaId, $programaId)
    {
        if ($programaId == 0) {
            // Obtengo los integrantes si pertenencen a sso familia
            $querySsoFamily = QueriesProd::getIntegrantesSsoFamilyByFamiliaIdQuery($familiaId);
            $result = DB::connection('consul_hab')->select($querySsoFamily);
            $result = array_map(function ($persona) {
                return strtoupper($persona->run . '-' . $persona->dv);
            }, $result);
        } else {
            // Obtengo los integrantes si pertenecen a sso transversal
            $queryCcvTrans = QueriesProd::getIntegrantesCcvTransByFamiliaIdQuery($familiaId);
            $result = DB::connection('consul_hab')->select($queryCcvTrans);
            $result = array_map(function ($persona) {
                return strtoupper($persona->rut);
            }, $result);
        }
        // Devuelvo los ruts de los resultados encontrados
        return $result;
    }

    /**
     * Devuelve los programas a los que pertenece un rut
     * @param $rut
     * @return array
     */
    public function getProgramasByRut($rut)
    {
        $rut = RegCivil::formatRut($rut);
        // Obtengo los programas de sso familia
        $querySsoFamily = QueriesProd::getFamilySsoFamilyByRutQuery($rut);
        $programasSsoFamily = DB::connection('consul_hab')->select($querySsoFamily);

        // Obtengo los programas de ccv transversal
        $queryCcvTrans = QueriesProd::getFamilyCcvTransByRutQuery($rut);
        $programasCcvTrans = DB::connection('consul_hab')->select($queryCcvTrans);

        // Mezclo ambos array de resultados
        $programas = array_merge($programasSsoFamily, $programasCcvTrans);

        $callesPrograma = []; // Array asociativo de calles y programas con esa calle
        $callesId = []; // Array con id de calles para consultar en territorialidad
        foreach ($programas as $key => $programa) {
            // Separo el string de ruts en un array
            $programa->ruts = explode(",", $programa->ruts);
            // Valor por defecto para el nombre de la calle
            $programa->nom_calle = null;
            // Identificador unico para el programa
            $programa->item_key = $programa->nom_programa . '-' . $programa->familia_id . '-' . $key;
            $callesId[] = $programa->calle_id;
            $callesPrograma[$programa->calle_id][] = $programa;
        }
        // Busco las calles en territorialidad
        $calles = Calle::find($callesId);
        // Setteo nombre de calle a los programas en caso de existir
        foreach ($calles as $calle) {
            if (array_key_exists($calle->id_calle, $callesPrograma)) {
                foreach ($callesPrograma[$calle->id_calle] as $programa) {
                    $programa->nom_calle = $calle->nombre;
                }
            }
        }
        // Setteo la direccion a los programas
        foreach ($programas as $programa) {
            $programa->direccion = self::getDireccion($programa->nom_calle, $programa->num_casa, $programa->num_bloque, $programa->num_dpto);
        }
        return $programas;
    }

    /**
     * Devuelve la direccion de un programa
     * @param $calle
     * @param $casa
     * @param $bloque
     * @param $dpto
     * @return string
     */
    public static function getDireccion($calle, $casa, $bloque, $dpto)
    {
        $result = $casa;
        if ($calle) {
            $result = $calle . ' ' . $result;
        }
        if ($bloque) {
            $result .= ', Bloque ' . $bloque;
        }
        if ($dpto) {
            $result .= ', Dpto ' . $dpto;
        }
        return $result;
    }
}
