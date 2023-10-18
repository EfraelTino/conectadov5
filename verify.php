
<?php
include "Chat.php";

use PHPMailer\PHPMailer\PHPMailer;

require 'vendor/autoload.php';
$chat = new Chat();

if (isset($_GET['asc'])) { // Cambiado de $_POST a $_GET
    $email = $_GET['asc']; // Cambiado de $_POST a $_GET

    $email_decode = base64_decode($email);
    $decodedEmail = $chat->dbConnect->real_escape_string($email_decode); // Escapar caracteres especiales
    $select_sql2 = "SELECT * FROM chat_users WHERE username = '$decodedEmail'";
    $result = $chat->dbConnect->query($select_sql2);
    if ($result) {
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Accede a los datos del resultado
                $userid = $row['userid'];
                $username = $row['username'];
                $fname = $row['fname'];
                $lname = $row['lastname'];
                $encodedEmail = base64_encode($decodedEmail);
                // 3->verificar
                $nb = 3;
                $encod_nb = base64_encode($nb);
                $sms = "Hi $email_decode, we have successfully verified your email, you can log in";
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
                $mail->setFrom('noreply@puntoarcade.com', 'conectado.com');
                //$mail->addReplyTo('noreply@puntoarcade.com', 'VIVO app');
                $mail->addAddress($email_decode, 'TU REGISTRO vivo ESTA CREADO!!!');
                $mail->Subject = 'Conectado Verification';
                $mail->msgHTML(file_get_contents('message.html'), __DIR__);
                $mail->Body = $cuerpo;

                if (!$mail->send()) {
                    // echo 'Error : ' . $mail->ErrorInfo;
                    // 1 ->error_clear_last
                    $nb = 1;
                    $encod_nb = base64_encode($nb);
                    $sms = "An error occurred, please try again later";
                    $encod_sms = base64_encode($sms);
                    echo "Error: " . $mail->ErrorInfo;
                    // header("Location: count_confirmation?verify=$nb&sms=$encod_sms");
                } else {

                    // 2 -> success
                    $nb = 2;
                    $encod_nb = base64_encode($nb);
                    $sms =   'A confirmation message was sent to your email, confirm your email and log in';
                    $encod_sms = base64_encode($sms);
                    header("Location: account_confirmation?verify=$nb&sms=$encod_sms");
                }
            }
        } else {
            // No se encontraron resultados
        }
    } else {
        // Error en la consulta
        echo "Error en la consulta: " . $chat->dbConnect->error;
    }
} else {
    echo "no llega nada";
}
