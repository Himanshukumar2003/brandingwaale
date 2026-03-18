<?php
include('db.php');
$link = 'dashboard';

// City count
$city = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(id) as cnt FROM city"))['cnt'] ?? 0;

// Blogs count
$blogs = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(id) as cnt FROM blogs"))['cnt'] ?? 0;

// Portfolio count
$portfolio = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(id) as cnt FROM portfolio"))['cnt'] ?? 0;

// Jobs count
$jobs = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(id) as cnt FROM jobs"))['cnt'] ?? 0;

// Job Categories count
$job_cats = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(id) as cnt FROM job_categories"))['cnt'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Brandingwaale — Dashboard</title>
    <link rel="stylesheet" href="assets/css/style.css" />
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Mono:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --dark-bg: #0f0f0f;
            --bg-primary: #1a1a1a;
            --bg-secondary: #2a2a2a;
            --card-bg: #141414;
            --border-color: #2a2a2a;
            --accent: #ffc107;
            --accent-dim: rgba(255, 193, 7, 0.08);
            --accent-glow: rgba(255, 193, 7, 0.2);
            --text-light: #ffffff;
            --text-muted: #888;
            --text-dim: #444;
            --font-display: 'Syne', sans-serif;
            --font-mono: 'DM Mono', monospace;
            --radius: 12px;
            --tr: 0.22s ease;
        }

        .main-content {
            width: 100%;
            padding: 40px 44px;
            font-family: var(--font-display);
        }

        /* ── HEADER ── */
        .dash-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 36px;
            flex-wrap: wrap;
            gap: 16px;
        }

        .dash-header h1 {
            font-size: 26px;
            font-weight: 800;
            letter-spacing: -.5px;
            color: var(--text-light);
        }

        .dash-header p {
            font-size: 13px;
            color: var(--text-muted);
            margin-top: 4px;
        }

        .dash-date {
            display: flex;
            align-items: center;
            gap: 8px;
            font-family: var(--font-mono);
            font-size: 12px;
            color: var(--text-muted);
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            padding: 10px 16px;
            border-radius: 8px;
        }

        .dash-date i {
            color: var(--accent);
        }

        /* ── SECTION LABEL ── */
        .section-label {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 16px;
        }

        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--border-color);
        }

        /* ── STATS GRID ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 16px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            padding: 24px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            position: relative;
            overflow: hidden;
            transition: border-color var(--tr), transform var(--tr), box-shadow var(--tr);
            text-decoration: none;
            color: inherit;
        }

        .stat-card:hover {
            border-color: rgba(255, 193, 7, 0.25);
            transform: translateY(-3px);
            box-shadow: 0 12px 32px rgba(0, 0, 0, 0.4);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--accent);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform .35s cubic-bezier(.76, 0, .24, 1);
        }

        .stat-card:hover::before {
            transform: scaleX(1);
        }

        .stat-card-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .stat-icon {
            width: 42px;
            height: 42px;
            background: var(--accent-dim);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 19px;
            color: var(--accent);
            flex-shrink: 0;
        }

        .stat-arrow {
            font-size: 16px;
            color: var(--text-dim);
            transition: color var(--tr), transform var(--tr);
        }

        .stat-card:hover .stat-arrow {
            color: var(--accent);
            transform: translate(2px, -2px);
        }

        .stat-value {
            font-family: var(--font-display);
            font-size: 36px;
            font-weight: 800;
            letter-spacing: -1px;
            line-height: 1;
            color: var(--text-light);
        }

        .stat-label {
            font-size: 12px;
            color: var(--text-muted);
            font-weight: 500;
            margin-top: 4px;
        }

        .stat-bg-num {
            position: absolute;
            right: 16px;
            bottom: 10px;
            font-family: var(--font-display);
            font-size: 64px;
            font-weight: 800;
            color: rgba(255, 193, 7, 0.03);
            line-height: 1;
            pointer-events: none;
            user-select: none;
        }

        /* ── QUICK LINKS ── */
        .quick-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 10px;
            margin-bottom: 40px;
        }

        .quick-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 16px;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            text-decoration: none;
            color: var(--text-muted);
            font-size: 12px;
            font-weight: 600;
            transition: var(--tr);
        }

        .quick-link i {
            width: 30px;
            height: 30px;
            background: var(--accent-dim);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent);
            font-size: 14px;
            flex-shrink: 0;
        }

        .quick-link:hover {
            border-color: var(--accent);
            color: var(--text-light);
            background: rgba(255, 193, 7, 0.04);
        }

        @media(max-width:768px) {
            .main-content {
                padding: 20px 16px;
            }

            .stats-grid {
                grid-template-columns: 1fr 1fr;
            }

            .quick-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media(max-width:480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .quick-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <button class="mobile-menu-btn" onclick="toggleSidebar()">☰</button>

        <?php include('sidenav.php') ?>

        <main class="main-content">
            <div id="dashboard-section" class="section">

                <!-- HEADER -->
                <div class="dash-header">
                    <div>
                        <h1>Welcome back, Admin 👋</h1>
                        <p>Here's what's happening with your website today.</p>
                    </div>
                    <div class="dash-date">
                        <i class="bi bi-calendar3"></i>
                        <?= date('l, d M Y') ?>
                    </div>
                </div>

                <!-- STATS -->
                <div class="section-label">Overview</div>
                <div class="stats-grid">

                    <a href="all-portfolio.php" class="stat-card">
                        <div class="stat-card-top">
                            <div class="stat-icon"><i class="bi bi-images"></i></div>
                            <i class="bi bi-arrow-up-right stat-arrow"></i>
                        </div>
                        <div>
                            <div class="stat-value"><?= $portfolio ?></div>
                            <div class="stat-label">Portfolio Images</div>
                        </div>
                        <div class="stat-bg-num"><?= $portfolio ?></div>
                    </a>

                    <a href="all-jobs.php" class="stat-card">
                        <div class="stat-card-top">
                            <div class="stat-icon"><i class="bi bi-briefcase"></i></div>
                            <i class="bi bi-arrow-up-right stat-arrow"></i>
                        </div>
                        <div>
                            <div class="stat-value"><?= $jobs ?></div>
                            <div class="stat-label">Active Jobs</div>
                        </div>
                        <div class="stat-bg-num"><?= $jobs ?></div>
                    </a>

                    <a href="add-job-category.php" class="stat-card">
                        <div class="stat-card-top">
                            <div class="stat-icon"><i class="bi bi-tag"></i></div>
                            <i class="bi bi-arrow-up-right stat-arrow"></i>
                        </div>
                        <div>
                            <div class="stat-value"><?= $job_cats ?></div>
                            <div class="stat-label">Job Categories</div>
                        </div>
                        <div class="stat-bg-num"><?= $job_cats ?></div>
                    </a>

                    <a href="#" class="stat-card">
                        <div class="stat-card-top">
                            <div class="stat-icon"><i class="bi bi-geo-alt"></i></div>
                            <i class="bi bi-arrow-up-right stat-arrow"></i>
                        </div>
                        <div>
                            <div class="stat-value"><?= $city ?></div>
                            <div class="stat-label">Cities</div>
                        </div>
                        <div class="stat-bg-num"><?= $city ?></div>
                    </a>

                    <a href="#" class="stat-card">
                        <div class="stat-card-top">
                            <div class="stat-icon"><i class="bi bi-file-earmark-text"></i></div>
                            <i class="bi bi-arrow-up-right stat-arrow"></i>
                        </div>
                        <div>
                            <div class="stat-value"><?= $blogs ?></div>
                            <div class="stat-label">Blog Posts</div>
                        </div>
                        <div class="stat-bg-num"><?= $blogs ?></div>
                    </a>

                </div>

                <!-- QUICK LINKS -->
                <div class="section-label">Quick Actions</div>
                <div class="quick-grid">
                    <a href="add-portfolio.php" class="quick-link">
                        <i class="bi bi-plus-circle"></i> Add Portfolio
                    </a>
                    <a href="portfolio-gallery.php" class="quick-link">
                        <i class="bi bi-grid-3x3-gap"></i> View Gallery
                    </a>
                    <a href="add-job.php" class="quick-link">
                        <i class="bi bi-briefcase"></i> Post a Job
                    </a>
                    <a href="add-job-category.php" class="quick-link">
                        <i class="bi bi-tag"></i> Add Job Category
                    </a>
                    <a href="all-jobs.php" class="quick-link">
                        <i class="bi bi-list-ul"></i> All Jobs
                    </a>
                    <a href="#" class="quick-link">
                        <i class="bi bi-pencil-square"></i> Add Blog
                    </a>
                </div>

            </div>
        </main>
    </div>
</body>

</html>