<div class="cl-normal">

<div>
    <div class="simbol">
        <img src="images/maleta.webp" alt="Icon backpack">
    </div>
    <h3 style="color: white; font-weight: 800; font-size: 2rem; text-align: center;">
        YOUR BACKPACK.
    </h3>


    <div class="wrap-data">
        <div class="cont_wrap_tow">
            <div class="cont_wrap">
                <h4>
                    Your boock and more
                </h4>
                <div class="books">
                    <?php
                    $sql = "SELECT * FROM mochila WHERE tipo = 1";
                    $stmt = $chat->dbConnect->query($sql);

                    if (!$stmt) {
                        die("Error en la consulta: " . $chat->dbConnect->error);
                    }

                    if ($stmt->num_rows > 0) {
                        while ($row = $stmt->fetch_assoc()) {
                    ?>
                            <a href="source/<?php echo $row['recurso'] ?>" class="view_src" download="<?php echo $row['recurso'] ?>">
                                <span class="icon-download ico_c"></span>
                                <?php echo $row['nombre']; ?>
                            </a>
                    <?php
                        }
                    } else {
                        echo "<p class='view_src ss'>No files were found</p>";
                    }
                    ?>
                </div>

            </div>
            <div class="cont_wrap">
                <h4>
                    Your videos
                </h4>
                <div class="videos">
                    <?php
                    $sql = "SELECT * FROM mochila WHERE tipo = 2";
                    $stmt = $chat->dbConnect->query($sql);

                    if (!$stmt) {
                        die("Error en la consulta: " . $chat->dbConnect->error);
                    }

                    if ($stmt->num_rows > 0) {
                        while ($row = $stmt->fetch_assoc()) {
                    ?>
                            <a href="<?php echo $row['recurso'] ?>" class="view_src" target="_blank" download="<?php echo $row['recurso'] ?>">
                                <span class="icon-eye ico_c"></span>
                                <?php echo $row['nombre'] . "<br>"; ?>
                            </a>
                    <?php
                        }
                    } else {
                        echo "<p class='view_src ss'>No videos found</p>";
                    }
                    ?>



                </div>
            </div>
        </div>
    </div>
</div>
</div>