<!-- BEGIN: Head -->
<?php
$title = 'Dashboard principal';
include("page-master/head.php");
$addError = '';

if (!empty($_POST['titulo'])) {

    $titulo = $_POST["titulo"];
    $nombreArchivo = $_FILES["archivo"]["name"];
    $archivoTmp = $_FILES["archivo"]["tmp_name"];

    // Ruta de destino para mover el archivo
    $rutaDestino = "video/" . $nombreArchivo;

    // Verifica que sea un archivo de video permitido (puedes personalizar las extensiones permitidas)
    $extensionesPermitidas = array("mp4", "avi", "mov");
    $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
    if (!in_array($extension, $extensionesPermitidas)) {
        $addError = "Error: Solo se permiten videos en formato MP4, AVI o MOV.";
    } else {
        // Mueve el archivo al destino
        if (move_uploaded_file($archivoTmp, $rutaDestino)) {
            header("location: classes");
        } else {
            $addError =  "Error al mover el video a la nueva ubicación.";
        }

        // Aquí puedes continuar con la inserción del título y la ruta en la base de datos si es necesario
    }
    include('Chat.php');
    $chat = new Chat();
    $lastInsertId = $chat->insetarVideo($titulo, $nombreArchivo, $extension);
} else {
    $addError = 'error';
}
?>



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
                    Add a new class
                </h2>
            </div>
            <div class="grid grid-cols-12 gap-6 mt-5">
                <div class="intro-y col-span-12 lg:col-span-12">
                    <!-- BEGIN: Vertical Form -->
                    <div class="intro-y box">
                        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                            <h2 class="font-medium text-base mr-auto">
                                Register class
                            </h2>
                        </div>
                        <div id="vertical-form" class="p-5">
                            <form method="post" enctype="multipart/form-data">
                                <?php if ($addError) { ?>
                                    <div class="alert-error"><?php echo $addError; ?></div>
                                <?php } ?>
                                <div class="preview">
                                    <div>
                                        <label for="titulo" class="form-label">Video title*</label>
                                        <input type="text" name="titulo" class="form-control" placeholder="College name" required>
                                    </div>
                                    <div class="mt-3">
                                        <label for="archivo" class="form-label">Select a video*</label>
                                        <input type="file" name="archivo" accept=".mp4, .avi, .mov" required>
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