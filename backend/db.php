<?php

$host = "localhost";
$user = "root";
$password = "";
$database = "brandingwaale";

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}



// server
// <?php

// $host = "localhost";
// $user = "branding_branding";
// $password = "branding@123";
// $database = "branding_brandingwaale";

// $conn = mysqli_connect($host, $user, $password, $database);

// if (!$conn) {
//     die("Database Connection Failed: " . mysqli_connect_error());
// }
