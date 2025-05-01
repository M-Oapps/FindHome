<?php
include("../../include/db_connect.php");

session_start();

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header("Location: ../login.php");
    exit();
}

$city = null;

// Fetch existing city
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $stmt = $conn->prepare("SELECT * FROM property_type WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $property_type = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$property_type) {
        die("Property type not found.");
    }
} else {
    die("Invalid request.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $name = $_POST['name'];

        // Update query
        $stmt = $conn->prepare("UPDATE property_type SET name = :name WHERE id = :id");
        $stmt->execute([
            ':name' => $name,
            ':id' => $_GET['id']
        ]);

        header("Location: property-type-list.php");
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
    <title>property Type Edit Page</title>
</head>

<body>
    <div class="wrapper">
        <!--	Header start  -->
        <?php include "../../include/admin/header.php"; ?>
        <!--	Header end  -->

        <section class="our-dashbord dashbord bgc-f7">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-xl-12 maxw100flex-992">
                        <div class="row">
                            <div class="col-lg-6 mb10">
                                <div class="breadcrumb_content style2">
                                    <h2 class="breadcrumb_title">Property Type Edit</h2>
                                    <p>We are glad to see you again!</p>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <form method="POST" enctype="multipart/form-data" action="">
                                    <div class="my_dashboard_review">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="row">
                                                    <div class="col-lg-8 col-xl-8">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleInput1">City Name</label>
                                                            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($property_type['name'] ?? '') ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12 text-right">
                                                        <div class="my_profile_setting_input">
                                                            <button class="btn btn2">Edit Property Type</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row mt30">
                            <div class="col-lg-12">
                                <div class="copyright-widget text-center">
                                    <p>© <?php echo date('Y'); ?> Home Find. All rights reserved.</p>
                                </div>
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