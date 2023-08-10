<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

// Prevent user from accessing this page when not verified
if (!$_SESSION['isVerified']) {
    // User's store is not verified
    header("location: ../verification.php");
    exit;
}
// Prevent user from accessing this page when not logged in
if (!isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']) {
    header("Location: ../login.php");
    exit;
}

require_once '../controllers/storeController.php';
include_once('includes/head.php');
include_once('includes/navbar.php');

$controller = new storeController();

?>
<!-- partial -->
<jdiv class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="col-md-12 mb-5">
                            <h4 class="card-title float-left">View spare parts</h4>
                            <h4 class="float-right"><a href="add-spare-parts.php" class="text-decoration-none">Add Spare Part</a></h4>
                        </div>
                        <div class="table-responsive">
                            <table id="spare-parts-table" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Item Name</th>
                                        <th>Category</th>
                                        <th>Car brand</th>
                                        <th>View product</th>
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
    <footer class="footer">
        <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">
                Copyright © 2023 from MeCAB. All rights reserved.
            </span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">
                <i class="ti-heart text-danger ml-1"></i>
            </span>
        </div>
    </footer>
    </div>
    <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->

    <script src="../vendors/js/vendor.bundle.base.js"></script>
    <script src="../js/jquery.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="../vendors/sweetalert/sweetalert.min.js"></script>
    <script src="../js/off-canvas.js"></script>
    <script src="../js/hoverable-collapse.js"></script>
    <script src="../js/template.js"></script>
    <script src="../js/settings.js"></script>
    <script src="../js/todolist.js"></script>
    <script src="../js/dashboard.js"></script>
    <script>
        $(document).ready(function() {
            // Fetch spare parts of a particular store
            $.ajax({
                url: "../logic/get-spare-parts.php",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.status === 'success') {
                        // Initialize DataTables
                        var dataTable = $('#spare-parts-table').DataTable({
                            data: response.parts,
                            columns: [{
                                    data: 'name'
                                },
                                {
                                    data: 'category_name'
                                },
                                {
                                    data: 'brand_name'
                                },
                                {
                                    data: 'sparepart_id',
                                    render: function(data, type, row) {
                                        // Modify the "View" link to pass the sparepart_id as a query parameter
                                        return '<a href="spare-part-details.php?sparepart_id=' + data + '">View</a>';
                                    }
                                },
                            ],
                            // Add options for pagination, searching, and sorting
                            paging: true,
                            searching: true,
                            ordering: true,
                            // Customize the number of records displayed per page (e.g., 10 records per page)
                            pageLength: 10,
                            // You can customize the page length options if needed
                            lengthMenu: [
                                [10, 25, 50, -1],
                                [10, 25, 50, 'All']
                            ],
                        });
                    } else {
                        // Handle error case
                        swal("Error", response.message, "error");
                    }
                },
                error: function(xhr, status, error) {
                    swal("Error", "An error occurred while fetching spare part details: " + error, "error");
                }
            });

            // Logout script
            $('#logoutForm').submit(function(e) {
                e.preventDefault(); // Prevent the default form submission

                // Perform the Ajax request
                $.ajax({
                    url: "./../logic/logout.php",
                    type: "POST",
                    data: $("#logoutForm").serialize() + "&action=logout",
                    dataType: "json",
                    success: function(response) {
                        // Handle the response from the server
                        if (response.status === 'success') {
                            // If logout was successful, redirect to the login page
                            window.location.href = response.redirect;
                        } else {
                            // If there was an error, display the error message
                            swal("Error", response.message, "error");
                        }
                    },
                    error: function(xhr, status, error) {
                        // If there was an error with the Ajax request, display an error message
                        swal("Error", response.message, "error");
                    }
                });
            });
        });
    </script>
    </body>

    </html>