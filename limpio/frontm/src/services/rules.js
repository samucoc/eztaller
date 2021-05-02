export function checkRut(rut) {
    if (typeof rut !== "string") {
        return false;
    }
    rut = rut.replace('.', '');
    rut = rut.replace('-', '');
    let numero = rut.slice(0, -1);
    let dv = rut.slice(-1).toUpperCase();
    if (numero.length < 7) {
        return false;
    }
    let i = 2;
    let suma = 0;
    for (let v of numero.split('').reverse()) {
        if (i === 8)
            i = 2;
        suma += v * i;
        ++i;
    }
    let dvr = 11 - (suma % 11);
    if (dvr === 11)
        dvr = 0;
    if (dvr === 10)
        dvr = 'K';
    return dvr + "" === dv.toUpperCase();
}

export const required = v => !!v || 'Campo requerido';
export const required_one = v => v.length !== 0 || 'Campo requerido';
export const email = v => /.+@.+\..+/.test(v) || 'E-mail no válido';
export const rut = v => checkRut(v) || 'Rut invalido';
export const min = v => v >= 0 || 'Campo Debe ser mayor a 0';
export const Coord_req = v => !!v || 'Campo requerido';
export const Coord_req_num = v => /^([0-9,\.]+)$/.test(v) || 'Campo Es Numerico';
export const alphanumeric = v => /^[^-\s][a-zA-Z0-9_\s-]+$/.test(v) || 'Campo acepta solo letras y números';
export const alpha = v => /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s-]+$/.test(v) || 'Campo acepta solo letras';
