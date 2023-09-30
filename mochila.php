<?php
session_start();
$title = "Conectado";
include('page-master/head.php');
if (isset($_SESSION["userid"]) &&  $_SESSION["userid"]) {
    $userid =  $_SESSION["userid"];
} else {
    header("Location: ./");
}
include('page-master/js.php');
?>

<body style="background-color: var(--color-primario); color:white; display: flex; justify-content: center; align-items: center; min-width: 100vw; min-height: 100vh;">
    <div >
        <h3 style="color: white; font-weight: 900; font-size: 2rem; text-align: center;">Your backpack, is in the process of implementation, come back soon....</h3>
    </div>


    <?php
    include "page-master/footer.php";
    ?>