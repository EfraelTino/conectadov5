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
			SELECT userid, username 
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

	public function query($sql)
	{
		// $sql es la consulta SQL que deseas ejecutar
		$result = $this->dbConnect->query($sql);

		if (!$result) {
			die("Error en la consulta SQL: " . $this->dbConnect->error);
		}

		return $result;
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

	public function insertarUniversidad($name, $photo, $location)
	{
		$sql = "insert into universities (name, photo, location) values('" .$name. "', '" .$photo. "','" .$location. "')";
		mysqli_query($this->dbConnect, $sql);
		$lastInsertId = mysqli_insert_id($this->dbConnect);
		return $lastInsertId;
	}
	public function insetarVideo($titulo, $archivo,$tipoArchivo){
		$sql ="INSERT INTO clases (titulo, archivo, tipo_archivo) VALUES ('".$titulo."', '".$archivo."', '".$tipoArchivo."')";
        mysqli_query($this->dbConnect, $sql);
		$luegode=mysqli_insert_id($this->dbConnect);
		return $luegode;
	}
	public function deleteVideo($id){
		$sql ="DELETE FROM clases WHERE id= $id";
        if (mysqli_query($this->dbConnect, $sql)) {
			return true; // Éxito al eliminar el registro
		} else {
			return false; // Error al eliminar el registro
		}
	}
}
