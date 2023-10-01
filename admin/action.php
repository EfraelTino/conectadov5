<?php

include('Chat.php');
$chat = new Chat();

$input = file_get_contents("php://input");
$data = json_decode($input);
header('Content-Type: application/json');

if (isset($data->action) && $data->action === 'addvideoyt') :
    $videoLink = $data->videolink;
    $nameVideo = $data->nameVideo;
    $sql = 'insert into mochila (nombre, recurso) values (?, ?)';
    $stmt = $chat->dbConnect->prepare($sql);
    if (!$stmt) {
        die("Error en la preparación de la consulta");
    }
    $stmt->bind_param('ss', $videoLink, $nameVideo);
    $response = array();
    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Se realizó la inserción';
    } else {
        $response['success'] = false;
        $response['message'] = 'Error';
        $stmt->error;
    }
    $stmt->close();
    echo json_encode($response);
endif;



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si se ha enviado la acción correcta
    $input = file_get_contents("php://input");
    $data = json_decode($input);
    header('Content-Type: application/json');
    $response = array();

    if (isset($data->action) && $data->action === 'addfile') {
        $fileUpload = $data->uploadFile;
        $nameFile = $data->nameFile;

        // Validar que se ha seleccionado un archivo
        if (!empty($_FILES['image']) && !empty($_FILES['image']['name'])) {
            $nombre_archivo_actual = basename($_FILES['image']['name']);
            $ruta_source = '../source/';
            $nuevo_archivo = $ruta_source . $nombre_archivo_actual;

            $img_explode = explode('.', $nombre_archivo_actual);
            $img_ext = strtolower(end($img_explode));
            $extensiones_permitidas = array('jpeg', 'png', 'jpg', 'pdf');

            if (in_array($img_ext, $extensiones_permitidas)) {
                if (move_uploaded_file($_FILES['image']['tmp_name'], $nuevo_archivo)) {
                    require_once 'conexion.php'; // Reemplaza esto por tu archivo de conexión
                    $tipo = 2;
                    $sql = "INSERT INTO mochila (nombre, recurso, tipo) VALUES (?, ?, ?)";
                    $stmt = $chat->dbConnect->prepare($sql);

                    if ($stmt) {
                        $stmt->bind_param('sss', $nameFile, $nombre_archivo_actual, $tipo);

                        if ($stmt->execute()) {
                            $response['success'] = true;
                            $response['message'] = 'Archivo subido, movido y registrado exitosamente.';
                        } else {
                            $response['success'] = false;
                            $response['message'] = 'Error al insertar en la base de datos: ' . $stmt->error;
                        }

                        $stmt->close();
                    } else {
                        $response['success'] = false;
                        $response['message'] = 'Error en la preparación de la consulta';
                    }
                } else {
                    $response['success'] = false;
                    $response['message'] = 'Error al mover el archivo a la carpeta de destino.';
                }
            } else {
                $response['success'] = false;
                $response['message'] = 'Extension de archivo no permitida. Solo se permiten archivos JPEG, PNG, JPG y PDF.';
            }
        } else {
            $response['success'] = false;
            $response['message'] = 'No se ha seleccionado ningún archivo.';
        }
    } else {
        $response['success'] = false;
        $response['message'] = 'Acción no válida.';
    }

    echo json_encode($response);
}

if(isset($_GET['action']) && $_GET['action'] =='eliminarvideo'){
    $id=$_GET['id'];
    $ejecutar= $chat->deleteVideo($id);
    if($ejecutar){
        header("location: classes");
    }else{
        echo "error";
    }
}
?>
