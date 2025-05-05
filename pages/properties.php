<<<<<<< HEAD
<?php
include "../include/db_connect.php";

$limit = 6;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$start = ($page - 1) * $limit;

$search_sql = "";
$params = [];

// Keyword search
$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
if (!empty($keyword)) {
    $search_sql .= " AND (p.title LIKE ? OR p.description LIKE ?)";
    $params[] = "%$keyword%";
    $params[] = "%$keyword%";
}

// Other search filters
if (!empty($_GET['location'])) {
    $search_sql .= " AND p.address LIKE :location";
    $params[':location'] = '%' . $_GET['location'] . '%';
}
if (!empty($_GET['city'])) {
    $search_sql .= " AND p.city = :city";
    $params[':city'] = $_GET['city'];
}
if (!empty($_GET['type'])) {
    $search_sql .= " AND p.type = :type";
    $params[':type'] = $_GET['type'];
}
if (!empty($_GET['min_price'])) {
    $search_sql .= " AND p.price >= :min_price";
    $params[':min_price'] = $_GET['min_price'];
}
if (!empty($_GET['max_price'])) {
    $search_sql .= " AND p.price <= :max_price";
    $params[':max_price'] = $_GET['max_price'];
}
if (!empty($_GET['bedrooms'])) {
    $search_sql .= " AND p.bedrooms = :bedrooms";
    $params[':bedrooms'] = $_GET['bedrooms'];
}
if (!empty($_GET['bathrooms'])) {
    $search_sql .= " AND p.bathrooms = :bathrooms";
    $params[':bathrooms'] = $_GET['bathrooms'];
}
if (!empty($_GET['year_built'])) {
    $search_sql .= " AND p.year_built = :year_built";
    $params[':year_built'] = $_GET['year_built'];
}
if (!empty($_GET['min_area'])) {
    $search_sql .= " AND p.area >= :min_area";
    $params[':min_area'] = $_GET['min_area'];
}
if (!empty($_GET['max_area'])) {
    $search_sql .= " AND p.area <= :max_area";
    $params[':max_area'] = $_GET['max_area'];
}

// Only approved properties
$search_sql = " AND p.approval_status = 'approved' $search_sql";

// Total count for pagination
$count_sql = "SELECT COUNT(*) FROM properties p WHERE 1 $search_sql";
$stmt = $conn->prepare($count_sql);
$stmt->execute($params);
$total = $stmt->fetchColumn();
$totalPages = ceil($total / $limit);

// Fetch properties (no duplicates, always approved)
$data_sql = "SELECT DISTINCT p.*, u.username, u.photo
             FROM properties p
             JOIN users u ON p.user_id = u.id
             WHERE p.approval_status = 'approved' $search_sql
             ORDER BY p.id DESC
             LIMIT $start, $limit";
$stmt = $conn->prepare($data_sql);
$stmt->execute($params);
$properties = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get image for each property
foreach ($properties as &$prop) {
    $img_stmt = $conn->prepare("SELECT image_path FROM property_images WHERE property_id = ? LIMIT 5");
    $img_stmt->execute([$prop['id']]);
    $prop['images'] = $img_stmt->fetchAll(PDO::FETCH_COLUMN);
}
?>



=======
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
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
<<<<<<< HEAD
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">

=======
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
    <title>Property List Page</title>
</head>

<body>
    <div class="wrapper">
        <!-- <div class="preloader"></div> -->

        <!--	Header start  -->
        <?php include "../include/header.php"; ?>
        <!--	Header end  -->

        <!-- Listing Grid View -->
        <section class="our-listing bgc-f7 pb30-991">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="breadcrumb_content style2 mt30-767 mb30-767">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active text-thm" aria-current="page">Simple Listing – Grid
                                    View</li>
                            </ol>
                            <h2 class="breadcrumb_title">Simple Listing – Grid View </h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 col-xl-4">
                        <div class="sidebar_listing_list dn-991">
                            <div class="sidebar_advanced_search_widget">
<<<<<<< HEAD
                                <form method="GET">
                                    <ul class="sasw_list mb0">
                                        <li class="search_area">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="exampleInputName1"
                                                    name="keyword" placeholder="keyword"
                                                    value="<?php echo htmlspecialchars($_GET['keyword'] ?? '') ?>">
                                                <label for="exampleInputEmail"><span
                                                        class="flaticon-magnifying-glass"></span></label>
                                            </div>
                                        </li>
                                        <li class="search_area">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="exampleInputEmail"
                                                    placeholder="Location" name="location"
                                                    value="<?php echo htmlspecialchars($_GET['location'] ?? '') ?>">
                                                <label for="exampleInputEmail"><span
                                                        class="flaticon-maps-and-flags"></span></label>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="search_option_two">
                                                <div class="candidate_revew_select">
                                                    <select class="selectpicker w100 show-tick form-select"
                                                        tabindex="-98">
                                                        <option value="">Status</option>
                                                        <option>Apartment</option>
                                                        <option>Bungalow</option>
                                                        <option>Condo</option>
                                                        <option>House</option>
                                                        <option>Land</option>
                                                        <option>Single Family</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="search_option_two">
                                                <div class="candidate_revew_select">
                                                    <select class="selectpicker w100 show-tick" tabindex="-98">
                                                        <option>Property Type</option>
                                                        <option>Apartment</option>
                                                        <option>Bungalow</option>
                                                        <option>Condo</option>
                                                        <option>House</option>
                                                        <option>Land</option>
                                                        <option>Single Family</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="small_dropdown2">
                                                <div id="prncgs2" class="btn dd_btn" data-bs-toggle="dropdown"
                                                    data-bs-auto-close="outside" aria-expanded="false">
                                                    <span>Price Range</span>
                                                    <label for="prncgs2"><span class="fa fa-angle-down"></span></label>
                                                </div>
                                                <div class="dd_content2 style2 dropdown-menu">
                                                    <div class="pricing_acontent">
                                                        <input type="text" id="min_price" class="amount"
                                                            placeholder="$50,000">
                                                        <input type="text" id="max_price" class="amount2"
                                                            placeholder="$1,000,000">
                                                        <div id="price_range_slider" class="slider-range"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="search_option_two">
                                                <div class="candidate_revew_select">
                                                    <select class="selectpicker w100 show-tick" tabindex="-98">
                                                        <option>Bathrooms</option>
                                                        <option>1</option>
                                                        <option>2</option>
                                                        <option>3</option>
                                                        <option>4</option>
                                                        <option>5</option>
                                                        <option>6</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="search_option_two">
                                                <div class="candidate_revew_select">
                                                    <select class="selectpicker w100 show-tick" tabindex="-98">
                                                        <option>Bedrooms</option>
                                                        <option>1</option>
                                                        <option>2</option>
                                                        <option>3</option>
                                                        <option>4</option>
                                                        <option>5</option>
                                                        <option>6</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="search_option_two">
                                                <div class="candidate_revew_select">
                                                    <select class="selectpicker w100 show-tick" tabindex="-98">
                                                        <option>Garages</option>
                                                        <option>Yes</option>
                                                        <option>No</option>
                                                        <option>Others</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="search_option_two">
                                                <div class="candidate_revew_select">
                                                    <select class="selectpicker w100 show-tick" tabindex="-98">
                                                        <option>Year built</option>
                                                        <option>2013</option>
                                                        <option>2014</option>
                                                        <option>2015</option>
                                                        <option>2016</option>
                                                        <option>2017</option>
                                                        <option>2018</option>
                                                        <option>2019</option>
                                                        <option>2020</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="min_area list-inline-item">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="exampleInputName2"
                                                    placeholder="Min Area">
                                            </div>
                                        </li>
                                        <li class="max_area list-inline-item">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="exampleInputName3"
                                                    placeholder="Max Area">
                                            </div>
                                        </li>
                                        <li>
                                            <div id="accordion" class="panel-group">
                                                <div class="panel">
                                                    <div class="panel-heading">
                                                        <h4 class="panel-title">
                                                            <a href="#panelBodyRating" class="accordion-toggle link"
                                                                data-toggle="collapse" data-parent="#accordion"><i
                                                                    class="flaticon-more"></i> Advanced features</a>
                                                        </h4>
                                                    </div>
                                                    <div id="panelBodyRating" class="panel-collapse collapse">
                                                        <div class="panel-body row">
                                                            <div class="col-lg-12">
                                                                <ul
                                                                    class="ui_kit_checkbox selectable-list float-left fn-400">
                                                                    <li>
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox"
                                                                                class="custom-control-input"
                                                                                id="customCheck16">
                                                                            <label class="custom-control-label"
                                                                                for="customCheck16">Air
                                                                                Conditioning</label>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox"
                                                                                class="custom-control-input"
                                                                                id="customCheck17">
                                                                            <label class="custom-control-label"
                                                                                for="customCheck17">Barbeque</label>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox"
                                                                                class="custom-control-input"
                                                                                id="customCheck18">
                                                                            <label class="custom-control-label"
                                                                                for="customCheck18">Gym</label>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox"
                                                                                class="custom-control-input"
                                                                                id="customCheck19">
                                                                            <label class="custom-control-label"
                                                                                for="customCheck19">Microwave</label>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox"
                                                                                class="custom-control-input"
                                                                                id="customCheck20">
                                                                            <label class="custom-control-label"
                                                                                for="customCheck20">TV
                                                                                Cable</label>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox"
                                                                                class="custom-control-input"
                                                                                id="customCheck21">
                                                                            <label class="custom-control-label"
                                                                                for="customCheck21">Lawn</label>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox"
                                                                                class="custom-control-input"
                                                                                id="customCheck22">
                                                                            <label class="custom-control-label"
                                                                                for="customCheck22">Refrigerator</label>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox"
                                                                                class="custom-control-input"
                                                                                id="customCheck23">
                                                                            <label class="custom-control-label"
                                                                                for="customCheck23">Swimming
                                                                                Pool</label>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                                <ul
                                                                    class="ui_kit_checkbox selectable-list float-right fn-400">
                                                                    <li>
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox"
                                                                                class="custom-control-input"
                                                                                id="customCheck24">
                                                                            <label class="custom-control-label"
                                                                                for="customCheck24">WiFi</label>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox"
                                                                                class="custom-control-input"
                                                                                id="customCheck25">
                                                                            <label class="custom-control-label"
                                                                                for="customCheck25">Sauna</label>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox"
                                                                                class="custom-control-input"
                                                                                id="customCheck26">
                                                                            <label class="custom-control-label"
                                                                                for="customCheck26">Dryer</label>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox"
                                                                                class="custom-control-input"
                                                                                id="customCheck27">
                                                                            <label class="custom-control-label"
                                                                                for="customCheck27">Washer</label>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox"
                                                                                class="custom-control-input"
                                                                                id="customCheck28">
                                                                            <label class="custom-control-label"
                                                                                for="customCheck28">Laundry</label>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox"
                                                                                class="custom-control-input"
                                                                                id="customCheck29">
                                                                            <label class="custom-control-label"
                                                                                for="customCheck29">Outdoor
                                                                                Shower</label>
                                                                        </div>
                                                                    </li>
                                                                    <li>
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input type="checkbox"
                                                                                class="custom-control-input"
                                                                                id="customCheck30">
                                                                            <label class="custom-control-label"
                                                                                for="customCheck30">Window
                                                                                Coverings</label>
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div>
=======
                                <ul class="sasw_list mb0">
                                    <li class="search_area">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="exampleInputName1"
                                                placeholder="keyword">
                                            <label for="exampleInputEmail"><span
                                                    class="flaticon-magnifying-glass"></span></label>
                                        </div>
                                    </li>
                                    <li class="search_area">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="exampleInputEmail"
                                                placeholder="Location">
                                            <label for="exampleInputEmail"><span
                                                    class="flaticon-maps-and-flags"></span></label>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="search_option_two">
                                            <div class="candidate_revew_select">
                                                <select class="selectpicker w100 show-tick form-select" tabindex="-98">
                                                    <option value="">Status</option>
                                                    <option>Apartment</option>
                                                    <option>Bungalow</option>
                                                    <option>Condo</option>
                                                    <option>House</option>
                                                    <option>Land</option>
                                                    <option>Single Family</option>
                                                </select>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="search_option_two">
                                            <div class="candidate_revew_select">
                                                <select class="selectpicker w100 show-tick" tabindex="-98">
                                                    <option>Property Type</option>
                                                    <option>Apartment</option>
                                                    <option>Bungalow</option>
                                                    <option>Condo</option>
                                                    <option>House</option>
                                                    <option>Land</option>
                                                    <option>Single Family</option>
                                                </select>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="small_dropdown2">
                                            <div id="prncgs2" class="btn dd_btn">
                                                <span>Price</span>
                                                <label for="exampleInputEmail2"><span
                                                        class="fa fa-angle-down"></span></label>
                                            </div>
                                            <div class="dd_content2 style2">
                                                <div class="pricing_acontent">
                                                    <input type="text" class="amount" placeholder="$52,239">
                                                    <input type="text" class="amount2" placeholder="$985,14">
                                                    <div
                                                        class="slider-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content">
                                                        <div class="ui-slider-range ui-corner-all ui-widget-header"
                                                            style="left: 2.79875%; width: 57.8438%;"></div><span
                                                            tabindex="0"
                                                            class="ui-slider-handle ui-corner-all ui-state-default"
                                                            style="left: 2.79875%;"></span><span tabindex="0"
                                                            class="ui-slider-handle ui-corner-all ui-state-default"
                                                            style="left: 60.6425%;"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="search_option_two">
                                            <div class="candidate_revew_select">
                                                <select class="selectpicker w100 show-tick" tabindex="-98">
                                                    <option>Bathrooms</option>
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                    <option>5</option>
                                                    <option>6</option>
                                                </select>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="search_option_two">
                                            <div class="candidate_revew_select">
                                                <select class="selectpicker w100 show-tick" tabindex="-98">
                                                    <option>Bedrooms</option>
                                                    <option>1</option>
                                                    <option>2</option>
                                                    <option>3</option>
                                                    <option>4</option>
                                                    <option>5</option>
                                                    <option>6</option>
                                                </select>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="search_option_two">
                                            <div class="candidate_revew_select">
                                                <select class="selectpicker w100 show-tick" tabindex="-98">
                                                    <option>Garages</option>
                                                    <option>Yes</option>
                                                    <option>No</option>
                                                    <option>Others</option>
                                                </select>
                                            </div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="search_option_two">
                                            <div class="candidate_revew_select">
                                                <select class="selectpicker w100 show-tick" tabindex="-98">
                                                    <option>Year built</option>
                                                    <option>2013</option>
                                                    <option>2014</option>
                                                    <option>2015</option>
                                                    <option>2016</option>
                                                    <option>2017</option>
                                                    <option>2018</option>
                                                    <option>2019</option>
                                                    <option>2020</option>
                                                </select>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="min_area list-inline-item">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="exampleInputName2"
                                                placeholder="Min Area">
                                        </div>
                                    </li>
                                    <li class="max_area list-inline-item">
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="exampleInputName3"
                                                placeholder="Max Area">
                                        </div>
                                    </li>
                                    <li>
                                        <div id="accordion" class="panel-group">
                                            <div class="panel">
                                                <div class="panel-heading">
                                                    <h4 class="panel-title">
                                                        <a href="#panelBodyRating" class="accordion-toggle link"
                                                            data-toggle="collapse" data-parent="#accordion"><i
                                                                class="flaticon-more"></i> Advanced features</a>
                                                    </h4>
                                                </div>
                                                <div id="panelBodyRating" class="panel-collapse collapse">
                                                    <div class="panel-body row">
                                                        <div class="col-lg-12">
                                                            <ul
                                                                class="ui_kit_checkbox selectable-list float-left fn-400">
                                                                <li>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox"
                                                                            class="custom-control-input"
                                                                            id="customCheck16">
                                                                        <label class="custom-control-label"
                                                                            for="customCheck16">Air
                                                                            Conditioning</label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox"
                                                                            class="custom-control-input"
                                                                            id="customCheck17">
                                                                        <label class="custom-control-label"
                                                                            for="customCheck17">Barbeque</label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox"
                                                                            class="custom-control-input"
                                                                            id="customCheck18">
                                                                        <label class="custom-control-label"
                                                                            for="customCheck18">Gym</label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox"
                                                                            class="custom-control-input"
                                                                            id="customCheck19">
                                                                        <label class="custom-control-label"
                                                                            for="customCheck19">Microwave</label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox"
                                                                            class="custom-control-input"
                                                                            id="customCheck20">
                                                                        <label class="custom-control-label"
                                                                            for="customCheck20">TV
                                                                            Cable</label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox"
                                                                            class="custom-control-input"
                                                                            id="customCheck21">
                                                                        <label class="custom-control-label"
                                                                            for="customCheck21">Lawn</label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox"
                                                                            class="custom-control-input"
                                                                            id="customCheck22">
                                                                        <label class="custom-control-label"
                                                                            for="customCheck22">Refrigerator</label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox"
                                                                            class="custom-control-input"
                                                                            id="customCheck23">
                                                                        <label class="custom-control-label"
                                                                            for="customCheck23">Swimming
                                                                            Pool</label>
                                                                    </div>
                                                                </li>
                                                            </ul>
                                                            <ul
                                                                class="ui_kit_checkbox selectable-list float-right fn-400">
                                                                <li>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox"
                                                                            class="custom-control-input"
                                                                            id="customCheck24">
                                                                        <label class="custom-control-label"
                                                                            for="customCheck24">WiFi</label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox"
                                                                            class="custom-control-input"
                                                                            id="customCheck25">
                                                                        <label class="custom-control-label"
                                                                            for="customCheck25">Sauna</label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox"
                                                                            class="custom-control-input"
                                                                            id="customCheck26">
                                                                        <label class="custom-control-label"
                                                                            for="customCheck26">Dryer</label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox"
                                                                            class="custom-control-input"
                                                                            id="customCheck27">
                                                                        <label class="custom-control-label"
                                                                            for="customCheck27">Washer</label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox"
                                                                            class="custom-control-input"
                                                                            id="customCheck28">
                                                                        <label class="custom-control-label"
                                                                            for="customCheck28">Laundry</label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox"
                                                                            class="custom-control-input"
                                                                            id="customCheck29">
                                                                        <label class="custom-control-label"
                                                                            for="customCheck29">Outdoor
                                                                            Shower</label>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="custom-control custom-checkbox">
                                                                        <input type="checkbox"
                                                                            class="custom-control-input"
                                                                            id="customCheck30">
                                                                        <label class="custom-control-label"
                                                                            for="customCheck30">Window
                                                                            Coverings</label>
                                                                    </div>
                                                                </li>
                                                            </ul>
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
<<<<<<< HEAD
                                        </li>
                                        <li>
                                            <div class="search_option_button">
                                                <button type="submit" class="btn btn-block btn-thm">Search</button>
                                            </div>
                                        </li>
                                    </ul>
                                </form>
=======
                                        </div>
                                    </li>
                                    <li>
                                        <div class="search_option_button">
                                            <button type="submit" class="btn btn-block btn-thm">Search</button>
                                        </div>
                                    </li>
                                </ul>
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-8">
                        <div class="row">
<<<<<<< HEAD
                            <?php foreach ($properties as $prop): ?>
                                <div class="col-md-6 col-lg-6">
                                    <div class="feat_property home7 style4">
                                        <div class="thumb">
                                            <div class="fp_single_item_slider owl-carousel owl-theme">
                                                <?php if (!empty($prop['images'])): ?>
                                                    <?php foreach ($prop['images'] as $img): ?>
                                                        <div class="item">
                                                            <img class="img-whp" src="../<?= htmlspecialchars($img) ?>"
                                                                alt="property image">
                                                        </div>
                                                    <?php endforeach; ?>
                                                <?php else: ?>
                                                    <div class="item">
                                                        <img class="img-whp" src="images/default-list.jpg" alt="default image">
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="thmb_cntnt style2">
                                                <ul class="tag mb0">
                                                    <li class="list-inline-item"><a href="#"><?= $prop['status'] ?></a></li>
                                                    <?php if ($prop['is_featured']): ?>
                                                        <li class="list-inline-item"><a href="#">Featured</a></li>
                                                    <?php endif; ?>
                                                </ul>
                                            </div>
                                            <div class="thmb_cntnt style3">
                                                <ul class="icon mb0">
                                                    <li class="list-inline-item"><a href="#"><span
                                                                class="flaticon-transfer-1"></span></a></li>
                                                    <li class="list-inline-item"><a href="#"><span
                                                                class="flaticon-heart"></span></a></li>
                                                </ul>
                                                <a class="fp_price"
                                                    href="#">$<?= number_format($prop['price']) ?><small>/mo</small></a>
                                            </div>
                                        </div>
                                        <div class="details">
                                            <div class="tc_content">
                                                <p class="text-thm"><?= $prop['type'] ?></p>
                                                <h4><?= $prop['title'] ?></h4>
                                                <p><span class="flaticon-placeholder"></span><?= $prop['address'] ?></p>
                                                <ul class="prop_details mb0">
                                                    <li class="list-inline-item"><a href="#">Beds:
                                                            <?= $prop['bedrooms'] ?></a></li>
                                                    <li class="list-inline-item"><a href="#">Baths:
                                                            <?= $prop['bathrooms'] ?></a></li>
                                                    <li class="list-inline-item"><a href="#">Sq Ft: <?= $prop['area'] ?></a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="fp_footer">
                                                <ul class="fp_meta float-left mb0">
                                                    <li class="list-inline-item"><a
                                                            href="agent-detail.php?id=<?php echo htmlspecialchars($prop['id']) ?>">
                                                            <img src="<?php echo !empty($prop['photo']) ? '../' . $prop['photo'] : '../images/profile.png'; ?>"
                                                                alt="<?php echo htmlspecialchars($prop['username']) ?>"
                                                                width="45" height="45" class="rounded-pill">
                                                        </a>
                                                    </li>
                                                    <li class="list-inline-item"><a
                                                            href="agent-detail.php?id=<?php echo htmlspecialchars($prop['id']) ?>"><?= ucfirst(htmlspecialchars($prop['username'])) ?></a>
                                                    </li>
                                                </ul>
                                                <div class="fp_pdate float-right text-thm">
                                                    <a href="property-detail.php?id=<?= $prop['id'] ?>">
                                                        View Details <i class="fa fa-angle-right"></i>
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
=======
                            <div class="grid_list_search_result">
                                <div class="col-sm-12 col-md-4 col-lg-4 col-xl-5">
                                    <div class="left_area tac-xsd">
                                        <p>9 Search results</p>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-md-8 col-lg-8 col-xl-7">
                                    <div class="right_area text-right tac-xsd">
                                        <ul>
                                            <li class="list-inline-item"><span class="stts">Status:</span>
                                                <select class="selectpicker show-tick">
                                                    <option>All Status</option>
                                                    <option>Recent</option>
                                                    <option>Old Review</option>
                                                </select>
                                            </li>
                                            <li class="list-inline-item"><span class="shrtby">Sort by:</span>
                                                <select class="selectpicker show-tick">
                                                    <option>Featured First</option>
                                                    <option>Featured 2nd</option>
                                                    <option>Featured 3rd</option>
                                                    <option>Featured 4th</option>
                                                    <option>Featured 5th</option>
                                                </select>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-lg-6">
                                <div class="feat_property home7">
                                    <div class="thumb">
                                        <img class="img-whp" src="https://creativelayers.net/themes/findhouse-html/images/property/fp1.jpg" alt="fp1.jpg">
                                        <div class="thmb_cntnt">
                                            <ul class="tag mb0">
                                                <li class="list-inline-item"><a href="#">For Rent</a></li>
                                                <li class="list-inline-item"><a href="#">Featured</a></li>
                                            </ul>
                                            <ul class="icon mb0">
                                                <li class="list-inline-item"><a href="#"><span
                                                            class="flaticon-transfer-1"></span></a></li>
                                                <li class="list-inline-item"><a href="#"><span
                                                            class="flaticon-heart"></span></a></li>
                                            </ul>
                                            <a class="fp_price" href="#">$13,000<small>/mo</small></a>
                                        </div>
                                    </div>
                                    <div class="details">
                                        <div class="tc_content">
                                            <p class="text-thm">Apartment</p>
                                            <h4>Renovated Apartment</h4>
                                            <p><span class="flaticon-placeholder"></span> 1421 San Pedro St, Los
                                                Angeles, CA 90015</p>
                                            <ul class="prop_details mb0">
                                                <li class="list-inline-item"><a class="text-thm3" href="#">Beds: 4</a>
                                                </li>
                                                <li class="list-inline-item"><a class="text-thm3" href="#">Baths: 2</a>
                                                </li>
                                                <li class="list-inline-item"><a class="text-thm3" href="#">Sq Ft:
                                                        5280</a></li>
                                            </ul>
                                        </div>
                                        <div class="fp_footer">
                                            <ul class="fp_meta float-left mb0">
                                                <li class="list-inline-item"><a href="#"><img
                                                            src="https://creativelayers.net/themes/findhouse-html/images/property/pposter1.png" alt="pposter1.png"></a>
                                                </li>
                                                <li class="list-inline-item"><a href="#">Ali Tufan</a></li>
                                            </ul>
                                            <div class="fp_pdate float-right">4 years ago</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="feat_property home7">
                                    <div class="thumb">
                                        <img class="img-whp" src="https://creativelayers.net/themes/findhouse-html/images/property/fp2.jpg" alt="fp2.jpg">
                                        <div class="thmb_cntnt">
                                            <ul class="tag mb0">
                                                <li class="list-inline-item"><a href="#">For Rent</a></li>
                                                <li class="list-inline-item dn"></li>
                                            </ul>
                                            <ul class="icon mb0">
                                                <li class="list-inline-item"><a href="#"><span
                                                            class="flaticon-transfer-1"></span></a></li>
                                                <li class="list-inline-item"><a href="#"><span
                                                            class="flaticon-heart"></span></a></li>
                                            </ul>
                                            <a class="fp_price" href="#">$13,000<small>/mo</small></a>
                                        </div>
                                    </div>
                                    <div class="details">
                                        <div class="tc_content">
                                            <p class="text-thm">Villa</p>
                                            <h4>Gorgeous Villa Bay View</h4>
                                            <p><span class="flaticon-placeholder"></span> 1421 San Pedro St, Los
                                                Angeles, CA 90015</p>
                                            <ul class="prop_details mb0">
                                                <li class="list-inline-item"><a class="text-thm3" href="#">Beds: 4</a>
                                                </li>
                                                <li class="list-inline-item"><a class="text-thm3" href="#">Baths: 2</a>
                                                </li>
                                                <li class="list-inline-item"><a class="text-thm3" href="#">Sq Ft:
                                                        5280</a></li>
                                            </ul>
                                        </div>
                                        <div class="fp_footer">
                                            <ul class="fp_meta float-left mb0">
                                                <li class="list-inline-item"><a href="#"><img
                                                            src="https://creativelayers.net/themes/findhouse-html/images/property/pposter1.png" alt="pposter1.png"></a>
                                                </li>
                                                <li class="list-inline-item"><a href="#">Ali Tufan</a></li>
                                            </ul>
                                            <div class="fp_pdate float-right">4 years ago</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="feat_property home7">
                                    <div class="thumb">
                                        <img class="img-whp" src="https://creativelayers.net/themes/findhouse-html/images/property/fp3.jpg" alt="fp3.jpg">
                                        <div class="thmb_cntnt">
                                            <ul class="tag mb0">
                                                <li class="list-inline-item"><a href="#">For Sale</a></li>
                                                <li class="list-inline-item dn"></li>
                                            </ul>
                                            <ul class="icon mb0">
                                                <li class="list-inline-item"><a href="#"><span
                                                            class="flaticon-transfer-1"></span></a></li>
                                                <li class="list-inline-item"><a href="#"><span
                                                            class="flaticon-heart"></span></a></li>
                                            </ul>
                                            <a class="fp_price" href="#">$13,000<small>/mo</small></a>
                                        </div>
                                    </div>
                                    <div class="details">
                                        <div class="tc_content">
                                            <p class="text-thm">Single Family Home</p>
                                            <h4>Luxury Family Home</h4>
                                            <p><span class="flaticon-placeholder"></span> 1421 San Pedro St, Los
                                                Angeles, CA 90015</p>
                                            <ul class="prop_details mb0">
                                                <li class="list-inline-item"><a class="text-thm3" href="#">Beds: 4</a>
                                                </li>
                                                <li class="list-inline-item"><a class="text-thm3" href="#">Baths: 2</a>
                                                </li>
                                                <li class="list-inline-item"><a class="text-thm3" href="#">Sq Ft:
                                                        5280</a></li>
                                            </ul>
                                        </div>
                                        <div class="fp_footer">
                                            <ul class="fp_meta float-left mb0">
                                                <li class="list-inline-item"><a href="#"><img
                                                            src="https://creativelayers.net/themes/findhouse-html/images/property/pposter1.png" alt="pposter1.png"></a>
                                                </li>
                                                <li class="list-inline-item"><a href="#">Ali Tufan</a></li>
                                            </ul>
                                            <div class="fp_pdate float-right">4 years ago</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="feat_property home7">
                                    <div class="thumb">
                                        <img class="img-whp" src="https://creativelayers.net/themes/findhouse-html/images/property/fp4.jpg" alt="fp4.jpg">
                                        <div class="thmb_cntnt">
                                            <ul class="tag mb0">
                                                <li class="list-inline-item"><a href="#">For Rent</a></li>
                                                <li class="list-inline-item"><a href="#">Featured</a></li>
                                            </ul>
                                            <ul class="icon mb0">
                                                <li class="list-inline-item"><a href="#"><span
                                                            class="flaticon-transfer-1"></span></a></li>
                                                <li class="list-inline-item"><a href="#"><span
                                                            class="flaticon-heart"></span></a></li>
                                            </ul>
                                            <a class="fp_price" href="#">$13,000<small>/mo</small></a>
                                        </div>
                                    </div>
                                    <div class="details">
                                        <div class="tc_content">
                                            <p class="text-thm">Apartment</p>
                                            <h4>Luxury Family Home</h4>
                                            <p><span class="flaticon-placeholder"></span> 1421 San Pedro St, Los
                                                Angeles, CA 90015</p>
                                            <ul class="prop_details mb0">
                                                <li class="list-inline-item"><a class="text-thm3" href="#">Beds: 4</a>
                                                </li>
                                                <li class="list-inline-item"><a class="text-thm3" href="#">Baths: 2</a>
                                                </li>
                                                <li class="list-inline-item"><a class="text-thm3" href="#">Sq Ft:
                                                        5280</a></li>
                                            </ul>
                                        </div>
                                        <div class="fp_footer">
                                            <ul class="fp_meta float-left mb0">
                                                <li class="list-inline-item"><a href="#"><img
                                                            src="https://creativelayers.net/themes/findhouse-html/images/property/pposter1.png" alt="pposter1.png"></a>
                                                </li>
                                                <li class="list-inline-item"><a href="#">Ali Tufan</a></li>
                                            </ul>
                                            <div class="fp_pdate float-right">4 years ago</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="feat_property home7">
                                    <div class="thumb">
                                        <img class="img-whp" src="https://creativelayers.net/themes/findhouse-html/images/property/fp15.jpg" alt="fp15.jpg">
                                        <div class="thmb_cntnt">
                                            <ul class="tag mb0">
                                                <li class="list-inline-item"><a href="#">For Rent</a></li>
                                                <li class="list-inline-item"><a href="#">Featured</a></li>
                                            </ul>
                                            <ul class="icon mb0">
                                                <li class="list-inline-item"><a href="#"><span
                                                            class="flaticon-transfer-1"></span></a></li>
                                                <li class="list-inline-item"><a href="#"><span
                                                            class="flaticon-heart"></span></a></li>
                                            </ul>
                                            <a class="fp_price" href="#">$13,000<small>/mo</small></a>
                                        </div>
                                    </div>
                                    <div class="details">
                                        <div class="tc_content">
                                            <p class="text-thm">Apartment</p>
                                            <h4>Renovated Apartment</h4>
                                            <p><span class="flaticon-placeholder"></span> 1421 San Pedro St, Los
                                                Angeles, CA 90015</p>
                                            <ul class="prop_details mb0">
                                                <li class="list-inline-item"><a class="text-thm3" href="#">Beds: 4</a>
                                                </li>
                                                <li class="list-inline-item"><a class="text-thm3" href="#">Baths: 2</a>
                                                </li>
                                                <li class="list-inline-item"><a class="text-thm3" href="#">Sq Ft:
                                                        5280</a></li>
                                            </ul>
                                        </div>
                                        <div class="fp_footer">
                                            <ul class="fp_meta float-left mb0">
                                                <li class="list-inline-item"><a href="#"><img
                                                            src="https://creativelayers.net/themes/findhouse-html/images/property/pposter1.png" alt="pposter1.png"></a>
                                                </li>
                                                <li class="list-inline-item"><a href="#">Ali Tufan</a></li>
                                            </ul>
                                            <div class="fp_pdate float-right">4 years ago</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6">
                                <div class="feat_property home7">
                                    <div class="thumb">
                                        <img class="img-whp" src="https://creativelayers.net/themes/findhouse-html/images/property/fp16.jpg" alt="fp16.jpg">
                                        <div class="thmb_cntnt">
                                            <ul class="tag mb0">
                                                <li class="list-inline-item"><a href="#">For Rent</a></li>
                                                <li class="list-inline-item dn"></li>
                                            </ul>
                                            <ul class="icon mb0">
                                                <li class="list-inline-item"><a href="#"><span
                                                            class="flaticon-transfer-1"></span></a></li>
                                                <li class="list-inline-item"><a href="#"><span
                                                            class="flaticon-heart"></span></a></li>
                                            </ul>
                                            <a class="fp_price" href="#">$13,000<small>/mo</small></a>
                                        </div>
                                    </div>
                                    <div class="details">
                                        <div class="tc_content">
                                            <p class="text-thm">Villa</p>
                                            <h4>Gorgeous Villa Bay View</h4>
                                            <p><span class="flaticon-placeholder"></span> 1421 San Pedro St, Los
                                                Angeles, CA 90015</p>
                                            <ul class="prop_details mb0">
                                                <li class="list-inline-item"><a class="text-thm3" href="#">Beds: 4</a>
                                                </li>
                                                <li class="list-inline-item"><a class="text-thm3" href="#">Baths: 2</a>
                                                </li>
                                                <li class="list-inline-item"><a class="text-thm3" href="#">Sq Ft:
                                                        5280</a></li>
                                            </ul>
                                        </div>
                                        <div class="fp_footer">
                                            <ul class="fp_meta float-left mb0">
                                                <li class="list-inline-item"><a href="#"><img
                                                            src="https://creativelayers.net/themes/findhouse-html/images/property/pposter1.png" alt="pposter1.png"></a>
                                                </li>
                                                <li class="list-inline-item"><a href="#">Ali Tufan</a></li>
                                            </ul>
                                            <div class="fp_pdate float-right">4 years ago</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-12 mt20">
                                <div class="mbp_pagination">
                                    <ul class="page_navigation">
                                        <li class="page-item disabled">
                                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true"> <span
                                                    class="flaticon-left-arrow"></span> Prev</a>
                                        </li>
                                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item active" aria-current="page">
                                            <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                                        </li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item"><a class="page-link" href="#">...</a></li>
                                        <li class="page-item"><a class="page-link" href="#">29</a></li>
                                        <li class="page-item">
                                            <a class="page-link" href="#"><span class="flaticon-right-arrow"></span></a>
                                        </li>
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                    </ul>
                                </div>
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
<<<<<<< HEAD

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggles = document.querySelectorAll('.dd_btn');

            toggles.forEach(btn => {
                btn.addEventListener('click', function (e) {
                    e.stopPropagation(); // prevent event from bubbling up
                    // Hide all dropdowns first
                    document.querySelectorAll('.dd_content2.style2').forEach(dropdown => {
                        if (dropdown !== this.nextElementSibling) {
                            dropdown.style.display = 'none';
                        }
                    });
                    // Toggle this one
                    const dropdown = this.nextElementSibling;
                    if (dropdown && dropdown.classList.contains('dd_content2')) {
                        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
                    }
                });
            });
            // Optional: click outside to close any open dropdowns
            document.addEventListener('click', function () {
                document.querySelectorAll('.dd_content2.style2').forEach(dropdown => {
                    dropdown.style.display = 'none';
                });
            });
        });
    </script>
    <script>
        $(function () {
            $("#price_range_slider").slider({
                range: true,
                min: 50000,
                max: 1000000,
                values: [100000, 600000],
                slide: function (event, ui) {
                    $("#min_price").val("$" + ui.values[0].toLocaleString());
                    $("#max_price").val("$" + ui.values[1].toLocaleString());
                }
            });

            // Set initial values
            $("#min_price").val("$" + $("#price_range_slider").slider("values", 0).toLocaleString());
            $("#max_price").val("$" + $("#price_range_slider").slider("values", 1).toLocaleString());
        });
    </script>
    <script>
        $(document).ready(function () {
            $(".fp_single_item_slider").owlCarousel({
                items: 1,
                dots: true,
                nav: true,
                autoplay: false,
                smartSpeed: 1200,
                loop: true
            });
        });
    </script>


=======
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
</body>

</html>