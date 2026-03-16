<?php
include('db.php');
$link = 'dashboard';

$city = mysqli_query($conn, "select count(id) from city");
if ($city->num_rows > 0) {
    $city = mysqli_fetch_assoc($city)['count(id)'];
} else {
    $city = 0;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>brandingwaale</title>
    <link rel="stylesheet" href="assets/css/style.css" />

</head>

<body>
    <div class="dashboard-container">
        <button class="mobile-menu-btn" onclick="toggleSidebar()">☰</button>

        <!-- Sidebar -->
        <?php include('sidenav.php') ?>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Dashboard Section -->
            <div id="dashboard-section" class="section">
                <div class="header">
                    <h1>Welcome back, Admin</h1>
                    <p>Here's what's happening with your website today.</p>
                </div>

                <div class="stats-grid">
                    <div class="stat-card">
                        <h3><?= $city ?></h3>
                        <p>Total city Have Created</p>
                    </div>
                </div>
            </div>
</body>

</html>