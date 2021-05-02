import request from "../services/request";

export function getRoleOptionsFromApi(data) {
    return request({
        url: `/api/admin/roles/options`,
        method: 'POST',
        data: data
    })
}
