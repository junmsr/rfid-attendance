<?php
$conn = mysqli_connect("localhost", "root", "", "attendance");
if (!$conn) {
    die("Connection failed: " . $conn->connect_error);
}

// Modify the SQL query to order by date_log in descending order
$sql = "SELECT rfid, position, surname, fname, contact, gender, time_log, in_out, date_log 
        FROM time_table 
        ORDER BY date_log DESC, time_log DESC"; // Order by date_log and time_log in descending order
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row["rfid"]) . "</td>
                <td>" . htmlspecialchars($row["position"]) . "</td>
                <td>" . htmlspecialchars($row["surname"]) . "</td>
                <td>" . htmlspecialchars($row["fname"]) . "</td>
                <td>" . htmlspecialchars($row["contact"]) . "</td>
                <td>" . htmlspecialchars($row["gender"]) . "</td>
                <td>" . htmlspecialchars($row["time_log"]) . "</td>
                <td>" . htmlspecialchars($row["in_out"]) . "</td>
                <td>" . htmlspecialchars($row["date_log"]) . "</td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='9'>No records found</td></tr>";
}

$conn->close();
?>