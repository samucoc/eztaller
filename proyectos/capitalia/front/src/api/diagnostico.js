import request from '../services/request'


export function visarDiagnosticoFamilia(familiaId, visar) {
    return request({
        url: `/api/diagnostico/visar/familia/${familiaId}/${visar}`,
        method: 'GET'
    })
}

export function formulario(familiaId) {
    return request({
        url: '/api/diagnostico/formulario/' + familiaId,
        method: 'GET'
    })
}

export function save(familiaId, values, respuestas) {
    return request({
        url: '/api/diagnostico/save/' + familiaId,
        method: 'POST',
        data: { values, respuestas }
    });
}

export function Plano(familiaId, file, compId) {
    let formData = new FormData();
    formData.append('file', file);
    return request({
        url: `/api/diagnostico/${familiaId}/${compId}/Plano_Ubi`,
        headers: { 'Content-Type': 'multipart/form-data' },
        method: 'POST',
        data: formData
    })
}

export function Plano_viv(familiaId, file, compId) {
    let formData = new FormData();
    formData.append('file', file);
    return request({
        url: `/api/diagnostico/${familiaId}/${compId}/Plano_Viv`,
        headers: { 'Content-Type': 'multipart/form-data' },
        method: 'POST',
        data: formData
    })
}

export function Photo(familiaId, file, compId) {
    let formData = new FormData();
    formData.append('file', file);
    return request({
        url: `/api/diagnostico/${familiaId}/${compId}/Photo`,
        headers: { 'Content-Type': 'multipart/form-data' },
        method: 'POST',
        data: formData
    })
}

export function _download(id) {
    return request({
        url: 'api/diagnostico/download/' + id,
        method: 'GET',
        responseType: 'blob',
    });
}

export function _download_plano_viv(Id) {
    return request({
        url: 'api/diagnostico/download_plano_viv/' + Id,
        method: 'GET',
        responseType: 'blob',
    });
}

export function _download_photos(Id) {
    return request({
        url: 'api/diagnostico/download_photos/' + Id,
        method: 'GET',
        responseType: 'blob',
    });
}

export function _mostrar_photos(Id) {
    return request({
        url: 'api/diagnostico/mostrar_photos/' + Id,
        method: 'GET',
        responseType: 'blob',
    });
}

export function _download_image(id, category) {
    return request({
        url: 'api/diagnostico/download/' + category + '/' + id,
        method: 'GET',
        responseType: 'blob',
    });
}


export function showImage(id) {

}

export function saveGrupoFamiliarFromApi(editedItem, familiaId, compId) {
    return request({
        url: '/api/diagnostico/grupo-familiar/' + familiaId + '/' + compId,
        method: 'POST',
        data: { editedItem }
    });
}

export function deleteGrupoFamiliarFromApi(data) {
    return request({
        url: '/api/diagnostico/grupo-familiar',
        method: 'DELETE',
        data: data
    });
}


export function add_tableGF(familiaId, compId, addItem) {
    return request({
        url: '/api/diagnostico/add_tableGF/' + familiaId + '/' + compId,
        method: 'POST',
        data: { addItem }
    });
}

export function delete_tableGF(familiaId, item) {
    return request({
        url: '/api/diagnostico/delete_tableGF/' + familiaId,
        method: 'POST',
        data: { item }
    });
}
export function validar_diag(familiaId) {
    return request({
        url: '/api/diagnostico/validar_diag/' + familiaId,
        method: 'POST',
    });
}

export function getGrupoFamiliarFromApi(familiaId) {
    return request({
        url: '/api/diagnostico/formulario/grupo-familiar/' + familiaId,
        method: 'GET',
    });
}
