<!-- BEGIN: Head -->
<?php
$title = 'Dashboard principal';
include("page-master/head.php");
$addError = '';

    if (!empty($_POST['nombre_uni']) && !empty($_POST['location'])) {
        // Capturamos los datos del formulario
        $nombre_uni = $_POST['nombre_uni'];
        $location = $_POST['location'];

        // Procesar el archivo cargado si se ha proporcionado uno
        if (isset($_FILES["file"]) && $_FILES["file"]["error"] == UPLOAD_ERR_OK) {
            $temp_name = $_FILES["file"]["tmp_name"];
            $original_name = $_FILES["file"]["name"];

            // Especifica la carpeta de destino donde deseas mover la foto
            $destination_folder = "textures/";

            // Ruta completa de destino
            $destination_path = $destination_folder . $original_name;

            // Mover el archivo a la carpeta de destino
            if (move_uploaded_file($temp_name, $destination_path)) {
                header("location: universities");
            } else {
                $addError = "Error moving photo to destination folder.";
            }
        }

        // Llama a tu función insertarUniversidad después de procesar la foto
        include('Chat.php');
        $chat = new Chat();
        $lastInsertId = $chat->insertarUniversidad($nombre_uni, $original_name, $location);

        // Continúa con el código según tus necesidades
    }


?>
<!-- END: Head -->

<body class="py-5 md:py-0">

    <!-- BEGIN: Top Bar -->
    <?php
    include("page-master/header.php");
    ?>
    <!-- END: Top Bar -->
    <div class="flex overflow-hidden">
        <!-- BEGIN: Side Menu -->
        <?php
        include("page-master/side-navbar.php");
        ?>

        <div class="content">
            <div class="intro-y flex items-center mt-8">
                <h2 class="text-lg font-medium mr-auto">
                    Add university
                </h2>
            </div>
            <div class="grid grid-cols-12 gap-6 mt-5">
                <div class="intro-y col-span-12 lg:col-span-12">
                    <!-- BEGIN: Vertical Form -->
                    <div class="intro-y box">
                        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                            <h2 class="font-medium text-base mr-auto">
                                Register university
                            </h2>
                        </div>
                        <div id="vertical-form" class="p-5">
                            <form method="post" enctype="multipart/form-data">
                                <?php if ($addError) { ?>
                                    <div class="alert-error"><?php echo $addError; ?></div>
                                <?php } ?>
                                <div class="preview">
                                    <div>
                                        <label for="vertical-form-1" class="form-label">Name</label>
                                        <input name="nombre_uni" type="text" class="form-control" placeholder="College name" required>
                                    </div>
                                    <div class="mt-3">
                                        <label for="vertical-form-2" class="form-label">Location</label>
                                        <input name="location" id="vertical-form-2" type="text" class="form-control" placeholder="University location" required>
                                    </div>
                                    <div class="mt-3 fallback">
                                        <label for="vertical-form-2" class="form-label">Location:</label>
                                        <input name="file" type="file" required/> 
                                    </div>
                                </div>


                                <button type="submit" class="btn btn-primary mt-5">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- END: Vertical Form -->
            </div>
        </div>
    </div>
    <?php
    include('page-master/js.php');
    ?>
</body>

</html>