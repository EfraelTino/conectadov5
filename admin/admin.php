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
        justify-content: space-between  ;
        padding: 10px 13px;
        transition: var(--transition300);
        width: 210px;
        font-weight: 600;
        font-size: 18px;
    }
    .add_new span{
        color: white;
        font-size: 18px;
    }

    .add_new:hover {
        transform: scale(1.04);
    box-shadow: 0px 8px 10px -4px rgba(0, 0, 0, .4);
    }

    .add_new:active {
        transform: scale(0.90);
        background-color: var(--color-ausente);
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
                YOUR BACKPACK
            </h3>


            <div class="wrap-data">
                <div class="cont_wrap_tow">
                    <div class="cont_wrap">
                        <h4>
                            Your boock and more
                        </h4>
                        <div class="books">
                            <?php
                            $sql = "SELECT * FROM mochila WHERE tipo = 1";
                            $stmt = $chat->dbConnect->query($sql);

                            if (!$stmt) {
                                die("Error en la consulta: " . $chat->dbConnect->error);
                            }

                            if ($stmt->num_rows > 0) {
                                while ($row = $stmt->fetch_assoc()) {
                            ?>
                                    <a href="source/<?php echo $row['recurso'] ?>" class="view_src" target="_blank" download="<?php echo $row['recurso'] ?>">
                                        <span class="icon-download ico_c"></span>
                                        <?php echo $row['nombre']; ?>
                                    </a>
                            <?php
                                }
                            } else {
                                echo "<p class='view_src ss'>No files were found</p>";
                            }
                            ?>
                        </div>
                            <div class="containadd">
                                <form action="">

                                </form>
                            </div>
                    </div>
                    <div class="cont_wrap">
                        <h4>
                            Your videos
                        </h4>
                        <div class="videos">
                        <?php
                            $sql = "SELECT * FROM mochila WHERE tipo = 2";
                            $stmt = $chat->dbConnect->query($sql);

                            if (!$stmt) {
                                die("Error en la consulta: " . $chat->dbConnect->error);
                            }

                            if ($stmt->num_rows > 0) {
                                while ($row = $stmt->fetch_assoc()) {
                            ?>
                                    <a href="<?php echo $row['recurso'] ?>" class="view_src" target="_blanck">
                                <span class="icon-eye ico_c"></span>
                                <?php echo $row['nombre']; ?></a>
                            <?php
                                }
                            } else {
                                echo "<p class='view_src ss'>No files were found</p>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="cont_add_new">
            <a href="select.php" class="add_new">Add new <span class="icon-file-plus"></span></a>
        </div>

    </div>
    <?php
    include "page-master/footer.php";
    ?>