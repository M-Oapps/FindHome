<?php
<<<<<<< HEAD
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include "../../include/db_connect.php";
=======
session_start();
include("../../include/db_connect.php");
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$password_updated = false;
$password_error = '';

// Password Update Logic
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_password'])) {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Fetch the user's current password from the database
    $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Validate old password
    if (password_verify($old_password, $user['password'])) {
        if ($new_password === $confirm_password) {
            // Hash new password and update in database
            $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update_query = "UPDATE users SET password = ? WHERE id = ?";
            $stmt = $conn->prepare($update_query);
            $stmt->execute([$hashed_new_password, $user_id]);
            $password_updated = true;
        } else {
            $password_error = "New password and confirmation do not match!";
        }
    } else {
        $password_error = "Old password is incorrect!";
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
    <title>Change password Page</title>
</head>

<body>
    <div class="wrapper">
        <!-- Header start -->
        <?php include "../../include/admin/header.php"; ?>
        <!-- Header end -->

        <section class="our-dashbord dashbord bgc-f7">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6 mb10">
<<<<<<< HEAD
                        <div class="breadcrumb_content">
=======
                        <div class="breadcrumb_content style2">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                            <h2 class="breadcrumb_title">Change password</h2>
                            <p>We are glad to see you again!</p>
                        </div>
                    </div>
                    <div class="col-lg-6 mb10">
                        <?php if ($password_updated): ?>
                            <div class="alert alert-success" id="passwordAlert">
                                Password updated successfully!
                            </div>
<<<<<<< HEAD
                        <?php elseif (!empty($password_error)): ?>
=======
                        <?php elseif (isset($password_error)): ?>
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                            <div class="alert alert-danger" id="passwordAlert">
                                <?php echo $password_error; ?>
                            </div>
                        <?php endif; ?>
                        <script>
<<<<<<< HEAD
                            // Hide the alert after 3 seconds
                            setTimeout(function () {
=======
                            setTimeout(function() {
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                var alert = document.getElementById('passwordAlert');
                                if (alert) {
                                    alert.style.display = 'none';
                                }
                            }, 3000);
                        </script>
                    </div>
                    <div class="col-lg-12 col-xl-12 maxw100flex-992">
                        <div class="my_dashboard_review mt30">
                            <form method="POST">
                                <div class="row">
                                    <div class="col-xl-2">
                                        <h4>Change password</h4>
                                    </div>
                                    <div class="col-xl-10">
                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="my_profile_setting_input form-group">
                                                    <label for="formGroupExampleOldPass">Old Password</label>
<<<<<<< HEAD
                                                    <input type="password" class="form-control" name="old_password"
                                                        required>
=======
                                                    <input type="password" class="form-control" name="old_password" required>
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-6 col-xl-6">
                                                <div class="my_profile_setting_input form-group">
                                                    <label for="formGroupExampleNewPass">New Password</label>
<<<<<<< HEAD
                                                    <input type="password" class="form-control" name="new_password"
                                                        required>
=======
                                                    <input type="password" class="form-control" name="new_password" required>
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-xl-6">
                                                <div class="my_profile_setting_input form-group">
                                                    <label for="formGroupExampleConfPass">Confirm New Password</label>
<<<<<<< HEAD
                                                    <input type="password" class="form-control" name="confirm_password"
                                                        required>
=======
                                                    <input type="password" class="form-control" name="confirm_password" required>
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="my_profile_setting_input float-right fn-520">
<<<<<<< HEAD
                                                    <button class="btn btn2" name="update_password">Change
                                                        password</button>
=======
                                                    <button class="btn btn2" name="update_password">Change password</button>
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
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