import request from '../services/request'

export function all(convocatoriaId, estado) {
    return request({
        url: '/api/beneficiario',
        method: 'GET',
        params: { convocatoriaId, estado }
    })
}

export function store(data) {
    return request({
        url: '/api/beneficiario',
        method: 'POST',
        data
    })
}

export function get(id) {
    return request({
        url: '/api/beneficiario/' + id,
        method: 'GET'
    })
}


export function update(id, data) {
    return request({
        url: '/api/beneficiario/' + id,
        method: 'PUT',
        data
    })
}

export function preSelectFamilia(beneficiarios) {
    return request({
        url: 'api/beneficiario/pre-select/familia',
        method: 'POST',
        data: { beneficiarios }
    })
}

export function selectFamilia(beneficiarios) {
    return request({
        url: 'api/beneficiario/select/familia',
        method: 'POST',
        data: { beneficiarios }
    })
}


export function checkConvocatoria(rut, convocatoria, anio = null) {
    return request({
        url: 'api/beneficiario/check/convocatoria',
        method: 'POST',
        data: { rut, convocatoria, anio }
    })
}

export function checkIntegrante(familia, programa, convocatoria) {
    return request({
        url: 'api/beneficiario/check/integrante',
        method: 'POST',
        data: { familia, programa, convocatoria }
    })
}

export function _export(convocatoriaId) {
    return request({
        url: 'api/beneficiario/export/' + convocatoriaId,
        method: 'GET',
        responseType: 'blob',
    });
}

export function print(convocatoriaId) {
    return request({
        url: 'api/beneficiario/print/' + convocatoriaId,
        method: 'GET',
        responseType: 'blob',
    });
}