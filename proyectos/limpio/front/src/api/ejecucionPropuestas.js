/*eslint-disable */

import request from "../services/request";

export function getFamiliasFromApi(convocatoria_id) {
    return request({
        url: `/api/ejecucion-propuestas/familias/${convocatoria_id}`,
        method: 'GET',
    })
}

export function getAsesoriasGrupalesFromApi(convocatoria_id) {
    return request({
        url: `/api/ejecucion-propuestas/asesorias-grupales/${convocatoria_id}`,
        method: 'GET',
    })
}

export function getByBeneficiarioFromApi(beneficiario_id) {
    return request({
        url: `/api/ejecucion-propuestas/beneficiario/${beneficiario_id}`,
        method: 'GET',
    })
}

export function saveAseFamComentarioFromApi(data) {
    return request({
        url: `/api/ejecucion-propuestas/asesorias-familiares/comentarios`,
        method: 'POST',
        data: data
    })
}

export function getAseFamComentariosFromApi(propuesta_asesoria_id) {
    return request({
        url: `/api/ejecucion-propuestas/asesorias-familiares/comentarios/${propuesta_asesoria_id}`,
        method: 'GET',
    })
}

export function saveAseFamGrupComentarioFromApi(data) {
    return request({
        url: `/api/ejecucion-propuestas/asesorias-grupales/comentarios`,
        method: 'POST',
        data: data
    })
}

export function getAseFamGrupComentariosFromApi(propuesta_asesoria_id) {
    return request({
        url: `/api/ejecucion-propuestas/asesorias-grupales/comentarios/${propuesta_asesoria_id}`,
        method: 'GET',
    })
}

export function saveSolFamComentarioFromApi(data) {
    return request({
        url: `/api/ejecucion-propuestas/soluciones-familiares/comentarios`,
        method: 'POST',
        data: data
    })
}

export function saveEstadoSol(pro_sol_id, estado_id) {
    return request({
        url: `/api/ejecucion-propuestas/soluciones-familiares/estado`,
        method: 'POST',
        data: {
            pro_sol_id: pro_sol_id,
            estado_id: estado_id
        }
    })
}

export function saveEstadoAse(pro_sol_id, estado_id) {
    return request({
        url: `/api/ejecucion-propuestas/asesorias-familiares/estado`,
        method: 'POST',
        data: {
            pro_sol_id: pro_sol_id,
            estado_id: estado_id
        }
    })
}

export function getSolFamComentariosFromApi(solucion_id) {
    return request({
        url: `/api/ejecucion-propuestas/soluciones-familiares/comentarios/${solucion_id}`,
        method: 'GET',
    })
}

export function getEstadoOptionsFromApi() {
    return request({
        url: `/api/ejecucion-propuestas/estado-options`,
        method: 'GET',
    })
}

export function Photo(id, file, pca) {
    let formData = new FormData();
    formData.append('file', file);
    formData.append('id', id);
    formData.append('disk', pca.disk);
    formData.append('filename', pca.filename);
    formData.append('mime_type', pca.mime_type);
    formData.append('original_name', pca.original_name);
    formData.append('size', pca.size);
    return request({
        url: '/api/ejecucion-propuestas/Photo',
        headers: { 'Content-Type': 'multipart/form-data' },
        method: 'POST',
        data: formData
    })
}

export function _download(id) {
    return request({
        url: 'api/ejecucion-propuestas/download/' + id,
        method: 'GET',
        responseType: 'blob',
    });
}

export function _download_image(id, category) {
    return request({
        url: 'api/ejecucion-propuestas/download/' + category + '/' + id,
        method: 'GET',
        responseType: 'blob',
    });
}

export function downloadEjecucionPropuestaPhotoFromApi(id, catogory) {
    return request({
        url: '/api/ejecucion-propuestas/photo-' + catogory + '/' + id + '/download',
        method: 'GET',
        responseType: 'blob',
    });
}


export function _mostrar_photos(Id) {
    return request({
        url: 'api/ejecucion-propuestas/mostrar_photos/' + Id,
        method: 'GET',
        responseType: 'blob',
    });
}

export function uploadSolPhotoFromApi(file, data) {
    let formData = new FormData();
    formData.append('file', file);
    formData.append('pro_sol_id', data.pro_sol_id);
    formData.append('disk', data.disk);
    formData.append('filename', data.filename);
    formData.append('mime_type', data.mime_type);
    formData.append('original_name', data.original_name);
    formData.append('size', data.size);
    return request({
        url: '/api/ejecucion-propuestas/photo-soluciones',
        headers: { 'Content-Type': 'multipart/form-data' },
        method: 'POST',
        data: formData
    })
}
/*eslint-disable */