// console.log("hola desde mochila");
var fname = "---";
var lastname = "---";
var userid = "---";
var useremail = "";
var responseValue = $('#response_value');
var profession = "";
var university = "";
var saveButtom = $("#saveButton");
var action;
var lugarGeneral = "";

// FUNCTION SEARCH
$(document).ready(function () {
    setTimeout(function () {
        const containerEmojis = document.getElementById('todos_emojis');
        containerEmojis.style.display = 'flex'; // Cambia 'none' a 'block' para mostrar los botones
        const abrir_chat = document.getElementById("abrir_chat");
        abrir_chat.style.display = 'flex'; // Cambia 'none' a 'block' para mostrar los botones

    }, 1000);
    $('#input_search').keyup(function () {
        const inputValue = $(this).val().trim();
        const responseValue = $('#response_value')
        if (inputValue === '') {
            $("#results_university").empty();
            $("#anterior_results").css("display", "flex");
            $("#not-found").text("No results found...").hide();
            return;
        }
        const params = {
            input_search: inputValue,
            action: 'search_uni'
        };
        $.ajax({
            data: params,
            url: 'logic/mochila_action.php',
            type: 'post',
            dataType: 'json',
            beforeSend: function () {
                // mensaje de carga
                $("#loading-message").text("Loading...").show();
            },
            success: function (response) {
                $("#results_university").empty();
                const results = response.results;


                if (results.length == 0) {
                    $("#not-found").text("No results found...").show();
                    $("#anterior_results").css("display", "none");
                } else {
                    $("#not-found").text("No results found...").hide();

                    const pintarHTML = results.map(element => ` 
                    <a class="cont_uni" href="${element.url}">
                        <div class="cont_ims">
                            <img src="textures/${element.photo}" alt="${element.name}" class="img_uni" loading="lazy">
                        </div>
                        <h4 class="name_universtity">${element.name}</h4>
                        <div class="desc">
                            <p>${element.location}</p>
                            <button class="btn_edit">Edit <span class="icon-edit"></span></button>
                           
                        </div>
                    </a>`).join("");

                    $("#results_university").append(pintarHTML);
                    $("#results_university").removeClass("id_s");
                    $("#anterior_results").css("display", "none");
                }
            },
            complete: function () {
                // Ocultar mensaje de carga
                $("#loading-message").hide();
            },
            error: function (xhr, error, status) {
                responseValue.addClass('error');
                responseValue.text('Unknown error contact support ...');
            }
        });
    });
});
// pintar universidad   
function traerUni(id) {
    const photoUni = $("#photo_uni");
    let imgHtml = '';
    const formData = new FormData();
    formData.append('id', id);
    formData.append('action', 'traeruni');
    const responseValue = $('#response_value');
    $.ajax({
        data: formData,
        url: 'logic/mochila_action.php',
        type: 'post',
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function (res) {

            const nameUniValue = res[0].name;
            const locationValue = res[0].location;
            const urlValue = res[0].url;
            const photoValue = res[0].photo;

            $('#name_uni').val(nameUniValue);
            $('#location_uni').val(locationValue);
            $('#link_uni').val(urlValue);


            imgHtml = `<img src="textures/${photoValue}" alt="${nameUniValue}" class="foto_uni" style="width: 100%; height:100%;" />`;
            photoUni.css('display', 'block')
            const labelElement = $('#photo_uni label');
            labelElement.after(imgHtml);


        }, error: function (xhr, error, status) {
            responseValue.text('Unknown error contact support ...');
            responseValue.addClass('error');
        }
    });
    // return false;
}

// OPEN MODAL UNIVERSITY
function openModal(actionType, universityId) {
    $(".status_s").text("");
    $("#response_value").text("");
    $("#response_value").removeClass("loading");
    $("#response_value").removeClass("succes");
    $("#response_value").removeClass("loading");
    console.log("SE EJECUTO OPEN");

    event.preventDefault();
    const modalContainer = $("#modal_content");
    const modalTitle = $("#modalTitle");
    const idField = $("#university_id");
    //const saveButtom = $("#saveButton");
    if (actionType === "add") {
        modalTitle.text("Add university");
        idField.val(universityId);
        saveButtom.text("Save new Uni");
        lugarGeneral = "save";
        // saveButtom.attr("data-action", "save");
        $('#photo_filename').hide();
    } else if (actionType === "edit") {
        modalTitle.text("Edit dates of university");
        idField.val(universityId);
        $('#photo_filename').show();
        traerUni(universityId);
        saveButtom.text("Save edit");
        //saveButtom.attr("data-action", "update");
        lugarGeneral = "update";
    }
    saveButtom.attr("data-action", lugarGeneral);
    modalContainer.addClass("show-modal");
}


function closeModal() {
    const modalContainer = $("#modal_content");
    modalContainer.removeClass("show-modal");
    // Borrar contenido de campos de entrada
    $('#name_uni').val('');
    $('#location_uni').val('');
    $('#link_uni').val('');
    // Borrar contenido de div o párrafo
    $('#response_value').text('');
    // Restablecer el campo de archivo (si es necesario, depende de tu caso de uso)
    $('#file_uni').val('');
    $('.foto_uni').remove();
    $("#photo_uni").css('display', 'flex');
    $("#response_value").removeClass('lading');
    $("#response_value").removeClass('error');
    $("#response_value").removeClass('succes');
    // $(".status_s").text("");
}

// OPEN MODAL PROFILE
function openModalP(actionType, userid) {
    $(".status_s").text("");
    $("#response_value").removeClass("loading");
    $("#response_value").removeClass("succes");
    $("#response_value").removeClass("loading");
    // console.log(userid);
    const modalContainer = $("#modal_content");
    const modalTitle = $("#modalTitle");
    const idField = $("#university_id");
    // saveButtom = $("#saveButton");
    // alert(saveButtom);
    switch (actionType) {
        case 'updateprofile':
            modalTitle.text("Edit profile");
            idField.val(userid);
            saveButtom.text("Save");
            searchProfileUser(userid, 'photo');
            lugarGeneral = "up_photo";
            // saveButtom.attr("data-action", "up_photo");//cambiar para realizar la accion
            break;
        case 'updatename':
            modalTitle.text("Edit first and last names");
            idField.val(userid);
            saveButtom.text("Save edit");
            searchProfileUser(userid, 'name');
            lugarGeneral = "up_name";
            //  saveButtom.attr("data-action", "up_name");//cambiar para realizar la accion        
            break;
        case 'updatemail':
            modalTitle.text("Edit your email");
            idField.val(userid);
            saveButtom.text("Save edit");
            searchProfileUser(userid, 'email');
            lugarGeneral = "up_email";
            // saveButtom.attr("data-action", "up_email");//cambiar para realizar la accion        
            break;
        case 'updateNumber':
            modalTitle.text("Edit your phone number");
            idField.val(userid);
            saveButtom.text("Save edit");
            searchProfileUser(userid, 'phone');
            lugarGeneral = "up_phone";
            // saveButtom.attr("data-action", "up_phone");//cambiar para realizar la accion
            break;
        case 'updateuni':
            modalTitle.text("Edit your University");
            idField.val(userid);
            saveButtom.text("Save edit");
            searchProfileUser(userid, 'uni');
            lugarGeneral = "up_uni";
            // saveButtom.attr("data-action", "up_uni");//cambiar para realizar la accion
            break;
        case 'updatedata':
            modalTitle.text("Edit general data");
            idField.val(userid);
            saveButtom.text("Save edit");
            searchProfileUser(userid, 'gdata');
            lugarGeneral = "up_gdata";
            // saveButtom.attr("data-action", "up_gdata");//cambiar para realizar la accion

            break;
        case 'updateadress':
            modalTitle.text("Edit Address");
            idField.val(userid);
            saveButtom.text("Save edit");
            searchProfileUser(userid, 'address');
            lugarGeneral = "up_address";
            //saveButtom.attr("data-action", "up_address");//cambiar para realizar la accion
            break;
    }
    saveButtom.attr("data-action", lugarGeneral);
    modalContainer.addClass("show-modal");
}
function closeModalId() {
    const modalContainer = $("#modal_content");
    const loading = $(".loading");
    modalContainer.removeClass("show-modal");

    $("#append_items").empty().append('');

    $('.foto_uni').remove();
    $("#response_value").removeClass('lading');
    $("#response_value").removeClass('error');
    $("#response_value").removeClass('succes');
    //  $("#response_value");
    $("#response_value").css("font-size", "0px");
    // $("#saveButton").remove();
    console.log("remover");
    // $(".status_s").text("");
    /*
    $('#file_uni').val('');searchProfileUser
    $("#profesion_user").val('');
    $("#user_name").val('');
    $("#user_lname").val('');
    $("#user_email").val('');
    $("#user_phone").val('');
    $("#user_uni").val('');
    $("#identificacion").val('');
    $("#nationality").val('');
    $("#sexo").val('');
    $("#address").val('');
    $("#country").val('');
    $("#city").val('');
    */


}

// traer profile uni
function searchProfileUser(id, type) {
    const id_user = parseInt(id);
    const formContainer = $("#append_items");
    let responseValue = $('#response_value');
    // alert(type);
    formData = new FormData();
    formData.append('id_user', id);
    formData.append('action', 'update_profile');
    $.ajax({
        data: formData,
        url: 'logic/mochila_action.php',
        type: 'post',
        dataType: 'json',
        processData: false,
        contentType: false,
        success: function (res) {
            const result = res.results;
            // recorremos el resultado
            let htmlInner = '';
            switch (type) {
                case 'photo':
                    htmlInner = result.map(element =>
                        `
                        <input id="id_user" value="${element.userid}" hidden>

<div class="input_section">
    <label for="">
        <small> Your profession?*</small>
    </label>
    <input type="text" id="profesion_user" placeholder="What is your profession?" class="input_modal"
        value="${!element.profession ? '' : element.profession}">
</div>
                    `);
                    formContainer.append(htmlInner);
                    break;
                case 'name':
                    htmlInner = result.map(element =>
                        `
                        <input id="id_user" value="${element.userid}" hidden>
                    <div class="input_section">
                                <label for="">
                                    <small> Your name*</small>
                                </label>
                                <input type="text" id="user_name" placeholder="What is your Your name?" class="input_modal" value="${element.fname}">
                            </div>
                            <div class="input_section">
                                <label for="">
                                    <small> Your Last name*</small>
                                </label>
                                <input type="text" id="user_lname" placeholder="What is your Last name?" class="input_modal" value="${element.lastname}">
                            </div>
                            `);
                    formContainer.append(htmlInner);
                    break;
                case 'email':
                    htmlInner = result.map(element =>
                        `
                        <input id="id_user" value="${element.userid}" hidden>
                                <div class="input_section">
                                    <label for="">
                                        <small> Your email*</small>
                                    </label>
                                    <input type="text" id="user_email" placeholder="What is your email?" class="input_modal" value="${element.username}">
                                </div>
                                `);
                    formContainer.append(htmlInner);
                    break;
                case 'phone':
                    htmlInner = result.map(element =>
                        `
                        <input id="id_user" value="${element.userid}" hidden>
                                <div class="input_section">
                                    <label for="">
                                        <small> Your phone number*</small>
                                    </label>
                                    <input type="text" id="user_phone" placeholder="What is your phone number?" class="input_modal" value="${!element.phone ? '' : element.phone}">
                                </div>
                                `);
                    formContainer.append(htmlInner);
                    break;
                case 'uni':
                    htmlInner = result.map(element =>
                        `
                        <input id="id_user" value="${element.userid}" hidden>
                                <div class="input_section">
                                    <label for="">
                                        <small> Your University*</small>
                                    </label>
                                    <input type="text" id="user_uni" placeholder="What is your University?" class="input_modal" value="${!element.institute ? '' : element.institute}">
                                </div>
                                `);
                    formContainer.append(htmlInner);
                    break;
                case 'gdata':
                    htmlInner = result.map(element =>
                        `
                        <input id="id_user" value="${element.userid}" hidden>
                                <div class="input_section">
                                    <label for="">
                                        <small> Your Nacional identification*</small>
                                    </label>
                                    <input type="text" id="identificacion" placeholder="What is your identification?" class="input_modal" value="${!element.document ? '' : element.document}">
                                </div>
                                <div class="input_section">
                                    <label for="">
                                        <small> Your Nacionality*</small>
                                    </label>
                                    <input type="text" id="nationality" placeholder="What is your Nacionality?" class="input_modal" value="${!element.nationality ? '' : element.nationality}">
                                </div>
                                <div class="input_section">
                                    <label for="">
                                        <small> Your Gender*</small>
                                    </label>
                                    <input type="text" id="sexo" placeholder="What is your Gender?" class="input_modal" value="${!element.sexo ? '' : element.sexo}">
                                </div>
                                `);
                    formContainer.append(htmlInner);
                    break;
                case 'address':
                    htmlInner = result.map(element =>
                        `
                        <input id="id_user" value="${element.userid}" hidden>
                                <div class="input_section">
                                    <label for="">
                                        <small> Your Address *</small>
                                    </label>
                                    <input type="text" id="address" placeholder="What is your Address?" class="input_modal" value="${!element.adress ? '' : element.adress}">
                                </div>
                                <div class="input_section">
                                    <label for="">
                                        <small> Your Country*</small>
                                    </label>
                                    <input type="text" id="country" placeholder="What is your Country?" class="input_modal" value="${!element.country ? '' : element.country}">
                                </div>
                                <div class="input_section">
                                    <label for="">
                                        <small> Your City*</small>
                                    </label>
                                    <input type="text" id="city" placeholder="What is your City?" class="input_modal" value="${!element.city ? '' : element.city}">
                                </div>
                                `);
                    formContainer.append(htmlInner);
                    break;
            }
        }, error: function (xhr, error, status) {
            responseValue.text('Unknown error');
            responseValue.addClass('Unknown error')
        }
    })
    // mostar html¡
}









//var n = 0;
//var l = document.getElementById("number");
window.setInterval(function () {
    // l.innerHTML = n;
    //console.log(n);
    //n++;
    //action = $(this).data("action");
    //saveButtom = $("#saveButton");

    //console.log(saveButtom.data("action"));
    //saveButtom.attr("data-action", "----");
}, 2000);


var cambio = false;
window.setInterval(function () {
    // l.innerHTML = n;
    //console.log(n);
    //n++;
    //action = $(this).data("action");
    //saveButtom = $("#saveButton");

    //console.log(saveButtom.data("action"));
    if (!cambio) {
        //saveButtom.attr("data-action", "----");
        cambio = true;
    } else {
        //saveButtom.attr("data-action", "aca");
        cambio = false;
        // console.log("-+-+-+-+");
    }

}, 10000);






// accion que se ejecuta
$("#saveButton").click(function () {
    action = $(this).data("action");
    // action = lugarGeneral;
    // if (action === "save") {
    //     newUniversity();
    // } else if (action === "") {
    //     editUniversity();
    // }
    // alert(action+" "+lugarGeneral);



    switch (lugarGeneral) {

        case "save":
            newUniversity();
            break;
        case "update":
            editUniversity();
            break;
        case "up_photo":
            editPhoto();
            break;
        case "up_name":
            editName();
            break;
        case "up_email":
            editEmail();
            break;
        case "up_phone":
            editPhone();
            break;
        case "up_uni": editUni();
            break;
        case "up_gdata":
            editData();
            break;
        case "up_address": editAddress();
            break;
    }


});

// NUEVA UNIVERSIDAD
function newUniversity() {
    // console.log("SE EJECUTO NUEVA UNIVERSIDAD");
    const nameUni = $('#name_uni').val();
    const locationUni = $('#location_uni').val();
    const linkUni = $('#link_uni').val();
    let fileInput = $('#file_uni')[0];
    const university_id = $('#university_id').val();
    let responseValue = $('#response_value');
    // console.log(fileInput);
    // name
    if (nameUni.length <= 10) {
        responseValue.text('Enter an existing university');
        responseValue.addClass('error');
        return false;
    }
    //file 
    if (fileInput.files.length === 0) {
        responseValue.text("Please select a file.");
        responseValue.addClass('error');
        return
    }
    // location
    if (locationUni.length <= 2) {
        responseValue.text('Enter a valid address');
        responseValue.addClass('error');
        return false
    }
    // url
    if (linkUni.length <= 10) {
        responseValue.text('Enter a valid url');
        responseValue.addClass('error');
        return false
    }
    const formData = new FormData();
    formData.append('photo', fileInput.files[0]);
    formData.append('action', 'adduni');
    formData.append('nameUni', nameUni);
    formData.append('locationUni', locationUni);
    formData.append('linkUni', linkUni);
    $.ajax({
        data: formData,
        url: 'logic/mochila_action.php',
        type: 'post',
        processData: false,
        contentType: false,
        dataType: 'json',
        beforeSend: function () {
            responseValue.text('Loading ...');
            responseValue.addClass('loading');
        }, success: function (res) {
            console.log(res);
            if (res.success) {
                responseValue.text('University added successfully');
                responseValue.addClass('succes');
                $('#name_uni').val('');
                $('#location_uni').val('');
                $('#link_uni').val('');
                $('#file_uni').val('');
                $('.status_s').text('The image has been loaded correctly, to visualize it refreshes the world');
                closeModalId();
            } else {
                responseValue.text('Failed to add university');
                responseValue.addClass('error');
            }
        }, complete: function () {
            responseValue.hide();
        }, error: function (xhr, error, status) {
            responseValue.addClass('error');
            responseValue.text('Unknown error contact support ...');
        }
    });
}

//  edit universidad
function editUniversity() {
    console.log("SE EJECUTO EDIT UNIVERSIDAD");
    const nameUni = $('#name_uni').val();
    const locationUni = $('#location_uni').val();
    const linkUni = $('#link_uni').val();
    const university_id = $('#university_id').val();
    const fileInput = $('#file_uni')[0];
    responseValue = $('#response_value');
    // console.log("foto: ", fileInput);

    if (nameUni.length <= 10) {
        responseValue.text('Enter an existing university');
        responseValue.addClass('error');
        return false;
    }
    // location
    if (locationUni.length <= 2) {
        responseValue.text('Enter a valid address');
        responseValue.addClass('error');
        return false
    }
    // url
    if (linkUni.length <= 10) {
        responseValue.text('Enter a valid url');
        responseValue.addClass('error');
        return false
    }
    //file 
    const formData = new FormData();
    formData.append('action', 'edituni');
    formData.append('nameUni', nameUni);
    formData.append('locationUni', locationUni);
    formData.append('linkUni', linkUni);
    formData.append('uni_id', university_id);
    formData.append('photo', fileInput.files[0]);
    if (fileInput.files.length === 0) {
        $.ajax({
            data: formData,
            url: 'logic/mochila_action.php',
            type: 'post',
            processData: false,
            contentType: false,
            dataType: 'json',
            beforeSend: function () {
                responseValue.text('Loading ...');
                responseValue.addClass('loading');
            }, success: function (res) {
                if (res.success == true) {
                    responseValue.removeClass("loading");
                    responseValue.text('');
                    $(".cont_ims").attr("href", linkUni);
                    $(".name_universtity").attr("href", linkUni);
                    $(".name_universtity").text(nameUni);
                    $(".countri_uni").text(locationUni);
                    if (algunaCondicion) { // Agrega aquí tu condición
                        const imagePath = "textures/unmsa.jpg"; // Ruta de la imagen
                        $(".uni_image").attr("src", imagePath);
                    }
                    closeModalId();
                } else {
                    responseValue.text('Unknown error contact support ...');
                    responseValue.removeClass('loading');
                    responseValue.addClass('error');
                }
                // location.reload();
            }, error: function (xhr, error, status) {
                responseValue.removeClass('loading');
                responseValue.addClass('error');
                responseValue.text('Unknown error contact support ...');
            }
        });
    } else {
        $.ajax({
            data: formData,
            url: 'logic/mochila_action.php',
            type: 'post',
            processData: false,
            contentType: false,
            dataType: 'json',
            beforeSend: function () {
                responseValue.text('Loading ...');
                responseValue.addClass('loading');
            }, success: function (res) {

                responseValue.removeClass("loading");
                responseValue.text('');
                $(".cont_ims").attr("href", linkUni);
                $(".name_universtity").attr("href", linkUni);
                $(".name_universtity").text(nameUni);
                $(".countri_uni").text(locationUni);

                closeModalId();
            },
            error: function (xhr, error, status) {
                responseValue.removeClass('loading');
                responseValue.addClass('error');
                responseValue.text('Unknown error contact support ...');
            }
        });
    }
}



// edits
function editPhoto() {
    event.preventDefault();
    // console.log("SE EJECUTO EDITPHOTO");
    // const fileInput = $("#file_profile")[0];
    //var responseValue = $('#response_value');
    profession = $('#profesion_user').val();
    // const userid = $('#id_user').val();
    $(document).ready(function () {
        $('#profesion_user').on('change', function () {
            profession = $(this).val();
            console.log('Nuevo valor del input:', profession);
            // Aquí puedes realizar cualquier otra acción con el valor capturado
        });
    });
    console.log(profession);
    // console.log(userid);

    if (profession.length <= 2) {
        responseValue.text('Please enter a valid profession longer than 2 characters');
        responseValue.addClass('error');
        return false;
    }
    const formData = new FormData();
    formData.append('action', 'editdata');
    formData.append('id_user', userid);   // Incluye id_user
    formData.append('especifiq', 'profedit');
    formData.append('profession', profession);
    $.ajax({
        data: formData,
        url: 'logic/mochila_action.php',
        type: 'post',
        processData: false,
        contentType: false,
        dataType: 'json',
        beforeSend: function () {
            responseValue.text('Loading ...');
            responseValue.addClass('loading');
        }, success: function (res) {
            if (res.success == true) {
                responseValue.removeClass("loading");
                responseValue.text('');
                $(".text_profesion").text(profession);
                closeModalId();
            } else {
                responseValue.addClass('error');
                responseValue.text('Unknown error contact support ...');
            }
        },
        error: function (xhr, error, status) {
            responseValue.removeClass('loading');
            responseValue.addClass('error');
            responseValue.text('Unknown error contact support ...');
        }
    });
}

function editName() {
    event.preventDefault();
    // console.log("SE EJECUTO editname");
    // const fileInput = $("#file_profile")[0];
    responseValue = $('#response_value');
    lastname = $('#user_name').val();
    fname = $("#user_lname").val();
    userid = $('#id_user').val();
    console.log("NAME: " + lastname);
    console.log("FULL NAME: " + fname);
    console.log("SE EJECUTO editname " + fname);

    if (fname.length <= 4) {
        responseValue.text('Please enter a valid name');
        responseValue.addClass('error');
        return false;
    }
    if (fname.length <= 4) {
        responseValue.text('Please enter a valid last name ');
        responseValue.addClass('error');
        return false;
    }
    const formData = new FormData();
    formData.append('action', 'editdata');
    formData.append('id_user', userid);   // Incluye id_user
    formData.append('especifiq', 'nameedit');
    formData.append('lname', lastname);
    formData.append('fname', fname);
    $.ajax({
        data: formData,
        url: 'logic/mochila_action.php',
        type: 'post',
        processData: false,
        contentType: false,
        dataType: 'json',
        beforeSend: function () {
            responseValue.text('Loading ...');
            responseValue.addClass('loading');
        },
        success: function (res) {
            if (res.success == true) {
                responseValue.removeClass("loading");
                responseValue.text('');
                $(".text_names").text(lastname + ' ' + fname);
                closeModalId();
            } else {
                responseValue.addClass('error');
                responseValue.text('Unknown error contact support ...');
            }
        }, error: function (xhr, error, status) {
            $("#response_value").addClass('error');
            responseValue.text('Unknown error contact support ...');
        }
    });
}

function isValidEmail(email) {
    // Expresión regular para validar el formato del correo electrónico
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailPattern.test(email);
}

function editEmail() {
    // console.log("SE EJECUTO editname");
    // const fileInput = $("#file_profile")[0];
    responseValue = $('#response_value');
    useremail = $('#user_email').val();
    userid = $('#id_user').val();

    console.log("EMAIL: " + useremail);


    if (!isValidEmail(useremail)) {
        responseValue.text('Please enter a valid email');
        responseValue.addClass('error');
        return false;
    }
    const formData = new FormData();
    formData.append('action', 'editdata');
    formData.append('id_user', userid);   // Incluye id_user
    formData.append('especifiq', 'emailedit');
    formData.append('useremail', useremail);
    $.ajax({
        data: formData,
        url: 'logic/mochila_action.php',
        type: 'post',
        processData: false,
        contentType: false,
        dataType: 'json',
        beforeSend: function () {
            responseValue.text('Loading ...');
            responseValue.addClass('loading');
        }, success: function (res) {
            if (res.success == true) {
                responseValue.removeClass("loading");
                responseValue.text('');
                $(".email").text(useremail);
                closeModalId();
            } else {
                responseValue.text('Unknown error contact support ...');
                responseValue.removeClass('loading');
                responseValue.addClass('error');
            }
        }, error: function (xhr, error, status) {
            responseValue.addClass('error');
            responseValue.text('Unknown error contact support ...');
        }
    });
}


function isNumeric(value) {
    return /^\d+$/.test(value);
}
function editPhone() {
    // console.log("SE EJECUTO editphone");
    // const fileInput = $("#file_profile")[0];
    responseValue = $('#response_value');
    const userphone = $('#user_phone').val();
    //const userid = $('#id_user').val();

    if (!isNumeric(userphone)) {
        responseValue.text('Please enter only numbers in the phone number field');
        responseValue.addClass('error');
        return false;
    }
    const formData = new FormData();
    formData.append('action', 'editdata');
    formData.append('id_user', userid);   // Incluye id_user
    formData.append('especifiq', 'phoneedit');
    formData.append('userphone', userphone);
    $.ajax({
        data: formData,
        url: 'logic/mochila_action.php',
        type: 'post',
        processData: false,
        contentType: false,
        dataType: 'json',
        beforeSend: function () {
            responseValue.text('Loading ...');
            responseValue.addClass('loading');
        }, success: function (res) {
            if (res.success == true) {
                responseValue.removeClass("loading");
                responseValue.text('');
                $(".phone").text(userphone);
                closeModalId();
            } else {
                responseValue.text('Unknown error contact support ...');
                responseValue.removeClass('loading');
                responseValue.addClass('error');
            }
        }, error: function (xhr, error, status) {
            responseValue.removeClass('loading');
            responseValue.addClass('error');
            responseValue.text('Unknown error contact support ...');
        }
    });
}

function editUni() {
    // console.log("SE EJECUTO editphone");
    // const fileInput = $("#file_profile")[0];
    responseValue = $('#response_value');
    university = $('#user_uni').val();
    //userid = $('#id_user').val();

    if (university.length <= 4) {
        responseValue.text('Please enter a valid university');
        responseValue.addClass('error');
        return false;
    }
    const formData = new FormData();
    formData.append('action', 'editdata');
    formData.append('id_user', userid);   // Incluye id_user
    formData.append('especifiq', 'uniedit');
    formData.append('university', university);
    $.ajax({
        data: formData,
        url: 'logic/mochila_action.php',
        type: 'post',
        processData: false,
        contentType: false,
        dataType: 'json',
        beforeSend: function () {
            responseValue.text('Loading ...');
            responseValue.addClass('loading');
        }, success: function (res) {
            if (res.success == true) {
                responseValue.removeClass("loading");
                responseValue.text('');
                $(".uni").text(university);
                closeModalId();
            } else {
                responseValue.text('Unknown error contact support ...');
                responseValue.removeClass('loading');
                responseValue.addClass('error');
            }
        },
        error: function (xhr, error, status) {
            responseValue.removeClass('loading');
            responseValue.addClass('error');
            responseValue.text('Unknown error contact support ...');
        }
    });
}
function editData() {
    responseValue = $('#response_value');
    const identificacion = $('#identificacion').val();
    const nationality = $('#nationality').val();
    const sexo = $('#sexo').val();
    const userid = $('#id_user').val();

    if (!isNumeric(identificacion)) {
        responseValue.text('Please enter only numbers in the identification field');
        responseValue.addClass('error');
        return false;
    }
    if (nationality.length <= 2) {
        responseValue.text('Please enter a valid nationality');
        responseValue.addClass('error');
        return false;
    }
    if (sexo.length <= 2) {
        responseValue.text('Please enter a valid gender');
        responseValue.addClass('error');
        return false;
    }
    const formData = new FormData();
    formData.append('action', 'editdata');
    formData.append('id_user', userid);   // Incluye id_user
    formData.append('especifiq', 'dataedit');
    formData.append('identificacion', identificacion);
    formData.append('nationality', nationality);
    formData.append('sexo', sexo);
    $.ajax({
        data: formData,
        url: 'logic/mochila_action.php',
        type: 'post',
        processData: false,
        contentType: false,
        dataType: 'json',
        beforeSend: function () {
            responseValue.text('Loading ...');
            responseValue.addClass('loading');
        }, success: function (res) {
            if (res.success == true) {
                responseValue.removeClass("loading");
                responseValue.text('');
                $(".identification").text(identificacion);
                $(".nationality").text(sexo);
                $(".sexo").text(sexo);
                closeModalId();
            } else {
                responseValue.text('Unknown error contact support ...');
                responseValue.removeClass('loading');
                responseValue.addClass('error');
            }
        },
        error: function (xhr, error, status) {
            responseValue.removeClass('loading');
            responseValue.addClass('error');
            responseValue.text('Unknown error contact support ...');



        }
    });
}

function editAddress() {

    responseValue = $('#response_value');
    const address = $('#address').val();
    const country = $('#country').val();
    const city = $('#city').val();
    const userid = $('#id_user').val();


    if (address.length <= 2) {
        responseValue.text('Please enter a valid address');
        responseValue.addClass('error');
        return false;
    }
    if (country.length <= 2) {
        responseValue.text('Please enter a valid country');
        responseValue.addClass('error');
        return false;
    }
    if (city.length <= 2) {
        responseValue.text('Please enter a valid city');
        responseValue.addClass('error');
        return false;
    }
    const formData = new FormData();
    formData.append('action', 'editdata');
    formData.append('id_user', userid);   // Incluye id_user
    formData.append('especifiq', 'editaddress');
    formData.append('address', address);
    formData.append('country', country);
    formData.append('city', city);
    $.ajax({
        data: formData,
        url: 'logic/mochila_action.php',
        type: 'post',
        processData: false,
        contentType: false,
        dataType: 'json',
        beforeSend: function () {
            responseValue.text('Loading ...');
            responseValue.addClass('loading');
        }, success: function (res) {
            if (res.success == true) {
                responseValue.removeClass("loading");
                responseValue.text('');
                $(".addres").text(address);
                $(".countri").text(country);
                $(".citi").text(city);
                closeModalId();
            } else {
                responseValue.text('Unknown error contact support ...');
                responseValue.removeClass('loading');
                responseValue.addClass('error');
            }
        },
        error: function (xhr, error, status) {
            responseValue.removeClass('loading');
            responseValue.addClass('error');
            responseValue.text('Unknown error contact support ...');
        }
    });
}

function closeOption(id) {
    console.log(id);
    const mochila_container = $("#mochila_container");
    const backpack_container = $("#backpack_container");
    const universiti_container = $("#universiti_container");
    const videloLlamada_container = $("#container-videllamada");
    switch (id) {
        case 1:
            console.log("se ejecuta open profile")
            mochila_container.removeClass('ver_mochila');
            backpack_container.removeClass("ver_backpack");
            break;
        case 2:
            console.log("hola");
            mochila_container.removeClass('ver_mochila');
            universiti_container.removeClass("ver_uni");
            break;
        case 3:
            console.log("se ejecuta 3");
            mochila_container.removeClass('ver_mochila');
            videloLlamada_container.removeClass("ver_llamda");
            break;
    }
}

function openProfile(id) {
    const mochila_container = $("#mochila_container");
    const backpack_container = $("#backpack_container");
    const universiti_container = $("#universiti_container");
    const videloLlamada_container = $("#container-videllamada");
    const content_chat = $("#content");
    // Oculta todos los contenedores primero
    mochila_container.removeClass('ver_mochila');
    backpack_container.removeClass("ver_backpack");
    universiti_container.removeClass("ver_uni");
    videloLlamada_container.removeClass("ver_llamada");

    switch (id) {
        case 1:
            console.log("se ejecuta open profile")
            mochila_container.addClass('ver_mochila');
            backpack_container.addClass("ver_backpack");
            videloLlamada_container.removeClass('ver_llamda');
            content_chat.removeClass("view_chat");
            window.Vagon.focusIframe();

            break;
        case 2:
            console.log("hola");
            mochila_container.addClass('ver_mochila');
            universiti_container.addClass("ver_uni");
            window.Vagon.focusIframe();

            break;
        case 3:
            console.log("se ejecuta 3");
            mochila_container.addClass('ver_mochila');
            videloLlamada_container.addClass("ver_llamda");
            mochila_container.removeClass('ver_backpack');
            content_chat.removeClass("view_chat");
            window.Vagon.focusIframe();

            break;
    }
    window.Vagon.focusIframe();
}

function alerta() {
    alert("Coming soon");
}

function viewDetalis(item) {
    event.preventDefault();
    const backpack_container = $("#backpack_container");
    const universiti_container = $("#universiti_container");
    const avatar_container = $("#avatar_container");
    const university_items = document.querySelectorAll(".university_item"); // Debería ser 'university_items'
    const account_items = document.querySelectorAll(".account_item"); // Debería ser 'account_items'
    const avatar_items = document.querySelectorAll(".avatar_item");
    switch (item) {
        case 'account':
            universiti_container.removeClass('view_uni');
            backpack_container.addClass("view_mochila");
            avatar_container.removeClass('view_avatar');
            account_items.forEach(function (item) {
                item.classList.add('option-active');
            });
            university_items.forEach(function (item) {
                item.classList.remove('option-active');
            });
            avatar_items.forEach(function (item) {
                item.classList.remove('option-active');
            });
            break;
        case 'list_uni':
            universiti_container.removeClass('view_mochila');
            avatar_container.removeClass('view_avatar');
            universiti_container.addClass('view_uni');
            university_items.forEach(function (item) {
                item.classList.add('option-active');
            });
            account_items.forEach(function (item) {
                item.classList.remove('option-active');
            });
            avatar_items.forEach(function (item) {
                item.classList.remove('option-active');
            });
            break;
        case 'avatar':
            universiti_container.removeClass('view_mochila');
            universiti_container.removeClass('view_uni');

            avatar_container.addClass('view_avatar');
            avatar_items.forEach(function (item) {
                item.classList.add('option-active');
            });
            account_items.forEach(function (item) {
                item.classList.remove('option-active');
            });
            university_items.forEach(function (item) {
                item.classList.remove('option-active');
            });
            break;


    }
}



// AVATAR
function actualizarCabello(id, parte) {
    const responseValue = $('#response_value');
    const formData = new FormData();
    let cambiar = '';

    formData.append('action', 'editaravatar');
    formData.append('id_user', id);

    switch (parte) {
        case 'cabello':
            cambiar = 'cabello';
            console.log('Va a cambiar el cabello');
            formData.append('cambiar', cambiar);
            if ($("#cabello")[0].files.length === 0) {
                responseValue.text('Please select a file');
                responseValue.addClass('error');
                return;
            }
            formData.append('imageavatar', $("#cabello")[0].files[0]);
            break;
        case 'camiseta':
            cambiar = 'camiseta';
            console.log('Va a cambiar la camisa');
            formData.append('cambiar', cambiar);
            if ($("#camisa")[0].files.length === 0) {
                responseValue.text('Please select a file');
                responseValue.addClass('error');
                return;
            }
            formData.append('imageavatar', $("#camisa")[0].files[0]);
            break;
        case 'pantalon':
            cambiar = 'pantalon';
            console.log('Va a cambiar el pantalón');
            formData.append('cambiar', cambiar);
            if ($("#pantalon")[0].files.length === 0) {
                responseValue.text('Please select a file');
                responseValue.addClass('error');
                return;
            }
            formData.append('imageavatar', $("#pantalon")[0].files[0]);
            break;
        case 'zapatos':
            cambiar = 'zapatos';
            console.log('Va a cambiar el zapato');
            formData.append('cambiar', cambiar);
            if ($("#zapato")[0].files.length === 0) {
                responseValue.text('Please select a file');
                responseValue.addClass('error');
                return;
            }
            formData.append('imageavatar', $("#zapato")[0].files[0]);
            break;
    }

    $.ajax({
        data: formData,
        url: 'logic/mochila_action.php',
        type: 'post',
        processData: false,
        contentType: false,
        dataType: 'json',
        beforeSend: function () {
            responseValue.text('Loading...');
            responseValue.addClass('loading');
        },
        success: function (res) {
            if (!res.success) {
                responseValue.removeClass('loading');
                responseValue.addClass('error');
                responseValue.text(res.message);
            } else {
                responseValue.removeClass('loading');
                responseValue.removeClass('error');
                responseValue.text('It has been updated correctly.');
                responseValue.addClass('succes');

                // ACTUALIZAR LA FOTO
                switch (parte) {
                    case 'cabello':
                        console.log("entra acá");
                        if ($("#cabello")[0].files.length > 0) {
                            const file = $("#cabello")[0].files[0];
                            const reader = new FileReader();
                            reader.onload = function (e) {
                                $('#cabelloImage').attr('src', e.target.result);
                            };
                            reader.readAsDataURL(file);
                        }
                        break;
                    case 'camiseta':
                        console.log("entra acá");
                        if ($("#camisa")[0].files.length > 0) {
                            const file = $("#camisa")[0].files[0];
                            const reader = new FileReader();
                            reader.onload = function (e) {
                                $('#camisetaImage').attr('src', e.target.result);
                            };
                            reader.readAsDataURL(file);
                        }
                        break;
                    case 'pantalon':
                        console.log("entra acá");
                        if ($("#pantalon")[0].files.length > 0) {
                            const file = $("#pantalon")[0].files[0];
                            const reader = new FileReader();
                            reader.onload = function (e) {
                                $('#pantalonImage').attr('src', e.target.result);
                            };
                            reader.readAsDataURL(file);
                        }
                        break;
                    case 'zapatos':
                        console.log("entra acá");
                        if ($("#zapato")[0].files.length > 0) {
                            const file = $("#zapato")[0].files[0];
                            const reader = new FileReader();
                            reader.onload = function (e) {
                                $('#zapatosImage').attr('src', e.target.result);
                            };
                            reader.readAsDataURL(file);
                        }
                        break;
                }
            }
        },
        error: function (xhr, error, status) {
            responseValue.removeClass('loading');
            responseValue.addClass('error');
            responseValue.text(error);
        }
    });
}
