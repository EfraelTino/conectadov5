<?php
session_start();
$title = "Conectado";
include('Chat.php');


if (isset($_SESSION["userid"]) &&  $_SESSION["userid"]) {
    $userid =  $_SESSION["userid"];
} else {
    header("Location: ./");
}
include('page-master/js.php');
$chat = new Chat();
?>

<link rel="stylesheet" href="icomoon/style.css">
<link rel="stylesheet" href="backpack.css">

<body style="background: #F7F5F0;">
    <?php
    $sql = "SELECT * FROM chat_users WHERE userid = '$userid'";
    $stmt = $chat->dbConnect->query($sql);
    if (!$stmt) {
        die("Error en la consulta: " . $chat->dbConnect->error);
    }
    while ($row = $stmt->fetch_assoc()) {
        $data[] = $row;
    }
    ?>
    <div class="header_principal">
        <div class="cl-normal">
            <div class="close_containers">

                <div class="containerlogo">
                    <img src="images/logo_conectado.webp" alt="Logo CONECTADO" width="120">
                    <a href="universities" class="options ">List of universities</a>
                    <a href="backpack" class="options">Account</a>
                    <a href="security" class="options">Security</a>
                    <a href="clases-materiales" class="options option-active">Classes and materials</a>
                    <a href="explore" class="options">Explore</a>
                </div>
                <?php
                include('page-master/profile_options.php')
                ?>
            </div>

        </div>

    </div>
    <div class="cl-normal">
        <?php include('options.php') ?>
        <div class="wrap-email">
            <div class="cont-email">
                <p class="prev_text email_t">Classes and materials</p>
            </div>
        </div>
        <div class="wrap_cont_video">
            <div class="wrap-video">
                
            </div>
            <div class="wrap-comments"></div>
        </div>
    </div>


    <?php
    include "page-master/footer.php";
    ?>