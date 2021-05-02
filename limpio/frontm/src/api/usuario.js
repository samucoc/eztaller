import request from "../services/request";

export function getProfesionOptionsFromApi() {
    return request({
        url: `/api/admin/usuarios/profesiones/options`,
        method: 'POST',
    })
}

export function getUsersFromApi(data) {
    return request({
        url: `/api/admin/usuarios/list`,
        method: 'POST',
        data: data
    })
}

export function storeUserFromApi(user) {
    return request({
        url: `/api/admin/usuarios`,
        method: 'POST',
        data: user
    })
}

export function updateUserFromApi(user) {
    return request({
        url: `/api/admin/usuarios/${user.id}`,
        method: 'PUT',
        data: user
    })
}

export function getRegionesFromApi(data) {
    return request({
        url: `/api/admin/usuarios/regiones/options`,
        method: 'POST',
        data: data
    })
}

export function getComunasFromApi(data) {
    return request({
        url: `/api/admin/usuarios/comunas/options`,
        method: 'POST',
        data: data
    })
}

export function changePasswordFromApi(user_id, password_actual, password_nuevo) {
    return request({
        url: `/api/admin/usuarios/clave`,
        method: 'PUT',
        data: {
            user_id: user_id,
            password_actual: password_actual,
            password_nuevo: password_nuevo,
        }
    })
}


export function create(convocatoria) {
    return request({
        url: `/api/convocatoria`,
        method: 'POST',
        data: convocatoria
    })
}

export function update(convocatoria, id) {
    return request({
        url: `/api/convocatoria/${id}`,
        method: 'PUT',
        data: convocatoria
    })
}

export function remove(id) {
    return request({
        url: `/api/convocatoria/${id}`,
        method: 'DELETE'
    })
}

export function getAniosConvocatoriasByTerritorio() {
    return request({
        url: `/api/convocatoria/anios`,
        method: 'GET'
    })
}

export function getByComuna(comunaId) {
    return request({
        url: `/api/convocatoria/comuna/${comunaId}`,
        method: 'GET',
    })
}

export function print(convocatorias) {
    return request({
        url: `api/convocatoria/print/${convocatorias}`,
        method: 'GET',
        responseType: 'blob',
    });
}

export function _export(convocatorias) {
    return request({
        url: `api/convocatoria/export/${convocatorias}`,
        method: 'GET',
        responseType: 'blob',
    });
}

export function visarListadoFamilia(idConvocatoria, visar) {
    return request({
        url: `/api/convocatoria/visar/${idConvocatoria}/${visar}`,
        method: 'GET'
    })
}

export function aprobacionListadoRegional(data) {
    return request({
        url: `/api/convocatoria/aprobar`,
        method: 'POST',
        data
    })
}

export function aprobacionPropuestaRegional(data) {
    return request({
        url: `/api/convocatoria/propuesta/aprobar`,
        method: 'POST',
        data
    })
}

export function _visarPropuesta(idConvocatoria, visar) {
    return request({
        url: `/api/convocatoria/visar/propuesta/${idConvocatoria}/${visar}`,
        method: 'GET'
    })
}

export function actaMesaTecnica(idConvocatoria, file) {
    let formData = new FormData();
    formData.append('file', file);
    return request({
        url: `/api/convocatoria/${idConvocatoria}/acta_mesa_tecnica`,
        headers: { 'Content-Type': 'multipart/form-data' },
        method: 'POST',
        data: formData
    })
}

export function actaMesaTecnicaPic(idConvocatoria, file) {
    let formData = new FormData();
    formData.append('file', file);
    return request({
        url: `/api/convocatoria/${idConvocatoria}/acta_mesa_tecnica_pic`,
        headers: { 'Content-Type': 'multipart/form-data' },
        method: 'POST',
        data: formData
    })
}

export function _download(actaMesaTecnicaId) {
    return request({
        url: 'api/convocatoria/download/' + actaMesaTecnicaId,
        method: 'GET',
        responseType: 'blob',
    });
}

export function getParticipacionesByRUT(rut) {
    return request({
        url: `/api/convocatoria/participaciones`,
        method: 'POST',
        data: { rut: rut }
    })
}