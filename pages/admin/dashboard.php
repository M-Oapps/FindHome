<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="images/favicon.ico">
    <link rel="stylesheet" href="../../css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <title>Dashboard Page</title>
</head>

<body>
    <div class="wrapper">

        <!--	Header start  -->
        <?php include "../../include/admin/header.php"; ?>
        <!--	Header end  -->

        <section class="our-dashbord dashbord bgc-f7 pb50">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-xl-12 maxw100flex-992">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="dashboard_navigationbar dn db-992">
                                    <div class="dropdown">
                                        <button onclick="myFunction()" class="dropbtn"><i class="fa fa-bars pr10"></i>
                                            Dashboard
                                            Navigation</button>
                                        <ul id="myDropdown" class="dropdown-content">
                                            <li class="active"><a href="page-dashboard.html"><span
                                                        class="flaticon-layers"></span> Dashboard</a></li>
                                            <li><a href="page-message.html"><span class="flaticon-envelope"></span>
                                                    Message</a>
                                            </li>
                                            <li><a href="page-my-properties.html"><span class="flaticon-home"></span> My
                                                    Properties</a></li>
                                            <li><a href="page-my-favorites.html"><span class="flaticon-heart"></span> My
                                                    Favorites</a></li>
                                            <li><a href="page-my-savesearch.html"><span
                                                        class="flaticon-magnifying-glass"></span> Saved Search</a></li>
                                            <li><a href="page-my-review.html"><span class="flaticon-chat"></span> My
                                                    Reviews</a>
                                            </li>
                                            <li><a href="page-my-packages.html"><span class="flaticon-box"></span> My
                                                    Package</a></li>
                                            <li><a href="page-my-profile.html"><span class="flaticon-user"></span> My
                                                    Profile</a></li>
                                            <li><a href="page-add-new-property.html"><span
                                                        class="flaticon-filter-results-button"></span> Add New
                                                    Listing</a></li>
                                            <li><a href="page-login.html"><span class="flaticon-logout"></span>
                                                    Logout</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mb10">
                                <div class="breadcrumb_content style2">
                                    <h2 class="breadcrumb_title">Howdy, Ali!</h2>
                                    <p>We are glad to see you again!</p>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3">
                                <div class="ff_one">
                                    <div class="icon"><span class="flaticon-home"></span></div>
                                    <div class="detais">
                                        <div class="timer">37</div>
                                        <p>All Properties</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3">
                                <div class="ff_one style2">
                                    <div class="icon"><span class="flaticon-view"></span></div>
                                    <div class="detais">
                                        <div class="timer">24</div>
                                        <p>Total Views</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3">
                                <div class="ff_one style3">
                                    <div class="icon"><span class="flaticon-chat"></span></div>
                                    <div class="detais">
                                        <div class="timer">12</div>
                                        <p>Total Visitor Reviews</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-3">
                                <div class="ff_one style4">
                                    <div class="icon"><span class="flaticon-heart"></span></div>
                                    <div class="detais">
                                        <div class="timer">18</div>
                                        <p>Total Favorites</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="recent_job_activity">
                                    <h4 class="title">Recent Activities</h4>
                                    <div class="grid">
                                        <ul>
                                            <li class="list-inline-item">
                                                <div class="icon"><span class="flaticon-home"></span></div>
                                            </li>
                                            <li class="list-inline-item">
                                                <p>Your listing <strong>Luxury Family Home</strong> has been approved!.
                                                </p>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="grid">
                                        <ul>
                                            <li class="list-inline-item">
                                                <div class="icon"><span class="flaticon-chat"></span></div>
                                            </li>
                                            <li class="list-inline-item">
                                                <p>Kathy Brown left a review on <strong>Renovated Apartment</strong></p>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="grid">
                                        <ul>
                                            <li class="list-inline-item">
                                                <div class="icon"><span class="flaticon-heart"></span></div>
                                            </li>
                                            <li class="list-inline-item">
                                                <p>Someone favorites your <strong>Gorgeous Villa Bay View</strong>
                                                    listing!</p>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="grid">
                                        <ul>
                                            <li class="list-inline-item">
                                                <div class="icon"><span class="flaticon-home"></span></div>
                                            </li>
                                            <li class="list-inline-item">
                                                <p>Your listing <strong>Luxury Family Home</strong> has been approved!
                                                </p>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="grid">
                                        <ul>
                                            <li class="list-inline-item">
                                                <div class="icon"><span class="flaticon-chat"></span></div>
                                            </li>
                                            <li class="list-inline-item">
                                                <p>Kathy Brown left a review on <strong>Renovated Apartment</strong></p>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="grid mb0">
                                        <ul class="pb0 mb0 bb_none">
                                            <li class="list-inline-item">
                                                <div class="icon"><span class="flaticon-heart"></span></div>
                                            </li>
                                            <li class="list-inline-item">
                                                <p>Someone favorites your <strong>Gorgeous Villa Bay</strong> View
                                                    listing!</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt50">
                            <div class="col-lg-6 offset-lg-3">
                                <div class="copyright-widget text-center">
                                    <p>© <?php echo date('Y'); ?> Home Find. All rights reserved.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <a class="scrollToHome" href="#"><i class="flaticon-arrows"></i></a>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://code.jquery.com/jquery-migrate-3.0.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../Js/jquery.mmenu.all.js"></script>
    <script type="text/javascript" src="../js/bootstrap-select.min.js"></script>

</body>

</html>