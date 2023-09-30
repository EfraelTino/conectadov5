console.log("hola desde las funciones")
console.log(typeof $);
var responseValue = $('#response_value');

// var pwd= document.getElementById("password"), toggleIcon=document.getElementById("icon-eyes");


// toggleIcon.onclick=()=>{
//     if(pwd.type== "password"){
//         pwd.type="text";
//         toggleIcon.classList.add("active")
//     }else{
//         pwd.type="password";
//         toggleIcon.classList.remove("active");
//     }
// }
function isValidEmail(email) {
    // Expresión regular para validar el formato del correo electrónico
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailPattern.test(email);
}
function crearCuenta() {
    responseValue = $('#response_value');
    const nombre = $("#nombre").val();
    const apellido = $("#apellido").val();
    const email_adress = $("#email_adress").val();
    const password_normal = $("#password_normal").val();
    const password_sec = $("#password_sec").val();
    const rol_usuario = $("#rol_usuario").val();
    console.log("el rol del usuario es ", rol_usuario);
    if (nombre.length <= 4) {
        responseValue.text('Ingrese un nombre válido');
        responseValue.addClass('error');
        return false;
    }
    if (apellido.length <= 4) {
        responseValue.text('Ingrese un apellido válido');
        responseValue.addClass('error');
        return false;
    }
    if (!isValidEmail(email_adress)) {
        responseValue.text('Ingrese un correo electrónico válido');
        responseValue.addClass('error');
        // responseValue.addClass('error');
        return false;
    }
    if (password_normal.length <= 6) {
        responseValue.text('La contraseña debe tener mas de 6 caracteres, intenta de nuevo');
        responseValue.addClass('error');
        return false;
    }
    if (password_normal !== password_sec) {
        console.log("Las contraseñas no coinciden");
        responseValue.text('Las contraseñas no coinciden');
        responseValue.addClass('error');
        return false;
    }
    const formData = new FormData();
    formData.append('action', 'crearcuenta');
    formData.append('nombre', nombre);
    formData.append('apellido', apellido);
    formData.append('email_adress', email_adress);
    formData.append('password_normal', password_normal);
    formData.append('password_sec', password_sec);
    formData.append('rol_usuario', rol_usuario);
    jQuery.ajax({
        data: formData,
        url: 'action.php',
        type: 'post',
        processData: false,
        contentType: false,
        dataType: 'json',
        beforeSend: function () {
        responseValue.text('Loading ...');
        responseValue.addClass('loading');
        },
        success: function (res) {
            console.log(res);
            if (res.success == true) {
                console.log(res.message);
                responseValue.text(res.message);
                responseValue.addClass('succes');
                $("#nombre").val("");
                $("#apellido").val("");
                $("#email_adress").val("");
                $("#password_normal").val("");
                $("#password_sec").val("");
                $("#rol_usuario").val("");
                responseValue.addClass('succes');
                responseValue.text(res.message);
            } else {
                responseValue.text(res.message);
                responseValue.addClass('error');
                // Muestra un mensaje de error al usuario o toma medidas apropiadas
            }
        }, 
        error: function (xhr, status, error) {
            console.log(xhr.responseText)
            console.log("XHR status: " + status);
            console.log("Error: " + error);
        }
    });
}

function cambiarLugar(id){
    switch (id) {
        case 1:
            window.location.href="./index"
            break;
    
        default:
            break;
    }
}

function actualizarDatos(){
    responseValue = $('#response_value');
    const nombre = $("#nombre_usuario").val();
    const apelleidos= $("#apellido_usuario").val();
    const email= $("#email_usuario").val();
    const telf= $("#telef_usuario").val();
    const metodo_pago= $("#meoto_pago").val();
    const enlace_pago= $("#enlace_pago").val();
    const enlace_telegram= $("#enlace_telegram").val();
    const genero= $("#genero_usuario").val();


    console.log("NOMBRE DE USUARIO: " + nombre);
    console.log("APELLIODO DE USUARIO: " + apelleidos);
    console.log("EMAIL DE USUARIO: " + email);
    console.log("TELF DE USUARIO: " + telf);
    console.log("METODO DE USUARIO: " + metodo_pago);
    console.log("ENLACE PAGO  DE USUARIO: " + enlace_pago);
    console.log("ENLACE TELEGRAM  DE USUARIO: " + enlace_telegram);
    console.log("GENERO  DE USUARIO: " + genero);
    console.log("------------------------------------------------")
    if (nombre.length <= 4) {
        responseValue.text('Ingrese un nombre válido');
        responseValue.addClass('error');
        return false;
    }
    if (apelleidos.length <= 4) {
        responseValue.text('Ingrese un apellido válido');
        responseValue.addClass('error');
        return false;
    }
    if (!isValidEmail(email)) {
        responseValue.text('Ingrese un correo electrónico válido');
        responseValue.addClass('error');
        // responseValue.addClass('error');
        return false;
    }
    if(telf.length< 9){
        responseValue.text('Ingrese un teléfono válido');
        responseValue.addClass('error');
        // responseValue.addClass('error');
        return false;
    }
    if(metodo_pago === '0'){
        responseValue.text('Seleccione un método de pago válido');
        responseValue.addClass('error');
        // responseValue.addClass('error');
        return false;
    }
    if(enlace_pago.length  <= 10){
        responseValue.text('Ingrese un enlace de pago válido');
        responseValue.addClass('error');
        // responseValue.addClass('error');
        return false;
    }
    if(enlace_telegram.length  <= 10){
        responseValue.text('Ingrese un enlace de telegram válido');
        responseValue.addClass('error');
        // responseValue.addClass('error');
        return false;
    }
    if(genero == '0'){
        responseValue.text('Seleccione un género válido');
        responseValue.addClass('error');
        // responseValue.addClass('error');
        return false;
    }

    const formData = new FormData();
    formData.append('action', 'actualizardatos');
    formData.append('apellido', apelleidos);
    formData.append('nombre', nombre);
    formData.append('email', email);
    formData.append('telf', telf);
    formData.append('metodo_pago', metodo_pago);
    formData.append('enlace_pago', enlace_pago);
    formData.append('enlace_telegram', enlace_telegram);
    formData.append('genero', genero);
    jQuery.ajax({
        data: formData,
        url: 'action.php',
        type: 'post',
        processData: false,
        contentType: false,
        dataType: 'json',
        beforeSend: function () {
        responseValue.text('Loading ...');
        responseValue.addClass('loading');
        },
        success: function (res) {
            console.log(res);
            if (res.succes == true) {
                console.log(res.message);
                responseValue.addClass('succes');
                responseValue.text(res.message);
                window.location.href = "dashboard";
            } else {
                responseValue.text(res.message);
                responseValue.addClass('error');
                // Muestra un mensaje de error al usuario o toma medidas apropiadas
            }
        }, 
        error: function (xhr, status, error) {
            console.log(xhr.responseText)
            console.log("XHR status: " + status);
            console.log("Error: " + error);
        }
    });
}