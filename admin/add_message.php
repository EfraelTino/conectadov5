<!-- BEGIN: Head -->
<?php
$title = 'Dashboard principal';
include("page-master/head.php");
$addError = '';

    if (!empty($_POST['message'])) {
        // Capturamos los datos del formulario
        $nombre_uni = $_POST['message'];
        // Llama a tu función insertarUniversidad después de procesar la foto
        include('Chat.php');
        $chat = new Chat();
        $lastInsertId = $chat->updateMessage($nombre_uni);
        header("location:  messages");

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
                    Add Message
                </h2>
            </div>
            <div class="grid grid-cols-12 gap-6 mt-5">
                <div class="intro-y col-span-12 lg:col-span-12">
                    <!-- BEGIN: Vertical Form -->
                    <div class="intro-y box">
                        <div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                            <h2 class="font-medium text-base mr-auto">
                                Register new Message
                            </h2>
                        </div>
                        <div id="vertical-form" class="p-5">
                            <form method="post" enctype="multipart/form-data">
                                <?php if ($addError) { ?>
                                    <div class="alert-error"><?php echo $addError; ?></div>
                                <?php } ?>
                                <div class="preview">
                                    <div>
                                        <label for="vertical-form-1" class="form-label">Message</label>
                                        <input name="message" type="text" class="form-control" placeholder="College name" required>
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