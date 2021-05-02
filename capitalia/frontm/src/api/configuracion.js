import request from "../services/request";

export function getConfigFromApi(variable, campo = null) {
    return request({
        url: `/api/config`,
        method: 'POST',
        data: {
            variable: variable,
            campo: campo
        }
    })
}

export function setConfigFromApi(variable, valor) {
    return request({
        url: `/api/config`,
        method: 'PUT',
        data: {
            variable: variable,
            valor: valor
        }
    })
}