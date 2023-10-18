<?php
class Chat
{
	
	//DATABASE CONNECTION LOCALHOST
	private $host  = "localhost";
	private $user  = 'root';
	private $password   = "";
	private $database  = "php_chat_1";
	
	//DATA BASE CONNECTION SERVER
		//  private $host  = 'localhost';
		//  private $password   = "Cocorilow.1";
		//  private $user  = 'u960900126_saproducciones';
		//  private $database  = "u960900126_hondabd";


	private $chatTable = 'chat';
	private $chatUsersTable = 'chat_users';
	private $chatLoginDetailsTable = 'chat_login_details';

	public $dbConnect;
	public function __construct()
	{
		$this->dbConnect = new mysqli($this->host, $this->user, $this->password, $this->database);
		if ($this->dbConnect->connect_error) {
			die("Error failed to connect to MySQL: " . $this->dbConnect->connect_error);
		}
	}
	public function getDBConnect()
	{
		return $this->dbConnect;
	}
	private function getData($sqlQuery)
	{
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if (!$result) {
			die('Error in query: ' . mysqli_error($this->dbConnect));
		}
		$data = array();
		/*while ($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {*/
		while ($row = mysqli_fetch_assoc($result)) {
			$data[] = $row;
		}
		return $data;
	}
	private function getNumRows($sqlQuery)
	{
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if (!$result) {
			die('Error in query: ' . mysqli_error($this->dbConnect));
		}
		$numRows = mysqli_num_rows($result);
		return $numRows;
	}
	public function loginUsers($username, $password)
	{
		$sqlQuery = "
			SELECT userid, username, is_verified 
			FROM " . $this->chatUsersTable . " 
			WHERE username='" . $username . "' AND password='" . $password . "'";
		return  $this->getData($sqlQuery);
	}
	public function chatUsers($userid)
	{
		$sqlQuery = "
			SELECT * FROM " . $this->chatUsersTable . " 
			WHERE userid != '$userid'";
		return  $this->getData($sqlQuery);
	}
	public function getUserDetails($userid)
	{
		$sqlQuery = "
			SELECT * FROM " . $this->chatUsersTable . " 
			WHERE userid = '$userid'";
		return  $this->getData($sqlQuery);
	}
	public function getUserAvatar($userid)
	{
		$sqlQuery = "
			SELECT img_profile 
			FROM " . $this->chatUsersTable . " 
			WHERE userid = '$userid'";
		$userResult = $this->getData($sqlQuery);
		$userAvatar = '';
		foreach ($userResult as $user) {
			$userAvatar = $user['img_profile'];
		}
		return $userAvatar;
	}
	public function updateUserOnline($userId, $online)
	{
		$sqlUserUpdate = "
			UPDATE " . $this->chatUsersTable . " 
			SET online = '" . $online . "' 
			WHERE userid = '" . $userId . "'";
		mysqli_query($this->dbConnect, $sqlUserUpdate);
	}
	public function insertChat($reciever_userid, $user_id, $chat_message, $lugar)
	{
		$sqlInsert = "
			INSERT INTO " . $this->chatTable . " 
			(reciever_userid, sender_userid, message, status, lugar) 
			VALUES ('" . $reciever_userid . "', '" . $user_id . "', '" . $chat_message . "', '1', '$lugar')";
		$result = mysqli_query($this->dbConnect, $sqlInsert);
		if (!$result) {
			return ('Error in query: ' . mysqli_error($this->dbConnect));
		} else {
			$conversation = $this->getUserChat($user_id, $reciever_userid);
			$data = array(
				"conversation" => $conversation
			);
			echo json_encode($data);
		}
	}
	// hacemos un get al chat
	public function getChatPeronal($from_user_id, $to_user_id)
	{
		$fromUserAvatar = $this->getUserAvatar($from_user_id);

		$sqlQuery = "
			SELECT * FROM " . $this->chatTable . " 
			WHERE (sender_userid = '" . $from_user_id . "' 
			AND reciever_userid = '" . $to_user_id . "') 
			OR (sender_userid = '" . $to_user_id . "' 
			AND reciever_userid = '" . $from_user_id . "') 
			ORDER BY timestamp ASC";



		$userChat = $this->getData($sqlQuery);

		$conversation = '<ul>';
		foreach ($userChat as $chat) {
			$nombreUsuario = $chat['fname'];
			$toUserAvatar =  $chat['img_profile'];
			$lugarUsuario = $chat['lugar']; //lugar del usuario x
			$tipoAvatar = $chat['avatar']; //avatar del usuario x
			$estadoUsuario = $chat['online']; // mi estado 
			// estado del usuario que  envia el mensaje 
			$estadoOtro = $chat['status'];
			$user_name = '';

			if ($chat["sender_userid"] == $from_user_id) {
				$conversation .= '<li class="sent" >' . '<div hidden id="lugar-usuario">' . $lugarUsuario . '</div>' . '<div hidden id="avatar-usuario">' . $tipoAvatar . '</div>' . '<div hidden id="estado-usuario">' . $estadoUsuario . '</div>';
				$conversation .= '<img width="22px" height="22px" src="userpics/' . $fromUserAvatar . '" alt="" /> ';
			} else {
				$conversation .= '<li class="replies">';
				$conversation .= '<img width="22px" height="22px" src="userpics/' . $toUserAvatar . '" alt="" /><span class="nombre_respuesta">'  . $nombreUsuario . '</span>' . '<div hidden id="lugar-otro-usuario">' . $lugarUsuario . '</div>' . '<div hidden id="avatar-otro-usuario">' . $tipoAvatar . '</div>' . '<div hidden id="estado-otro-usuario">' . $estadoUsuario . '</div>';
			}

			$conversation .= '<p>' . $chat["message"] . '</p>';
			$conversation .= '</li>';
		}

		$conversation .= '</ul>';

		return $conversation;
	}
	public function getUserChat($from_user_id, $to_user_id)
	{
		$fromUserAvatar = $this->getUserAvatar($from_user_id);

		/*		
		$sqlQuery = "
			SELECT * FROM ".$this->chatTable." 
			WHERE (sender_userid = '".$from_user_id."' 
			AND reciever_userid = '".$to_user_id."') 
			OR (sender_userid = '".$to_user_id."' 
			AND reciever_userid = '".$from_user_id."') 
			ORDER BY timestamp ASC";
			*/

		$sqlQuery = "SELECT *
			FROM chat
			INNER JOIN chat_users
			ON chat.sender_userid = chat_users.userid
			ORDER BY timestamp ASC;";
		//echo $sqlQuery;

		$userChat = $this->getData($sqlQuery);

		$conversation = '<ul>';
		foreach ($userChat as $chat) {
			$nombreUsuario = $chat['fname'];
			$toUserAvatar =  $chat['img_profile'];
			$lugarUsuario = $chat['lugar']; //lugar del usuario x
			$tipoAvatar = $chat['avatar']; //avatar del usuario x
			$estadoUsuario = $chat['online']; // mi estado 
			// estado del usuario que  envia el mensaje 
			$estadoOtro = $chat['status'];
			$user_name = '';

			if ($chat["sender_userid"] == $from_user_id) {
				$conversation .= '<li class="sent" >' . '<div hidden id="lugar-usuario">' . $lugarUsuario . '</div>' . '<div hidden id="avatar-usuario">' . $tipoAvatar . '</div>' . '<div hidden id="estado-usuario">' . $estadoUsuario . '</div>';
				$conversation .= '<img width="22px" height="22px" src="userpics/' . $fromUserAvatar . '" alt="" /> ';
			} else {
				$conversation .= '<li class="replies">' . '<div hidden id="lugar-otro-usuario">' . $lugarUsuario . '</div>';
				$conversation .= '<img width="22px" height="22px" src="userpics/' . $toUserAvatar . '" alt="" /><span>' . $nombreUsuario . '</span>' . '<div hidden id="lugar-otro-usuario">' . $lugarUsuario . '</div>' . '<div hidden id="avatar-otro-usuario">' . $tipoAvatar . '</div>' . '<div hidden id="estado-otro-usuario">' . $estadoUsuario . '</div>';
			}

			$conversation .= '<p>' . $chat["message"] . '</p>';
			$conversation .= '</li>';
		}

		$conversation .= '</ul>';

		return $conversation;
	}

	public function showUserChat($from_user_id, $to_user_id)
	{
		$userDetails = $this->getUserDetails($to_user_id);
		$toUserAvatar = '';
		foreach ($userDetails as $user) {
			$toUserAvatar = $user['img_profile'];
			$userSection = '<div class="img_profile"> <span class="icon-arrow-left ico-back" onclick="abrirchat();"></span>  <img src="userpics/' . $user['img_profile'] . '" alt="user-icon" />
				<p>' . ' CONECTADO ' . '</p> </div>
				<div class="social-media">
					<i class="icon-facebook" aria-hidden="true"></i>
					<i class="icon-twitter" aria-hidden="true"></i>
					 <i class="icon-instagram" aria-hidden="true"></i> <span class="icon-x i-cerrar" onclick="cerrarChat();"></span>
				</div>';
		}
		// get user conversation
		$conversation = $this->getUserChat($from_user_id, $to_user_id);
		// update chat user read status		
		$sqlUpdate = "
			UPDATE " . $this->chatTable . " 
			SET status = '0' 
			WHERE sender_userid = '" . $to_user_id . "' AND reciever_userid = '" . $from_user_id . "' AND status = '1'";
		mysqli_query($this->dbConnect, $sqlUpdate);
		// update users current chat session
		$sqlUserUpdate = "
			UPDATE " . $this->chatUsersTable . " 
			SET current_session = '" . $to_user_id . "' 
			WHERE userid = '" . $from_user_id . "'";
		mysqli_query($this->dbConnect, $sqlUserUpdate);
		$data = array(
			"userSection" => $userSection,
			"conversation" => $conversation
		);
		echo json_encode($data);
	}
	// mirar un chat personal
	public function verChatPeronal($from_user_id, $to_user_id)
	{
		$userDetails = $this->getUserDetails($to_user_id);
		$toUserAvatar = '';
		foreach ($userDetails as $user) {
			$toUserAvatar = $user['img_profile'];
			$userSection = '<div class="img_profile"> <span class="icon-arrow-left ico-back" onclick="abrirchat();"></span>  <img src="userpics/' . $user['img_profile'] . '" alt="user-icon" />
				<p>' . ' CONECTADO ' . '</p> </div>
				<div class="social-media">
					<i class="icon-facebook" aria-hidden="true"></i>
					<i class="icon-twitter" aria-hidden="true"></i>
					 <i class="icon-instagram" aria-hidden="true"></i> <span class="icon-x i-cerrar" onclick="cerrarChat();"></span>
				</div>';
		}
		// get user conversation
		$conversation = $this->getUserChat($from_user_id, $to_user_id);
		// update chat user read status		
		$sqlUpdate = "
			UPDATE " . $this->chatTable . " 
			SET status = '0' 
			WHERE sender_userid = '" . $to_user_id . "' AND reciever_userid = '" . $from_user_id . "' AND status = '1'";
		mysqli_query($this->dbConnect, $sqlUpdate);
		// update users current chat session
		$sqlUserUpdate = "
			UPDATE " . $this->chatUsersTable . " 
			SET current_session = '" . $to_user_id . "' 
			WHERE userid = '" . $from_user_id . "'";
		mysqli_query($this->dbConnect, $sqlUserUpdate);
		$data = array(
			"userSection" => $userSection,
			"conversation" => $conversation
		);
		echo json_encode($data);
	}
	public function getUnreadMessageCount($senderUserid, $recieverUserid)
	{
		$sqlQuery = "
			SELECT * FROM " . $this->chatTable . "  
			WHERE sender_userid = '$senderUserid' AND reciever_userid = '$recieverUserid' AND status = '1'";
		$numRows = $this->getNumRows($sqlQuery);
		$output = '';
		if ($numRows > 0) {
			$output = $numRows;
		}
		return $output;
	}
	public function updateTypingStatus($is_type, $loginDetailsId)
	{
		$sqlUpdate = "
			UPDATE " . $this->chatLoginDetailsTable . " 
			SET is_typing = '" . $is_type . "' 
			WHERE id = '" . $loginDetailsId . "'";
		mysqli_query($this->dbConnect, $sqlUpdate);
	}
	public function fetchIsTypeStatus($userId)
	{
		$sqlQuery = "
		SELECT is_typing FROM " . $this->chatLoginDetailsTable . " 
		WHERE userid = '" . $userId . "' ORDER BY last_activity DESC LIMIT 1";
		$result =  $this->getData($sqlQuery);
		$output = '';
		foreach ($result as $row) {
			if ($row["is_typing"] == 'yes') {
				$output = ' - <small></small>';
			}
		}
		return $output;
	}
	public function insertUserLoginDetails($userId)
	{
		$sqlInsert = "
			INSERT INTO " . $this->chatLoginDetailsTable . "(userid) 
			VALUES ('" . $userId . "')";
		mysqli_query($this->dbConnect, $sqlInsert);
		$lastInsertId = mysqli_insert_id($this->dbConnect);
		return $lastInsertId;
	}
	public function updateLastActivity($loginDetailsId)
	{
		$sqlUpdate = "
			UPDATE " . $this->chatLoginDetailsTable . " 
			SET last_activity = now() 
			WHERE id = '" . $loginDetailsId . "'";
		mysqli_query($this->dbConnect, $sqlUpdate);
	}
	public function getUserLastActivity($userId)
	{
		$sqlQuery = "
			SELECT last_activity FROM " . $this->chatLoginDetailsTable . " 
			WHERE userid = '$userId' ORDER BY last_activity DESC LIMIT 1";
		$result =  $this->getData($sqlQuery);
		foreach ($result as $row) {
			return $row['last_activity'];
		}
	}
	// Actualizar el lugar del usuario cuando éste cambia de lugar
	public function actualizarLugarUsuario($nuevolugar, $userid)
	{
		$sql = "UPDATE $this->chatTable SET lugar = ? WHERE sender_userid = ? ORDER BY chatid DESC LIMIT 1";
		$stmt = mysqli_prepare($this->dbConnect, $sql);
		mysqli_stmt_bind_param($stmt, "si", $nuevolugar, $userid);
		$result = mysqli_stmt_execute($stmt);
		mysqli_stmt_close($stmt);
	
		// Verificar si la consulta se ejecutó correctamente
		if ($result) {
			// Consulta exitosa, obtener el estado actualizado
			$estadoActualizado = $nuevolugar;
		} else {
			// Consulta fallida, devolver un estado de error
			$estadoActualizado = "Error al actualizar el lugar";
		}
	
		// Devolver el estado actualizado
		return $estadoActualizado;
	}
	// public function traerVideo(){
	// 	$sql = "SELECT * FROM clases WHERE id=1";
	// 	$result = $this->getData($sql);
	// 	foreach($result as $row){
	// 		return $row['archivo'];
	// 	}
	// }
}
	
