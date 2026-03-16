<?php
session_start();
include 'db.php';

$alertmsg = '';

if (isset($_POST['submit'])) {

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $res = mysqli_query($conn, "SELECT * FROM `user` WHERE `username`='$username'");

    if (mysqli_num_rows($res) > 0) {

        $row = mysqli_fetch_assoc($res);

        if (password_verify($password, $row['password'])) {

            $_SESSION['user'] = $row['userid'];
            $_SESSION['type'] = 'Admin';

            header("Location: dashboard.php");
            exit;
        } else {
            $alertmsg = "<div class='alert error'>Wrong Password</div>";
        }
    } else {
        $alertmsg = "<div class='alert error'>User With This Username Does Not Exist</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - brandingwaale</title>

    <link
        href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@400;500;600;700&family=DM+Sans:wght@400;500;600&display=swap"
        rel="stylesheet">

    <link href="assets/css/style.css" rel="stylesheet">

    <style>
        /* ================= BODY ================= */
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135 deg, #1a1a1a, #000000 70%);
            color: var(--text-primary);
        }
    </style>
</head>

<body>

    <div class="login-card">

        <div class="login-title">Admin Login</div>
        <div class="login-subtitle">Sign in to access the dashboard</div>

        <?= $alertmsg ?>

        <form method="POST">

            <div class="form-group">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-input" placeholder="Enter your username" required>
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-input" placeholder="••••••••" required>
            </div>

            <button type="submit" name="submit" class="login-btn">
                Sign In
            </button>

        </form>

        <div class="login-footer">
            © <?= date('Y') ?> brandingwaale. All rights reserved.
        </div>

    </div>

</body>

</html>