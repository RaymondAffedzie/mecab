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

$query = "SELECT * FROM carousel ORDER BY carousel_ID DESC LIMIT 3";
$carousels = $controller->getRecords($query);
?>
<div class="carousel-container">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
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
<div class="collection-box fadeIn section">
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
            $query = "SELECT c.category_id, c.category_name, c.image, COUNT(s.category_id) AS top_category_count
                        FROM categories c
                        JOIN spare_parts s ON c.category_id = s.category_id
                        GROUP BY c.category_id, c.category_name
                        ORDER BY top_category_count DESC LIMIT 10;";

            $data = $controller->getRecords($query);

            if (!empty($data)) {
                foreach ($data as $item) {
                    $categoryId = $item['category_id'];
                    $categoryImage = $item['image'];
                    $categoryName = $item['category_name'];
            ?>
                    <a href="category-spare-parts.php?category=<?= $categoryId; ?>">
                        <figure class="figure">
                            <img src="uploads/<?= $categoryImage; ?>" class="figure-img img-fluid rounded-0" alt="Image" style="height: 220px; width: auto;">
                            <figcaption class="figure-caption text-center"><?= $categoryName; ?></figcaption>
                        </figure>
                    </a>
            <?php
                }
            } else {
                echo "No top categories found.";
            }
            ?>
            <!-- END CODE FOR FETCHING SPARE PARTS CATEGORIES -->
        </div>
    </div>
</div>
<!--End Collection Box slider-->


<?php
include_once('includes/footer.php')
?>