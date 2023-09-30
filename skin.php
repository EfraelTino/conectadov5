<?php 
include ("Chat.php");
$chat = new Chat();
$response = array(); 

$input = file_get_contents("php://input");
$data = json_decode($input);

if ($data->action == 'avatar1') {
    $avatar = $data->avatar;
    $user_id = $data->user_id;
    
    $sql = "UPDATE chat_users SET genero = '$avatar' WHERE id = '$user_id'";
    $result = $chat->dbConnect->execute_query($sql); 

    if ($result) {
        $response['status'] = 'success';
        $response['message'] = 'Avatar updated successfully.';
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Error updating avatar.';
    }
}
echo json_encode($response);
?>