<?php
include("../../include/db_connect.php");

$types = $conn->query("SELECT id, name FROM property_type")->fetchAll(PDO::FETCH_ASSOC);
$cities = $conn->query("SELECT id, name FROM cities")->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['id'])) {
    $property_id = intval($_GET['id']);
    // Fetch property data
    $stmt = $conn->prepare("SELECT * FROM properties WHERE id = ?");
    $stmt->execute([$property_id]);
    $property = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$property) {
        die("Property not found.");
    }
} else {
    die("No property ID provided.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // 1. Update base property info
        $stmt = $conn->prepare("UPDATE properties SET
            title = :title,
            description = :description,
            type = :type,
            status = :status,
            rooms = :rooms,
            price = :price,
            area = :area,
            address = :address,
            state = :state,
            city = :city,
            neighborhood = :neighborhood,
            zip_code = :zip_code,
            latitude = :latitude,
            longitude = :longitude,
            area_size = :area_size,
            size_prefix = :size_prefix,
            land_area = :land_area,
            land_area_postfix = :land_area_postfix,
            bedrooms = :bedrooms,
            bathrooms = :bathrooms,
            garages = :garages,
            garage_size = :garage_size,
            year_built = :year_built,
            video_url = :video_url,
            virtual_tour_url = :virtual_tour_url,
            is_featured = :is_featured
        WHERE id = :id");

        $stmt->execute([
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
            ':id' => $property_id
        ]);

        // 2. Update amenities
        $conn->prepare("DELETE FROM property_amenities WHERE property_id = ?")->execute([$property_id]);

        if (!empty($_POST['amenities'])) {
            $stmt = $conn->prepare("INSERT INTO property_amenities (property_id, amenity_name) VALUES (?, ?)");
            foreach ($_POST['amenities'] as $amenity) {
                $stmt->execute([$property_id, $amenity]);
            }
        }

        // 3. Upload new images
        if (!empty($_FILES['images']['name'][0])) {
            $uploadDir = '../../images/uploads/images/';
            $uploadUrl = 'images/uploads/images/';
            if (!file_exists($uploadDir)) mkdir($uploadDir, 0777, true);

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

        // 4. Upload attachment (replace old one)
        if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] === 0) {
            $attachDir = '../../images/uploads/attachments/';
            $attachUrl = 'images/uploads/attachments/';
            if (!file_exists($attachDir)) mkdir($attachDir, 0777, true);

            $filename = time() . '_' . basename($_FILES['attachment']['name']);
            $targetFile = $attachDir . $filename;
            if (move_uploaded_file($_FILES['attachment']['tmp_name'], $targetFile)) {
                $attachmentPath = $attachUrl . $filename;
                $stmt = $conn->prepare("UPDATE properties SET attachment_url = ? WHERE id = ?");
                $stmt->execute([$attachmentPath, $property_id]);
            }
        }

        // 5. Floorplans - delete and re-insert (or use a smarter update logic)
        $conn->prepare("DELETE FROM property_floorplans WHERE property_id = ?")->execute([$property_id]);

        if (!empty($_POST['plan_title'])) {
            $stmt = $conn->prepare("INSERT INTO property_floorplans (
                property_id, title, bedrooms, bathrooms, price,
                price_postfix, size, image_path, description
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $floorImageDir = '../../images/uploads/floorplans/';
            $floorImageUrl = 'images/uploads/floorplans/';
            if (!file_exists($floorImageDir)) mkdir($floorImageDir, 0777, true);

            foreach ($_POST['plan_title'] as $i => $title) {
                $imgPath = '';
                if (!empty($_FILES['plan_image_path']['name'][$i]) && $_FILES['plan_image_path']['error'][$i] === 0) {
                    $filename = time() . '_' . basename($_FILES['plan_image_path']['name'][$i]);
                    $targetFile = $floorImageDir . $filename;
                    if (move_uploaded_file($_FILES['plan_image_path']['tmp_name'][$i], $targetFile)) {
                        $imgPath = $floorImageUrl . $filename;
                    }
                }
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

        header("Location: properties-list.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
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
    <title>Edit property page</title>
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
                                    <h2 class="breadcrumb_title">Edit Property</h2>
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
                                                    <input type="text" class="form-control" name="title" value="<?= htmlspecialchars($property['title'] ?? '') ?>">
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="my_profile_setting_textarea">
                                                    <label for="propertyDescription">Description</label>
                                                    <textarea class="form-control" id="propertyDescription" rows="7" name="description"><?= htmlspecialchars($property['description'] ?? '') ?></textarea>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-xl-4">
                                                <div class="my_profile_setting_input ui_kit_select_search form-group">
                                                    <label>Type</label>
                                                    <select class="selectpicker" data-live-search="true" data-width="100%" name="type">
                                                        <option value="">Select Type</option>
                                                        <?php foreach ($types as $type): ?>
                                                            <option value="<?= htmlspecialchars($type['name']) ?>" <?= ($property['type'] == $type['name']) ? 'selected' : '' ?>><?= htmlspecialchars($type['name']) ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-xl-4">
                                                <div class="my_profile_setting_input ui_kit_select_search form-group">
                                                    <label>Status</label>
                                                    <select class="selectpicker" data-live-search="true" data-width="100%" name="status">
                                                        <option value="">Select Status</option>
                                                        <option value="Rent" <?= ($property['status'] == 'Rent') ? 'selected' : '' ?>>Rent</option>
                                                        <option value="Sale" <?= ($property['status'] == 'Sale') ? 'selected' : '' ?>>Sale</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-xl-4">
                                                <div class="my_profile_setting_input ui_kit_select_search form-group">
                                                    <label>Rooms</label>
                                                    <select class="selectpicker" data-live-search="true" data-width="100%" name="rooms">
                                                        <option value="">Select Rooms</option>
                                                        <option value="1" <?= ($property['rooms'] == '1') ? 'selected' : '' ?>>1</option>
                                                        <option value="2" <?= ($property['rooms'] == '2') ? 'selected' : '' ?>>2</option>
                                                        <option value="3" <?= ($property['rooms'] == '3') ? 'selected' : '' ?>>3</option>
                                                        <option value="4" <?= ($property['rooms'] == '4') ? 'selected' : '' ?>>4</option>
                                                        <option value="5" <?= ($property['rooms'] == '5') ? 'selected' : '' ?>>5</option>
                                                        <option value="Other" <?= ($property['rooms'] == 'Other') ? 'selected' : '' ?>>Other</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-xl-6">
                                                <div class="my_profile_setting_input form-group">
                                                    <label for="formGroupExamplePrice">Price</label>
                                                    <input type="text" class="form-control" name="price" value="<?= htmlspecialchars($property['price'] ?? '') ?>">
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-xl-6">
                                                <div class="my_profile_setting_input form-group">
                                                    <label for="formGroupExampleArea">Area</label>
                                                    <input type="text" class="form-control" name="area" value="<?= htmlspecialchars($property['area'] ?? '') ?>">
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
                                                    <input type="text" class="form-control" name="address" value="<?= htmlspecialchars($property['address'] ?? '') ?>">
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-xl-4">
                                                <div class="my_profile_setting_input form-group">
                                                    <label for="propertyState">County / State</label>
                                                    <input type="text" class="form-control" name="state" value="<?= htmlspecialchars($property['state'] ?? '') ?>">
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-xl-4">
                                                <div class="my_profile_setting_input ui_kit_select_search form-group">
                                                    <label>City</label>
                                                    <select class="selectpicker" data-live-search="true" data-width="100%" name="city">
                                                        <option value="">Select City</option>
                                                        <?php foreach ($cities as $city): ?>
                                                            <option value="<?= htmlspecialchars($city['name']) ?>" <?= ($property['city'] == $city['name']) ? 'selected' : '' ?>>
                                                                <?= htmlspecialchars($city['name']) ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-xl-4">
                                                <div class="my_profile_setting_input form-group">
                                                    <label for="neighborHood">Neighborhood</label>
                                                    <input type="text" class="form-control" name="neighborhood" value="<?= htmlspecialchars($property['neighborhood'] ?? '') ?>">
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-xl-4">
                                                <div class="my_profile_setting_input form-group">
                                                    <label for="zipCode">Zip</label>
                                                    <input type="text" class="form-control" name="zip" value="<?= htmlspecialchars($property['zip_code'] ?? '') ?>">
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-xl-4">
                                                <div class="my_profile_setting_input form-group">
                                                    <label for="googleMapLat">Latitude (for Google Maps)</label>
                                                    <input type="text" class="form-control" id="googleMapLat" name="latitude" value="<?= htmlspecialchars($property['latitude'] ?? '') ?>">
                                                </div>
                                            </div>

                                            <div class="col-lg-4 col-xl-4">
                                                <div class="my_profile_setting_input form-group">
                                                    <label for="googleMapLong">Longitude (for Google Maps)</label>
                                                    <input type="text" class="form-control" id="googleMapLong" name="longitude" value="<?= htmlspecialchars($property['longitude'] ?? '') ?>">
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
                                                    <input type="text" class="form-control" id="propertyASize" name="area_size" value="<?= htmlspecialchars($property['area_size'] ?? '') ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-4">
                                                <div class="my_profile_setting_input form-group">
                                                    <label for="sizePrefix">Size Prefix</label>
                                                    <input type="text" class="form-control" id="sizePrefix" name="size_prefix" value="<?= htmlspecialchars($property['size_prefix'] ?? '') ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-4">
                                                <div class="my_profile_setting_input form-group">
                                                    <label for="landArea">Land Area</label>
                                                    <input type="text" class="form-control" id="landArea" name="land_area" value="<?= htmlspecialchars($property['land_area'] ?? '') ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-4">
                                                <div class="my_profile_setting_input form-group">
                                                    <label for="LASPostfix">Land Area Size Postfix</label>
                                                    <input type="text" class="form-control" id="LASPostfix" name="land_area_postfix" value="<?= htmlspecialchars($property['land_area_postfix'] ?? '') ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-4">
                                                <div class="my_profile_setting_input form-group">
                                                    <label for="bedRooms">Bedrooms</label>
                                                    <input type="text" class="form-control" id="bedRooms" name="bedrooms" value="<?= htmlspecialchars($property['bedrooms'] ?? '') ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-4">
                                                <div class="my_profile_setting_input form-group">
                                                    <label for="bathRooms">Bathrooms</label>
                                                    <input type="text" class="form-control" id="bathRooms" name="bathrooms" value="<?= htmlspecialchars($property['bathrooms'] ?? '') ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-4">
                                                <div class="my_profile_setting_input form-group">
                                                    <label for="garages">Garages</label>
                                                    <input type="text" class="form-control" id="garages" name="garages" value="<?= htmlspecialchars($property['garages'] ?? '') ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-4">
                                                <div class="my_profile_setting_input form-group">
                                                    <label for="garagesSize">Garages Size</label>
                                                    <input type="text" class="form-control" id="garagesSize" name="garage_size" value="<?= htmlspecialchars($property['garage_size'] ?? '') ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-4">
                                                <div class="my_profile_setting_input form-group">
                                                    <label for="yearBuild">Year Built</label>
                                                    <input type="text" class="form-control" id="yearBuild" name="year_built" value="<?= htmlspecialchars($property['year_built'] ?? '') ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-4">
                                                <div class="my_profile_setting_input form-group">
                                                    <label for="videoUrl">Video URL</label>
                                                    <input type="text" class="form-control" id="videoUrl" name="video_url" value="<?= htmlspecialchars($property['video_url'] ?? '') ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-4">
                                                <div class="my_profile_setting_input form-group">
                                                    <label for="virtualTour">360° Virtual Tour</label>
                                                    <input type="text" class="form-control" id="virtualTour" name="virtual_tour" value="<?= htmlspecialchars($property['virtual_tour_url'] ?? '') ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-4">
                                                <div class="custom-control custom-checkbox ui_kit_checkbox selectable-list" style="margin-top: 40px;">
                                                    <input type="checkbox" class="custom-control-input" id="isFeatured" name="is_featured" <?= ($property['is_featured'] == 1) ? 'checked' : '' ?>>
                                                    <label class="custom-control-label" for="isFeatured">Is Featured?</label>
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
                                            // Fetch selected amenities from DB for this property
                                            $selected_amenities = [];
                                            $stmt = $conn->prepare("SELECT amenity_name FROM property_amenities WHERE property_id = ?");
                                            $stmt->execute([$property['id']]);
                                            $selected_amenities = array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'amenity_name');
                                            // Split into 3 columns (5 per column)
                                            $i = 1;
                                            foreach (array_chunk($amenities, 5) as $chunk): ?>
                                                <div class="col-sm-4 col-md-4 col-lg-4">
                                                    <ul class="ui_kit_checkbox selectable-list">
                                                        <?php foreach ($chunk as $label): ?>
                                                            <li>
                                                                <div class="custom-control custom-checkbox">
                                                                    <input type="checkbox" class="custom-control-input" id="customCheck<?= $i ?>"
                                                                        name="amenities[]" value="<?= htmlspecialchars($label) ?>"
                                                                        <?= in_array($label, $selected_amenities) ? 'checked' : '' ?>>
                                                                    <label class="custom-control-label" for="customCheck<?= $i ?>"><?= $label ?></label>
                                                                </div>
                                                            </li>
                                                        <?php $i++;
                                                        endforeach; ?>
                                                    </ul>
                                                </div>
                                            <?php endforeach; ?>
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
                                                    <input type="file" name="images[]" id="imageUploadInput" multiple accept="image/*">
                                                    <div class="icon"><span class="flaticon-download"></span></div>
                                                    <p>Drag and drop images here</p>
                                                </div>
                                            </div>
                                            <div class="col-xl-8">
                                                <div class="resume_uploader mb30">
                                                    <h3>Attachments</h3>
                                                    <div class="form-inline d-flex flex-wrap wrap">
                                                        <input class="upload-path form-control w-75" readonly id="attachmentName">
                                                        <label class="upload">
                                                            <input type="file" name="attachment" id="attachmentFile"> Select Attachment
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
                                                        <button type="button" class="btn admore_btn mb30" id="addPlanBtn">Add More</button>
                                                    </div>
                                                </div>
                                                <div class="col-xl-12">
                                                    <div class="my_profile_setting_input form-group">
                                                        <label for="planTitle">Plan Title</label>
                                                        <input type="text" class="form-control" id="planTitle" name="plan_title[]">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-xl-4">
                                                    <div class="my_profile_setting_input form-group">
                                                        <label for="planBedrooms">Plan Bedrooms</label>
                                                        <input type="text" class="form-control" id="planBedrooms" name="plan_bedrooms[]">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-xl-4">
                                                    <div class="my_profile_setting_input form-group">
                                                        <label for="planBathrooms">Plan Bathrooms</label>
                                                        <input type="text" class="form-control" id="planBathrooms" name="plan_bathrooms[]">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-xl-4">
                                                    <div class="my_profile_setting_input form-group">
                                                        <label for="planPrice">Plan Price</label>
                                                        <input type="text" class="form-control" id="planPrice" name="plan_price[]">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-xl-4">
                                                    <div class="my_profile_setting_input form-group">
                                                        <label for="planPostfix">Price Postfix</label>
                                                        <input type="text" class="form-control" id="planPostfix" name="plan_price_postfix[]">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-xl-4">
                                                    <div class="my_profile_setting_input form-group">
                                                        <label for="planSize">Plan Size</label>
                                                        <input type="text" class="form-control" id="planSize" name="plan_size[]">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-xl-4">
                                                    <div class="my_profile_setting_input form-group">
                                                        <label>Plan Image</label>
                                                        <div class="avatar-upload">
                                                            <div class="avatar-edit">
                                                                <input type="file" id="planImage" name="plan_image_path[]" accept=".png, .jpg, .jpeg">
                                                                <label for="planImage" id="planImagefile"></label>
                                                            </div>
                                                            <div class="avatar-preview">
                                                                <div class="form-control" id="imagePreview"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-xl-12">
                                                    <div class="my_profile_setting_textarea mt30-991">
                                                        <label for="planDescription">Plan Description</label>
                                                        <textarea class="form-control" id="planDescription" name="plan_description[]" rows="7"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-12 mt30">
                                            <div class="my_profile_setting_input">
                                                <button class="btn btn2 float-right" type="submit">Update Property</button>
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

        imageInput.addEventListener('change', function() {
            previewList.innerHTML = '';
            [...this.files].forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
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
        document.getElementById('attachmentFile').addEventListener('change', function() {
            document.getElementById('attachmentName').value = this.files[0]?.name || '';
        });
    </script>
    <script>
        document.getElementById('addPlanBtn').addEventListener('click', function() {
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
        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('removePlanBtn')) {
                e.target.closest('.floor-plan-block').remove();
            }
        });

        document.getElementById('planImage').addEventListener('change', function() {
            const fileName = this.files[0]?.name || '';
            document.getElementById('imagePreview').textContent = fileName;
        });
    </script>


</body>

</html>