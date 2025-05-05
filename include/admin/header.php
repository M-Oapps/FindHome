<<<<<<< HEAD
<?php if (session_status() == PHP_SESSION_NONE) { session_start(); } ?>
=======
<?php session_start(); ?>
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a

<header class="header-nav menu_style_home_one style2 navbar-scrolltofixed stricky main-menu">
    <div class="container-fluid p0">
        <!-- Ace Responsive Menu -->
        <nav>
            <!-- Menu Toggle btn-->
            <div class="menu-toggle">
                <img class="nav_logo_img img-fluid" src="../../images//light-logo.png" alt="header-logo.png">
                <button type="button" id="menu-btn">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <ul id="respMenu" class="ace-responsive-menu text-right" data-menu-style="horizontal">
                <li>
                    <a href="../index.php"><span class="title">Home</span></a>
                </li>
                <li>
                    <a href="../about-us.php"><span class="title">About Us</span></a>
                </li>
                <li>
                    <a href="../properties.php"><span class="title">Properties</span></a>
                </li>
                <li>
                    <a href="../agent.php"><span class="title">Agent</span></a>
                </li>
                <li>
                    <a href="../faq.php"><span class="title">FAQ</span></a>
                </li>
                <li class="last">
                    <a href="../contact.php"><span class="title">Contact</span></a>
                </li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="user_setting">
                        <div class="dropdown menu-active">
                            <a class="btn dropdown-toggle" href="#">
                                <?php
                                $user_photo = !empty($_SESSION['photo']) ? '../../../' . $_SESSION['photo'] : '../../images/profile.png';
                                ?>
                                <img class="rounded-circle" src="<?php echo htmlspecialchars($user_photo); ?>" alt="profile">
                                <span class="dn-1199"><?php echo htmlspecialchars($_SESSION['username']); ?>
                                </span>
                            </a>
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>

<div class="dashboard_sidebar_menu dn-992">
    <ul class="sidebar-menu">
        <li class="header">
            <img src="../../images//light-logo.png" alt="header-logo2.png">
        </li>
        <li class="title"><span>Main</span></li>
        <li class="treeview"><a href="../../pages/admin/dashboard.php"><i class="flaticon-layers"></i><span>
                    Dashboard</span></a>
        </li>
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <li class="treeview"><a href="../../pages/admin/user-list.php"><i class="flaticon-user"></i><span>
                        User/Agent</span></a>
            <li class="treeview"><a href="../../pages/admin/city-list.php"><i class="flaticon-placeholder"></i><span>
                        City</span></a>
            <li class="treeview"><a href="../../pages/admin/property-type-list.php"><i class="flaticon-building"></i><span>
                        Property Type</span></a>
            <?php endif; ?>
            <li class="treeview"><a href="../../pages/admin/properties-list.php"><i class="flaticon-home"></i><span>
                        My Properties</span></a>
            </li>
            <li class="treeview"><a href="../../pages/admin/review-list.php"><i class="flaticon-chat"></i><span>
                        Reviews</span></a>
            </li>
            <li class="title"><span>Manage Account</span></li>
            <li><a href="../../pages/admin/profile.php"><i class="flaticon-user"></i> <span>My Profile</span></a></li>
            <li><a href="../../pages/admin/change-password.php"><i class="flaticon-box"></i> <span>Change password</span></a></li>
            <li><a href="../../pages/logout.php"><i class="flaticon-logout"></i> <span>Logout</span></a></li>
            <!-- <li id="myProperties" class="treeview">
            <a href="../../pages/admin/properties-list.php"><i class="flaticon-home"></i> <span>My Properties</span><i
                    class="fa fa-angle-down pull-right"></i></a>
            <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle"></i> General Elements</a></li>
                <li><a href="#"><i class="fa fa-circle"></i> Advanced Elements</a></li>
                <li><a href="#"><i class="fa fa-circle"></i> Editors</a></li>
            </ul>
        </li> -->
    </ul>
</div>