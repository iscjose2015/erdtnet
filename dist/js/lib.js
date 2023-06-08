/*    AJAX    */
// Para manejar los errores del Ajax
function markErr(jqXHR, textStatus) {
    if (jqXHR.status === 0) {
        Swal.fire({
            icon: 'error',
            text: 'No es posible conectarse',
            footer: 'Por favor verifique su conexión',
            position: 'top',
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true,
            allowOutsideClick: false
        });
    } else if (jqXHR.status == 404) {
        Swal.fire({
            icon: 'error',
            text: 'Página no encontrada [404]',
            footer: 'Si el problema persiste, por favor contacte al soporte',
            position: 'top',
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true,
            allowOutsideClick: false
        });
    } else if (jqXHR.status == 500) {
        Swal.fire({
            icon: 'error',
            text: 'Error Interno [500]',
            footer: 'Por favor contacte al soporte',
            position: 'top',
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true,
            allowOutsideClick: false
        });
    } else if (textStatus === 'parsererror') {
        Swal.fire({
            icon: 'error',
            text: 'Problema Interno [Request JSON fail]',
            footer: 'Por favor contacte al soporte',
            position: 'top',
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true,
            allowOutsideClick: false
        });
    } else if (textStatus === 'timeout') {
        Swal.fire({
            icon: 'error',
            text: 'Tiempo de respuesta excedido',
            footer: 'Reintente y si el problema persiste, por favor contacte al soporte',
            position: 'top',
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true,
            allowOutsideClick: false
        });
    } else if (textStatus === 'abort') {
        Swal.fire({
            icon: 'error',
            text: 'Problema en el envío',
            footer: 'Por favor contacte al soporte y notifique [ajax request aborted]',
            position: 'top',
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true,
            allowOutsideClick: false
        });
    } else {
        Swal.fire({
            icon: 'error',
            text: 'Sucedió un error inesperado: ' + jqXHR.responseText,
            footer: 'Por favor contacte al soporte',
            position: 'top',
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true,
            allowOutsideClick: false
        });
    }
}


/*    STRINGS    */
// Para saber si un string está vacío
function isAnEmptyString(string) {
    var key = false;
    if (string.trim().length > 0) return key;
    else key = true;

    return key;
}
function capitalize_all(string) {
    let newString = '';

    let split = string.split(' ');
    if (split.length > 1) {
        for (element in split) {
            let word = split[element].toLowerCase();
            newString += word.charAt(0).toUpperCase() + word.slice(1) + ' ';
        }
    } else {
        let word = split[0].toLowerCase();
        newString += word.charAt(0).toUpperCase() + word.slice(1);
    }

    return newString;
}
function capitalize(string) {
    let minus = string.toLowerCase();
    return minus.charAt(0).toUpperCase() + minus.slice(1);
}
function moneyFormat(cant) {
    let dolarSign = '$';
    let cantFmt = new Intl.NumberFormat('en-US').format(cant);
    if (cantFmt == 'NaN') {
        return cant;
    }

    return dolarSign + cantFmt;
}



/*    NUMEROS   */
function getRandomInt(max) {
    return Math.floor(Math.random() * max);
}
function getPercentage(cant, total) {
    let proporcional_percentage = (parseInt(cant) * 100);
    let total_percentage = proporcional_percentage / parseInt(total);

    return Math.round(total_percentage);
}


/*    FECHAS    */
function getActualDay() {
    let today = new Date();
    return today.getDate();
}
function getActualMonth() {
    let today = new Date();
    return today.getMonth() + 1; // Se suma uno, porque Enero es la posición 0
}
function getActualYear() {
    let today = new Date();
    return today.getFullYear();
}

function getDay(date) {
    let today = new Date(date);
    return today.getDate();
}
function getMonth(date) {
    let today = new Date(date);
    return today.getMonth() + 1;
}
function getYear(date) {
    let today = new Date(date);
    return today.getFullYear();
}

function monthDayFormat(month_or_day) {
    let format = '0';
    if (month_or_day.toString().length == 1) {
        return format + month_or_day;
    }

    return month_or_day;
}


/*    ACCESS    */
// Para mostrar un popup de acceso restringido
function modal_denied() {
    Swal.fire({
        html: '<img src="dist/img/warning.png" alt="Alerta!" title="Advertencia"><h3><strong>Denegado</strong></h3><hr><p>Usted no tiene los permisos necesarios para realizar esta acción.</p>',
        showConfirmButton: false,
        showCloseButton: true,
        allowOutsideClick: false,
        position: 'top'
    });
}