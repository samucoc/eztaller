import request from '../services/request'

export function getBeneficiariosFromApi(convocatoria_id) {
    return request({
        url: `/api/propuesta-familia/${convocatoria_id}/beneficiarios`,
        method: 'GET',
    })
}

export function getAsesoriasGrupalesFromApi(convocatoria_id) {
    return request({
        url: `/api/propuesta-familia/${convocatoria_id}/asesorias-grupales`,
        method: 'GET',
    })
}

export function getAsesoriasGrupalesOptionsFromApi(convocatoria_id) {
    return request({
        url: `/api/propuesta-familia/${convocatoria_id}/asesorias-grupales-options`,
        method: 'GET',
    })
}



export function habilitarBeneficiarioFromApi(convocatoria_id, beneficiario_id) {
    return request({
        url: `/api/propuesta-familia/${convocatoria_id}/habilitar-beneficiario`,
        method: 'POST',
        data: { beneficiario_id: beneficiario_id }
    })
}

export function getMotivosParaDesestimarFromApi(bit_estado_id) {
    return request({
        url: `/api/propuesta-familia/motivos-desestimar/${bit_estado_id}`,
        method: 'GET',
    })
}

export function desestimarBeneficiarioFromApi(convocatoria_id, beneficiario_id, motivo) {
    return request({
        url: `/api/propuesta-familia/${convocatoria_id}/desestimar-beneficiario`,
        method: 'POST',
        data: {
            beneficiario_id: beneficiario_id,
            motivo: motivo
        }
    })
}

export function guardarVisitaFromApi(data) {
    return request({
        url: `/api/propuesta-familia/guardar-visita`,
        method: 'POST',
        data: data
    })
}

export function getMotivosNoVisitaFromApi() {
    return request({
        url: `/api/propuesta-familia/motivos-no-visita`,
        method: 'GET',
    })
}

export function getVisitasFromApi(beneficiario_id) {
    return request({
        url: `/api/propuesta-familia/visitas-beneficiario`,
        method: 'POST',
        data: { beneficiario_id: beneficiario_id }
    })
}

export function setVisadoByConvocatoria(convocatoria_id) {
    return request({
        url: `/api/propuesta-familia/${convocatoria_id}/visado-familias`,
        method: 'POST',
        data: { convocatoria_id: convocatoria_id }
    })
}