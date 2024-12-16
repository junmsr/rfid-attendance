<?php
// Database connection parameters
$host = 'localhost'; // or your database host
$db = 'attendance'; // your database name
$user = 'root'; // your database username
$pass = ''; // your database password

// Create a connection to the database
$conn = new mysqli($host, $user, $pass, $db);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize an array to hold the summary data
$summary = [];

// Query to get the total number of faculties
$totalQuery = "SELECT COUNT(*) as total FROM logs";
$result = $conn->query($totalQuery);
if ($result) {
    $row = $result->fetch_assoc();
    $summary['total'] = $row['total'];
} else {
    $summary['total'] = 0; // Default to 0 if query fails
}

// Query to get the number of male faculties
$maleQuery = "SELECT COUNT(*) as male FROM logs WHERE gender = 'male'";
$result = $conn->query($maleQuery);
if ($result) {
    $row = $result->fetch_assoc();
    $summary['male'] = $row['male'];
} else {
    $summary['male'] = 0; // Default to 0 if query fails
}

// Query to get the number of female faculties
$femaleQuery = "SELECT COUNT(*) as female FROM logs WHERE gender = 'female'";
$result = $conn->query($femaleQuery);
if ($result) {
    $row = $result->fetch_assoc();
    $summary['female'] = $row['female'];
} else {
    $summary['female'] = 0; // Default to 0 if query fails
}

// Close the database connection
$conn->close();

// Return the summary data as JSON
header('Content-Type: application/json');
echo json_encode($summary);
?>