<?php
session_start();
include ('Chat.php');
$chat = new Chat();
if($_POST['action'] == 'update_user_list') {
	$chatUsers = $chat->chatUsers($_SESSION['userid']);
	$data = array(
		"profileHTML" => $chatUsers,	
	);
	echo json_encode($data);	
}
if($_POST['action'] == 'insert_chat') {
	
	$chat->insertChat($_POST['to_user_id'], $_SESSION['userid'], $_POST['chat_message'], $_POST['lugar']);
	echo json_encode($data);
	
}
if($_POST['action'] == 'show_chat') {
	$chat->showUserChat($_SESSION['userid'], $_POST['to_user_id']);
	echo json_encode($data);	
}
// ver chat personal
if($_POST['action'] == 'ver_char_personal'){
	$chat->verChatPeronal($_SESSION['userid'], $_POST['to_user_id']);
	echo json_encode($data);
}
if($_POST['action'] == 'update_user_chat') {
	$conversation = $chat->getUserChat($_SESSION['userid'], $_POST['to_user_id']);
	$lugarUsuario="";
	$tipoAvatar="";
	$estadoUsuario="";
	$data = array(
		"conversation" => $conversation,		
		// "lugarUsuario" => $lugarUsuario,
		// "tipoAvatar" => $tipoAvatar,
		// "estadoUsuario" => $estadoUsuario,
	);
	echo json_encode($data);
}
if($_POST['action'] == 'update_unread_message') {
	$count = $chat->getUnreadMessageCount($_POST['to_user_id'], $_SESSION['userid']);
	$data = array(
		"count" => $count,	
	);
	echo json_encode($data);
}

if($_POST['action'] == 'update_typing_status') {
	$chat->updateTypingStatus($_POST["is_type"], $_SESSION["login_details_id"]);
	echo json_encode($data);	
}
if($_POST['action'] == 'show_typing_status') {
	$message = $chat->fetchIsTypeStatus($_POST['to_user_id']);
	$data = array(
		"message" => $message			
	);
	echo json_encode($data);
}

// actualizar la ubicación del usuario en DB
if ($_POST['action'] == 'actualizar_lugar_usuario') {
    $lugar = $chat->actualizarLugarUsuario($_POST['lugar'], $_SESSION['userid']);

    // Crear un array con el estado actualizado
    $response = array(
        "lugar" => $lugar
    );

    // Convertir el array en JSON
    $jsonResponse = json_encode($response);

    // Enviar la respuesta al front-end
    echo $jsonResponse;
}

?>