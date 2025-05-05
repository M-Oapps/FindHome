<?php
include "../include/db_connect.php";

$limit = 6;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$search = isset($_GET['name']) ? trim($_GET['name']) : '';
$search_sql = "WHERE role = 'agent'";
$params = [];

if (!empty($search)) {
    $search_sql .= " AND (first_name LIKE ? OR last_name LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

// Get total count for pagination
$count_sql = "SELECT COUNT(*) FROM users $search_sql";
$stmt = $conn->prepare($count_sql);
$stmt->execute($params);
$total = $stmt->fetchColumn();
$totalPages = ceil($total / $limit);

// Fetch agents
$data_sql = "SELECT * FROM users $search_sql ORDER BY id DESC LIMIT $start, $limit";
$stmt = $conn->prepare($data_sql);
$stmt->execute($params);
$agents = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Featured properties
$featured_sql = "SELECT * FROM properties WHERE is_featured = 1 LIMIT 5";
$featured_stmt = $conn->prepare($featured_sql);
$featured_stmt->execute();
$featured_properties = $featured_stmt->fetchAll(PDO::FETCH_ASSOC);

// Property categories with count
$categories_sql = "SELECT type, COUNT(*) as count FROM properties GROUP BY type";
$cat_stmt = $conn->prepare($categories_sql);
$cat_stmt->execute();
$property_categories = $cat_stmt->fetchAll(PDO::FETCH_ASSOC);

// Recently viewed
$recent_sql = "SELECT * FROM properties ORDER BY created_at DESC LIMIT 3";
$stmt = $conn->prepare($recent_sql);
$stmt->execute();
$recent_properties = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>


<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="images/favicon.ico">
    <link rel="stylesheet" href="../css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <title>Agent List Page</title>

</head>

<body>
    <div class="wrapper">
        <!-- <div class="preloader"></div> -->

        <!--	Header start  -->
        <?php include "../include/header.php"; ?>
        <!--	Header end  -->

        <section class="our-listing bgc-f7 pb30-991">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="breadcrumb_content style2 mb0-991">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active text-thm" aria-current="page">Simple Listing – Grid
                                    View</li>
                            </ol>
                            <h2 class="breadcrumb_title">All Agents</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-xl-4">
                        <div class="sidebar_listing_grid1">
                            <div class="sidebar_listing_list">
                                <div class="sidebar_advanced_search_widget">
                                    <h4 class="mb25">Find Agent</h4>
                                    <form method="GET">
                                        <ul class="sasw_list mb0">
                                            <li class="search_area">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" name="name"
                                                        value="<?php echo htmlspecialchars($_GET['name'] ?? '') ?>"
                                                        placeholder="Enter Agent Name">
                                                </div>
                                            </li>
                                            <li>
                                                <div class="search_option_button">
                                                    <button type="submit" class="btn btn-block btn-thm">Search</button>
                                                </div>
                                            </li>
                                        </ul>
                                    </form>
                                </div>
                            </div>
                            <div class="terms_condition_widget">
                                <h4 class="title">Featured Properties</h4>
                                <div class="sidebar_feature_property_slider owl-carousel owl-theme">
                                    <?php foreach ($featured_properties as $fp): ?>
                                        <div class="item">
                                            <div class="feat_property home7 agent">
                                                <div class="thumb">
                                                    <img class="img-whp"
                                                        src="<?php echo !empty($agent['photo']) ? '../' . $agent['photo'] : '../images/default-list.jpg'; ?>"
                                                        alt="<?php echo htmlspecialchars($agent['title']) ?>">
                                                    <div class="thmb_cntnt">
                                                        <ul class="tag mb0">
                                                            <li class="list-inline-item"><a
                                                                    href="#"><?php echo $fp['status'] ?></a></li>
                                                            <?php if ($fp['is_featured']): ?>
                                                                <li class="list-inline-item"><a href="#">Featured</a></li>
                                                            <?php endif; ?>
                                                        </ul>
                                                        <a class="fp_price"
                                                            href="#">$<?php echo number_format($fp['price']) ?><small>/<?php echo $fp['status'] == 'Rent' ? 'mo' : '' ?></small></a>
                                                        <h4 class="posr color-white">
                                                            <?php echo htmlspecialchars($fp['title']) ?>
                                                        </h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <div class="terms_condition_widget">
                                <h4 class="title">Categories Property</h4>
                                <div class="widget_list">
                                    <ul class="list_details">
                                        <?php foreach ($property_categories as $cat): ?>
                                            <li><a href="#"><i class="fa fa-caret-right mr10"></i><?php echo $cat['type'] ?>
                                                    <span class="float-right"><?php echo $cat['count'] ?>
                                                        properties</span></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                            <div class="sidebar_feature_listing">
                                <h4 class="title">Recently Viewed</h4>
                                <?php foreach ($recent_properties as $recent): ?>
                                    <div class="media">
                                        <img class="align-self-start mr-3 rounded"
                                            src="<?php echo !empty($recent['photo']) ? '../' . $recent['photo'] : '../images/default-list.jpg'; ?>"
                                            alt="<?php echo htmlspecialchars($recent['title']) ?>" width="90" height="80">
                                        <div class="media-body">
                                            <h5 class="mt-0 post_title"><?php echo htmlspecialchars($recent['title']) ?>
                                            </h5>
                                            <a
                                                href="#">$<?php echo number_format($recent['price']) ?>/<?php echo $recent['status'] == 'Rent' ? 'mo' : '' ?></a>
                                            <ul class="mb0">
                                                <li class="list-inline-item">Beds: <?php echo $recent['bedrooms'] ?></li>
                                                <li class="list-inline-item">Baths: <?php echo $recent['bathrooms'] ?></li>
                                                <li class="list-inline-item">Sq Ft:
                                                    <?php echo number_format((float) $recent['area'], 0) ?>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                <?php endforeach; ?>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-8">
                        <div class="row">
                            <div class="grid_list_search_result style2">
                                <div class="col-sm-12 col-md-4 col-lg-3 col-xl-3">
                                    <div class="left_area">
                                        <p><?php echo $total ?> Search results</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <?php foreach ($agents as $agent): ?>
                                <div class="col-md-6 col-lg-6">
                                    <div class="feat_property home7 agent">
                                        <div class="thumb">
                                            <img class="img-whp"
                                                src="<?php echo !empty($agent['photo']) ? '../' . $agent['photo'] : '../images/default-list.jpg'; ?>"
                                                alt="<?php echo htmlspecialchars($agent['username']) ?>" height="220">
                                        </div>
                                        <div class="details">
                                            <div class="tc_content">
                                                <h4><?php echo htmlspecialchars($agent['first_name'] . ' ' . $agent['last_name']); ?>
                                                </h4>
                                                <p class="text-thm">
                                                    <?php echo htmlspecialchars(ucfirst($agent['position'])) ?>
                                                </p>
                                                <ul class="prop_details mb0">
                                                    <?php if (!empty($agent['phone'])): ?>
                                                        <li><a
                                                                href="tel:<?php echo htmlspecialchars($agent['phone']) ?>">Office:<?php echo htmlspecialchars($agent['phone']) ?></a>
                                                        </li>
                                                    <?php endif; ?>
                                                    <?php if (!empty($agent['mobile'])): ?>
                                                        <li><a
                                                                href="tel:<?php echo htmlspecialchars($agent['mobile']) ?>">Mobile:<?php echo htmlspecialchars($agent['mobile']) ?></a>
                                                        </li>
                                                    <?php endif; ?>
                                                    <?php if (!empty($agent['fax_number'])): ?>
                                                        <li><a
                                                                href="#">Fax:<?php echo htmlspecialchars($agent['fax_number']) ?></a>
                                                        </li>
                                                    <?php endif; ?>
                                                    <?php if (!empty($agent['email'])): ?>
                                                        <li><a
                                                                href="mailto:<?php echo htmlspecialchars($agent['email']) ?>">Email:<?php echo htmlspecialchars($agent['email']) ?></a>
                                                        </li>
                                                    <?php endif; ?>
                                                </ul>
                                            </div>
                                            <div class="fp_footer">
                                                <ul class="fp_meta float-left mb0">
                                                    <?php if (!empty($agent['facebook'])): ?>
                                                        <li class="list-inline-item">
                                                            <a href="<?php echo htmlspecialchars($agent['facebook']) ?>"
                                                                target="_blank"><i class="fa fa-facebook"></i></a>
                                                        </li>
                                                    <?php endif; ?>
                                                    <?php if (!empty($agent['twitter'])): ?>
                                                        <li class="list-inline-item">
                                                            <a href="<?php echo htmlspecialchars($agent['twitter']) ?>"
                                                                target="_blank"><i class="fa fa-twitter"></i></a>
                                                        </li>
                                                    <?php endif; ?>
                                                    <?php if (!empty($agent['instagram'])): ?>
                                                        <li class="list-inline-item">
                                                            <a href="<?php echo htmlspecialchars($agent['instagram']) ?>"
                                                                target="_blank"><i class="fa fa-instagram"></i></a>
                                                        </li>
                                                    <?php endif; ?>
                                                    <?php if (!empty($agent['pinterest'])): ?>
                                                        <li class="list-inline-item">
                                                            <a href="<?php echo htmlspecialchars($agent['pinterest']) ?>"
                                                                target="_blank"><i class="fa fa-pinterest"></i></a>
                                                        </li>
                                                    <?php endif; ?>
                                                    <?php if (!empty($agent['google_plus'])): ?>
                                                        <li class="list-inline-item">
                                                            <a href="<?php echo htmlspecialchars($agent['google_plus']) ?>"
                                                                target="_blank"><i class="fa fa-google"></i></a>
                                                        </li>
                                                    <?php endif; ?>
                                                </ul>
                                                <div class="fp_pdate float-right text-thm">
                                                    <a
                                                        href="agent-detail.php?id=<?php echo htmlspecialchars($agent['id']) ?>">
                                                        View My Listings <i class="fa fa-angle-right"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                            <div class="col-lg-12 mt20">
                                <div class="mbp_pagination">
                                    <ul class="page_navigation">
                                        <?php if ($page > 1): ?>
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>"><span
                                                        class="flaticon-left-arrow"></span> Prev</a>
                                            </li>
                                        <?php endif; ?>

                                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                            <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                                <a class="page-link"
                                                    href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
                                            </li>
                                        <?php endfor; ?>

                                        <?php if ($page < $totalPages): ?>
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>"><span
                                                        class="flaticon-right-arrow"></span></a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </section>

        <!-- Footer start  -->
        <?php include "../include/footer.php"; ?>
        <!--	Footer end  -->

        <a class="scrollToHome" href="#"><i class="flaticon-arrows"></i></a>
    </div>

    <script src="https://code.jquery.com/jquery-migrate-3.0.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../Js/jquery.mmenu.all.js"></script>
    <script type="text/javascript" src="../js/bootstrap-select.min.js"></script>

    <script>
        $(document).ready(function () {
            $(".sidebar_feature_property_slider").owlCarousel({
                items: 1,
                dots: true,
                nav: false,
                autoplay: false,
                smartSpeed: 1200,
                loop: true
            });
        });
    </script>

</body>

</html>