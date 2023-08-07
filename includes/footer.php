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

<script src="vendors/js/vendor.bundle.base.js"></script>
<script src="js/jquery.js"></script>
<script src="vendors/sweetalert/sweetalert.min.js"></script>
<script src="js/off-canvas.js"></script>
<script src="js/hoverable-collapse.js"></script>
<script src="js/template.js"></script>
<script src="js/settings.js"></script>
<script src="js/todolist.js"></script>
<script src="js/dashboard.js"></script>
<script>
    $(document).ready(function() {
        // When the form is submitted
        $('#logoutForm').submit(function(e) {
            e.preventDefault(); // Prevent the default form submission

            // Perform the Ajax request
            $.ajax({
                url: "./logic/logout.php",
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


    // count down
    function countdown(endDate) {
        const targetDate = new Date(endDate).getTime();

        const timer = setInterval(() => {
            const now = new Date().getTime();
            const timeRemaining = targetDate - now;

            if (timeRemaining <= 0) {
                clearInterval(timer);
                document.getElementById("countdown").innerHTML = "Countdown expired!";
            } else {
                const days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
                const hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

                const countdownString = `${days}days ${hours}hours ${minutes}mins ${seconds}sec`;
                document.getElementById("countdown").innerHTML = countdownString;
            }
        }, 1000); // Update every second
    }

    // Example usage: Set the target date for the countdown
    const endDate = "2023-09-30T00:00:00";
    countdown(endDate);
</script>

</body>

</html>