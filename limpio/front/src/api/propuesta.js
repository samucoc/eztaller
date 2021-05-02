import request from '../services/request'

export function dropAsesoriaFamiliarFromApi(data) {
    return request({
        url: `/api/propuestas/asesorias-familiares`,
        method: 'DELETE',
        data: data
    })
}

export function exportResumenPicFromApi(convocatoria_id) {
    return request({
        url: `/api/propuestas/pic/resumen/` + convocatoria_id + `/export`,
        method: 'GET',
    })
}

export function getDatosPropuestaByFamiliasFromApi(data) {
    return request({
        url: `/api/propuestas/datos`,
        method: 'POST',
        data: data
    })
}

export function getResumenPicFromApi(convocatoria_id) {
    return request({
        url: `/api/propuestas/pic/resumen/` + convocatoria_id,
        method: 'GET',
    })
}

export function getResumenModPicFromApi(convocatoria_id) {
    return request({
        url: `/api/propuestas/mod_pic/resumen/` + convocatoria_id,
        method: 'GET',
    })
}

export function getSolucionOptionsFromApi() {
    return request({
        url: `/api/propuestas/solucion/options`,
        method: 'GET',
    })
}

export function getDetalleSolucionOptionsFromApi(solucion_id) {
    return request({
        url: `/api/propuestas/detalle-solucion/options/` + solucion_id,
        method: 'GET',
    })
}

export function getPropuestaPicFromApi(beneficiario_id) {
    return request({
        url: `/api/propuestas/pic/${beneficiario_id}`,
        method: 'GET'
    })
}

export function getPropuestaPicConvocatoriaFromApi(convocatoria_id) {
    return request({
        url: `/api/propuestas/pic/convocatoria/${convocatoria_id}`,
        method: 'GET'
    })
}

export function getPropuestaModPicFromApi(beneficiario_id) {
    return request({
        url: `/api/propuestas/pic/mod/${beneficiario_id}`,
        method: 'GET'
    })
}

export function saveAsesoriaFamiliarFromApi(data) {
    return request({
        url: `/api/propuestas/asesorias-familiares`,
        method: 'POST',
        data: data
    })
}

export function savePropuestaSolucionFromApi(data) {
    return request({
        url: `/api/propuestas/soluciones`,
        method: 'POST',
        data: data
    })
}


export function changeStatusPropuestaSolucionFromApi(status, solucion_id, comentario) {
    return request({
        url: `/api/propuestas/cambiar-estado-soluciones`,
        method: 'POST',
        data: {
                status : status,
                solucion_id : solucion_id,
                comentario : comentario
        }
    })
}

export function changeStatusAsesoriasFromApi(status, solucion_id, comentario) {
    return request({
        url: `/api/propuestas/cambiar-estado-asesorias`,
        method: 'POST',
        data: {
                status : status,
                solucion_id : solucion_id,
                comentario : comentario
        }
    })
}

export function getAsesoriasGrupalesPicFromApi(convocatoria_id) {
    return request({
        url: `/api/propuestas/asesorias-grupales/pic/` + convocatoria_id,
        method: 'GET',
        data: { convocatoria_id: convocatoria_id }
    })
}

export function getAsesoriasGrupalesModPicFromApi(convocatoria_id) {
    return request({
        url: `/api/propuestas/asesorias-grupales/pic/mod/` + convocatoria_id,
        method: 'GET',
        data: { convocatoria_id: convocatoria_id }
    })
}

export function saveAsesoriaGrupalFromApi(data) {
    return request({
        url: `/api/propuestas/asesorias-grupales`,
        method: 'POST',
        data: data
    })
}

export function dropAsesoriaGrupalFromApi(data) {
    return request({
        url: `/api/propuestas/asesorias-grupales`,
        method: 'DELETE',
        data: { propuesta_asesoria_id: data.propuesta_asesoria_id }
    })
}

export function saveCostoAsesoriaFromApi(data) {
    return request({
        url: `/api/propuestas/costo-asesorias`,
        method: 'POST',
        data: data
    })
}

export function downloadCertificadoAprobacionModPicFromApi(convocatoria_id) {
    return request({
        url: '/api/propuestas/mod_pic/certificado-aprobacion/' + convocatoria_id,
        method: 'GET',
        responseType: 'blob',
    });
}

export function getStatusEntidad(entidad_id) {
    return request({
        url: '/api/propuestas/obtener-estados-entidad/'+ entidad_id,
        method: 'GET',
    });
}