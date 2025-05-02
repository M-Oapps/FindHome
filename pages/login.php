<?php
session_start();
include("../include/db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        $_SESSION["email"] = $user["email"];
        $_SESSION["role"] = $user["role"]; // save role in session

        // Redirect to home page
        header("Location: index.php");
        exit();
    } else {
        echo "Invalid Email or Password!";
    }
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
    <title>Login Page</title>
</head>

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
                            <h4 class="breadcrumb_title">Logın</h4>
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Logın</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="our-log bgc-fa">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-lg-6 offset-lg-3">
                        <div class="login_form inner_page">
                            <form method="POST" action="login.php">
                                <div class="heading">
                                    <h3 class="text-center">Login to your account</h3>
                                    <p class="text-center">Don't have an account? <a class="text-thm"
                                            href="register.php">Sign Up!</a></p>
                                </div>
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control" placeholder="Email Address"
                                        required>
                                </div>
                                <div class="form-group">
                                    <input type="password" name="password" class="form-control" placeholder="Password"
                                        required>
                                </div>
                                <button type="submit" class="btn btn-log btn-block btn-thm2">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Start Partners -->
        <?php include "../pages/component/cta.php"; ?>

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