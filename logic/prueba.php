<?php
// Conexión a la base de datos
include("conexion.php");

// Obtener los datos del formulario
$avatar = $_POST['avatar'];

// Ruta del archivo seleccionado
$archivoSeleccionado = './' . $avatar;

// Ruta de destino del archivo
$archivoDestino = './avatar/' . basename($avatar);

// Mover el archivo a la carpeta de destino
if (file_exists($archivoSeleccionado)) {
    if (copy($archivoSeleccionado, $archivoDestino)) {
        // Insertar el registro en la base de datos
        $id = 12;
        $sql = "UPDATE chat_users SET avatar = '$archivoDestino' WHERE userid = $id";

        if ($conn->query($sql) === TRUE) {
            echo "Avatar guardado exitosamente.";
        } else {
            echo "Error al guardar el avatar: " . $conn->error;
        }
    } else {
        echo "Error al mover el archivo de avatar.";
    }
} else {
    echo "El archivo de avatar seleccionado no existe.";
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
