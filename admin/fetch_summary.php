<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection parameters
$host = 'localhost'; // Your database host
$db = 'your_database_name'; // Your database name
$user = 'your_username'; // Your database username
$pass = 'your_password'; // Your database password

// Create a connection to the database
$conn = new mysqli($host, $user, $pass, $db);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables to hold counts
$totalFaculties = 0;
$maleFaculties = 0;
$femaleFaculties = 0;

// Query to get the total number of faculties
$sql = "SELECT COUNT(*) as total FROM faculties";
$result = $conn->query($sql);
if ($result) {
    $row = $result->fetch_assoc();
    $totalFaculties = $row['total'];
}

// Query to get the count of male faculties
$sqlMale = "SELECT COUNT(*) as male FROM faculties WHERE gender = 'male'";
$resultMale = $conn->query($sqlMale);
if ($resultMale) {
    $rowMale = $resultMale->fetch_assoc();
    $maleFaculties = $rowMale['male'];
}

// Query to get the count of female faculties
$sqlFemale = "SELECT COUNT(*) as female FROM faculties WHERE gender = 'female'";
$resultFemale = $conn->query($sqlFemale);
if ($resultFemale) {
    $rowFemale = $resultFemale->fetch_assoc();
    $femaleFaculties = $rowFemale['female'];
}

// Prepare the data to be returned as JSON
$data = [
    'total' => $totalFaculties,
    'male' => $maleFaculties,
    'female' => $femaleFaculties
];

// Set the content type to application/json
header('Content-Type: application/json');

// Return the JSON response
echo json_encode($data);

// Close the database connection
$conn->close();
?>