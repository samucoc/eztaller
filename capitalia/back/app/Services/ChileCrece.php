<?php


namespace App\Services;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ChileCrece
{
    /**
     * Verifica si un rut pertenece al programa chile crece
     * @param $rut
     * @return array
     */
    public function getChileCreceByRut($rut)
    {
        if (!is_array($rut)) {
            $rut = [$rut];
        }
        foreach ($rut as $index => $item) {
            $rut[$index] = RegCivil::formatRut($item);
        }
        // Obtengo cantidad de ruts que pertenecen a chile crece de cred gestacion
        $queryCredGest = QueriesProd::getCredGestChileCreceQuery($rut);
        $resultCredGest = DB::connection('chcc')->select($queryCredGest);

        // Obtengo cantidad de ruts que pertenecen a chile crece de cred niño
        $queryCredNino = QueriesProd::getCredNinoChileCreceQuery($rut);
        $resultCredNino = DB::connection('chcc')->select($queryCredNino);

        $result = ($resultCredGest[0]->cant + $resultCredNino[0]->cant) > 0;
        return [
            'chileCrece' => $result
        ];
    }
}