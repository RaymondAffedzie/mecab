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


<div class="container my-5">
    <div class="pt-4 py-5 px-3 text-center bg-body-tertiary rounded-3">
        <h1 class="text-body-emphasis">MECHANICAL ASSURANCE BEAREAU - MeCAB</h1>
        <p>
            <strong>Your life is our preeminent solicitude</strong>
        </p>
        <p class="lead">
            Our company is dedicated to serving the needs of mechanics, spare parts sellers, and buyers by
            providing a comprehensive platform that enables easy and safe services. We understand the
            importance of a reliable and efficient marketplace that connects professionals, suppliers, and
            customers. In addition to facilitating transactions, our website also aims to enhance the
            knowledge and skills of mechanics by offering educational resources and opportunities for
            professional development. With our commitment to excellence and continuous improvement, we
            strive to become the go-to destination for all automotive professionals and enthusiasts.
        </p>
        <p>
            <i class="ti-location-arrow"></i> Winneba, Central Region, Ghana
        </p>
        <p>
            <i class="mdi mdi-phone"></i> +233 (0)24 479 1855
        </p>
        <p>
            <i class="mdi mdi-email"></i> info@mecab.org
        </p>
    </div>
</div>

<div class="container" id="socials">
    <div class="row slide-in from-bottom">
        <div class="cover meet">
            <div class="socials">
                <a href="" target="_blank">
                    <i class="mdi mdi-linkedin-box"></i>
                </a>
            </div>

            <div class="socials">
                <a href="" target="_blank">
                    <i class="mdi mdi-twitter"></i>
                </a>
            </div>
            <div class="socials">
                <a href=" target=" _blank">
                    <i class="mdi mdi-instagram"></i>
                </a>
            </div>
            <div class="socials">
                <a href="" target="_blank">
                    <i class="mdi mdi-facebook"></i>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="container my-5">
    <div class="p-5 text-center bg-body-tertiary rounded-3" id="contact">
        <h2 class="text-body-emphasis">Say hello to us</h2>
        <!-- <p>Contact us</p> -->
        <div class="col-lg-8">
            <input type="text" name="name" id="name" placeholder="Fullname" />
            <input type="email" name="email" id="email" placeholder="Email" />
            <textarea name="message" id="message" placeholder="Message" rows="1"></textarea>
            <button class="btn" type="button">Submit</button>
        </div>

    </div>
</div>


<?php
include_once('includes/footer.php')
?>