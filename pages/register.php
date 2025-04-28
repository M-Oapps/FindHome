<?php
session_start();
include("../include/db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm_password"]);

    if ($password != $confirm_password) {
        die("Passwords do not match!");
    }

    // Check if email exists
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->execute([$email]);
    if ($check->rowCount() > 0) {
        die("Email already registered.");
    }

    // Role logic
    $user_count = $conn->query("SELECT COUNT(*) FROM users")->fetchColumn();
    $role = ($user_count == 0) ? 'admin' : 'agent'; // first user = admin, rest = agent

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->execute([$username, $email, $hashed_password, $role]);

    // Redirect to login page
    header("Location: login.php");
    exit();
}
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
    <title>Register page</title>

<body>
    <div class="wrapper">

        <!--	Header start  -->
        <?php include "../include/header.php"; ?>
        <!--	Header end  -->

        <section class="inner_page_breadcrumb">
            <div class="container">
                <div class="row">
                    <div class="col-xl-6">
                        <div class="breadcrumb_content">
                            <h4 class="breadcrumb_title">Register</h4>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Register</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="our-log-reg bgc-fa">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-lg-6 offset-lg-3">
                        <div class="sign_up_form inner_page">
                            <div class="heading">
                                <h3 class="text-center">Register to start learning</h3>
                                <p class="text-center">Have an account? <a class="text-thm"
                                        href="../pages/login.php">Login</a></p>
                            </div>
                            <div class="details">
                                <form method="POST" action="register.php">
                                    <div class="form-group">
                                        <input type="text" name="username" class="form-control" placeholder="Username" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control" placeholder="Email Address" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" required>
                                    </div>
                                    <button type="submit" class="btn btn-log btn-block btn-thm2">Register</button>
                                    <div class="divide mt40">
                                        <span class="lf_divider">Or</span>
                                        <hr>
                                    </div>
                                    <div class="row mt40">
                                        <div class="col-lg-8">
                                            <div>Already have an account?</div>
                                        </div>
                                        <div class="col-lg">
                                            <a class="tdu btn-fpswd float-right" href="../pages/login.php">Login</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="start-partners bgc-thm pt50 pb50">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="start_partner tac-smd">
                            <h2>Become a Real Estate Agent</h2>
                            <p>We only work with the best companies around the globe</p>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="parner_reg_btn text-right tac-smd">
                            <a class="btn btn-thm2" href="#">Register Now</a>
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
</body>

</html>