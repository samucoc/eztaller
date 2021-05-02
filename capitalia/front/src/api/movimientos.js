import request from "../services/request";

export function getMovimientosFamiliaFromApi(convocatoria_id) {
    return request({
        url: `/api/convocatoria/${convocatoria_id}/movimientos/1`,
        method: 'GET',
    })
}

export function getMovimientosPropuestaFromApi(convocatoria_id) {
    return request({
        url: `/api/convocatoria/${convocatoria_id}/movimientos/2`,
        method: 'GET',
    })
}