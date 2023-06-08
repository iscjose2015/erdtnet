class Popup {
    constructor(general_parameters) { // Aqui se pone un JSON con todos los datos que se manejaran dentro de la clase
        this.params = general_parameters;
        this.popup_data = undefined; // Aquí se mete todo el contenido que se va a mostrar en el popup
        this.endFunction = undefined; // Este sirve para saber si hay una función que ejecutar (la función se pasa como parámetro)

        this.#create(); // Se manda crear el popup con los parametros que se pasan en el constructor (instancia a la clase)
    }

    show() { // Se manda mostrar el popup una vez tenga datos  (método público)
        if (this.endFunction !== undefined) { // Si hay algo, entonces...
            Swal.fire(this.popup_data).then(() => {
                setTimeout(this.endFunction); // Aquí simplemente se usa el setTimeout como una forma de ejecutar una función (sin tiempo de espera)
            });
        } else { // En caso contrario, sólo se muestra el mensaje...
            Swal.fire(this.popup_data);
        }
    }

    #create() { // Se manda crear el popup con los parametros que lo definen (método privado)
        let is_generic_popup = (this.params.generic !== undefined);
        let is_forms_popup = (this.params.forms !== undefined);
        let is_table_popup = (this.params.table !== undefined);

        if (is_generic_popup) { // Si el tipo de popup es generico
            let type = (this.params.generic.type);

            let edited_message = (this.params.generic.message); // El mensaje que se pasa en los parametros
            let final_function = (this.params.generic.response_function); // La función que se pasa en los parametros
            switch (type) {
                case 'success':
                    this.#setSuccessPopup(final_function, edited_message);
                    break;
                case 'info':
                    this.#setInfoPopup(final_function, edited_message);
                    break;
                case 'error':
                    this.#setErrorPopup(final_function, edited_message);
                    break;

            }
        } else if (is_forms_popup) {

        } else if (is_table_popup) {

        }
    }

    #setSuccessPopup(function_at_end, message) { // La función que se va a ejecutar cuando se cierre el popup  (método privado)
        if (function_at_end !== undefined) { // Si hay algo que ejecutar...   
            this.endFunction = function_at_end;
        }
        let final_text = 'Se completó la acción correctamente!';
        if (message !== undefined) { // Si pusieron un mensaje personalizado...
            final_text = message;
        }

        this.popup_data = {
            icon: 'success',
            text: final_text,
            showConfirmButton: false,
            showCloseButton: true,
            position: 'top',
            allowOutsideClick: false
        };
    }
    #setInfoPopup(function_at_end, message) { // La función que se va a ejecutar cuando se cierre el popup  (método privado)
        if (function_at_end !== undefined) { // Si hay algo que ejecutar...   
            this.endFunction = function_at_end;
        }
        let final_text = '';
        if (message !== undefined) { // Si pusieron un mensaje personalizado...
            final_text = message;
        }

        this.popup_data = {
            icon: 'info',
            text: final_text,
            showConfirmButton: false,
            showCloseButton: true,
            position: 'top',
            allowOutsideClick: false
        };
    }
    #setErrorPopup(function_at_end, message) { // La función que se va a ejecutar cuando se cierre el popup  (método privado)
        if (function_at_end !== undefined) { // Si hay algo que ejecutar...   
            this.endFunction = function_at_end;
        }
        let final_text = 'Algo salió mal!';
        if (message !== undefined) { // Si pusieron un mensaje personalizado...
            final_text = message;
        }

        this.popup_data = {
            icon: 'error',
            text: final_text,
            showConfirmButton: false,
            showCloseButton: true,
            position: 'top',
            allowOutsideClick: false
        };
    }
}

//let test = new Popup({generic: {type: 'success'}});
//test.create();