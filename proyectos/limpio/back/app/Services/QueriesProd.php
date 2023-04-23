<?php


namespace App\Services;
use App\Beneficiario;
use Illuminate\Support\Facades\DB;

class QueriesProd
{
    /**
     * Query para chile crece tabla CREDENCIAL_GESTACION
     * @param array $ruts
     * @return string
     */
    static function getCredGestChileCreceQuery($ruts)
    {
        $where = implode(" OR ", array_map(function ($rut) {
            $run = $rut['run'];
            $dv = $rut['dv'];
            return "(CG.RUN_GESTANTE = $run AND LOWER(CG.DV) = '$dv')";
        }, self::getRutSplitted($ruts)));
        return "SELECT COUNT(*) AS cant FROM CREDENCIAL_GESTACION CG WHERE CG.C_ESTADO_REGISTRO = 2 AND ($where)";
    }

    /**
     * Query para chile crece tabla CREDENCIAL_NINO
     * @param array $ruts
     * @return string
     */
    static function getCredNinoChileCreceQuery($ruts)
    {
        $where = implode(" OR ", array_map(function ($rut) {
            $run = $rut['run'];
            $dv = $rut['dv'];
            return "(CN.RUN_NINO = $run AND LOWER(CN.DV) = '$dv')";
        }, self::getRutSplitted($ruts)));
        return "SELECT COUNT(*) AS cant FROM CREDENCIAL_NINO CN WHERE CN.C_ESTADO_REGISTRO = 2 AND ($where)";
    }

    /**
     * @param $ruts
     * @return array
     */
    static function getRutSplitted($ruts)
    {
        return array_map(function ($rut) {
            $split = explode("-", $rut);
            return [
                'run' => $split[0],
                'dv' => strtolower($split[1])
            ];
        }, $ruts);
    }

    /**
     * Query para obtener programas de sso familia
     * @param string $rut
     * @return string
     */
    public static function getFamilySsoFamilyByRutQuery(string $rut)
    {
        $arr = explode("-", $rut);
        $run = $arr[0];
        $dv = strtoupper($arr[1]);
        return "SELECT 'FAMILIA'                                                      AS NOM_PROGRAMA,
                       0                                                              AS PROGRAMA_ID,
                       EXTRACT (YEAR FROM ASIGNACION_FAMILIA.FECHA_DE_ASIGNACION)     AS ANIO_CONVOCATORIA,
                       FAMILIA.TR01_ID_PK                                             AS FAMILIA_ID,
                       CF01_DESCRIPCION.CF01_DESCRIPCION                              AS ESTADO,
                       FAMILIA.TR01_CALLE_SIT                                         AS CALLE_ID,
                       FAMILIA.TR01_NUMERO_DOMICILIO                                  AS NUM_CASA,
                       FAMILIA.TR01_BLOCK                                             AS NUM_BLOQUE,
                       FAMILIA.TR01_DEPARTAMENTO                                      AS NUM_DPTO,
                       LISTAGG(PERSONA.TR00_RUN || '-' || PERSONA.TR00_DV, ',') 
                            WITHIN GROUP (ORDER BY PERSONA.TR00_RUN)                  AS RUTS,
                       USUARIO.AU01_NOMBRE || ' ' || 
                       USUARIO.AU01_APELLIDO_PATERNO || ' ' ||
                       USUARIO.AU01_APELLIDO_MATERNO                                  AS NOM_APO_FAM,
                       USUARIO.AU01_RUN || '-' || USUARIO.AU01_DV                     AS RUT_APO_FAM,
                       USUARIO.AU01_EMAIL                                             AS EMAIL_APO_FAM,
                       USUARIO.AU01_FONO                                              AS TELEFONO,
                       USUARIO.CF01_VIGENCIA_FK                                       AS ACTIVO
                FROM SSOFAMILIA.TR01_FAMILIA FAMILIA
                LEFT JOIN SSOFAMILIA.CF14_ESTADO CF14_ESTADO 
                    ON FAMILIA.CF14_ESTADO_FK = CF14_ESTADO.CF14_ID_PK
                LEFT JOIN SSOFAMILIA.CF01_DESCRIPCION CF01_DESCRIPCION 
                    ON CF14_ESTADO.CF01_ESTADO_FK = CF01_DESCRIPCION.CF01_ID_PK
                LEFT JOIN SSOFAMILIA.TR02_INTEGRANTE INTEGRANTE 
                    ON INTEGRANTE.TR01_FAMILIA_FK = FAMILIA.TR01_ID_PK
                LEFT JOIN SSOFAMILIA.TR00_PERSONA PERSONA 
                    ON PERSONA.TR00_ID_PK = INTEGRANTE.TR00_PERSONA_FK
                LEFT JOIN SSOFAMILIA.AU01_USUARIO USUARIO 
                    ON USUARIO.AU01_ID_PK = FAMILIA.AU01_APOYO_ACTUAL_FK
                LEFT JOIN (
                    SELECT TR01_FAMILIA_FK, MIN (TR04_FECHA_ASIGNACION) AS FECHA_DE_ASIGNACION 
                    FROM SSOFAMILIA.TR04_ASIGNACIONFAMILIA 
                    GROUP BY TR01_FAMILIA_FK
                ) ASIGNACION_FAMILIA 
                    ON ASIGNACION_FAMILIA.TR01_FAMILIA_FK = FAMILIA.TR01_ID_PK
                WHERE CF01_DESCRIPCION.CF01_DESCRIPCION <> 'EGRESADO SUBSISTEMA'
                AND FAMILIA.TR01_ID_PK IN (
                    SELECT TR02.TR01_FAMILIA_FK
                    FROM SSOFAMILIA.TR02_INTEGRANTE TR02
                    INNER JOIN SSOFAMILIA.TR00_PERSONA T00P 
                        ON TR02.TR00_PERSONA_FK = T00P.TR00_ID_PK
                    WHERE T00P.TR00_RUN = '$run'
                    AND T00P.TR00_DV = UPPER('$dv')
                )
                AND FAMILIA.CF01_VIGENCIA_FK = 1
                AND FAMILIA.CF14_ESTADO_FK > 0
                AND INTEGRANTE.CF01_VIGENCIA_INTEGRANTE_FK IN (171, 172, 173)
                AND INTEGRANTE.CF01_VIGENCIA_FK = 1
                GROUP BY FAMILIA.TR01_ID_PK,
                         FAMILIA.CF14_ESTADO_FK, 
                         CF01_DESCRIPCION.CF01_DESCRIPCION, 
                         FAMILIA.TR01_CALLE_SIT,
                         FAMILIA.TR01_NUMERO_DOMICILIO, 
                         FAMILIA.TR01_BLOCK, 
                         FAMILIA.TR01_DEPARTAMENTO,
                         USUARIO.AU01_NOMBRE || ' ' || USUARIO.AU01_APELLIDO_PATERNO || ' ' || USUARIO.AU01_APELLIDO_MATERNO, USUARIO.AU01_RUN || '-' || USUARIO.AU01_DV, 
                         USUARIO.AU01_EMAIL,
                         USUARIO.AU01_FONO, 
                         USUARIO.CF01_VIGENCIA_FK,
                         EXTRACT (YEAR FROM ASIGNACION_FAMILIA.FECHA_DE_ASIGNACION)";
    }

    /**
     * Query para obtener programas de ccv transversal
     * @param string $rut
     * @return string
     */
    public static function getFamilyCcvTransByRutQuery(string $rut)
    {
        $rut = strtoupper($rut);
        return "SELECT UPPER(PROGRAMA.TR03_NOMBRE)                                                           AS NOM_PROGRAMA,
                       PROGRAMA.TR03_ID_PK                                                                   AS PROGRAMA_ID,
                       CONVOCATORIA.TR04_ANIO                                                                AS ANIO_CONVOCATORIA,
                       INTEGRANTE.TR13_FAMILIA_FK                                                            AS FAMILIA_ID,
                       ESTADO_TRAYECTORIA.TR27_NOMBRE                                                        AS ESTADO,
                       FAMILIA_DATOS.BT02_ID_CALLE_SIT                                                       AS CALLE_ID,
                       FAMILIA_DATOS.BT02_NUMERO                                                             AS NUM_CASA,
                       FAMILIA_DATOS.BT02_BLOCK                                                              AS NUM_BLOQUE,
                       FAMILIA_DATOS.BT02_DEPARTAMENTO                                                       AS NUM_DPTO,
                       LISTAGG(PERSONA.TR12_RUN, ',') WITHIN GROUP ( ORDER BY PERSONA.TR12_RUN)              AS RUTS,
                       FAMILIA_PROF_INSTRUMENTO.TR84_NOMBRE || ' ' || FAMILIA_PROF_INSTRUMENTO.TR84_APELLIDO AS NOM_APO_FAM,
                       FAMILIA_PROF_INSTRUMENTO.TR84_RUN || '-' || FAMILIA_PROF_INSTRUMENTO.TR84_DV          AS RUT_APO_FAM,
                       FAMILIA_PROF_INSTRUMENTO.TR84_MAIL                                                    AS EMAIL_APO_FAM,
                       NULL                                                                                  AS TELEFONO,
                       DECODE(ESTADO_TRAYECTORIA.TR27_ID_PK, 2, 1, 4, 1, 6, 1, 8, 1, 0)                      AS ACTIVO
                FROM CCV_TRANSVERSAL.TR12_PERSONA PERSONA
                INNER JOIN CCV_TRANSVERSAL.BT03_DATOS_PERSONA DATOS_PERSONA
                    ON DATOS_PERSONA.TR12_PERSONA_FK = PERSONA.TR12_ID_PK
                INNER JOIN CCV_TRANSVERSAL.TR04_CONVOCATORIA CONVOCATORIA
                    ON CONVOCATORIA.TR04_ID_PK = PERSONA.TR04_CONVOCATORIA_FK
                INNER JOIN CCV_TRANSVERSAL.TR03_PROGRAMA PROGRAMA
                    ON CONVOCATORIA.TR03_PROGRAMA_FK = PROGRAMA.TR03_ID_PK
                INNER JOIN CCV_TRANSVERSAL.TR17_INTEGRANTE INTEGRANTE 
                    ON INTEGRANTE.TR12_PERSONA_FK = PERSONA.TR12_ID_PK
                INNER JOIN CCV_TRANSVERSAL.BT01_TRAYECTORIA_INTEGRANTE TRAYECTORIA_INTEGRANTE
                    ON TRAYECTORIA_INTEGRANTE.TR17_INTEGRANTE_FK = INTEGRANTE.TR17_ID_PK 
                    AND TRAYECTORIA_INTEGRANTE.BT01_REGISTRO_ACTIVO = 1
                    AND TRAYECTORIA_INTEGRANTE.TR15_TRAYECTORIA_FK = 1
                INNER JOIN CCV_TRANSVERSAL.TR27_ESTADO_TRAYECTORIA ESTADO_TRAYECTORIA
                    ON ESTADO_TRAYECTORIA.TR27_ID_PK = TRAYECTORIA_INTEGRANTE.TR27_ESTADO_TRAYECTORIA_FK
                INNER JOIN CCV_TRANSVERSAL.BT02_FAMILIA_DATOS FAMILIA_DATOS
                    ON FAMILIA_DATOS.TR13_FAMILIA_FK = INTEGRANTE.TR13_FAMILIA_FK
                INNER JOIN CCV_TRANSVERSAL.TR84_FAMILIA_PROF_INSTRUMENTO FAMILIA_PROF_INSTRUMENTO
                    ON FAMILIA_PROF_INSTRUMENTO.TR13_FAMILIA_FK = INTEGRANTE.TR13_FAMILIA_FK
                WHERE ESTADO_TRAYECTORIA.TR27_NOMBRE <> 'Egresado'
                AND INTEGRANTE.TR13_FAMILIA_FK IN (
                    SELECT CCV_TRANSVERSAL.TR17_INTEGRANTE.TR13_FAMILIA_FK
                    FROM CCV_TRANSVERSAL.TR17_INTEGRANTE
                    INNER JOIN CCV_TRANSVERSAL.TR12_PERSONA T12P 
                        ON TR17_INTEGRANTE.TR12_PERSONA_FK = T12P.TR12_ID_PK
                    WHERE T12P.TR12_RUN = UPPER('$rut')
                )
                GROUP BY UPPER(PROGRAMA.TR03_NOMBRE), 
                         CONVOCATORIA.TR04_ANIO,
                         PROGRAMA.TR03_ID_PK, 
                         INTEGRANTE.TR13_FAMILIA_FK, 
                         ESTADO_TRAYECTORIA.TR27_NOMBRE,
                         FAMILIA_DATOS.BT02_ID_CALLE_SIT, 
                         FAMILIA_DATOS.BT02_NUMERO, 
                         FAMILIA_DATOS.BT02_BLOCK,
                         FAMILIA_DATOS.BT02_DEPARTAMENTO,
                         FAMILIA_PROF_INSTRUMENTO.TR84_NOMBRE || ' ' || FAMILIA_PROF_INSTRUMENTO.TR84_APELLIDO,
                         FAMILIA_PROF_INSTRUMENTO.TR84_RUN || '-' || FAMILIA_PROF_INSTRUMENTO.TR84_DV,
                         FAMILIA_PROF_INSTRUMENTO.TR84_MAIL,
                         NULL, 
                         DECODE(ESTADO_TRAYECTORIA.TR27_ID_PK, 2, 1, 4, 1, 6, 1, 8, 1, 0)";
    }

    /**
     * Query para obtener integrantes de un nucleo familiar sso familia
     * @param integer $familiaId
     * @return string
     */
    public static function getIntegrantesSsoFamilyByFamiliaIdQuery($familiaId)
    {
        return "SELECT PERSONA.TR00_ID_PK   AS PERSONA_ID,
                        PERSONA.TR00_RUN    AS RUN,
                        PERSONA.TR00_DV     AS DV
                FROM SSOFAMILIA.TR00_PERSONA PERSONA
                        LEFT JOIN SSOFAMILIA.TR02_INTEGRANTE INTEGRANTE ON PERSONA.TR00_ID_PK = INTEGRANTE.TR00_PERSONA_FK
                WHERE INTEGRANTE.TR01_FAMILIA_FK = $familiaId";
    }

    /**
     * Query para obtener integrantes de un nucleo familiar ccv transversal
     * @param integer $familiaId
     * @return string
     */
    public static function getIntegrantesCcvTransByFamiliaIdQuery($familiaId)
    {
        return "SELECT PERSONA.TR12_ID_PK   AS PERSONA_ID,
                        PERSONA.TR12_RUN    AS RUT
                FROM CCV_TRANSVERSAL.TR12_PERSONA PERSONA
                        INNER JOIN CCV_TRANSVERSAL.TR17_INTEGRANTE INTEGRANTE ON PERSONA.TR12_ID_PK = INTEGRANTE.TR12_PERSONA_FK
                WHERE INTEGRANTE.TR13_FAMILIA_FK = $familiaId";
    }

    /**
     * Query para obtener programas dado array de ruts sso familia
     * @param array $ruts
     * @return string
     */
    public static function getProgramasSsoFamilyByFamiliaIdQuery(array $ruts)
    {
        $or = implode(" OR ", array_map(function ($rut) {
            $arr = explode('-', $rut);
            $run = $arr[0];
            $dv = $arr[1];
            return "PERSONA.TR00_RUN = '$run' AND PERSONA.TR00_DV = '$dv'";
        }, $ruts));
        return "SELECT 0 AS PROGRAMA_ID, FAMILIA.TR01_ID_PK AS FAMILIA_ID
                FROM SSOFAMILIA.TR01_FAMILIA FAMILIA
                        LEFT JOIN SSOFAMILIA.TR02_INTEGRANTE INTEGRANTE ON INTEGRANTE.TR01_FAMILIA_FK = FAMILIA.TR01_ID_PK
                        LEFT JOIN SSOFAMILIA.TR00_PERSONA PERSONA ON PERSONA.TR00_ID_PK = INTEGRANTE.TR00_PERSONA_FK
                WHERE $or";
    }

    /**
     * Query para obtener programas dado array de ruts ccv tyransversal
     * @param array $ruts
     * @return string
     */
    public static function getProgramasCcvTransByFamiliaIdQuery(array $ruts)
    {
        $ruts = array_map(function ($rut) {
            return "'" . $rut . "'";
        }, $ruts);
        return "SELECT CONVOCATORIA.TR03_PROGRAMA_FK AS PROGRAMA_ID, INTEGRANTE.TR13_FAMILIA_FK AS FAMILIA_ID
                FROM CCV_TRANSVERSAL.TR12_PERSONA PERSONA
                        INNER JOIN CCV_TRANSVERSAL.TR04_CONVOCATORIA CONVOCATORIA ON PERSONA.TR04_CONVOCATORIA_FK = CONVOCATORIA.TR04_ID_PK
                        INNER JOIN CCV_TRANSVERSAL.TR17_INTEGRANTE INTEGRANTE ON INTEGRANTE.TR12_PERSONA_FK = PERSONA.TR12_ID_PK
                WHERE PERSONA.TR12_RUN IN (" . implode(",", $ruts) . ")";
    }

    /**
     * Query para obtener los programas inactivos dado array de familias sso familia
     * @param array $ssoFamilyIds
     * @return string
     */
    public static function getProgramasInactivosSsoFamilyByIdQuery(array $ssoFamilyIds)
    {
        return "SELECT * 
                FROM SSOFAMILIA.TR01_FAMILIA FAMILIA
                    LEFT JOIN SSOFAMILIA.AU01_USUARIO USUARIO ON USUARIO.AU01_ID_PK = FAMILIA.AU01_APOYO_ACTUAL_FK
                WHERE USUARIO.CF01_VIGENCIA_FK <> 1 AND FAMILIA.TR01_ID_PK IN (" . implode(",", $ssoFamilyIds) . ")";
    }

    /**
     * Query para obtener los programas inactivos dado array de familias ccv transversal
     * @param array $ccvTransIds
     * @return string
     */
    public static function getProgramasInactivosCcvTransByIdQuery(array $ccvTransIds)
    {
        return "SELECT *
                FROM CCV_TRANSVERSAL.TR13_FAMILIA FAMILIA
                    INNER JOIN CCV_TRANSVERSAL.TR17_INTEGRANTE INTEGRANTE ON FAMILIA.TR13_ID_PK = INTEGRANTE.TR13_FAMILIA_FK
                    INNER JOIN CCV_TRANSVERSAL.BT01_TRAYECTORIA_INTEGRANTE TRAYECTORIA_INTEGRANTE
                        ON TRAYECTORIA_INTEGRANTE.TR17_INTEGRANTE_FK = INTEGRANTE.TR17_ID_PK AND TRAYECTORIA_INTEGRANTE.BT01_REGISTRO_ACTIVO = 1
                    INNER JOIN CCV_TRANSVERSAL.TR27_ESTADO_TRAYECTORIA ESTADO_TRAYECTORIA 
                        ON ESTADO_TRAYECTORIA.TR27_ID_PK = TRAYECTORIA_INTEGRANTE.TR27_ESTADO_TRAYECTORIA_FK
                WHERE DECODE(ESTADO_TRAYECTORIA.TR27_ID_PK, 2, 1, 4, 1, 6, 1, 8, 1, 0) <> 1 
                    AND FAMILIA.TR13_ID_PK IN (" . implode(",", $ccvTransIds) . ")";
    }
    /**
     * Query para obtener GF de programa Familia
     * @param array $ccvTransIds
     * @return string
     */
    public static function getGF_Familia(string $rut)
    {
        $arr = explode('-', $rut);
        $run = $arr[0];
        $dv = $arr[1];
        return "SELECT
                    TR00.TR00_RUN as run,
                    TR00.TR00_DV as dv,
                    TR00.TR00_NOMBRE as nombre,
                    TR00.TR00_APELLIDO_PATERNO as apellido_paterno,
                    TR00.TR00_APELLIDO_MATERNO as apellido_materno,
                    TRUNC(months_between(sysdate, TR00.TR00_FECHA_NACIMIENTO) / 12) as edad,
                    CASE
                        WHEN CF01.CF01_DESCRIPCION = 'MASCULINO' THEN 'M' ELSE 'F'
                    END AS SEXO,
                    CF01_2.CF01_DESCRIPCION AS PARENTESCO,
                    TR01.TR01_ID_PK as id_familia
                FROM
                        SSOFAMILIA.TR02_INTEGRANTE TR02
                INNER JOIN SSOFAMILIA.TR01_FAMILIA TR01 ON TR01.TR01_ID_PK = TR02.TR01_FAMILIA_FK
                INNER JOIN SSOFAMILIA.TR00_PERSONA TR00 ON TR00.TR00_ID_PK = TR02.TR00_PERSONA_FK
                INNER JOIN SSOFAMILIA.CF01_DESCRIPCION CF01 ON CF01.CF01_ID_PK = TR00.CF01_SEXO_FK
                INNER JOIN SSOFAMILIA.CF01_DESCRIPCION CF01_2 ON CF01_2.CF01_ID_PK = TR02.CF01_RELACION_FAMILIAR_FK
                INNER JOIN SSOFAMILIA.CF01_DESCRIPCION CF01_3 ON CF01_3.CF01_ID_PK = TR02.CF01_VIGENCIA_INTEGRANTE_FK
                WHERE
                TR02.TR01_FAMILIA_FK = (
                            SELECT
                                    TR02.TR01_FAMILIA_FK
                            FROM
                                    SSOFAMILIA.TR02_INTEGRANTE TR02
                            INNER JOIN SSOFAMILIA.TR00_PERSONA TR00 ON TR00.TR00_ID_PK = TR02.TR00_PERSONA_FK
                            WHERE   TR02.CF01_VIGENCIA_INTEGRANTE_FK IN (171, 172, 173)
                                    AND TR00.TR00_RUN = '$run'
                            )
                AND TR01.CF14_ESTADO_FK IN (8, 11, 13, 14)
                ORDER BY CF01_2.CF01_DESCRIPCION ASC";
    }
     /**
     * Query para obtener GF de programa Familia
     * @param array $ccvTransIds
     * @return string
     */
    public static function getGF_Vulnerable(string $rut)
    {
        return "SELECT
                    substr(per2.TR12_RUN,1,instr(per2.TR12_RUN,'-')-1) as run,
                    substr(per2.TR12_RUN,instr(per2.TR12_RUN,'-')+1,1) as dv,
                    datper.BT03_NOMBRE as nombre,        
                    datper.BT03_APELLIDO as apellido_paterno,
                    null as apellido_materno,
                    trunc(months_between(sysdate, per2.TR12_FECHA_NACIMIENTO)/12) as edad,
                    CASE
                        WHEN tipgen.TR134_DESCRIPCION = 'Hombre' THEN 'M' ELSE 'F'
                    END AS sexo,
                    null AS PARENTESCO,
                    in2.TR13_FAMILIA_FK as id_familia
                FROM  
                    ccv_transversal.TR17_INTEGRANTE in2
                INNER JOIN ccv_transversal.TR12_PERSONA per2 ON per2.TR12_ID_PK = in2.TR12_PERSONA_FK
                INNER JOIN ccv_transversal.BT03_DATOS_PERSONA datper ON datper.TR12_PERSONA_FK = per2.TR12_ID_PK
                LEFT JOIN ccv_transversal.BT01_TRAYECTORIA_INTEGRANTE trayint ON trayint.TR17_INTEGRANTE_FK = in2.TR17_ID_PK 
                        AND trayint.BT01_REGISTRO_ACTIVO = 1 AND trayint.TR15_TRAYECTORIA_FK != 2
                INNER JOIN CCV_TRANSVERSAL.tr134_tipo_genero tipgen ON tipgen.TR134_ID_PK = datper.TR134_TIPO_GENERO_FK
                        WHERE in2.TR13_FAMILIA_FK in(select in1.TR13_FAMILIA_FK 
                        FROM ccv_transversal.TR12_PERSONA per1 
                INNER JOIN ccv_transversal.TR17_INTEGRANTE in1 ON in1.TR12_PERSONA_FK = per1.TR12_ID_PK 
                
                WHERE per1.TR12_RUN = '$rut')
                    AND in2.TR17_PARTICIPANTE = 1";
    }
    /**
     * Devuelve el grupo Familiar
     * @param $beneficiacioId
     * @return mixed
     */
    public static function getGF($beneficiacioId)
    {
        $benef = Beneficiario::find($beneficiacioId);
        $prog = $benef->nom_programa;
        $benf_rut = $benef->rut_benef;  
        switch ($prog) {
            case "FAMILIA":
            $queryGF = self::getGF_Familia($benf_rut);
            $result = DB::connection('consul_hab')->select($queryGF);
            break;
            
            default:
            $queryVul = self::getGF_Vulnerable($benf_rut);
            $result = DB::connection('consul_hab')->select($queryVul);
            break;
        }
        return $result; 
    }
}