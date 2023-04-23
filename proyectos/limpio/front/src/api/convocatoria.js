import request from "../services/request";

export function search(criterios) {
    return request({
        url: `/api/convocatoria/searchConvocatoria`,
        method: 'POST',
        data: criterios
    })
}

export function create(data) {
    return request({
        url: `/api/convocatoria`,
        method: 'POST',
        data: data
    })
}

export function update(data, id) {
    return request({
        url: `/api/convocatoria/${id}`,
        method: 'PUT',
        data: data
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

export function visarResumenPicFromApi(convocatoria_id) {
    return request({
        url: `/api/convocatoria/${convocatoria_id}/resumen_pic/visar`,
        method: 'POST'
    })
}

export function aprobarResumenPicFromApi(convocatoria_id) {
    return request({
        url: `/api/convocatoria/${convocatoria_id}/resumen_pic/aprobar`,
        method: 'POST'
    })
}

export function visarResumenModPicFromApi(convocatoria_id) {
    return request({
        url: `/api/convocatoria/${convocatoria_id}/resumen_mod_pic/visar`,
        method: 'POST'
    })
}

export function aprobarResumenModPicFromApi(convocatoria_id) {
    return request({
        url: `/api/convocatoria/${convocatoria_id}/resumen_mod_pic/aprobar`,
        method: 'POST'
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

export function uploadActaMesaTecnicaPicFromApi(convocatoria_id, file) {
    let formData = new FormData();
    formData.append('convocatoria_id', convocatoria_id);
    formData.append('file', file);
    return request({
        url: `/api/convocatoria/${convocatoria_id}/acta_mesa_tecnica_pic`,
        headers: { 'Content-Type': 'multipart/form-data' },
        method: 'POST',
        data: formData
    })
}

export function downloadActaMesaTecnicaPicFromApi(archivo_id) {
    return request({
        url: 'api/convocatoria/download/' + archivo_id,
        method: 'GET',
        responseType: 'blob',
    });
}

export function uploadActaMesaTecnicaModPicFromApi(convocatoria_id, file) {
    let formData = new FormData();
    formData.append('convocatoria_id', convocatoria_id);
    formData.append('file', file);
    return request({
        url: `/api/convocatoria/${convocatoria_id}/acta_mesa_tecnica_mod_pic`,
        headers: { 'Content-Type': 'multipart/form-data' },
        method: 'POST',
        data: formData
    })
}

export function downloadActaMesaTecnicaModPicFromApi(archivo_id) {
    return request({
        url: 'api/convocatoria/download/' + archivo_id,
        method: 'GET',
        responseType: 'blob',
    });
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

export function getBitacoraFromApi(convocatoria_id) {
    return request({
        url: `/api/convocatoria/${convocatoria_id}/bitacora`,
        method: 'GET',
    })
}

export function buscarFromApi(criterios) {
    return request({
        url: `/api/convocatoria/buscar`,
        method: 'POST',
        data: criterios
    })
}

export function getUsuariosByConvocatoriaFromApi(convocatoria_id) {
    return request({
        url: `/api/convocatoria/usuarios`,
        method: 'POST',
        data: { convocatoria_id: convocatoria_id }
    })
}

export function getConvocatoriaSeleccionada() {
    // return JSON.parse(atob(localStorage.getItem('convocatoria_seleccionada')));
    return JSON.parse(localStorage.getItem('convocatoria_seleccionada'));
}

export function setConvocatoriaSeleccionada(convocatoria) {
    // localStorage.setItem('convocatoria_seleccionada', btoa(JSON.stringify(convocatoria)));
    localStorage.setItem('convocatoria_seleccionada', JSON.stringify(convocatoria));
}

export function hasConvocatoriaSeleccionada() {
    return !(localStorage.getItem('convocatoria_seleccionada') == null);
}

export function updateConvocatoriaSeleccionada(convocatorias, convocatoria) {
    for (const [i, item] of convocatorias.entries()) {
        if (item.id === convocatoria.id) {
            convocatorias[i] = convocatoria;
        }
    }
    return convocatorias;
}

export function destroyConvocatoriaSeleccionada() {
    setConvocatoriaSeleccionada(emptyConvocatoria());
}


export function hasConvocatoriaFiltro() {
    return !(localStorage.getItem('convocatoria_filtro') === null);
}

export function setConvocatoriaFiltro(filtro) {
    localStorage.setItem('convocatoria_filtro', JSON.stringify(filtro));
}

export function getConvocatoriaFiltro() {
    return JSON.parse(localStorage.getItem('convocatoria_filtro'));
}


export function setConvocatoriaFiltroBuscar(buscar) {
    localStorage.setItem('convocatoria_filtro_buscar', JSON.stringify(buscar));
}

export function emptyConvocatoria() {
    return {
        id: null,
        anio: null,
        comunas: [],
        comunas_id: [],
        comunas_nombre: [],
        direccion_ejecutor: null,
        ejecutor: null,
        bit_estado_actual: 1,
        email_ate_fosis: null,
        email_ejec_const: null,
        email_ejec_social: null,
        email_enc_ejec: null,
        email_enc_prog_seremi: null,
        estado: {
            id: 1,
            estado: "Ingresada",
        },
        observacion: null,
        fono_ejecutor: null,
        nombre_ate_fosis: null,
        nombre_ejec_const: null,
        nombre_ejec_social: null,
        nombre_enc_ejec: null,
        nombre_enc_prog_seremi: null,
        profesion_ejec_const: null,
        profesion_ejec_social: null,
        region: {
            id: null,
        },
        rut_ate_fosis: null,
        rut_ejec_const: null,
        rut_ejec_social: null,
        rut_ejecutor: null,
        rut_enc_ejec: null,
        rut_enc_prog_seremi: null,
        fecha_transferencia: null,
        fecha_termino: null,
        estado_sigec: null,
        familias_estimadas: null,
    };
}

export function emptyConvocatoriaFiltro() {
    return {
        anio: null,
        buscar: "",
    };
}