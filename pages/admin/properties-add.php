<?php
include("../../include/db_connect.php");
<<<<<<< HEAD
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
=======
session_start();

>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header("Location: ../login.php");
    exit();
}

$types = $conn->query("SELECT name FROM property_type")->fetchAll(PDO::FETCH_ASSOC);
$cities = $conn->query("SELECT name FROM cities")->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $stmt = $conn->prepare("INSERT INTO properties (
            user_id, title, description, type, status, rooms, price, area,
            address, state, city, neighborhood, zip_code, latitude, longitude,
            area_size, size_prefix, land_area, land_area_postfix, bedrooms,
            bathrooms, garages, garage_size, year_built, video_url, virtual_tour_url,
<<<<<<< HEAD
            is_featured, attachment_url, approval_status, sale_status 
=======
            is_featured, attachment_url
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
        ) VALUES (
            :user_id, :title, :description, :type, :status, :rooms, :price, :area,
            :address, :state, :city, :neighborhood, :zip_code, :latitude, :longitude,
            :area_size, :size_prefix, :land_area, :land_area_postfix, :bedrooms,
            :bathrooms, :garages, :garage_size, :year_built, :video_url, :virtual_tour_url,
<<<<<<< HEAD
            :is_featured, :attachment_url, :approval_status, :sale_status 
=======
            :is_featured, :attachment_url
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
        )");

        $stmt->execute([
            ':user_id' => $_SESSION['user_id'],
            ':title' => $_POST['title'],
            ':description' => $_POST['description'],
            ':type' => $_POST['type'],
            ':status' => $_POST['status'],
            ':rooms' => $_POST['rooms'],
            ':price' => $_POST['price'],
            ':area' => $_POST['area'],
            ':address' => $_POST['address'],
            ':state' => $_POST['state'],
            ':city' => $_POST['city'],
            ':neighborhood' => $_POST['neighborhood'],
            ':zip_code' => $_POST['zip'],
            ':latitude' => $_POST['latitude'],
            ':longitude' => $_POST['longitude'],
            ':area_size' => $_POST['area_size'],
            ':size_prefix' => $_POST['size_prefix'],
            ':land_area' => $_POST['land_area'],
            ':land_area_postfix' => $_POST['land_area_postfix'],
            ':bedrooms' => $_POST['bedrooms'],
            ':bathrooms' => $_POST['bathrooms'],
            ':garages' => $_POST['garages'],
            ':garage_size' => $_POST['garage_size'],
            ':year_built' => $_POST['year_built'],
            ':video_url' => $_POST['video_url'],
            ':virtual_tour_url' => $_POST['virtual_tour'],
            ':is_featured' => isset($_POST['is_featured']) ? 1 : 0,
<<<<<<< HEAD
            ':attachment_url' => '',
            ':approval_status' => $_POST['approval_status'],
            ':sale_status' => $_POST['sale_status'],
=======
            ':attachment_url' => '' // placeholder
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
        ]);

        $property_id = $conn->lastInsertId();

        // 2. Insert amenities
        if (!empty($_POST['amenities'])) {
            $stmt = $conn->prepare("INSERT INTO property_amenities (property_id, amenity_name) VALUES (?, ?)");
            foreach ($_POST['amenities'] as $amenity) {
                $stmt->execute([$property_id, $amenity]);
            }
        }

        // 3. Handle property images
        if (!empty($_FILES['images']['name'][0])) {
            $uploadDir = '../../images/uploads/images/'; // server path
            $uploadUrl = 'images/uploads/images/'; // relative URL to save in DB
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true); // create directory if it doesn't exist
            }
            foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['images']['error'][$key] === 0) {
                    $imageName = time() . '_' . basename($_FILES['images']['name'][$key]);
                    $targetFile = $uploadDir . $imageName;

                    if (move_uploaded_file($tmp_name, $targetFile)) {
                        $imagePath = $uploadUrl . $imageName;

                        $stmt = $conn->prepare("INSERT INTO property_images (property_id, image_path) VALUES (?, ?)");
                        $stmt->execute([$property_id, $imagePath]);
                    }
                }
            }
        }

        // 4. Handle attachment
        if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === 0) {
            $attachDir = '../../images/uploads/attachments/'; // server path
            $attachUrl = 'images/uploads/attachments/'; // relative URL to save in DB
            if (!file_exists($attachDir)) {
                mkdir($attachDir, 0777, true); // create directory if it doesn't exist
            }
            $filename = time() . '_' . basename($_FILES['attachment']['name']);
            $targetFile = $attachDir . $filename;
            if (move_uploaded_file($_FILES['attachment']['tmp_name'], $targetFile)) {
                $attachmentPath = $attachUrl . $filename;

                $stmt = $conn->prepare("UPDATE properties SET attachment_url = ? WHERE id = ?");
                $stmt->execute([$attachmentPath, $property_id]);
            }
        }


        // 5. Handle floor plans
        if (!empty($_POST['plan_title'])) {
            $stmt = $conn->prepare("INSERT INTO property_floorplans (
                property_id, title, bedrooms, bathrooms, price,
                price_postfix, size, image_path, description
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $floorImageDir = '../../images/uploads/floorplans/'; // server path
            $floorImageUrl = 'images/uploads/floorplans/'; // relative path to store in DB

            if (!file_exists($floorImageDir)) {
                mkdir($floorImageDir, 0777, true); // create directory if it doesn't exist
            }

            foreach ($_POST['plan_title'] as $i => $title) {
                $imgPath = '';
                if (!empty($_FILES['plan_image_path']['name'][$i]) && $_FILES['plan_image_path']['error'][$i] === 0) {
                    $filename = time() . '_' . basename($_FILES['plan_image_path']['name'][$i]);
                    $targetFile = $floorImageDir . $filename;
                    if (move_uploaded_file($_FILES['plan_image_path']['tmp_name'][$i], $targetFile)) {
                        $imgPath = $floorImageUrl . $filename;
                    }
                }
                $stmt = $conn->prepare("INSERT INTO property_floorplans (property_id, title, bedrooms, bathrooms, price, price_postfix, size, image_path, description) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([
                    $property_id,
                    $title,
                    $_POST['plan_bedrooms'][$i],
                    $_POST['plan_bathrooms'][$i],
                    $_POST['plan_price'][$i],
                    $_POST['plan_price_postfix'][$i],
                    $_POST['plan_size'][$i],
                    $imgPath,
                    $_POST['plan_description'][$i]
                ]);
            }
        }

        header("Location: properties-list.php"); // redirect after success
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage(); // debugging only
    }
}
?>



<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="images/favicon.ico">
    <link rel="stylesheet" href="../../css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <title>Add property page</title>
</head>

<body>
    <div class="wrapper">

        <!--	Header start  -->
        <?php include "../../include/admin/header.php"; ?>
        <!--	Header end  -->

        <section class="our-dashbord dashbord bgc-f7 pb50">
            <div class="container-fluid ovh">
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
                                            <li><a href="page-dashboard.html"><span class="flaticon-layers"></span>
                                                    Dashboard</a></li>
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
                                            <li class="active"><a href="page-add-new-property.html"><span
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
                                    <h2 class="breadcrumb_title">Add New Property</h2>
                                    <p>We are glad to see you again!</p>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <form method="POST" enctype="multipart/form-data" action="">
                                    <div class="my_dashboard_review">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <h4 class="mb30">Create Listing</h4>
                                                <div class="my_profile_setting_input form-group">
                                                    <label for="propertyTitle">Property Title</label>
<<<<<<< HEAD
                                                    <input type="text" class="form-control" id="propertyTitle"
                                                        name="title">
=======
                                                    <input type="text" class="form-control" id="propertyTitle" name="title">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="my_profile_setting_textarea">
                                                    <label for="propertyDescription">Description</label>
<<<<<<< HEAD
                                                    <textarea class="form-control" id="propertyDescription" rows="7"
                                                        name="description"></textarea>
=======
                                                    <textarea class="form-control" id="propertyDescription" rows="7" name="description"></textarea>
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-xl-4">
                                                <div class="my_profile_setting_input ui_kit_select_search form-group">
                                                    <label>Type</label>
<<<<<<< HEAD
                                                    <select class="selectpicker" data-live-search="true"
                                                        data-width="100%" name="type">
                                                        <option value="">Select Type</option>
                                                        <?php foreach ($types as $type): ?>
                                                            <option value="<?= htmlspecialchars($type['name']) ?>">
                                                                <?= htmlspecialchars($type['name']) ?>
                                                            </option>
=======
                                                    <select class="selectpicker" data-live-search="true" data-width="100%" name="type">
                                                        <option value="">Select Type</option>
                                                        <?php foreach ($types as $type): ?>
                                                            <option value="<?= htmlspecialchars($type['name']) ?>"><?= htmlspecialchars($type['name']) ?></option>
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-xl-4">
                                                <div class="my_profile_setting_input ui_kit_select_search form-group">
                                                    <label>Status</label>
<<<<<<< HEAD
                                                    <select class="selectpicker" data-width="100%" name="status">
=======
                                                    <select class="selectpicker" data-live-search="true" data-width="100%" name="status">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        <option value="">Select Status</option>
                                                        <option value="Rent">Rent</option>
                                                        <option value="Sale">Sale</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-xl-4">
                                                <div class="my_profile_setting_input ui_kit_select_search form-group">
                                                    <label>Rooms</label>
<<<<<<< HEAD
                                                    <select class="selectpicker" data-live-search="true"
                                                        data-width="100%" name="rooms">
=======
                                                    <select class="selectpicker" data-live-search="true" data-width="100%" name="rooms">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        <option value="">Select Rooms</option>
                                                        <option value="1">1</option>
                                                        <option value="2">2</option>
                                                        <option value="3">3</option>
                                                        <option value="4">4</option>
                                                        <option value="5">5</option>
                                                        <option value="Other">Other</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-xl-6">
                                                <div class="my_profile_setting_input form-group">
                                                    <label for="formGroupExamplePrice">Price</label>
<<<<<<< HEAD
                                                    <input type="text" class="form-control" id="formGroupExamplePrice"
                                                        name="price">
=======
                                                    <input type="text" class="form-control" id="formGroupExamplePrice" name="price">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-xl-6">
                                                <div class="my_profile_setting_input form-group">
                                                    <label for="formGroupExampleArea">Area</label>
<<<<<<< HEAD
                                                    <input type="text" class="form-control" id="formGroupExampleArea"
                                                        name="area">
=======
                                                    <input type="text" class="form-control" id="formGroupExampleArea" name="area">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my_dashboard_review mt30">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <h4 class="mb30">Location</h4>
                                                <div class="my_profile_setting_input form-group">
                                                    <label for="propertyAddress">Address</label>
<<<<<<< HEAD
                                                    <input type="text" class="form-control" id="propertyAddress"
                                                        name="address">
=======
                                                    <input type="text" class="form-control" id="propertyAddress" name="address">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-xl-4">
                                                <div class="my_profile_setting_input form-group">
                                                    <label for="propertyState">County / State</label>
<<<<<<< HEAD
                                                    <input type="text" class="form-control" id="propertyState"
                                                        name="state">
=======
                                                    <input type="text" class="form-control" id="propertyState" name="state">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-xl-4">
                                                <div class="my_profile_setting_input ui_kit_select_search form-group">
                                                    <label>City</label>
<<<<<<< HEAD
                                                    <select class="selectpicker" data-live-search="true"
                                                        data-width="100%" name="city">
=======
                                                    <select class="selectpicker" data-live-search="true" data-width="100%" name="city">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        <option value="">Select City</option>
                                                        <?php foreach ($cities as $city): ?>
                                                            <option value="<?= htmlspecialchars($city['name']) ?>">
                                                                <?= htmlspecialchars($city['name']) ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-xl-4">
                                                <div class="my_profile_setting_input form-group">
                                                    <label for="neighborHood">Neighborhood</label>
<<<<<<< HEAD
                                                    <input type="text" class="form-control" id="neighborHood"
                                                        name="neighborhood">
=======
                                                    <input type="text" class="form-control" id="neighborHood" name="neighborhood">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-xl-4">
                                                <div class="my_profile_setting_input form-group">
                                                    <label for="zipCode">Zip</label>
                                                    <input type="text" class="form-control" id="zipCode" name="zip">
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-xl-4">
                                                <div class="my_profile_setting_input form-group">
                                                    <label for="googleMapLat">Latitude (for Google Maps)</label>
<<<<<<< HEAD
                                                    <input type="text" class="form-control" id="googleMapLat"
                                                        name="latitude">
=======
                                                    <input type="text" class="form-control" id="googleMapLat" name="latitude">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-xl-4">
                                                <div class="my_profile_setting_input form-group">
                                                    <label for="googleMapLong">Longitude (for Google Maps)</label>
<<<<<<< HEAD
                                                    <input type="text" class="form-control" id="googleMapLong"
                                                        name="longitude">
=======
                                                    <input type="text" class="form-control" id="googleMapLong" name="longitude">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my_dashboard_review mt30">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <h4 class="mb30">Detailed Information</h4>
                                            </div>
                                            <div class="col-lg-6 col-xl-4">
                                                <div class="my_profile_setting_input form-group">
                                                    <label for="propertyASize">Area Size</label>
<<<<<<< HEAD
                                                    <input type="text" class="form-control" id="propertyASize"
                                                        name="area_size">
=======
                                                    <input type="text" class="form-control" id="propertyASize" name="area_size">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-4">
                                                <div class="my_profile_setting_input form-group">
                                                    <label for="sizePrefix">Size Prefix</label>
<<<<<<< HEAD
                                                    <input type="text" class="form-control" id="sizePrefix"
                                                        name="size_prefix">
=======
                                                    <input type="text" class="form-control" id="sizePrefix" name="size_prefix">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-4">
                                                <div class="my_profile_setting_input form-group">
                                                    <label for="landArea">Land Area</label>
<<<<<<< HEAD
                                                    <input type="text" class="form-control" id="landArea"
                                                        name="land_area">
=======
                                                    <input type="text" class="form-control" id="landArea" name="land_area">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-4">
                                                <div class="my_profile_setting_input form-group">
                                                    <label for="LASPostfix">Land Area Size Postfix</label>
<<<<<<< HEAD
                                                    <input type="text" class="form-control" id="LASPostfix"
                                                        name="land_area_postfix">
=======
                                                    <input type="text" class="form-control" id="LASPostfix" name="land_area_postfix">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-4">
                                                <div class="my_profile_setting_input form-group">
                                                    <label for="bedRooms">Bedrooms</label>
<<<<<<< HEAD
                                                    <input type="text" class="form-control" id="bedRooms"
                                                        name="bedrooms">
=======
                                                    <input type="text" class="form-control" id="bedRooms" name="bedrooms">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-4">
                                                <div class="my_profile_setting_input form-group">
                                                    <label for="bathRooms">Bathrooms</label>
<<<<<<< HEAD
                                                    <input type="text" class="form-control" id="bathRooms"
                                                        name="bathrooms">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-4">
                                                <div class="my_profile_setting_input ui_kit_select_search form-group">
                                                    <label>Garages</label>
                                                    <select class="selectpicker" data-width="100%" id="garages"
                                                        name="garages">
                                                        <option value="">Select Garages</option>
                                                        <option value="Yes">Yes</option>
                                                        <option value="No">No</option>
                                                        <option value="Other">Other</option>
                                                    </select>
=======
                                                    <input type="text" class="form-control" id="bathRooms" name="bathrooms">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-4">
                                                <div class="my_profile_setting_input form-group">
                                                    <label for="garages">Garages</label>
                                                    <input type="text" class="form-control" id="garages" name="garages">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-4">
                                                <div class="my_profile_setting_input form-group">
                                                    <label for="garagesSize">Garages Size</label>
<<<<<<< HEAD
                                                    <input type="text" class="form-control" id="garagesSize"
                                                        name="garage_size">
=======
                                                    <input type="text" class="form-control" id="garagesSize" name="garage_size">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-4">
                                                <div class="my_profile_setting_input form-group">
                                                    <label for="yearBuild">Year Built</label>
<<<<<<< HEAD
                                                    <input type="text" class="form-control" id="yearBuild"
                                                        name="year_built">
=======
                                                    <input type="text" class="form-control" id="yearBuild" name="year_built">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-4">
                                                <div class="my_profile_setting_input form-group">
                                                    <label for="videoUrl">Video URL</label>
<<<<<<< HEAD
                                                    <input type="text" class="form-control" id="videoUrl"
                                                        name="video_url">
=======
                                                    <input type="text" class="form-control" id="videoUrl" name="video_url">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-4">
                                                <div class="my_profile_setting_input form-group">
                                                    <label for="virtualTour">360° Virtual Tour</label>
<<<<<<< HEAD
                                                    <input type="text" class="form-control" id="virtualTour"
                                                        name="virtual_tour">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-4">
                                                <div class="custom-control custom-checkbox ui_kit_checkbox selectable-list"
                                                    style="margin-top: 40px;">
                                                    <input type="checkbox" class="custom-control-input" id="isFeatured"
                                                        name="is_featured" value="1">
                                                    <label class="custom-control-label" for="isFeatured">Is
                                                        Featured?</label>
=======
                                                    <input type="text" class="form-control" id="virtualTour" name="virtual_tour">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-4">
                                                <div class="custom-control custom-checkbox ui_kit_checkbox selectable-list" style="margin-top: 40px;">
                                                    <input type="checkbox" class="custom-control-input" id="isFeatured" name="is_featured" value="1">
                                                    <label class="custom-control-label" for="isFeatured">Is Featured?</label>
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <h4>Amenities</h4>
                                            </div>
                                            <!-- Amenity Checkboxes -->
                                            <?php
                                            $amenities = [
                                                'Air Conditioning',
                                                'Lawn',
                                                'Swimming Pool',
                                                'Barbeque',
                                                'Microwave',
                                                'TV Cable',
                                                'Dryer',
                                                'Outdoor Shower',
                                                'Washer',
                                                'Gym',
                                                'Refrigerator',
                                                'WiFi',
                                                'Laundry',
                                                'Sauna',
                                                'Window Coverings'
                                            ];
                                            $i = 1;
                                            foreach (array_chunk($amenities, 5) as $chunk):
<<<<<<< HEAD
                                                ?>
=======
                                            ?>
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                <div class="col-sm-4 col-md-4 col-lg-4">
                                                    <ul class="ui_kit_checkbox selectable-list">
                                                        <?php foreach ($chunk as $label): ?>
                                                            <li>
                                                                <div class="custom-control custom-checkbox">
<<<<<<< HEAD
                                                                    <input type="checkbox" class="custom-control-input"
                                                                        id="customCheck<?= $i ?>" name="amenities[]"
                                                                        value="<?= htmlspecialchars($label) ?>">
                                                                    <label class="custom-control-label"
                                                                        for="customCheck<?= $i ?>"><?= $label ?></label>
                                                                </div>
                                                            </li>
                                                            <?php $i++;
=======
                                                                    <input type="checkbox" class="custom-control-input" id="customCheck<?= $i ?>" name="amenities[]" value="<?= htmlspecialchars($label) ?>">
                                                                    <label class="custom-control-label" for="customCheck<?= $i ?>"><?= $label ?></label>
                                                                </div>
                                                            </li>
                                                        <?php $i++;
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        endforeach; ?>
                                                    </ul>
                                                </div>
                                            <?php endforeach; ?>
<<<<<<< HEAD

                                            <div class="col-lg-6 col-xl-6">
                                                <div class="my_profile_setting_input ui_kit_select_search form-group">
                                                    <label>Approval Status</label>
                                                    <select class="selectpicker" data-width="100%"
                                                        name="approval_status">
                                                        <option value="">Select Approval Status</option>
                                                        <option value="pending">Pending</option>
                                                        <option value="approved">Approved</option>
                                                        <option value="rejected">Rejected</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-xl-6">
                                                <div class="my_profile_setting_input ui_kit_select_search form-group">
                                                    <label>Sale Status</label>
                                                    <select class="selectpicker" data-width="100%" name="sale_status">
                                                        <option value="">Select Sale Status</option>
                                                        <option value="available">Available</option>
                                                        <option value="sold_out">Sold Out</option>
                                                    </select>
                                                </div>
                                            </div>

=======
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                        </div>
                                    </div>
                                    <div class="my_dashboard_review mt30">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <h4 class="mb30">Property media</h4>
                                            </div>
                                            <div class="col-lg-12">
                                                <ul class="mb0 list-inline" id="imagePreviewList"></ul>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="portfolio_upload">
<<<<<<< HEAD
                                                    <input type="file" name="images[]" id="imageUploadInput" multiple
                                                        accept="image/*">
=======
                                                    <input type="file" name="images[]" id="imageUploadInput" multiple accept="image/*">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                    <div class="icon"><span class="flaticon-download"></span></div>
                                                    <p>Drag and drop images here</p>
                                                </div>
                                            </div>
                                            <div class="col-xl-8">
                                                <div class="resume_uploader mb30">
                                                    <h3>Attachments</h3>
                                                    <div class="form-inline d-flex flex-wrap wrap">
<<<<<<< HEAD
                                                        <input class="upload-path form-control w-75" readonly
                                                            id="attachmentName">
                                                        <label class="upload">
                                                            <input type="file" name="attachment" id="attachmentFile">
                                                            Select Attachment
=======
                                                        <input class="upload-path form-control w-75" readonly id="attachmentName">
                                                        <label class="upload">
                                                            <input type="file" name="attachment" id="attachmentFile"> Select Attachment
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my_dashboard_review mt30">
                                        <div class="floor-plan-block">
                                            <div class="row">
                                                <div class="col-lg-12 d-flex flex-wrap center justify-content-between">
                                                    <h4 class="mb30">Floor Plans</h4>
                                                    <div class="plan-header-actions">
<<<<<<< HEAD
                                                        <button type="button" class="btn admore_btn mb30"
                                                            id="addPlanBtn">Add More</button>
=======
                                                        <button type="button" class="btn admore_btn mb30" id="addPlanBtn">Add More</button>
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-xl-4">
                                                    <div class="my_profile_setting_input form-group">
                                                        <label for="planTitle">Plan Title</label>
<<<<<<< HEAD
                                                        <input type="text" class="form-control" id="planTitle"
                                                            name="plan_title[]">
=======
                                                        <input type="text" class="form-control" id="planTitle" name="plan_title[]">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-xl-4">
                                                    <div class="my_profile_setting_input form-group">
                                                        <label for="planBedrooms">Plan Bedrooms</label>
<<<<<<< HEAD
                                                        <input type="text" class="form-control" id="planBedrooms"
                                                            name="plan_bedrooms[]">
=======
                                                        <input type="text" class="form-control" id="planBedrooms" name="plan_bedrooms[]">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-xl-4">
                                                    <div class="my_profile_setting_input form-group">
                                                        <label for="planBathrooms">Plan Bathrooms</label>
<<<<<<< HEAD
                                                        <input type="text" class="form-control" id="planBathrooms"
                                                            name="plan_bathrooms[]">
=======
                                                        <input type="text" class="form-control" id="planBathrooms" name="plan_bathrooms[]">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-xl-4">
                                                    <div class="my_profile_setting_input form-group">
                                                        <label for="planPrice">Plan Price</label>
<<<<<<< HEAD
                                                        <input type="text" class="form-control" id="planPrice"
                                                            name="plan_price[]">
=======
                                                        <input type="text" class="form-control" id="planPrice" name="plan_price[]">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-xl-4">
                                                    <div class="my_profile_setting_input form-group">
                                                        <label for="planPostfix">Price Postfix</label>
<<<<<<< HEAD
                                                        <input type="text" class="form-control" id="planPostfix"
                                                            name="plan_price_postfix[]">
=======
                                                        <input type="text" class="form-control" id="planPostfix" name="plan_price_postfix[]">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-xl-4">
                                                    <div class="my_profile_setting_input form-group">
                                                        <label for="planSize">Plan Size</label>
<<<<<<< HEAD
                                                        <input type="text" class="form-control" id="planSize"
                                                            name="plan_size[]">
=======
                                                        <input type="text" class="form-control" id="planSize" name="plan_size[]">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                    </div>
                                                </div>
                                                <div class="col-lg-4">
                                                    <div class="wrap-custom-file">
<<<<<<< HEAD
                                                        <input type="file" name="plan_image_path[]" id="planImage"
                                                            accept=".gif, .jpg, .jpeg, .png">
                                                        <label for="planImage">
                                                            <span><i class="flaticon-download"></i> Upload Plan
                                                                Image</span>
=======
                                                        <input type="file" name="plan_image_path[]" id="planImage" accept=".gif, .jpg, .jpeg, .png">
                                                        <label for="planImage">
                                                            <span><i class="flaticon-download"></i> Upload Plan Image</span>
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-xl-8">
                                                    <div class="my_profile_setting_textarea mt30-991">
                                                        <label for="planDescription">Plan Description</label>
<<<<<<< HEAD
                                                        <textarea class="form-control" id="planDescription"
                                                            name="plan_description[]" rows="8"></textarea>
=======
                                                        <textarea class="form-control" id="planDescription" name="plan_description[]" rows="8"></textarea>
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-12 mt30">
                                            <div class="my_profile_setting_input">
                                                <button class="btn btn2 float-right" type="submit">Add Property</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
    <script type="text/javascript" src="../../js/bootstrap-select.min.js"></script>
    <script>
        const imageInput = document.getElementById('imageUploadInput');
        const previewList = document.getElementById('imagePreviewList');

<<<<<<< HEAD
        imageInput.addEventListener('change', function () {
            previewList.innerHTML = '';
            [...this.files].forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function (e) {
=======
        imageInput.addEventListener('change', function() {
            previewList.innerHTML = '';
            [...this.files].forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                    const li = document.createElement('li');
                    li.classList.add('list-inline-item');
                    li.innerHTML = `
                    <div class="portfolio_item">
                        <img class="img-fluid" src="${e.target.result}" alt="${file.name}">
                        <div class="edu_stats_list" title="Delete">
                            <a href="#" onclick="removeImage(${index}); return false;">
                                <span class="flaticon-garbage"></span>
                            </a>
                        </div>
                    </div>`;
                    previewList.appendChild(li);
                };
                reader.readAsDataURL(file);
            });
        });

        // Delete previewed image (client side only)
        function removeImage(index) {
            const dt = new DataTransfer();
            let files = imageInput.files;

            for (let i = 0; i < files.length; i++) {
                if (i !== index) dt.items.add(files[i]);
            }

            imageInput.files = dt.files;
            imageInput.dispatchEvent(new Event('change')); // refresh preview
        }

        // Show attachment file name
<<<<<<< HEAD
        document.getElementById('attachmentFile').addEventListener('change', function () {
=======
        document.getElementById('attachmentFile').addEventListener('change', function() {
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
            document.getElementById('attachmentName').value = this.files[0]?.name || '';
        });
    </script>
    <script>
<<<<<<< HEAD
        document.getElementById('planImage').addEventListener('change', function (event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
=======
        document.getElementById('planImage').addEventListener('change', function(event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                    const label = document.querySelector('label[for="planImage"]');
                    label.style.backgroundImage = `url('${e.target.result}')`;
                };
                reader.readAsDataURL(input.files[0]);
            }
        });
    </script>
    <script>
<<<<<<< HEAD
        document.getElementById('addPlanBtn').addEventListener('click', function () {
=======
        document.getElementById('addPlanBtn').addEventListener('click', function() {
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
            let original = document.querySelector('.floor-plan-block');
            let clone = original.cloneNode(true);

            // Clear inputs
            clone.querySelectorAll('input, textarea').forEach(el => {
                if (el.type !== "file") el.value = '';
            });

            // Remove existing add/delete button
            let actionDiv = clone.querySelector('.plan-header-actions');
            if (actionDiv) {
                actionDiv.innerHTML = '<button type="button" class="btn btn-danger mb30 removePlanBtn">Delete</button>';
            }

            // Append clone
            original.parentNode.appendChild(clone);
        });

        // Delegate delete functionality
<<<<<<< HEAD
        document.addEventListener('click', function (e) {
=======
        document.addEventListener('click', function(e) {
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
            if (e.target && e.target.classList.contains('removePlanBtn')) {
                e.target.closest('.floor-plan-block').remove();
            }
        });

<<<<<<< HEAD
        document.getElementById('planImage').addEventListener('change', function () {
=======
        document.getElementById('planImage').addEventListener('change', function() {
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
            const fileName = this.files[0]?.name || '';
            document.getElementById('imagePreview').textContent = fileName;
        });
    </script>
</body>

</html>