<!-- UNIVERSITY -->
<div class="cl-normal cont_backpack avatar_action" id="avatar_container">

    <div class="header_principal">
        <div class="cl-normal">
            <div class="close_containers">

                <div class="containerlogo">
                    <img src="images/smal_conectado.webp" alt="Logo CONECTADO" width="120">
                    <button onclick="viewDetalis('account');" id="accout_item" class="options accout_item">Account</button>
                    <button onclick="viewDetalis('list_uni');" id="university_item" class="options university_item option-active">Campus Connect</button>
                    <button onclick="viewDetalis('avatar');" id="avatar_item" class="options avatar_item">Avatar</button>
                </div>
                <?php
                $id= 1;
                include('page-master/profile_options.php')
                ?>
            </div>
        </div>
    </div>
    <div class="back_child">
        <div class="wrap-email wrap-avatar">

            <div class="wrap_avatar">
                <h2 class="prev_text email_t list_uni text_avatar">Your avatar</h2>
                <p id="response_value" class="text_response text_1"></p>
                <div class="wrap_avatar_content">
                    <div class="wrap_second">
                        <div>
                            <img src="userpics/avatar_principal.webp" alt="user avatar" id="imagen_principal" class="avatar_principal">
                            <div class="images_cont_avatar">
                                <img style="width: 200px;" src="" alt="" class="genero" id="parte_genero" data-parte="genero">
                                <img style="width: 200px;"  src="" alt="" class="cabello" id="parte_cabello" data-parte="cabello">
                                <img style="width: 200px;"  src="" alt="" class="camiseta" id="parte_camiseta" data-parte="camiseta">
                                <img style="width: 200px;"  src="" alt="" class="pantalon" id="parte_pantalon" data-parte="pantalon">
                                <img style="width: 200px;"  src="" alt="" class="zapato" id="parte_zapato" data-parte="zapato">
                            </div>
                            <!-- <button type="button" class="btn_see">Save <span class="ico-save"></span></button> -->
                        </div>
                    <div class="save_container_avatar">
                        <button type="button" class="btn_see save_avatar"> Save<span class="icon-save"></span></button>
                    </div>

                    </div>
                    <div class="image_c lista_imagen">
                        <?php
                        $sql = "SELECT * FROM avatar";
                        $result = $chat->dbConnect->query($sql);
                        if ($result) {
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $indumentaria = $row['indumentaria'];
                                    $parte = $row['parte'];
                                    echo "<img src='userpics/$indumentaria' alt='avatar pants' class='image_avatar_part' data-src='userpics/$indumentaria' data-parte='$parte'>";
                                }
                            } else {
                                echo "No se encontraron registros en la tabla.";
                            }
                            $result->free();
                        } else {
                            die("Error en la consulta: " . $chat->dbConnect->error);
                        }
                        $chat->dbConnect->close();
                        ?>

                    </div>
                    <!-- <div class="image_c">
                            <img src="" alt="avatar shoe" id="zapatosImage" class="image_avatar_part">
                            <form action="" class="avatar_items">
                                <input type="file" name="cabello" id="zapato" id="zapatoImage">
                                <button class="btn_see" type="button" id="saveAvatar" onclick="actualizarCabello(<?php echo $_SESSION['userid'] ?>, 'zapatos')">Save <span class="icon-save"></span></button>
                            </form>
                        </div> -->
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // Agrega un manejador de clic a las imágenes seleccionables
        $('.image_avatar_part').click(function() {
            // Obtiene la ruta de la imagen seleccionada desde el atributo data-src
            var nuevaImagenSrc = $(this).data('src');
            var parteAvatar = $(this).data('parte');
            if (parteAvatar === 1) {
                $('#imagen_principal').attr('src', nuevaImagenSrc);
                $('.image_avatar_part').removeClass('back_verde');
                $(this).addClass('back_verde');
            } else if (parteAvatar === 2) {
                $('#imagen_principal').attr('src', nuevaImagenSrc);
                $('.image_avatar_part').removeClass('back_verde');
                $(this).addClass('back_verde');
            } else if (parteAvatar === 3) {
                $('#parte_cabello').attr('src', nuevaImagenSrc);
                $('.image_avatar_part').removeClass('back_verde');
                $(this).addClass('back_verde');
            } else if (parteAvatar === 4) {
                $('#parte_cabello').attr('src', nuevaImagenSrc);
                $('.image_avatar_part').removeClass('back_verde');
                $(this).addClass('back_verde');
            } else if (parteAvatar === 5) {
                $('#parte_camiseta').attr('src', nuevaImagenSrc);
                $('.image_avatar_part').removeClass('back_verde');
                $(this).addClass('back_verde');
            } else if (parteAvatar === 6) {
                $('#parte_camiseta').attr('src', nuevaImagenSrc);
                $('.image_avatar_part').removeClass('back_verde');
                $(this).addClass('back_verde');
            } else if (parteAvatar === 7) {
                $('#parte_pantalon').attr('src', nuevaImagenSrc);
                $('.image_avatar_part').removeClass('back_verde');
                $(this).addClass('back_verde');
            } else if (parteAvatar === 8) {
                $('#parte_pantalon').attr('src', nuevaImagenSrc);
                $('.image_avatar_part').removeClass('back_verde');
                $(this).addClass('back_verde');
            } else if (parteAvatar === 9) {
                $('#parte_zapato').attr('src', nuevaImagenSrc);
                $('.image_avatar_part').removeClass('back_verde');
                $(this).addClass('back_verde');
            } else if (parteAvatar === 10) {
                $('#parte_zapato').attr('src', nuevaImagenSrc);
                $('.image_avatar_part').removeClass('back_verde');
                $(this).addClass('back_verde');
            }
        });
    });
</script>
<?php
// include('modals.php');

?>
</div>
<?php
include "page-master/footer.php";
?>