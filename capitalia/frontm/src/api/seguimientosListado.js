import request from "../services/request";

export function seguimientosListado (convocatoriaId) {
    return request({
        url: `/api/seguimientos/listado/convocatoria/${convocatoriaId}`,
        method: 'GET',
    })
}