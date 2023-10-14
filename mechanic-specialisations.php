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
    $query = "SELECT s.specialisation, s.description, s.image, u.user_id, u.first_name, u.other_names, u.last_name, u.users_email, c.users_contact, st.store_location, st.store_town
                FROM mechanic_specialisation m
                INNER JOIN specialisation s ON s.specialisation_id = m.specialisation_id
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
        <?php
        foreach ($specialisations as $data) {
        ?>
            <div class="col-md-5">
                <div class="card bg-dark text-white">
                    <img src="uploads/<?= $data['image']; ?>" class="card-img" alt="...">
                    <div class="card-img-overlay">
                        <h1 class="card-title h1 text-white"><?=$data['store_town'] .' | '.  $data['store_location']; ?></h1>
                        <h3 class="card-text h3 text-white"><?= $data['users_contact'] .' | '. $data['first_name'] .' '. $data['other_names'] .' '. $data['last_name'].' | '. $data['specialisation']; ?></h3>
                        <em class="card-text text-warning"><?= $data['users_email']; ?></em>
                        <i class="card-text text-white"><?= $data['description'] ;?></i>
                        <a href="mechanic-services.php?service=<?= $data['user_id'];?>" class="card-link text-warning float-right pb-3">View Servies</a>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>

        <!--End Main Content-->
    </div>
</div>

<?php
include_once('includes/footer.php')
?>