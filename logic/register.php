<?php
include "../Chat.php";

use PHPMailer\PHPMailer\PHPMailer;

require '../vendor/autoload.php';
session_start();
$chat = new Chat();
$conn = $chat->getDBConnect();
$fname = mysqli_real_escape_string($conn, $_POST['fname']);
$lname = mysqli_real_escape_string($conn, $_POST['lname']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);

$nombre_archivo_actual = basename($avatar_user);
$ruta_avatar = '../avatar/';
$nuevo_file = $ruta_avatar . $nombre_archivo_actual;
// echo $nuevo_file;

if (!empty($fname) && !empty($lname) && !empty($email) && !empty($password)) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $sql = mysqli_query($conn, "SELECT * FROM chat_users WHERE username = '{$email}'");
        if (mysqli_num_rows($sql) > 0) {
            $res = "$email - This email already exists! ";
            $res_encoded = urlencode($res);
            header("Location: ../register?res=$res_encoded");
        } else {
            // Validar y procesar la imagen aquí
            if (isset($_FILES['image'])) {
                $img_name = $_FILES['image']['name'];
                $img_type = $_FILES['image']['type'];
                $tmp_name = $_FILES['image']['tmp_name'];

                $img_explode = explode('.', $img_name);
                $img_ext = end($img_explode);

                $extensions = ["jpeg", "png", "jpg"];
                if (in_array($img_ext, $extensions) === true) {
                    $types = ["image/jpeg", "image/jpg", "image/png"];
                    if (in_array($img_type, $types) === true) {
                        $time = time();
                        $new_img_name = $time . $img_name;
                        if (move_uploaded_file($tmp_name, "../userpics/" . $new_img_name)) {
                            $encrypt_pass = md5($password);
                            $insert_query = mysqli_query($conn, "INSERT INTO chat_users (fname, lastname, username, password, img_profile, avatar, is_verified)
                            VALUES ('{$fname}', '{$lname}', '{$email}', '{$encrypt_pass}', '{$new_img_name}', '{$nuevo_file}', 0)");
                            if ($insert_query) {
                                $select_sql2 = mysqli_query($conn, "SELECT * FROM chat_users WHERE username = '{$email}'");
                                if (mysqli_num_rows($select_sql2) > 0) {
                                    $encodedEmail = base64_encode($email);
                                    // 3->verificar
                                    $nb = 3;
                                    $encod_nb = base64_encode($nb);
                                    $sms = "Hi $email, we have successfully verified your email, you can log in";
                                    $encod_sms = base64_encode($sms);
                                    $cuerpo = " 
                                    <!DOCTYPE HTML>
                                    <html>
                                    
                                    <head>
                                        <title>Conectado Verification</title>
                                    </head>
                                    
                                    <body>
                                        <div style='width: 100%;
                                        display: flex;
                                        text-align: center;
                                        justify-content: center;'>
                                            <div style='background-color: #e8fffa; border-radius: 20px; padding: 10px;'>
                                                <h1 style='color: #26b999;'><strong>Verification required</strong></h1>
                                                <img src='https://i0.wp.com/conectado.com/wp-content/uploads/2022/07/Conectado-logo-full-transparent-reduced-1.png?fit=500%2C284&ssl=1'
                                                    alt='Logo conectado' style='width: 120px;'>
                                                <p style='color: #0d1a35;'>
                                                    <b style='color: #0d1a35;'> $fname $lname, in order to complete your registration or reactivate your
                                                        account on Conectado, you
                                                        need to confirm your email address by clicking the button below
                                                    </b>
                                                </p>
                                                <a href='http://localhost/conectadov5ee2/account_confirmation?verify=$encod_nb&sms=$encod_sms&as=$encodedEmail' style='background-color: #26b999; color: #ffffff;padding: 5px 20px;
                                                border: none;
                                                border-radius: 4px;
                                                font-size: 13px;
                                                color: #fff;
                                                text-decoration: none;
                                                white-space: nowrap;
                                                '>Confirm Email</a>
                                            </div>
                                        </div>
                                    </body>
                                    
                                    </html>
        ";
                                    $mail = new PHPMailer;
                                    $mail->isSMTP();
                                    $mail->SMTPDebug = 0;
                                    $mail->Host = 'smtp.hostinger.com';
                                    $mail->Port = 587;
                                    $mail->SMTPAuth = true;
                                    $mail->Username = 'noreply@puntoarcade.com';
                                    $mail->Password = 'Cocorilow.1';
                                    $mail->setFrom('noreply@puntoarcade.com', 'puntoarcade.com');
                                    //$mail->addReplyTo('noreply@puntoarcade.com', 'VIVO app');
                                    $mail->addAddress($email, 'TU REGISTRO vivo ESTA CREADO!!!');
                                    $mail->Subject = 'Conectado Verification';
                                    $mail->msgHTML(file_get_contents('message.html'), __DIR__);
                                    $mail->Body = $cuerpo;
                                    //$mail->addAttachment('test.txt');
                                    if ($i == $veces) {
                                        if (!$mail->send()) {
                                            // echo 'Error : ' . $mail->ErrorInfo;
                                            // 1 ->error_clear_last
                                            $nb = 1;
                                            $encod_nb = base64_encode($nb);
                                            $sms = "An error occurred, please try again later";
                                            $encod_sms = base64_encode($sms);
                                            header("Location: ../account_confirmation?verify=$nb&sms=$encod_sms");
                                        } else {

                                            // 2 -> success
                                            $nb = 2;
                                            $encod_nb = base64_encode($nb);
                                            $sms =   'A confirmation message was sent to your email, confirm your email and log in';
                                            $encod_sms = base64_encode($sms);
                                            header("Location: ../account_confirmation?verify=$nb&sms=$encod_sms");
                                        }
                                    }
                                    // header("Location:../index");
                                } else {
                                    echo "This email address does not exist!";
                                }
                            } else {
                                echo "Something went wrong. Try again!";
                            }
                        }
                    } else {
                        echo "Upload an image file: jpeg, png, jpg";
                    }
                } else {
                    echo "Upload an image file: jpeg, png, jpg";
                }
            }
        }
    } else {
        echo "$email is not a valid email!";
    }
} else {
    echo "All input fields are required!";
}
