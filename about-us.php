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
?>

<!--Page Title-->
<div class="page section-header text-center">
    <div class="page-title">
        <div class="wrapper">
            <h1 class="page-width">About Us</h1>
        </div>
    </div>
</div>
<!--End Page Title-->

<div class="container">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-12 col-lg-12 main-col">
            <div class="text-center mb-4">
                <h2 class="h2">MECHANICAL ASSURANCE BEAREAU - MeCAB</h2>
                <div class="rte-setting">
                    <p>
                        <strong>Your life is our prominent solitude</strong>
                    </p>
                    <p>
                        Our company is dedicated to serving the needs of mechanics, spare parts sellers, and buyers by
                        providing a comprehensive platform that enables easy and safe services. We understand the
                        importance of a reliable and efficient marketplace that connects professionals, suppliers, and
                        customers. In addition to facilitating transactions, our website also aims to enhance the
                        knowledge and skills of mechanics by offering educational resources and opportunities for
                        professional development. With our commitment to excellence and continuous improvement, we
                        strive to become the go-to destination for all automotive professionals and enthusiasts.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
            <h2 class="h2">Contact Us</h2>
            <ul class="addressFooter" style="list-style-type: none;">
                <li>
                    <p>
                        <i class="anm anm-map-marker-al"></i> Winneba, Central Region, Ghana
                    </p>
                </li>
                <li class="phone">
                    <p>
                        <i class="anm anm-phone-s"></i> +233 (0)24 479 1855
                    </p>
                </li>
                <li class="email">
                    <p>
                        <i class="anm anm-envelope-l"></i> bamfoadwuma@gmail.com
                    </p>
                </li>
            </ul>

        </div>
        <div class="col-12 col-sm-12 col-md-6 col-lg-6 mb-4">
            <h2 class="h2">Social Media</h2>
            <div class="rte-setting">
                <hr />
                <ul class="list--inline site-footer__social-icons social-icons">
                    <li>
                        <a class="social-icons__link" href="#" target="_blank" hidden>
                            <i class="icon icon-facebook"></i>
                        </a>
                    </li>
                    <li>
                        <a class="social-icons__link" href="#" target="_blank" hidden>
                            <i class="icon icon-twitter"></i>
                        </a>
                    </li>
                    <li>
                        <a class="social-icons__link" href="#" target="_blank" hidden>
                            <i class="icon icon-instagram"></i>
                        </a>
                    </li>
                    <li>
                        <a class="social-icons__link" href="#" target="_blank" hidden>
                            <i class="icon icon-youtube"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<?php
include_once('includes/footer.php')
?>