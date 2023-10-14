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
    $query = "SELECT ms.users_id, ms.service_id, ms.service_name, ms.price, ms.duration, ms.users_id, st.store_name, st.store_town, st.store_location, c.users_contact FROM mechanic_services ms 
              INNER JOIN users u  ON u.user_id = ms.users_id
              INNER JOIN users_contact c ON c.users_id = u.user_id
              INNER JOIN users_store us ON us.users_id = u.user_id
              INNER JOIN stores st ON st.store_id = us.store_id
              WHERE ms.users_id = :service";
    $params = array(':service' => $service);
    $services = $controller->getRecordsByValue($query, $params);
}
?>

<div class="container">
    <div class="row">
        <?php
        foreach ($services as $data) {
        ?>
            <div class="col-md-4 mb-3">
                <div class="h-100 p-3 text-dark rounded-lg border">
                    <h1><?= $data['service_name']; ?></h1>
                    <h2>&#x20B5;<?= $data['price'] . ' | ' . $data['duration'] . 'hrs - Service duration'; ?> </h2>
                    <p><?= $data['users_contact'] . ' | ' . $data['store_town'] . ' | ' . $data['store_location']; ?></p>
                    <label for="" class="text-dark float-right">Ratings</label>
                    <a class="my-2 text-secondary" data-toggle="modal" data-target="#exampleModal" data-service-id="<?= $data['service_id']; ?>" data-service-name="<?= $data['service_name']; ?>" data-price="<?= $data['price']; ?>" data-duration="<?= $data['duration']; ?>" data-contact="<?= $data['users_contact']; ?>" data-town="<?= $data['store_town']; ?>" data-location="<?= $data['store_location']; ?>">Book appointment</a>
                </div>
            </div>
        <?php } ?>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="exampleModalLabel">Book Appointment</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="settings-close ti-close text-danger"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="book-appointment-model-form" method="post">
                            <input type="text" name="service" id="service" value="<?= $data['service_id']; ?>">
                            <input type="text" name="mechanic" id="mechanic" value="<?= $data['users_id']; ?>">
                            <small class="text-danger">Vehicle Details</small>
                            <div class="mb-3">
                                <label for="make">Make</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="make" name="make" placeholder="e.g. Toyota, Honda">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="model">Model</label>
                                <div class="input-group">
                                    <input type="text" id="model" class="form-control" name="model" placeholder="e.g. Corolla, Civic">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="year">Year</label>
                                <div class="input-group">
                                    <input type="year" id="year" class="form-control" name="year" placeholder="2023">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="plate">License Plate Number</label>
                                <div class="input-group">
                                    <input type="text" id="plate" class="form-control" name="plate" placeholder="WR-1234-24">
                                </div>
                            </div>
                            <small class="text-danger">Appointment Details</small>
                            <div class="mb-3">
                                <label for="date">Date</label>
                                <div class="input-group">
                                    <input type="date" id="date" class="form-control" name="date">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="note">Note</label>
                                <div class="input-group">
                                    <textarea type="text" id="note" class="form-control" name="note" rows="2" placeholder="Special instructions or additional details for the appointment"></textarea>
                                </div>
                            </div>

                            <button id="save-book-mechanic-appointment-btn" class="btn" name="save" data-service-id=""><i class="settings-save ti-save"></i> Save</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<?php
include_once('includes/footer.php')
?>