<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);
session_start();
// Error handler 
function errorHandler($errno, $errstr, $errfile, $errline)
{
    $eventDate = date("Y-M-d H:m:s");
	$message = "[$eventDate] - Error: [$errno] $errstr - $errfile:$errline";
    error_log($message . PHP_EOL, 3, "../error-log.txt");
}
set_error_handler("errorHandler");

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

$controller = new storeController()
?>

<!-- partial -->
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card" id="spare-part-card" style="display: none;">
                    <div class="card-body">
                        <h1 class="card-title">Spare part Details</h1>
                        <div class="d-flex flex-wrap mb-5">
                            <div class="col-md-6 text-left">
                                <div class="my-3">
                                    <img src="" alt="" id="image" width="210px" height="280px">
                                </div>
                                <div class="mt-3">
                                    <p class="text-muted">Spare part name</p>
                                    <h5 class="text-primary" id="name"></h5>
                                </div>
                            </div>
                            <div class="col-md-6 text-left">
                                <div class="mt-3">
                                    <p class="text-muted">Description</p>
                                    <p class="text-primary" id="description"></p>
                                </div>
                                <div class="mt-3">
                                    <p class="text-muted">Price</p>
                                    <p class="text-primary" id="price"></p>
                                </div>
                                <div class="mt-3">
                                    <p class="text-muted">Category</p>
                                    <p class="text-primary" id="category"></p>
                                </div>
                                <div class="mt-3">
                                    <p class="text-muted">Brand</p>
                                    <p class="text-primary" id="brand"></p>
                                </div>
                                <div class="mt-3">
                                    <p class="text-muted">Model</p>
                                    <p class="text-primary" id="model"></p>
                                </div>
                            </div>
                            <div class="mx-auto mt-3">
                                <button id="edit-spare-part-btn" class="btn btn-sm btn-outline-primary font-weight-medium mx-auto">
                                    <i class="mdi mdi-grease-pencil"></i> Edit
                                </button>
                                <button id="delete-spare-part-btn" class="btn btn-sm btn-outline-danger font-weight-medium mx-auto">
                                    <i class="mdi mdi-delete"></i> Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card text-left" id="edit-spare-part-card" style="display: none;">
                    <div class="card-body">
                        <h1 class="card-title">Edit spare part</h1>
                        <form class="pt-3" id="update-spare-part-form" action="../logic/update-spare-part-logic.php" method="post" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="hidden" id="spare-part-id">
                                    <div class="form-group">
                                        <label for="spare-part-name">Spare Part Name</label>
                                        <input type="text" class="form-control" id="spare-part-name" name="spare_part_name" placeholder="Enter Spare Part Name" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="spare-part-category">Spare part Category</label>
                                        <select id="spare-part-category" class="form-control form-control-lg" name="category" required>
                                            <option value=""></option>

                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="price">Price</label>
                                        <input type="number" class="form-control" id="spare-part-price" name="price" placeholder="Enter Price" required>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div>
                                                <label for="image-upload">Select Image:</label>
                                                <input type="file" class="form-control" id="image-upload" name="image" accept="image/*">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div id="image-preview-container">
                                                <img id="image-preview" src="" alt="Image Preview"  width="134px" height="186px">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea class="form-control" id="spare-part-description" name="description" placeholder="Enter Description" rows="9"></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="spare-part-car_brand">Car brand</label>
                                        <select id="spare-part-car_brand" class="form-control form-control-lg" name="car_brand_id">
                                            <option value=""></option>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="spare-part-car_model">Car model</label>
                                        <select id="spare-part-car_model" class="form-control form-control-lg" name="car_model_id">
                                            <option value=""></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <button id="save-btn" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" name="save">SAVE</button>
                            </div>
                        </form>
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
<script src="../vendors/sweetalert/sweetalert.min.js"></script>
<script src="../js/off-canvas.js"></script>
<script src="../js/hoverable-collapse.js"></script>
<script src="../js/template.js"></script>
<script src="../js/settings.js"></script>
<script src="../js/todolist.js"></script>
<script src="../js/dashboard.js"></script>
<script>
    // Display card on button click
    document.addEventListener("DOMContentLoaded", function() {
        // Get the edit-spare-part-btn and edit-spare-part-card elements
        const editProfileBtn = document.getElementById("edit-spare-part-btn");
        const userProfileCard = document.getElementById("edit-spare-part-card");

        // Add click event listener to the edit-spare-part-btn
        editProfileBtn.addEventListener("click", function() {
            // Toggle the visibility of the edit-spare-part-card
            userProfileCard.style.display = userProfileCard.style.display === "none" ? "block" : "none";
        });
    });

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

    // Listen for changes in the file input
    document.getElementById('image-upload').addEventListener('change', function() {
        previewImage(this);
    });

    // Function to populate the car model dropdown with the provided data
    function populateCarModels(carModels, selectedCarModelId) {
        var carModelSelect = $("#spare-part-car_model");
        carModelSelect.empty();
        carModelSelect.append("<option value=''>Select car model</option>");

        carModels.forEach(function(model) {
            // Add each car model as an option to the select field
            carModelSelect.append("<option value='" + model.car_model_id + "'>" + model.model_name + "</option>");
        });

        // Set the selected car model if available
        if (selectedCarModelId) {
            carModelSelect.val(selectedCarModelId);
        }

        // Enable the car model dropdown
        carModelSelect.removeAttr("disabled");
    }

    // On car brand change, fetch the related car models and update the dropdown
    $("#spare-part-car_brand").change(function() {
        var selectedBrand = $(this).val();
        var carModelSelect = $("#spare-part-car_model");

        if (selectedBrand !== "") {
            $.ajax({
                url: "../logic/get-car-models-logic.php",
                type: "GET",
                data: {
                    car_brand_id: selectedBrand
                },
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        var carModels = response.car_models;
                        var selectedCarModelId = response.data.car_model_id;
                        populateCarModels(carModels, selectedCarModelId);
                    } else {
                        swal("Error", response.message, "error");
                        carModelSelect.empty().attr("disabled", true);
                    }
                },
                error: function(xhr, status, error) {
                    swal("Error", "An error occurred while fetching the car models: " + error, "error");
                    carModelSelect.empty().attr("disabled", true);
                }
            });
        } else {
            // Clear and disable the car model dropdown when no brand is selected
            carModelSelect.empty().attr("disabled", true);
        }
    });


    $(document).ready(function() {
        var carModelId;
        // Fetch spare part details
        <?php
        if (isset($_GET['sparepart_id'])) {
            $sparepart_id = filter_input(INPUT_GET, 'spare_part_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        ?>
            $.ajax({
                url: "../logic/get-spare-part-details.php",
                type: "GET",
                data: {
                    sparepart_id: "<?= $sparepart_id; ?>"
                },
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        carModelId = response.data.car_model_id;

                        $("#name").text(response.data.name);
                        $("#description").text(response.data.description);
                        $("#price").text(response.data.price);
                        $("#category").text(response.data.category_name);
                        $("#brand").text(response.data.brand_name);
                        $("#model").text(response.data.model_name);
                        $("#id").text(response.data.sparepart_id);
                        $("#spare-part-id").val(response.data.sparepart_id);
                        $("#spare-part-name").val(response.data.name);
                        $("#spare-part-description").val(response.data.description);
                        $("#spare-part-price").val(response.data.price);
                        $("#spare-part-category").val(response.data.category_id);
                        $("#spare-part-car_brand").val(response.data.car_brand_id);
                        $("#spare-part-car_model").val(response.data.car_model_id);
                        $("#image").attr("src", "../uploads/" + response.data.image);

                        $("#spare-part-card").show();

                        // Update carModelId with the response value
                        var carModelId = response.data.car_model_id;

                        // Fetch spare parts categories
                        $.ajax({
                            url: "../logic/spare-parts-category-logic.php",
                            type: "GET",
                            dataType: "json",
                            success: function(categoryResponse) {
                                if (categoryResponse.status === "success") {
                                    var categories = categoryResponse.categories;
                                    var selectField = $("#spare-part-category");
                                    selectField.empty();
                                    selectField.append("<option value=''>Select category of spare part</option>");

                                    categories.forEach(function(category) {
                                        // Add each category as an option to the select field
                                        selectField.append("<option value='" + category.category_id + "'>" + category.category_name + "</option>");
                                    });

                                    // Add the specific spare part category as an option with a selected attribute
                                    selectField.append("<option value='" + response.data.category_id + "' selected>" + response.data.category_name + "</option>");

                                    selectField.removeAttr("disabled");
                                } else {
                                    swal("Error", categoryResponse.message, "error");
                                }
                            },
                            error: function(xhr, status, error) {
                                swal("Error", "An error occurred while fetching categories: " + error, "error");
                            }
                        });

                        // Fetch car brands
                        $.ajax({
                            url: "../logic/get-car-brands-logic.php",
                            type: "GET",
                            dataType: "json",
                            success: function(brandResponse) {
                                if (brandResponse.status === "success") {
                                    var carBrands = brandResponse.car_brands;
                                    var selectField = $("#spare-part-car_brand");
                                    selectField.empty();
                                    selectField.append("<option value=''>Select car brand</option>");

                                    carBrands.forEach(function(brand) {
                                        // Add each car brand as an option to the select field
                                        selectField.append("<option value='" + brand.car_brand_id + "'>" + brand.brand_name + "</option>");
                                    });

                                    // Add the specific spare part car brand as an option with a selected attribute
                                    selectField.append("<option value='" + response.data.car_brand_id + "' selected>" + response.data.brand_name + "</option>");

                                    selectField.removeAttr("disabled");
                                } else {
                                    swal("Error", brandResponse.message, "error");
                                }
                            },
                            error: function(xhr, status, error) {
                                swal("Error", "An error occurred while fetching car brands: " + error, "error");
                            }
                        });

                        // Get the selected car brand ID on page load
                        var selectedBrand = response.data.car_brand_id;
                        // console.log("car brand id: " + response.data.car_brand_id);

                        // Function to fetch car models based on the selected car brand
                        function fetchCarModels(selectedBrand) {
                            var carModelSelect = $("#spare-part-car_model");
                            if (selectedBrand !== "") {
                                $.ajax({
                                    url: "../logic/get-car-models-logic.php",
                                    type: "GET",
                                    data: {
                                        car_brand_id: selectedBrand
                                    },
                                    dataType: "json",
                                    success: function(response) {
                                        if (response.status === "success") {
                                            var carModels = response.car_models;
                                            carModelSelect.empty();
                                            carModelSelect.append("<option value=''>Select car model</option>");

                                            carModels.forEach(function(model) {
                                                // Add each car model as an option to the select field
                                                carModelSelect.append("<option value='" + model.car_model_id + "'>" + model.model_name + "</option>");
                                            });

                                            // console.log("car model id : " + carModelId);

                                            // Set the default car model if available
                                            var defaultCarModelId = carModelId
                                            if (defaultCarModelId) {
                                                carModelSelect.val(defaultCarModelId);
                                            }

                                            // Enable the car model dropdown
                                            carModelSelect.removeAttr("disabled");
                                        } else {
                                            swal("Error", response.message, "error");
                                            carModelSelect.empty().attr("disabled", true);
                                        }
                                    },
                                    error: function(xhr, status, error) {
                                        swal("Error", "An error occurred while fetching the car models: " + error, "error");
                                        carModelSelect.empty().attr("disabled", true);
                                    }
                                });
                            } else {
                                // Clear and disable the car model dropdown when no brand is selected
                                carModelSelect.empty().attr("disabled", true);
                            }
                        }

                        // Fetch car models on page load
                        fetchCarModels(selectedBrand);

                        // Event listener to fetch car models when the car brand selection changes
                        $("#spare-part-car_brand").change(function() {
                            selectedBrand = $(this).val();
                            fetchCarModels(selectedBrand);
                        });

                    } else {
                        swal("Error", response.message, "error");
                    }
                },
                error: function(xhr, status, error) {
                    swal("Error", "An error occurred while fetching spare part details: " + error, "error");
                }
            });
        <?php
        }
        ?>

        // Update spare part item
        $("#save-btn").click(function(e) {
            e.preventDefault();

            // Get form inputs
            var sparePartId = $("#spare-part-id").val().trim();
            var sparePartName = $("#spare-part-name").val().trim();
            var sparePartDescription = $("#spare-part-description").val().trim();
            var sparePartPrice = $("#spare-part-price").val().trim();
            var sparePartCategory = $("#spare-part-category").val().trim();
            var sparePartCarBrand = $("#spare-part-car_brand").val().trim();
            var sparePartCarModel = $("#spare-part-car_model").val().trim();
            // var sparePartImage = $("#image-upload")[0].files[0];

            var sparePartImageElement = $("#image-upload");
            var sparePartImage = null;

            if (sparePartImageElement.length > 0 && sparePartImageElement[0].files.length > 0) {
                sparePartImage = sparePartImageElement[0].files[0];

                // Validate the image only if it's uploaded
                var allowedExtensions = /(\.png|\.jpeg|\.jpg)$/i;
                if (!allowedExtensions.exec(sparePartImage.name)) {
                    swal("Error", "Invalid image file. Allowed extensions are PNG, JPEG, and JPG.", "error");
                    return;
                }
            }

            if (sparePartName === "") {
                swal("Error", "Please enter spare part name.", "error");
                return;
            }
            if (sparePartPrice === "") {
                swal("Error", "Please enter spare part price.", "error");
                return;
            }
            if (!/^\d+(\.\d{2})?$/.test(sparePartPrice)) {
                swal("Error", "Price should be a number with no more than two decimal places.", "error");
                return;
            }
            if (sparePartCategory === "") {
                swal("Error", "Please enter spare part category.", "error");
                return;
            }
            if (sparePartDescription.length > 500) {
                swal("Error", "Description should not exceed 500 characters.", "error");
                return;
            }

            var formData = new FormData();
            formData.append('car_brand_id', sparePartCarBrand);
            formData.append('car_model_id', sparePartCarModel);
            formData.append('spare_part_id', sparePartId);
            formData.append('spare_part_name', sparePartName);
            formData.append('category', sparePartCategory);
            formData.append('price', sparePartPrice);
            formData.append('description', sparePartDescription);
            formData.append('image', sparePartImage);

            $.ajax({
                url: "../logic/update-spare-part-logic.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "json",
                success: function(response) {
                    if (response.status === 'success') {
                        $("#update-spare-part-form")[0].reset();
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

        // Delete spare part item
        $("#delete-spare-part-btn").click(function(e) {
            e.preventDefault();
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this spare part!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then(function(willDelete) {
                if (willDelete) {
                    $.ajax({
                        url: "../logic/delete-spare-part.php",
                        type: "POST",
                        data: {
                            sparepart_id: "<?php echo $sparepart_id; ?>"
                        },
                        dataType: "json",
                        success: function(response) {
                            if (response.status === "success") {
                                swal("Success", response.message, "success").then(function() {
                                    window.location.href = "../Spare-parts/view-spare-parts.php";
                                });
                            } else {
                                swal("Error", response.message, "error");
                            }
                        },
                        error: function(xhr, status, error) {
                            swal("Error", "An error occurred while deleting the spare part: " + error, "error");
                        },
                    });
                }
            });
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