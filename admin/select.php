<?php
session_start();
$title = "Conectado";
include('Chat.php');
include('page-master/head.php');
if (isset($_SESSION["userid"]) &&  $_SESSION["userid"]) {
    $userid =  $_SESSION["userid"];
} else {
    header("Location: ./");
}
include('page-master/js.php');
$chat = new Chat();
?>
<style>
    body {
        overflow-y: auto !important;
    }

    .cont_wrap {
        display: flex;
        margin: 4px 0px;
        align-items: center;
        gap: 4px;
        flex-direction: column;
        width: 100%;
    }

    .close_containers {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .cont_wrap_tow {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 10px;
    }





    .ic_e {
        color: white;
    }

    .ic_b {
        color: var(--color-en-linea);
        font-size: 40px;
    }

    h4 {
        text-align: center;
        margin-bottom: 4px;
        font-size: 22px;
    }

    h4,
    .view_src {
        color: var(--color-ausente);
    }

    .ico_c {
        color: var(--color-ausente);
    }

    .view_src {
        text-align: left;
        font-size: 18px;
    }

    .books {
        width: 100%;
    }

    .books .view_src {
        height: 24px;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 1;
    }

    .ss {
        text-align: center;
    }

    .cont_add_new {
        width: 100%;
        display: flex;
        justify-content: center;
        text-align: center;
    }

    .add_new {
        color: white;
        background-color: var(--color-en-linea);
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 13px;
        transition: var(--transition300);
        width: 210px;
        font-weight: 600;
        font-size: 18px;
    }

    .add_neww {
        border-radius: 8px;
        background-color: var(--color-en-linea);
        display: inline-flex;
        padding: 6px 13px;
        align-items: center;
        transition: var(--transition300);
        font-weight: 600;
        font-size: 18px;
        justify-content: center;
        border: none;
        cursor: pointer;
        margin: 0 20px;
    }

    .add_new span {
        color: white;
        font-size: 18px;
    }

    .add_new:hover,
    .add_neww {
        transform: scale(1.04);
        box-shadow: 0px 8px 10px -4px rgba(0, 0, 0, .4);
    }

    .add_new:active,
    .add_neww:active {
        transform: scale(0.90);
        background-color: var(--color-ausente);
    }

    select {
        background-color: var(--color-ausente);
        padding: 4px 10px;
        border-radius: 8px;
        margin: 10px 0px;
        font-size: 18px;
    }

    label {
        color: white;
    }

    .input_date {
        border-radius: 4px;
        background-color: var(--color-secundario);
        border: none;
        font-size: 20px;
        padding: 4px 10px;
        font-weight: 700;
    }

    .input_date::placeholder {
        font-size: 18px;
        color: #32465a;
    }

    .input_date:focus-visible {
        border: none;
        outline: none;
    }

    .container_videos,
    .container_boock {
        margin: 16px 0px;
    }

    .container_messages {
        color: white;
        font-size: 18px;
    }

    /* Estilo para ocultar el input file */
    .hidden-input {
        display: none;
    }

    /* Estilo para el botón simulado */
    .custom-file-input {
        display: inline-block;
        padding: 0px 16px;
        cursor: pointer;
        background-color: var(--color-primario);
        border: 1px solid var(--color-secundario);
        color: var(--color-white);
        border-radius: 4px;
        transition: var(--transition150);
        font-weight: 600;
        background-color: var(--color-primario);
        margin: 0;
    }

    .file_name {
        color: var(--color-primario);
        height: 24px;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 1;
        padding: 0px 8px;
        width: 320px;
    }

    .img_options {
        margin: 16px 0px;
    }

    .cont_s {
        background-color: var(--color-en-linea);
        border-radius: 8px;
        display: flex;
    }

    .img_options {
        display: flex;
        gap: 16px;
    }

    .custom-file-input:hover {
        transform: scale(1.03);
        transition: var(--transition150);
    }
</style>

<body style="background-color: var(--color-primario); color:white;">
    <?php
    $sql = "SELECT fname, lastname, username, document, password, institute, birthdate, sexo, adress, country, city FROM chat_users WHERE userid = '$userid'";
    $stmt = $chat->dbConnect->query($sql);
    if (!$stmt) {
        die("Error en la consulta: " . $chat->dbConnect->error);
    }
    while ($row = $stmt->fetch_assoc()) {
        $fname = $row['fname'];
        $lname = $row['lastname'];
        $username = $row['username'];
        $doc = $row['document'];
        $pass = $row['password'];
        $insti = $row['institute'];
        $birthda = $row['birthdate'];
        $sexo = $row['sexo'];
        $address = $row['adress'];
        $country = $row['country'];
        $city = $row['city'];
    }
    ?>
    <div class="cl-normal">
        <div class="close_containers">
            <a href="conectado" class="options_salir">
                <span class="icon-arrow-left-circle ic_b"></span>
            </a>
            <div class="containerlogo">
                <img src="images/logo_conectado.webp" alt="Logo CONECTADO" width="120">
            </div>

        </div>
        <div>
            <h3 style="color: white; font-weight: 800; font-size: 2rem; text-align: center;">
                ¿BOOCK OR VIDEO?
            </h3>


            <div class="wrap-data">
                <div class="cont_wrap_tow">
                    <div class="cont_wrap">
                        <h4>
                            Select the type of file you want to upload
                        </h4>
                        <div class="videos">
                            <select name="file_type" id="file_type">
                                <option value="0">Select the type of file</option>
                                <option value="1">Boock (pdf, jpg and more)</option>
                                <option value="1">Vídeo</option>
                            </select>
                        </div>
                        <div class="cont_add_new">
                            <button class="add_new" onclick="agregar();">Add new <span class="icon-file-plus"></span></button>
                        </div>
                    </div>
                </div>
            </div>
            <p class="container_messages" id="container_message">

            </p>
        </div>

        <div class="container_boock" id="book_container" style="display: flex;">
            <form action="">
                <div class="img_options">
                    <label for="">File name or source type pdf, jpg, png*</label>
                    <div class="cont_s">
                        <label for="file-upload" class="custom-file-input" id="file-label" style="color: white;">Choose file</label>
                        <input type="file" name="image" accept="image/x-png,image/gif,image/jpeg,image/jpg/pdf" id="file-upload" class="hidden-input" onchange="showFileName(event)" required>
                        <span id="file-name" class="file_name">No file selected</span>
                    </div>
                </div>
                <label for="">File name*</label>
                <input class="input_date" type="text" id="name_file" placeholder="" value="">
                <button class="add_neww" onclick="saveFile(event);">Save</button>
            </form>

        </div>
        <div class="container_videos" id="video_container" style="display: none;">
            <form action="">
                <label for="">Video link*</label>
                <input class="input_date" type="text" placeholder="" value="" id="link_video">
                <label for="">Video name*</label>
                <input class="input_date" type="text" placeholder="" value="" id="video_name">
                <button class="add_neww" onclick="saveVideo(event);">Save</button>
            </form>
        </div>

    </div>
    <script>
        function showFileName(event) {
            const fileInput = event.target;
            const fileNameSpan = document.getElementById('file-name');

            if (fileInput.files && fileInput.files.length > 0) {
                fileNameSpan.textContent = fileInput.files[0].name;
            } else {
                fileNameSpan.textContent = 'No file selected';
            }
        }

        function agregar() {
            const fileSelect = document.getElementById('file_type');
            const bookContainer = document.getElementById('book_container');
            const videoContainer = document.getElementById('video_container');
            if (fileSelect.value === '0') {
                alert("Select a valid field");
            }
            if (fileSelect.value === "1") {
                bookContainer.style.display = 'block';
                videoContainer.style.display = 'none';
            } else if (fileSelect.value === "2") {
                bookContainer.style.display = 'none';
                videoContainer.style.display = 'block';
            } else {
                bookContainer.style.display = 'none';
                videoContainer.style.display = 'none';
            }
        }

        // enviar file
        function saveVideo(event) {
            event.preventDefault();
            const videoLink = document.querySelector("#link_video");
            const nameVideo = document.querySelector("#video_name");
            const containerMessage = document.querySelector("#container_message");

            const datos = {
                videolink: videoLink.value,
                nameVideo: nameVideo.value,
                action: 'addvideoyt',
            }
            // texto:


            // codificar
            const codificar = JSON.stringify(datos);
            //envio
            fetch("action.php", {
                    method: 'POST',
                    body: codificar,
                    headers: {
                        'Content-Type': 'application/json',
                    }
                })
                .then(res => res.json())
                .then(res => {
                    if (res.success) {
                        containerMessage.textContent = 'Uploaded successfully';
                        videoLink.value = '';
                        nameVideo.value = '';
                    } else {
                        containerMessage.textContent = res.message;
                        videoLink.value = '';
                        nameVideo.value = '';
                    }
                })
                .catch(error => {
                    console.log('error fech: ', error);
                });
        }
        // save file
        function saveFile(event) {
            event.preventDefault();
            const fileInput = document.querySelector("#file-upload");
            const nameFile = document.querySelector("#name_file");
            const containerMessage = document.querySelector("#container_message");
            const fileNameSpan = document.getElementById("file-name");
            const file = fileInput.files[0]; // Accede al primer archivo seleccionado

            if (!file || nameFile.value.trim() === "") {
                alert("Both fields must be filled out.");
                return; // Detener el proceso si no se cumplen los requisitos
            }

            const formData = new FormData();
            formData.append("image", file);
            formData.append("nameFile", nameFile.value);
            formData.append("action", "addfile");

            // Envío del formulario
            fetch("action.php", {
                    method: "POST",
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        containerMessage.textContent = data.message;
                    } else {
                        containerMessage.textContent = data.message;
                    }
                })
                .catch(error => {
                    console.error("Fetch error:", error);
                });
        }
    </script>

    <?php
    include "page-master/footer.php";
    ?>