<?php
session_start();
$title = "Conectado";
include('page-master/head.php');
include ('Chat.php');
$chat = new Chat();
if (isset($_SESSION["userid"]) &&  $_SESSION["userid"]) {
    $userid =  $_SESSION["userid"];
} else {
    header("Location: ./");
}

include('page-master/js.php');
?>

<body>
    <div class="container-conectado-logo">
        <img src="textures/conectado_logo.webp" alt="">
    </div>
    <div class="container-skins" id="contColores" hidden>
        <!-- <span class="icon-chevron-right" id="mostrarA" ></span> -->
        <button class="btn_show" id="btnShow" onclick="mostrarA();">Avatar</button>
        <div class="wrap_skins" id="skins_cont" hidden>
            <h2>Select your Avatar</h2>
            <button class="skin_one" data-skin-number="1" onclick="seleccionarA();"><img src="images/King.png" class="skins" alt="primer skin" id="mujer"></button>
            <button class="skin_two" data-skin-number="2" onclick="seleccionarA();"><img src="images/Queen.png" class="skins" alt="segundo skin" id="hombre">></button>

        </div>

    </div>
    <div class="container-skins2" id="contColores" hidden>
        <!-- <span class="icon-chevron-left" id="mostrarC" onclick="mostrarC();"></span> -->
        <button class="btn_show show_2" id="btnShow2" onclick="mostrarC();">Skin</button>
        <div class="wrap_skins2" id="skins_cont2" hidden>
            <h2>Select your skins</h2>
            <button class="skin_one" data-skin-number="1" onclick="seleccionarC();"><img src="images/yellow.png" class="skins" alt="primer skin" id="color1"></button>
            <button class="skin_two" data-skin-number="2" onclick="seleccionarC();"><img src="images/gray.png" class="skins" alt="segundo skin" id="color2">></button>

        </div>

    </div>
    <div class="container-emojis">
        <button id="Saludo" class="emoji-button" hidden>
            <img src="images/han.webp" alt="greeting icon" class="icon-hand">
        </button>
        <button id="Dance" class="emoji-button" hidden>
            <img src="images/dancing.webp" alt="greeting icon" class="icon-greting">
        </button>
        <button id="suggestion_button" class="emoji-button" onclick="showSuggestion();">
            <img src="images/suggestion.webp" alt="greeting icon" class="icon-suggestion">
        </button>
        <button class="btn_sms" onclick="showSms();" hidden>
            <span class="icon-message-circle"></span>
        </button>
        <button class="btn_camera" onclick="logOut();">
            <img src="images/maleta.webp" alt="greeting icon" class="icon-greting">
        </button>

        <button class="btn_logout" onclick="mochila();">
            <span class="icon-log-out"></span>
        </button>
    </div>

    <div class="suggestion-container">
        <div class="conte-suggestion" id="suggestion_container">
            <button class="btn_x" onclick="showSuggestion();"> <span class="icon-x"></span></button>
            <img src="images/logo_conectado.webp" alt="logo conectado" class="logo_conectado">
            <h3 class="suggestion_text">SUGGESTION <strong>BOX</strong></h3>
            <?php
            $sql = "SELECT fname, lastname, username FROM chat_users WHERE userid = '$userid'";
            $stmt = $chat->dbConnect->query($sql);
            if (!$stmt) {
                die("Error en la consulta: " . $chat->dbConnect->error);
            }
            while ($row = $stmt->fetch_assoc()) {
                $fname = $row['fname'];
                $lname = $row['lastname'];
                $completename = $fname . ' ' . $lname;
                $username = $row['username'];
            }
            ?>
            <form action="" method="" id="" class="form_col">
                <input type="text" value="<?php echo $completename ?>" name="fname" id="fname" hidden>
                <input type="text" value="<?php echo $username ?>" name="email" id="email" hidden>
                <textarea type="text" id="input_suggestion" name="input_suggestion" class="input_suggestion" placeholder="PLEASE LEAVE US YOUR COMMENTS OF THE EXPERIENCE IN CONECTADO WORD"></textarea>
                <button type="button" class="send_suggestion" onclick="enviarSugerencia();">SEND</button>
                <div id="respuesta">
                </div>
            </form>

        </div>
    </div>
    <div class="conectado_container">
        <iframe id="vagonFrame" allow="microphone  *; clipboard-read *; clipboard-write *; encrypted-media *;" src="https://streams.vagon.io/streams/3189cfc0-a865-4efb-82c2-431c306c8d6c ">
    </div>

    <?php
    include "page-master/footer.php";
    ?>