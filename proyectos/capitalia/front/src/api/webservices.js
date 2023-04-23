import request from '../services/request'

export function getPersonaByRut(rut) {
    return request({
        url: 'api/webservices/regcivil/persona/' + rut,
        method: 'GET'
    });
}

export function getProgramasByRut(rut) {
    return request({
        url: 'api/webservices/programa/' + rut,
        method: 'GET'
    });
}

export function getChileCreceByRut(rut) {
    return request({
        url: 'api/webservices/chilecrece',
        method: 'POST',
        data: { rut }
    });
}

export function institucionEjecutora(region, anio) {
    return request({
        url: 'api/webservices/institucionEjecutora/' + region + '/' + anio,
        method: 'GET'
    });
}