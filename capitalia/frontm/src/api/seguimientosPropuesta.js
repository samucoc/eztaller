import request from "../services/request";

export function seguimientosPropuesta (convocatoriaId) {
    return request({
        url: `/api/seguimientos/propuesta/convocatoria/${convocatoriaId}`,
        method: 'GET',
    })
}