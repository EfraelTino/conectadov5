<?php

class Mochila
{

	//DATABASE CONNECTION LOCALHOST
	// private $host  = 'localhost';
	// private $password   = "";
	// //private $host  = 'localhost:8080';
	// private $user  = 'root';
	// //private $password   = "";
	// private $database  = "php_chat_1";

	//DATABASE CONNECTION SERVER
	 private $host  = 'localhost';
	 private $password   = "Cocorilow.1";
	 private $user  = 'u960900126_saproducciones';
	 private $database  = "u960900126_hondabd";



	// private $chatUsersTable = 'chat_users';
	// private $chatLoginDetailsTable = 'chat_login_details';
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

	// buscar universidad en tiempo real	
	public function searchUni($data)
	{
		$sql = "SELECT * FROM universities WHERE name LIKE '%" . $data . "%'";
		$results = $this->getData($sql); // ejecuto
		if ($results === false) {
			// si ocurre un error
			$response['success'] = false;
			$response['message'] = 'Error en la consulta: ' . mysqli_error($this->dbConnect);
			echo json_encode($response); // respuesta en json
		} else {
			// si no ocurre un error
			$response['success'] = true;
			$response['message'] = 'Resultados encontradosssssss:';
			$response['results'] = $results;
		}

		return json_encode($response); // respuesta jsonº
	}
	public function insertMochila($nameUni, $locationUni, $linkUni, $fileName)
	{
		$sql = "INSERT INTO universities (name, photo, location, url) VALUES (?, ?, ?, ?)";
		$stmt = mysqli_prepare($this->dbConnect, $sql);

		if (!$stmt) {
			throw new Exception('Error en la preparación de la consulta: ' . mysqli_error($this->dbConnect));
		}
		mysqli_stmt_bind_param($stmt, "ssss", $nameUni, $fileName, $locationUni, $linkUni);
		$result = mysqli_stmt_execute($stmt);

		if (!$result) {
			throw new Exception('Error en la consulta: ' . mysqli_error($this->dbConnect));
		}

		mysqli_stmt_close($stmt);

		return true; // Opcionalmente podrías retornar algo significativo aquí
	}
	public function updatePhotoComplete($nameUni, $locationUni, $linkUni, $fileName, $uni_id)
	{
		$id_str = intval($uni_id);
		$sql = "UPDATE universities SET name=?, location=?, url=?, photo=? WHERE id=?";
		$stmt = $this->dbConnect->prepare($sql);
		if (!$stmt) {
			die("Error en la preparación de la consulta");
		}
		$stmt->bind_param('ssssi', $nameUni, $locationUni, $linkUni, $fileName, $id_str);
		if ($stmt->execute()) {
			$response['success'] = true;
			$response['message'] = 'Avatar enviado';
		} else {
			$response['success'] = false;
			$response['message'] = 'Oops! ocurrió un error: ' . $stmt->error;
		}
		$stmt->close();
		echo json_encode($response);
	}
	public function updatePhoto($nameUni, $locationUni, $linkUni, $uni_id)
	{
		$id_str = intval($uni_id);
		$sql = "UPDATE universities SET name=?, location=?, url=? WHERE id=?";
		$stmt = $this->dbConnect->prepare($sql);
		if (!$stmt) {
			die("Error en la preparación de la consulta");
		}
		$stmt->bind_param('sssi', $nameUni, $locationUni, $linkUni, $id_str);
		if ($stmt->execute()) {
			$response['success'] = true;
			$response['message'] = 'Avatar enviado';
		} else {
			$response['success'] = false;
			$response['message'] = 'Oops! ocurrió un error: ' . $stmt->error;
		}
		$stmt->close();
		echo json_encode($response);
	}

	// search user
	public function searchUser($id)
	{
		$sql = "SELECT * FROM chat_users WHERE userid =$id";
		$result = $this->getData($sql);
		if ($result === false) {
			$response['success'] = false;
			$response['message'] = 'Error en la consulta: ' . mysqli_error($this->dbConnect);
			echo json_encode($response);
		} else {
			$response['success'] = true;
			$response['message'] = 'Resultados encontradosssssss:';
			$response['results'] = $result;
		}
		return json_encode($response); // respuesta jsonº

	}

	// functions edit data
	public function editProfession($prof, $id)
	{
		$id_str = intval($id);
		$sql = "UPDATE chat_users SET profession=? WHERE userid=?";
		$stmt = $this->dbConnect->prepare($sql);

		if (!$stmt) {
			$response['success'] = false;
			$response['message'] = 'Error al preparar la consulta: ' . $this->dbConnect->error;
		} else {
			$stmt->bind_param('si', $prof, $id_str);
			if ($stmt->execute()) {
				$response['success'] = true;
				$response['message'] = 'Update success';
			} else {
				$response['success'] = false;
				$response['message'] = 'Error: ' . $stmt->error;
			}
			$stmt->close();
		}

		echo json_encode($response);
	}
	public function editName($fname, $lname, $id)
	{
		$id_str = intval($id);
		$sql = "UPDATE chat_users SET fname=?, lastname=? WHERE userid=?";
		$stmt = $this->dbConnect->prepare($sql);

		if (!$stmt) {
			$response['success'] = false;
			$response['message'] = 'Error al preparar la consulta: ' . $this->dbConnect->error;
		} else {
			$stmt->bind_param('ssi', $fname, $lname, $id_str);
			if ($stmt->execute()) {
				$response['success'] = true;
				$response['message'] = 'Update success';
			} else {
				$response['success'] = false;
				$response['message'] = 'Error: ' . $stmt->error;
			}
			$stmt->close();
		}

		echo json_encode($response);
	}
	public function editEmail($useremail, $id_user)
	{
		$id_str = intval($id_user);
		$sql = "UPDATE chat_users SET username=? WHERE userid=?";
		$stmt = $this->dbConnect->prepare($sql);

		if (!$stmt) {
			$response['success'] = false;
			$response['message'] = 'Error al preparar la consulta: ' . $this->dbConnect->error;
		} else {
			$stmt->bind_param('si', $useremail, $id_str);
			if ($stmt->execute()) {
				$response['success'] = true;
				$response['message'] = 'Update success';
			} else {
				$response['success'] = false;
				$response['message'] = 'Error: ' . $stmt->error;
			}
			$stmt->close();
		}

		echo json_encode($response);
	}
	public function editPhone($phone, $id_user)
	{
		$id_str = intval($id_user);
		$sql = "UPDATE chat_users SET phone=? WHERE userid=?";
		$stmt = $this->dbConnect->prepare($sql);

		if (!$stmt) {
			$response['success'] = false;
			$response['message'] = 'Error al preparar la consulta: ' . $this->dbConnect->error;
		} else {
			$stmt->bind_param('si', $phone, $id_str);
			if ($stmt->execute()) {
				$response['success'] = true;
				$response['message'] = 'Update success';
			} else {
				$response['success'] = false;
				$response['message'] = 'Error: ' . $stmt->error;
			}
			$stmt->close();
		}

		echo json_encode($response);
	}
	
	public function editUni($uni, $id_user)
	{
		$id_str = intval($id_user);
		$sql = "UPDATE chat_users SET institute=? WHERE userid=?";
		$stmt = $this->dbConnect->prepare($sql);

		if (!$stmt) {
			$response['success'] = false;
			$response['message'] = 'Error al preparar la consulta: ' . $this->dbConnect->error;
		} else {
			$stmt->bind_param('si', $uni, $id_str);
			if ($stmt->execute()) {
				$response['success'] = true;
				$response['message'] = 'Update success';
			} else {
				$response['success'] = false;
				$response['message'] = 'Error: ' . $stmt->error;
			}
			$stmt->close();
		}

		echo json_encode($response);
	}
	public function editData($identificacion, $nationality, $sexo, $id_user)
	{
		$id_str = intval($id_user);
		$sql = "UPDATE chat_users SET nationality=?, document=?, sexo=? WHERE userid=?";
		$stmt = $this->dbConnect->prepare($sql);

		if (!$stmt) {
			$response['success'] = false;
			$response['message'] = 'Error al preparar la consulta: ' . $this->dbConnect->error;
		} else {
			$stmt->bind_param('sssi',$nationality, $identificacion, $sexo, $id_str);
			if ($stmt->execute()) {
				$response['success'] = true;
				$response['message'] = 'Update success';
			} else {
				$response['success'] = false;
				$response['message'] = 'Error: ' . $stmt->error;
			}
			$stmt->close();
		}

		echo json_encode($response);
	}
	public function editAddress($address, $country, $city, $id_user)
	{
		$id_str = intval($id_user);
		$sql = "UPDATE chat_users SET adress=?, country=?, city=? WHERE userid=?";
		$stmt = $this->dbConnect->prepare($sql);

		if (!$stmt) {
			$response['success'] = false;
			$response['message'] = 'Error al preparar la consulta: ' . $this->dbConnect->error;
		} else {
			$stmt->bind_param('sssi',$address, $country, $city, $id_str);
			if ($stmt->execute()) {
				$response['success'] = true;
				$response['message'] = 'Update success';
			} else {
				$response['success'] = false;
				$response['message'] = 'Error: ' . $stmt->error;
			}
			$stmt->close();
		}

		echo json_encode($response);
	}
	// AVATAR
	public function updateCaracter($cabello, $id_user, $lugar)
	{
		$id_str = intval($id_user);
	
		// Validación de entrada
		if (!is_int($id_str) || empty($lugar) || empty($cabello)) {
			$response['success'] = false;
			$response['message'] = 'Parámetros de entrada inválidos';
			return json_encode($response);
		}
	
		$sql = "UPDATE chat_users SET $lugar=? WHERE userid=?";
		$stmt = $this->dbConnect->prepare($sql);
		if (!$stmt) {
			// Lanzar una excepción en lugar de usar die()
			throw new Exception("Error en la preparación de la consulta: " . $this->dbConnect->error);
		}
	
		$stmt->bind_param('si', $cabello, $id_str);
		if ($stmt->execute()) {
			$response['success'] = true;
			$response['message'] = 'Avatar enviado';
		} else {
			$response['success'] = false;
			// Proporcionar un mensaje de error más detallado
			$response['message'] = 'Error al actualizar avatar: ' . $stmt->error;
		}
		$stmt->close();
	
		return json_encode($response);
	}
	
}
