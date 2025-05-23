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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $stmt = $conn->prepare("
            INSERT INTO users 
            (username, email, first_name, last_name, position, license, tax_number, phone, fax_number, mobile, language, company_name, address, about_me, website, skype, facebook, twitter, linkedin, instagram, google_plus, youtube, pinterest, vimeo, photo)
            VALUES 
            (:username, :email, :first_name, :last_name, :position, :license, :tax_number, :phone, :fax_number, :mobile, :language, :company_name, :address, :about_me, :website, :skype, :facebook, :twitter, :linkedin, :instagram, :google_plus, :youtube, :pinterest, :vimeo, :photo)
        ");

        // File upload logic
        $imagePath = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $uploadDir = '../../images/uploads/'; // server path
            $uploadUrl = 'images/uploads/'; // relative URL to save in DB
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true); // create directory if not exists
            }
            $imageName = time() . '_' . basename($_FILES['image']['name']); // add timestamp to avoid duplicates
            $targetFile = $uploadDir . $imageName;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $imagePath = $uploadUrl . $imageName; // save the relative path to database
            }
        }


        // Bind values
        $stmt->execute([
            ':username' => $_POST['username'],
            ':email' => $_POST['email'],
            ':first_name' => $_POST['first_name'],
            ':last_name' => $_POST['last_name'],
            ':position' => $_POST['position'],
            ':license' => $_POST['license'],
            ':tax_number' => $_POST['tax_number'],
            ':phone' => $_POST['phone'],
            ':fax_number' => $_POST['fax_number'],
            ':mobile' => $_POST['mobile'],
            ':language' => $_POST['language'],
            ':company_name' => $_POST['company_name'],
            ':address' => $_POST['address'],
            ':about_me' => $_POST['about_me'],
            ':website' => $_POST['website'],
            ':skype' => $_POST['skype'],
            ':facebook' => $_POST['facebook'],
            ':twitter' => $_POST['twitter'],
            ':linkedin' => $_POST['linkedin'],
            ':instagram' => $_POST['instagram'],
            ':google_plus' => $_POST['google_plus'],
            ':youtube' => $_POST['youtube'],
            ':pinterest' => $_POST['pinterest'],
            ':vimeo' => $_POST['vimeo'],
            ':photo' => $imagePath
        ]);

        header("Location: user-list.php"); // redirect after success
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
    <title>User/Agent Add Page</title>
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
                                    <h2 class="breadcrumb_title">User/agent Add</h2>
                                    <p>We are glad to see you again!</p>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <form method="POST" enctype="multipart/form-data" action="">
                                    <div class="my_dashboard_review">
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="row">
                                                    <div class="col-lg-4 col-xl-4">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleInput1">Username</label>
<<<<<<< HEAD
                                                            <input type="text" name="username" class="form-control"
                                                                placeholder="Username" required>
=======
                                                            <input type="text" name="username" class="form-control" placeholder="Username" require>
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-xl-4">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleEmail">Email</label>
<<<<<<< HEAD
                                                            <input type="email" class="form-control" name="email"
                                                                placeholder="Email" required>
=======
                                                            <input type="email" class="form-control" name="email" placeholder="Email" require>
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-xl-4">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleInput3">First Name</label>
<<<<<<< HEAD
                                                            <input type="text" class="form-control" name="first_name"
                                                                placeholder="First Name">
=======
                                                            <input type="text" class="form-control" name="first_name" placeholder="First Name">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-xl-4">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleInput4">Last Name</label>
<<<<<<< HEAD
                                                            <input type="text" class="form-control" name="last_name"
                                                                placeholder="Last Name">
=======
                                                            <input type="text" class="form-control" name="last_name" placeholder="Last Name">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-xl-4">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleInput5">Position</label>
<<<<<<< HEAD
                                                            <input type="text" class="form-control" name="position"
                                                                placeholder="Position">
=======
                                                            <input type="text" class="form-control" name="position" placeholder="Position">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-xl-4">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleInput6">License</label>
<<<<<<< HEAD
                                                            <input type="text" class="form-control" name="license"
                                                                placeholder="License">
=======
                                                            <input type="text" class="form-control" name="license" placeholder="License">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-xl-4">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleInput7">Tax Number</label>
<<<<<<< HEAD
                                                            <input type="text" class="form-control" name="tax_number"
                                                                placeholder="Tax Number">
=======
                                                            <input type="text" class="form-control" name="tax_number" placeholder="Tax Number">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-xl-4">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleInput8">Phone</label>
<<<<<<< HEAD
                                                            <input type="tel" class="form-control" name="phone"
                                                                placeholder="Phone">
=======
                                                            <input type="tel" class="form-control" name="phone" placeholder="Phone">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-xl-4">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleInput9">Fax Number</label>
<<<<<<< HEAD
                                                            <input type="text" class="form-control" name="fax_number"
                                                                placeholder="Fax Number">
=======
                                                            <input type="text" class="form-control" name="fax_number" placeholder="Fax Number">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-xl-4">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleInput10">Mobile</label>
<<<<<<< HEAD
                                                            <input type="tel" class="form-control" name="mobile"
                                                                placeholder="Mobile">
=======
                                                            <input type="tel" class="form-control" name="mobile" placeholder="Mobile">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-xl-4">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleInput11">Language</label>
<<<<<<< HEAD
                                                            <input type="text" class="form-control" name="language"
                                                                placeholder="Language">
=======
                                                            <input type="text" class="form-control" name="language" placeholder="Language">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-xl-4">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleInput12">Company Name</label>
<<<<<<< HEAD
                                                            <input type="text" class="form-control" name="company_name"
                                                                placeholder="Company Name">
=======
                                                            <input type="text" class="form-control" name="company_name" placeholder="Company Name">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleInput13">Address</label>
<<<<<<< HEAD
                                                            <input type="text" class="form-control" name="address"
                                                                placeholder="Address">
=======
                                                            <input type="text" class="form-control" name="address" placeholder="Address">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="my_profile_setting_textarea">
                                                            <label for="exampleFormControlTextarea1">About me</label>
                                                            <textarea class="form-control" name="about_me"
                                                                rows="7"></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleWebsite">Website</label>
<<<<<<< HEAD
                                                            <input type="url" class="form-control" name="website"
                                                                placeholder="Website">
=======
                                                            <input type="url" class="form-control" name="website" placeholder="Website">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-xl-4">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleSkype">Skype</label>
<<<<<<< HEAD
                                                            <input type="text" class="form-control" name="skype"
                                                                placeholder="Skype Url">
=======
                                                            <input type="text" class="form-control" name="skype" placeholder="Skype Url">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 col-xl-4">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleFaceBook">Facebook</label>
<<<<<<< HEAD
                                                            <input type="url" class="form-control" name="facebook"
                                                                placeholder="Facebook Url">
=======
                                                            <input type="url" class="form-control" name="facebook" placeholder="Facebook Url">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-xl-4">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleTwitter">Twitter</label>
<<<<<<< HEAD
                                                            <input type="url" class="form-control" name="twitter"
                                                                placeholder="Twitter Url">
=======
                                                            <input type="url" class="form-control" name="twitter" placeholder="Twitter Url">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-xl-4">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleLinkedin">Linkedin</label>
<<<<<<< HEAD
                                                            <input type="url" class="form-control" name="linkedin"
                                                                placeholder="Linkedin Url">
=======
                                                            <input type="url" class="form-control" name="linkedin" placeholder="Linkedin Url">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-xl-4">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleInstagram">Instagram</label>
<<<<<<< HEAD
                                                            <input type="url" class="form-control" name="instagram"
                                                                placeholder="Instagram Url">
=======
                                                            <input type="url" class="form-control" name="instagram" placeholder="Instagram Url">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-xl-4">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleGooglePlus">Google Plus</label>
<<<<<<< HEAD
                                                            <input type="url" class="form-control" name="google_plus"
                                                                placeholder="Google Plus Url">
=======
                                                            <input type="url" class="form-control" name="google_plus" placeholder="Google Plus Url">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-xl-4">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleYoutube">Youtube</label>
<<<<<<< HEAD
                                                            <input type="url" class="form-control" name="youtube"
                                                                placeholder="Youtube Url">
=======
                                                            <input type="url" class="form-control" name="youtube" placeholder="Youtube Url">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-xl-4">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExamplePinterest">Pinterest</label>
<<<<<<< HEAD
                                                            <input type="url" class="form-control" name="pinterest"
                                                                placeholder="Pinterest Url">
=======
                                                            <input type="url" class="form-control" name="pinterest" placeholder="Pinterest Url">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-xl-4">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleVimeo">Vimeo</label>
<<<<<<< HEAD
                                                            <input type="url" class="form-control" name="vimeo"
                                                                placeholder="Vimeo Url">
=======
                                                            <input type="url" class="form-control" name="vimeo" placeholder="Vimeo Url">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="wrap-custom-file">
<<<<<<< HEAD
                                                            <input type="file" name="image" id="image"
                                                                accept=".gif, .jpg, .jpeg, .png">
                                                            <label for="image">
                                                                <span><i class="flaticon-download"></i> Upload Photo
                                                                </span>
=======
                                                            <input type="file" name="image" id="image" accept=".gif, .jpg, .jpeg, .png">
                                                            <label for="image">
                                                                <span><i class="flaticon-download"></i> Upload Photo </span>
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                            </label>
                                                        </div>
                                                        <p>*minimum 260px x 260px</p>
                                                    </div>
                                                    <div class="col-xl-12 text-right">
                                                        <div class="my_profile_setting_input">
                                                            <button class="btn btn2">Add User/Agent</button>
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
    <script>
<<<<<<< HEAD
        document.getElementById('image').addEventListener('change', function (event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
=======
        document.getElementById('image').addEventListener('change', function(event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                    const label = document.querySelector('label[for="image"]');
                    label.style.backgroundImage = `url('${e.target.result}')`;
                };
                reader.readAsDataURL(input.files[0]);
            }
        });
    </script>


</body>

</html>