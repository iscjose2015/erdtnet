// TRAFICO Y LOGISTICA
function modal_edit(id, type_name){
    // Aquí se toman el nombre de los id de todos los campos del formulario para usarlos después en otro ciclo
    let id_name_fields = [];
    let modal_inputs = document.getElementsByClassName('form-group row');
    for(inp in modal_inputs){
        let inputs = modal_inputs[inp].children;
        for(element in inputs){
            let input = inputs[element];
            if(input.className == 'col-sm-9'){ // Esto es para los divs que contienen inputs con esta clase
                let isAnInputField = input.querySelector('input');
                let isASelectField = input.querySelector('select');
                if(isAnInputField != null){
                    id_name_fields.push(isAnInputField.id);
                }else if(isASelectField != null){
                    id_name_fields.push(isASelectField.id);
                }else{ console.log(input); }
            }
        }
    }
    
    $.ajax({
        url: 'boost_query.php',
        data: {
            name: type_name,
            id: id
        },
        type: 'POST',
        success: (response) => {
            console.log(response);
            if(response.includes('errors')){
                Swal.fire({
                    icon: 'error',
                    text: 'Algo salió mal',
                    position: 'top',
                    timer: 2500,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    allowOutsideClick: false
                });
            }else{
                let data = JSON.parse(response);
                
                $('#modal-xl').modal('show');

                document.getElementById('modal-title').innerHTML = 'Editar Datos';

                for(let i=0 ;i<id_name_fields.length; i++){
                    document.getElementById(id_name_fields[i]).value = data[i];
                }

                document.getElementById('hiddenField').value = 3;
                //document.getElementById('newtxtid').value = id;

                //let saveBtn = document.getElementById('btnguarda');
                //saveBtn.disabled = false;
            }
        },
        error: (jqXHR, textStatus) => {
            markErr(jqXHR, textStatus);
        }
    });
    
}

function reset_modal(){
    let clear  ='';
    document.getElementById('modal-title').innerHTML = 'Nuevo Registro';

    let modal_inputs = document.getElementsByClassName('form-group row');
    for(inp in modal_inputs){ // Se itera por los form-group para tomar el valor de los inputs
        let inputs = modal_inputs[inp].children;
        for(element in inputs){
            let input = inputs[element];
            if(input.className == 'col-sm-9'){
                let isAnInputField = input.querySelector('input');
                let isASelectField = input.querySelector('select');
                
                // Para vaciar el valor del campo, cuando este es uno de los campos buscados
                if(isAnInputField != null){ 
                    isAnInputField.value = clear; 
                }else if(isASelectField != null){
                    isASelectField.value = clear;
                }else{ console.log(input); } // En caso contrario, mostrar qué es el campo
            }
        }
    }
    document.getElementById('hiddenField').value = 1;

    //let saveBtn = document.getElementById('btnguarda');
    //saveBtn.disabled = true;

    $('#modal-xl').modal('hide');
}

function modal_delete(id, factura, include_fact=false){
    $('#modal-borrar').modal('show');

    document.getElementById('borrar_codigo').innerHTML = 'Codigo: '+id;
    document.getElementById('borrar_desc').innerHTML = 'Descripcion: '+factura;

    /*if(include_fact){
        document.getElementById('txtfact').value = factura;
    }*/
    document.getElementById('txtfact').value = factura;
    document.getElementById('txtid').value = id;
}

//INICIA FUNCION PARA AGREGAR PRODUCTOS A LA FACTURA
function newDataFact(id, type_name, factura, w){

    var existencia = document.getElementById('existenciasdata-'+w+'').value;
    var precio = document.getElementById('preciodata-'+w+'').value;


    $.ajax({
        url: 'newProductFact.php',
        data: {
            name: type_name,
            id: id,
            cantidad: existencia,
            ttalprecio: precio,
            factura: factura
        },
        type: 'POST',
        success: (response) => {
            //console.log(response);
            if(response.includes('errors')){
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'Intente de nuevo!!!',
                    showConfirmButton: false,
                    timer: 1500
                  })

            } else {
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: 'Un registro Agregado!!!',
                    showConfirmButton: false,
                    timer: 1500
                  })

            }

        },
        error: (jqXHR, textStatus) => {
            markErr(jqXHR, textStatus);
        }
    });
    
}//TERMINA FUNCION PARA AGREGAR PRODUCTOS A LA FACTURA

function markErr(jqXHR, textStatus){
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
            text: 'Sucedió un error inesperado: '+jqXHR.responseText,
            footer: 'Por favor contacte al soporte',
            position: 'top',
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true,
            allowOutsideClick: false
        });
    }
}