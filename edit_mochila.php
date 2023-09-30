<?php

use function PHPSTORM_META\type;

session_start();
$title = "Edit";
include('Chat.php');
include('page-master/head.php');
include('page-master/js.php');
$chat = new Chat();
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $userid = $_GET['id'];
} else {
    header("Location: mochila");
}
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

    .text_input {
        color: #ffffff;
    }

    .input_date {
        width: 100%;
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

    input[readonly] {
        background-color: #27B99A90;
        /* Cambia este color según tu preferencia */
        color: var(--color-neutro);
        /* Cambia el color del texto si es necesario */
    }

    .wrap_butt {
        display: flex;
        justify-content: end;
        margin-bottom: 8px;
        margin-top: 4px;
    }

    .edit_mochila {
        background-color: var(--color-en-linea);
        color: white;
        padding: 6px 24px;
        font-weight: 600;
        font-size: 20px;
        border-radius: 4px;
        border: 3px solid var(--color-en-linea);
        transition: var(--transition300);
    }

    .edit_mochila:hover,
    .edit_mochila:hover .ic_e {
        background-color: white;
        color: var(--color-en-linea);
    }

    .cancel {
        background-color: var(--color-error);
        border: 3px solid var(--color-error);
        margin: 0px 12px;
    }

    .cancel:hover,
    .cancel:hover .ic_e {
        color: var(--color-error);
        background: white;
    }

    .ic_e {
        color: white;
    }

    .ic_b {
        color: var(--color-en-linea);
        font-size: 40px;
    }

    .ic_book {
        color: var(--color-ausente);
        font-size: 40px;
    }

    .cont_wraps {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    .ic_d {
        color: var(--color-ausente);
        font-size: 20px;
    }

    .text_book {
        color: white;
        font-size: 20px;
        font-weight: 500;
        color: var(--color-ausente);
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
        <form action="logic/edit_mochila.php" method="get">
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
                    GENERAL DATA
                </h3>


                <div class="wrap-data">

                    <div class="cont_wrap_tow">
                        <div class="cont_wrap">
                            <p class="text_input">Name*</p>
                            <input type="number" name="userid" value="<?php echo $userid ?>" hidden>
                            <input type="text" required value="<?php echo $fname; ?>" class="input_date" name="name">
                        </div>
                        <div class="cont_wrap">
                            <p class="text_input">Last Name*</p>
                            <input type="text" required value="<?php echo $lname; ?>" class="input_date" name="lastname">
                        </div>
                    </div>
                    <div class="cont_wrap_tow">
                        <div class="cont_wrap">
                            <p class="text_input">Email*</p>
                            <input type="text" required value="<?php echo $username ?>" class="input_date" readonly name="username">
                        </div>
                        <div class="cont_wrap">
                            <p class="text_input">Document*</p>
                            <input type="text" required value="<?php echo $doc; ?>" class="input_date" placeholder="<?php if ($doc == ' ' || $doc == null) {
                                                                                                                echo "Your document";
                                                                                                            } else {
                                                                                                                echo "";
                                                                                                            } ?>" name="document">
                        </div>
                        <div class="cont_wrap">
                            <p class="text_input">Password*</p>
                            <?php  ?>
                            <input type="password" placeholder="Your password" required class="input_date" name="pass">
                        </div>
                    </div>
                    <div class="cont_wrap_tow">
                        <div class="cont_wrap">
                            <p class="text_input">Institute*</p>
                            <input type="text" required value="<?php echo $insti; ?>" class="input_date" placeholder="<?php if ($insti == ' ' || $insti == null) {
                                                                                                                    echo "Your Institute";
                                                                                                                } else {
                                                                                                                    echo "";
                                                                                                                } ?>" name="institute">
                        </div>
                        <div class="cont_wrap">
                            <p class="text_input">Birthdate*</p>
                            <input type="text" required value="<?php echo $birthda; ?>" class="input_date" placeholder="<?php if ($birthda == ' ' || $insti == null) {
                                                                                                                    echo "DD/MM/YY";
                                                                                                                } else {
                                                                                                                    echo "";
                                                                                                                } ?>" name="birth">
                        </div>
                        <div class="cont_wrap">
                            <p class="text_input">Gender*</p>
                            <input type="text" required value="<?php if ($sexo == '' || $sexo == null) {
                                                            echo "";
                                                        } else {
                                                            echo $sexo;
                                                        } ?>" class="input_date" placeholder="<?php if ($sexo == '' || $sexo == null) {
                                                                                                    echo "Your gender";
                                                                                                } else {
                                                                                                    echo "";
                                                                                                } ?>"  name="sexo">
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <h3 style="color: white; font-weight: 800; font-size: 2rem; text-align: center;">
                    CURRENT ADDRESS
                </h3>


                <div class="wrap-data">
                    <div class="cont_wrap_tow">
                        <div class="cont_wrap">
                            <p class="text_input">Address*</p>
                            <input type="text" required value="<?php echo $address; ?>" class="input_date" placeholder="<?php if ($address == ' ' || $address == null) {
                                                                                                                    echo "Your address";
                                                                                                                } else {
                                                                                                                    echo "";
                                                                                                                } ?>" name="address">
                        </div>
                        <div class="cont_wrap">
                            <p class="text_input">Country*</p>
                            <input type="text" required value="<?php echo $country; ?>" class="input_date" placeholder="<?php if ($country == ' ' || $country == null) {
                                                                                                                    echo "Your country";
                                                                                                                } else {
                                                                                                                    echo "";
                                                                                                                } ?>" name="country">
                        </div>
                        <div class="cont_wrap">
                            <p class="text_input">City*</p>
                            <input type="text" required value="<?php echo $city; ?>" class="input_date" placeholder="<?php if ($city == ' ' || $city == null) {
                                                                                                                echo "Your country";
                                                                                                            } else {
                                                                                                                echo "";
                                                                                                            } ?>" name="city">
                        </div>
                    </div>
                </div>
            </div>
            <div class="wrap_butt">
                <a href="mochila" class="edit_mochila cancel">
                    <span class="icon-arrow-left ic_e"></span> Cancel
                </a>
                <button type="submit" class="edit_mochila save">
                    Save <span class="icon-save ic_e"></span>
                </button>
            </div>
        </form>
    </div>
    <?php
    include "page-master/footer.php";
    ?>