import moment from "moment";


export function getFilename(response, filename_def) {
    let name = 'file';
    if (response.data.type.search('pdf') > -1) {
        name = name + '.pdf';
    } else if (response.data.type.search('spreadsheet') > -1) {
        name = name + '.xlsx';
    }
    let filename = (typeof filename_def !== 'undefined') ? filename_def : name;

    let disposition = response.request.getResponseHeader('Content-Disposition');
    if (disposition && disposition.indexOf('filename=') !== -1) {
        let filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
        let matches = filenameRegex.exec(disposition);
        if (matches != null && matches[1]) {
            filename = matches[1].replace(/['"]/g, '');
        }
    }
    return filename;
}

export function getFamiliasHeaders() {
    return [
        {
            text: 'No.',
            align: 'left',
            value: 'numero',
        },
        {
            text: '',
            value: 'bit_estado_actual_id'
        },
        {
            text: 'Estado',
            align: 'left',
            value: 'estado_actual',
        },
        {
            text: 'RUN representante',
            align: 'left',
            value: 'rut_benef',
        },
        {
            text: 'Nombre representante',
            align: 'left',
            value: 'nom_benef',
        },
        {
            text: 'Dirección',
            align: 'left',
            value: 'direccion',
        },
        {
            text: 'Programa origen',
            align: 'left',
            value: 'nom_programa',
        },
        {
            text: 'Teléfono',
            align: 'left',
            value: 'telefono',
        },
        {
            text: 'Activo',
            align: 'left',
            value: 'activo',
        },
        {
            text: 'Nombre apoyo familiar',
            align: 'left',
            value: 'nom_apo_fam',
        },
        {
            text: 'Correo apoyo familiar',
            align: 'left',
            value: 'email_apo_fam',
        }
    ];
}

export function getProgramasHeader() {
    return [
        {
            text: 'Año de Convocatoria',
            align: 'left',
            value: 'anio_convocatoria',
        },
        {
            text: 'Programa',
            align: 'left',
            value: 'nom_programa',
        },
        {
            text: 'Estado',
            align: 'left',
            value: 'estado',
        },
        {
            text: 'Activo',
            align: 'left',
            value: 'activo',
        }
    ];
}


export function getParticipacionesHeader() {
    return [
        {
            text: 'Año de Convocatoria',
            align: 'left',
            value: 'anio_convocatoria',
        },
        {
            text: 'Región',
            align: 'left',
            value: 'nombre_region',
        },
        {
            text: 'Comuna',
            align: 'left',
            value: 'nombre_comuna',
        },
        {
            text: 'Programa SSyOO registrado en Habitabilidad',
            align: 'left',
            value: 'programa',
        },
    ];
}

export function getAniosList() {
    let anios = [{
        text: "Todos",
        value: null
    }];

    for (let i = 2018; parseInt(moment().format('YYYY')) >= i; i++) {
        anios.push({
            text: i,
            value: i
        });
    }
    return anios;
}

export function empty(value) {
    if (typeof value !== 'string') {
        return true;
    }
    return value.trim().length === 0;
}

export function splitComunas(comunas) {
    return comunas.map(comuna => comuna['nom_com']).join(' / ');
}



export function arraySearch(needle, haystack, argStrict) {
    // eslint-disable-line camelcase
    //  discuss at: https://locutus.io/php/array_search/
    // original by: Kevin van Zonneveld (https://kvz.io)
    //    input by: Brett Zamir (https://brett-zamir.me)
    // bugfixed by: Kevin van Zonneveld (https://kvz.io)
    // bugfixed by: Reynier de la Rosa (https://scriptinside.blogspot.com.es/)
    //        test: skip-all
    //   example 1: array_search('zonneveld', {firstname: 'kevin', middle: 'van', surname: 'zonneveld'})
    //   returns 1: 'surname'
    //   example 2: array_search('3', {a: 3, b: 5, c: 7})
    //   returns 2: 'a'

    var strict = !!argStrict
    var key = ''

    if (typeof needle === 'object' && needle.exec) {
        // Duck-type for RegExp
        if (!strict) {
            // Let's consider case sensitive searches as strict
            var flags = 'i' + (needle.global ? 'g' : '') +
                (needle.multiline ? 'm' : '') +
                // sticky is FF only
                (needle.sticky ? 'y' : '')
            needle = new RegExp(needle.source, flags)
        }
        for (key in haystack) {
            if (haystack.hasOwnProperty(key)) {
                if (needle.test(haystack[key])) {
                    return key
                }
            }
        }
        return false
    }

    for (key in haystack) {
        if (haystack.hasOwnProperty(key)) {
            if ((strict && haystack[key] === needle) || (!strict && haystack[key] == needle)) { // eslint-disable-line eqeqeq
                return key
            }
        }
    }

    return false
}

export function arrayColumn(input, ColumnKey, IndexKey = null) { // eslint-disable-line camelcase
    //   discuss at: https://locutus.io/php/array_column/
    //   original by: Enzo Dañobeytía
    //   example 1: array_column([{name: 'Alex', value: 1}, {name: 'Elvis', value: 2}, {name: 'Michael', value: 3}], 'name')
    //   returns 1: {0: "Alex", 1: "Elvis", 2: "Michael"}
    //   example 2: array_column({0: {name: 'Alex', value: 1}, 1: {name: 'Elvis', value: 2}, 2: {name: 'Michael', value: 3}}, 'name')
    //   returns 2: {0: "Alex", 1: "Elvis", 2: "Michael"}
    //   example 3: array_column([{name: 'Alex', value: 1}, {name: 'Elvis', value: 2}, {name: 'Michael', value: 3}], 'name', 'value')
    //   returns 3: {1: "Alex", 2: "Elvis", 3: "Michael"}
    //   example 4: array_column([{name: 'Alex', value: 1}, {name: 'Elvis', value: 2}, {name: 'Michael', value: 3}], null, 'value')
    //   returns 4: {1: {name: 'Alex', value: 1}, 2: {name: 'Elvis', value: 2}, 3: {name: 'Michael', value: 3}}

    if (input !== null && (typeof input === 'object' || Array.isArray(input))) {
        var newarray = []
        if (typeof input === 'object') {
            let temparray = []
            for (let key of Object.keys(input)) {
                temparray.push(input[key])
            }
            input = temparray
        }
        if (Array.isArray(input)) {
            for (let key of input.keys()) {
                if (IndexKey && input[key][IndexKey]) {
                    if (ColumnKey) {
                        newarray[input[key][IndexKey]] = input[key][ColumnKey]
                    } else {
                        newarray[input[key][IndexKey]] = input[key]
                    }
                } else {
                    if (ColumnKey) {
                        newarray.push(input[key][ColumnKey])
                    } else {
                        newarray.push(input[key])
                    }
                }
            }
        }
        return Object.assign({}, newarray)
    }
}

export function inArray(needle, haystack) {
    for (var i in haystack) {
        if (haystack[i] == needle) return true;
    }
    return false;
}

export function moneyFormat(number) {
    return (new Intl.NumberFormat("de-DE").format(number));
}

export function encodeUTF8(str) {
    return unescape(encodeURIComponent(str));
}

export function decodeUTF8(str) {
    return decodeURIComponent(escape(str));
}

export function date2fecha(date) {
    if (!date) return null;
    const [year, month, day] = date.split("-");
    return `${day}/${month}/${year}`;
}


