<?php 
include ("Chat.php");
$datos = json_decode(file_get_contents("php://input"));
$chat = new Chat();
// procesar datos
$nombre = $datos->nombre;
$mensaje = $datos->mensaje;
$email = $datos->correo;

$sql = "INSERT INTO suggestion (name, suggestion, email) VALUES(?, ?, ?)";
$stmt = $chat->dbConnect->prepare($sql);
if(!$stmt){
    die("Error en la preparación de la consulta". $chat->dbConnect->error);
}
$stmt->bind_param('sss', $nombre, $mensaje, $email);

$response = array(); // Crear un arreglo para la respuesta

if($stmt->execute()){
    $response["success"] = true; // Indicar éxito en la respuesta
    $response["message"] = "Suggestion sent";
}else{
    $response["success"] = false; // Indicar error en la respuesta
    $response["message"] = "An error occurred, please try again later: " . $stmt->error;
}
$stmt->close();

// Devolver la respuesta en formato JSON
echo json_encode($response);
?>
