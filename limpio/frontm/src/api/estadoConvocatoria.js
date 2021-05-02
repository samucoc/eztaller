import request from '../services/request'

export function estados() {
    return request({
        url: '/api/estados',
        method: 'GET'
    })
}