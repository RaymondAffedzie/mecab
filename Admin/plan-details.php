<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);

function errorHandler($errno, $errstr, $errfile, $errline)
{
    $eventDate = date("Y-M-d H:i:s");
    $message = "[$eventDate] - Error: [$errno] $errstr - $errfile:$errline";
    error_log($message . PHP_EOL, 3, "../error-log.txt");
}

set_error_handler("errorHandler");

require_once '../controllers/storeController.php';
include_once('includes/head.php');
include_once('includes/navbar.php');

$controller = new storeController();
?>

<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h1 class="card-title">Plan Details</h1>
                        <div class="row">
                            <div class="col-md-6 mt-md-0 mt-lg-3 text-left">
                                <p><strong>Plan Name: </strong><span id="plan_name"></span></p>
                                <p><strong>Plan Amount: </strong>GH₵ <span id="plan_amount"></span></p>
                                <p><strong>Plan Interval: </strong><span id="plan_interval"></span></p>
                                <p><strong>Plan Description: </strong><span id="plan_description"></span></p>
                                <p><strong>Date Created: </strong><span id="date_created"></span></p>
                            </div>
                            <div class="col-md-6 mt-md-0 mt-lg-3 text-left">
                                <p><strong>Plan ID: </strong><span id="plan_id"></span></p>
                                <p><strong>Plan Code: </strong><span id="plan_code"></span></p>
                                <p><strong>Plan Active Subscriptions: </strong><span id="plan_active_subscriptions"></span></p>
                                <p><strong>Plan Total Subscriptions: </strong><span id="plan_total_subscriptions"></span></p>
                                <p><strong>Plan Subscriptions Revenue: </strong>GH₵ <span id="plan_subscriptions_revenue"></span></p>
                                <p><strong>Last Updated: </strong><span id="plan_lastUpdate"></span></p>
                            </div>
                            <div class="mx-auto mt-3">
                                <button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#editPlanModal">
                                    <i class="mdi mdi-grease-pencil"></i> Edit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="modal fade" id="editPlanModal" tabindex="-1" role="dialog" aria-labelledby="editPlanModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="editPlanModalLabel">Edit Categories</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true"><i class="settings-close ti-close text-danger"></i></span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form class="" id="update-Plan-form" action="../logic/update-Plan-logic.php" method="post">

                            <input type="hidden" value="" id="edit_plan_id" name="edit_plan_id">
                            <div class="form-group">
                                <label for="edit_plan_name">Name</label>
                                <input type="text" id="edit_plan_name" class="form-control" name="edit_plan_name" placeholder="Name" required>
                            </div>

                            <div class="form-group">
                                <label for="edit_plan_amount">Amount</label>
                                <input type="number" id="edit_plan_amount" class="form-control" name="edit_plan_amount" placeholder="Amount" required>
                            </div>

                            <div class="form-group">
                                <label for="edit_plan_interval">Billing Interval</label>
                                <select id="edit_plan_interval" class="form-control" name="edit_plan_interval" required>
                                    <option value="">Selection interval for plan</option>
                                    <option value="weekly">Weekly</option>
                                    <option value="monthly">Monthly</option>
                                    <option value="quaterly">Quartery (3 months)</option>
                                    <option value="biannually">Biannually (6 months)</option>
                                    <option value="annually">Annually (12 months)</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="edit_plan_description">Description</label>
                                <textarea type="email" id="edit_plan_description" class="form-control" name="edit_plan_description" placeholder="Enter discription here" rows="3"></textarea>
                            </div>

                            <div class="mt-3">
                                <button id="save-plan-update-btn" class="btn btn-block btn-primary btn-lg" name="save">Save</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <?php include_once('includes/footer.php'); ?>