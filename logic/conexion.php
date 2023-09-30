<?php
$hostname = "localhost";
// $username = "u960900126_saproducciones";
$username = "root";
// $password = "Cocorilow.1";
$password = "";
// $dbname = "u960900126_hondabd";
$dbname = "php_chat_1";

   

$conn = mysqli_connect($hostname, $username, $password, $dbname);
if (!$conn) {
  echo "Database connection, estamos en este error ..... " . mysqli_connect_error();
}else{echo "conectado <br>";}