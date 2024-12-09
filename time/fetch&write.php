<?php
// Database credentials
$host = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbname = "attendance";

// Connect to the database
$conn = new mysqli($host, $dbUsername, $dbPassword, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Database connection failed: " . $conn->connect_error]);
    exit;
}

// Check if RFID tag is provided
if (isset($_POST['rfid_tag']) && !empty($_POST['rfid_tag'])) {
    $rfid = $_POST['rfid_tag'];
    $c_time = $_POST['time_in'];
    $c_date = $_POST['date_in'];
    $inOut = "";

    // Prepare the query to check RFID in the logs table
    $query = "SELECT position, surname, fname, contact, gender FROM logs WHERE rfid = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $rfid);
    $stmt->execute();
    $stmt->store_result();

    // Check if the RFID exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($position, $surname, $fname, $contact, $gender);
        $stmt->fetch();

        // Check the most recent in_out status in time_table for the RFID
        $checkQuery = "SELECT in_out FROM time_table WHERE rfid = ? ORDER BY time_log DESC LIMIT 1";
        $checkStmt = $conn->prepare($checkQuery);
        $checkStmt->bind_param("s", $rfid);
        $checkStmt->execute();
        $checkStmt->bind_result($lastInOut);
        $recentRecordExists = $checkStmt->fetch();
        $checkStmt->close();

        // Determine the new in_out value
        if ($recentRecordExists && $lastInOut === "in") {
            $inOut = "out";
        } else {
            $inOut = "in";
        }

        // Insert a new record into time_table
        $insertSql = "INSERT INTO time_table (rfid, position, surname, fname, contact, gender, time_log, in_out, date_log) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $insertStmt = $conn->prepare($insertSql);
        $insertStmt->bind_param("sssssssss", $rfid, $position, $surname, $fname, $contact, $gender, $c_time, $inOut, $c_date);
        
        if ($insertStmt->execute()) {
            $response = [
                "success" => true,
                "position" => $position,
                "surname" => $surname,
                "fname" => $fname,
                "contact" => $contact,
                "gender" => $gender,
                "c_time" => $c_time,
                "inOut" => $inOut,
                "c_date" => $c_date
            ];
        } else {
            $response = ["success" => false, "message" => "Failed to insert new record."];
        }

        $insertStmt->close();
    } else {
        $response = ["success" => false, "message" => "RFID not found in the database."];
    }

    $stmt->close();
} else {
    $response = ["success" => false, "message" => "No RFID tag provided."];
}

$conn->close();

// Send the final JSON response
echo json_encode($response);
?>