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

if (isset($_GET['service'])) {
    $service =  filter_input(INPUT_GET, 'service', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $query = "SELECT  c.*, s.* FROM categories c 
              INNER JOIN spare_parts s ON c.service_id = s.service_id 
              WHERE s.service_id = :service ";

    $params = array(':service' => $service);
    $services = $controller->getRecordsByValue($query, $params);
}
?>

<div class="container">
    <div class="row">
        <!--Main Content-->
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 main-col shop-grid-6">
            <div class="productList">
                <div class="grid-products grid--view-items">
                    <div class="row py-3">
                        <div class="col-6 col-sm-6 col-md-4 col-lg-2 item">
                            <!-- start product image -->
                            <div class="product-image">
                                <!-- start product image -->
                                <a href="#">
                                    <!-- image -->
                                    <img class="primary blur-up lazyload" data-src="uploads/64f9e7975e57f_wallpaperflare.com_wallpaper.jpg" src="uploads/64f9e7975e57f_wallpaperflare.com_wallpaper.jpg" alt="image" title="product">
                                    <!-- End image -->
                                    <!-- Hover image -->
                                    <img class="hover blur-up lazyload" data-src="uploads/64f9e7975e57f_wallpaperflare.com_wallpaper.jpg" src="uploads/64f9e7975e57f_wallpaperflare.com_wallpaper.jpg" alt="image" title="product">
                                    <!-- End hover image -->
                                </a>
                                <!-- end product image -->
                                <!-- Start product button -->
                                <form class="variants add" action="#" onclick="window.location.href='cart.html'" method="post">
                                    <button class="btn btn-addto-cart" type="button">Add To Cart</button>
                                </form>
                                <div class="button-set">
                                    <a href="javascript:void(0)" title="Quick View" class="quick-view-popup quick-view" data-toggle="modal" data-target="#content_quickview">
                                        <i class="icon anm anm-search-plus-r"></i>
                                    </a>
                                    <div class="wishlist-btn">
                                        <a class="wishlist add-to-wishlist" href="#" title="Add to Wishlist">
                                            <i class="icon anm anm-heart-l"></i>
                                        </a>
                                    </div>
                                    <div class="compare-btn">
                                        <a class="compare add-to-compare" href="compare.html" title="Add to Compare">
                                            <i class="icon anm anm-random-r"></i>
                                        </a>
                                    </div>
                                </div>
                                <!-- end product button -->
                            </div>
                            <!-- end product image -->

                            <!--start product details -->
                            <div class="product-details text-center">
                                <!-- product name -->
                                <div class="product-name">
                                    <a href="#">Zipper Jacket</a>
                                </div>
                                <!-- End product name -->
                                <!-- product price -->
                                <div class="product-price">
                                    <span class="price">$788.00</span>
                                </div>
                                <!-- End product price -->

                                <div class="product-review">
                                    <i class="font-13 fa fa-star"></i>++
                                    <i class="font-13 fa fa-star"></i>
                                    <i class="font-13 fa fa-star"></i>
                                    <i class="font-13 fa fa-star-o"></i>
                                    <i class="font-13 fa fa-star-o"></i>
                                </div>
                            </div>
                            <!-- End product details -->
                        </div>
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