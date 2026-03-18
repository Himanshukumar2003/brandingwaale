<?php
include('backend/db.php');


$blogs = mysqli_query($conn, "SELECT * FROM blogs WHERE status='1' ORDER BY id DESC");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brandingwaale - Transform Your Business</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/viewer.css">



</head>

<body>

    <?php include 'components/navbar.php'; ?>


    <section class="section border-bottom">
        <div class="container">
            <div class="row align-items-center ">
                <div class="col-lg-6">
                    <h6 class="highlight">Blogs</h6>
                    <h1>EMPOWERING GROWTH WITH INNOVATION</h1>
                </div>
                <div class="col-lg-6">
                    <p>
                        We are pioneers in driving technological advancement and personal growth through innovative
                        solutions and exceptional work culture, fostering creativity and professional success.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <div class="section">
        <div class="container">
            <div class="row">

                <?php if (mysqli_num_rows($blogs) > 0): ?>

                    <?php while ($blog = mysqli_fetch_assoc($blogs)): ?>

                        <div class="col-md-4 mb-4">
                            <div class="blog-card">

                                <img src="backend/<?= $blog['image'] ?>"
                                    alt="<?= htmlspecialchars($blog['title']) ?>"
                                    class="blog-image img-fluid">

                                <div class="blog-content">



                                    <h5 class="blog-title">
                                        <?= htmlspecialchars($blog['heading']) ?>
                                    </h5>

                                    <p class="blog-description">
                                        <?= substr(strip_tags($blog['short_description']), 0, 100) ?>...
                                    </p>

                                    <div class="btn-section d-flex justify-content-start">
                                        <a href="blogs.php/<?= $blog['slug'] ?>"
                                            class="view-more-btn custom-btn">
                                            View More
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>

                    <?php endwhile; ?>

                <?php else: ?>

                    <div class="col-12 text-center">
                        <p>No blogs found.</p>
                    </div>

                <?php endif; ?>

            </div>
        </div>
    </div>

    <?php include 'components/footer.php'; ?>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <script src="js/index.js"></script>

</body>

</html>