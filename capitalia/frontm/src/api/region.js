import request from '../services/request'

export function regiones() {
    return request({
        url: '/api/regiones',
        method: 'GET'
    })
}