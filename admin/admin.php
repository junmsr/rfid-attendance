<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://unpkg.com/react@18/umd/react.development.js" crossorigin></script>
    <script src="https://unpkg.com/react-dom@18/umd/react-dom.development.js" crossorigin></script>
    <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="dashboard.css">
    <title>Admin Dashboard</title>
</head>
<body>
    <div class="container">
        <div class="navigation">
            <ul>
                <li>
                    <a href="">
                        <span class="icon">
                            <img src="../assets/BISCAST.png" alt="#" width="60px" height="auto">
                        </span>
                        <span class="title">Admin Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="">
                        <span class="icon">
                            <ion-icon name="home-outline"></ion-icon>
                        </span>
                        <span class="title">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="../faculties/faculties.php">
                        <span class="icon">
                            <ion-icon name="people-outline"></ion-icon>
                        </span>
                        <span class="title">Faculties</span>
                    </a>
                </li>
                <li>
                    <a href="../faculties/attendance.php">
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
        </div>
        <div class="summary-container">
            <!-- Summary Report -->
            <div class="summary-card">
                <h3>Total Faculties</h3>
                <p id="total-faculties"></p>
            </div>
            <div class="summary-card">
                <h3>Male Faculties</h3>
                <p id="male-faculties"></p>
            </div>
            <div class="summary-card">
                <h3>Female Faculties</h3>
                <p id="female-faculties"></p>
            </div>

            <!-- Visualization Graph -->
            <div class="graph-container">
                <canvas id="genderChart"></canvas>
            </div>
        </div>
    </div>

    <!-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fetch summary data
            fetch('fetch_summary.php')
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log("Summary data fetched:", data); // Debug log

        document.getElementById('total-faculties').textContent = data.total || 0;
        document.getElementById('male-faculties').textContent = data.male || 0;
        document.getElementById('female-faculties').textContent = data.female || 0;

        // Render Gender Distribution Chart
        const ctx = document.getElementById('genderChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Male Faculties', 'Female Faculties'],
                datasets: [{
                    label: 'Gender Distribution',
                    data: [data.male, data.female],
                    backgroundColor: ['#3498db', '#e74c3c'],
                    hoverBackgroundColor: ['#2980b9', '#c0392b']
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    title: { display: true, text: 'Gender Distribution of Faculties' }
                }
            }
        });
    })
    .catch(error => console.error('Error fetching summary data:', error));
});
    </script>


    
    <script src="admin.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>