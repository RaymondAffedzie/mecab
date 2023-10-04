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

$query = "SELECT * FROM `specialisation` ORDER BY `specialisation` ASC";
$data = $controller->getRecords($query);
?>

<!--Page Title-->
<div class="page section-header text-center">
    <div class="page-title">
        <div class="wrapper">
            <h1 class="page-width">Mechanics</h1>
        </div>
    </div>
</div>
<!--End Page Title-->

<div class="container collection-box">
    <div class="row">
        <?php
        if (!empty($data)) {
            foreach ($data as $specialisation) {
                $specialisationId = $specialisation['specialisation_id'];
                $specialisationImage = $specialisation['image'];
                $specialisationName = $specialisation['specialisation'];
        ?>
                <div class="col-6 col-sm-6 col-md-3 col-lg-3">
                    <div class="colletion-item">
                        <a href="mechanic-specialisations.php?specialisation=<?= $specialisationId; ?>">
                            <img class="blur-up lazyload" data-src="uploads/<?= $specialisationImage; ?>" src="uploads/<?= $specialisationImage; ?>" alt="<?= $specialisationName; ?>" title="">
                            <span class="title">
                                <span><?= $specialisationName; ?></span>
                            </span>
                        </a>
                    </div>
                </div>
            <?php
            }
        } else {
            ?>
            <div class="page section-header text-center">
                <div class="page-title">
                    <div class="wrapper">
                        <h1 class="page-width">No specialisations found</h1>
                    </div>
                </div>
            </div>
        <?php
        }
        ?>
    </div>
</div>

<?php
include_once('includes/footer.php')
?>