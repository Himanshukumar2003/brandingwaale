<?php
include 'backend/db.php';

// Get selected category
$cat_id = isset($_GET['category']) ? (int)$_GET['category'] : 0;

// Fetch categories
$categories = mysqli_query($conn, "SELECT * FROM job_categories ORDER BY name ASC");

// Fetch jobs (with filter)
if ($cat_id > 0) {
    $jobs = mysqli_query($conn, "SELECT j.*, jc.name as category_name 
        FROM jobs j 
        LEFT JOIN job_categories jc ON j.category_id = jc.id
        WHERE j.category_id = $cat_id
        ORDER BY j.id DESC");
} else {
    $jobs = mysqli_query($conn, "SELECT j.*, jc.name as category_name 
        FROM jobs j 
        LEFT JOIN job_categories jc ON j.category_id = jc.id
        ORDER BY j.id DESC");
}
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

    <style>
        body {

            color: white;
        }


        .value-card {
            padding: 40px;
            background-color: #2a2a2a;
            transition: background-color 0.4s ease, transform 0.3s ease;

            border-radius: 20px;
        }

        /* .value-card:hover {
            background: rgba(255, 193, 7, 0.8);
        } */


        .card-accent {
            background-color: #e0a800;
        }

        .mission-card:hover .card-accent {
            background-color: #2a2a2a !important;
        }




        .value-card i {
            transition: transform 0.5s ease;
            display: inline-block;
        }

        .value-card:hover i {
            transform: rotateY(360deg);
        }

        .border-bottom {
            border-bottom: 3px solid #333333 !important;
        }

        .card-heading {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
        }


        .card-heading i {
            font-size: 2.5rem;

        }


        .benefits-section {
            position: relative;
            background-color: #2a2a2a;
        }

        .benefits-section::after {
            content: "";
            /* background: linear-gradient(45deg, var(--accent-color), rgba(255, 193, 7, 0.3)); */
            z-index: -1;
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
        }




        .benefit-card {
            /* background: rgba(40, 60, 40, 0.6); */
            border: 1px solid rgba(255, 193, 7, 0.2);
            border-radius: 15px;
            padding: 30px 25px;
            height: 100%;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);

        }

        .benefit-card:hover {
            transform: translateY(-5px);
            border-color: rgba(255, 193, 7, 0.4);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .benefit-icon {
            width: 50px;
            height: 50px;
            background: rgba(255, 193, 7, 0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            border: 1px solid rgba(255, 193, 7, 0.3);
        }

        .benefit-icon i {
            font-size: 24px;
            color: var(--accent-color);
        }




        .position-card {
            padding: 20px;
            background-color: #2a2a2a;
            height: 100%;
            border-radius: 20px;
        }

        .position-card h4 {
            margin-top: 20px;
        }

        .position-tag {

            background: rgba(255, 193, 7, 0.3);
            padding: 5px 10px;
            border-radius: 20px;
        }


        .btn-apply {
            color: var(--accent-color);

        }


        .sub-category {
            list-style-type: disc;
        }


        .form-container {
            max-width: 550px;
            margin: 60px auto;
            padding: 20px;
        }

        .elegant-card {
            background: var(--bg-card);
            border-radius: 0;
            padding: 60px 50px;
            text-align: left;
            box-shadow:

                0 30px 80px rgba(0, 0, 0, 0.3),
                0 0 0 1px rgba(255, 193, 7, 0.2);
            position: relative;
            overflow: hidden;
        }





        .form-title {
            font-family: 'Playfair Display', serif;
            text-align: center;
            margin-bottom: 15px;
            color: var(--text-light);
            font-weight: 700;
            font-size: 2.8rem;
            letter-spacing: -1px;
        }



        .form-group {
            margin-bottom: 30px;
            position: relative;
        }

        .elegant-label {
            display: block;
            margin-bottom: 8px;
            color: var(--text-light);
            font-weight: 500;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .elegant-input {
            width: 100%;
            padding: 10px 15px;
            background: var(--bg-secondary);
            color: var(--text-light);
            font-size: 16px;
            font-weight: 400;
            transition: all 0.4s ease;
            position: relative;
        }

        .elegant-input::placeholder {
            color: var(--text-muted);
        }

        .elegant-input:focus {
            outline: none;
            border-color: var(--accent-color);
            background: var(--bg-primary);
            box-shadow: 0 0 0 3px rgba(255, 193, 7, 0.1);
        }

        .elegant-select {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid var(--text-muted);
            background: var(--bg-secondary);
            color: var(--text-light);
            font-size: 16px;
            font-weight: 400;
            transition: all 0.4s ease;
        }

        option {
            background-color: var(--bg-secondary);

        }

        .elegant-textarea {
            width: 100%;
            padding: 8px 10px;
            border: 1px solid var(--text-muted);
            background: var(--bg-secondary);
            color: var(--text-light);
            font-size: 16px;
            font-weight: 400;
            transition: all 0.4s ease;
            resize: vertical;
            font-family: 'Inter', sans-serif;
        }

        .elegant-textarea::placeholder {
            color: var(--text-muted);
        }



        .elegant-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 40px rgba(255, 193, 7, 0.3);
        }

        .elegant-btn:hover::before {
            left: 100%;
        }

        .decorative-line {
            width: 60px;
            height: 2px;
            background: var(--accent-color);
            margin: 20px auto;
        }

        .input-group-elegant {
            position: relative;
        }

        .input-icon-elegant {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--accent-color);
            font-size: 18px;
        }

        .file-upload-elegant {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }

        .file-upload-elegant input[type=file] {
            position: absolute;
            left: -9999px;
        }

        .file-upload-label {
            display: block;
            padding: 18px 25px;
            border: 1px solid var(--text-muted);
            background: var(--bg-secondary);
            color: var(--text-light);
            cursor: pointer;
            transition: all 0.4s ease;
            text-align: center;
        }

        .file-upload-label:hover {
            border-color: var(--accent-color);
            background: var(--bg-primary);
        }

        .elegant-divider {
            text-align: center;
            position: relative;
        }

        .elegant-divider::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--text-muted), transparent);
        }

        .elegant-divider span {
            background: var(--bg-card);
            padding: 0 20px;
            color: var(--text-gray);
            font-size: 0.9rem;
            position: relative;
        }


        .modal-header {
            border-bottom: none !important;
            padding: 0;
        }


        .modal-content {
            position: relative;
        }

        .modal-header .btn-close {
            position: absolute;
            right: 40px;
            top: 30px;
            z-index: 99;
        }








        .elegant-label {
            font-weight: 500;
            color: #fff;
            margin-bottom: 5px;
            display: block;
        }

        .input-group-elegant {
            position: relative;
            display: flex;
            align-items: center;
        }

        .elegant-input {
            width: 100%;
            padding: 10px 35px 10px 12px;
            border: 1px solid #444;
            border-radius: 5px;
            background-color: #222;
            color: #fff;
            transition: 0.3s ease;
        }

        .elegant-input:focus {
            outline: none;
            border-color: #ffa03a;
            background-color: #1c1c1c;
        }

        .input-icon-elegant {
            position: absolute;
            right: 10px;
            color: #888;
        }

        .readonly-input {
            background-color: #222 !important;
            color: #ccc;
            cursor: not-allowed;
        }

        .readonly-input:focus {
            border-color: #555 !important;
        }

        .file-upload-elegant input[type="file"] {
            display: none;
        }

        .file-upload-label {
            display: inline-block;
            width: 100%;
            padding: 10px;
            background-color: #222;
            border: 1px dashed #555;
            color: #bbb;
            text-align: center;
            cursor: pointer;
            border-radius: 5px;
            transition: 0.3s ease;
        }

        .file-upload-label:hover {
            background-color: #333;
            border-color: #ffa03a;
            color: #fff;
        }

        .custom-btn {
            margin-top: 20px;
            background-color: #ffa03a;
            color: #000;
            padding: 10px 25px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            transition: 0.3s ease;
        }

        .custom-btn:hover {
            background-color: #ff8c00;
        }
    </style>

</head>

<body>

    <?php include 'components/navbar.php'; ?>


    <header class="service-header section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <h5 class="label" data-aos=" fade-up" data-aos-delay="100">
                        We're Hiring
                    </h5>
                    <h1 class="section-title" data-aos="fade-up" data-aos-delay="300">
                        Don't Find a Job. Find Your



                        <span class="highlight">Creative Home.</span>
                    </h1>
                    <p data-aos="fade-up" data-aos-delay="500">
                        At Brandingwaale Webtech, we don't hire just People— we build a tribe of thinkers, makers, and relentless problem-solvers. If you wake up excited about brands, ideas, and the internet, you already belong here.
                    </p>
                    <p data-aos="fade-up" data-aos-delay="700">
                        We believe great work happens when passion meets purpose. At Brandingwaale Webtech, you won’t just clock in and out—you’ll collaborate on meaningful projects, push creative boundaries, and grow alongside a team that values innovation and individuality. Whether you're a designer, developer, strategist, or storyteller, this is your space to learn, create, and make a real impact every single day.
                    </p>



                    <!-- <button class="cta-btn" data-aos="fade-up" data-aos-delay="800">Get Started</button> -->
                </div>
                <div class="col-lg-6 header-image" data-aos="fade-left" data-aos-duration="1200">

                    <img src="img/bg/career-page.png" alt="Branding Services Illustration" class="img-fluid"
                        data-aos="zoom-in" data-aos-duration="1200">
                </div>
            </div>
        </div>
    </header>



    <section class="benefits-section section">
        <div class="container">
            <div class="row align-items-center mb-5">
                <div class="col-lg-6">
                    <h6 class="highlight">Not Just a Workplace. A Launchpad.</h6>
                    <h2>WHY BRANDINGWAALE?</h2>
                </div>
                <div class="col-lg-6">
                    <p>
                        At Brandingwaale Webtech, growth isn’t defined by time — it’s defined by impact. We’ve built a culture where talent moves fast, ideas are valued, and every individual gets the opportunity to create meaningful work that truly matters.
                    </p>
                </div>
            </div>

            <div class="row g-4">

                <!-- Grow Without Limits -->
                <div class="col-lg-3 col-md-6">
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="fas fa-fire"></i>
                        </div>
                        <h5 class="benefit-title">Grow Without Limits</h5>
                        <p class="benefit-description">
                            No rigid hierarchies. No waiting your turn. If you have the skills and the hunger, the opportunities are yours to take.
                        </p>
                    </div>
                </div>

                <!-- Real Brands -->
                <div class="col-lg-3 col-md-6">
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="fas fa-lightbulb"></i>
                        </div>
                        <h5 class="benefit-title">Work on Real Brands</h5>
                        <p class="benefit-description">
                            From startups to enterprises — your work reaches real audiences, real markets, and makes a real difference from day one.
                        </p>
                    </div>
                </div>

                <!-- Team -->
                <div class="col-lg-3 col-md-6">
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="fas fa-globe"></i>
                        </div>
                        <h5 class="benefit-title">A Team That Gets It</h5>
                        <p class="benefit-description">
                            20+ creative minds who challenge, support, and push each other to do their best work every single day.
                        </p>
                    </div>
                </div>

                <!-- Ownership -->
                <div class="col-lg-3 col-md-6">
                    <div class="benefit-card">
                        <div class="benefit-icon">
                            <i class="fas fa-bolt"></i>
                        </div>
                        <h5 class="benefit-title">Build. Experiment. Own It.</h5>
                        <p class="benefit-description">
                            Pitch ideas, experiment freely, and own your work end to end. Your contributions are seen, valued, and celebrated.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- <div class="row mb-4">
    <div class="col-lg-4">
        <form method="GET">
            <select name="category" class="form-select" onchange="this.form.submit()">
                <option value="0">All Categories</option>

                <?php while ($cat = mysqli_fetch_assoc($categories)): ?>
                    <option value="<?= $cat['id'] ?>" 
                        <?= ($cat_id == $cat['id']) ? 'selected' : '' ?>>
                        <?= $cat['name'] ?>
                    </option>
                <?php endwhile; ?>

            </select>
        </form>
    </div>
</div> -->

    <section class="positions-section section" id="job">
        <div class="container">
            <div class="row align-items-center mb-5">
                <div class="col-lg-6">
                    <h6 class="highlight">What Defines Us</h6>
                    <h1>EMPOWERING GROWTH WITH INNOVATION</h1>
                </div>
                <div class="col-lg-6">
                    <p>
                        We are pioneers in driving technological advancement and personal growth through innovative
                        solutions and exceptional work culture, fostering creativity and professional success.
                    </p>


                </div>
            </div>
            <div class="row g-4">

                <?php if (mysqli_num_rows($jobs) > 0): ?>

                    <?php while ($job = mysqli_fetch_assoc($jobs)): ?>

                        <div class="col-lg-4 col-md-6">
                            <div class="position-card">

                                <span class="position-tag">
                                    <?= strtoupper($job['category_name']) ?>
                                </span>

                                <h4><?= htmlspecialchars($job['title']) ?></h4>

                                <p class="sub-category mb-3">
                                    <?= htmlspecialchars($job['location']) ?>
                                </p>

                                <p>
                                    <?= substr(strip_tags($job['description']), 0, 120) ?>...
                                </p>

                                <a href="#"
                                    class="btn-apply"
                                    data-bs-toggle="modal"
                                    data-bs-target="#applicationModal"
                                    data-position="<?= htmlspecialchars($job['title']) ?>">
                                    Apply Now <i class="fas fa-arrow-right"></i>
                                </a>

                            </div>
                        </div>

                    <?php endwhile; ?>

                <?php else: ?>

                    <div class="col-12 text-center">
                        <p>No jobs found in this category.</p>
                    </div>

                <?php endif; ?>

            </div>
        </div>
    </section>
    <div class="modal fade" id="applicationModal" tabindex="-1" aria-labelledby="applicationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content bg-dark text-white ">
                <div class="modal-header">
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="elegant-card">

                        <form>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="elegant-label">Name</label>
                                        <div class="input-group-elegant">
                                            <input type="text" class="elegant-input" required>
                                            <i class="fas fa-user input-icon-elegant"></i>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="elegant-label">Email Address</label>
                                        <div class="input-group-elegant">
                                            <input type="email" class="elegant-input" required>
                                            <i class="fas fa-envelope input-icon-elegant"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="elegant-label">Phone Number</label>
                                        <div class="input-group-elegant">
                                            <input type="tel" class="elegant-input" required>
                                            <i class="fas fa-phone input-icon-elegant"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="elegant-label">city/state</label>
                                        <div class="input-group-elegant">
                                            <input type="text" class="elegant-input" required>

                                            <i class="bi bi-geo-alt-fill input-icon-elegant"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="elegant-label">Position of Interest</label>
                                        <div class="input-group-elegant">
                                            <input type="text" id="positionInput" class="elegant-input readonly-input"
                                                readonly required>
                                            <i class="fas fa-briefcase input-icon-elegant"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="elegant-label">Executive Resume</label>
                                        <div class="file-upload-elegant">
                                            <input type="file" id="resume-elegant-modal" accept=".pdf,.doc,.docx"
                                                required>
                                            <label for="resume-elegant-modal" class="file-upload-label">
                                                <i class="fas fa-cloud-upload-alt me-2"></i>Upload Professional Resume
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="custom-btn">
                                Submit
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>



    <section class="cta-section section">
        <div class="container">
            <div class="row ">
                <div class="col-12">
                    <div class="cta-card">
                        <div class="row ">
                            <div class="col-md-7">
                                <!-- <div class="caption-text">CAPTION HERE</div> -->
                                <h2 class="main-heading  text-white">Think You Belong Here Anyway?

                                </h2>
                                <p class="  text-white w-100">
                                    We're always open to meeting extraordinary people. Send us your portfolio, resume, or just a note about what you do — and we'll reach out if there's a fit.

                                </p>

                                <p>
                                    <b>Email: </b>
                                    <a href="mailto:recruitment@brandingwaale.com" class="text-white">
                                        recruitment@brandingwaale.com
                                    </a>
                                </p>
                                <div class="d-flex justify-content-start">
                                    <a href="#job" class="custom-btn  ">
                                        Apply Now→

                                        <svg class="arrow-icon" viewBox="0 0 16 19" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M7 18C7 18.5523 7.44772 19 8 19C8.55228 19 9 18.5523 9 18H7ZM8.70711 0.292893C8.31658 -0.0976311 7.68342 -0.0976311 7.29289 0.292893L0.928932 6.65685C0.538408 7.04738 0.538408 7.68054 0.928932 8.07107C1.31946 8.46159 1.95262 8.46159 2.34315 8.07107L8 2.41421L13.6569 8.07107C14.0474 8.46159 14.6805 8.46159 15.0711 8.07107C15.4616 7.68054 15.4616 7.04738 15.0711 6.65685L8.70711 0.292893ZM9 18L9 1H7L7 18H9Z" class="arrow-path"></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <img src="img/bg/cta.png" class="img-fluid cta-img" alt="cta-img">
                            </div>

                        </div>


                    </div>
                </div>
            </div>
        </div>
    </section>
    <?php include 'components/footer.php'; ?>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('resume-elegant').addEventListener('change', function(e) {
            const label = document.querySelector('.file-upload-label');
            if (e.target.files.length > 0) {
                label.innerHTML = `<i class="fas fa-check me-2"></i>${e.target.files[0].name}`;
                label.style.borderColor = 'var(--accent-color)';
                label.style.background = 'var(--bg-primary)';
                label.style.color = 'var(--accent-color)';
            }
        });

        document.querySelectorAll('.elegant-input, .elegant-select, .elegant-textarea').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'translateY(-2px)';
            });

            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'translateY(0)';
            });
        });
    </script>

    <script>
        document.querySelectorAll('.btn-apply').forEach(btn => {
            btn.addEventListener('click', function() {
                const position = this.getAttribute('data-position');
                document.getElementById('positionInput').value = position;
            });
        });
    </script>




    <script src="js/index.js"></script>

</body>

</html>