import request from '../services/request'

export function getDataFromApi(convocatoria_id) {
    return request({
        url: `/api/resumen-propuesta-comunal/${convocatoria_id}`,
        method: 'GET',
    })
}

export function visarDiagnosticosFromApi(convocatoria_id) {
    return request({
        url: `/api/resumen-propuesta-comunal/visar-diagnosticos`,
        method: 'POST',
        data: { convocatoria_id: convocatoria_id }
    })
}

export function visarSolucionesFromApi(convocatoria_id) {
    return request({
        url: `/api/resumen-propuesta-comunal/visar-soluciones`,
        method: 'POST',
        data: { convocatoria_id: convocatoria_id }
    })
}

export function visarAsesoriasFromApi(convocatoria_id) {
    return request({
        url: `/api/resumen-propuesta-comunal/visar-asesorias`,
        method: 'POST',
        data: { convocatoria_id: convocatoria_id }
    })
}

export function aprobarPicFromApi(convocatoria_id) {
    return request({
        url: `/api/resumen-propuesta-comunal/aprobar-pic`,
        method: 'POST',
        data: { convocatoria_id: convocatoria_id }
    })
}

export function downloadCertificadoAprobacionPicFromApi(convocatoria_id) {
    return request({
        url: '/api/resumen-propuesta-comunal/certificado-pic',
        method: 'POST',
        data: { convocatoria_id: convocatoria_id },
        responseType: 'blob',
    });
}
