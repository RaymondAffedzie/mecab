<!-- content-wrapper ends -->
<!-- partial:partials/_footer.html -->
<footer class="footer">
    <div class="d-sm-flex justify-content-center justify-content-sm-between">
        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">
            Copyright © 2023. MeCAB from MeCAB. All rights reserved.
        </span>
        <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">
            <!-- Hand-crafted & made with -->
            <i class="ti-heart text-danger ml-1"></i>
        </span>
    </div>
</footer>
<!-- partial -->
</div>
<!-- main-panel ends -->
</div>
<!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->

<script src="../vendors/js/vendor.bundle.base.js"></script>
<script src="../js/jquery.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="../vendors/sweetalert/sweetalert.min.js"></script>
<script src="../js/off-canvas.js"></script>
<script src="../js/hoverable-collapse.js"></script>
<script src="../js/template.js"></script>
<script src="../js/settings.js"></script>
<script src="../js/todolist.js"></script>
<script src="../js/dashboard.js"></script>
<script>
    $(document).ready(function() {
        /**
         * @description Services
         * 
         */

        //  add service
        $("#save-service-btn").click(function(e) {
            e.preventDefault();

            // Get form inputs
            var service = $("#service").val().trim();
            var price = $("#price").val().trim();
            var duration = $("#duration").val().trim();

            // Perform validation
            if (service === null) {
                swal("Error", "Service is required.", "error");
                return;
            }

            if (!/^\d+(\.\d{2})?$/.test(price)) {
                swal("Error", "Price should be a number with no more than two decimal places.", "error");
                return;
            }

            var formData = new FormData();
            formData.append('service', service);
            formData.append('price', price);
            formData.append('duration', duration);

            $.ajax({
                url: "../logic/add-mechanic-service-logic.php",
                type: "POST",
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status === "success") {
                        $("#add-mechanic-service-form")[0].reset();
                        swal("Success", response.message, "success").then(function() {
                            if (response.redirect) {
                                window.location.href = response.redirect;
                            }
                        });
                    } else {
                        swal("Error", response.message, "error");
                    }
                },
                error: function(xhr, status, error) {
                    swal("Error", "An error occurred while processing the request: " + error, "error");
                }
            });
        });

        // Fetch services
        $.ajax({
            url: "../logic/get-mechanic-services.php",
            type: "GET",
            dataType: "json",
            success: function(response) {
                if (response.status === 'success') {
                    var dataTable = $('#services-table').DataTable({
                        data: response.data,
                        columns: [{
                                data: 'service_name'
                            },
                            {
                                data: 'price'
                            },
                            {
                                data: 'duration'
                            },
                            {
                                data: 'service_id',
                                render: function(data, type, row) {
                                    return '<a href="service-details.php?service=' + data + '">View</a>';
                                }
                            },
                        ],
                        paging: true,
                        searching: true,
                        ordering: true,
                        pageLength: 10,
                        lengthMenu: [
                            [5, 10, 25, 50, -1],
                            [5, 10, 25, 50, 'All']
                        ],
                    });
                } else {
                    swal("Error", response.message, "error");
                }
            },
            error: function(xhr, status, error) {
                swal("Error", "An error occurred while fetching services: " + error, "error");
            }
        });

        // Fetch service details
        function fetchServiceDetails() {
            <?php
            if (isset($_GET['service'])) {
                $service = filter_input(INPUT_GET, 'service', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            ?>
                $.ajax({
                    url: "../logic/get-mechanic-service-details.php",
                    type: "GET",
                    data: {
                        service: "<?= $service ?>"
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {
                            $("#service").text(response.data.service_name);
                            $("#price").text(response.data.price);
                            $("#duration").text(response.data.duration);
                            $("#service-name").val(response.data.service_name);
                            $("#service-price").val(response.data.price);
                            $("#service-duration").val(response.data.duration);
                            $("#service-id").val(response.data.service_id);
                            $("#service-card").show();
                        }
                    }
                });
            <?php
            }
            ?>
        }

        fetchServiceDetails();

        // Update  service
        $("#save-service-update-btn").click(function(e) {
            e.preventDefault();

            var serviceId = $("#service-id").val().trim();
            var serviceName = $("#service-name").val().trim();
            var servicePrice = $("#service-price").val().trim();
            var serviceDuration = $("#service-duration").val().trim();
            if (serviceName === null) {
                swal("Error", "Please enter service name.", "error");
                return;
            }

            if (!/^\d+(\.\d{2})?$/.test(servicePrice)) {
                swal("Error", "Price should be a number with no more than two decimal places.", "error");
                return;
            }

            var formData = new FormData();
            formData.append('service_id', serviceId);
            formData.append('service_name', serviceName);
            formData.append('price', servicePrice);
            formData.append('duration', serviceDuration);

            $.ajax({
                url: "../logic/update-mechanic-service-logic.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(response) {
                    if (response.status === 'success') {
                        swal("Success", response.message, "success").then(function() {
                            if (response.redirect) {
                                window.location.href = response.redirect;
                            }
                        });
                        fetchServiceDetails();
                    } else {
                        swal("Error", response.message, "error");
                    }
                },
                error: function(xhr, status, error) {
                    swal("Error", "An error occurred while processing the request: " + error, "error");
                }
            });
        });

        // Delete  service
        $("#delete-mechanic-service-btn").click(function(e) {
            <?php
            if (isset($_GET['service'])) {
                $service = filter_input(INPUT_GET, 'service', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            ?>
                e.preventDefault();
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this  service!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then(function(willDelete) {
                    if (willDelete) {
                        $.ajax({
                            url: "../logic/delete-mechanic-service-logic.php",
                            type: "POST",
                            data: {
                                service_id: "<?php echo $service; ?>"
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.status === "success") {
                                    swal("Success", response.message, "success").then(function() {
                                        window.location.href = response.redirect;
                                    });
                                } else {
                                    swal("Error", response.message, "error");
                                }
                            },
                            error: function(xhr, status, error) {
                                swal("Error", "An error occurred while deleting the service: " + error, "error");
                            },
                        });
                    }
                });
            <?php
            }
            ?>
        });

        /**
         * @description for loggin out and terminating session
         * 
         */

        $('#logoutForm').submit(function(e) {
            e.preventDefault();
            $.ajax({
                url: "./../logic/logout.php",
                type: "POST",
                data: $("#logoutForm").serialize() + "&action=logout",
                dataType: "json",
                success: function(response) {
                    if (response.status === 'success') {
                        window.location.href = response.redirect;
                    } else {
                        swal("Error", response.message, "error");
                    }
                },
                error: function(xhr, status, error) {
                    swal("Error", response.message, "error");
                }
            });
        });
    });
</script>

</body>

</html>