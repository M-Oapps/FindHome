<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="images/favicon.ico">
    <link rel="stylesheet" href="../../css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <title>Review List Page</title>
</head>

<body>
    <div class="wrapper">

        <!--	Header start  -->
        <?php include "../../include/admin/header.php"; ?>
        <!--	Header end  -->

        <section class="our-dashbord dashbord bgc-f7 pb50">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12 col-lg-12 col-xl-12 maxw100flex-992">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="dashboard_navigationbar dn db-992">
                                    <div class="dropdown">
                                        <button onclick="myFunction()" class="dropbtn"><i class="fa fa-bars pr10"></i> Dashboard
                                            Navigation</button>
                                        <ul id="myDropdown" class="dropdown-content">
                                            <li><a href="page-dashboard.html"><span class="flaticon-layers"></span>
                                                    Dashboard</a></li>
                                            <li><a href="page-message.html"><span class="flaticon-envelope"></span> Message</a>
                                            </li>
                                            <li><a href="page-my-properties.html"><span class="flaticon-home"></span> My
                                                    Properties</a></li>
                                            <li><a href="page-my-favorites.html"><span class="flaticon-heart"></span> My
                                                    Favorites</a></li>
                                            <li><a href="page-my-savesearch.html"><span
                                                        class="flaticon-magnifying-glass"></span> Saved Search</a></li>
                                            <li class="active"><a href="page-my-review.html"><span class="flaticon-chat"></span>
                                                    My Reviews</a></li>
                                            <li><a href="page-my-packages.html"><span class="flaticon-box"></span> My
                                                    Package</a></li>
                                            <li><a href="page-my-profile.html"><span class="flaticon-user"></span> My
                                                    Profile</a></li>
                                            <li><a href="page-add-new-property.html"><span
                                                        class="flaticon-filter-results-button"></span> Add New Listing</a></li>
                                            <li><a href="page-login.html"><span class="flaticon-logout"></span> Logout</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-8 col-xl-9 mb10">
                                <div class="breadcrumb_content style2">
                                    <h2 class="breadcrumb_title">Reviews</h2>
                                    <p>We are glad to see you again!</p>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xl-3 mb10">
                                <ul class="sasw_list mb0">
                                    <li class="search_area">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="exampleInputName1" placeholder="Search">
                                            <label for="exampleInputEmail"><span
                                                    class="flaticon-magnifying-glass"></span></label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div id="myreview" class="my_dashboard_review">
                                    <div class="review_content">
                                        <h4>My Reviews</h4>
                                        <div class="media pb30 mt30 bb1">
                                            <img class="mr-3" src="https://creativelayers.net/themes/findhouse-html/images/resource/review.png" alt="Review image">
                                            <div class="media-body">
                                                <h5 class="review_title mt-0">Your review on <span class="text-thm">Villa called
                                                        Archangel</span>
                                                    <span class="sspd_review float-right">
                                                        <ul>
                                                            <li class="list-inline-item"><a href="#"><i
                                                                        class="fa fa-star"></i></a></li>
                                                            <li class="list-inline-item"><a href="#"><i
                                                                        class="fa fa-star"></i></a></li>
                                                            <li class="list-inline-item"><a href="#"><i
                                                                        class="fa fa-star"></i></a></li>
                                                            <li class="list-inline-item"><a href="#"><i
                                                                        class="fa fa-star"></i></a></li>
                                                            <li class="list-inline-item"><a href="#"><i
                                                                        class="fa fa-star"></i></a></li>
                                                        </ul>
                                                    </span>
                                                </h5>
                                                <a class="review_date" href="#">December 28, 2020</a>
                                                <p class="para">Beautiful home, very picturesque and close to everything in
                                                    jtree! A little warm for a hot weekend, but would love to come back during
                                                    the cooler seasons! Lorem ipsum dolor sit amet, consectetur adipisicing
                                                    elit. Accusantium voluptates eum, velit recusandae, ducimus earum aperiam
                                                    commodi error officia optio aut et quae nam nostrum!</p>
                                                <ul class="view_edit_delete_list mb0 mt35">
                                                    <li class="list-inline-item" data-toggle="tooltip" data-placement="top"
                                                        title="" data-original-title="Edit"><a href="#"><span
                                                                class="flaticon-edit"></span></a></li>
                                                    <li class="list-inline-item" data-toggle="tooltip" data-placement="top"
                                                        title="" data-original-title="Delete"><a href="#"><span
                                                                class="flaticon-garbage"></span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="media mt30">
                                            <img class="mr-3" src="https://creativelayers.net/themes/findhouse-html/images/resource/review.png" alt="Review image">
                                            <div class="media-body">
                                                <h5 class="review_title mt-0">Your review on <span class="text-thm">Sunset
                                                        Studio</span>
                                                    <span class="sspd_review float-right">
                                                        <ul>
                                                            <li class="list-inline-item"><a href="#"><i
                                                                        class="fa fa-star"></i></a></li>
                                                            <li class="list-inline-item"><a href="#"><i
                                                                        class="fa fa-star"></i></a></li>
                                                            <li class="list-inline-item"><a href="#"><i
                                                                        class="fa fa-star"></i></a></li>
                                                            <li class="list-inline-item"><a href="#"><i
                                                                        class="fa fa-star"></i></a></li>
                                                            <li class="list-inline-item"><a href="#"><i
                                                                        class="fa fa-star"></i></a></li>
                                                        </ul>
                                                    </span>
                                                </h5>
                                                <a class="review_date" href="#">December 28, 2020</a>
                                                <p class="para">Beautiful home, very picturesque and close to everything in
                                                    jtree! A little warm for a hot weekend, but would love to come back during
                                                    the cooler seasons! Lorem ipsum dolor sit amet, consectetur adipisicing
                                                    elit. Accusantium voluptates eum, velit recusandae, ducimus earum aperiam
                                                    commodi error officia optio aut et quae nam nostrum!</p>
                                                <ul class="view_edit_delete_list mb0 mt35">
                                                    <li class="list-inline-item" data-toggle="tooltip" data-placement="top"
                                                        title="" data-original-title="Edit"><a href="#"><span
                                                                class="flaticon-edit"></span></a></li>
                                                    <li class="list-inline-item" data-toggle="tooltip" data-placement="top"
                                                        title="" data-original-title="Delete"><a href="#"><span
                                                                class="flaticon-garbage"></span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div id="client_myreview" class="my_dashboard_review mt30">
                                    <div class="review_content">
                                        <h4>Visitor Reviews</h4>
                                        <div class="media pb30 mt30 bb1">
                                            <img class="mr-3" src="https://creativelayers.net/themes/findhouse-html/images/resource/review2.png" alt="Review image">
                                            <div class="media-body">
                                                <h5 class="review_title mt-0">Kathy Brown <span class="text-thm">Villa called
                                                        Archangel</span>
                                                    <span class="sspd_review float-right">
                                                        <ul>
                                                            <li class="list-inline-item"><a href="#"><i
                                                                        class="fa fa-star"></i></a></li>
                                                            <li class="list-inline-item"><a href="#"><i
                                                                        class="fa fa-star"></i></a></li>
                                                            <li class="list-inline-item"><a href="#"><i
                                                                        class="fa fa-star"></i></a></li>
                                                            <li class="list-inline-item"><a href="#"><i
                                                                        class="fa fa-star"></i></a></li>
                                                            <li class="list-inline-item"><a href="#"><i
                                                                        class="fa fa-star"></i></a></li>
                                                        </ul>
                                                    </span>
                                                </h5>
                                                <a class="review_date" href="#">December 28, 2020</a>
                                                <p class="para">Beautiful home, very picturesque and close to everything in
                                                    jtree! A little warm for a hot weekend, but would love to come back during
                                                    the cooler seasons! Lorem ipsum dolor sit amet, consectetur adipisicing
                                                    elit. Accusantium voluptates eum, velit recusandae, ducimus earum aperiam
                                                    commodi error officia optio aut et quae nam nostrum!</p>
                                                <ul class="view_edit_delete_list mb0 mt35">
                                                    <li class="list-inline-item" data-toggle="tooltip" data-placement="top"
                                                        title="" data-original-title="Reply"><a href="#"><span
                                                                class="flaticon-reply"></span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="media pb30 mt30 bb1">
                                            <img class="mr-3" src="https://creativelayers.net/themes/findhouse-html/images/resource/review3.png" alt="Review image">
                                            <div class="media-body">
                                                <h5 class="review_title mt-0">Nina Wallker <span class="text-thm">Sunset
                                                        Studio</span>
                                                    <span class="sspd_review float-right">
                                                        <ul>
                                                            <li class="list-inline-item"><a href="#"><i
                                                                        class="fa fa-star"></i></a></li>
                                                            <li class="list-inline-item"><a href="#"><i
                                                                        class="fa fa-star"></i></a></li>
                                                            <li class="list-inline-item"><a href="#"><i
                                                                        class="fa fa-star"></i></a></li>
                                                            <li class="list-inline-item"><a href="#"><i
                                                                        class="fa fa-star"></i></a></li>
                                                            <li class="list-inline-item"><a href="#"><i
                                                                        class="fa fa-star"></i></a></li>
                                                        </ul>
                                                    </span>
                                                </h5>
                                                <a class="review_date" href="#">December 28, 2020</a>
                                                <p class="para">Beautiful home, very picturesque and close to everything in
                                                    jtree! A little warm for a hot weekend, but would love to come back during
                                                    the cooler seasons! Lorem ipsum dolor sit amet, consectetur adipisicing
                                                    elit. Accusantium voluptates eum, velit recusandae, ducimus earum aperiam
                                                    commodi error officia optio aut et quae nam nostrum!</p>
                                                <ul class="view_edit_delete_list mb0 mt35">
                                                    <li class="list-inline-item" data-toggle="tooltip" data-placement="top"
                                                        title="" data-original-title="Reply"><a href="#"><span
                                                                class="flaticon-reply"></span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="media mt30">
                                            <img class="mr-3" src="https://creativelayers.net/themes/findhouse-html/images/resource/review4.png" alt="Review image">
                                            <div class="media-body">
                                                <h5 class="review_title mt-0">Anna Harrison <span class="text-thm">Nice Room
                                                        With View</span>
                                                    <span class="sspd_review float-right">
                                                        <ul>
                                                            <li class="list-inline-item"><a href="#"><i
                                                                        class="fa fa-star"></i></a></li>
                                                            <li class="list-inline-item"><a href="#"><i
                                                                        class="fa fa-star"></i></a></li>
                                                            <li class="list-inline-item"><a href="#"><i
                                                                        class="fa fa-star"></i></a></li>
                                                            <li class="list-inline-item"><a href="#"><i
                                                                        class="fa fa-star"></i></a></li>
                                                            <li class="list-inline-item"><a href="#"><i
                                                                        class="fa fa-star"></i></a></li>
                                                        </ul>
                                                    </span>
                                                </h5>
                                                <a class="review_date" href="#">December 28, 2020</a>
                                                <p class="para">Beautiful home, very picturesque and close to everything in
                                                    jtree! A little warm for a hot weekend, but would love to come back during
                                                    the cooler seasons! Lorem ipsum dolor sit amet, consectetur adipisicing
                                                    elit. Accusantium voluptates eum, velit recusandae, ducimus earum aperiam
                                                    commodi error officia optio aut et quae nam nostrum!</p>
                                                <ul class="view_edit_delete_list mb0 mt35">
                                                    <li class="list-inline-item" data-toggle="tooltip" data-placement="top"
                                                        title="" data-original-title="Reply"><a href="#"><span
                                                                class="flaticon-reply"></span></a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt50">
                            <div class="col-lg-12">
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