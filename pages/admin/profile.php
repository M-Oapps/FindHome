<?php
session_start();
include("../../include/db_connect.php");

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header("Location: ../login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$profile_updated = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetching the data from the form
    $username = trim($_POST["username"]);
    $email = trim($_POST["email"]);
    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);
    $position = trim($_POST["position"]);
    $license = trim($_POST["license"]);
    $tax_number = trim($_POST["tax_number"]);
    $phone = trim($_POST["phone"]);
    $fax_number = trim($_POST["fax_number"]);
    $mobile = trim($_POST["mobile"]);
    $language = trim($_POST["language"]);
    $company_name = trim($_POST["company_name"]);
    $address = trim($_POST["address"]);
    $about_me = trim($_POST["about_me"]);
    $skype = trim($_POST["skype"]);
    $website = trim($_POST["website"]);
    $facebook = trim($_POST["facebook"]);
    $twitter = trim($_POST["twitter"]);
    $linkedin = trim($_POST["linkedin"]);
    $instagram = trim($_POST["instagram"]);
    $google_plus = trim($_POST["google_plus"]);
    $youtube = trim($_POST["youtube"]);
    $pinterest = trim($_POST["pinterest"]);
    $vimeo = trim($_POST["vimeo"]);

    // Handling Profile Image Upload
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

    // Updating the profile in the database
    $update_query = "UPDATE users SET username = ?, email = ?, first_name = ?, last_name = ?, position = ?, license = ?, tax_number = ?, phone = ?, fax_number = ?, mobile = ?, language = ?, company_name = ?, address = ?, about_me = ?, skype = ?, website = ?, facebook = ?, twitter = ?, linkedin = ?, instagram = ?, google_plus = ?, youtube = ?, pinterest = ?, vimeo = ?, photo = COALESCE(?, photo) WHERE id = ?";
    $stmt = $conn->prepare($update_query);
    $stmt->execute([$username, $email, $first_name, $last_name, $position, $license, $tax_number, $phone, $fax_number, $mobile, $language, $company_name, $address, $about_me,  $skype, $website, $facebook, $twitter, $linkedin, $instagram, $google_plus, $youtube, $pinterest, $vimeo, $imagePath, $user_id]);

    $profile_updated = true;
}

// Fetch user data from database
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
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
    <title>Profile Page</title>
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
                                    <h2 class="breadcrumb_title">My Profile</h2>
                                    <p>We are glad to see you again!</p>
                                </div>
                            </div>
                            <div class="col-lg-6 mb10">
                                <?php if ($profile_updated): ?>
                                    <div class="alert alert-success" id="profileAlert">
                                        Profile updated successfully!
                                    </div>
                                    <script>
                                        setTimeout(function() {
                                            var alert = document.getElementById('profileAlert');
                                            if (alert) {
                                                alert.style.display = 'none';
                                            }
                                        }, 3000);
                                    </script>
                                <?php endif; ?>

                            </div>
                            <div class="col-lg-12">
                                <form method="POST" enctype="multipart/form-data">
                                    <div class="my_dashboard_review">
                                        <div class="row">
                                            <div class="col-xl-2">
                                                <h4>Profile Information</h4>
                                            </div>
                                            <div class="col-xl-10">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <div class="wrap-custom-file">
                                                            <input type="file" name="image" id="image" accept=".gif, .jpg, .jpeg, .png">
                                                            <label for="image"
                                                                <?php if (!empty($user['photo'])): ?>
                                                                style="background-image: url('<?php echo '../../' . $user['photo']; ?>');"
                                                                <?php endif; ?>>
                                                                <span><i class="flaticon-download"></i> Upload Photo </span>
                                                            </label>
                                                        </div>
                                                        <p>*minimum 260px x 260px</p>
                                                    </div>
                                                    <div class="col-lg-6 col-xl-6">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleInput1">Username</label>
                                                            <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($user['username']); ?>" require>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-xl-6">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleEmail">Email</label>
                                                            <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($user['email']); ?>" require>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-xl-6">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleInput3">First Name</label>
                                                            <input type="text" class="form-control" name="first_name" value="<?= htmlspecialchars($user['first_name']); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-xl-6">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleInput4">Last Name</label>
                                                            <input type="text" class="form-control" name="last_name" value="<?= htmlspecialchars($user['last_name']); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-xl-6">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleInput5">Position</label>
                                                            <input type="text" class="form-control" name="position" value="<?= htmlspecialchars($user['position']); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-xl-6">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleInput6">License</label>
                                                            <input type="text" class="form-control" name="license" value="<?= htmlspecialchars($user['license']); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-xl-6">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleInput7">Tax Number</label>
                                                            <input type="text" class="form-control" name="tax_number" value="<?= htmlspecialchars($user['tax_number']); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-xl-6">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleInput8">Phone</label>
                                                            <input type="tel" class="form-control" name="phone" value="<?= htmlspecialchars($user['phone']); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-xl-6">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleInput9">Fax Number</label>
                                                            <input type="text" class="form-control" name="fax_number" value="<?= htmlspecialchars($user['fax_number']); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-xl-6">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleInput10">Mobile</label>
                                                            <input type="tel" class="form-control" name="mobile" value="<?= htmlspecialchars($user['mobile']); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-xl-6">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleInput11">Language</label>
                                                            <input type="text" class="form-control" name="language" value="<?= htmlspecialchars($user['language']); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-xl-6">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleInput12">Company Name</label>
                                                            <input type="text" class="form-control" name="company_name" value="<?= htmlspecialchars($user['company_name']); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleInput13">Address</label>
                                                            <input type="text" class="form-control" name="address" value="<?= htmlspecialchars($user['address']); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="my_profile_setting_textarea">
                                                            <label for="exampleFormControlTextarea1">About me</label>
                                                            <textarea class="form-control" name="about_me"
                                                                rows="7"><?= htmlspecialchars($user['about_me']); ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-2">
                                                <h4>Social Media</h4>
                                            </div>
                                            <div class="col-xl-10">
                                                <div class="row">
                                                    <div class="col-lg-6 col-xl-6">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleSkype">Skype</label>
                                                            <input type="text" class="form-control" name="skype" value="<?= htmlspecialchars($user['skype']); ?>">
                                                        </div>
                                                    </div>
                                                    <div class=" col-lg-6 col-xl-6">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleWebsite">Website</label>
                                                            <input type="url" class="form-control" name="website" value="<?= htmlspecialchars($user['website']); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-xl-6">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleFaceBook">Facebook</label>
                                                            <input type="url" class="form-control" name="facebook" value="<?= htmlspecialchars($user['facebook']); ?>">
                                                        </div>
                                                    </div>
                                                    <div class=" col-lg-6 col-xl-6">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleTwitter">Twitter</label>
                                                            <input type="url" class="form-control" name="twitter" value="<?= htmlspecialchars($user['twitter']); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-xl-6">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleLinkedin">Linkedin</label>
                                                            <input type="url" class="form-control" name="linkedin" value="<?= htmlspecialchars($user['linkedin']); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-xl-6">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleInstagram">Instagram</label>
                                                            <input type="url" class="form-control" name="instagram" value="<?= htmlspecialchars($user['instagram']); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-xl-6">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleGooglePlus">Google Plus</label>
                                                            <input type="url" class="form-control" name="google_plus" value="<?= htmlspecialchars($user['google_plus']); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-xl-6">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleYoutube">Youtube</label>
                                                            <input type="url" class="form-control" name="youtube" value="<?= htmlspecialchars($user['youtube']); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-xl-6">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExamplePinterest">Pinterest</label>
                                                            <input type="url" class="form-control" name="pinterest" value="<?= htmlspecialchars($user['pinterest']); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6 col-xl-6">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleVimeo">Vimeo</label>
                                                            <input type="url" class="form-control" name="vimeo" value="<?= htmlspecialchars($user['vimeo']); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12 text-right">
                                                        <div class="my_profile_setting_input">
                                                            <button class="btn btn2">Update Profile</button>
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
        document.getElementById('image').addEventListener('change', function(event) {
            const input = event.target;
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const label = document.querySelector('label[for="image"]');
                    label.style.backgroundImage = `url('${e.target.result}')`;
                };
                reader.readAsDataURL(input.files[0]);
            }
        });
    </script>
</body>

</html>