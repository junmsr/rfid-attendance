<?php
// update_process.php

// Database connection
$conn = mysqli_connect("localhost", "root", "", "attendance");
if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $rfid = $_POST['rfid'];
    $role = $_POST['role'];
    $surname = $_POST['surname'];
    $fname = $_POST['fname'];
    $contact = $_POST['contact'];
    $gender = $_POST['gender'];

    // Prepare the SQL update statement
    $sql = "UPDATE logs SET position=?, surname=?, fname=?, contact=?, gender=? WHERE rfid=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $role, $surname, $fname, $contact, $gender, $rfid);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to the faculties page after successful update
        header("Location: faculties.php");
        exit(); // Make sure to exit after redirecting
    } else {
        echo "Error updating record: " . $conn->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Directory where you want to save the uploaded files
    $targetDir = "uploads/"; // Ensure this directory exists and is writable
    $targetFile = $targetDir . basename($_FILES["upload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["upload"]["tmp_name"]);
    if ($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check if file already exists
    if (file_exists($targetFile)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size (optional)
    if ($_FILES["upload"]["size"] > 500000) { // Limit to 500KB
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // If everything is ok, try to upload file
        if (move_uploaded_file($_FILES["upload"]["tmp_name"], $targetFile)) {
            echo "The file " . htmlspecialchars(basename($_FILES["upload"]["name"])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>