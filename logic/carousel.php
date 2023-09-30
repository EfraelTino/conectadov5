<?php
include "conexion.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['avatar_usuario']) && isset($_POST['userid'])) {
        $selectedImage = $_POST['avatar_usuario'];
        $userid = $_POST['userid']; // Obtener el ID del usuario desde la solicitud AJAX
        $sql = "UPDATE chat_users SET avatar = '$selectedImage' WHERE userid = $userid";
        if ($conn->query($sql) === true) {
            echo 'Imagen guardada correctamente y referencia insertada en la base de datos.';
        } else {
            echo 'Error al insertar la referencia en la base de datos.';
        }
    } else {
        echo 'No se ha seleccionado ninguna imagen o no se proporcionó el ID de usuario.';
    }
} else {
    http_response_code(405); // Método no permitido
    exit();
}
?>
