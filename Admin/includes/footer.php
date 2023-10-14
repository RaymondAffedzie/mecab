<!-- content-wrapper ends -->
<!-- partial:partials/_footer.html -->
<footer class="footer">
    <div class="d-sm-flex justify-content-center justify-content-sm-between">
        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">
            Copyright © 2023 from MeCAB. All rights reserved.
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
         * @description for notifications
         * 
         */

        $.ajax({
            type: "GET",
            url: "../logic/get-new-stores.php",
            dataType: "json",
            success: function(response) {
                if (response.status === 'success') {

                }
            }
        });

        /**
         * @descriptioin for subscription management
         */

        // save subscription plan
        $("#save-plan-btn").click(function(e) {
            e.preventDefault();
            var name = $("#plan_name").val().trim();
            var amount = $("#plan_amount").val().trim();
            var interval = $("#plan_interval").val().trim();
            var description = $("#plan_description").val().trim();
            var textRegex = /^[a-zA-Z ]+$/;
            var intervalRegex = /^(weekly|monthly|quarterly|biannually|annually)$/;
            var amountRegex = /^[1-9]\d*$/;

            if (!textRegex.test(name)) {
                swal('Error', 'Please enter a valid name. Only alphabets and spaces are allowed.', 'error');
            }
            if (!intervalRegex.test(interval)) {
                swal('Error', 'Please select a valid interval (weekly, monthly, quarterly, biannually, or annually).', 'error');
            }
            if (description && !textRegex.test(description)) {
                swal('Error', 'Please enter a valid description. Only alphabets and spaces are allowed.', 'error');
            }
            if (!amountRegex.test(amount)) {
                swal('Error', 'Please enter a valid integer value.', 'error');
            }

            var formData = new FormData();
            formData.append('plan_name', name);
            formData.append('plan_amount', amount);
            formData.append('plan_interval', interval);
            formData.append('plan_description', description);
            var url = '../logic/add-plan-logic.php';
            postReq(url, formData);
        });

        // list subscription plans
        $.ajax({
            type: "GET",
            url: "../logic/list-plans-logic.php",
            dataType: "json",
            success: function(response) {
                if (response.status === 'success') {

                    var dataTable = $('#plans-table').DataTable({
                        data: response.data,
                        columns: [{
                                data: 'name'
                            },
                            {
                                data: 'interval'
                            },
                            {
                                data: 'amount',
                                render: function(data, type, row) {
                                    return 'GH₵ ' + data / 100; 
                                }
                            },
                            {
                                data: 'id',
                                render: function(data, type, row) {
                                    return '<a href="plan-details.php?plan=' + data + '">View</a>';
                                }
                            },
                        ],
                        paging: true,
                        searching: true,
                        ordering: true,
                        pageLength: 5,
                        lengthMenu: [
                            [5, 10, 25, 50, -1],
                            [5, 10, 25, 50, 'All']
                        ],
                    });
                }
            }
        });

        // Fetch subscription plan details
        <?php
        if (isset($_GET['plan'])) {
            $plan = filter_input(INPUT_GET, 'plan', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        ?>
            $.ajax({
                type: "GET",
                url: "../logic/get-plan-details-logic.php",
                data: {
                    plan: "<?= $plan; ?>"
                },
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        $("#plan_name").text(response.data.name);
                        $("#plan_amount").text(response.data.amount / 100);
                        $("#plan_interval").text(response.data.interval);
                        $("#plan_description").text(response.data.description);
                        $("#date_created").text(response.data.createdAt);
                        $("#plan_id").text(response.data.id);
                        $("#plan_code").text(response.data.plan_code);
                        $("#plan_total_subscriptions").text(response.data.subscriptions_count);
                        $("#plan_subscriptions_revenue").text(response.data.total_revenue / 100);
                        $("#plan_active_subscriptions").text(response.data.active_subscriptions_count);
                        $("#plan_lastUpdate").text(response.data.updatedAt);
                        $("#edit_plan_name").val(response.data.name);
                        $("#edit_plan_amount").val(response.data.amount / 100);
                        $("#edit_plan_interval").val(response.data.interval);
                        $("#edit_plan_description").val(response.data.description);
                        $("#edit_plan_id").val(response.data.id);

                    } else {
                        swal("Error", response.message, "error");
                    }
                }
            });
        <?php
        }
        ?>

        // save subscription plan
        $("#save-plan-update-btn").click(function(e) {
            e.preventDefault();
            var name = $("#edit_plan_name").val().trim();
            var amount = $("#edit_plan_amount").val().trim();
            var interval = $("#edit_plan_interval").val().trim();
            var description = $("#edit_plan_description").val().trim();
            var id = $("#edit_plan_id").val().trim();
            var textRegex = /^[a-zA-Z ]+$/;
            var intervalRegex = /^(weekly|monthly|quarterly|biannually|annually)$/;
            var amountRegex = /^[1-9]\d*$/;

            if (!textRegex.test(name)) {
                swal('Error', 'Please enter a valid name. Only alphabets and spaces are allowed.', 'error');
            }
            if (!intervalRegex.test(interval)) {
                swal('Error', 'Please select a valid interval (weekly, monthly, quarterly, biannually, or annually).', 'error');
            }
            if (description && !textRegex.test(description)) {
                swal('Error', 'Please enter a valid description. Only alphabets and spaces are allowed.', 'error');
            }
            if (!amountRegex.test(amount)) {
                swal('Error', 'Please enter a valid integer value for amount.', 'error');
            }

            var formData = new FormData();
            formData.append('plan_name', name);
            formData.append('plan_amount', amount);
            formData.append('plan_interval', interval);
            formData.append('plan_description', description);
            formData.append('plan_id', id);
            var url = '../logic/update-plan-logic.php';
            postReq(url, formData);
        });

        /**
         * @description for  management
         * 
         */

        $("#save-admin-btn").click(function(e) {
            e.preventDefault();

            var first_name = $("#admin_first_name").val().trim();
            var other_names = $("#admin_other_names").val().trim();
            var last_name = $("#admin_last_name").val().trim();
            var email = $("#admin_email").val().trim();
            var contact = $("#admin_contact").val().trim();

            if (first_name === '') {
                swal("Error", "Please enter first name.", "error");
                return;
            }

            if (last_name === '') {
                swal("Error", "Please enter last name.", "error");
                return;
            }

            // Validate the email format with a regular expression
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                swal("Error", "Please enter a valid email address.", "error");
                return;
            }

            var formData = new FormData();
            formData.append('first_name', first_name);
            formData.append('other_names', other_names);
            formData.append('last_name', last_name);
            formData.append('email', email);
            formData.append('contact', contact);

            $.ajax({
                url: '../logic/add-admins-logic.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status === 'success') {
                        $("#add-admin-form")[0].reset();
                        swal("Success", response.message, "success")
                        fetchAdmins();
                    } else {
                        swal("Error", response.message, "error");
                    }
                },
                error: function(xhr, status, error) {
                    swal("Error", "An error occurred while processing the request: " + error, "error");
                }
            });
        });

        function fetchAdmins() {
            // Fetch Admins
            $.ajax({
                url: "../logic/get-admins-logic.php",
                type: "GET",
                dataType: "json",
                success: function(response) {
                    if (response.status === 'success') {
                        var rowNo = 0;
                        var dataTable = $('#admins-table').DataTable({
                            data: response.data,
                            columns: [{
                                    data: 'first_name'
                                },
                                {
                                    data: 'last_name'
                                },
                                {
                                    data: 'users_email'
                                },
                                {
                                    data: 'users_contact'
                                },
                                {
                                    data: 'user_id',
                                    render: function(data, type, row) {
                                        return '<a href="admin-details.php?admin=' + data + '">View</a>';
                                    }
                                },
                            ],
                            paging: true,
                            searching: true,
                            ordering: true,
                            pageLength: 20,
                            lengthMenu: [
                                [5, 10, 25, 50, -1],
                                [5, 10, 25, 50, 'All']
                            ],
                        });
                    } else {
                        // Handle error case
                        swal("Error", response.message, "error");
                    }
                },
                error: function(xhr, status, error) {
                    swal("Error", "An error occurred while fetching Admins: " + error, "error");
                }
            });
        }

        fetchAdmins();

        // Fetch Admin details
        <?php
        if (isset($_GET['admin'])) {
            $admin = filter_input(INPUT_GET, 'admin', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        ?>
            $.ajax({
                url: "../logic/get-admin-details.php",
                type: "GET",
                data: {
                    admin: "<?= $admin ?>"
                },
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        $("#name").text(response.data.first_name + " " + response.data.other_names + " " + response.data.last_name);
                        $("#email").text(response.data.users_email);
                        $("#contact").text(response.data.users_contact);
                        $("#admin-card").show();
                    }
                }
            });

            // Admin unblock button
            $("#status-unblock-btn").click(function(e) {
                e.preventDefault();
                swal({
                    title: "Are you sure?",
                    text: "You want to grant access to this admin!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then(function(status) {
                    if (status) {
                        $.ajax({
                            url: "../logic/unblock-admin-logic.php",
                            type: "POST",
                            data: {
                                admin: "<?= $admin; ?>"
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.status === "success") {
                                    swal("Success", response.message, "success");
                                    window.location.href = response.redirect;
                                } else {
                                    swal("Error", response.message, "error");
                                }
                            },
                            error: function(xhr, status, error) {
                                swal("Error", "An error occurred while unblocking the Admin: " + error, "error");
                            },
                        });
                    }
                });
            });

            // Admin block button
            $("#status-block-btn").click(function(e) {
                e.preventDefault();
                swal({
                    title: "Are you sure?",
                    text: "You want to block this admin!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then(function(status) {
                    if (status) {
                        $.ajax({
                            url: "../logic/block-admin-logic.php",
                            type: "POST",
                            data: {
                                admin: "<?= $admin; ?>"
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.status === "success") {
                                    swal("Success", response.message, "success");
                                    window.location.href = response.redirect;
                                } else {
                                    swal("Error", response.message, "error");
                                }
                            },
                            error: function(xhr, status, error) {
                                swal("Error", "An error occurred while blocking the Admin: " + error, "error");
                            },
                        });
                    }
                });
            });

        <?php
        }
        ?>


        /**
         * @description for car brands management 
         * 
         * */

        // fetch car brand details
        fetchCarBrandDetails();

        $("#save-brand-btn").click(function(e) {
            e.preventDefault();

            // Get form inputs
            var brandName = $("#brandName").val().trim();

            // Perform validation
            if (brandName === "") {
                swal("Error", "Car brand name is required.", "error");
                return;
            }

            var formData = new FormData();
            formData.append('brandName', brandName);

            // All inputs are valid, proceed with AJAX request
            $.ajax({
                url: "../logic/add-car-brand-logic.php",
                type: "POST",
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response) {
                    // Handle the response and redirect
                    if (response.status === "success") {
                        $("#add-car-brand-form")[0].reset();
                        swal("Success", response.message, "success").then(function() {
                            window.location.href = response.redirect;
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

        // Fetch car brands
        $.ajax({
            url: "../logic/get-car-brands.php",
            type: "GET",
            dataType: "json",
            success: function(response) {
                if (response.status === 'success') {
                    // Initialize DataTables
                    var dataTable = $('#car-brands-table').DataTable({
                        data: response.parts,
                        columns: [{
                                data: 'brand_name'
                            },
                            {
                                data: 'car_brand_id',
                                render: function(data, type, row) {
                                    return '<a href="car-brand-details.php?car_brand_id=' + data + '">View</a>';
                                }
                            },
                        ],
                        paging: true,
                        searching: true,
                        ordering: true,
                        pageLength: 5,
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
                swal("Error", "An error occurred while fetching car brands: " + error, "error");
            }
        });

        // Fetch car brand details
        function fetchCarBrandDetails() {
            <?php
            if (isset($_GET['car_brand_id'])) {
                $car_brand_id = filter_input(INPUT_GET, 'car_brand_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            ?>
                $.ajax({
                    url: "../logic/get-car-brand-details.php",
                    type: "GET",
                    data: {
                        car_brand_id: "<?= $car_brand_id ?>"
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {
                            $("#brand_name").text(response.data.brand_name);
                            $("#car-brand-name").val(response.data.brand_name);
                            $("#car-brand-id").val(response.data.car_brand_id);
                            $("#car-brand-card").show();
                        }
                    }
                });
            <?php
            }
            ?>
        }

        // Update car brand
        $("#save-brand-update-btn").click(function(e) {
            e.preventDefault();

            var carBrandId = $("#car-brand-id").val().trim();
            var carBrandName = $("#car-brand-name").val().trim();

            if (carBrandName === "") {
                swal("Error", "Please enter car brand name.", "error");
                return;
            }

            var formData = new FormData();
            formData.append('brand_id', carBrandId);
            formData.append('brand_name', carBrandName);

            $.ajax({
                url: "../logic/update-car-brand-logic.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(response) {
                    if (response.status === 'success') {
                        $("#update-car-model-form")[0].fetchCarBrandDetails();
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

        // Delete car brand
        $("#delete-car-brand-btn").click(function(e) {
            e.preventDefault();
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this car brand!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then(function(willDelete) {
                if (willDelete) {
                    $.ajax({
                        url: "../logic/delete-car-brand.php",
                        type: "POST",
                        data: {
                            car_brand_id: "<?php echo $sparepart_id; ?>"
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.status === "success") {
                                swal("Success", response.message, "success").then(function() {
                                    window.location.href = "../Admin/add-car-brand.php";
                                });
                            } else {
                                swal("Error", response.message, "error");
                            }
                        },
                        error: function(xhr, status, error) {
                            swal("Error", "An error occurred while deleting the Car Brand: " + error, "error");
                        },
                    });
                }
            });
        });


        /**
         * @description for car models management 
         * 
         * */

        $("#save-model-btn").click(function(e) {
            e.preventDefault();

            // Get form inputs
            var modelName = $("#modelName").val().trim();
            var car_brand_id = $("#car_brand_id").val().trim();

            // Perform validation
            if (modelName === "") {
                swal("Error", "Car model name is required.", "error");
                return;
            }
            if (car_brand_id === "") {
                swal("Error", "Car brand is required.", "error");
                return;
            }

            var formData = new FormData();
            formData.append('car_brand_id', car_brand_id);
            formData.append('modelName', modelName);

            // All inputs are valid, proceed with AJAX request
            $.ajax({
                url: "../logic/add-car-model-logic.php",
                type: "POST",
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response) {
                    // Handle the response and redirect
                    if (response.status === "success") {
                        $("#add-car-model-form")[0].reset();
                        swal("Success", response.message, "success").then(function() {
                            window.location.href = response.redirect; // redirect to desired page
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

        // Fetch car models
        $.ajax({
            url: "../logic/get-car-models.php",
            type: "GET",
            dataType: "json",
            success: function(response) {
                if (response.status === 'success') {
                    // Initialize DataTables
                    var rowNo = 0;
                    var dataTable = $('#car-model-table').DataTable({
                        data: response.parts,
                        columns: [{
                                data: 'brand_name'
                            },
                            {
                                data: 'model_name'
                            },
                            {
                                data: 'car_model_id',
                                render: function(data, type, row) {
                                    // Modify the "View" link to pass the car_brand_id as a query parameter
                                    return '<a href="car-model-details.php?model=' + data + '">View</a>';
                                }
                            },
                        ],
                        // Add options for pagination, searching, and sorting
                        paging: true,
                        searching: true,
                        ordering: true,
                        // Customize the number of records displayed per page (e.g., 10 records per page)
                        pageLength: 5,
                        // You can customize the page length options if needed
                        lengthMenu: [
                            [5, 10, 25, 50, -1],
                            [5, 10, 25, 50, 'All']
                        ],
                    });
                } else {
                    // Handle error case
                    swal("Error", response.message, "error");
                }
            },
            error: function(xhr, status, error) {
                swal("Error", "An error occurred while fetching car models: " + error, "error");
            }
        });

        <?php
        if (isset($_GET['model'])) {
            $car_model = filter_input(INPUT_GET, 'model', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        ?>
            // Fetch car model details
            function fetchCarModelDetails() {
                $.ajax({
                    url: "../logic/get-car-model-details.php",
                    type: "GET",
                    data: {
                        model: "<?= $car_model; ?>"
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {
                            $("#model_name").text(response.data[0].model_name);
                            $("#model_brand_name").text("Brand name: " + response.data[0].brand_name);
                            $("#car-model-name").val(response.data[0].model_name);
                            $("#car-brand-name").val(response.data[0].brand_name);
                            $("#car-model-id").val(response.data[0].car_model_id);
                            $("#car-model-card").show();
                        }
                    }
                });
            }

            fetchCarModelDetails();

            // Delete car model
            $("#delete-car-model-btn").click(function(e) {
                e.preventDefault();
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this car model!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then(function(willDelete) {
                    if (willDelete) {
                        $.ajax({
                            url: "../logic/delete-car-model.php",
                            type: "POST",
                            data: {
                                model_id: "<?= $car_model; ?>"
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.status === "success") {
                                    swal("Success", response.message, "success").then(function() {
                                        window.location.href = "../Admin/add-car-model.php";
                                    });
                                } else {
                                    swal("Error", response.message, "error");
                                }
                            },
                            error: function(xhr, status, error) {
                                swal("Error", "An error occurred while deleting the Car Model: " + error, "error");
                            },
                        });
                    }
                });
            });
        <?php
        }
        ?>

        // Update Car Model
        $("#save-model-update-btn").click(function(e) {
            e.preventDefault();

            // Get form inputs
            var carModelId = $("#car-model-id").val().trim();
            var carModelName = $("#car-model-name").val().trim();

            if (carModelName === "") {
                swal("Error", "Please enter car model name.", "error");
                return;
            }

            var formData = new FormData();
            formData.append('model_id', carModelId);
            formData.append('model_name', carModelName);

            $.ajax({
                url: "../logic/update-car-model-logic.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(response) {
                    if (response.status === 'success') {
                        $("#update-car-model-form")[0].fetchCarModelDetails();
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


        /**
         * @description for categories management
         * 
         */

        $("#save-category-btn").click(function(e) {
            e.preventDefault();

            var category_name = $("#category_name").val().trim();

            if (category_name === '') {
                swal("Error", "Please enter category name.", "error");
                return;
            }

            var imageInput = document.getElementById('image-upload');
            var selectedFile = imageInput.files[0];
            var allowedExtensions = /(\.png|\.jpeg|\.jpg|)$/i;

            if (!selectedFile) {
                swal("Error", "Please select an image.", "error");
                return;
            }

            if (!allowedExtensions.exec(selectedFile.name)) {
                swal("Error", "Invalid image file. Allowed extensions are PNG, JPEG and JPG.", "error");
                return;
            }

            var formData = new FormData();
            formData.append('category_name', category_name);
            formData.append('image', selectedFile);

            $.ajax({
                url: '../logic/add-categories-logic.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status === 'success') {
                        $("#add-categories-form")[0].reset();
                        swal("Success", response.message, "success").then(function() {
                            window.location.href = response.redirect;
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

        // Fetch category details
        <?php
        if (isset($_GET['category'])) {
            $category = filter_input(INPUT_GET, 'category', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        ?>
            $.ajax({
                type: "GET",
                url: "../logic/get-category-details-logic.php",
                data: {
                    category: "<?= $category; ?>"
                },
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        $("#name").text(response.data.category_name);
                        $("#image").attr("src", "../uploads/" + response.data.image);
                        $("#category_id").val(response.data.category_id);
                        $("#category_name").val(response.data.category_name);
                    } else {
                        swal("Error", response.message, "error");
                    }
                }
            });
        <?php
        }
        ?>

        $("#save-category-update-btn").click(function(e) {
            e.preventDefault();

            var category_name = $("#category_name").val().trim();
            var category_id = $("#category_id").val().trim();

            var categoryImageElement = $("#image-upload");
            var categoryImage = null;

            if (categoryImageElement.length > 0 && categoryImageElement[0].files.length > 0) {
                categoryImage = categoryImageElement[0].files[0];
                var allowedExtensions = /(\.png|\.jpeg|\.jpg)$/i;
                if (!allowedExtensions.exec(categoryImage.name)) {
                    swal("Error", "Invalid image file. Allowed extensions are PNG, JPEG, JPG and AVIF.", "error");
                    return;
                }
            }

            var formData = new FormData();
            formData.append('category_id', category_id);
            formData.append('category_name', category_name);
            formData.append('image', categoryImage);

            $.ajax({
                url: "../logic/update-category-logic.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(response) {
                    if (response.status === 'success') {
                        $("#update-category-form")[0].reset();
                        swal("Success", response.message, "success");
                    } else {
                        swal("Error", response.message, "error");
                    }
                },
                error: function(xhr, status, error) {
                    swal("Error", "An error occurred while processing the request: " + error, "error");
                }
            });
        });

        // Delete spare part item
        $("#delete-category-btn").click(function(e) {
            <?php
            if (isset($_GET['category'])) {
                $category = filter_input(INPUT_GET, 'category', FILTER_SANITIZE_NUMBER_INT);
            ?>
                e.preventDefault();
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this category!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then(function(willDelete) {
                    if (willDelete) {
                        $.ajax({
                            url: "../logic/delete-category.php",
                            type: "POST",
                            data: {
                                category_id: "<?= $category; ?>"
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.status === "success") {
                                    swal("Success", response.message, "success").then(function() {
                                        window.location.href = "../Admin/view-categories.php";
                                    });
                                } else {
                                    swal("Error", response.message, "error");
                                }
                            },
                            error: function(xhr, status, error) {
                                swal("Error", "An error occurred while deleting the category: " + error, "error");
                            },
                        });
                    }

                });
            <?php
            }
            ?>
        });

        // Fetch categories
        $.ajax({
            url: "../logic/get-categories.php",
            type: "GET",
            dataType: "json",
            success: function(response) {
                if (response.status === 'success') {
                    var dataTable = $('#categories-table').DataTable({
                        data: response.categories,
                        columns: [{
                                data: 'category_name'
                            },
                            {
                                data: 'category_id',
                                render: function(data, type, row) {
                                    return '<a href="category-details.php?category=' + data + '">View</a>';
                                }
                            },
                        ],
                        paging: true,
                        searching: true,
                        ordering: true,
                        pageLength: 10,
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
                swal("Error", "An error occurred while fetching categories: " + error, "error");
            }
        });


        /**
         * @description for carrousel management
         * 
         */

        $("#save-carousel-btn").click(function(e) {
            e.preventDefault();

            var caption = $("#caption").val().trim();
            if (caption === '') {
                swal("Error", "Please enter slide caption.", "error");
                return;
            }

            var imageInput = document.getElementById('image-upload');
            var selectedFile = imageInput.files[0];
            var allowedExtensions = /(\.png|\.jpeg|\.jpg|)$/i;

            if (!selectedFile) {
                swal("Error", "Please select an image.", "error");
                return;
            }

            if (!allowedExtensions.exec(selectedFile.name)) {
                swal("Error", "Invalid image file. Allowed extensions are PNG, JPEG and JPG", "error");
                return;
            }

            var formData = new FormData();
            formData.append('caption', caption);
            formData.append('image', selectedFile);

            $.ajax({
                url: '../logic/add-carousel-logic.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status === 'success') {
                        $("#add-carousel-form")[0].reset();
                        swal("Success", response.message, "success").then(function() {
                            window.location.href = response.redirect;
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

        // Fetch carousel details
        <?php
        if (isset($_GET['carousel'])) {
            $carousel = filter_input(INPUT_GET, 'carousel', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        ?>
            $.ajax({
                type: "GET",
                url: "../logic/get-carousel-details-logic.php",
                data: {
                    carousel: "<?= $carousel; ?>"
                },
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        $("#caption").text(response.data.carousel_caption);
                        $("#date ").text(response.data.created_at);
                        $("#image").attr("src", "../uploads/" + response.data.image);
                        $("#carousel_id").val(response.data.carousel_ID);
                        $("#carousel_caption").val(response.data.carousel_caption);
                    } else {
                        swal("Error", response.message, "error");
                    }
                }
            });
        <?php
        }
        ?>

        // Fetch carousels
        $.ajax({
            url: "../logic/get-carousels.php",
            type: "GET",
            dataType: "json",
            success: function(response) {
                if (response.status === 'success') {
                    var dataTable = $('#carousel-table').DataTable({
                        data: response.carousel,
                        columns: [{
                                data: 'carousel_caption'
                            },
                            {
                                data: 'created_at'
                            },
                            {
                                data: 'carousel_ID',
                                render: function(data, type, row) {
                                    return '<a href="carousel-details.php?carousel=' + data + '">View</a>';
                                }
                            },
                        ],
                        paging: true,
                        searching: true,
                        ordering: true,
                        pageLength: 10,
                        lengthMenu: [
                            [10, 25, 50, -1],
                            [10, 25, 50, 'All']
                        ],
                    });
                } else {
                    swal("Error", response.message, "error");
                }
            },
            error: function(xhr, status, error) {
                swal("Error", "An error occurred while fetching categories: " + error, "error");
            }
        });

        // update carousel
        $("#save-carousel-update-btn").click(function(e) {
            e.preventDefault();

            var carouselCaption = $("#carousel_caption").val().trim();
            var carousel_ID = $("#carousel_id").val().trim();

            if (carouselCaption === '') {
                swal("Error", "Please enter carousel caption.", "error");
                return;
            }

            var imageInput = document.getElementById('image-upload');
            var selectedFile = imageInput.files[0]; // Get the selected file
            var allowedExtensions = /(\.png|\.jpeg|\.jpg)$/i;

            // Check if an image is selected
            if (!selectedFile) {
                swal("Error", "Please select an image.", "error");
                return;
            }

            // Check the file extension
            if (!allowedExtensions.exec(selectedFile.name)) {
                swal("Error", "Invalid image file. Allowed extensions are PNG, JPEG, and JPG.", "error");
                return;
            }

            var formData = new FormData();
            formData.append('carousel_ID', carousel_ID);
            formData.append('carousel_caption', carouselCaption);
            formData.append('image', selectedFile);

            $.ajax({
                url: '../logic/update-carousel-logic.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status === 'success') {
                        $("#update-carousel-form")[0].reset();
                        swal("Success", response.message, "success").then(function() {});
                    } else {
                        swal("Error", response.message, "error");
                    }
                },
                error: function(xhr, status, error) {
                    swal("Error", "An error occurred while processing the request: " + error, "error");
                }
            });

        });

        // Delete carousel
        $("#delete-carousel-btn").click(function(e) {
            <?php
            if (isset($_GET['carousel'])) {
                $carousel = filter_input(INPUT_GET, 'carousel', FILTER_SANITIZE_NUMBER_INT);
            ?>
                e.preventDefault();
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this carousel!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then(function(willDelete) {
                    if (willDelete) {
                        $.ajax({
                            url: "../logic/delete-carousel.php",
                            type: "POST",
                            data: {
                                carousel: "<?= $carousel; ?>"
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.status === "success") {
                                    swal("Success", response.message, "success");
                                    window.location.href = response.redirect;
                                } else {
                                    swal("Error", response.message, "error");
                                }
                            },
                            error: function(xhr, status, error) {
                                swal("Error", "An error occurred while deleting the carousel: " + error, "error");
                            },
                        });
                    }

                });
            <?php
            }
            ?>
        });


        /**
         * @description for specialisation management
         * 
         */

        $("#save-specialisation-btn").click(function(e) {
            e.preventDefault();
            var spcialisation = $("#spcialisation").val().trim();
            var description = $("#description").val().trim();

            if (spcialisation === "") {
                swal("Error", "spcialisation name is required.", "error");
                return;
            }

            var imageInput = document.getElementById('image-upload');
            var selectedFile = imageInput.files[0];

            var allowedExtensions = /(\.png|\.jpeg|\.jpg)$/i;

            if (!selectedFile) {
                swal("Error", "Please select an image.", "error");
                return;
            }

            // Check the file extension
            if (!allowedExtensions.exec(selectedFile.name)) {
                swal("Error", "Invalid image file. Allowed extensions are PNG, JPEG and JPG.", "error");
                return;
            }

            var formData = new FormData();
            formData.append('spcialisation', spcialisation);
            formData.append('description', description);
            formData.append('image', selectedFile);

            $.ajax({
                url: "../logic/add-specialisation-logic.php",
                type: 'POST',
                data: formData,
                dataType: 'json',
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status === "success") {
                        $("#add-spcialisation-form")[0].reset();
                        swal("Success", response.message, "success");
                        window.location.href = response.redirect;
                    } else {
                        swal("Error", response.message, "error");
                    }
                },
                error: function(xhr, status, error) {
                    swal("Error", "An error occurred while processing the request: " + error, "error");
                }
            });
        });

        // Fetch specialisation details
        <?php
        if (isset($_GET['specialisation'])) {
            $specialisation = filter_input(INPUT_GET, 'specialisation', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        ?>
            $.ajax({
                type: "GET",
                url: "../logic/get-specialisation-details-logic.php",
                data: {
                    specialisation: "<?= $specialisation; ?>"
                },
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        $("#name").text(response.data.specialisation);
                        $("#description").text(response.data.description);
                        $("#image").attr("src", "../uploads/" + response.data.image);
                        $("#specialisation_id").val(response.data.specialisation_id);
                        $("#specialisation_name").val(response.data.specialisation);
                        $("#description").val(response.data.description);
                    } else {
                        swal("Error", response.message, "error");
                    }
                }
            });
        <?php
        }
        ?>

        $("#save-specialisation-update-btn").click(function(e) {
            e.preventDefault();

            var specialisation_name = $("#specialisation_name").val().trim();
            var specialisation_id = $("#specialisation_id").val().trim();
            var specialisation_description = $("#specialisation_description").val().trim();
            var specialisationImageElement = $("#image-upload");
            var specialisationImage = null;

            if (specialisationImageElement.length > 0 && specialisationImageElement[0].files.length > 0) {
                specialisationImage = specialisationImageElement[0].files[0];
                var allowedExtensions = /(\.png|\.jpeg|\.jpg)$/i;
                if (!allowedExtensions.exec(specialisationImage.name)) {
                    swal("Error", "Invalid image file. Allowed extensions are PNG, JPEG and JPG", "error");
                    return;
                }
            }

            var formData = new FormData();
            formData.append('specialisation_id', specialisation_id);
            formData.append('specialisation_name', specialisation_name);
            formData.append('specialisation_description', specialisation_description);
            formData.append('image', specialisationImage);

            $.ajax({
                url: "../logic/update-specialisation-logic.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(response) {
                    if (response.status === 'success') {
                        $("#update-specialisation-form")[0].reset();
                        swal("Success", response.message, "success");
                        window.location.href = response.redirect;
                    } else {
                        swal("Error", response.message, "error");
                    }
                },
                error: function(xhr, status, error) {
                    swal("Error", "An error occurred while processing the request: " + error, "error");
                }
            });
        });

        // Delete specialisation
        $("#delete-specialisation-btn").click(function(e) {
            <?php
            if (isset($_GET['specialisation'])) {
                $specialisation = filter_input(INPUT_GET, 'specialisation', FILTER_SANITIZE_NUMBER_INT);
            ?>
                e.preventDefault();
                swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this specialisation!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then(function(willDelete) {
                    if (willDelete) {
                        $.ajax({
                            url: "../logic/delete-specialisation.php",
                            type: "POST",
                            data: {
                                specialisation: "<?= $specialisation; ?>"
                            },
                            dataType: "json",
                            success: function(response) {
                                if (response.status === "success") {
                                    swal("Success", response.message, "success");
                                    window.location.href = response.redirect;
                                } else {
                                    swal("Error", response.message, "error");
                                }
                            },
                            error: function(xhr, status, error) {
                                swal("Error", "An error occurred while deleting the specialisation: " + error, "error");
                            },
                        });
                    }

                });
            <?php
            }
            ?>
        });

        // Fetch specialisations 
        $.ajax({
            url: "../logic/get-specialisations-logic.php",
            type: "GET",
            dataType: "json",
            success: function(response) {
                if (response.status === 'success') {
                    // Initialize DataTables
                    var dataTable = $('#specialisation-table').DataTable({
                        data: response.specialisations,
                        columns: [{
                                data: 'specialisation'
                            },
                            {
                                data: 'specialisation_id',
                                render: function(data, type, row) {
                                    return '<a href="specialisation-details.php?specialisation=' + data + '">View</a>';
                                }
                            },
                        ],
                        paging: true,
                        searching: true,
                        ordering: true,
                        pageLength: 10,
                        lengthMenu: [
                            [10, 25, 50, -1],
                            [10, 25, 50, 'All']
                        ],
                    });
                } else {
                    swal("Error", response.message, "error");
                }
            },
            error: function(xhr, status, error) {
                swal("Error", "An error occurred while fetching specialisation: " + error, "error");
            }
        });

        /**
         * @description for user account management
         * 
         */

        // get user details
        $.ajax({
            url: "../logic/get-user-details.php",
            type: "GET",
            dataType: "json",
            success: function(response) {
                if (response.status === 'success') {

                    var userDetails = response.user;

                    // populate profile card
                    var fullName = userDetails.first_name + " " + userDetails.last_name;
                    fullName += userDetails.other_names ? " " + userDetails.other_names : " ";
                    $("#user-full-name").text(fullName);
                    $("#user-role").text(userDetails.users_role);
                    $("#user-contact").text(userDetails.users_contact);
                    $("#user-email").text(userDetails.users_email);

                    // populate update form
                    $("#first_name").val(userDetails.first_name);
                    $("#other_names").val(userDetails.other_names);
                    $("#last_name").val(userDetails.last_name);
                    $("#user_email").val(userDetails.users_email);
                    $("#user_contact").val(userDetails.users_contact);
                    $("#user_role").val(userDetails.users_role);

                    // Show the user profile card
                    $("#user-profile-card").show();
                } else {
                    // Handle error case
                    swal("Error", response.message, "error");
                }
            },
            error: function(xhr, status, error) {
                swal("Error", "An error occurred while fetching user details: " + error, "error");
            }
        });

        // Update user details script
        $("#save-profile-btn").click(function(e) {
            e.preventDefault();

            // Get form inputs
            var firstName = $("#first_name").val().trim();
            var otherNames = $("#other_names").val().trim();
            var lastName = $("#last_name").val().trim();
            var userEmail = $("#user_email").val().trim();
            var userContact = $("#user_contact").val().trim();

            // Perform validation
            if (firstName === "") {
                swal("Error", "Please enter your first name.", "error");
                return;
            }
            if (lastName === "") {
                swal("Error", "Please enter your last name.", "error");
                return;
            }
            if (userEmail === "") {
                swal("Error", "Please enter your email.", "error");
                return;
            }
            if (userContact === "") {
                swal("Error", "Please enter your contact.", "error");
                return;
            }
            if (!validateEmail(userEmail)) {
                swal("Error", "Please enter a valid email address.", "error");
                return;
            }
            if (!validateContact(userContact)) {
                swal("Error", "Please enter a valid contact number starting with 0 and containing 10 digits.", "error");
                return;
            }

            var formData = new FormData();
            formData.append('first_name', firstName);
            formData.append('last_name', lastName);
            formData.append('other_names', otherNames);
            formData.append('user_email', userEmail);
            formData.append('user_contact', userContact);

            // All inputs are valid, proceed with AJAX request
            $.ajax({
                url: "../logic/update-user-logic.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(response) {
                    // Handle the response and redirect
                    if (response.status === 'success') {
                        $("#update-profile-form")[0].reset();
                        swal("Success", response.message, "success").then(function() {
                            window.location.href = response.redirect;
                        });
                    } else {
                        swal("Error", response.message, "error");
                    }
                },
                error: function(xhr, status, error) {
                    swal("Error", "An error occurred while processing the request: " + error, "error");
                }
            });

            // Email validation helper function
            function validateEmail(email) {
                var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailPattern.test(email);
            }

            // Contact validation helper function
            function validateContact(contact) {
                var contactPattern = /^0\d{9}$/;
                return contactPattern.test(contact);
            }
        });

        // Change password script
        $("#save-password-btn").click(function(e) {
            e.preventDefault();

            // Get form inputs
            var oldPassword = $("#old-password").val().trim();
            var newPassword = $("#new-password").val().trim();
            var conPassword = $("#con-new-password").val().trim();

            // Perform validation
            if (oldPassword === "") {
                swal("Error", "Please enter your password.", "error");
                return;
            }
            if (newPassword === "") {
                swal("Error", "Please enter your new password.", "error");
                return;
            }
            if (conPassword === "") {
                swal("Error", "Please confirm your new password.", "error");
                return;
            }
            if (oldPassword === newPassword) {
                swal("Error", "Cannot use old password as new password.", "error");
                return;
            }
            if (newPassword !== conPassword) {
                swal("Error", "New password and confirm password do not match", "error");
                return;
            }

            var formData = new FormData();
            formData.append('old_password', oldPassword);
            formData.append('new_password', newPassword);
            formData.append('con_password', conPassword);
            // console.log(formData);

            // All inputs are valid, proceed with AJAX request
            $.ajax({
                url: "../logic/change-password-logic.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(response) {
                    // Handle the response and redirect
                    if (response.status === 'success') {
                        $("#change-password-form")[0].reset();
                        swal("Success", response.message, "success").then(function() {
                            window.location.href = response.redirect;
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

        function postReq(url, data) {
            $.ajax({
                url: url,
                type: "POST",
                data: data,
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
                    } else {
                        swal("Error", response.message, "error");
                    }
                },
                error: function(xhr, status, error) {
                    swal("Error", "An error occurred while processing the request: " + error, "error");
                }
            });
        }
    });


    /**
     * @global image preveiw
     * 
     * */

    // Function to preview the selected image
    function previewImage(input) {
        var imagePreview = document.getElementById('image-preview');
        var imagePreviewContainer = document.getElementById('image-preview-container');

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                imagePreview.setAttribute('src', e.target.result);
                imagePreviewContainer.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        } else {
            imagePreview.setAttribute('src', '');
            imagePreviewContainer.style.display = 'none';
        }
    }

    document.getElementById('image-upload').addEventListener('change', function() {
        previewImage(this);
    });
</script>

</body>

</html>