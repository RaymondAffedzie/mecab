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
        // Fetch orders
        $.ajax({
            url: "../logic/get-orders.php",
            type: "GET",
            dataType: "json",
            success: function(response) {
                if (response.status === 'success') {
                    response.data.forEach(function(row) {
                        row.full_name = row.first_name + (row.other_names ? ' ' + row.other_names : '') + ' ' + row.last_name;
                    });
                    var dataTable = $('#orders-table').DataTable({
                        data: response.data,
                        columns: [{
                                data: 'full_name'
                            },
                            {
                                data: 'total_amount'
                            },
                            {
                                data: 'status'
                            },
                            {
                                data: 'order_date',
                                render: function(data, type, row) {
                                    if (type === 'display') {
                                        return formatDate(data);
                                    }
                                    return data;
                                }
                            },
                            {
                                data: 'order_id',
                                render: function(data, type, row) {
                                    return '<a href="order-details.php?order=' + data + '">View</a>';
                                }
                            },
                        ],
                        paging: true,
                        searching: true,
                        ordering: true,
                        pageLength: 20,
                        lengthMenu: [
                            [10, 15, 25, 30, 50, -1],
                            [10, 15, 25, 30, 50, 'All']
                        ],
                        createdRow: function(row, data, dataIndex) {
                            var status = data.status;
                            var statusClass = '';

                            if (status === 'payment received') {
                                statusClass = 'bg-primary text-white';
                            } else if (status === 'shipped') {
                                statusClass = 'bg-info text-white';
                            } else if (status === 'payment canceled') {
                                statusClass = 'bg-danger text-white';
                            } else if (status === 'confirmed') {
                                statusClass = 'bg-warning text-dark';
                            } else if (status === 'delivered') {
                                statusClass = 'bg-secondary text-white';
                            } else if (status === 'completed') {
                                statusClass = 'bg-success text-white';
                            } else if (status === 'pending payment') {
                                statusClass = 'bg-dark text-white';
                            }
                            $('td', row).eq(2).addClass(statusClass);
                        }
                    });
                } else {
                    swal("Error", response.message, "error");
                }
            },
            error: function(xhr, status, error) {
                swal("Error", "An error occurred while fetching orders: " + error, "error");
            }
        });

        // Fetch payments
        $.ajax({
            url: "../logic/get-payments.php",
            type: "GET",
            dataType: "json",
            success: function(response) {
                if (response.status === 'success') {

                    var dataTable = $('#payments-table').DataTable({
                        data: response.data,
                        columns: [
                            {
                                data: 'transaction_reference'
                            },
                            {
                                data: 'payment_amount'
                            },
                            {
                                data: 'payment_status'
                            },
                            {
                                data: 'payment_date',
                                render: function(data, type, row) {
                                    if (type === 'display') {
                                        return formatDate(data);
                                    }
                                    return data;
                                }
                            },
                            {
                                data: 'confirmation_status'
                            },
                            {
                                data: 'order_id',
                                render: function(data, type, row) {
                                    return '<a href="order-details.php?order=' + data + '">Order Details</a>';
                                }
                            },
                        ],
                        paging: true,
                        searching: true,
                        ordering: true,
                        pageLength: 20,
                        lengthMenu: [
                            [10, 15, 25, 30, 50, -1],
                            [10, 15, 25, 30, 50, 'All']
                        ],
                        createdRow: function(row, data, dataIndex) {
                            var status = data.payment_status;
                            var statusClass = '';

                            if (status === 'completed') {
                                statusClass = 'bg-success text-white';
                            } else if (status === 'pending') {
                                statusClass = 'bg-info text-white';
                            } else if (status === 'failed') {
                                statusClass = 'bg-danger text-white';
                            } else if (status === 'refunded') {
                                statusClass = 'bg-warning text-dark';
                            } 
                            $('td', row).eq(2).addClass(statusClass);
                        
                            var status = data.confirmation_status;
                            var confirmationClass = '';

                            if (status === 'true') {
                                confirmationClass = 'bg-success text-white';
                            } else if (status === 'false') {
                                confirmationClass = 'bg-secondary text-white';
                            }
                            $('td', row).eq(4).addClass(confirmationClass);
                        }
                    });
                } else {
                    swal("Error", response.message, "error");
                }
            },
            error: function(xhr, status, error) {
                swal("Error", "An error occurred while fetching payments: " + error, "error");
            }
        });

        function fetchOrderDetails() {
            <?php
            if (isset($_GET['order'])) {
                $order = filter_input(INPUT_GET, 'order', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            ?>
                $.ajax({
                    url: "../logic/get-order-details.php",
                    type: "GET",
                    data: {
                        order: "<?= $order ?>"
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.status === "success") {

                            var orderStatus = response.data[0].status;

                            const confirmBtn = $("#confirm-btn");
                            const shipBtn = $("#ship-btn");
                            const completeBtn = $("#complete-btn");

                            // Disable all buttons by default
                            confirmBtn.prop("disabled", true);
                            shipBtn.prop("disabled", true);
                            completeBtn.prop("disabled", true);

                            if (orderStatus === "payment received") {
                                // Enable the Confirm button
                                confirmBtn.prop("disabled", false);
                            }
                            if (orderStatus === "confirmed") {
                                // Enable the Ship button
                                confirmBtn.prop("disabled", true);
                                shipBtn.prop("disabled", false);
                            }
                            if (orderStatus === "delivered") {
                                completeBtn.prop("disabled", false);
                            }

                            $("#status").text(orderStatus);
                            $("#totalAmount").text('₵ ' + response.data[0].total_amount);
                            $("#city").text(response.data[0].city);
                            $("#region").text(response.data[0].region + ' region');
                            $("#gps_address").text(response.data[0].gps_address);
                            $("#full_name").text(response.data[0].first_name + ' ' + response.data[0].other_names + ' ' + response.data[0].last_name);
                            $("#contact").text(response.data[0].contact);
                            $("#email").text(response.data[0].users_email);
                            $("#order_date").text(formatDate(response.data[0].order_date));
                            $("#order").val(response.data[0].order_id);

                            var dataTable = $('#order-items-table').DataTable({
                                data: response.data,
                                columns: [{
                                        data: 'name'
                                    },
                                    {
                                        data: 'item_price'
                                    },
                                    {
                                        data: 'quantity'
                                    }, {
                                        data: 'subtotal'
                                    }
                                ],
                                paging: true,
                                searching: true,
                                ordering: true,
                                pageLength: 10,
                                lengthMenu: [
                                    [10, 15, 25, 30, 50, -1],
                                    [10, 15, 25, 30, 50, 'All']
                                ],
                            });
                        }
                    }
                });
            <?php
            }
            ?>
        }

        fetchOrderDetails();

        function daySuffix(day) {
            if (day >= 11 && day <= 13) {
                return 'th';
            }
            switch (day % 10) {
                case 1:
                    return 'st';
                case 2:
                    return 'nd';
                case 3:
                    return 'rd';
                default:
                    return 'th';
            }
        }

        function formatDate(dateTime) {
            const options = {
                hour: '2-digit',
                minute: '2-digit'
            };
            const date = new Date(dateTime);
            const day = date.getDate();
            const month = date.toLocaleDateString('en-GB', {
                month: 'long'
            });
            const year = date.getFullYear();
            const time = date.toLocaleTimeString('en-US', options);

            const formattedDate = `${day}${daySuffix(day)} ${month}, ${year}. ${time}`;
            return formattedDate;
        }

        // confirm order
        $("#confirm-btn").click(function(e) {
            e.preventDefault();
            var order = $("#order").val().trim();
            var formData = new FormData();
            formData.append('order', order);
            var url = "../logic/order-payment-confirmation.php";
            postReq(url, formData);
        });

        // ship order
        $("#ship-btn").click(function(e) {
            e.preventDefault();
            var order = $("#order").val().trim();
            var formData = new FormData();
            formData.append('order', order);
            var url = '../logic/ship-order-logic.php';
            postReq(url, formData);
        });

        // complete order
        $("#complete-btn").click(function(e) {
            e.preventDefault();
            var order = $("#order").val().trim();
            var formData = new FormData();
            formData.append('order', order);
            var url = '../logic/complete-order-logic.php';
            postReq(url, formData);
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

        /** 
         * ======= sign out ====================
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