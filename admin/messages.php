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
                Global message
                </h2>
                <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                    <a href="add_message" class="btn btn-primary shadow-md mr-2">Add global message</a>
                </div>
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
                                <th class="whitespace-nowrap">Message</th>
                                <th class="whitespace-nowrap">Action</th>
                                <!-- <th class="whitespace-nowrap">Photo</th>
                                <th class="whitespace-nowrap">Location</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $chat = new  Chat();
                            $sql = "select * from chat_users LIMIT 1";
                            $result = $chat->query($sql);
                            $poss = 0;
                            while ($row = $result->fetch_assoc()) {
                                $poss++;
                            ?>
                                <tr>
                                    <td><?php echo $poss ?></td>
                                    <?php if(!$row['mensaje']) { ?> 
                                    
                                     
                                        <td colspan="3"><p>No hay ningún mensaje<p></td>
                                    <?php
                                    
                                }else{ ?>
   <td><p><?php echo  $row['mensaje']; ?> <p></td>
                                    
                                    <td><a class="delete flex items-center text-danger" href="action.php?action=deletemessage"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="trash-2" data-lucide="trash-2" class="lucide lucide-trash-2 w-4 h-4 mr-1">
                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                <path d="M19 6v14a2 2 0 01-2 2H7a2 2 0 01-2-2V6m3 0V4a2 2 0 012-2h4a2 2 0 012 2v2"></path>
                                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                                <line x1="14" y1="11" x2="14" y2="17"></line>
                                            </svg>Delete </a>

                                        </a></td>
                                 <?php 
                                 }
                                        
                                    ?>
                               
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