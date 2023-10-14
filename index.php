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

$query = "SELECT * FROM carousel ORDER BY carousel_ID DESC LIMIT 4";
$carousels = $controller->getRecords($query);
?>
<div class="carousel-container">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <?php
            foreach ($carousels as $key => $value) {
            ?>
                <li data-target="#carouselExampleIndicators" data-slide-to="<?= $key ?>" class="<?= ($key === 0) ? 'active' : ''; ?>"></li>
            <?php
            }
            ?>
        </ol>
        <div class="carousel-inner">
            <?php foreach ($carousels as $key => $carouselData) { ?>
                <div class="carousel-item <?= ($key === 0) ? 'active' : ''; ?>">
                    <img class="d-block w-100" src="uploads/<?= $carouselData['image']; ?>" alt="uploads/<?= $carouselData['image']; ?>">
                    <div class="carousel-caption">
                        <p class="fst-italic text-white" style="font-size: 20px"><?= $carouselData['carousel_caption']; ?></p>
                    </div>
                </div>
            <?php } ?>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</div>

<!--Collection Box slider-->
<div v class="collection-box fadeIn section mt-5">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                <div class="section-header text-center">
                    <h2 class="h2">What are you looking for?</h2>
                    <p>Solutions for a better driving experience</p>
                </div>
            </div>
        </div>
        <div class="collection-grid-4item">
            <!-- PHP CODE FOR FETCHING SPARE PARTS CATEGORIES -->
            <?php
            $query = "SELECT category_id, category_name, `image` FROM categories";
            $data = $controller->getRecords($query);
            foreach ($data as $item) {
            ?>
                <div class="collection-grid-item">
                    <a href="category-spare-parts.php?category=<?= $item['category_id']; ?>" class="collection-grid-item__link">
                        <img data-src="uploads/<?= $item['image']; ?>" src="uploads/<?= $item['image']; ?>" alt="<?= $item['category_name']; ?>" class="blur-up lazyload" height="220px"/>
                        <div class="collection-grid-item__title-wrapper">
                            <h3 class="collection-grid-item__title btn btn--secondary no-border"><?= $item['category_name']; ?></h3>
                        </div>
                    </a>
                </div>
            <?php } ?>
            <!-- END CODE FOR FETCHING SPARE PARTS CATEGORIES -->
        </div>
    </div>
</div>
<!--End Collection Box slider-->


<?php
include_once('includes/footer.php')
?>