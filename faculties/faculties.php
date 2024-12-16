<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../admin/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Document</title>
</head>
<body>
    <div class="container" id="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="">
                        <span class="icon">
                            <img src="../assets/BISCAST.png" alt="#" width="60px" height="auto">
                        </span>
                        <span class="title">Attendance System</span>
                    </a>
                </li>
                <li>
                    <a href="../admin/admin.php">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <span class="icon">
                            <ion-icon name="people-outline"></ion-icon>
                        </span>
                        <span class="title">Faculties</span>
                    </a>
                </li>
                <li>
                    <a href="attendance.php">
                        <span class="icon">
                            <ion-icon name="calendar-outline"></ion-icon>
                        </span>
                        <span class="title">Attendance Log</span>
                    </a>
                </li>
                <li>
                    <a href="../main/index.php">
                        <span class="icon">
                            <ion-icon name="log-out-outline"></ion-icon>
                        </span>
                        <span class="title">Sign Out</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="main">
        <div class="topbar">
            <div class="toggle">
                <ion-icon name="grid-outline"></ion-icon>
            </div>
            <div class="title">
                <h1>Faculties</hassistant></h1>
            </div>
            <div class="new">
                <button class="add-new" id="new-faculty"><ion-icon name="person-add-outline"></ion-icon>New</button>
            </div>
        </div>
        
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>RFID</th>
                        <th>Role</th>
                        <th>Surname</th>
                        <th>First Name</th>
                        <th>Contact #</th>
                        <th>Gender</th>
                        <th>Setting</th>
                    </tr>
                </thead>
                <img src="" alt="">

                <?php
                $conn = mysqli_connect("localhost", "root", "", "attendance");
                if(!$conn){
                    die("Connection failed: ".$conn-> connect_error);
                }
                $sql = "SELECT rfid, position, surname, fname, contact, gender from logs";
                $result = $conn-> query($sql);

                if($result-> num_rows > 0){
                    while($row = $result-> fetch_assoc()){
                        echo "<tbody>
                            <tr>
                                <td>".$row["rfid"]."</td>
                                <td>".$row["position"]."</td>
                                <td>".$row["surname"]."</td>
                                <td>".$row["fname"]."</td>
                                <td>".$row["contact"]."</td>
                                <td>".$row["gender"]."</td>
                                <td>
                                    <a href='delete.php?id=".$row['rfid']."' class='btn delete' onclick='return confirm(\"Are you sure you want to delete this record?\");'>
                                        <i class='fas fa-trash-alt'></i> Delete
                                    </a>
                                    <a href='#' class='btn update' onclick=\"openModal('".$row['rfid']."', '".$row['position']."', '".$row['surname']."', '".$row['fname']."', '".$row['contact']."', '".$row['gender']."'); return false;\">
                                        <i class='fas fa-edit'></i> Update
                                    </a>
                                </td>
                            </tr>
                        </tbody>";
                    }
                }
                ?>
                <!-- <tbody>
                    <tr>
                        <td data-label="RFID" id="rfid-tb"></td>
                        <td data-label="Role" id="role-tb"></td>
                        <td data-label="Surname" id="surname-tb"></td>
                        <td data-label="First Name" id="fname-tb"></td>
                        <td data-label="Contact #" id="contact-tb"></td>
                        <td data-label="Gender" id="gender-tb"></td>
                        <td data-label="Setting" id="setting-tb"></td>
                    </tr>
                </tbody> -->
            </table>
        </div>

        <!-- Update Modal -->
        <!-- Update Modal -->
        <div class="modal" id="updateModal">
            <div class="modal-content">
                <span class="close" id="closeModal">&times;</span>
                <form method="POST" id="updateForm" action="update_process.php">
                    <div class="modal-header">
                        <h2>Update Faculty</h2>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="rfid" id="rfid">
                        <div class="input-box">
                            <label for="role">Role:</label>
                            <input type="text" id="role" name="role" required>
                        </div>
                        <div class="input-box">
                            <label for="surname">Surname:</label>
                            <input type="text" id="surname" name="surname" required>
                        </div>
                        <div class="input-box">
                            <label for="fname">First Name:</label>
                            <input type="text" id="fname" name="fname" required>
                        </div>
                        <div class="input-box">
                            <label for="contact">Contact No:</label>
                            <input type="text" id="contact" name="contact" required>
                        </div>
                        <div class="input-box">
                            <label for="gender">Gender:</label>
                            <select id="gender" name="gender" required>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="n/a">Prefer not to say</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="updateButton">Update</button>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="container-form" id="form-container">
            <div class="close-btn" id="btn-close">&times;</div>
            <form  method="POST" id="form" enctype="multipart/form-data">
                <div class="title-form">Register</div>
                <div class="user-details">
                    <div class="input-box">
                        <span class="details" id="rfid">ID tag</span>
                        <input type="text" id="rfid-tag" placeholder="ID tag" name="rfid-tag" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Role</span>
                        <input type="text" id="role" placeholder="Role" name="role" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Surname</span>
                        <input type="text" id="surname" placeholder="Enter your Surname" name="surname" required>
                    </div>
                    <div class="input-box">
                        <span class="details">First Name</span>
                        <input type="text" id="fname" placeholder="Enter your First Name" name="fname" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Contact No.</span>
                        <input type="text" id="contact" placeholder="Contact Number" name="contact" required>
                    </div>
                    <br>
                    <div class="photo">
                        <p>Upload a photo</p>
                        <!-- <span class="details">Upload an image</span> -->
                        <input type="file" accept="image/jpeg, image/png, image/jpg" id="upload">
                        <label for="upload">Choose</label>
                    </div>
                </div>
                <div class="gender-details">
                    <input type="radio" name="gender" id="dot-1" value="male">
                    <input type="radio" name="gender" id="dot-2" value="female">
                    <input type="radio" name="gender" id="dot-3" value="n/a">
                    <span class="gender-title">Gender</span>
                    <div class="category">
                        <label for="dot-1">
                            <span class="dot one"></span>
                            <span class="gender">Male</span>
                        </label>
                        <label for="dot-2">
                            <span class="dot two"></span>
                            <span class="gender">Female</span>
                        </label>
                        <label for="dot-3">
                            <span class="dot three"></span>
                            <span class="gender">Prefer not to say</span>
                        </label>
                    </div>
                    <div class="button-reg">
                        <input type="submit" id="register" value="Register" onclick="window.open('faculties.php', '_blank';location.reload();">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Get the modal
        var modal = document.getElementById("updateModal");

        // Get the <span> element that closes the modal
        var span = document.getElementById("closeModal");

        // Function to open the modal and populate it with data
        function openModal(rfid, role, surname, fname, contact, gender) {
            document.getElementById("rfid").value = rfid;
            document.getElementById("role").value = role;
            document.getElementById("surname").value = surname;
            document.getElementById("fname").value = fname;
            document.getElementById("contact").value = contact;
            document.getElementById("gender").value = gender;
            modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        $("#register").click(function() {
            $.ajax({
                url: "logs.php",
                type: "POST",
                data: $("#form").serialize(),
                success: function(response) {
                    console.log("Server Response: ", response); // Log response for debugging
                    $("#response").html(response);
                    window.location.reload();
                },
                error: function(xhr, status, error) {
                    console.error("AJAX Error: ", error);
                    console.error("XHR Response: ", xhr.responseText); // Log server response
                }
            });
        });
    </script>
    
    <script src="faculty.js"></script>
    <script src="../admin/admin.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>