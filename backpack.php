<!-- BACKPACK -->
<div class="cl-normal cont_backpack" id="backpack_container">
    <?php
    $sql = "SELECT * FROM chat_users WHERE userid = '$userid'";
    $stmt = $chat->dbConnect->query($sql);
    if (!$stmt) {
        die("Error en la consulta: " . $chat->dbConnect->error);
    }
    while ($row = $stmt->fetch_assoc()) {
        $data[] = $row;
    }
    ?>
    <div class="header_principal">
        <div class="cl-normal">
            <div class="close_containers">

                <div class="containerlogo">
                    <img src="images/smal_conectado.webp" alt="Logo CONECTADO" width="120">
                    <button onclick="viewDetalis('account');" id="accout_item" class="options  accout_item option-active">Account</button>
                    <button onclick="viewDetalis('list_uni');" id="university_item" class="options accout_item ">Campus connect</button>
                    <button onclick="viewDetalis('avatar');" id="avatar_item" class="options avatar_item">Avatar</button>

                </div>

                <?php
                $id=1;
                include('page-master/profile_options.php')
                ?>
            </div>

        </div>
    </div>
    <div class="ft_bk">
    <div class="back_child">
        <div class="wrap-general">
            <div class="wrap-profile">
                <?php include('page-master/profile.php'); ?>

                <div class="wrap-email">
                    <div class="cont-email">
                        <p class="prev_text email_t">Email</p>
                        <!-- <button onclick="openModalP('updatemail', <?php echo $data[0]['userid'] ?>);" class="text_edit_email">Update<span class="icon-edit ic_eds"></span></button> -->
                    </div>
                    <div class="emial_des">
                        <small><strong>Your email</strong></small>
                        <p class="email"><?php echo $data[0]['username'] ?></p>
                    </div>
                </div>
                <div class="wrap-phone">
                    <div class="cont-email">
                        <p class="prev_text email_t">Phone number</p>
                        <!-- <button onclick="openModalP('updateNumber', <?php echo $data[0]['userid'] ?>);" class="text_edit_email">Update <span class="icon-edit ic_eds"></span></button> -->
                    </div>
                    <div class="emial_des">
                        <small><strong>Mobile phone</strong></small>
                        <p class="phone">
                            <?php if ($data[0]['phone'] != '' || $data[0]['phone'] != null) {
                                echo $data[0]['phone'];
                            } else {
                                echo "Not specified";
                            } ?>
                        </p>
                    </div>
                </div>
                <div class="wrap-phone">
                    <div class="cont-email">
                        <p class="prev_text email_t">University</p>
                        <!-- <button onclick="openModalP('updateuni', <?php echo $data[0]['userid'] ?>);" class="text_edit_email">Update <span class="icon-edit ic_eds"></span></button> -->
                    </div>
                    <div class="emial_des">
                        <small><strong>Your university</strong></small>
                        <p class="uni">
                            <?php if ($data[0]['institute'] != '' || $data[0]['institute'] != null) {
                                echo $data[0]['institute'];
                            } else {
                                echo "Not specified";
                            } ?>
                        </p>
                    </div>
                </div>
                <div class="wrap-phone">
                    <div class="cont-email">
                        <p class="prev_text email_t">Main data</p>
                        <!-- <button onclick="openModalP('updatedata', <?php echo $data[0]['userid'] ?>);" class="text_edit_email">Update <span class="icon-edit ic_eds"></span></button> -->
                    </div>
                    <div class="emial_des">
                        <small><strong>National identification</strong></small>
                        <p class="identification">
                            <?php if ($data[0]['document'] != '' || $data[0]['document'] != null) {
                                echo $data[0]['document'];
                            } else {
                                echo "Not specified";
                            } ?>
                        </p>
                        <br>
                        <small><strong>Nationality</strong></small>

                        <p class="nationality">
                            <?php if ($data[0]['nationality'] != '' || $data[0]['nationality'] != null) {
                                echo $data[0]['nationality'];
                            } else {
                                echo "Unspecified nationality";
                            } ?>
                        </p>
                        <br>
                        <!-- <small><strong>Birthday</strong></small>
                        <p>
                            <?php if ($data[0]['birthdate'] != '' || $data[0]['birthdate'] != null) {
                                echo $data[0]['birthdate'];
                            } else {
                                echo "Not specified";
                            } ?>
                        </p>
                        <br> -->
                        <small><strong>Gender</strong></small>
                        <p class="sexo">
                            <?php if ($data[0]['sexo'] != '' || $data[0]['sexo'] != null) {
                                echo $data[0]['sexo'];
                            } else {
                                echo "Not specified";
                            } ?>
                        </p>
                    </div>
                </div>

                <div class="wrap-phone">
                    <div class="cont-email">
                        <p class="prev_text email_t">Address</p>
                        <!-- <button onclick="openModalP('updateadress', <?php echo $data[0]['userid'] ?>);" class="text_edit_email">Update <span class="icon-edit ic_eds"></span></button> -->
                    </div>
                    <div class="emial_des">
                        <small><strong>Address</strong></small>
                        <p class="addres">
                            <?php if ($data[0]['adress'] != '' || $data[0]['adress'] != null) {
                                echo $data[0]['adress'];
                            } else {
                                echo "Not specified";
                            } ?>
                        </p>
                        <br>
                        <small><strong>Country</strong></small>
                        <p class="countri">
                            <?php if ($data[0]['country'] != '' || $data[0]['country'] != null) {
                                echo $data[0]['country'];
                            } else {
                                echo "Not specified";
                            } ?>
                        </p>
                        <br>
                        <small><strong>City</strong></small>
                        <p class="citi">
                            <?php if ($data[0]['city'] != '' || $data[0]['city'] != null) {
                                echo $data[0]['city'];
                            } else {
                                echo "Not specified";
                            } ?>
                        </p>
                        <br>
                    </div>
                </div>
            </div>

            <div class="wrap-info">
                <div class="wrap-clases">
                    <div class="cont-clases">
                        <p class="prev_text email_t text_source">Welcome to conectado</p>
                    </div>
                    <div class="container-video">
                        <video controls style="width: 100%;">
                            <source src="video/vide_1.mp4" type="video/mp4">
                            Tu navegador no admite la reproducción de videos.
                        </video>
                    </div>
                    <div class="see_more">
                        <!-- <a href="" class="btn_see">See more <span class="icon-eye"></span></a> -->
                    </div>
                </div>
                <div class="wrap-clases">
                    <div class="cont-clases">
                        <p class="prev_text email_t text_source">Your books and more</p>
                    </div>
                    <div class="container-video">
                        <video id="videoPlayer" controls style="width: 100%;">
                            <source src="video/vide_1.mp4" type="video/mp4">
                            Tu navegador no admite la reproducción de videos.
                        </video>
                    </div>
                    <div class="see_more">
                    </div>
                    <div class="see_more">
                        <div class="see_more class_Seemore">
                            <button id="btnAntes" class="btn_see prev_video"><span class="icon-chevron-left"></span>Prev</button>
                            <button id="btnSiguiente" class="btn_see next_video">Next <span class="icon-chevron-right"></span></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <?php
    // include('modals.php');
    ?>
</div>


<?php
echo "<script src='js/call.js'></script>";
include "page-master/footer.php";
?>