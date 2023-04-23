import request from '../services/request'

export function login(user) {
    return request({
        url: '/api/auth/login',
        method: 'POST',
        data: user
    })
}

export function me() {
    return request({
        url: '/api/auth/me',
        method: 'GET'
    });
}