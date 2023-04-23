import request from "../services/request";

export function getFamilias(params) {
    return request({
        url: '/api/diagnosticoResumen/convocatoria',
        method: 'GET',
        params
    })
}

export function exportar (convocatoriaId) {
    return request({
        url: `/api/diagnosticoResumen/export/${convocatoriaId}`,
        method: 'GET',
        responseType: 'blob',
    })
}

export function print(convocatoriaId) {
    return request({
        url: `api/diagnosticoResumen/print/${convocatoriaId}`,
        method: 'GET',
        responseType: 'blob',
    });
}