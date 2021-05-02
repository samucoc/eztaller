import request from '../services/request'

export function comunasByRegion(regionId) {
    return request({
        url: `/api/comuna/region/${regionId}`,
        method: 'GET'
    })
}

export function comunasByLoggedUser() {
    return request({
        url: '/api/comuna/user',
        method: 'GET'
    })
}