<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Sigec
{
    /**
     * Devuelve los datos de una intitución ejecutora dada la region, el año y el rut (opcional)
     * @param $region
     * @param $anio
     * @param $rut
     * @return array
     */
    public function getInstituciones($region, $anio, $rut = null)
    {
        try {
            $filter_rut = '';
            if (!is_null($rut)) {
                $filter_rut = "and orga.rut='" . $rut . "'";
            }
            // Pendiente agregar filtro de Estado en SIGEC (estado_proyecto)
            $query = "SELECT 
            orga.nombre as org_nombre,
            orga.rut as org_rut,
            dire.calle as org_direccion_calle,
            (
                select info_cont.telefono
                from convenios.info_contacto info_cont
                inner join convenios.usuario usua on usua.id_info_contacto=info_cont.id
                inner join convenios.user_rol on user_rol.id_usuario=usua.id
                where user_rol.id_rol = 1
                and usua.es_inactivo = false
                and usua.id_org=orga.id
                order by usua.id desc
                limit 1
            ) as org_telefono,   
            (
            select tipo_acti.id
            from flow.tipo_actividad as tipo_acti
            inner join flow.actividad as acti on acti.id_tipo_actividad=tipo_acti.id
            inner join flow.workflow as work on work.id=acti.id_workflow
            where work.id=proy.id_workflow
            and acti.actual = true
            limit 1
            ) as estado_proyecto_id,
            (
            select tipo_acti.nombre
            from flow.tipo_actividad as tipo_acti
            inner join flow.actividad as acti on acti.id_tipo_actividad=tipo_acti.id
            inner join flow.workflow as work on work.id=acti.id_workflow
            where work.id=proy.id_workflow
            and acti.actual = true
            limit 1
            ) as estado_proyecto,
            cuota.fecha_pago AS fecha_transferencia_cuota_1,
            pror.fecha_prorroga AS fecha_prorroga,
            (
            select invi.cobertura 
            from convenios.invitacion invi 
            where invi.id_convocatoria=conv.id 
            order by id desc
            limit 1
            ) as cobertura
            from convenios.programa prog
            inner join convenios.convocatoria conv on conv.id_programa=prog.id
            inner join proyectos.proyecto proy on proy.id_convocatoria=conv.id
            inner join convenios.org orga on orga.id=proy.id_org
            inner join convenios.direccion dire on dire.id=orga.id_direccion
            inner join convenios.comuna comu on comu.id=dire.id_comuna
            inner join convenios.provincia prov on prov.id=comu.id_provincia
            inner join convenios.region regi on regi.id=prov.id_region
            left outer join proyectos.cuota cuota on cuota.id_proyecto = proy.id 
            left join (
                select * from proyectos.prorroga t1 where not exists(
                    select * from proyectos.prorroga t2 where (t1.id_proyecto = t2.id_proyecto) and (t1.fecha_prorroga < t2.fecha_prorroga)
                )
            ) pror on pror.id_proyecto = proy.id         
            where prog.id = 3
            and lower(conv.tipo) = 'estandar'
            and conv.ano = $anio
            and regi.id = $region
            $filter_rut
            order by org_nombre";
            // Log::info($query);
            $res = DB::connection('sigec')->select($query);
            $return = array_map(function ($item) {
                return [
                    "nombre" => $item->org_nombre,
                    "rut" => $item->org_rut,
                    "direccion" => $item->org_direccion_calle,
                    "telefono" => $item->org_telefono,
                    "estado_sigec_id" => $item->estado_proyecto_id,
                    "estado_sigec" => $item->estado_proyecto,
                    "fecha_transferencia" => $item->fecha_transferencia_cuota_1,
                    "fecha_termino" => $item->fecha_prorroga,
                    "cobertura" => $item->cobertura
                ];
            }, $res);
            return $return;
        } catch (\Exception $exception) {
            Log::error($exception);
            return [];
        }
    }
}
