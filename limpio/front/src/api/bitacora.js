import request from '../services/request'

export function getBitacoraFromApi(data) {
    return request({
        url: '/api/bitacora',
        method: 'POST',
        data: data
    })
}