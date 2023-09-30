<?php 
include ("Chat.php");
$chat = new Chat();

$input = file_get_contents("php://input");
$data = json_decode($input);
header('Content-Type: application/json');

if (isset($data->action) && $data->action === 'avatar1'):
    $avatar = $data->avatar;
    $user_id = $data->user_id;
    
    $sql = "UPDATE chat_users SET avatar_user = ? WHERE userid = ?";
    $stmt = $chat->dbConnect->prepare($sql);
    if(!$stmt){
        die("Error en la preparación de la consulta");
    }
    $stmt->bind_param('si', $avatar, $user_id);
    $response = array(); 
    if($stmt->execute()){
        $response['success'] = true;
        $response['message'] = 'Avatar enviado' .$avatar;
    }else{
        $response['success'] = false;
        $response['message'] = 'Oops! ocurrió un error: '. $stmt->error;
    }
    $stmt->close();
    echo json_encode($response);    
endif;

if (isset($data->action) && $data->action === 'avatar2'):
    $avatar = $data->avatar;
    $user_id = $data->user_id;
    
    $sql = "UPDATE chat_users SET avatar_user = ? WHERE userid = ?";
    $stmt = $chat->dbConnect->prepare($sql);
    if(!$stmt){
        die("Error en la preparación de la consulta");
    }
    $stmt->bind_param('si', $avatar, $user_id);
    $response = array(); 
    if($stmt->execute()){
        $response['success'] = true;
        $response['message'] = 'Avatar enviado' .$avatar;
    }else{
        $response['success'] = false;
        $response['message'] = 'Oops! ocurrió un error: '. $stmt->error;
    }
    $stmt->close();
    echo json_encode($response);  
endif;

// seleccion de skin
if (isset($data->action) && $data->action === 'skin1'):
    $skin = $data->skin;
    $user_id = $data->user_id;
    
    $sql = "UPDATE chat_users SET skin_user = ? WHERE userid = ?";
    $stmt = $chat->dbConnect->prepare($sql);
    if(!$stmt){
        die("Error en la preparación de la consulta");
    }
    $stmt->bind_param('si', $skin, $user_id);
    $response = array(); 
    if($stmt->execute()){
        $response['success'] = true;
        $response['message'] = 'Skin enviado' .$skin;
    }else{
        $response['success'] = false;
        $response['message'] = 'Oops! ocurrió un error: '. $stmt->error;
    }
    $stmt->close();
    echo json_encode($response);  
endif;

if (isset($data->action) && $data->action === 'skin2'):
    $skin = $data->skin;
    $user_id = $data->user_id;
    
    $sql = "UPDATE chat_users SET skin_user = ? WHERE userid = ?";
    $stmt = $chat->dbConnect->prepare($sql);
    if(!$stmt){
        die("Error en la preparación de la consulta");
    }
    $stmt->bind_param('si', $skin, $user_id);
    $response = array(); 
    if($stmt->execute()){
        $response['success'] = true;
        $response['message'] = 'Skin enviado' .$skin;
    }else{
        $response['success'] = false;
        $response['message'] = 'Oops! ocurrió un error: '. $stmt->error;
    }
    $stmt->close();
    echo json_encode($response);  
endif;

?>
