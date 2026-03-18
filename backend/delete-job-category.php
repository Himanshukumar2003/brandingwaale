<?php
session_start();
include 'db.php';

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    mysqli_query($conn, "DELETE FROM jobs WHERE category_id = $id");
    mysqli_query($conn, "DELETE FROM job_categories WHERE id = $id");
    $_SESSION['msg'] = "Category Deleted Successfully";
}

header("Location: add-job-category.php");
exit;
