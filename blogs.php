<?php
include('backend/db.php');

/* GET SLUG FROM URL */
$request = $_SERVER['REQUEST_URI'];
$slug = basename(parse_url($request, PHP_URL_PATH));

/* FETCH BLOG */
$slug = mysqli_real_escape_string($conn, $slug);

$query = mysqli_query($conn, "SELECT * FROM blogs WHERE slug='$slug' AND status='1'");

if (mysqli_num_rows($query) == 0) {
    echo "Blog not found";
    exit;
}

$data = mysqli_fetch_assoc($query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- SEO -->
    <title><?php echo htmlspecialchars($data['title']); ?> </title>
    <meta name="description" content="<?php echo htmlspecialchars($data['description']); ?>">
    <meta name="keywords" content="<?php echo htmlspecialchars($data['keyword']); ?>">

    <!-- Open Graph -->
    <meta property="og:title" content="<?php echo htmlspecialchars($data['title']); ?>">
    <meta property="og:description" content="<?php echo htmlspecialchars($data['description']); ?>">
    <meta property="og:image" content="https://brandingwaale.com/<?php echo $data['image']; ?>">
    <meta property="og:type" content="article">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="/css/viewer.css">

    <style>
        body {
            /* background-color: var(--darker-bg); */
            font-family: 'Manrope', sans-serif;
            color: white;
            background-color: #1E1E1E;

        }

        .featured-image {
            position: relative;
            margin-bottom: 20px;
        }

        .featured-image img {
            width: 100%;
            height: auto;
            margin-bottom: 20px;
            border-radius: 20px;
        }

        .image-meta {
            color: var(--accent-color);
            margin-top: 8px;
        }

        .content-list {
            padding-left: 20px;
            margin-bottom: 20px;
            list-style-type: disc;
        }

        .content-list li {
            margin-bottom: 10px;
        }

        /* Quote Box */
        .quote-box {
            background-color: var(--accent-color);
            border-left: 4px solid var(--accent-color);
            padding: 20px;
            border-radius: 5px;
            margin-left: 15px;
        }

        .quote-box h5 {
            font-weight: 600;
            margin-bottom: 15px;
        }

        .quote-list {
            padding-left: 20px;
            margin-bottom: 0;
        }

        .quote-list li {
            margin-bottom: 10px;
            list-style-type: disc;
        }

        /* Sidebar */
        .sidebar {
            border-radius: 10px;
            border: 1px solid #313131;
            padding: 25px 0 0px 0;
            position: sticky;
            top: 0;
            background: #101010;
            padding: 20px;
        }

        /* Search Bar */
        .search-input {
            background-color: #1e1e1e;
            border: 1px solid #333;
            color: #e0e0e0;
            padding: 10px 15px;
        }

        .search-input:focus {
            background-color: #1e1e1e;
            border-color: #444;
            color: #e0e0e0;
            box-shadow: none;
        }

        .search-input::placeholder {
            color: #888;
        }

        .search-btn {
            background-color: #1e1e1e;
            border: 1px solid #333;
            color: #888;
        }

        .search-btn:hover {
            background-color: #333;
            color: var(--accent-color);
        }

        /* Section Titles */
        .sidebar-title {
            color: #ffffff;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
            position: relative;
            padding-bottom: 10px;
        }

        .sidebar-title::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 100px;
            height: 2px;
            background-color: #444;
        }

        /* Category Links */
        .sidebar-links li {
            margin-bottom: 8px;
        }

        .sidebar-links a {
            color: #b0b0b0;
            text-decoration: none;
            transition: color 0.3s;
            display: block;
            padding: 3px 0;
        }

        .sidebar-links a:hover {
            color: var(--accent-color);
        }

        /* Popular Posts */
        .post-item {
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #2a2a2a;
        }

        .post-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .post-info {
            padding-left: 10px;
        }

        .post-title {
            font-size: 14px;
            margin-bottom: 5px;
            line-height: 1.3;
        }

        .post-title a {
            color: #b0b0b0;
            text-decoration: none;
            transition: color 0.3s;
        }

        .post-title a:hover {
            color: var(--accent-color);
        }

        .post-date {
            font-size: 12px;
            color: #777;
            display: block;
        }

        /* Tags */
        .tags-container {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .tag {
            display: inline-block;
            background-color: #1e1e1e;
            color: #b0b0b0;
            padding: 5px 10px;
            font-size: 12px;
            border-radius: 3px;
            text-decoration: none;
            transition: all 0.3s;
        }

        .tag:hover {
            background-color: #333;
            color: var(--accent-color);
        }

        /* Social Icons */
        .social-icons {
            display: flex;
            gap: 12px;
        }


        /* Responsive adjustments */
        @media (max-width: 991px) {
            .sidebar {
                margin-top: 30px;
            }
        }

        @media (max-width: 767px) {
            .content-area {
                padding: 20px;
            }



            .quote-box {
                margin-left: 0;
                margin-top: 20px;
            }
        }
    </style>

</head>

<body> <?php include 'components/navbar.php'; ?>


    <!-- HERO SECTION -->
    <section class="section border-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h6 class="highlight">Blogs</h6>
                    <h1><?php echo htmlspecialchars($data['heading']); ?></h1>
                </div>
                <div class="col-lg-6">
                    <p><?php echo htmlspecialchars($data['short_description']); ?></p>
                </div>
            </div>
        </div>
    </section>

    <!-- BLOG DETAIL -->
    <div class="section">
        <div class="container">
            <div class="row">

                <!-- MAIN CONTENT -->
                <div class="col-lg-8 content-area">

                    <div class="featured-image">
                        <img src="http://localhost/brandingwaale/backend/<?php echo $data['image']; ?>" class="img-fluid rounded-4 mb-4"
                            alt="<?php echo $data['heading']; ?>">
                        <div class="image-meta">
                            <?php echo date("j M, Y", strtotime($data['date'])); ?>
                        </div>
                    </div>

                    <h2 class="article-title">
                        <?php echo htmlspecialchars($data['heading']); ?>
                    </h2>

                    <!-- Direct echo — HTML renders properly -->
                    <div class="article-content">
                        <?php echo $data['content']; ?>
                    </div>

                </div>

                <!-- SIDEBAR -->
                <div class="col-lg-4">
                    <div class="sidebar">

                        <!-- Our Services STATIC -->
                        <div class="sidebar-section mb-4">
                            <h4 class="sidebar-title">Our Services</h4>
                            <ul class="list-unstyled sidebar-links">
                                <li><a href="marketing.php">Digital Marketing</a></li>
                                <li><a href="marketing.php">SEO &amp; Analytics</a></li>
                                <li><a href="development.php">Web Development</a></li>
                                <li><a href="branding.php">Branding</a></li>
                                <li><a href="pr-and-advertising.php">PR &amp; Advertising</a></li>
                            </ul>
                        </div>

                        <!-- Related Articles DYNAMIC -->
                        <div class="sidebar-section mb-4">
                            <h4 class="sidebar-title">Related Articles</h4>

                            <?php
                            $current_id = (int) $data['id'];
                            $related = mysqli_query($conn, "
                                SELECT id, heading, slug, image, date
                                FROM blogs
                                WHERE status = '1' AND id != $current_id
                                ORDER BY id DESC
                                LIMIT 5
                            ");

                            if ($related && mysqli_num_rows($related) > 0):
                                while ($post = mysqli_fetch_assoc($related)):
                            ?>
                                    <div class="post-item">
                                        <div class="row g-0">
                                            <div class="col-3">
                                                <img src="backend/<?php echo $post['image']; ?>"
                                                    alt="<?php echo htmlspecialchars($post['heading']); ?>"
                                                    class="post-thumb">
                                            </div>
                                            <div class="col-9">
                                                <div class="post-info">
                                                    <h6 class="post-title">
                                                        <a href="/blogs/<?php echo $post['slug']; ?>">
                                                            <?php echo htmlspecialchars($post['heading']); ?>
                                                        </a>
                                                    </h6>
                                                    <span class="post-date">
                                                        <?php echo date("M d, Y", strtotime($post['date'])); ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                endwhile;
                            else:
                                ?>
                                <p style="color:#888; font-size:14px;">No related articles found.</p>
                            <?php endif; ?>

                        </div>

                        <!-- Popular Tags STATIC -->
                        <div class="sidebar-section mb-4">
                            <h4 class="sidebar-title">Popular Tags</h4>
                            <div class="tags-container">
                                <a href="#" class="tag">Digital Strategy</a>
                                <a href="#" class="tag">Content Marketing</a>
                                <a href="#" class="tag">Marketing Analytics</a>
                                <a href="#" class="tag">Online Advertising</a>
                                <a href="#" class="tag">Social Media</a>
                                <a href="#" class="tag">Tech Trends</a>
                            </div>
                        </div>

                        <!-- Follow Us STATIC -->
                        <div class="sidebar-section">
                            <h4 class="sidebar-title">Follow us on</h4>
                            <div class="social-icons">
                                <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
                                <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/index.js"></script>
    <?php include 'components/footer.php'; ?>

</body>

</html>