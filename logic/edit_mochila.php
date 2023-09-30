<?php 
include('../Chat.php');
$chat = new Chat();
$userid = $_GET['userid'];
$name= $_GET['name'];
echo "name: ". $name. " <br>";
$lname= $_GET['lastname'];
echo "lname: ". $lname . " <br>"; 
$username= $_GET['username'];
echo "username: ". $username . " <br>";
$doc= $_GET['document'];
echo "doc: ". $doc . " <br>";
$pass= $_GET['pass'];
echo "pass: ". $pass . " <br>";
$insti= $_GET['institute'];
echo "insti: ". $insti . " <br>";
$birth= $_GET['birth'];
echo "birth: ". $birth . " <br>";
$sexo = $_GET['sexo'];
echo "sexo: ". $sexo . " <br>";
$address = $_GET['address'];
echo "address: ". $address . " <br>";
$country = $_GET['country'];
echo "country: ". $country . " <br>";
$city = $_GET['city'];
echo "city: ". $city . " <br>";
$encrypt_pass = md5($pass);
echo $userid;

$sql = "UPDATE chat_users SET fname=?, lastname=?, username=?, document=?, password=?, institute=?, birthdate=?, sexo=?, adress=?, country=?, city=? WHERE userid=?";
$stmt = $chat->dbConnect->prepare($sql);
if (!$stmt) {
    die("Error en la preparación de la consulta");
}
$stmt->bind_param('sssssssssssi', $name, $lname, $username, $doc, $encrypt_pass, $insti, $birth, $sexo, $address, $country, $city, $userid);

$result = $stmt->execute();
if($result){
    echo "<script>
    alert('Your details have been successfully updated');
    window.location.href = '../mochila';
</script>";
}else{
    echo "<script>
    alert('Could not update your personal data, please try another time');
    window.history.back();
</script>";
}
$stmt->close();
$chat->dbConnect->close();
