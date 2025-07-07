   
   <?php
   
    $curr_user = $user->GetData($_SESSION['TOKEN']);

    ?>
   <!-- header start -->
    <div class="header">
        <div class="row g-0 align-items-center">
            <div class="col-xxl-6 col-xl-5 col-4 d-flex align-items-center gap-20">
                <div class="main-logo d-lg-block d-none">
                    <div class="logo-big">
                        <a href="">
                            <img src="assets/logo/logo.png" alt="Logo" width="70%">
                        </a>
                    </div>
                    <div class="logo-small">
                        <a href="">
                            <img src="assets/logo/logo.png" alt="Logo" width="70%">
                        </a>
                    </div>
                </div>
                <div class="nav-close-btn">
                    <button id="navClose"><i class="fa-light fa-bars-sort"></i></button>
                </div>
            </div>
            <div class="col-4 d-lg-none">
                <div class="mobile-logo">
                    <a href="">
                        <img src="assets/logo/logo.png" width="70%" alt="Logo">
                    </a>
                </div>
            </div>
            <div class="col-xxl-6 col-xl-7 col-lg-8 col-4">
                <div class="header-right-btns d-flex justify-content-end align-items-center">

                    <button class="header-btn theme-settings-btn d-lg-none"><i class="fa-light fa-gear"></i></button>
                    <div class="header-btn-box profile-btn-box">
                        <button class="profile-btn" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="assets/images/admin.png" alt="image">
                        </button>
                        <ul class="dropdown-menu profile-dropdown-menu">
                            <li>
                                <div class="dropdown-txt text-center">
                                    <p class="mb-0"><?php echo $curr_user['USERNAME']; ?></p>
                                  
                 
                                </div>
                            </li>
                            <li><a class="dropdown-item" href="./?p=profil"><span class="dropdown-icon"><i class="fa-regular fa-circle-user"></i></span> Profile</a></li>

                            <li><hr class="dropdown-divider"></li>

                            <li><a class="dropdown-item" href="./?p=logout"><span class="dropdown-icon"><i class="fa-regular fa-arrow-right-from-bracket"></i></span> Logout</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- header end -->

    <!-- profile right sidebar start -->
    <div class="profile-right-sidebar">
        <button class="right-bar-close"><i class="fa-light fa-angle-right"></i></button>
        <div class="top-panel">
            <div class="profile-content scrollable">
                <ul>

                    <li>
                        <a class="dropdown-item" href="./?p=profil"><span class="dropdown-icon"><i class="fa-regular fa-circle-user"></i></span> Profile</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="./?p=logout"><span class="dropdown-icon"><i class="fa-regular fa-arrow-right-from-brackets"></i></span> Logout</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="bottom-panel">
            <div class="button-group">
                <a href="./?p=profil><i class="fa-light fa-gear"></i><span>Profil</span></a>
                <a href="./?p=logout"><i class="fa-regular fa-arrow-right-from-bracket"></i><span>Logout</span></a>
            </div>
        </div>
    </div>
    <!-- profile right sidebar end -->




    <!-- main sidebar start -->
    <div class="main-sidebar">
        <div class="main-menu">
            <ul class="sidebar-menu scrollable">
                <li class="sidebar-item">
                    <a role="button" class="sidebar-link-group-title has-sub">Manage</a>
                    <ul class="sidebar-link-group">
                        <li class="sidebar-dropdown-item">
                            <a href="./?p=home" class="sidebar-link"><span class="nav-icon"><i class="fa-light fa-cart-shopping-fast"></i></span> <span class="sidebar-txt">Home</span></a>
                        </li>
                        <li class="sidebar-dropdown-item">
                            <a href="./?p=bots" class="sidebar-link"><span class="nav-icon"><i class="fa-light fa-users"></i></span> <span class="sidebar-txt">Bots</span></a>
                        </li>
                        <li class="sidebar-dropdown-item">
                            <a href="./?p=tasks" class="sidebar-link"><span class="nav-icon"><i class="fa-light fa-file"></i></span> <span class="sidebar-txt">Tasks</span></a>
                        </li>
                        <li class="sidebar-dropdown-item">
                            <a href="./?p=groups" class="sidebar-link"><span class="nav-icon"><i class="fa-light fa-list"></i></span> <span class="sidebar-txt">Group</span></a>
                        </li>
                        <li class="sidebar-dropdown-item">
                            <a href="./?p=ddos_history" class="sidebar-link"><span class="nav-icon"><i class="fa-light fa-file"></i></span> <span class="sidebar-txt">Ddos History</span></a>
                        </li>
                        <li class="sidebar-dropdown-item">
                            <a href="./?p=dlexec_history" class="sidebar-link"><span class="nav-icon"><i class="fa-light fa-file"></i></span> <span class="sidebar-txt">Dl Exec History</span></a>
                        </li>
                    </ul>
                </li>


            </ul>
        </div>
    </div>
    <!-- main sidebar end -->