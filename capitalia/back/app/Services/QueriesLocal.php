<?php


namespace App\Services;


class QueriesLocal
{
    /**
     * @param $ruts
     * @return string
     */
    static function getChileCreceQuery($ruts)
    {
        return "select * from TST_PERSONAS where rut in ('" . implode("', '", $ruts) . "')";
    }

    /**
     * @param $programasId
     * @return string
     */
    static function getProgramasInactivosByIdQuery($programasId)
    {
        return "SELECT * FROM TST_PROGRAMAS
                    WHERE TST_PROGRAMAS.ACTIVO <> 1 AND PROGRAMA_ID IN (" . implode(",", $programasId) . ")";
    }

    /**
     * @return string
     */
    static function getProgramasByFamiliaIdQuery()
    {
        return "select distinct TST_PROGRAMAS.PROGRAMA_ID, f.FAMILIA_ID from TST_PROGRAMAS
                    inner join TST_FAMILIAS f on TST_PROGRAMAS.familia_id = f.familia_id
                    inner join TST_INTEGRANTES i on f.familia_id = i.familia_id
                    inner join TST_PERSONAS p on i.persona_id = p.persona_id
                    where programa_id <> ? and p.rut in (
                        select rut from TST_PERSONAS 
                        inner join TST_INTEGRANTES i2 on TST_PERSONAS.persona_id = i2.persona_id
                        inner join TST_FAMILIAS f2 on i2.familia_id = f2.familia_id
                        where f2.familia_id = ?
                    )";
    }

    /**
     * @return string
     */
    static function getIntegrantesByFamiliaIdQuery()
    {
        return "SELECT TST_PERSONAS.PERSONA_ID, UPPER(TST_PERSONAS.RUT) AS RUT FROM TST_PERSONAS
                    INNER JOIN TST_INTEGRANTES I ON TST_PERSONAS.PERSONA_ID = I.PERSONA_ID
                    INNER JOIN TST_FAMILIAS F ON I.FAMILIA_ID = F.FAMILIA_ID
                    WHERE F.FAMILIA_ID = ?";
    }

    /**
     * @return string
     */
    static function getProgramasByRutQuery()
    {
        return "SELECT TST_PROGRAMAS.*, LISTAGG(P.RUT, ',') WITHIN GROUP (ORDER BY NOMBRE) AS RUTS FROM TST_PROGRAMAS 
                    inner join TST_FAMILIAS f on TST_PROGRAMAS.familia_id = f.familia_id
                    inner join TST_INTEGRANTES i on f.familia_id = i.familia_id
                    inner join TST_PERSONAS p on i.persona_id = p.persona_id
                    where estado <> 'Egresada del Subsistema' and f.familia_id in (
                        select familia_id from TST_INTEGRANTES
                        inner join TST_PERSONAS p2 on TST_INTEGRANTES.persona_id = p2.persona_id
                        where p2.rut = ?
                    )
                    group by PROGRAMA_ID, TST_PROGRAMAS.FAMILIA_ID, NOM_PROGRAMA, ESTADO, ACTIVO, TST_PROGRAMAS.TELEFONO, CALLE_ID, NUM_CASA, NUM_BLOQUE, NUM_DPTO, RUT_APO_FAM, NOM_APO_FAM, EMAIL_APO_FAM";
    }
}