<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
session_start();
// Error handler 
function errorHandler($errno, $errstr, $errfile, $errline)
{
    $eventDate = date("Y-M-d H:m:s");
    $message = "[$eventDate] - Error: [$errno] $errstr - $errfile:$errline";
    error_log($message . PHP_EOL, 3, "error-log.txt");
}

set_error_handler("errorHandler");

require_once 'controllers/storeController.php';
include_once('includes/head.php');
include_once('includes/navbar.php');

$controller = new storeController();
$query = "SELECT * FROM carousel ORDER BY carousel_ID DESC LIMIT 3";
$carousels = $controller->getRecords($query);
?>

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

<!--Popular Categories-->
<div class="section" hidden>
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                <div class="section-header text-center">
                    <h2 class="h2">Popular Spare part categories</h2>
                    <p>Replacement parts and More...</p>
                </div>
            </div>
        </div>
        <div class="categories-list-items">
            <div class="row">
                <div class="col-12">

                    <!-- PHP CODE FOR FETCHING SPARE PARTS CATEGORIES -->
                    <?php
                    $query = "SELECT c.category_id, c.category_name, c.image, COUNT(s.category_id) AS top_category_count
                                            FROM categories c
                                            JOIN spare_parts s ON c.category_id = s.category_id
                                            GROUP BY c.category_id, c.category_name
                                            ORDER BY top_category_count DESC LIMIT 4;";

                    $data = $controller->getRecords($query);

                    if (!empty($data)) {
                        foreach ($data as $category) {
                            $categoryId = $category['category_id'];
                            $categoryImage = $category['image'];
                            $categoryName = $category['category_name'];
                    ?>
                            <div class="categories-item">
                                <a href="category-spare-parts.php?category=<?= $categoryId; ?>" class="thumb">
                                    <img class="primary blur-up lazyload" data-src="uploads/<?= $categoryImage; ?>" src="uploads/<?= $categoryImage; ?>" alt="<?= $categoryName ?>" title="<?= $categoryName ?>">
                                </a>
                                <h4>
                                    <a href="category-spare-parts.php?category=<?= $categoryId; ?>"> <?= $categoryName ?> </a>
                                </h4>
                                <a href="category-spare-parts.php?category=<?= $categoryId; ?>" class="btn no-border">Shop now</a>
                            </div>
                    <?php
                        }
                    } else {
                        echo "No top categories found.";
                    }
                    ?>
                    <!-- END CODE FOR FETCHING SPARE PARTS CATEGORIES -->
                </div>
            </div>

            <div class="infinitpaginOuter" hidden>
                <div class="infinitpagin">
                    <a href="#" class="btn loadMore">Load More</a>
                </div>
            </div>

        </div>
    </div>
</div>
<!--End Popular Categories-->

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
                    $categoryImage = $category['image'];
                    $categoryName = $item['category_name'];
            ?>
                    <div class="collection-grid-item">
                        <a href="category-spare-parts.php?category=<?= $categoryId; ?>" class="collection-grid-item__link">
                            <img data-src="uploads/<?= $categoryImage; ?>" src="uploads/<?= $categoryImage; ?>" alt="<?= $categoryName; ?>" class="blur-up lazyload" />
                            <div class="collection-grid-item__title-wrapper">
                                <h3 class="collection-grid-item__title btn btn--secondary no-border"><?= $categoryName; ?></h3>
                            </div>
                        </a>
                    </div>
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