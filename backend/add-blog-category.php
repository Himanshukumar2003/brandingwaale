<?php
error_reporting(0);
session_start();
include 'db.php';
$alertmsg = '';
$link = 'Blogs Category';

if (isset($_POST['submit'])) {
    extract($_POST);
    $date = date('Y-m-d');
    $slug = strtolower($blog_name);
    $slug = preg_replace('/[^a-z0-9\s-]/', '', $slug);
    $slug = preg_replace('/\s+/', '-', $slug);
    $slug = trim($slug, '-');
    $title = mysqli_real_escape_string($conn, $title);
    $description = mysqli_real_escape_string($conn, $description);
    $keywords = mysqli_real_escape_string($conn, $keywords);
    $getslug = mysqli_query($conn, "SELECT `slug` FROM `blog_category` WHERE `slug` = '$slug'");
    if (mysqli_num_rows($getslug) > 0) {
        $alertmsg = '<sl-alert variant="danger" open duration="1500" closable>
                  <span class="mdi mdi-alpha-x-circle-outline"></span>                
                  Category Already Exists
                </sl-alert>';
    } else {
        $date = date("Y-m-d H:i:s");
        $query = mysqli_query($conn, "INSERT INTO `blog_category`(`category`,`slug`,`title`,`description`,`keyword`,`date`) VALUES ('$blog_name','$slug','$title','$description','$keywords','$date')");
        if ($query) {
            $alertmsg = '<sl-alert variant="success" open duration="1500" closable>
                    <span class="mdi mdi-check-circle-outline"></span>                  
                    Blog Category Added Successfully
                  </sl-alert>';
        } else {
            $alertmsg = '<sl-alert variant="danger" open duration="1500" closable>
                    <span class="mdi mdi-alpha-x-circle-outline"></span>
                    Oops Something Went Wrong
                  </sl-alert>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Blog</title>
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@shoelace-style/shoelace@2.0.0-beta.83/dist/themes/light.css" />



</head>

<body>
    <div class="sl-toast-stack">
        <?php
        echo $alertmsg;
        ?>
    </div>
    <?php include('sidenav.php') ?>
    <section class="main-content">
        <h2>Add Blog</h2>

        <form class="pt-0 row g-3 mt-3" method="post">
            <div class="col-lg-6 col-xl-6 col-12 mb-3 mt-0">
                <div class="input-group input-group-merge">
                    <div class="form-floating form-floating-outline">
                        <input type="text" id="title" name="blog_name" class="form-control" placeholder="My Category"
                            aria-label="My Category" aria-describedby="basicPost2" required />
                        <label for="title">Blog Category</label>
                    </div>
                </div>
            </div>
            <?php include 'seo.php'; ?>
            <div class="col-sm-12">
                <button type="submit" name="submit" class="btn btn-primary data-submit me-sm-3 me-1">Submit</button>
            </div>
        </form>
    </section>

</body>

</html>