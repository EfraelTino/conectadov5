<?php 
if(isset($_FILES['photo'])){
        // $_FILES['photo'] contiene la información del archivo
        $uploadedFile = $_FILES['photo'];
        $fileName = $uploadedFile['name'];
        $fileTmpName = $uploadedFile['tmp_name'];
        $fileSize = $uploadedFile['size'];
        $fileType = $uploadedFile['type'];
        // validación del tipo de archivo
        $allowedExtensions  = ['jpg', 'jpeg', 'png', 'webp']; // Corregido 'jgp' a 'jpg'
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (in_array($fileExtension, $allowedExtensions)) {
            $destination = '../textures/' . $fileName;
            if (move_uploaded_file($fileTmpName, $destination)) {
                $insertUni = $mochila->updatePhotoComplete($nameUni, $locationUni, $linkUni, $fileName, $uni_id);
                // No necesitas imprimir el resultado aquí, solo necesitas enviar una respuesta JSON
                if ($insertUni['success']) {
                    echo json_encode($insertUni);
                } else {
                    $response['success'] = false;
                    $response['message'] = 'Failed to insert university';
                    echo json_encode($response);
                }
            } else {
                $response['success'] = false;
                $response['message'] = 'Error uploading file';
                echo json_encode($response);
            }
        } else {
            $response['success'] = false;
            $response['message'] = 'Invalid file extension';
            echo json_encode($response);
        }
    }