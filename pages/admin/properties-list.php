<?php
session_start();
include("../../include/db_connect.php");

if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    header("Location: ../login.php");
    exit();
}

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

$limit = 5;
$page = isset($_GET['page']) ? max((int)$_GET['page'], 1) : 1;
$start = ($page - 1) * $limit;

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$params = [];
$where_clauses = [];

if (!empty($search)) {
    $where_clauses[] = "(p.title LIKE ? OR p.type LIKE ? OR p.price LIKE ?)";
    $params = array_merge($params, ["%$search%", "%$search%", "%$search%"]);
}

if ($role === 'agent') {
    $where_clauses[] = "p.user_id = ?";
    $params[] = $user_id;
}

$where_sql = '';
if (!empty($where_clauses)) {
    $where_sql = 'WHERE ' . implode(' AND ', $where_clauses);
}

// Count query
$count_sql = "SELECT COUNT(*) FROM properties p $where_sql";
$stmt = $conn->prepare($count_sql);
$stmt->execute($params);
$total_properties = $stmt->fetchColumn();
$total_pages = ceil($total_properties / $limit);

// Data fetch query
$data_sql = "SELECT p.*,
                (SELECT image_path FROM property_images WHERE property_id = p.id ORDER BY id ASC LIMIT 1) AS image_path 
            FROM properties p 
            $where_sql 
            ORDER BY p.id DESC 
            LIMIT $start, $limit";

$stmt = $conn->prepare($data_sql);
$stmt->execute($params);
$properties = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Handle delete
if (isset($_GET['delete_id']) && is_numeric($_GET['delete_id'])) {
    $deleteId = (int)$_GET['delete_id'];

    if ($role === 'agent') {
        $stmt = $conn->prepare("DELETE FROM properties WHERE id = ? AND user_id = ?");
        $stmt->execute([$deleteId, $user_id]);
    } else {
        $stmt = $conn->prepare("DELETE FROM properties WHERE id = ?");
        $stmt->execute([$deleteId]);
    }

    header("Location: properties-list.php");
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
    <link rel="stylesheet" href="../../css/style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <title>Property List Page</title>
</head>

<body>
    <div class="wrapper">

        <!--	Header start  -->
        <?php include "../../include/admin/header.php"; ?>
        <!--	Header end  -->

        <section class="our-dashbord dashbord bgc-f7 pb50">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12 col-lg-12 col-xl-12 maxw100flex-992">
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
                                            <li class="active"><a href="page-my-properties.html"><span
                                                        class="flaticon-home"></span> My Properties</a></li>
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
                                            <li><a href="page-add-new-property.html"><span
                                                        class="flaticon-filter-results-button"></span> Add New
                                                    Listing</a></li>
                                            <li><a href="page-login.html"><span class="flaticon-logout"></span>
                                                    Logout</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4 col-xl-4 mb10">
                                <div class="breadcrumb_content style2 mb30-991">
                                    <h2 class="breadcrumb_title">My Properties</h2>
                                    <p>We are glad to see you again!</p>
                                </div>
                            </div>
                            <div class="col-lg-8 col-xl-8">
                                <div class="candidate_revew_select style2 text-right mb30-991">
                                    <ul class="mb0">
                                        <li class="list-inline-item">
                                            <div class="candidate_revew_search_box course fn-520">
                                                <form method="GET" class="form-inline my-2">
                                                    <input class="form-control mr-sm-2" type="search" name="search"
                                                        value="<?= htmlspecialchars($search ?? '') ?>" placeholder="Search" aria-label="Search">
                                                    <button class="btn my-2 my-sm-0" type="submit"><span
                                                            class="flaticon-magnifying-glass"></span></button>
                                                </form>
                                            </div>
                                        </li>
                                        <li class="list-inline-item view_add_list" title="Add">
                                            <a href="../../pages/admin/properties-add.php"><span class="flaticon-plus"></span></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="my_dashboard_review mb40">
                                    <div class="property_table">
                                        <div class="table-responsive mt0">
                                            <table class="table">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th scope="col">Listing Title</th>
                                                        <th scope="col">Property Type</th>
                                                        <th scope="col">City</th>
                                                        <th scope="col">Date published</th>
                                                        <th scope="col">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    foreach ($properties as $property):
                                                    ?>
                                                        <tr>
                                                            <th scope="row">
                                                                <div class="feat_property list favorite_page style2">
                                                                    <div class="thumb">
                                                                        <img class="img-whp"
                                                                            src="<?= !empty($property['image_path']) ? '../../' . $property['image_path'] : '../../images/default-list.jpg'; ?>"
                                                                            alt="<?= htmlspecialchars($property['title']) ?>">
                                                                        <div class="thmb_cntnt">
                                                                            <ul class="tag mb0">
                                                                                <li class="list-inline-item dn"></li>
                                                                                <li class="list-inline-item"><a href="#">For
                                                                                        <?= htmlspecialchars($property['status']) ?></a></li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                    <div class="details">
                                                                        <div class="tc_content">
                                                                            <h4><?= htmlspecialchars($property['title']) ?></h4>
                                                                            <p><span class="flaticon-placeholder"></span><?= htmlspecialchars($property['address']) ?></p>
                                                                            <a class="fp_price text-thm" href="#">$<?= number_format((float)$property['price'], 0) ?><small>/mo</small></a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </th>
                                                            <td><?= htmlspecialchars($property['type']) ?></td>
                                                            <td><?= htmlspecialchars($property['city']) ?></td>
                                                            <td><?= isset($property['created_at']) ? date("d M, Y", strtotime($property['created_at'])) : 'N/A' ?></td>
                                                            <td>
                                                                <ul class="view_edit_delete_list mb0">
                                                                    <li class="list-inline-item" title="Edit">
                                                                        <a href="properties-edit.php?id=<?= $property['id'] ?>"><span class="flaticon-edit"></span></a>
                                                                    </li>
                                                                    <li class="list-inline-item" data-toggle="tooltip" title="Delete">
                                                                        <a href="properties-list.php?delete_id=<?= $property['id']; ?>" onclick="return confirmDelete();">
                                                                            <span class="flaticon-garbage"></span>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                    <?php if (empty($properties)): ?>
                                                        <tr>
                                                            <td colspan="5" class="text-center text-danger">No properties found.</td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="mbp_pagination">
                                            <ul class="page_navigation">
                                                <?php if ($page > 1): ?>
                                                    <li class="page-item">
                                                        <a class="page-link" href="?page=<?= $page - 1 ?>&search=<?= urlencode($search) ?>"><span class="flaticon-left-arrow"></span> Prev</a>
                                                    </li>
                                                <?php endif; ?>

                                                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                                                        <a class="page-link" href="?page=<?= $i ?>&search=<?= urlencode($search) ?>"><?= $i ?></a>
                                                    </li>
                                                <?php endfor; ?>

                                                <?php if ($page < $total_pages): ?>
                                                    <li class="page-item">
                                                        <a class="page-link" href="?page=<?= $page + 1 ?>&search=<?= urlencode($search) ?>"><span class="flaticon-right-arrow"></span></a>
                                                    </li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt10">
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
    <script>
        function confirmDelete() {
            return confirm('Are you sure you want to delete this Properties?');
        }
    </script>
    <script src="https://code.jquery.com/jquery-migrate-3.0.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="../../Js/jquery.mmenu.all.js"></script>
    <script type="text/javascript" src="../../js/bootstrap-select.min.js"></script>

</body>

</html>