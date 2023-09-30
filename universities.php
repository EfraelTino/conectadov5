<!-- UNIVERSITY -->
<div class="cl-normal cont_backpack university" id="universiti_container">
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
                    <button  onclick="viewDetalis('account');" id="accout_item" class="options accout_item">Account</button>
                    <button onclick="viewDetalis('list_uni');" id="university_item" class="options university_item">Campus connect</button>
                    <button onclick="viewDetalis('avatar');" id="avatar_item" class="options avatar_item">Avatar</button>
                </div>
                <?php
                include('page-master/profile_options.php')
                ?>
            </div>
        </div>
    </div>
    <div class="back_child">
        <div class="wrap-email">
            <div class="cont-email">
                <h2 class="prev_text email_t list_uni">List of universities</h2>
                <button onclick="openModal('add', 0);" class="text_add">Add new <span class="icon-plus ic_eds"></span></button>

            </div>
            <div class="wrap_search">
                <div class="cont_search">
                    <input type="search" name="" id="input_search" placeholder=" Search universities and institutes..." class="input_search">
                    <button class="btn_search">Search <span class="icon-search"></span></button>
                </div>
            </div>
            <p id="loading-message" class="loading-message" style="display: none; text-align: center; font-size: 20px; font-weight: 600; color: var(--color-en-linea);">Cargando...</p>
            <p id="not-found" class="loading-message" style="display: none; text-align: center;    font-size: 20px; font-weight: 600; color: var(--color-error);">Cargando...</p>
            <p class="status_s"></p>
            <div class="wrap_universities">
                <div class="wrap_uni id_s" id="results_university">
                </div>
            </div>
            <div class="wrap_universities">
                <div class="wrap_uni" id="anterior_results">
                    <?php
                    $sql = "select * from universities order by id ASC";
                    $stmt = $chat->dbConnect->query($sql);
                    if (!$stmt) {
                        die("Error en la consulta: " . $chat->dbConnect->error);
                    }
                    while ($row = $stmt->fetch_assoc()) {
                    ?>
                        <div class="cont_uni">
                            <a href="<?php echo $row['url'] ?>" class="cont_ims">
                                <img src="textures/<?php echo $row['photo'] ?>" alt="<?php echo $row['name'] ?>" class="img_uni" loading="lazy">
                            </a>
                            <a href="<?php
                                        $url = trim($row['url']); // Elimina espacios en blanco al inicio y al final
                                        $url = str_replace(' ', '-', $url); // Reemplaza espacios en blanco por guiones

                                        // Verifica si la URL comienza con "http://" o "https://", si no, agrega "https://"
                                        if (!preg_match('/^(http|https):\/\//i', $url)) {
                                            $url = 'https://' . $url;
                                        }
                                        echo $url  ?>" class="name_universtity"><?php echo $row['name'] ?></a>
                            <div class="desc">
                                <p class="countri_uni"><?php echo $row['location'] ?></p>
                                <button onclick="openModal('edit', <?php echo $row['id']; ?>);" class="btn_edit" data-id="<?php echo $row['id']; ?>">Edit <span class="icon-edit"></span></button>
                            </div>
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>
    <?php
        // include('modals.php');

    ?>
</div>
<?php
include "page-master/footer.php";
?>