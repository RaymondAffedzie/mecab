<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'controllers/storeController.php';
include_once('includes/head.php');
include_once('includes/navbar.php');

$controller = new storeController();

// Error handler 
function errorHandler($errno, $errstr, $errfile, $errline)
{
	$eventDate = date("Y-M-d H:m:s");
	$message = "[$eventDate] - Error: [$errno] $errstr - $errfile:$errline";
	error_log($message . PHP_EOL, 3, "error-log.txt");
}

set_error_handler("errorHandler");
?>		           
            <!--Popular Categories-->
            <div class="section">
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
                                $query = "SELECT c.category_id, c.category_name, COUNT(s.category_id) AS top_category_count
                                            FROM categories c
                                            JOIN spare_parts s ON c.category_id = s.category_id
                                            GROUP BY c.category_id, c.category_name
                                            ORDER BY top_category_count DESC LIMIT 4;";

                                $topCategories = $controller->getRecords($query);

                                if (!empty($topCategories)) {
                                    foreach ($topCategories as $category) {
                                        $categoryId = $category['category_id'];
                                        $categoryName = $category['category_name'];
                            ?>
                                <div class="categories-item">
                                    <a href="category-spare-parts.php?category=<?=$categoryId; ?>" class="thumb"><img class="primary blur-up lazyload" data-src="assets/images/autoparts/categories-img1.jpg" src="assets/images/autoparts/categories-img1.jpg" alt="<?= $categoryName ?>" title="<?= $categoryName ?>"></a>
                                    <h4><a href="category-spare-parts.php?category=<?=$categoryId; ?>"> <?= $categoryName ?> </a></h4>
                                    <a href="category-spare-parts.php?category=<?=$categoryId; ?>" class="btn no-border">Shop now</a>
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

                        <div class="infinitpaginOuter">
                            <div class="infinitpagin">	
                                <a href="#" class="btn loadMore">Load More</a>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <!--End Popular Categories--> 


<?php
include_once('includes/footer.php')
?>