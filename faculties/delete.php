<?php
$id = $_GET['id'];
//Connect DB
//Create query based on the ID passed from you table
//query : delete where Staff_id = $id
// on success delete : redirect the page to original page using header() method
$dbname = "attendance";
$conn = mysqli_connect("localhost", "root", "", $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// sql to delete a record
$sql = "DELETE FROM logs WHERE rfid = '$id'"; 

if (mysqli_query($conn, $sql)) {
    mysqli_close($conn);
    //If book.php is your main page where you list your all records
    header('Location: faculties.php'); 
    exit;
} else {
    echo "Error deleting record";
}
?>