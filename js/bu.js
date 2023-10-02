// console.log("hola desde mochila");

// FUNCTION SEARCH

$(document).ready(function () {
    $('#input_search').keyup(function () {
        const inputValue = $(this).val().trim();
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
                console.log(response);
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
            console.log(res[0]);
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

// OPEN MODAL
function openModal(actionType, universityId) {
    console.log(universityId);
    const modalContainer = $("#modal_content");
    const modalTitle = $("#modalTitle");
    const idField = $("#university_id");
    const saveButtom = $("#saveButton");
    if (actionType === "add") {
        modalTitle.text("Add university");
        idField.val(universityId);
        saveButtom.text("Save new Uni");
        saveButtom.attr("data-action", "save");
        $('#photo_filename').hide();
    } else if (actionType === "edit") {
        modalTitle.text("Edit dates of university");
        idField.val(universityId);
        $('#photo_filename').show();
        traerUni(universityId);
        saveButtom.text("Save edit");
        saveButtom.attr("data-action", "update");
    }
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
}

// accion que se ejecuta
$("#saveButton").click(function () {
    const action = $(this).data("action");

    if (action === "save") {
        newUniversity();
    } else if (action === "update") {
        editUniversity();
    }
});

// NUEVA UNIVERSIDAD
function newUniversity() {
    console.log("SE EJECUTO NUEVA UNIVERSIDAD");
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
            // responseValue.empty();
            if (res.success) {
                responseValue.text('University added successfully');
                responseValue.addClass('succes');
                $('#name_uni').val('');
                $('#location_uni').val('');
                $('#link_uni').val('');
                $('#file_uni').val('');
            } else {
                responseValue.text('Failed to add university');
                responseValue.addClass('error');
            }
        },
        complete: function () {
            responseValue.hide();
        },
        error: function (xhr, error, status) {
            responseValue.addClass('error');
            responseValue.text('Unknown error contact support ...');
            console.log(xhr);
            console.log(error);
            console.log(status);
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
    var responseValue = $('#response_value');
    console.log("foto: ", fileInput);

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
                console.log(res);
            },complete:function(){
                responseValue.hide();
            },   error: function (xhr, error, status) {
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
                console.log(res);
                location.reload();
            },complete: function(){
                responseValue.hide();
            }, 
            error: function (xhr, error, status) {
                responseValue.addClass('error');
                responseValue.text('Unknown error contact support ...');
            }
        });
    }
}
