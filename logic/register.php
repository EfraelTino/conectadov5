<?php
include "../Chat.php";
session_start();
$chat = new Chat();
$conn = $chat->getDBConnect();
$fname = mysqli_real_escape_string($conn, $_POST['fname']);
$lname = mysqli_real_escape_string($conn, $_POST['lname']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$password = mysqli_real_escape_string($conn, $_POST['password']);
$avatar_user = mysqli_real_escape_string($conn, $_POST['testimonial']);

$nombre_archivo_actual = basename($avatar_user);
$ruta_avatar = '../avatar/';
$nuevo_file =$ruta_avatar . $nombre_archivo_actual;
// echo $nuevo_file;

if (!empty($fname) && !empty($lname) && !empty($email) && !empty($password)) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $sql = mysqli_query($conn, "SELECT * FROM chat_users WHERE username = '{$email}'");
        if (mysqli_num_rows($sql) > 0) {
            echo "$email - This email already exists!";
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
                            $insert_query = mysqli_query($conn, "INSERT INTO chat_users (fname, lastname, username, password, img_profile, avatar)
                            VALUES ('{$fname}', '{$lname}', '{$email}', '{$encrypt_pass}', '{$new_img_name}', '{$nuevo_file}')");
                            if ($insert_query) {
                                $select_sql2 = mysqli_query($conn, "SELECT * FROM chat_users WHERE username = '{$email}'");
                                if (mysqli_num_rows($select_sql2) > 0) {
                                    $_SESSION['username'] = $user[0]['username'];
                                    $_SESSION['userid'] = $user[0]['userid'];
                                    $chat->updateUserOnline($user[0]['userid'], 1);
                                    $lastInsertId = $chat->insertUserLoginDetails($user[0]['userid']);
                                    $_SESSION['login_details_id'] = $lastInsertId;
                                    header("Location:../index");
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
