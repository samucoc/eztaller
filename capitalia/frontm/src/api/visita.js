import request from '../services/request'

export function _motivosNoVisita() {
    return request({
        url: `/api/visita/motivos-no-visita`,
        method: 'GET'
    })
}

export function saveVisita(visita) {
    return request({
        url: `/api/visita/store`,
        method: 'POST',
        data: visita
    })
}

export function _getVisitas(beneficiarioId) {
    return request({
        url: `/api/visita/beneficiario/${beneficiarioId}`,
        method: 'GET'
    })
}