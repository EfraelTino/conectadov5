<?php
$title = "Account confirmation";
include('Chat.php');
$chat = new Chat();
include('page-master/head.php');

if (isset($_GET['verify'])  && isset($_GET['sms'])) {
    $encod_nb = $_GET['verify'];
    $encod_sms = $_GET['sms'];

    $nb = base64_decode($encod_nb);
    $sms = base64_decode($encod_sms);
    if ($nb == 3) { // Verifica que nb sea igual a 3
        if (isset($_GET['as'])) {
            $email_enc = $_GET['as'];
            $email = base64_decode($email_enc);
        }
    }else {
        header('location : index');
    }
} else {
    header("location: index");
}
include('page-master/js.php');
?>

<body>


    <div class="container-login">
        <div class="login-form">
            <?php if ($nb == 1) { ?>
                <div class="form-login-container">
                    <div>
                        <div class="form-groups">
                            <div style="font-size: 18px;"><?php echo $sms; ?></div>
                        </div>
                        <div class="form-groups grupo_button">
                            <a href="index" name="login" class="btn-login" style="display: flex; justify-content: center; align-items: center;">SIGN IN</a>
                        </div>
                        </form>
                        <div class="form-groups copy_form">
                            <span class="copy">Copyright © Conectado 2023 </span>
                        </div>
                    </div>
                </div>
            <?php
            } else if ($nb == 2) { ?>
                <div class="form-login-container">
                    <div>
                        <div class="form-groups">
                            <div style="font-size: 18px;"><?php echo $sms; ?></div>
                        </div>as
                        <div class="form-groups grupo_button">
                            <a href="index" name="login" class="btn-login" style="display: flex; justify-content: center; align-items: center;">SIGN IN</a>
                        </div>
                        </form>
                        <div class="form-groups copy_form">
                            <span class="copy">Copyright © Conectado 2023 </span>
                        </div>
                    </div>
                </div>
                <?php
            } else if ($nb == 3) {
                $sql_search = "SELECT is_verified, username, userid FROM chat_users WHERE username = '$email'";
                $execute = $chat->dbConnect->query($sql_search);
                if (!$execute) {
                    die("Error en la consulta: " . $chat->dbConnect->error);
                }
                if ($execute->num_rows > 0) {
                    $row = $execute->fetch_assoc();
                    $is_verified = $row['is_verified'];
                    $userid= $row['userid'];
                    if ($is_verified == 0) { 
                        $verificar=1;
                        $sql_up = "UPDATE chat_users SET is_verified = ? WHERE userid= ?";
                        $execute = $chat->dbConnect->prepare($sql_up);
                        if (!$execute) {
                            die("Error en la consulta: " . $chat->dbConnect->error);
                        }
                        $execute->bind_param('ii', $verificar, $userid);
                        $execute->execute();
                        ?>
                        <div class="form-login-container">
                            <div>
                                <div class="form-groups">
                                    <div style="font-size: 18px;"><?php echo $sms; ?></div>
                                </div>
                                <div class="form-groups grupo_button">
                                    <a href="index" name="login" class="btn-login" style="display: flex; justify-content: center; align-items: center;">SIGN IN</a>
                                </div>
                                </form>
                                <div class="form-groups copy_form">
                                    <span class="copy">Copyright © Conectado 2023 </span>
                                </div>
                            </div>
                        </div>
                    <?php } else {
                        // Se encontraron resultados, lo que significa que el correo electrónico existe en la base de datos
                        header('location: index');
                    }
                } else {
                    ?>
                    <div class="form-login-container">
                        <div>
                            <div class="form-groups">
                                <div style="font-size: 18px;"> Something went wrong try again later.</div>
                            </div>
                            <div class="form-groups grupo_button">
                                <a href="index" name="login" class="btn-login" style="display: flex; justify-content: center; align-items: center;">SIGN IN</a>
                            </div>
                            </form>
                            <div class="form-groups copy_form">
                                <span class="copy">Copyright © Conectado 2023 </span>
                            </div>
                        </div>
                    </div>
            <?php
                }
            }
            ?>


        </div>


        <?php
        include "page-master/footer.php";
        ?>