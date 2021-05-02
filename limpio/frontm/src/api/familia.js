import request from '../services/request'

export function getFamilias(params) {
    return request({
        url: '/api/familias/convocatoria',
        method: 'GET',
        params
    })
}

export function getMotivos() {
    return request({
        url: '/api/familias/motivosCancelacion',
        method: 'GET',
    })
}

export function cancelar(motivo, id) {
    return request({
        url: `/api/familias/cancelar`,
        method: 'POST',
        data: {motivo, id}
    })
}

export function activar (id) {
    return request({
        url: `/api/familias/activar/${id}`,
        method: 'GET'
    })
}

export function exportar (convocatoriaId) {
    return request({
        url: `/api/familias/export/${convocatoriaId}`,
        method: 'GET',
        responseType: 'blob',
    })
}

export function print(convocatoriaId) {
    return request({
        url: `api/familias/print/${convocatoriaId}`,
        method: 'GET',
        responseType: 'blob',
    });
}