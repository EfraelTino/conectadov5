<?php
include('./Mochila.php');
$mochila = new Mochila();
$response = array();


if (isset($_POST['action']) && $_POST['action'] === 'search_uni') {
    if (isset($_POST['input_search'])) {
        $data = $_POST['input_search'];
        $searchResults = $mochila->searchUni($data);

        // Devolver solo los resultados en formato JSON
        echo $searchResults;
    } else {
        $response['success'] = true;
        $response['message'] = 'Error al recibir los datos';
        echo json_encode($response);
    }
}


if (isset($_POST['action']) && $_POST['action'] === 'adduni') {
    $nameUni = $_POST['nameUni'];
    $locationUni = $_POST['locationUni'];
    $linkUni = $_POST['linkUni'];

    if (isset($_FILES['photo'])) {
        // $_FILES['photo'] contiene la información del archivo
        $uploadedFile = $_FILES['photo'];
        $fileName = $uploadedFile['name'];
        $fileTmpName = $uploadedFile['tmp_name'];
        $fileSize = $uploadedFile['size'];
        $fileType = $uploadedFile['type'];
        // validación del tipo de archivo
        $allowedExtensions  = ['jpg', 'jpeg', 'png', 'webp'];
        if ($allowedExtensions) {
            $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            if (in_array($fileExtension, $allowedExtensions)) {
                $destination = '../textures/' . $fileName;
                move_uploaded_file($fileTmpName, $destination);
                $insertUni = $mochila->insertMochila($nameUni, $locationUni, $linkUni, $fileName);

                if ($insertUni) {
                    $response['success'] = true;
                    $response['message'] = 'University added successfully';
                } else {
                    $response['success'] = false;
                    $response['message'] = 'Failed to insert university';
                }
            } else {
                $response['success'] = false;
                $response['message'] = 'Invalid file extension';
            }
        } else {
            $response['success'] = false;
            $response['message'] = 'Archivo no permitido';
        }
    } else {
        $response['success'] = false;
        $response['message'] = 'No se a cargado ningún archivo';
    }
    echo json_encode($response);
}
// select uni
if (isset($_POST['action']) && $_POST['action'] === 'traeruni') {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $sql = "SELECT * FROM universities WHERE id = '$id'";
        $stmt = $mochila->dbConnect->query($sql);
        if (!$stmt) {
            die("Error en la consulta: " . $mochila->dbConnect->error);
        }
        while ($row = $stmt->fetch_assoc()) {
            $response[] = $row;
        }
        echo json_encode($response);
    } else {
        $response['success'] = true;
        $response['message'] = 'El id no coincide';
        echo json_encode($response);
    }
}
// update uni
if (isset($_POST['action']) && $_POST['action'] === 'edituni') {
    $nameUni = $_POST['nameUni'];
    $locationUni = $_POST['locationUni'];
    $linkUni = $_POST['linkUni'];
    $uni_id = $_POST['uni_id'];

    if (isset($_FILES['photo'])) {
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
                $updatephoto = $mochila->updatePhotoComplete($nameUni, $locationUni, $linkUni, $fileName, $uni_id); // Pasar $fileName en lugar de $fileExtension
                echo $updatephoto;
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
    } else {
        // solo actualizar la mita
        $updatephoto = $mochila->updatePhoto($nameUni, $locationUni, $linkUni, $uni_id);
        echo $updatephoto;
    }
}


/*traer profile user
*/
if (isset($_POST['action']) && $_POST['action'] == 'update_profile') {
    if ($_POST['id_user']) {
        $id_user = $_POST['id_user'];
        $searchUser = $mochila->searchUser($id_user);
        echo $searchUser;
    } else {
        $response['success'] = false;
        $response['message'] = 'User not found';
        echo json_encode($response);
    }
}

/*
edit DATA
*/

if (isset($_POST['action']) && $_POST['action'] == 'editdata') {
    $id_user = intval($_POST['id_user']); // Conviértelo a entero
    $especify = $_POST['especifiq'];
    switch ($especify) {
        case 'profedit':
            $profession = $_POST['profession'];
            $editprofession = $mochila->editProfession($profession, $id_user);
            echo $editprofession;
            break;
        case 'nameedit':
            $lnmae = $_POST['lname'];
            $fnmae = $_POST['fname'];
            $editname = $mochila->editName($lnmae, $fnmae, $id_user);
            break;
        case 'emailedit':
            $useremail = $_POST['useremail'];
            $editname = $mochila->editEmail($useremail, $id_user);
            break;
        case 'phoneedit':
            $phone = $_POST['userphone'];
            $editphone = $mochila->editPhone($phone, $id_user);
            break;
        case 'uniedit':
            $uni = $_POST['university'];
            $editphone = $mochila->editUni($uni, $id_user);
            break;
        case 'dataedit':
            $identificacion = $_POST['identificacion'];
            $nationality = $_POST['nationality'];
            $sexo = $_POST['sexo'];
            $editphone = $mochila->editData($identificacion, $nationality, $sexo, $id_user);
            break;
        case 'editaddress':
            $address = $_POST['address'];
            $country = $_POST['country'];
            $city = $_POST['city'];
            $editphone = $mochila->editAddress($address, $country, $city, $id_user);
            break;
    }
}

if (isset($_POST['action']) && $_POST['action'] === 'editaravatar') {

    $iduser =$_POST['id_user'];
    $cambiar = $_POST['cambiar'];
    if (isset($_FILES['imageavatar'])) {

        $uploadedFile = $_FILES['imageavatar'];
        $fileName = $uploadedFile['name'];
        $fileTmpName = $uploadedFile['tmp_name'];
        $fileSize = $uploadedFile['size'];
        $fileType = $uploadedFile['type'];

        $allowedExtensions  = ['jpg', 'jpeg', 'png', 'webp'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        if (in_array($fileExtension, $allowedExtensions)) {

            $destination = '../userpics/' . $fileName;
            if (move_uploaded_file($fileTmpName, $destination)) {
                $updatecaracter = $mochila->updateCaracter($fileName, $iduser, $cambiar);
                echo $updatecaracter;
            }else{
                $response['success'] = false;
                $response['message'] = 'Error uploading file';
                echo json_encode($response);
            }
            }else{
                $response['success'] = false;
                $response['message'] = 'Invalid file extension';
                echo json_encode($response);
            }
    }
}