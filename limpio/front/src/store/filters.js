export function formatRut(value) {
    if (!value) {
        return '';
    }
    let newValue = value.replace(/![0-9kK]/, '');
    if (newValue.length < 9) {
        return value;
    }
}