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
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="css/index.css">

    <style>
        /* Portfolio Container */
        .portfolio-container {
            background-color: var(--bg-secondary);
            padding: 40px;
            border-radius: 20px;
            margin-bottom: 2rem;
        }

        .main-heading h2 {
            position: relative;
            color: var(--text-light);
            font-weight: 700;
            margin-bottom: 2rem;
        }

        .main-heading h2::after {
            position: absolute;
            content: "";
            bottom: -15px;
            width: 100px;
            left: 0;
            height: 3px;
            background-color: var(--accent-color);
        }

        /* Services Sidebar Styles */
        .services-sidebar {
            background-color: var(--bg-secondary);
            border-radius: 10px;
            padding: 20px;
            position: sticky;
            top: 20px;
            height: fit-content;
        }

        .category-item {
            margin-bottom: 10px;
        }

        .category-btn {
            width: 100%;
            text-align: left;
            background: transparent;
            border: none;
            color: var(--text-gray);
            font-size: 18px;
            font-weight: 500;
            padding: 15px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: space-between;
            cursor: pointer;
        }

        .category-btn:hover,
        .category-btn.active {
            background-color: var(--accent-color);
            color: var(--text-color);
            font-weight: 600;
        }

        .category-btn:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba(255, 193, 7, 0.5);
        }

        .subcategory-list {
            display: none;
            padding-left: 20px;
            margin-top: 10px;
            transition: all 0.3s ease;
        }

        .subcategory-list.show {
            display: block;
        }

        .subcategory-btn {
            width: 100%;
            text-align: left;
            background: transparent;
            border: none;
            color: var(--text-muted);
            font-size: 14px;
            padding: 8px 15px;
            border-radius: 5px;
            margin-bottom: 5px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .subcategory-btn:hover,
        .subcategory-btn.active {
            background-color: var(--bg-card);
            color: var(--accent-color);
        }

        .subcategory-btn:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba(255, 193, 7, 0.3);
        }

        /* Portfolio Content Styles */
        .portfolio-content {
            background-color: var(--bg-secondary);
            border-radius: 20px;
            padding: 40px;
        }

        .portfolio-grid {
            display: none;
        }

        .portfolio-grid.active {
            display: block;
        }

        .category-header {
            text-align: left;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 3px solid var(--accent-color);
        }

        .category-header h2 {
            font-weight: 700;
            color: var(--accent-color);
            margin-bottom: 10px;
            font-size: 2rem;
        }

        .category-header p {
            color: var(--text-muted);
            font-size: 1.1rem;
        }

        .subcategory-header {
            margin-bottom: 30px;
            padding: 20px;
            background-color: var(--bg-card);
            border-radius: 10px;
        }

        .subcategory-header h3 {
            font-weight: 600;
            color: var(--accent-color);
            margin-bottom: 10px;
            font-size: 1.5rem;
        }

        .subcategory-header p {
            color: var(--text-muted);
            margin-bottom: 0;
        }

        /* Portfolio Card Styles */
        .portfolio-card {
            background-color: var(--bg-card);
            border-radius: 10px;
            overflow: hidden;
            transition: all 0.3s ease;

            height: 100%;
            border: 1px solid rgba(255, 193, 7, 0.2);
        }

        .portfolio-card:hover {
            transform: translateY(-5px);
            border-color: var(--accent-color);
        }

        .portfolio-image {
            overflow: hidden;
            object-fit: contain;

        }

        .portfolio-image img {
            width: 100%;
            object-fit: contain;
            transition: transform 0.3s ease;
        }

        .pr-logo img {
            height: auto;
        }

        .pr-logo {
            height: auto;
        }

        .portfolio-card:hover .portfolio-image img {
            transform: scale(1.05);
        }

        .portfolio-card-body {
            padding: 20px;
        }

        .portfolio-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 10px;
            color: var(--text-light);
        }

        .portfolio-description {
            color: var(--text-muted);
            font-size: 14px;
            margin-bottom: 15px;
            line-height: 1.5;
        }

        .portfolio-link {
            display: inline-block;
            background-color: var(--accent-color);
            color: var(--text-color);
            padding: 8px 16px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .portfolio-link:hover {
            background-color: #e0a800;
            color: var(--text-color);
            transform: translateY(-2px);
            text-decoration: none;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .services-sidebar {
                margin-bottom: 30px;
                position: relative;
            }

            .portfolio-content {
                padding: 20px;
            }

            .portfolio-container {
                padding: 20px;
            }

            .main-heading h2 {
                font-size: 1.8rem;
            }

            .category-header h2 {
                font-size: 1.5rem;
            }

            .subcategory-header h3 {
                font-size: 1.3rem;
            }
        }

        /* Smooth transitions */
        * {
            transition: all 0.3s ease;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-secondary);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--accent-color);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #e0a800;
        }

        /* Section anchors */
        .section-anchor {
            display: block;
            position: relative;
            top: -100px;
            visibility: hidden;
        }

        .category-item .active {
            color: white !important;
        }

        /* ── Marquee section (your existing styles kept as-is) ── */
        .marquee-section {
            background: var(--dark-bg);
            padding: 64px 0;
            overflow: hidden;
            font-family: 'Helvetica Neue', sans-serif;
        }

        .marquee-header {
            text-align: center;
            margin-bottom: 48px;
            padding: 0 24px;
        }

        .marquee-header .tag {
            display: inline-block;
            background: var(--accent-color);
            color: #000;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            padding: 5px 14px;
            border-radius: 2px;
            margin-bottom: 16px;
        }

        .marquee-header h2 {
            color: var(--text-light);
            font-size: clamp(28px, 4vw, 48px);
            font-weight: 300;
            letter-spacing: -0.02em;
            margin: 0 0 12px;
            line-height: 1.1;
        }

        .marquee-header h2 span {
            color: var(--accent-color);
            font-weight: 700;
        }

        .marquee-header p {
            color: var(--text-muted);
            font-size: 15px;
            margin: 0;
        }

        .marquee-track-wrapper {
            position: relative;
            margin-bottom: 20px;
        }

        .marquee-track-wrapper::before,
        .marquee-track-wrapper::after {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            width: 120px;
            z-index: 2;
            pointer-events: none;
        }

        .marquee-track-wrapper::before {
            left: 0;
            background: linear-gradient(to right, var(--dark-bg), transparent);
        }

        .marquee-track-wrapper::after {
            right: 0;
            background: linear-gradient(to left, var(--dark-bg), transparent);
        }

        .marquee-track {
            display: flex;
            gap: 20px;
            width: max-content;
        }

        .marquee-track.row-ltr {
            animation: scrollLTR 90s linear infinite;
        }

        .marquee-track.row-rtl {
            animation: scrollRTL 90s linear infinite;
        }

        .marquee-track:hover {
            animation-play-state: paused;
        }

        @keyframes scrollLTR {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        @keyframes scrollRTL {
            0% {
                transform: translateX(-50%);
            }

            100% {
                transform: translateX(0);
            }
        }

        .proj-card {
            position: relative;
            width: 350px;
            border-radius: 12px;
            overflow: hidden;
            flex-shrink: 0;
            cursor: pointer;
            border: 1px solid var(--border-color);
            background: var(--bg-secondary);
            transition: transform 0.3s ease, border-color 0.3s ease;
        }

        .proj-card:hover {
            transform: scale(1.04);
            border-color: var(--accent-color);
            z-index: 5;
        }

        .proj-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.4s ease;
        }

        .proj-card:hover img {
            transform: scale(1.06);
        }

        .proj-card .overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.82) 0%, rgba(0, 0, 0, 0) 55%);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 14px 16px;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .proj-card:hover .overlay {
            opacity: 1;
        }

        .proj-card .overlay .title {
            color: #fff;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.02em;
            margin: 0 0 4px;
        }

        .proj-card .overlay .cat {
            color: var(--accent-color);
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            margin: 0;
        }

        .proj-card .label-pill {
            position: absolute;
            top: 10px;
            left: 10px;
            background: rgba(0, 0, 0, 0.65);
            color: #fff;
            font-size: 10px;
            font-weight: 600;
            padding: 3px 9px;
            border-radius: 20px;
            backdrop-filter: blur(4px);
            letter-spacing: 0.04em;
        }

        .marquee-bottom {
            text-align: center;
            margin-top: 44px;
            padding: 0 24px;
        }

        .marquee-bottom p {
            color: var(--text-muted);
            font-size: 13px;
            margin: 0 0 18px;
            letter-spacing: 0.03em;
        }

        .cta-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--accent-color);
            color: #000;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            padding: 12px 28px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            transition: background 0.2s, transform 0.15s;
            text-decoration: none;
        }

        .cta-btn:hover {
            background: #e6ac00;
            transform: translateY(-1px);
        }

        .cta-btn svg {
            width: 14px;
            height: 14px;
        }

        /* ── Swiper overrides (project swipers) ── */
        .port-swiper {
            padding-bottom: 3rem !important;
        }

        .swiper {
            padding: 10px 0;
        }

        .port-swiper .swiper-slide {
            height: auto;
        }

        .port-swiper .swiper-button-next,
        .port-swiper .swiper-button-prev {
            color: var(--accent-color);
        }

        .port-swiper .swiper-button-next::after,
        .port-swiper .swiper-button-prev::after {
            font-size: 18px;
            font-weight: 800;
        }

        .port-swiper .swiper-pagination-bullet-active {
            background: var(--accent-color);
        }

        /* ── Logo marquee swipers ── */
        .logo-swiper-row {
            overflow: hidden;
            margin-bottom: 1.2rem;
        }

        .logo-swiper .swiper-slide {
            width: auto !important;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* pr-logo cards inside swiper keep original styles */
        .logo-swiper .portfolio-card.pr-logo {
            margin-bottom: 0;
            width: 200px;
            height: 100px;
            display: flex;
            background-color: #fff;
            align-items: center;
            justify-content: center;
        }

        .logo-swiper .portfolio-card.pr-logo .portfolio-image img {

            width: 100%;
            object-fit: contain;
        }
    </style>
</head>

<body>
    <?php include 'components/navbar.php'; ?>

    <section class="marquee-section">
        <div class="marquee-header">
            <h2>Brands We've <span>Built</span></h2>
            <p>From hospitality to architecture — crafted with purpose.</p>
        </div>

        <div class="marquee-track-wrapper">
            <div class="marquee-track row-rtl" id="row1"></div>
        </div>
        <div class="marquee-track-wrapper">
            <div class="marquee-track row-ltr" id="row2"></div>
        </div>
    </section>

    <div class="container-fluid py-5">
        <div class="container">
            <div class="portfolio-container">
                <div class="row g-4">

                    <!-- ══ SIDEBAR (unchanged) ══════════════════════════════ -->
                    <div class="col-md-4">
                        <div class="services-sidebar">
                            <div class="category-item">
                                <button class="category-btn active" onclick="showAllProjects()">
                                    <span><i class="bi bi-grid-fill me-2"></i>All</span>
                                </button>
                            </div>

                            <div class="category-item">
                                <button class="category-btn" onclick="toggleCategory('development')">
                                    <span><i class="bi bi-code-slash me-2"></i>DEVELOPMENT</span>
                                    <i class="bi bi-chevron-down" id="development-icon"></i>
                                </button>
                                <div class="subcategory-list" id="development-list">
                                    <button class="subcategory-btn"
                                        onclick="showSubcategory('website-development')">Website Designing &
                                        Development</button>
                                    <!-- <button class="subcategory-btn" onclick="showSubcategory('web-application')">Web
                                        Application Development</button> -->
                                    <button class="subcategory-btn" onclick="showSubcategory('web-portals')">Web Portals
                                        Development</button>
                                    <button class="subcategory-btn"
                                        onclick="showSubcategory('ecommerce')">E-commerce</button>
                                </div>
                            </div>

                            <div class="category-item">
                                <button class="category-btn" onclick="toggleCategory('marketing')">
                                    <span><i class="bi bi-graph-up me-2"></i>MARKETING</span>
                                    <i class="bi bi-chevron-down" id="marketing-icon"></i>
                                </button>
                                <div class="subcategory-list" id="marketing-list">
                                    <button class="subcategory-btn" onclick="showSubcategory('seo-sem')">SMM | SEO | SEM
                                        | SMO</button>
                                    <button class="subcategory-btn" onclick="showSubcategory('gmb-optimization')">Google
                                        My Business (GMB) Optimization</button>
                                    <button class="subcategory-btn"
                                        onclick="showSubcategory('whatsapp-marketing')">WhatsApp Marketing &
                                        Automation</button>
                                    <button class="subcategory-btn" onclick="showSubcategory('whatsapp-api')">WhatsApp
                                        API Integration</button>
                                </div>
                            </div>

                            <div class="category-item">
                                <button class="category-btn" onclick="toggleCategory('advertising')">
                                    <span><i class="bi bi-megaphone me-2"></i>PR & ADVERTISING</span>
                                    <i class="bi bi-chevron-down" id="advertising-icon"></i>
                                </button>
                                <div class="subcategory-list" id="advertising-list">
                                    <button class="subcategory-btn" onclick="showSubcategory('media-buying')">Media
                                        Buying</button>
                                    <!-- <button class="subcategory-btn" onclick="showSubcategory('print-media')">Print Media
                                        Advertising</button>
                                    <button class="subcategory-btn"
                                        onclick="showSubcategory('digital-advertising')">Mobile Advertising, Radio,
                                        Cinema</button> -->
                                </div>
                            </div>

                            <div class="category-item">
                                <button class="category-btn" onclick="toggleCategory('design')">
                                    <span><i class="bi bi-palette me-2"></i>DESIGN</span>
                                    <i class="bi bi-chevron-down" id="design-icon"></i>
                                </button>
                                <div class="subcategory-list" id="design-list">
                                    <button class="subcategory-btn" onclick="showSubcategory('logo-design')">Logo
                                        Designing</button>
                                </div>
                            </div>
                        </div>
                    </div><!-- /sidebar -->

                    <!-- ══ PORTFOLIO CONTENT ═══════════════════════════════ -->
                    <div class="col-md-8">
                        <div class="portfolio-content">

                            <!-- ── All Projects ──────────────────────────── -->
                            <div id="default-view" class="portfolio-grid active">
                                <div class="subcategory-header">
                                    <h3>All Projects</h3>
                                    <p>Explore all our service categories and successful project implementations.</p>
                                </div>
                                <div class="swiper port-swiper" id="sw-all">
                                    <div class="swiper-wrapper">

                                        <!-- 193 -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/portfolio/193.jpeg" alt="Boost Ads" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Boost Ads</h4>
                                                    <p class="portfolio-description">The premier Google Ads agency in India founded by Anaam Tiwary.</p>
                                                    <a href="https://www.boostads.in/" class="portfolio-link" target="_blank">View Project</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 194 -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/portfolio/194.jpeg" alt="Anaam Tiwary" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Anaam Tiwary</h4>
                                                    <p class="portfolio-description">Google Ads Certified Expert delivering high-converting campaigns.</p>
                                                    <a href="https://www.anaamtiwary.com/" class="portfolio-link" target="_blank">View Project</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 293 -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/portfolio/Asset262.jpeg" alt="MySkilly" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">MySkilly</h4>
                                                    <p class="portfolio-description">Platform focused on financial sector growth.</p>
                                                    <a href="https://myskilly.com/" class="portfolio-link" target="_blank">View Project</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 442 -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/portfolio/Asset442.jpeg" alt="Gulshan Nagpal" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Gulshan Nagpal</h4>
                                                    <p class="portfolio-description">Motivational speaker and life coach.</p>
                                                    <a href="https://gulshannagpal.in/" class="portfolio-link" target="_blank">View Project</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 392 -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/portfolio/Asset392.jpeg" alt="Rajeev Bhatt" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Rajeev Bhatt</h4>
                                                    <p class="portfolio-description">Inclusive education pioneer.</p>
                                                    <a href="https://rajeevbhatt.com/" class="portfolio-link" target="_blank">View Project</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 402 -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/portfolio/Asset402.jpeg" alt="Asmita Theatre Group" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Asmita Theatre Group</h4>
                                                    <p class="portfolio-description">Delhi-based theatre group.</p>
                                                    <a href="https://atg.bwdemo.in/" class="portfolio-link" target="_blank">View Project</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 372 -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/portfolio/Asset372.jpeg" alt="MACK EV" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">MACK EV</h4>
                                                    <p class="portfolio-description">Electric mobility brand.</p>
                                                    <a href="https://mack-ev.com/" class="portfolio-link" target="_blank">View Project</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 312 -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/portfolio/Asset312.jpeg" alt="Astro Shivang" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Astro Shivang</h4>
                                                    <p class="portfolio-description">Spiritual and Vedic solutions platform.</p>
                                                    <a href="https://astroshivang.com/" class="portfolio-link" target="_blank">View Project</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 432 -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/portfolio/Asset432.jpeg" alt="Dr Dipti Smile Suite" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Dr. Dipti’s Smile Suite</h4>
                                                    <p class="portfolio-description">Modern dental clinic.</p>
                                                    <a href="https://www.drdiptismilesuite.com/" class="portfolio-link" target="_blank">View Project</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 382 -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/portfolio/Asset382.jpeg" alt="EventBrew" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">EventBrew</h4>
                                                    <p class="portfolio-description">Event management company.</p>
                                                    <a href="https://eventbrew.in/" class="portfolio-link" target="_blank">View Project</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 452 -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/portfolio/Asset452.jpeg" alt="Qeds Studio" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Qeds Studio</h4>
                                                    <p class="portfolio-description">Architectural design studio.</p>
                                                    <a href="https://qedsstudio.com/" class="portfolio-link" target="_blank">View Project</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 302 -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/portfolio/Asset302.jpeg" alt="Wyte Kyte" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Wyte Kyte</h4>
                                                    <p class="portfolio-description">Premium interior design brand.</p>
                                                    <a href="https://wytekyte.com/" class="portfolio-link" target="_blank">View Project</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Dynamic Displays -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/potal/Asset13.jpeg" alt="Dynamic Displays" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Dynamic Displays</h4>
                                                    <p class="portfolio-description">
                                                        CRM platform with lead tracking, customer management, installation visits, and order pipeline.
                                                    </p>
                                                    <a href="https://dashboard.dynamicdisplays.co.nz/" target="_blank" class="portfolio-link">View More</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Bharat Shakti Tenders -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/potal/Asset262.jpeg" alt="Bharat Shakti Tenders" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Bharat Shakti Tenders</h4>
                                                    <p class="portfolio-description">
                                                        Tender management system for tracking GEM orders, invoices, and payments.
                                                    </p>
                                                    <a href="#" target="_blank" class="portfolio-link">View More</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Neer Savior -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/potal/Asset11.jpeg" alt="Neer Savior" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Neer Savior</h4>
                                                    <p class="portfolio-description">
                                                        Water tanker booking admin panel with size, type, pricing, and delivery management.
                                                    </p>
                                                    <a href="#" target="_blank" class="portfolio-link">View More</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Myskilly -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/potal/Asset8.jpeg" alt="Myskilly" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Myskilly</h4>
                                                    <p class="portfolio-description">
                                                        LMS admin panel for course creation, tutor management, and payments.
                                                    </p>
                                                    <a href="#" target="_blank" class="portfolio-link">View More</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Startup News India -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/potal/Asset9.jpeg" alt="Startup News India" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Startup News India</h4>
                                                    <p class="portfolio-description">
                                                        CMS for publishing startup news, blogs, categories, and managing users.
                                                    </p>
                                                    <a href="#" target="_blank" class="portfolio-link">View More</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Skilly -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/potal/Asset8.jpeg" alt="Skilly" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Skilly – Learn Earn Lead</h4>
                                                    <p class="portfolio-description">
                                                        AI-powered e-learning platform with video-based professional courses.
                                                    </p>
                                                    <a href="#" target="_blank" class="portfolio-link">View More</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Indobes -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/potal/Asset7.jpeg" alt="Indobes Portal" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Indobes Portal</h4>
                                                    <p class="portfolio-description">
                                                        Admin portal for managing news content, categories, and users.
                                                    </p>
                                                    <a href="#" target="_blank" class="portfolio-link">View More</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Dr Dipti -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/potal/Asset6.jpeg" alt="Dr Dipti" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Dental Clinic Management</h4>
                                                    <p class="portfolio-description">
                                                        Patient, treatment, payment, and clinic record management system.
                                                    </p>
                                                    <a href="#" target="_blank" class="portfolio-link">View More</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- BW Tasks -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/potal/Asset5.jpeg" alt="BW Tasks" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">BW Tasks</h4>
                                                    <p class="portfolio-description">
                                                        Task management platform with dashboard, KPIs, and team collaboration.
                                                    </p>
                                                    <a href="#" target="_blank" class="portfolio-link">View More</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- InfraKeys -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/potal/Asset9.jpeg" alt="InfraKeys" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">InfraKeys</h4>
                                                    <p class="portfolio-description">
                                                        Secure admin login system for infrastructure key management.
                                                    </p>
                                                    <a href="#" target="_blank" class="portfolio-link">View More</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Accord Hospital -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/potal/Asset3.jpeg" alt="Accord Hospital" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Accord Hospital</h4>
                                                    <p class="portfolio-description">
                                                        Patient portal with UHID login for accessing medical records.
                                                    </p>
                                                    <a href="#" target="_blank" class="portfolio-link">View More</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Login Screens -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/potal/Asset2.jpeg" alt="BW Tasks Login" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">BW Tasks Login</h4>
                                                    <p class="portfolio-description">
                                                        Dark themed login UI for team task management SaaS platform.
                                                    </p>
                                                    <a href="https://bwtask.bwdemo.in/" target="_blank" class="portfolio-link">View More</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- QED -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/potal/Asset265.jpeg" alt="QED Studio" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">QED's Studio</h4>
                                                    <p class="portfolio-description">
                                                        Minimal admin login panel for creative production platform.
                                                    </p>
                                                    <a href="https://dashboard.qedsstudio.com/" target="_blank" class="portfolio-link">View More</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Generic -->
                                        <!-- <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/potal/asset-4.png" alt="Generic Admin" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Generic Admin Panel</h4>
                                                    <p class="portfolio-description">
                                                        Clean blue-themed login UI for SaaS admin systems.
                                                    </p>
                                                    <a href="#" target="_blank" class="portfolio-link">View More</a>
                                                </div>
                                            </div>
                                        </div> -->

                                        <!-- Mack EV -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/potal/Asset263.jpeg" alt="Mack EV" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Mack EV</h4>
                                                    <p class="portfolio-description">
                                                        EV platform admin login with clean energy-focused UI.
                                                    </p>
                                                    <a href="https://mack-ev.com/" target="_blank" class="portfolio-link">View More</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Bharat Login -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/potal/Asset262.jpeg" alt="Bharat Login" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Bharat Tenders Login</h4>
                                                    <p class="portfolio-description">
                                                        Login with OTP and Google sign-in for tender platform users.
                                                    </p>
                                                    <a href="https://bharatshaktitenders.com/" target="_blank" class="portfolio-link">View More</a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="swiper-button-prev"></div>
                                    <div class="swiper-button-next"></div>

                                </div>
                            </div>
                            <!-- ── Website Development ───────────────────── -->
                            <div id="website-development" class="portfolio-grid">
                                <div class="subcategory-header">
                                    <h3>Website Designing & Development</h3>
                                    <p>Professional websites that drive results and enhance your digital presence with
                                        modern design and functionality.</p>
                                </div>
                                <div class="swiper port-swiper" id="sw-website">
                                    <div class="swiper-wrapper">

                                        <!-- 193 -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/portfolio/193.jpeg" alt="Boost Ads" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Boost Ads</h4>
                                                    <p class="portfolio-description">The premier Google Ads agency in India founded by Anaam Tiwary.</p>
                                                    <a href="https://www.boostads.in/" class="portfolio-link" target="_blank">View Project</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 194 -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/portfolio/194.jpeg" alt="Anaam Tiwary" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Anaam Tiwary</h4>
                                                    <p class="portfolio-description">Google Ads Certified Expert delivering high-converting campaigns.</p>
                                                    <a href="https://www.anaamtiwary.com/" class="portfolio-link" target="_blank">View Project</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 293 -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/portfolio/Asset262.jpeg" alt="MySkilly" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">MySkilly</h4>
                                                    <p class="portfolio-description">Platform focused on financial sector growth.</p>
                                                    <a href="https://myskilly.com/" class="portfolio-link" target="_blank">View Project</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 442 -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/portfolio/Asset442.jpeg" alt="Gulshan Nagpal" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Gulshan Nagpal</h4>
                                                    <p class="portfolio-description">Motivational speaker and life coach.</p>
                                                    <a href="https://gulshannagpal.in/" class="portfolio-link" target="_blank">View Project</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 392 -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/portfolio/Asset392.jpeg" alt="Rajeev Bhatt" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Rajeev Bhatt</h4>
                                                    <p class="portfolio-description">Inclusive education pioneer.</p>
                                                    <a href="https://rajeevbhatt.com/" class="portfolio-link" target="_blank">View Project</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 402 -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/portfolio/Asset402.jpeg" alt="Asmita Theatre Group" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Asmita Theatre Group</h4>
                                                    <p class="portfolio-description">Delhi-based theatre group.</p>
                                                    <a href="https://atg.bwdemo.in/" class="portfolio-link" target="_blank">View Project</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 372 -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/portfolio/Asset372.jpeg" alt="MACK EV" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">MACK EV</h4>
                                                    <p class="portfolio-description">Electric mobility brand.</p>
                                                    <a href="https://mack-ev.com/" class="portfolio-link" target="_blank">View Project</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 312 -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/portfolio/Asset312.jpeg" alt="Astro Shivang" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Astro Shivang</h4>
                                                    <p class="portfolio-description">Spiritual and Vedic solutions platform.</p>
                                                    <a href="https://astroshivang.com/" class="portfolio-link" target="_blank">View Project</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 432 -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/portfolio/Asset432.jpeg" alt="Dr Dipti Smile Suite" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Dr. Dipti’s Smile Suite</h4>
                                                    <p class="portfolio-description">Modern dental clinic.</p>
                                                    <a href="https://www.drdiptismilesuite.com/" class="portfolio-link" target="_blank">View Project</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 382 -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/portfolio/Asset382.jpeg" alt="EventBrew" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">EventBrew</h4>
                                                    <p class="portfolio-description">Event management company.</p>
                                                    <a href="https://eventbrew.in/" class="portfolio-link" target="_blank">View Project</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 452 -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/portfolio/Asset452.jpeg" alt="Qeds Studio" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Qeds Studio</h4>
                                                    <p class="portfolio-description">Architectural design studio.</p>
                                                    <a href="https://qedsstudio.com/" class="portfolio-link" target="_blank">View Project</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- 302 -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/portfolio/Asset302.jpeg" alt="Wyte Kyte" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Wyte Kyte</h4>
                                                    <p class="portfolio-description">Premium interior design brand.</p>
                                                    <a href="https://wytekyte.com/" class="portfolio-link" target="_blank">View Project</a>
                                                </div>
                                            </div>
                                        </div>




                                    </div>
                                    <div class="swiper-button-prev"></div>
                                    <div class="swiper-button-next"></div>

                                </div>
                            </div>
                            <!-- ── Web Application Development ───────────── -->
                            <!-- <div id="web-application" class="portfolio-grid">
                                <div class="subcategory-header">
                                    <h3>Web Application Development</h3>
                                    <p>Custom web applications built with modern technologies to streamline your
                                        business processes and improve efficiency.</p>
                                </div>
                                <div class="swiper port-swiper" id="sw-webapp">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image"><img src="img/app/asset1.png"
                                                        alt="Custom CRM System" loading="lazy"></div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Custom CRM System</h4>
                                                    <p class="portfolio-description">Advanced customer relationship
                                                        management system with automated workflows and analytics.</p>
                                                    <a href="#" class="portfolio-link">View Project</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image"><img src="img/app/asset2.png"
                                                        alt="Inventory Management" loading="lazy"></div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Inventory Management</h4>
                                                    <p class="portfolio-description">Real-time inventory tracking system
                                                        with automated alerts and reporting features.</p>
                                                    <a href="#" class="portfolio-link">View Project</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image"><img src="img/app/asset3.png"
                                                        alt="Project Management Tool" loading="lazy"></div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Project Management Tool</h4>
                                                    <p class="portfolio-description">Comprehensive project management
                                                        platform with team collaboration and time tracking.</p>
                                                    <a href="#" class="portfolio-link">View Project</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image"><img src="img/app/asset5.png"
                                                        alt="HR Management System" loading="lazy"></div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">HR Management System</h4>
                                                    <p class="portfolio-description">Complete HR solution with employee
                                                        management, payroll, and performance tracking.</p>
                                                    <a href="#" class="portfolio-link">View Project</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-button-prev"></div>
                                    <div class="swiper-button-next"></div>
                                    
                                </div>
                            </div> -->

                            <!-- ── Web Portals Development ────────────────── -->
                            <div id="web-portals" class="portfolio-grid">
                                <div class="subcategory-header">
                                    <h3>Web Portals Development</h3>
                                    <p>Secure and scalable web portals that connect users, streamline processes, and
                                        enhance collaboration.</p>
                                </div>
                                <div class="swiper port-swiper" id="sw-portals">
                                    <div class="swiper-wrapper">

                                        <!-- Dynamic Displays -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/potal/Asset13.jpeg" alt="Dynamic Displays" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Dynamic Displays</h4>
                                                    <p class="portfolio-description">
                                                        CRM platform with lead tracking, customer management, installation visits, and order pipeline.
                                                    </p>
                                                    <a href="https://dashboard.dynamicdisplays.co.nz/" target="_blank" class="portfolio-link">View More</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Bharat Shakti Tenders -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/potal/Asset262.jpeg" alt="Bharat Shakti Tenders" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Bharat Shakti Tenders</h4>
                                                    <p class="portfolio-description">
                                                        Tender management system for tracking GEM orders, invoices, and payments.
                                                    </p>
                                                    <a href="#" target="_blank" class="portfolio-link">View More</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Neer Savior -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/potal/Asset11.jpeg" alt="Neer Savior" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Neer Savior</h4>
                                                    <p class="portfolio-description">
                                                        Water tanker booking admin panel with size, type, pricing, and delivery management.
                                                    </p>
                                                    <a href="#" target="_blank" class="portfolio-link">View More</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Myskilly -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/potal/Asset8.jpeg" alt="Myskilly" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Myskilly</h4>
                                                    <p class="portfolio-description">
                                                        LMS admin panel for course creation, tutor management, and payments.
                                                    </p>
                                                    <a href="#" target="_blank" class="portfolio-link">View More</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Startup News India -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/potal/Asset9.jpeg" alt="Startup News India" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Startup News India</h4>
                                                    <p class="portfolio-description">
                                                        CMS for publishing startup news, blogs, categories, and managing users.
                                                    </p>
                                                    <a href="#" target="_blank" class="portfolio-link">View More</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Skilly -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/potal/Asset8.jpeg" alt="Skilly" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Skilly – Learn Earn Lead</h4>
                                                    <p class="portfolio-description">
                                                        AI-powered e-learning platform with video-based professional courses.
                                                    </p>
                                                    <a href="#" target="_blank" class="portfolio-link">View More</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Indobes -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/potal/Asset7.jpeg" alt="Indobes Portal" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Indobes Portal</h4>
                                                    <p class="portfolio-description">
                                                        Admin portal for managing news content, categories, and users.
                                                    </p>
                                                    <a href="#" target="_blank" class="portfolio-link">View More</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Dr Dipti -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/potal/Asset6.jpeg" alt="Dr Dipti" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Dental Clinic Management</h4>
                                                    <p class="portfolio-description">
                                                        Patient, treatment, payment, and clinic record management system.
                                                    </p>
                                                    <a href="#" target="_blank" class="portfolio-link">View More</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- BW Tasks -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/potal/Asset5.jpeg" alt="BW Tasks" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">BW Tasks</h4>
                                                    <p class="portfolio-description">
                                                        Task management platform with dashboard, KPIs, and team collaboration.
                                                    </p>
                                                    <a href="#" target="_blank" class="portfolio-link">View More</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- InfraKeys -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/potal/Asset9.jpeg" alt="InfraKeys" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">InfraKeys</h4>
                                                    <p class="portfolio-description">
                                                        Secure admin login system for infrastructure key management.
                                                    </p>
                                                    <a href="#" target="_blank" class="portfolio-link">View More</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Accord Hospital -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/potal/Asset3.jpeg" alt="Accord Hospital" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Accord Hospital</h4>
                                                    <p class="portfolio-description">
                                                        Patient portal with UHID login for accessing medical records.
                                                    </p>
                                                    <a href="#" target="_blank" class="portfolio-link">View More</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Login Screens -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/potal/Asset2.jpeg" alt="BW Tasks Login" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">BW Tasks Login</h4>
                                                    <p class="portfolio-description">
                                                        Dark themed login UI for team task management SaaS platform.
                                                    </p>
                                                    <a href="https://bwtask.bwdemo.in/" target="_blank" class="portfolio-link">View More</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- QED -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/potal/Asset265.jpeg" alt="QED Studio" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">QED's Studio</h4>
                                                    <p class="portfolio-description">
                                                        Minimal admin login panel for creative production platform.
                                                    </p>
                                                    <a href="https://dashboard.qedsstudio.com/" target="_blank" class="portfolio-link">View More</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Generic -->
                                        <!-- <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/potal/asset-4.png" alt="Generic Admin" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Generic Admin Panel</h4>
                                                    <p class="portfolio-description">
                                                        Clean blue-themed login UI for SaaS admin systems.
                                                    </p>
                                                    <a href="#" target="_blank" class="portfolio-link">View More</a>
                                                </div>
                                            </div>
                                        </div> -->

                                        <!-- Mack EV -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/potal/Asset263.jpeg" alt="Mack EV" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Mack EV</h4>
                                                    <p class="portfolio-description">
                                                        EV platform admin login with clean energy-focused UI.
                                                    </p>
                                                    <a href="https://mack-ev.com/" target="_blank" class="portfolio-link">View More</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Bharat Login -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/potal/Asset262.jpeg" alt="Bharat Login" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Bharat Tenders Login</h4>
                                                    <p class="portfolio-description">
                                                        Login with OTP and Google sign-in for tender platform users.
                                                    </p>
                                                    <a href="https://bharatshaktitenders.com/" target="_blank" class="portfolio-link">View More</a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="swiper-button-prev"></div>
                                    <div class="swiper-button-next"></div>

                                </div>
                            </div>

                            <!-- ── E-commerce Development ─────────────────── -->
                            <div id="ecommerce" class="portfolio-grid">
                                <div class="subcategory-header">
                                    <h3>E-commerce Development</h3>
                                    <p>Complete e-commerce solutions with secure payment gateways, inventory management,
                                        and user-friendly shopping experiences.</p>
                                </div>
                                <div class="swiper port-swiper" id="sw-ecom">
                                    <div class="swiper-wrapper">

                                        <!-- BDS Education -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/web/asset27.png" alt="BDS Education" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">BDS Education</h4>
                                                    <p class="portfolio-description">
                                                        An e-commerce platform for educational STEM products, offering ATL and Non-ATL kits including robots, DIY kits, and more.
                                                    </p>
                                                    <a href="https://bdseducation.in/" target="_blank" class="portfolio-link">View More</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Murliwala Aggarwal -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/web/asset26.png" alt="Murliwala Aggarwal" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Murliwala Aggarwal</h4>
                                                    <p class="portfolio-description">
                                                        A traditional sweets and snacks brand offering premium gift boxes and festive collections with PAN India delivery.
                                                    </p>
                                                    <a href="https://murliwalaaggarwal.com/" target="_blank" class="portfolio-link">View More</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Kanine -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/web/asset25.png" alt="Kanine" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Kanine</h4>
                                                    <p class="portfolio-description">
                                                        A premium pet products store offering accessories, apparel, and essentials for dogs and cats from top brands.
                                                    </p>
                                                    <a href="https://kanineindia.com/" target="_blank" class="portfolio-link">View More</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Industry Baba -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/web/asset28.png" alt="Industry Baba" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Industry Baba</h4>
                                                    <p class="portfolio-description">
                                                        India's leading B2B marketplace for industrial products including electricals, automation, and bulk supplies.
                                                    </p>
                                                    <a href="https://industrybaba.com/" target="_blank" class="portfolio-link">View More</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Softener Wala -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/web/asset24.png" alt="Softener Wala" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Softener Wala</h4>
                                                    <p class="portfolio-description">
                                                        An online store for water softening and purification solutions with RO systems and filtration equipment.
                                                    </p>
                                                    <a href="https://softenerwala.com/" target="_blank" class="portfolio-link">View More</a>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Denzour Nutrition -->
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image">
                                                    <img src="img/web/asset23.png" alt="Denzour Nutrition" loading="lazy">
                                                </div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Denzour Nutrition</h4>
                                                    <p class="portfolio-description">
                                                        A sports nutrition brand offering whey protein supplements for muscle building and recovery.
                                                    </p>
                                                    <a href="https://denzournutrition.com/" target="_blank" class="portfolio-link">View More</a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="swiper-button-prev"></div>
                                    <div class="swiper-button-next"></div>

                                </div>
                            </div>

                            <!-- ── SEO & SEM ───────────────────────────────── -->
                            <div id="seo-sem" class="portfolio-grid">
                                <div class="subcategory-header">
                                    <h3>SMM | SEO | SEM | SMO</h3>
                                    <p>Comprehensive digital marketing strategies to boost your online visibility, drive
                                        traffic, and increase conversions.</p>
                                </div>
                                <div class="swiper port-swiper" id="sw-seo">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image"><img src="img/seo/asset-1.png"
                                                        alt="E-commerce SEO Success" loading="lazy"></div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">E-commerce SEO Success</h4>
                                                    <p class="portfolio-description">Increased organic traffic by 300%
                                                        for a leading e-commerce platform through strategic SEO.</p>
                                                    <a href="#" class="portfolio-link">View Project</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image"><img src="img/seo/asset-2.png"
                                                        alt="Social Media Growth" loading="lazy"></div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Social Media Growth</h4>
                                                    <p class="portfolio-description">Achieved 500% follower growth and
                                                        200% engagement increase for a lifestyle brand.</p>
                                                    <a href="#" class="portfolio-link">View Project</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image"><img src="img/seo/asset-3.png"
                                                        alt="PPC Campaign Success" loading="lazy"></div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">PPC Campaign Success</h4>
                                                    <p class="portfolio-description">Reduced cost per acquisition by 40%
                                                        while increasing conversion rate by 25%.</p>
                                                    <a href="#" class="portfolio-link">View Project</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image"><img src="img/seo/asset-4.png"
                                                        alt="Local SEO Strategy" loading="lazy"></div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Local SEO Strategy</h4>
                                                    <p class="portfolio-description">Boosted local search visibility and
                                                        in-store visits for a retail chain.</p>
                                                    <a href="#" class="portfolio-link">View Project</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-button-prev"></div>
                                    <div class="swiper-button-next"></div>

                                </div>
                            </div>

                            <!-- ── GMB Optimization ───────────────────────── -->
                            <div id="gmb-optimization" class="portfolio-grid">
                                <div class="subcategory-header">
                                    <h3>Google My Business (GMB) Optimization</h3>
                                    <p>Strategic optimization of your Google Business Profile to improve local search
                                        visibility and customer engagement.</p>
                                </div>
                                <div class="swiper port-swiper" id="sw-gmb">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image"><img src="img/seo/asset-5.png"
                                                        alt="GMB Optimization" loading="lazy"></div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Restaurant GMB Optimization</h4>
                                                    <p class="portfolio-description">Increased restaurant bookings by
                                                        45% through strategic GMB optimization and review management.
                                                    </p>
                                                    <a href="#" class="portfolio-link">View Project</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image"><img src="img/seo/asset-6.png"
                                                        alt="GMB Optimization" loading="lazy"></div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Retail Store GMB Strategy</h4>
                                                    <p class="portfolio-description">Enhanced local visibility with
                                                        optimized GMB profile resulting in 60% more store visits.</p>
                                                    <a href="#" class="portfolio-link">View Project</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-button-prev"></div>
                                    <div class="swiper-button-next"></div>

                                </div>
                            </div>

                            <!-- ── WhatsApp Marketing ──────────────────────── -->
                            <div id="whatsapp-marketing" class="portfolio-grid">
                                <div class="subcategory-header">
                                    <h3>WhatsApp Marketing & Automation</h3>
                                    <p>Leverage WhatsApp's reach for effective marketing campaigns and automated
                                        customer interactions.</p>
                                </div>
                                <div class="swiper port-swiper" id="sw-wam">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image"><img src="img/seo/asset-7.png"
                                                        alt="WhatsApp Marketing" loading="lazy"></div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">WhatsApp Campaign Success</h4>
                                                    <p class="portfolio-description">Achieved 85% open rate and 35%
                                                        conversion rate with targeted WhatsApp marketing campaign.</p>
                                                    <a href="#" class="portfolio-link">View Project</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-button-prev"></div>
                                    <div class="swiper-button-next"></div>

                                </div>
                            </div>

                            <!-- ── WhatsApp API ────────────────────────────── -->
                            <div id="whatsapp-api" class="portfolio-grid">
                                <div class="subcategory-header">
                                    <h3>WhatsApp API Integration</h3>
                                    <p>Seamless WhatsApp API integration for automated customer support and business
                                        communications.</p>
                                </div>
                                <div class="swiper port-swiper" id="sw-waapi">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image"><img src="img/whatsapp/asset-25.png"
                                                        alt="WhatsApp API 25" loading="lazy"></div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">E-commerce WhatsApp Integration</h4>
                                                    <p class="portfolio-description">Automated order updates and
                                                        customer support through WhatsApp API integration.</p><a
                                                        href="#" class="portfolio-link">View Project</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image"><img src="img/whatsapp/asset-26.png"
                                                        alt="WhatsApp API 26" loading="lazy"></div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">E-commerce WhatsApp Integration</h4>
                                                    <p class="portfolio-description">Automated order updates and
                                                        customer support through WhatsApp API integration.</p><a
                                                        href="#" class="portfolio-link">View Project</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image"><img src="img/whatsapp/asset-27.png"
                                                        alt="WhatsApp API 27" loading="lazy"></div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">E-commerce WhatsApp Integration</h4>
                                                    <p class="portfolio-description">Automated order updates and
                                                        customer support through WhatsApp API integration.</p><a
                                                        href="#" class="portfolio-link">View Project</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image"><img src="img/whatsapp/asset-28.png"
                                                        alt="WhatsApp API 28" loading="lazy"></div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">E-commerce WhatsApp Integration</h4>
                                                    <p class="portfolio-description">Automated order updates and
                                                        customer support through WhatsApp API integration.</p><a
                                                        href="#" class="portfolio-link">View Project</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image"><img src="img/whatsapp/asset-29.png"
                                                        alt="WhatsApp API 29" loading="lazy"></div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">E-commerce WhatsApp Integration</h4>
                                                    <p class="portfolio-description">Automated order updates and
                                                        customer support through WhatsApp API integration.</p><a
                                                        href="#" class="portfolio-link">View Project</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image"><img src="img/whatsapp/asset-30.png"
                                                        alt="WhatsApp API 30" loading="lazy"></div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">E-commerce WhatsApp Integration</h4>
                                                    <p class="portfolio-description">Automated order updates and
                                                        customer support through WhatsApp API integration.</p><a
                                                        href="#" class="portfolio-link">View Project</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image"><img src="img/whatsapp/asset-31.png"
                                                        alt="WhatsApp API 31" loading="lazy"></div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">E-commerce WhatsApp Integration</h4>
                                                    <p class="portfolio-description">Automated order updates and
                                                        customer support through WhatsApp API integration.</p><a
                                                        href="#" class="portfolio-link">View Project</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image"><img src="img/whatsapp/asset-32.png"
                                                        alt="WhatsApp API 32" loading="lazy"></div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">E-commerce WhatsApp Integration</h4>
                                                    <p class="portfolio-description">Automated order updates and
                                                        customer support through WhatsApp API integration.</p><a
                                                        href="#" class="portfolio-link">View Project</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image"><img src="img/whatsapp/asset-33.png"
                                                        alt="WhatsApp API 33" loading="lazy"></div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">E-commerce WhatsApp Integration</h4>
                                                    <p class="portfolio-description">Automated order updates and
                                                        customer support through WhatsApp API integration.</p><a
                                                        href="#" class="portfolio-link">View Project</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-button-prev"></div>
                                    <div class="swiper-button-next"></div>

                                </div>
                            </div>

                            <!-- ══ Media Buying — dual logo marquee swipers ═══ -->
                            <div id="media-buying" class="portfolio-grid">
                                <div class="subcategory-header">
                                    <h3>Media Buying</h3>
                                    <p>Strategic media buying services to maximize your advertising ROI across premium
                                        platforms.</p>
                                </div>
                                <!-- Row 1: left → right -->
                                <div class="logo-swiper-row">
                                    <div class="swiper logo-swiper" id="logo-ltr-mb">
                                        <div class="swiper-wrapper" id="logo-ltr-mb-wrap"></div>
                                    </div>
                                </div>
                                <!-- Row 2: right → left -->
                                <div class="logo-swiper-row">
                                    <div class="swiper logo-swiper" id="logo-rtl-mb">
                                        <div class="swiper-wrapper" id="logo-rtl-mb-wrap"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- ── Print Media ─────────────────────────────── -->
                            <!-- <div id="print-media" class="portfolio-grid">
                                <div class="subcategory-header">
                                    <h3>Print Media Advertising</h3>
                                    <p>Strategic print media campaigns for maximum brand visibility and credibility.</p>
                                </div>
                                <div class="swiper port-swiper" id="sw-print">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image"><img
                                                        src="https://via.placeholder.com/400x250/2C3E50/ffffff?text=Print+Media+Campaign"
                                                        alt="Print Media Campaign" loading="lazy"></div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">Newspaper Advertisement Campaign</h4>
                                                    <p class="portfolio-description">Strategic newspaper advertising
                                                        campaign across major publications for brand awareness.</p>
                                                    <a href="#" class="portfolio-link">View Project</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-button-prev"></div>
                                    <div class="swiper-button-next"></div>
                                    <div class="swiper-pagination"></div>
                                </div>
                            </div> -->

                            <!-- ── Digital Advertising ────────────────────── -->
                            <div id="digital-advertising" class="portfolio-grid">
                                <div class="subcategory-header">
                                    <h3>Mobile Advertising, Radio, Cinema</h3>
                                    <p>AMPLIFY YOUR BRAND WITH A POWERFUL BLEND OF ATL REACH AND BTL PRECISION</p>
                                </div>
                                <div class="swiper port-swiper" id="sw-digital">
                                    <div class="swiper-wrapper">
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image"><img
                                                        src="https://via.placeholder.com/400x250/FF6B6B/ffffff?text=AUTO+RICKSHAW+BRANDING"
                                                        alt="Auto Rickshaw Branding" loading="lazy"></div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">AUTO RICKSHAW BRANDING</h4>
                                                    <p class="portfolio-description">Strategic auto rickshaw branding
                                                        campaign for maximum local visibility and brand recognition.</p>
                                                    <a href="#" class="portfolio-link">View Project</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image"><img
                                                        src="https://via.placeholder.com/400x250/FFD93D/333333?text=RADIO+BRANDING"
                                                        alt="Radio Branding" loading="lazy"></div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">RADIO BRANDING</h4>
                                                    <p class="portfolio-description">Effective radio advertising
                                                        campaigns with strategic placement and compelling audio content.
                                                    </p>
                                                    <a href="#" class="portfolio-link">View Project</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image"><img
                                                        src="https://via.placeholder.com/400x250/43e97b/ffffff?text=BUS+BRANDING"
                                                        alt="Bus Branding" loading="lazy"></div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">BUS BRANDING</h4>
                                                    <p class="portfolio-description">High-impact bus branding campaigns
                                                        for maximum visibility across urban areas.</p>
                                                    <a href="#" class="portfolio-link">View Project</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="swiper-slide">
                                            <div class="portfolio-card">
                                                <div class="portfolio-image"><img
                                                        src="https://via.placeholder.com/400x250/4facfe/ffffff?text=CINEMA+ADVERTISING"
                                                        alt="Cinema Advertising" loading="lazy"></div>
                                                <div class="portfolio-card-body">
                                                    <h4 class="portfolio-title">CINEMA ADVERTISING</h4>
                                                    <p class="portfolio-description">Engaging cinema advertising
                                                        campaigns targeting captive audiences for maximum impact.</p>
                                                    <a href="#" class="portfolio-link">View Project</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-button-prev"></div>
                                    <div class="swiper-button-next"></div>
                                    <div class="swiper-pagination"></div>
                                </div>
                            </div>

                            <!-- ══ Logo Design — dual logo marquee swipers ════ -->
                            <div id="logo-design" class="portfolio-grid">
                                <div class="subcategory-header">
                                    <h3>Logo Designing</h3>
                                    <p>Creative and memorable logo designs that represent your brand identity perfectly
                                        and leave a lasting impression.</p>
                                </div>
                                <!-- Row 1: left → right -->
                                <div class="logo-swiper-row">
                                    <div class="swiper logo-swiper" id="logo-ltr-ld">
                                        <div class="swiper-wrapper" id="logo-ltr-ld-wrap"></div>
                                    </div>
                                </div>
                                <!-- Row 2: right → left -->
                                <div class="logo-swiper-row">
                                    <div class="swiper logo-swiper" id="logo-rtl-ld">
                                        <div class="swiper-wrapper" id="logo-rtl-ld-wrap"></div>
                                    </div>
                                </div>
                            </div>

                            <div id="dynamic-content"></div>
                        </div>
                    </div><!-- /col-md-8 -->

                </div><!-- /row -->
            </div>
        </div>
    </div>


    <?php include 'components/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="js/index.js"></script>

    <!-- Marquee rows (your original script — unchanged) -->
    <script>
        const row1Imgs = [
            "img/portfolio/Asset342.jpeg", "img/portfolio/Asset352.jpeg", "img/portfolio/Asset362.jpeg",
            "img/portfolio/Asset372.jpeg", "img/portfolio/Asset382.jpeg", "img/portfolio/Asset392.jpeg",
            "img/portfolio/Asset402.jpeg", "img/portfolio/Asset412.jpeg", "img/portfolio/Asset422.jpeg",
            "img/portfolio/Asset432.jpeg", "img/portfolio/Asset442.jpeg", "img/portfolio/Asset452.jpeg",
            "img/portfolio/Asset462.jpeg", "img/portfolio/Asset472.jpeg",
            "img/portfolio/194.jpeg", "img/portfolio/195.jpeg", "img/portfolio/196.jpeg",
            "img/portfolio/197.jpeg", "img/portfolio/198.jpeg"
        ];

        const row2Imgs = [
            "img/portfolio/Asset482.jpeg", "img/portfolio/Asset492.jpeg", "img/portfolio/Asset222.jpeg",
            "img/portfolio/Asset232.jpeg", "img/portfolio/Asset242.jpeg", "img/portfolio/Asset252.jpeg",
            "img/portfolio/Asset262.jpeg", "img/portfolio/Asset272.jpeg", "img/portfolio/Asset282.jpeg",
            "img/portfolio/Asset292.jpeg", "img/portfolio/Asset302.jpeg", "img/portfolio/Asset312.jpeg",
            "img/portfolio/Asset322.jpeg", "img/portfolio/Asset332.jpeg",
            "img/portfolio/200.jpeg", "img/portfolio/201.jpeg", "img/portfolio/202.jpeg", "img/portfolio/193.jpeg"
        ];

        function buildRow(id, imgs) {
            const row = document.getElementById(id);
            [...imgs, ...imgs].forEach(src => {
                const card = document.createElement('div');
                card.className = 'proj-card';
                card.innerHTML = `<img src="${src}" alt="Portfolio Project" loading="lazy">`;
                row.appendChild(card);
            });
        }

        buildRow('row1', row1Imgs);
        buildRow('row2', row2Imgs);
    </script>

    <!-- Your original sidebar navigation script — unchanged -->
    <script>
        let activeCategory = null;
        let activeSubcategory = null;

        function toggleCategory(categoryName) {
            const categoryList = document.getElementById(categoryName + '-list');
            const categoryIcon = document.getElementById(categoryName + '-icon');
            const categoryBtn = event.target.closest('.category-btn');

            document.querySelectorAll('.subcategory-list').forEach(list => {
                if (list.id !== categoryName + '-list') list.classList.remove('show');
            });
            document.querySelectorAll('.category-btn').forEach(btn => {
                if (btn !== categoryBtn) {
                    btn.classList.remove('active');
                    const icon = btn.querySelector('i:last-child');
                    if (icon) {
                        icon.classList.remove('bi-chevron-up');
                        icon.classList.add('bi-chevron-down');
                    }
                }
            });

            if (activeCategory === categoryName) {
                categoryList.classList.remove('show');
                categoryBtn.classList.remove('active');
                categoryIcon.classList.remove('bi-chevron-up');
                categoryIcon.classList.add('bi-chevron-down');
                activeCategory = null;
                showDefaultView();
            } else {
                categoryList.classList.add('show');
                categoryBtn.classList.add('active');
                categoryIcon.classList.remove('bi-chevron-down');
                categoryIcon.classList.add('bi-chevron-up');
                activeCategory = categoryName;
            }

            document.querySelectorAll('.subcategory-btn').forEach(btn => btn.classList.remove('active'));
            activeSubcategory = null;
        }

        function showSubcategory(subcategoryName) {
            document.querySelectorAll('.subcategory-btn').forEach(btn => btn.classList.remove('active'));
            event.target.classList.add('active');
            activeSubcategory = subcategoryName;

            document.querySelectorAll('.portfolio-grid').forEach(grid => grid.classList.remove('active'));
            const targetGrid = document.getElementById(subcategoryName);
            if (targetGrid) targetGrid.classList.add('active');

            // Init logo marquee swipers on first open
            if (subcategoryName === 'media-buying' || subcategoryName === 'logo-design') {
                initLogoSwipers();
            }
        }

        function showAllProjects() {
            document.querySelectorAll('.category-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.subcategory-btn').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.subcategory-list').forEach(list => list.classList.remove('show'));
            event.target.classList.add('active');
            document.querySelectorAll('.portfolio-grid').forEach(grid => grid.classList.remove('active'));
            document.getElementById('default-view').classList.add('active');
            activeCategory = null;
            activeSubcategory = null;
        }

        function showDefaultView() {
            document.querySelectorAll('.portfolio-grid').forEach(grid => grid.classList.remove('active'));
            document.getElementById('default-view').classList.add('active');
        }

        document.addEventListener('DOMContentLoaded', function() {
            showDefaultView();
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    document.querySelectorAll('.category-btn').forEach(btn => btn.classList.remove('active'));
                    document.querySelectorAll('.subcategory-list').forEach(list => list.classList.remove('show'));
                    document.querySelectorAll('.subcategory-btn').forEach(btn => btn.classList.remove('active'));
                    activeCategory = null;
                    activeSubcategory = null;
                    showDefaultView();
                }
            });

            // Init all project swipers
            const projSwipers = [
                'sw-all', 'sw-website', 'sw-webapp', 'sw-portals', 'sw-ecom',
                'sw-seo', 'sw-gmb', 'sw-wam', 'sw-waapi', 'sw-print', 'sw-digital'
            ];
            projSwipers.forEach(id => {
                new Swiper('#' + id, {
                    slidesPerView: 1,
                    spaceBetween: 24,
                    navigation: {
                        nextEl: '#' + id + ' .swiper-button-next',
                        prevEl: '#' + id + ' .swiper-button-prev',
                    },
                    pagination: {
                        el: '#' + id + ' .swiper-pagination',
                        clickable: true,
                    },
                    breakpoints: {
                        768: {
                            slidesPerView: 2
                        }
                    }
                });
            });
        });
    </script>

    <!-- Logo marquee swipers (lazy init) -->
    <script>
        const prlogos = [{
                src: 'img/pr-logo/abp.webp',
                alt: 'ABP'
            },
            {
                src: 'img/pr-logo/ani.webp',
                alt: 'ANI'
            },
            {
                src: 'img/pr-logo/businessstandard.webp',
                alt: 'Business Standard'
            },
            {
                src: 'img/pr-logo/business-world.webp',
                alt: 'Business World'
            },
            {
                src: 'img/pr-logo/chronicle.webp',
                alt: 'Chronicle'
            },
            {
                src: 'img/pr-logo/cnbc.webp',
                alt: 'CNBC'
            },
            {
                src: 'img/pr-logo/dh.webp',
                alt: 'DH'
            },
            {
                src: 'img/pr-logo/dna.webp',
                alt: 'DNA'
            },
            {
                src: 'img/pr-logo/financial-express.webp',
                alt: 'Financial Express'
            },
            {
                src: 'img/pr-logo/hindustan-times.webp',
                alt: 'Hindustan Times'
            },
            {
                src: 'img/pr-logo/indian-express.webp',
                alt: 'Indian Express'
            },
            {
                src: 'img/pr-logo/indiatoday.webp',
                alt: 'India Today'
            },
            {
                src: 'img/pr-logo/lastestly.webp',
                alt: 'Latestly'
            },
            {
                src: 'img/pr-logo/live-mint.webp',
                alt: 'Live Mint'
            },
            {
                src: 'img/pr-logo/lokmat-times.webp',
                alt: 'Lokmat Times'
            },
            {
                src: 'img/pr-logo/mid-day.webp',
                alt: 'Mid-Day'
            },
            {
                src: 'img/pr-logo/ndtv.webp',
                alt: 'NDTV'
            },
            {
                src: 'img/pr-logo/one-india.webp',
                alt: 'One India'
            },
            {
                src: 'img/pr-logo/outlook.webp',
                alt: 'Outlook'
            },
            {
                src: 'img/pr-logo/republic.webp',
                alt: 'Republic'
            },
            {
                src: 'img/pr-logo/the-asianage.webp',
                alt: 'The Asian Age'
            },
            {
                src: 'img/pr-logo/the-hindu.webp',
                alt: 'The Hindu'
            },
            {
                src: 'img/pr-logo/thepioneer.webp',
                alt: 'The Pioneer'
            },
            {
                src: 'img/pr-logo/the-print.webp',
                alt: 'The Print'
            },
            {
                src: 'img/pr-logo/zee5.webp',
                alt: 'Zee5'
            },
            {
                src: 'img/pr-logo/zee-business.webp',
                alt: 'Zee Business'
            },
            {
                src: 'img/pr-logo/zee-news.webp',
                alt: 'Zee News'
            },
        ];

        const logosDesgin = [{
                src: "img/logos/Asset1.png",
                alt: "Tuitionwala"
            },
            {
                src: "img/logos/Asset2.png",
                alt: "Smudged Burgers & Beyond"
            },
            {
                src: "img/logos/Asset3.png",
                alt: "Naukari Fly"
            },
            {
                src: "img/logos/Asset4.png",
                alt: "Digi Ninjas"
            },
            {
                src: "img/logos/Asset5.png",
                alt: "BDIM"
            },
            {
                src: "img/logos/Asset6.png",
                alt: "Fitness Brand"
            },
            {
                src: "img/logos/Asset7.png",
                alt: "Wanderlust Trail"
            },
            {
                src: "img/logos/Asset8.png",
                alt: "Cafe Noir"
            },
            {
                src: "img/logos/Asset9.png",
                alt: "Giraffe"
            },
            {
                src: "img/logos/Asset10.png",
                alt: "Hunger Bowl"
            },
            {
                src: "img/logos/Asset11.png",
                alt: "Vanakkam"
            },
            {
                src: "img/logos/Asset12.png",
                alt: "Industry Baba"
            },
            {
                src: "img/logos/Asset13.png",
                alt: "Packit"
            },
            {
                src: "img/logos/Asset14.png",
                alt: "Ninja Porter"
            },
            {
                src: "img/logos/Asset15.png",
                alt: "Branding Owl"
            },
            {
                src: "img/logos/Asset16.png",
                alt: "The Corporate Monk"
            },
            {
                src: "img/logos/Asset17.png",
                alt: "Panamax"
            },
            {
                src: "img/logos/Asset18.png",
                alt: "Wafly"
            },
            {
                src: "img/logos/Asset19.png",
                alt: "Job Ready"
            },
            {
                src: "img/logos/Asset20.png",
                alt: "Catalyst"
            },
            {
                src: "img/logos/Asset21.png",
                alt: "Vedant Pain Management Clinic"
            },
            {
                src: "img/logos/Asset22.png",
                alt: "Cokey"
            },
            {
                src: "img/logos/Asset23.png",
                alt: "Annica HealthTech"
            },
            {
                src: "img/logos/Asset24.png",
                alt: "The Parts App"
            },
            {
                src: "img/logos/Asset25.png",
                alt: "Fitness Gurukul"
            }
        ];


        function fillLogoWrap(wrapId) {
            const wrap = document.getElementById(wrapId);
            if (!wrap || wrap.children.length > 0) return;

            const isPR = wrapId.includes('-mb-');
            const list = isPR ? prlogos : logosDesgin;

            [...list, ...list, ...list].forEach(item => {
                const slide = document.createElement('div');
                slide.className = 'swiper-slide';

                slide.innerHTML = `
                <div class="portfolio-card pr-logo">
                    <div class="portfolio-image">
                        <img src="${item.src}" alt="${item.alt}" loading="lazy">
                    </div>
                </div>
            `;
                wrap.appendChild(slide);
            });
        }

        function createLogoSwiper(id, reverse = false) {
            return new Swiper('#' + id, {
                slidesPerView: 'auto',
                spaceBetween: 16,
                loop: true,
                speed: 3000,

                autoplay: {
                    delay: 1, // FIXED
                    disableOnInteraction: false,
                    reverseDirection: reverse,
                    pauseOnMouseEnter: false
                },

                allowTouchMove: false,

                freeMode: {
                    enabled: true,
                    momentum: false
                },

                observer: true,
                observeParents: true,
            });
        }

        let swipers = [];
        let logoSwipersDone = false;

        function initLogoSwipers() {
            if (logoSwipersDone) return;
            logoSwipersDone = true;

            ['logo-ltr-mb-wrap', 'logo-rtl-mb-wrap', 'logo-ltr-ld-wrap', 'logo-rtl-ld-wrap'].forEach(fillLogoWrap);

            swipers.push(createLogoSwiper('logo-ltr-mb', false));
            swipers.push(createLogoSwiper('logo-ltr-ld', false));
            swipers.push(createLogoSwiper('logo-rtl-mb', true));
            swipers.push(createLogoSwiper('logo-rtl-ld', true));
        }

        // INIT
        document.addEventListener('DOMContentLoaded', initLogoSwipers);

        // TAB SWITCH FIX
        document.addEventListener("visibilitychange", () => {
            if (!document.hidden) {
                swipers.forEach(swiper => swiper.autoplay.start());
            }
        });

        // WINDOW FOCUS FIX
        window.addEventListener('focus', () => {
            swipers.forEach(swiper => swiper.autoplay.start());
        });
    </script>

</body>

</html>