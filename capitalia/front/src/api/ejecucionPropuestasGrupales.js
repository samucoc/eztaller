/*eslint-disable */

import request from "../services/request";

export function getFamiliasFromApi(convocatoria_id) {
    return request({
        url: `/api/ejecucion-propuestas/familias/${convocatoria_id}`,
        method: 'GET',
    })
}

export function getAsesoriasGrupalesFromApi(convocatoria_id) {
    return request({
        url: `/api/ejecucion-propuestas/asesorias-grupales/${convocatoria_id}`,
        method: 'GET',
    })
}

export function getByBeneficiarioFromApi(beneficiario_id) {
    return request({
        url: `/api/ejecucion-propuestas/beneficiario/${beneficiario_id}`,
        method: 'GET',
    })
}

export function saveAseFamComentarioFromApi(data) {
    return request({
        url: `/api/ejecucion-propuestas/asesorias-familiares/comentarios`,
        method: 'POST',
        data: data
    })
}

export function getAseFamComentariosFromApi(propuesta_asesoria_id) {
    return request({
        url: `/api/ejecucion-propuestas/asesorias-familiares/comentarios/${propuesta_asesoria_id}`,
        method: 'GET',
    })
}

export function saveSolFamComentarioFromApi(data) {
    return request({
        url: `/api/ejecucion-propuestas/soluciones-familiares/comentarios`,
        method: 'POST',
        data: data
    })
}

export function saveEstadoSol(pro_sol_id, estado_id) {
    return request({
        url: `/api/ejecucion-propuestas/soluciones-familiares/estado`,
        method: 'POST',
        data: {
            pro_sol_id: pro_sol_id,
            estado_id: estado_id
        }
    })
}

export function saveEstadoAse(pro_sol_id, estado_id) {
    return request({
        url: `/api/ejecucion-propuestas/asesorias-familiares/estado`,
        method: 'POST',
        data: {
            pro_sol_id: pro_sol_id,
            estado_id: estado_id
        }
    })
}

export function getSolFamComentariosFromApi(solucion_id) {
    return request({
        url: `/api/ejecucion-propuestas/soluciones-familiares/comentarios/${solucion_id}`,
        method: 'GET',
    })
}

export function getEstadoOptionsFromApi() {
    return request({
        url: `/api/ejecucion-propuestas/estado-options`,
        method: 'GET',
    })
}
/*eslint-disable */