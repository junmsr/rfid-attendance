<?php
// Check if the form was submitted
if (isset($_POST['updateButton'])) {
    // Capture data from the form
    $newData = $_POST['dataToUpdate'];

    // Example: Update the database (replace with your actual DB connection and update logic)
    $conn = new mysqli("localhost", "username", "", "attendance");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Example SQL query (update query)
    $sql = "UPDATE logs SET rfid = ? WHERE rfid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $newData, $conditionValue);

    // Execute the update
    if ($stmt->execute()) {
        echo "Record updated successfully.";
    } else {
        echo "Error updating record: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>