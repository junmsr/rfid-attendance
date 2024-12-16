<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RFID Lookup</title>
    <link rel="stylesheet" href="in-out.css"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- <script>
        // Function to Update Time and Date Dynamically
        function updateDateTime() {
            const now = new Date();
            const date = now.toLocaleDateString();
            const time = now.toLocaleTimeString();

            document.getElementById("current-date").textContent = date;
            document.getElementById("current-time").textContent = time;
        }

        // Update Every Second
        setInterval(updateDateTime, 1000);

        // Initial Call
        window.onload = updateDateTime;
    </script> -->
</head>
<body>
    <!-- Back Button -->
    <a href="../main/index.php" class="back-button">⬅ Back</a>

    <!-- Main Content -->
    <div class="container">
        <!-- Details Section -->
        <div class="details-section">
            <h2>RFID Attendance Details</h2>
            <!-- Profile Image -->
            <div class="profile-image" id="profile-image"></div>

            <!-- Real-Time Date and Time -->
            <div class="datetime-container">
                <p><strong>Date:</strong> <span id="current-date"></span></p>
                <p><strong>Time:</strong> <span id="current-time"></span></p>
            </div>

            <!-- RFID Input -->
            <label for="rfid-tag" class="label-tag">Enter RFID Tag:</label>
            <input type="text" id="rfid-tag" name="rfid-tag" placeholder="Scan or Enter RFID">

            <!-- Output Fields -->
            <div class="details-container">
                <div class="details-row">
                    <strong>Role:</strong> <span id="role"></span>
                </div>
                <div class="details-row">
                    <strong>Surname:</strong> <span id="surname"></span>
                </div>
                <div class="details-row">
                    <strong>First Name:</strong> <span id="fname"></span>
                </div>
                <div class="details-row">
                    <strong>Contact:</strong> <span id="contact"></span>
                </div>
                <div class="details-row">
                    <strong>Gender:</strong> <span id="gender"></span>
                </div>
                <div class="details-row">
                    <strong>In/Out:</strong> <span id="in_out"></span>
                </div>
            </div>
        </div>

        <!-- Attendance Table -->
        <div class="table-section" id="table-section">
            <table>
                <thead>
                    <tr>
                        <th>RFID</th>
                        <th>Role</th>
                        <th>Surname</th>
                        <th>First Name</th>
                        <th>Contact</th>
                        <th>Gender</th>
                        <th>Time</th>
                        <th>In/Out</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be populated here by AJAX -->
                </tbody>
            </table>
        </div>
    </div>

    <script src="time.js"></script>
    <script>
        // Real-time Date and Time Script
        function updateDateTime() {
            const now = new Date();
            const date = now.toLocaleDateString(); // Format: MM/DD/YYYY
            const time = now.toLocaleTimeString(); // Format: HH:MM:SS AM/PM
            document.getElementById('current-date').textContent = date;
            document.getElementById('current-time').textContent = time;
        }

        // Update the time every second
        setInterval(updateDateTime, 1000);
        updateDateTime(); // Call once to initialize immediately

        function refreshTable() {
            $.ajax({
                url: "fetch_table.php", // Path to the PHP script that fetches the latest data
                type: "GET", // Use GET method to retrieve data
                success: function(response) {
                    // Clear the existing table body
                    $("#table-section tbody").empty();

                    // Append the new data to the table
                    $("#table-section tbody").append(response);
                },
                error: function(xhr, status, error) {
                    console.error("Error fetching table data: ", error);
                }
            });
        }

        // RFID Lookup AJAX Script

        $(document).ready(function() {
        $("#rfid-tag").on('input', function() {
            var rfid = $(this).val(); // Get RFID input value
            var currentTime = new Date().toLocaleTimeString();
            var currentDate = new Date().toLocaleDateString();

            // Check if RFID tag is the expected length (e.g., 8 characters)
            if (rfid.length === 8) {
                // Send AJAX request
                $.ajax({
                    url: "fetch&write.php", // Path to the PHP script
                    type: "POST",
                    data: { 
                        rfid_tag: rfid,
                        time_in: currentTime,
                        date_in: currentDate
                    }, // Send RFID as data
                    success: function(response) {
                        try {
                            var data = JSON.parse(response); // Parse JSON response
                            if (data.success) {
                                // Populate output fields
                                $("#role").text(data.position);
                                $("#surname").text(data.surname);
                                $("#fname").text(data.fname);
                                $("#contact").text(data.contact);
                                $("#gender").text(data.gender);
                                $("#time_in").text(data.c_time);
                                $("#in_out").text(data.inOut);
                                $("#date_in").text(data.c_date);

                                refreshTable();
                            } else {
                                alert(data.message);
                            }
                        } catch (e) {
                            console.error("Error parsing response: ", e);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error: ", error);
                    }
                });

                // Clear the text field for the next input
                $(this).val('');
            }
        });
    });
    </script>
</body>
</html>