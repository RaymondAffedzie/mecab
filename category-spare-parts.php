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

if (isset($_GET['category'])) {
    $category =  filter_input(INPUT_GET, 'category', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $query = "SELECT  c.*, s.* FROM categories c 
              INNER JOIN spare_parts s ON c.category_id = s.category_id 
              WHERE s.category_id = :category ";

    $params = array(':category' => $category);
    $categorySpareParts = $controller->getRecordsByValue($query, $params);

?>

    <div class="container">
        <div class="row">
            <!--Sidebar-->
            <div class="col-12 col-sm-12 col-md-3 col-lg-3 sidebar filterbar">
                <div class="closeFilter d-block d-md-none"><i class="mdi mdi-times"></i></div>
                <div class="sidebar_tags">
                    <div class="sidebar_widget categories filter-widget">
                        <div class="widget-title">
                            <h2>Categories</h2>
                        </div>
                        <div class="widget-content">
                            <ul class="sidebar_categories">
                                <!-- PHP CODE FOR FETCHING SPARE PARTS CATEGORIES -->
                                <?php
                                $query = "SELECT category_id, category_name FROM categories ORDER BY category_name ASC;";

                                $data = $controller->getRecords($query);

                                if (!empty($data)) {
                                    foreach ($data as $category) {
                                        $categoryId = $category['category_id'];
                                        $categoryImage = $category['image'];
                                        $categoryName = $category['category_name'];
                                ?>
                                        <li class="lvl-1"><a href="category-spare-parts.php?category=<?= $categoryId; ?>" class="site-nav"><?= $categoryName ?></a></li>
                                <?php }
                                } ?>
                            </ul>
                        </div>
                    </div>
                    <!--Price Filter-->
                    <div class="sidebar_widget filterBox filter-widget">
                        <div class="widget-title">
                            <h2>Price</h2>
                        </div>
                        <form action="#" method="post" class="price-filter">
                            <div id="slider-range" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all">
                                <div class="ui-slider-range ui-widget-header ui-corner-all"></div>
                                <span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0"></span>
                                <span class="ui-slider-handle ui-state-default ui-corner-all" tabindex="0"></span>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <p class="no-margin"><input id="amount" type="text"></p>
                                </div>
                                <div class="col-6 text-right margin-25px-top">
                                    <button class="btn btn-secondary btn--small">filter</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!--End Price Filter-->

                    <!--Popular Products-->
                    <div class="sidebar_widget">
                        <div class="widget-title">
                            <h2>Popular Products</h2>
                        </div>
                        <div class="widget-content">
                            <div class="list list-sidebar-products">
                                <div class="grid">
                                    <div class="grid__item">
                                        <div class="mini-list-item">
                                            <div class="mini-view_image">
                                                <a class="grid-view-item__link" href="#">
                                                    <img class="grid-view-item__image" src="assets/images/product-images/mini-product-img.jpg" alt="" />
                                                </a>
                                            </div>
                                            <div class="details"> <a class="grid-view-item__title" href="#">Cena Skirt</a>
                                                <div class="grid-view-item__meta"><span class="product-price__price"><span class="money">$173.60</span></span></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End Popular Products-->

                </div>
            </div>
            <!--End Sidebar-->

            <!--Main Content-->
            <div class="col-12 col-sm-12 col-md-9 col-lg-9 main-col shop-grid-5">
                <div class="productList">
                    <div class="category-description">
                        <?php
                        if (!empty($categorySpareParts)) {
                            // Fetch only the category name
                            $firstRecord = $categorySpareParts[0];
                            // display category name
                            echo '<h1 class="text-center pt-5">' . $firstRecord['category_name'] . '</h1>';
                        }
                        ?>
                    </div>
                    <hr>

                    <div class="grid-products grid--view-items">
                        <div class="row">
                            <?php
                            if (!empty($categorySpareParts)) {
                                foreach ($categorySpareParts as $item) {
                            ?>
                                    <div class="col-6 col-sm-6 col-md-4 col-lg-2 item">
                                        <div class="product-image">
                                            <a href="spare-part-product.php?product=<?= $item['sparepart_id']; ?>">
                                                <img class="primary blur-up lazyload" data-src="uploads/<?= $item['image']; ?>" src="uploads/<?= $item['image']; ?>" alt="image" title="<?= $item['name']; ?>" style="max-height: 176px; min-height: 176px;">
                                                <img class="hover blur-up lazyload" data-src="uploads/<?= $item['image']; ?>" src="uploads/<?= $item['image']; ?>" alt="<?= $item['name']; ?>" title="<?= $item['name']; ?>" style="max-height: 170px; min-height: 170px;">
                                            </a>
                                            <a href="spare-part-product.php?product=<?= $item['sparepart_id']; ?>" class="variants add btn btn-addto-cart">View Product</a>
                                        </div>
                                        <div class="product-details text-center">
                                            <div class="product-name">
                                                <a href="spare-part-product.php?product=<?= $item['sparepart_id']; ?>"><?= $item['name']; ?></a>
                                            </div>
                                            <div class="product-price">
                                                <span class="price">GHC <?= $item['price']; ?></span>
                                            </div>
                                            <div class="product-review">
                                                <i class="font-13 fa fa-star"></i>
                                                <i class="font-13 fa fa-star"></i>
                                                <i class="font-13 fa fa-star"></i>
                                                <i class="font-13 fa fa-star-o"></i>
                                                <i class="font-13 fa fa-star-o"></i>
                                            </div>
                                        </div>
                                    </div>
                        <?php
                                }
                            } else {
                                echo '<h1>No Records Found For this category</h1>';
                            }
                        }

                        ?>
                        </div>
                    </div>
                </div>
            </div>
            <!--End Main Content-->
        </div>
    </div>

    <?php
    include_once('includes/footer.php')
    ?>