<?php if (session_status() == PHP_SESSION_NONE) { session_start(); } ?>

<!-- Main Header Nav -->
<header class="header-nav menu_style_home_one style2 navbar-scrolltofixed stricky main-menu scroll-to-fixed-fixed slideIn animated">
    <div class="container p0">
        <!-- Ace Responsive Menu -->
        <nav>
            <!-- Menu Toggle btn-->
            <div class="menu-toggle">
                <img class="nav_logo_img img-fluid" src="../images/dark-logo.png" alt="header-logo.png">
                <button type="button" id="menu-btn">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <a href="#" class="navbar_brand float-left dn-smd">
                <img class="logo1 img-fluid"
                    src="../images/dark-logo.png"
                    alt="header-logo.png">
                <img class="logo2 img-fluid"
                    src="../images/dark-logo.png"
                    alt="header-logo2.png">
            </a>
            <!-- Responsive Menu Structure-->
            <!--Note: declare the Menu style in the data-menu-style="horizontal" (options: horizontal, vertical, accordion) -->
            <ul id="respMenu" class="ace-responsive-menu text-right" data-menu-style="horizontal">
                <li>
                    <a href="index.php"><span class="title">Home</span></a>
                </li>
                <li>
                    <a href="about-us.php"><span class="title">About Us</span></a>
                </li>
                <li>
                    <a href="properties.php"><span class="title">Properties</span></a>
                </li>
                <li>
                    <a href="agent.php"><span class="title">Agent</span></a>
                </li>
                <li>
                    <a href="faq.php"><span class="title">FAQ</span></a>
                </li>
                <li>
                    <a href="contact.php"><span class="title">Contact</span></a>
                </li>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="user_setting">
                        <div class="dropdown menu-active">
                            <a class="btn dropdown-toggle" href="#" data-toggle="dropdown">
                                <?php
                                $user_photo = !empty($_SESSION['photo']) ? '../../' . $_SESSION['photo'] : '../images/profile.png';
                                ?>
                                <img class="rounded-circle" src="<?php echo htmlspecialchars($user_photo); ?>" alt="profile">
                                <span class="dn-1199"><?php echo htmlspecialchars($_SESSION['username']); ?></span>
                            </a>
                            <div class="dropdown-menu">
                                <div class="user_set_header">
                                    <img class="float-left" src="https://creativelayers.net/themes/findhouse-html/images/team/e1.png" alt="profile">
                                    <p><?php echo htmlspecialchars($_SESSION['username']); ?><br>
                                        <span class="address"><?php echo htmlspecialchars($_SESSION['email']); ?></span>
                                    </p>
                                </div>
                                <div class="user_setting_content">
                                    <a class="dropdown-item active" href="admin/profile.php">My Profile</a>
                                    <a class="dropdown-item" href="admin/dashboard.php">Dashboard</a>
                                    <a class="dropdown-item" href="admin/properties-list.php">My Properties</a>
                                    <a class="dropdown-item" href="logout.php">Log out</a>
                                </div>
                            </div>
                        </div>
                    </li>
                <?php else: ?>
                    <li class="list-inline-item add_listing">
                        <a href="login.php" class="btn flaticon-user"><span class="dn-lg ml10">Login/Register</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>
<!-- Main Header Nav For Mobile -->
<div id="page" class="stylehome1 h0">
    <div class="mobile-menu">
        <div class="header stylehome1">
            <div class="d-flex justify-content-between">
                <a class="mobile-menu-trigger" href="#menu">
                    <img src="https://creativelayers.net/themes/findhouse-html/images/dark-nav-icon.svg" alt=""></a>
                <a class="nav_logo_img" href="index.html">
                    <img class="img-fluid mt20"
                        src="../images/dark-logo.png" width="180" alt="header-logo2.png"></a>
                <a class="mobile-menu-reg-link" href="page-register.html"><span
                        class="flaticon-user"></span></a>
            </div>
        </div>
    </div>
</div>

<script>
    const header = document.querySelector('.header-nav');

    window.addEventListener('scroll', function() {
        if (window.scrollY >= 95) {
            header.classList.add('stricky-fixed');
        } else {
            header.classList.remove('stricky-fixed');
        }
    });
</script>