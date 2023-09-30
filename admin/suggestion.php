<!-- BEGIN: Head -->
<?php
$title = 'Dashboard principal';
include("page-master/head.php");
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
            <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
                <h2 class="text-lg font-medium mr-auto">
                Suggestion box
                </h2>
            </div>
            <!-- BEGIN: HTML Table Data -->
            <div class="intro-y box p-5 mt-5">
                <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                </div>

                <div class="overflow-x-auto">
                    <table class="table">
                        <thead class="table-dark">
                            <tr>
                                <th class="whitespace-nowrap">#</th>
                                <th class="whitespace-nowrap">Name</th>
                                <th class="whitespace-nowrap">Suggestion</th>
                                <th class="whitespace-nowrap">Email</th>
                                <!-- <th class="whitespace-nowrap">Photo</th>
                                <th class="whitespace-nowrap">Location</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $chat = new  Chat();
                            $sql = "select * from suggestion";
                            $result = $chat->query($sql);
                            $poss = 0;
                            while ($row = $result->fetch_assoc()) {
                                $poss++;
                            ?>
                                <tr>
                                    <td><?php echo $poss ?></td>
                                    <td><?php echo $row['name']; ?></td>
                                    <td><?php echo $row['suggestion']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                </tr>
                            <?php }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- END: HTML Table Data -->
        </div>


        <!-- END: Side Menu -->
        <!-- BEGIN: Content -->

        <!-- END: Content -->
    </div>
    <!-- BEGIN: Dark Mode Switcher-->
    <!-- <div data-url="side-menu-light-dashboard-overview-2.html" class="dark-mode-switcher cursor-pointer shadow-md fixed bottom-0 right-0 box dark:bg-dark-2 border rounded-full w-40 h-12 flex items-center justify-center z-50 mb-10 mr-10">
        <div class="mr-4 text-gray-700 dark:text-gray-300">Dark Mode</div>
        <div class="dark-mode-switcher__toggle dark-mode-switcher__toggle--active border"></div>
    </div> -->
    <!-- END: Dark Mode Switcher-->

    <!-- BEGIN: JS Assets-->
    <?php
    include('page-master/js.php');
    ?>
</body>

</html>