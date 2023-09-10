<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);

// Error handler 
function errorHandler($errno, $errstr, $errfile, $errline)
{
	$eventDate = date("Y-M-d H:m:s");
	$message = "[$eventDate] - Error: [$errno] $errstr - $errfile:$errline";
	error_log($message . PHP_EOL, 3, "error-log.txt");
}

set_error_handler("errorHandler");

require_once 'controllers/storeController.php';
$controller = new storeController();
include_once('includes/head.php');
include_once('includes/navbar.php');

if (isset($_GET['product'])) {
    $product =  filter_input(INPUT_GET, 'product', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    $query = "SELECT c.*, s.*, b.*, m.*, st.*
                FROM spare_parts s
                INNER JOIN categories c ON c.category_id = s.category_id
                LEFT JOIN car_brand b ON b.car_brand_id = s.car_brand_id
                LEFT JOIN car_model m ON m.car_model_id = s.car_model_id
                LEFT JOIN stores st ON st.store_id = s.store_id
                WHERE s.sparepart_id = :product
                LIMIT 1";

    $params = array(':product' => $product);
    $record = $controller->getSingleRecordsByValue($query, $params);

    if ($record === null) {

    }    
}

?>		           

       <!--MainContent-->
       <div id="MainContent" class="main-content" role="main">
           <!--#ProductSection-product-template-->
            <div id="ProductSection-product-template" class="product-template__container prstyle2 container pt-5">
                <!--Product-single-->
                <?php
                    if(!empty($record)){
                ?>
                 <div class="product-single product-single-1">
                    <div class="row">
                        <col-lg-12 class="col-md-12 col-sm-12 col-12">
                        </col-lg-12>
                    </div>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="product-details-img product-single__photos bottom">
                                <div class="zoompro-wrap product-zoom-right pl-20">
                                    <div class="zoompro-span">
                                        <img class="blur-up lazyload zoompro" data-zoom-image="uploads/<?=$record['image']; ?>" alt="<?= $record['name']; ?>" src="uploads/<?=$record['image']; ?>" />               
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                            <div class="product-single__meta">
                                <h1 class="product-single__title"><?= $record['name']; ?></h1>
                                <div class="prInfoRow">
                                    <div class="product-sku">Product Category: <span class="variant-sku"><b><?= $record['category_name']; ?></b></span></div>
                                    <div class="product-review">
                                        <a class="reviewLink" href="#tab2">
                                            <i class="font-13 fa fa-star"></i>
                                            <i class="font-13 fa fa-star"></i>
                                            <i class="font-13 fa fa-star"></i>
                                            <i class="font-13 fa fa-star-o"></i>
                                            <i class="font-13 fa fa-star-o"></i>
                                            <span class="spr-badge-caption">6 reviews</span>
                                        </a>
                                    </div>
                                </div>
                                <p class="product-single__price product-single__price-product-template">
                                    <span class="visually-hidden">Regular price</span>
                                    <span class="product-price__price product-price__price-product-template product-price__sale product-price__sale--single">
                                        <span id="ProductPrice-product-template"><span class="money"><?= "GHC ". $record['price']; ?></span></span>
                                    </span>
                                    <!-- Discount badge || for future use -->
                                    <!-- <span class="discount-badge"> <span class="devider">|</span>&nbsp;
                                        <span>You Save</span>
                                        <span id="SaveAmount-product-template" class="product-single__save-amount">
                                        <span class="money">$100.00</span>
                                        </span>
                                        <span class="off">(<span>16</span>%)</span>
                                    </span>  -->
                                </p>

                                <!-- Description -->
                                <div class="product-single__description rte">
                                    <p><?= $record['description']; ?></p>
                                </div>
                                <form method="post" action="" id="product_form_10508262282" class="product-form product-form-product-template hidedropdown"">
                                    <div class="swatch clearfix swatch-0 option1" data-option-index="0">
                                        <div class="product-form__data">
                                            <label class="header">Car Brand: <span class="slVariant"><?= $record['brand_name']; ?></span></label>
                                            <label class="header">Car Model: <span class="slVariant"><?= $record['model_name']; ?></span></label>
                                            
                                        </div>
                                        <div class="form-group">
                                            <input type="text" id="product_id" name="" value="<?= $record['sparepart_id']; ?>" hidden>
                                            <input type="text" id="product_name" name="" value="<?= $record['name']; ?>" hidden>
                                            <input type="text" id="product_price" name="" value="<?= $record['price']; ?>" hidden>
                                            <input type="text" id="product_image" name="" value="<?= $record['image']; ?>" hidden>
                                            <input type="text" id="product_cat_id" name="" value="<?= $record['category_id']; ?>" hidden>
                                            <input type="text" id="product_cat_name" name="" value="<?= $record['category_name']; ?>" hidden>
                                            <input type="text" id="product_brand_id" name="" value="<?= $record['car_brand_id']; ?>" hidden>
                                            <input type="text" id="product_brand_name" name="" value="<?= $record['brand_name']; ?>" hidden>
                                            <input type="text" id="product_model_id" name="" value="<?= $record['car_model_id']; ?>" hidden>
                                            <input type="text" id="product_model_name" name="" value="<?= $record['model_name']; ?>" hidden>
                                            <input type="text" id="product_store_id" name="" value="<?= $record['store_id']; ?>" hidden>
                                            <input type="text" id="product_store_name" name="" value="<?= $record['store_name']; ?>" hidden>
                                        </div>
                                    </div>
                                    <!-- Product Action -->
                                    <div class="product-action clearfix">
                                        <div class="product-form__item--quantity">
                                            <div class="wrapQtyBtn">
                                                <div class="qtyField">
                                                    <a class="qtyBtn minus" href="">
                                                        <i class="fa anm anm-minus-r" aria-hidden="true"></i>
                                                    </a>
                                                    <input type="text" id="Quantity" name="quantity" value="1" class="product-form__input qty quantity-input">
                                                    <a class="qtyBtn plus" href="">
                                                        <i class="fa anm anm-plus-r" aria-hidden="true"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>                                
                                        <div class="product-form__item--submit">
                                            <button type="button" id="addToCartBtn" class="btn product-form__cart-submit">
                                                <span id="AddToCartText-product-template">Add to cart</span>
                                            </button>
                                        </div>
                                    </div>
                                    <!-- End Product Action -->
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="row pt-5">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-12">    
                            <div class="card">
                                <div class="card-header border-0">
                                    <div class="d-flex">
                                        <div class="title pt-3 pb-4">

                                        </div>
                                    </div>
                                    
                                    <!-- START TABS DIV -->
                                    <div class="tabbable-responsive">
                                        <div class="tabbable">
                                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="first-tab" data-toggle="tab" href="#first" role="tab" aria-controls="first" aria-selected="true">PRODUCT DETAILS</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="second-tab" data-toggle="tab" href="#second" role="tab" aria-controls="second" aria-selected="false">PRODUCT REVIEWS</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="third-tab" data-toggle="tab" href="#third" role="tab" aria-controls="third" aria-selected="false">STORE DETAILS</a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="tab-pane fade show active" id="first" role="tabpanel" aria-labelledby="first-tab">
                                            <h5 class="card-title">PRODUCT DETAILS</h5>
                                            <div class="prInfoRow">
                                                <div class="product-sku">Product name: 
                                                    <span class="variant-sku"><b><?= $record['name']; ?></b></span>
                                                </div>
                                                <div class="product-sku">Product Category: 
                                                    <span class="variant-sku"><b><?= $record['category_name']; ?></b></span>
                                                </div>
                                                <div class="product-sku">Product Car Brand: 
                                                    <span class="variant-sku"><b><?= $record['brand_name']; ?></b></span>
                                                </div>
                                                <div class="product-sku">Product Car Model: 
                                                    <span class="variant-sku"><b><?= $record['model_name']; ?></b></span>
                                                </div>
                                            </div>
                                            <div class="row pt-3">
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                                                    <h5 class="card-title">PRODUCT DESCRIPTION</h5>
                                                    <div class="product-single__description rte">
                                                        <p><?= $record['description']; ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="second" role="tabpanel" aria-labelledby="second-tab">
                                            <div id="shopify-product-reviews" hidden>
                                                <div class="spr-container">
                                                    <div class="spr-header clearfix">
                                                        <div class="spr-summary">
                                                            <span class="product-review"><a class="reviewLink"><i class="font-13 fa fa-star"></i><i class="font-13 fa fa-star"></i><i class="font-13 fa fa-star"></i><i class="font-13 fa fa-star-o"></i><i class="font-13 fa fa-star-o"></i> </a><span class="spr-summary-actions-togglereviews">Based on 6 reviews456</span></span>
                                                            <span class="spr-summary-actions">
                                                                <a href="#" class="spr-summary-actions-newreview btn">Write a review</a>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="spr-content">
                                                        <div class="spr-form clearfix">
                                                            <form method="post" action="#" id="new-review-form" class="new-review-form">
                                                                <h3 class="spr-form-title">Write a review</h3>
                                                                <fieldset class="spr-form-contact">
                                                                    <div class="spr-form-contact-name">
                                                                        <label class="spr-form-label" for="review_author_10508262282">Name</label>
                                                                        <input class="spr-form-input spr-form-input-text " id="review_author_10508262282" type="text" name="review[author]" value="" placeholder="Enter your name">
                                                                    </div>
                                                                    <div class="spr-form-contact-email">
                                                                        <label class="spr-form-label" for="review_email_10508262282">Email</label>
                                                                        <input class="spr-form-input spr-form-input-email " id="review_email_10508262282" type="email" name="review[email]" value="" placeholder="john.smith@example.com">
                                                                    </div>
                                                                </fieldset>
                                                                <fieldset class="spr-form-review">
                                                                    <div class="spr-form-review-rating">
                                                                        <label class="spr-form-label">Rating</label>
                                                                        <div class="spr-form-input spr-starrating">
                                                                            <div class="product-review"><a class="reviewLink" href="#"><i class="fa fa-star-o"></i><i class="font-13 fa fa-star-o"></i><i class="font-13 fa fa-star-o"></i><i class="font-13 fa fa-star-o"></i><i class="font-13 fa fa-star-o"></i></a></div>
                                                                        </div>
                                                                    </div>
                                                            
                                                                    <div class="spr-form-review-title">
                                                                        <label class="spr-form-label" for="review_title_10508262282">Review Title</label>
                                                                        <input class="spr-form-input spr-form-input-text " id="review_title_10508262282" type="text" name="review[title]" value="" placeholder="Give your review a title">
                                                                    </div>
                                                            
                                                                    <div class="spr-form-review-body">
                                                                        <label class="spr-form-label" for="review_body_10508262282">Body of Review <span class="spr-form-review-body-charactersremaining">(1500)</span></label>
                                                                        <div class="spr-form-input">
                                                                            <textarea class="spr-form-input spr-form-input-textarea " id="review_body_10508262282" data-product-id="10508262282" name="review[body]" rows="10" placeholder="Write your comments here"></textarea>
                                                                        </div>
                                                                    </div>
                                                                </fieldset>
                                                                <fieldset class="spr-form-actions">
                                                                    <input type="submit" class="spr-button spr-button-primary button button-primary btn btn-primary" value="Submit Review">
                                                                </fieldset>
                                                            </form>
                                                        </div>
                                                        <div class="spr-reviews">
                                                            <div class="spr-review">
                                                                <div class="spr-review-header">
                                                                    <span class="product-review spr-starratings spr-review-header-starratings"><span class="reviewLink"><i class="fa fa-star"></i><i class="font-13 fa fa-star"></i><i class="font-13 fa fa-star"></i><i class="font-13 fa fa-star"></i><i class="font-13 fa fa-star"></i></span></span>
                                                                    <h3 class="spr-review-header-title">Lorem ipsum dolor sit amet</h3>
                                                                    <span class="spr-review-header-byline"><strong>dsacc</strong> on <strong>Apr 09, 2019</strong></span>
                                                                </div>
                                                                <div class="spr-review-content">
                                                                    <p class="spr-review-content-body">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane fade" id="third" role="tabpanel" aria-labelledby="third-tab">
                                            <h5 class="card-title">STORE DETAILS</h5>
                                            <div class="prInfoRow">
                                                <div class="product-sku">Store name: 
                                                    <span class="variant-sku"><b><?= strtoupper($record['store_name']); ?></b></span>
                                                </div>
                                                <div class="product-sku">Store contact: 
                                                    <span class="variant-sku"><b><?= $record['store_contact']; ?></b></span>
                                                </div>
                                                <div class="product-sku">Store email: 
                                                    <span class="variant-sku"><b><?= strtolower($record['store_email']); ?></b></span>
                                                </div>
                                            </div>
                                            <div class="prInfoRow">
                                                <div class="product-sku">Town: 
                                                    <span class="variant-sku"><b><?= strtoupper($record['store_town']); ?></b></span>
                                                </div>
                                                <div class="product-sku">Community: 
                                                    <span class="variant-sku"><b><?= strtoupper($record['store_location']); ?></b></span>
                                                </div>
                                                <div class="product-sku">GPS Address: 
                                                    <span class="variant-sku"><b><?= strtoupper($record['gps_address']) ; ?></b></span>
                                                </div>
                                                <div class="product-sku">Street Name:    
                                                    <span class="variant-sku"><b><?= strtoupper($record['street_name']); ?></b></span>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>      
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--End-product-single-->
                </div>
                <?php
                    } else {
                        echo '<h1 class="text-center pt-5">No Record Found</h1>';
                    }
                ?>
               
                <!--#ProductSection-product-template-->
            </div>
        </div>
        <!--MainContent-->

<?php
include_once('includes/footer.php')
?>