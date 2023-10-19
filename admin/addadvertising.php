<!-- BEGIN: Head -->
<?php
$title = 'Dashboard principal';
include("page-master/head.php");
$addError = '';
$addError = ''; // Inicializa la variable $addError

// Procesar el primer archivo si se ha proporcionado
if (isset($_FILES["file1"]) && $_FILES["file1"]["error"] == UPLOAD_ERR_OK) {
    $temp_name1 = $_FILES["file1"]["tmp_name"];
    $original_name1 = $_FILES["file1"]["name"];

    // Especifica la carpeta de destino donde deseas mover el archivo
    $destination_folder = "../publicidad/";

    // Ruta completa de destino para el primer archivo
    $destination_path1 = $destination_folder . $original_name1;

    // Mover el primer archivo a la carpeta de destino
    if (move_uploaded_file($temp_name1, $destination_path1)) {
        // Procesa el segundo archivo si se ha proporcionado
        if (isset($_FILES["file2"]) && $_FILES["file2"]["error"] == UPLOAD_ERR_OK) {
            $temp_name2 = $_FILES["file2"]["tmp_name"];
            $original_name2 = $_FILES["file2"]["name"];

            // Ruta completa de destino para el segundo archivo
            $destination_path2 = $destination_folder . $original_name2;

            // Mover el segundo archivo a la carpeta de destino
            if (move_uploaded_file($temp_name2, $destination_path2)) {
                // Llama a tu función insertarUniversidad después de procesar ambos archivos
                include('Chat.php');
                $chat = new Chat();
                $insert = $chat->addAdver($original_name1, $original_name2);
                echo "entra acá";
                header("location: advertising");
            } else {
                $addError = "Error moving second file to destination folder.";
            }
        } else {
            $addError = "Error uploading second file.";
        }
    } else {
        $addError = "Error moving first file to destination folder.";
    }
} else {
    $addError = "Error uploading first file.";
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
                    Add Advertising
                </h2>
            </div>
            <div class="grid grid-cols-12 gap-6 mt-5">
                <div class="intro-y col-span-12 lg:col-span-12">
                    <!-- BEGIN: Vertical Form -->
                    <div class="intro-y box">
                        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                            <h2 class="font-medium text-base mr-auto">
                                Register Advertising
                            </h2>
                        </div>
                        <div id="vertical-form" class="p-5">
                            <form method="post" enctype="multipart/form-data">
                                <?php if ($addError) { ?>
                                    <div class="alert-error"><?php echo $addError; ?></div>
                                <?php } ?>
                                <div class="preview">
                                    <div class="mt-3 fallback">
                                        <label for="vertical-form-2" class="form-label">Advertising 1:</label>
                                        <input name="file1" type="file" required />
                                    </div>

                                    <div class="mt-3 fallback">
                                        <label for="vertical-form-2" class="form-label">Advertising 2:</label>
                                        <input name="file2" type="file" required />
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