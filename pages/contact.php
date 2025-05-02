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
    <title>Contact Us Page</title>
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
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Contact</li>
                            </ol>
                            <h4 class="breadcrumb_title">Contact Us</h4>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="our-contact pb0 bgc-f7">
            <div class="container">
                <div class="row">
                    <div class="col-lg-7 col-xl-8">
                        <div class="form_grid">
                            <h4 class="mb5">Send Us An Email</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In gravida quis libero eleifend
                                ornare.
                                Maecenas mattis enim at arcu feugiat, sit amet blandit nisl iaculis. Donec lacus odio,
                                malesuada
                                eu libero sit amet, congue aliquam leo. In hac habitasse platea dictumst.</p>
                            <form class="contact_form" id="contact_form" name="contact_form" action="#" method="post"
                                novalidate="novalidate">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input id="form_name" name="form_name" class="form-control"
                                                required="required" type="text" placeholder="Name">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input id="form_email" name="form_email" class="form-control required email"
                                                required="required" type="email" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input id="form_phone" name="form_phone" class="form-control required phone"
                                                required="required" type="phone" placeholder="Phone">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <input id="form_subject" name="form_subject" class="form-control required"
                                                required="required" type="text" placeholder="Subject">
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <textarea id="form_message" name="form_message"
                                                class="form-control required" rows="8" required="required"
                                                placeholder="Your Message"></textarea>
                                        </div>
                                        <div class="form-group mb0">
                                            <button type="button" class="btn btn-lg btn-thm">Send Message</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-5 col-xl-4">
                        <div class="contact_localtion">
                            <h4>Contact Us</h4>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In gravida quis libero eleifend
                                ornare.
                                habitasse platea dictumst.</p>
                            <div class="content_list">
                                <h5>Address</h5>
                                <p>2301 Ravenswood Rd Madison, <br>WI 53711</p>
                            </div>
                            <div class="content_list">
                                <h5>Phone</h5>
                                <p>(315) 905-2321</p>
                            </div>
                            <div class="content_list">
                                <h5>Mail</h5>
                                <p>info@findhouse.com</p>
                            </div>
                            <div class="content_list">
                                <h5>Skype</h5>
                                <p>findhouse.com</p>
                            </div>
                            <h5>Follow Us</h5>
                            <ul class="contact_form_social_area">
                                <li class="list-inline-item"><a href="#"><i class="fa fa-facebook"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="fa fa-twitter"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="fa fa-instagram"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="fa fa-google"></i></a></li>
                                <li class="list-inline-item"><a href="#"><i class="fa fa-pinterest"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container-fluid p0 mt50">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="h600">
                            <iframe title="map" className="gmap_iframe" height="100%"
                                src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d193309.02147838814!2d-74.53513266718751!3d40.79602810000002!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sbd!4v1663993365939!5m2!1sen!2sbd"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Start Partners -->
        <?php include "../pages/component/cta.php"; ?>

        <!--  Footer start  -->
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