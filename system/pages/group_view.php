<?php
$curr_group = $group->GetData($_GET['token']);
?>
<?php
if (!$user->CheckLogin()) {
    $page = $tpl->GetPage("login");
    require_once $page;
    die();
}
$curr_user = $user->GetData($_SESSION['TOKEN']);
if (!$group->CheckToken($_GET['token'])) {
    $page = $tpl->GetPage("home");
    require_once $page;
    die();
}
?>
<!DOCTYPE html>
<html lang="en" data-menu="vertical" data-nav-size="nav-default">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table | Digiboard</title>

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

        <div class="dashboard-breadcrumb mb-25">
            <h2>Edit Group</h2>
        </div>
        <div class="row">
            <div class="row">
                <div class="col-12">
                    <div class="panel">
                        <div class="panel-body">
                            <form method="POST">
                                <?php
                                if (isset($_POST['Update'])) {

                                    $group->Edit(array(
                                        "TOKEN" => @$_GET['token'],
                                        "NAME" => @$_POST['group'],
                                        "STATUS" => @$_POST['status']
                                    ));
                                }
                                if (isset($_POST['delete'])) {
                                    $group->Delete($_POST['delete']);
                                }

                                ?>
                                <?php
                                $curr_group = $group->GetData($_GET['token']);
                                ?>
                                <div class="">
                                    <div class="row g-3">


                                        <div class="col-sm-6">
                                            <h6>Group name</h6>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa-light fa-info"></i></span>
                                                <input type="text" name="group" class="form-control" placeholder="Default" value="<?php echo $curr_group['NAME'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <h6>Group status</h6>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="fa-light fa-info"></i></span>
                                                <select class="form-select" name="status" aria-label="Default select example">
                                                    <option value="true" <?php if ($curr_group['STATUS'] == "1") {
                                                                                echo "selected";
                                                                            } ?>>Active</option>
                                                    <option value="false" <?php if ($curr_group['STATUS'] == "0") {
                                                                                echo "selected";
                                                                            } ?>>Inactive</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button name="Update" type="submit" class="btn btn-primary">Update Group</button>
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