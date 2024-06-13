function ingresar() {
    var user = document.getElementById("user").value;
    var pass = document.getElementById("contrasenia").value;



    if (user === "cmanriquez@inacap.cl" && pass === "Cristian22/11-22") {

        window.location.href = "index.html";
        document.getElementById("user").value = '';
        document.getElementById("contrasenia").value = '';

    }
    else if (user === "bretamales@inacap.cl" && pass === "Brayan22/11-22") {

        window.location.href = "index.html";
        document.getElementById("user").value = '';
        document.getElementById("contrasenia").value = '';
    }
    else if (user === "smorales@inacap.cl" && pass === "Seba22/11-22") {
        window.location.href = "index.html";
        document.getElementById("user").value = '';
        document.getElementById("contrasenia").value = '';
    }
    else {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Credenciales incorrectas. Por favor, inténtalo de nuevo.',
            confirmButtonText: 'Entendido'
        }).then(() => {
            document.getElementById("user").value = '';
            document.getElementById("contrasenia").value = '';
        });
    }
    var errorDisplayed = false;
    
    var inputUser = document.getElementById("user");
    inputUser.addEventListener("blur", function (a) {
        var user = a.target.value;
        var campo = a.target;
        var patron = new RegExp('^[a-zA-Z]+@[a-zA-Z]+\.[a-zA-Z]+$');
        // requerimiento que cumple con tener al menos 1 letra en minuscula y 1 en mayuscula 1 @ y almenos 1 "."
    
        var errorElement = campo.parentElement.querySelector('.alert.alert-primary'); //busca el elemnento alert de la clase css
        if (errorDisplayed) {
            // verifica si ya a mostrado el mensaje, si es asi no hace nada
            return;
        }
        if (errorElement) {
            errorElement.remove();
            // si el mensaje esta en pantalla lo borra
        }
    
        if (user.length == 0) {
            campo.parentElement.insertAdjacentHTML("beforeend", '<div class="alert alert-primary d-flex align-items-center" role="alert"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" bg="red" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg><div>El campo no puede estar vacio</div></div>')
        } 
        /*else if (!patron.test(user)) {
            campo.parentElement.insertAdjacentHTML("beforeend",
                '<div class="alert alert-primary d-flex align-items-center" role="alert">' +
                '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">' +
                '<path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>' +
                '</svg>' +
                '<div>El correo debe cumplir con:</div>' +
                '<ul>' +
                '<li> Debe tener un y solo un signo arroba.</li>' +
                '<li>Mínimo 3 caracteres antes del signo arroba.</li>' +
                '<li>Debe tener un y solo un punto después del signo arroba</li>' +
                '<li>Mínimo 3 caracteres antes del punto que está después del signo arroba.</li>' +
                '<li>Máximo 3 caracteres después del punto que esta después del signo arroba.</li>' +
                '</ul>' +
                '</div>'
            );*/
    
        else if (user.split('@').length !== 2){
            campo.parentElement.insertAdjacentHTML("beforeend", '<div class="alert alert-primary d-flex align-items-center" role="alert"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" bg="red" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg><div>Debe tener un y solo un signo arroba</div></div>')
            //validacion para que no hayan mas de 2 @
        }
        else if (user.split('@')[1].split('.').length !== 2){
            campo.parentElement.insertAdjacentHTML("beforeend", '<div class="alert alert-primary d-flex align-items-center" role="alert"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" bg="red" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg><div>Debe tener un y solo un punto después del signo arroba</div></div>')
            //validacion para que despues del @ no hayan mas de 2 puntos
        }
        else if (user.split('@')[1].split('.')[0].length < 3){
            campo.parentElement.insertAdjacentHTML("beforeend", '<div class="alert alert-primary d-flex align-items-center" role="alert"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" bg="red" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg><div>Debe haber al menos 3 caracteres antes del punto que está después del "@"</div></div>')
            //validacion para que despues del @ y antes del punto haya al menos 3 caracteres
        }
        else if (user.split('@')[0].length < 3){
            campo.parentElement.insertAdjacentHTML("beforeend", '<div class="alert alert-primary d-flex align-items-center" role="alert"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" bg="red" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg><div>Debe haber al menos 3 caracteres antes del "@"</div></div>')
            //validacion para que antes del @ haya al menos 3 caracteres
        }
        
        else if (user.split('@')[1].split('.')[1].length < 2 || user.split('@')[1].split('.')[1].length > 3){
            campo.parentElement.insertAdjacentHTML("beforeend", '<div class="alert alert-primary d-flex align-items-center" role="alert"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" bg="red" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg><div>Máximo 3 caracteres después del punto que está después del signo arroba</div></div>')
            //validacion para que no hayan minimo 2 y maximo 3 caracteres despues del .
        }
    
        var errorDisplayed = false;
        var inputContrasenia = document.getElementById("contrasenia");
        inputContrasenia.addEventListener("blur", function (a) {
            var contrasenia = a.target.value;
            var campo = a.target;
            var patron = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!\"#$%&\/\(\)=\?¡¿\*\-\+\,\.;:_\[\]\{\}])[a-zA-Z\d!\"#$%&\/\(\)=\?¡¿\*\-\+\,\.;:_\[\]\{\}]{4,16}$/;
            //cumple con tener 1 en mayuscula, 1 en minuscula y / y - respectivamente para cumplir con el requerimiento
    
            var errorElement = campo.parentElement.querySelector('.alert.alert-primary');
            if (errorDisplayed) {
                return;
            }
            if (errorElement) {
                errorElement.remove();
            }
    
            if (contrasenia.length == 0) {
                campo.parentElement.insertAdjacentHTML("beforeend", '<div class="alert alert-primary d-flex align-items-center" role="alert"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg><div>El campo no puede estar vacio</div></div>');
            } 
            else if (contrasenia.length <4 ||contrasenia.length >=17){
                campo.parentElement.insertAdjacentHTML("beforeend", '<div class="alert alert-primary d-flex align-items-center" role="alert"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg><div>La contraseña debe ser de minimo 4 caracteres y maximo 16.</div></div>');
    
            }
            else if (!patron.test(contrasenia)) {
                campo.parentElement.insertAdjacentHTML("beforeend", '<div class="alert alert-primary d-flex align-items-center" role="alert"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg><div>La contraseña tiene que tener almenos 1 letra en mayuscula un numero y un signo ($#"....)</div></div>');
            }
        });
        
    })
}

