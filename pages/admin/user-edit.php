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

$user = null;
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
    $stmt->execute([$_GET['id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("User not found.");
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
<<<<<<< HEAD
        // Image upload
        $imagePath = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $uploadDir = '../../images/uploads/';
            $uploadUrl = 'images/uploads/';
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $imageName = time() . '_' . basename($_FILES['image']['name']);
            $targetFile = $uploadDir . $imageName;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $imagePath = $uploadUrl . $imageName;
            }
        }

        // Prepare SQL dynamically
        $sql = "
            UPDATE users SET
            username = :username,
            email = :email,
            first_name = :first_name,
            last_name = :last_name,
            position = :position,
            license = :license,
            tax_number = :tax_number,
            phone = :phone,
            fax_number = :fax_number,
            mobile = :mobile,
            language = :language,
            company_name = :company_name,
            address = :address,
            about_me = :about_me,
            website = :website,
            skype = :skype,
            facebook = :facebook,
            twitter = :twitter,
            linkedin = :linkedin,
            instagram = :instagram,
            google_plus = :google_plus,
            youtube = :youtube,
            pinterest = :pinterest,
            vimeo = :vimeo";

        if ($imagePath !== null) {
            $sql .= ", photo = :photo";
        }

        $sql .= " WHERE id = :id";

        $stmt = $conn->prepare($sql);

        $params = [
=======
        $stmt = $conn->prepare("
    UPDATE users SET
        username = :username,
        email = :email,
        first_name = :first_name,
        last_name = :last_name,
        position = :position,
        license = :license,
        tax_number = :tax_number,
        phone = :phone,
        fax_number = :fax_number,
        mobile = :mobile,
        language = :language,
        company_name = :company_name,
        address = :address,
        about_me = :about_me,
        website = :website,
        skype = :skype,
        facebook = :facebook,
        twitter = :twitter,
        linkedin = :linkedin,
        instagram = :instagram,
        google_plus = :google_plus,
        youtube = :youtube,
        pinterest = :pinterest,
        vimeo = :vimeo,
        photo = :photo
    WHERE id = :id
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
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
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
<<<<<<< HEAD
            ':id' => $_GET['id']
        ];

        if ($imagePath !== null) {
            $params[':photo'] = $imagePath;
        }

        $stmt->execute($params);

        header("Location: user-list.php");
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
=======
            ':photo' => $imagePath
        ]);

        header("Location: user-list.php"); // redirect after success
        exit();
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage(); // debugging only
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
    }
}
?>



<<<<<<< HEAD
=======

>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
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
                                    <h2 class="breadcrumb_title">User/agent Edit</h2>
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
                                                                value="<?= htmlspecialchars($user['username'] ?? '') ?>"
                                                                require>
=======
                                                            <input type="text" name="username" class="form-control" value="<?= htmlspecialchars($user['username'] ?? '') ?>" require>
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-xl-4">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleEmail">Email</label>
<<<<<<< HEAD
                                                            <input type="email" class="form-control" name="email"
                                                                value="<?= htmlspecialchars($user['email'] ?? '') ?>"
                                                                require>
=======
                                                            <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" require>
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-xl-4">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleInput3">First Name</label>
<<<<<<< HEAD
                                                            <input type="text" class="form-control" name="first_name"
                                                                value="<?= htmlspecialchars($user['first_name']); ?>">
=======
                                                            <input type="text" class="form-control" name="first_name" value="<?= htmlspecialchars($user['first_name']); ?>">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-xl-4">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleInput4">Last Name</label>
<<<<<<< HEAD
                                                            <input type="text" class="form-control" name="last_name"
                                                                value="<?= htmlspecialchars($user['last_name']); ?>">
=======
                                                            <input type="text" class="form-control" name="last_name" value="<?= htmlspecialchars($user['last_name']); ?>">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-xl-4">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleInput5">Position</label>
<<<<<<< HEAD
                                                            <input type="text" class="form-control" name="position"
                                                                value="<?= htmlspecialchars($user['position']); ?>">
=======
                                                            <input type="text" class="form-control" name="position" value="<?= htmlspecialchars($user['position']); ?>">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-xl-4">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleInput6">License</label>
<<<<<<< HEAD
                                                            <input type="text" class="form-control" name="license"
                                                                value="<?= htmlspecialchars($user['license']); ?>">
=======
                                                            <input type="text" class="form-control" name="license" value="<?= htmlspecialchars($user['license']); ?>">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-xl-4">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleInput7">Tax Number</label>
<<<<<<< HEAD
                                                            <input type="text" class="form-control" name="tax_number"
                                                                value="<?= htmlspecialchars($user['tax_number']); ?>">
=======
                                                            <input type="text" class="form-control" name="tax_number" value="<?= htmlspecialchars($user['tax_number']); ?>">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-xl-4">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleInput8">Phone</label>
<<<<<<< HEAD
                                                            <input type="tel" class="form-control" name="phone"
                                                                value="<?= htmlspecialchars($user['phone']); ?>">
=======
                                                            <input type="tel" class="form-control" name="phone" value="<?= htmlspecialchars($user['phone']); ?>">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-xl-4">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleInput9">Fax Number</label>
<<<<<<< HEAD
                                                            <input type="text" class="form-control" name="fax_number"
                                                                value="<?= htmlspecialchars($user['fax_number']); ?>">
=======
                                                            <input type="text" class="form-control" name="fax_number" value="<?= htmlspecialchars($user['fax_number']); ?>">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-xl-4">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleInput10">Mobile</label>
<<<<<<< HEAD
                                                            <input type="tel" class="form-control" name="mobile"
                                                                value="<?= htmlspecialchars($user['mobile']); ?>">
=======
                                                            <input type="tel" class="form-control" name="mobile" value="<?= htmlspecialchars($user['mobile']); ?>">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-xl-4">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleInput11">Language</label>
<<<<<<< HEAD
                                                            <input type="text" class="form-control" name="language"
                                                                value="<?= htmlspecialchars($user['language']); ?>">
=======
                                                            <input type="text" class="form-control" name="language" value="<?= htmlspecialchars($user['language']); ?>">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-xl-4">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleInput12">Company Name</label>
<<<<<<< HEAD
                                                            <input type="text" class="form-control" name="company_name"
                                                                value="<?= htmlspecialchars($user['company_name']); ?>">
=======
                                                            <input type="text" class="form-control" name="company_name" value="<?= htmlspecialchars($user['company_name']); ?>">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleInput13">Address</label>
<<<<<<< HEAD
                                                            <input type="text" class="form-control" name="address"
                                                                value="<?= htmlspecialchars($user['address']); ?>">
=======
                                                            <input type="text" class="form-control" name="address" value="<?= htmlspecialchars($user['address']); ?>">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="my_profile_setting_textarea">
                                                            <label for="exampleFormControlTextarea1">About me</label>
                                                            <textarea class="form-control" name="about_me"
                                                                rows="7"><?= htmlspecialchars($user['about_me']); ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="col-xl-12">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleWebsite">Website</label>
<<<<<<< HEAD
                                                            <input type="url" class="form-control" name="website"
                                                                value="<?= htmlspecialchars($user['website']); ?>">
=======
                                                            <input type="url" class="form-control" name="website" value="<?= htmlspecialchars($user['website']); ?>">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-xl-4">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleSkype">Skype</label>
<<<<<<< HEAD
                                                            <input type="text" class="form-control" name="skype"
                                                                value="<?= htmlspecialchars($user['skype']); ?>">
=======
                                                            <input type="text" class="form-control" name="skype" value="<?= htmlspecialchars($user['skype']); ?>">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-4 col-xl-4">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleFaceBook">Facebook</label>
<<<<<<< HEAD
                                                            <input type="url" class="form-control" name="facebook"
                                                                value="<?= htmlspecialchars($user['facebook']); ?>">
=======
                                                            <input type="url" class="form-control" name="facebook" value="<?= htmlspecialchars($user['facebook']); ?>">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-xl-4">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleTwitter">Twitter</label>
<<<<<<< HEAD
                                                            <input type="url" class="form-control" name="twitter"
                                                                value="<?= htmlspecialchars($user['twitter']); ?>">
=======
                                                            <input type="url" class="form-control" name="twitter" value="<?= htmlspecialchars($user['twitter']); ?>">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-xl-4">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleLinkedin">Linkedin</label>
<<<<<<< HEAD
                                                            <input type="url" class="form-control" name="linkedin"
                                                                value="<?= htmlspecialchars($user['linkedin']); ?>">
=======
                                                            <input type="url" class="form-control" name="linkedin" value="<?= htmlspecialchars($user['linkedin']); ?>">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-xl-4">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleInstagram">Instagram</label>
<<<<<<< HEAD
                                                            <input type="url" class="form-control" name="instagram"
                                                                value="<?= htmlspecialchars($user['instagram']); ?>">
=======
                                                            <input type="url" class="form-control" name="instagram" value="<?= htmlspecialchars($user['instagram']); ?>">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-xl-4">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleGooglePlus">Google Plus</label>
<<<<<<< HEAD
                                                            <input type="url" class="form-control" name="google_plus"
                                                                value="<?= htmlspecialchars($user['google_plus']); ?>">
=======
                                                            <input type="url" class="form-control" name="google_plus" value="<?= htmlspecialchars($user['google_plus']); ?>">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-xl-4">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleYoutube">Youtube</label>
<<<<<<< HEAD
                                                            <input type="url" class="form-control" name="youtube"
                                                                value="<?= htmlspecialchars($user['youtube']); ?>">
=======
                                                            <input type="url" class="form-control" name="youtube" value="<?= htmlspecialchars($user['youtube']); ?>">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-xl-4">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExamplePinterest">Pinterest</label>
<<<<<<< HEAD
                                                            <input type="url" class="form-control" name="pinterest"
                                                                value="<?= htmlspecialchars($user['pinterest']); ?>">
=======
                                                            <input type="url" class="form-control" name="pinterest" value="<?= htmlspecialchars($user['pinterest']); ?>">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4 col-xl-4">
                                                        <div class="my_profile_setting_input form-group">
                                                            <label for="formGroupExampleVimeo">Vimeo</label>
<<<<<<< HEAD
                                                            <input type="url" class="form-control" name="vimeo"
                                                                value="<?= htmlspecialchars($user['vimeo']); ?>">
=======
                                                            <input type="url" class="form-control" name="vimeo" value="<?= htmlspecialchars($user['vimeo']); ?>">
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="wrap-custom-file">
<<<<<<< HEAD
                                                            <input type="file" name="image" id="image"
                                                                accept=".gif, .jpg, .jpeg, .png">
                                                            <label for="image" <?php if (!empty($user['photo'])): ?>
                                                                    style="background-image: url('<?php echo '../../' . $user['photo']; ?>');"
                                                                <?php endif; ?>>
                                                                <span><i class="flaticon-download"></i> Upload Photo
                                                                </span>
=======
                                                            <input type="file" name="image" id="image" accept=".gif, .jpg, .jpeg, .png">
                                                            <label for="image" <?php if (!empty($user['photo'])): ?>
                                                                style="background-image: url('<?php echo '../../' . $user['photo']; ?>');"
                                                                <?php endif; ?>>
                                                                <span><i class="flaticon-download"></i> Upload Photo </span>
>>>>>>> 410f9ed0f0c7bac4540d6ad97ac55dc69cea551a
                                                            </label>
                                                        </div>
                                                        <p>*minimum 260px x 260px</p>
                                                    </div>
                                                    <div class="col-xl-12 text-right">
                                                        <div class="my_profile_setting_input">
                                                            <button class="btn btn2">Edit User/Agent</button>
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