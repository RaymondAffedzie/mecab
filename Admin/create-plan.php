<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);

function errorHandler($errno, $errstr, $errfile, $errline)
{
    $eventDate = date("Y-M-d H:i:s"); // Fixed the time format
    $message = "[$eventDate] - Error: [$errno] $errstr - $errfile:$errline";
    error_log($message . PHP_EOL, 3, "../error-log.txt");
}

set_error_handler("errorHandler");

require_once '../controllers/storeController.php';
include_once('includes/head.php');
include_once('includes/navbar.php');

?>
<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-lg-4 pb-5">
                                        <h4 class="card-title">Add Plan</h4>
                                        <form class="pt-3" id="add-plan-form" action="../logic/add-plan-logic.php" method="post">
                                            <div class="form-group">
                                                <label for="plan_name">Name</label>
                                                <input type="text" id="plan_name" class="form-control" name="plan_name" placeholder="Name" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="plan_amount">Amount</label>
                                                <input type="number" id="plan_amount" class="form-control" name="plan_amount" placeholder="Amount" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="plan_interval">Billing Interval</label>
                                                <select id="plan_interval" class="form-control" name="plan_interval"required>
                                                    <option value="">Selection interval for plan</option>
                                                    <option value="weekly">Weekly</option>
                                                    <option value="monthly">Monthly</option>
                                                    <option value="quaterly">Quartery (3 months)</option>
                                                    <option value="biannually">Biannually (6 months)</option>
                                                    <option value="annually">Annually (12 months)</option>
                                                </select>
                                            </div>

                                            <div class="form-group">
                                                <label for="plan_description">Description</label>
                                                <textarea type="email" id="plan_description" class="form-control" name="plan_description" placeholder="Enter discription here" rows="3"></textarea>
                                            </div>

                                            <div class="mt-3">
                                                <button id="save-plan-btn" class="btn btn-block btn-primary" name="save">
                                                    <i class="mdi mdi-content-save-all"></i> Save
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-lg-8">
                                        <h4>Plans</h4>
                                        <div class="table-responsive">
                                            <table id="plans-table" class="table order-column table-hover">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">Name</th>
                                                        <th class="text-center">Billing Interval</th>
                                                        <th class="text-center">Amount</th>
                                                        <th class="text-center">View Details</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include_once('includes/footer.php'); ?>