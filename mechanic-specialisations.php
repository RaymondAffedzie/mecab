<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
session_start();
// Error handler 
function errorHandler($errno, $errstr, $errfile, $errline)
{
    $eventDate = date("Y-M-d H:i:s");
    $message = "[$eventDate] - Error: [$errno] $errstr - $errfile:$errline";
    error_log($message . PHP_EOL, 3, "error-log.txt");
}

set_error_handler("errorHandler");

require_once 'controllers/storeController.php';
$controller = new storeController();
include_once('includes/head.php');
include_once('includes/navbar.php');

if (isset($_GET['specialisation'])) {
    $specialisation =  filter_input(INPUT_GET, 'specialisation', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $query = "SELECT m.specialisation_id, s.specialisation, s.description, s.image, u.first_name, u.other_names, u.last_name, u.users_email, c.users_contact, st.store_location, st.store_town, st.gps_address, st.street_name
                FROM specialisation s
                INNER JOIN mechanic_specialisation m ON s.specialisation_id = m.specialisation_id
                INNER JOIN users u ON m.users_id = u.user_id
                INNER JOIN users_contact c ON u.user_id = c.users_id
                INNER JOIN users_store us ON us.users_id = u.user_id
                INNER JOIN stores st ON st.store_id = us.store_id
                WHERE s.specialisation_id = :specialisation;";

    $params = array(':specialisation' => $specialisation);
    $specialisations = $controller->getRecordsByValue($query, $params);
}
?>

<!--Page Title-->
<div class="page section-header text-center">
    <div class="page-title">
        <div class="wrapper">
            <h1 class="page-width">
                <?php
                if (!empty($specialisations)) {
                    $firstRecord = $specialisations[0];
                    echo $firstRecord['specialisation'];
                }
                ?>
            </h1>
        </div>
    </div>
</div>
<!--End Page Title-->

<div class="container">
    <div class="row">
        <!--Main Content-->
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 main-col shop-grid-6">
            <div class="productList">
                <div class="list-view-items grid--view-items">
                    <?php
                    foreach ($specialisations as $data) {
                    ?>
                        <!--ListView Item-->
                        <div class="list-product list-view-item">
                            <div class="list-view-item__image-column">
                                <div class="list-view-item__image-wrapper">
                                    <!-- Image -->
                                    <a href=""><img class="list-view-item__image blur-up lazyload" data-src="uploads/<?= $data['image']; ?>" src="uploads/<?= $data['image']; ?>" alt="<?= $data['specialisation']; ?>" title="<?= $data['specialisation']; ?>" height="auto" width="100%"></a>
                                    <!-- End Image -->
                                </div>
                            </div>
                            <div class="list-view-item__title-column">
                                <div class="h4 grid-view-item__title"><a href=""><?= $data['specialisation']; ?> | <?= $data['store_town']; ?> | <?= $data['store_location']; ?> | <?= $data['gps_address'] ?> </a></div>
                                <!-- Product Review -->
                                <p class="product-review"><i class="font-13 fa fa-star"></i><i class="font-13 fa fa-star"></i><i class="font-13 fa fa-star"></i><i class="font-13 fa fa-star-o"></i><i class="font-13 fa fa-star-o"></i></p>
                                <!-- End Product Review -->
                                <!-- Sort Description -->
                                <p><?= $data['description']; ?> <br> <?= $data['users_contact']; ?> | <?= $data['users_email']; ?> </p>
                                <!-- End Sort Description -->
                                
                                    <a href="" class="btn btn--small">View Services</a>
                                
                            </div>
                        </div>
                        <!--End ListView Item-->
                    <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <!--End Main Content-->
    </div>
</div>

<?php
include_once('includes/footer.php')
?>