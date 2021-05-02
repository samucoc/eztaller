import request from "../services/request";

export function search(criterios) {
    return request({
        url: '/api/ProcesoAdquisicion/searchProcesoAdquisicion',
        method: 'POST',
        data: criterios
    })
}

export function all(convocatoriaId) {
    return request({
        url: '/api/ProcesoAdquisicion',
        method: 'GET',
        params: {convocatoriaId}
    })
}

export function createPA(ProcesoAdquisicion) {
    return request({
        url: '/api/ProcesoAdquisicion/agregar',
        method: 'POST',
        data: {
                convocatoria_id : ProcesoAdquisicion.convocatoria_id,
                disk : ProcesoAdquisicion.disk,
                filename : ProcesoAdquisicion.filename,
                mime_type : ProcesoAdquisicion.mime_type,
                original_name : ProcesoAdquisicion.original_name,
                size : ProcesoAdquisicion.size, tipo : ProcesoAdquisicion.tipo,
                comentarios : ProcesoAdquisicion.comentarios,
                fecha : ProcesoAdquisicion.fecha,
                numero : ProcesoAdquisicion.numero
                }
    })
}

export function update(ProcesoAdquisicion, id) {
    return request({
        url: '/api/ProcesoAdquisicion/actualizar/${id}',
        method: 'PUT',
        data: ProcesoAdquisicion
    })
}

export function removePA(id) {
    return request({
        url: '/api/ProcesoAdquisicion/eliminar',
        method: 'POST',
        data: { id : id }
    })
}

export function archivoPCA(id, file, pca) {
    let formData = new FormData();
    formData.append('file', file);
    formData.append('id', id);
    formData.append('disk', pca.disk);
    formData.append('filename', pca.filename);
    formData.append('mime_type', pca.mime_type);
    formData.append('original_name', pca.original_name);
    formData.append('size', pca.size);
    return request({
        url: '/api/ProcesoAdquisicion/archivoPCA',
        headers: { 'Content-Type': 'multipart/form-data' },
        method: 'POST',
        data: formData 
    })
}
