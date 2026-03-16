<?php
include 'backend/db.php';

// ── Auto-add slug column if it doesn't exist ──────────────────────────────
$col_check = mysqli_query($conn, "SHOW COLUMNS FROM `city` LIKE 'slug'");
if (mysqli_num_rows($col_check) === 0) {
    mysqli_query($conn, "ALTER TABLE `city` ADD `slug` VARCHAR(255) NULL AFTER `hero_subheading`");
}


// ── Auto-generate slug for any rows that don't have one ──────────────────
$missing = mysqli_query($conn, "SELECT id, heading FROM `city` WHERE slug IS NULL OR slug = ''");
while ($row = mysqli_fetch_assoc($missing)) {
    $base_slug = strtolower(trim($row['heading']));
    $base_slug = preg_replace('/[^a-z0-9\s-]/', '', $base_slug);
    $base_slug = preg_replace('/\s+/', '-', $base_slug);
    $base_slug = trim($base_slug, '-');

    // Make unique — append -2, -3 etc if slug already exists
    $slug_candidate = $base_slug;
    $counter = 2;
    while (true) {
        $sc = mysqli_real_escape_string($conn, $slug_candidate);
        $exists = mysqli_query($conn, "SELECT id FROM `city` WHERE slug = '$sc' AND id != '{$row['id']}'");
        if (mysqli_num_rows($exists) === 0) break;
        $slug_candidate = $base_slug . '-' . $counter++;
    }
    $safe_slug = mysqli_real_escape_string($conn, $slug_candidate);
    mysqli_query($conn, "UPDATE `city` SET slug = '$safe_slug' WHERE id = '{$row['id']}'");
}
// ─────────────────────────────────────────────────────────────────────────

// Get city by slug or id
if (!empty($_GET['slug'])) {
    $slug = mysqli_real_escape_string($conn, $_GET['slug']);
    $result = mysqli_query($conn, "SELECT * FROM `city` WHERE slug = '$slug' LIMIT 1");
} elseif (!empty($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = mysqli_query($conn, "SELECT * FROM `city` WHERE id = '$id' LIMIT 1");
} else {
    header('location: index.html');
    exit;
}

$city = mysqli_fetch_assoc($result);
if (!$city) {
    header('location: index.html');
    exit;
}






// Decode JSON fields
$images       = json_decode($city['images'] ?? '[]', true) ?: [];
$descriptions = json_decode($city['description_section'] ?? '[]', true) ?: [];
$feature_data = json_decode($city['feature_section'] ?? '{}', true) ?: [];
$faqs         = json_decode($city['faq_section'] ?? '[]', true) ?: [];
$features     = $feature_data['features'] ?? [];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($city['meta_title'] ?: $city['heading']) ?></title>
    <meta name="description" content="<?= htmlspecialchars($city['meta_description'] ?? '') ?>">
    <meta name="keywords" content="<?= htmlspecialchars($city['keywords'] ?? '') ?>">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="css/index.css">

    <style>
        :root {
            --dark-bg: #0f0f0f;
            --dark-color: #1a1a1a;
            --border-color: #2a2a2a;
            --accent-color: #ffc107;
            --text-light: #ffffff;
            --text-muted: #b0b0b0;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background: var(--dark-bg);
            color: var(--text-light);
            font-family: 'Segoe UI', sans-serif;
        }

        .brand-eyebrow {
            font-size: 11px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--accent-color, #ffc107);
            margin-bottom: 18px;
            font-weight: 600;
        }

        /* ── HERO ── */
        .city-hero {
            background: var(--dark-bg);
            padding: 120px 60px 80px;
            border-bottom: 1px solid var(--border-color);
            position: relative;
            overflow: hidden;
        }

        .city-hero::before {
            content: '';
            position: absolute;
            top: -200px;
            right: -200px;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(255, 193, 7, 0.06) 0%, transparent 70%);
            pointer-events: none;
        }

        .hero-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
        }

        .hero-eyebrow {
            font-size: 11px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--accent-color);
            font-weight: 700;
            margin-bottom: 20px;
        }

        .hero-heading {
            font-family: 'Bebas Neue', cursive;
            font-size: clamp(52px, 6vw, 88px);
            line-height: 0.92;
            color: var(--text-light);
            letter-spacing: 2px;
            margin-bottom: 28px;
        }

        .hero-heading .accent {
            color: var(--accent-color);
        }

        .hero-divider {
            width: 44px;
            height: 3px;
            background: var(--accent-color);
            border-radius: 2px;
            margin-bottom: 24px;
        }

        .hero-subheading {
            font-size: 13px;
            font-weight: 700;
            color: var(--accent-color, #ffc107);
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 16px;
        }

        /* Hero image / gallery preview */
        .hero-gallery {
            position: relative;
        }

        .hero-main-img {
            width: 100%;
            height: 420px;
            object-fit: cover;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            display: block;
        }

        .hero-no-img {
            width: 100%;
            height: 420px;
            background: var(--dark-color);
            border-radius: 8px;
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-no-img i {
            font-size: 64px;
            color: var(--border-color);
        }

        .img-count-badge {
            position: absolute;
            bottom: 16px;
            right: 16px;
            background: rgba(0, 0, 0, 0.75);
            backdrop-filter: blur(6px);
            border: 1px solid var(--border-color);
            color: var(--text-light);
            font-size: 12px;
            font-weight: 600;
            padding: 6px 14px;
            border-radius: 20px;
            letter-spacing: 1px;
        }

        /* ── GALLERY STRIP ── */
        .gallery-section {
            background: var(--dark-color);
            padding: 70px 60px;
            border-bottom: 1px solid var(--border-color);
        }

        .section-eyebrow {
            font-size: 11px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: var(--accent-color);
            font-weight: 700;
            margin-bottom: 16px;
        }

        .section-title {
            font-family: 'Bebas Neue', cursive;
            font-size: clamp(36px, 5vw, 60px);
            color: var(--text-light);
            letter-spacing: 2px;
            margin-bottom: 40px;
        }

        .section-title span {
            color: var(--accent-color);
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 16px;
        }

        .gallery-grid-item {
            position: relative;
            overflow: hidden;
            border-radius: 6px;
            border: 1px solid var(--border-color);
            cursor: pointer;
        }

        .gallery-grid-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            display: block;
            transition: transform 0.4s ease;
        }

        .gallery-grid-item:hover img {
            transform: scale(1.06);
        }

        .gallery-grid-item .overlay {
            position: absolute;
            inset: 0;
            background: rgba(255, 193, 7, 0.12);
            opacity: 0;
            transition: opacity 0.3s;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .gallery-grid-item:hover .overlay {
            opacity: 1;
        }

        .gallery-grid-item .overlay i {
            font-size: 28px;
            color: var(--accent-color);
        }

        /* ── DESCRIPTION ── */
        .description-section {
            background: var(--dark-bg);
            padding: 100px 60px;
            border-bottom: 1px solid var(--border-color);
        }

        .desc-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 340px 1fr;
            gap: 80px;
            align-items: start;
        }

        .desc-sticky {
            position: sticky;
            top: 100px;
        }

        .desc-para {
            font-size: 16px;
            color: var(--text-muted);
            line-height: 1.9;

        }



        /* ── FEATURES ── */
        .features-section {
            background: var(--dark-color);
            padding: 100px 60px;
            border-bottom: 1px solid var(--border-color);
        }

        .feature-heading {
            font-size: clamp(32px, 4vw, 52px);
        }

        .features-inner {
            max-width: 1200px;
            margin: 0 auto;
        }

        .features-header {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: end;
            margin-bottom: 70px;
        }

        .features-main-desc {
            font-size: 15px;
            color: var(--text-muted);
            line-height: 1.8;
            padding-top: 12px;
        }

        .features-list {
            border-top: 1px solid var(--border-color);
        }

        .feature-item {
            display: grid;
            grid-template-columns: 80px 1fr 1fr;
            gap: 40px;
            align-items: start;
            padding: 44px 0;
            border-bottom: 1px solid var(--border-color);
            transition: background 0.3s, padding 0.3s;
            cursor: default;
        }

        .feature-item:hover {
            background: rgba(255, 193, 7, 0.03);
            padding-left: 16px;
            padding-right: 16px;
            margin: 0 -16px;
            border-radius: 6px;
        }

        .feature-num {
            font-family: 'Bebas Neue', cursive;
            font-size: 16px;
            color: var(--accent-color);
            letter-spacing: 1px;
            padding-top: 6px;
        }

        .feature-heading {
            font-family: 'Bebas Neue', cursive;
            font-size: clamp(28px, 3.5vw, 44px);
            color: var(--text-light);
            letter-spacing: 1px;
            line-height: 1;
        }

        .feature-heading span {
            color: var(--accent-color);
        }

        .feature-desc {
            font-size: 15px;
            color: var(--text-muted);
            line-height: 1.8;
            padding-top: 6px;
        }

        /* ── FAQ ── */
        .faq-section {
            background: var(--dark-bg);
            padding: 100px 60px;
        }

        .faq-inner {
            max-width: 1200px;
            margin: 0 auto;
        }

        .faq-layout {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 80px;
        }

        .faq-sidebar-sticky {
            position: sticky;
            top: 100px;
        }

        .faq-item-block {
            border-bottom: 1px solid var(--border-color);
        }

        .faq-question-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 28px 0;
            cursor: pointer;
            gap: 20px;
        }

        .faq-question-row h3 {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-light);
            line-height: 1.5;
            flex: 1;
        }

        .faq-icon-box {
            width: 32px;
            height: 32px;
            border: 1px solid var(--border-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: background 0.3s, border-color 0.3s;
        }

        .faq-icon-box i {
            font-size: 14px;
            color: var(--text-muted);
            transition: transform 0.3s, color 0.3s;
        }

        .faq-item-block.open .faq-icon-box {
            background: var(--accent-color);
            border-color: var(--accent-color);
        }

        .faq-item-block.open .faq-icon-box i {
            transform: rotate(45deg);
            color: #0f0f0f;
        }

        .faq-answer-body {
            display: none;
            padding: 0 0 28px;
        }

        .faq-answer-body p {
            font-size: 15px;
            color: var(--text-muted);
            line-height: 1.8;
        }

        .faq-item-block.open .faq-answer-body {
            display: block;
        }

        /* ── LIGHTBOX ── */
        .lightbox-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.92);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }

        .lightbox-overlay.active {
            display: flex;
        }

        .lightbox-img {
            max-width: 90vw;
            max-height: 85vh;
            border-radius: 6px;
            object-fit: contain;
        }

        .lightbox-close {
            position: absolute;
            top: 24px;
            right: 30px;
            font-size: 32px;
            color: #fff;
            cursor: pointer;
            line-height: 1;
            opacity: 0.7;
            transition: opacity 0.2s;
        }

        .lightbox-close:hover {
            opacity: 1;
        }

        .lightbox-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #fff;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            cursor: pointer;
            transition: background 0.2s;
        }

        .lightbox-nav:hover {
            background: var(--accent-color);
            color: #0f0f0f;
        }

        .lightbox-nav.prev {
            left: 24px;
        }

        .lightbox-nav.next {
            right: 24px;
        }

        /* ── CTA BANNER ── */
        .cta-banner {
            background: var(--dark-color);
            border-top: 1px solid var(--border-color);
            border-bottom: 1px solid var(--border-color);
            padding: 80px 60px;
            text-align: center;
        }

        .cta-banner h2 {
            font-family: 'Bebas Neue', cursive;
            font-size: clamp(40px, 5vw, 72px);
            letter-spacing: 2px;
            color: var(--text-light);
            margin-bottom: 20px;
        }

        .cta-banner h2 span {
            color: var(--accent-color);
        }

        .cta-banner p {
            font-size: 16px;
            color: var(--text-muted);
            margin-bottom: 36px;
        }

        .btn-primary-gold {
            background: var(--accent-color);
            color: #0f0f0f;
            padding: 14px 36px;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            border-radius: 3px;
            text-decoration: none;
            display: inline-block;
            transition: opacity 0.2s, transform 0.2s;
            border: none;
        }

        .btn-primary-gold:hover {
            opacity: 0.85;
            transform: translateY(-2px);
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 1024px) {

            .hero-inner,
            .desc-inner,
            .features-header,
            .faq-layout {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .desc-sticky,
            .faq-sidebar-sticky {
                position: static;
            }

            .feature-item {
                grid-template-columns: 60px 1fr;
            }

            .feature-desc {
                grid-column: 2;
            }
        }

        @media (max-width: 768px) {

            .city-hero,
            .gallery-section,
            .description-section,
            .features-section,
            .faq-section,
            .cta-banner {
                padding: 60px 24px;
            }

            .feature-item {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .feature-num {
                padding-top: 0;
            }
        }
    </style>


    <!-- ══ CONTACT MODAL ══ -->
    <style>
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.75);
            z-index: 10000;
            align-items: center;
            justify-content: center;
            padding: 20px;
            backdrop-filter: blur(4px);
        }

        .modal-overlay.active {
            display: flex;
        }

        .cmodal {
            background: #1a1a1a;
            border: 1px solid #2a2a2a;
            border-radius: 10px;
            width: 100%;
            max-width: 680px;
            max-height: 90vh;
            overflow-y: auto;
            padding: 40px;
            position: relative;
            font-family: 'Segoe UI', sans-serif;
        }

        .cmodal::-webkit-scrollbar {
            width: 4px;
        }

        .cmodal::-webkit-scrollbar-thumb {
            background: #2a2a2a;
            border-radius: 2px;
        }

        .modal-close {
            position: absolute;
            top: 16px;
            right: 20px;
            background: none;
            border: none;
            color: #b0b0b0;
            font-size: 22px;
            cursor: pointer;
            line-height: 1;
            transition: color .2s;
        }

        .modal-close:hover {
            color: #ffc107;
        }

        .modal-eyebrow {
            font-size: 10px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #ffc107;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .modal-title {
            font-size: 28px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 6px;
            line-height: 1.15;
        }

        .modal-title span {
            color: #ffc107;
        }

        .modal-sub {
            font-size: 13px;
            color: #b0b0b0;
            margin-bottom: 28px;
            line-height: 1.6;
        }

        .modal-divider {
            height: 1px;
            background: #2a2a2a;
            margin-bottom: 28px;
        }

        .mform-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 16px;
        }

        .mform-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-bottom: 16px;
        }

        .mform-group label {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #b0b0b0;
        }

        .mform-control {
            background: #111;
            border: 1px solid #2a2a2a;
            border-radius: 4px;
            color: #fff;
            font-size: 14px;
            padding: 11px 14px;
            font-family: inherit;
            transition: border-color .2s, box-shadow .2s;
            outline: none;
            width: 100%;
        }

        .mform-control:focus {
            border-color: #ffc107;
            box-shadow: 0 0 0 2px rgba(255, 193, 7, .12);
        }

        .mform-control::placeholder {
            color: #555;
        }

        select.mform-control option {
            background: #1a1a1a;
            color: #fff;
        }

        .phone-row {
            display: flex;
            gap: 8px;
        }

        .phone-code {
            background: #111;
            border: 1px solid #2a2a2a;
            border-radius: 4px;
            color: #ffc107;
            font-size: 13px;
            padding: 11px 10px;
            font-family: inherit;
            outline: none;
            flex: 0 0 110px;
            cursor: pointer;
            transition: border-color .2s;
        }

        .phone-code:focus {
            border-color: #ffc107;
        }

        .services-list {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin-top: 6px;
        }

        .svc-item {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #111;
            border: 1px solid #2a2a2a;
            border-radius: 4px;
            padding: 10px 14px;
            cursor: pointer;
            transition: border-color .2s;
            user-select: none;
        }

        .svc-item:hover {
            border-color: #444;
        }

        .svc-item.selected {
            border-color: #ffc107;
        }

        .chk-box {
            width: 16px;
            height: 16px;
            border-radius: 3px;
            border: 1.5px solid #2a2a2a;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all .2s;
        }

        .svc-item.selected .chk-box {
            background: #ffc107;
            border-color: #ffc107;
        }

        .chk-mark {
            display: none;
            font-size: 10px;
            color: #000;
            font-weight: 800;
        }

        .svc-item.selected .chk-mark {
            display: block;
        }

        .svc-name {
            font-size: 13px;
            color: #b0b0b0;
        }

        .svc-item.selected .svc-name {
            color: #fff;
        }

        .modal-submit {
            background: #ffc107;
            color: #0f0f0f;
            padding: 14px 36px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            width: 100%;
            margin-top: 8px;
            transition: opacity .2s, transform .2s;
            font-family: inherit;
        }

        .modal-submit:hover {
            opacity: .88;
            transform: translateY(-1px);
        }

        .modal-err {
            color: #ff6b6b;
            font-size: 12px;
            margin-bottom: 12px;
            display: none;
        }

        .modal-success {
            display: none;
            text-align: center;
            padding: 40px 20px;
        }

        .success-icon-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: rgba(255, 193, 7, .12);
            border: 1px solid #ffc107;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 24px;
            color: #ffc107;
        }

        .modal-success h3 {
            color: #fff;
            font-size: 22px;
            margin-bottom: 8px;
        }

        .modal-success p {
            color: #b0b0b0;
            font-size: 14px;
            line-height: 1.7;
        }

        textarea.mform-control {
            resize: vertical;
            min-height: 100px;
        }

        @media(max-width:560px) {
            .mform-row {
                grid-template-columns: 1fr;
            }

            .cmodal {
                padding: 24px;
            }
        }
    </style>




</head>

<body>

    <!-- NAVBAR (same as main site) -->
    <nav class="navbar navbar-expand-lg navbar-custom">
        <div class="container">
            <div class="logo-section">
                <a class="logo" href="index.html">
                    <img src="img/log.gif">
                </a>
            </div>
            <button class="navbar-toggler mobile-toggle" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
                <i class="bi bi-list"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.html">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="about.html">About Us</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button">Services</a>
                        <div class="dropdown-menu">
                            <div class="services-grid">
                                <a href="development.html" class="service-item">
                                    <div class="service-icon"><i class="bi bi-code-slash"></i></div>
                                    <div class="service-content">
                                        <h6>DEVELOPMENT <span class="service-arrow">↗</span></h6>
                                        <p>Building scalable, high-performing digital platforms.</p>
                                    </div>
                                </a>
                                <a href="marketing.html" class="service-item">
                                    <div class="service-icon"><i class="bi bi-layout-text-window-reverse"></i></div>
                                    <div class="service-content">
                                        <h6>MARKETING <span class="service-arrow">↗</span></h6>
                                        <p>Driving engagement through data and creativity.</p>
                                    </div>
                                </a>
                                <a href="pr-and-advertising.html" class="service-item">
                                    <div class="service-icon"><i class="bi bi-palette"></i></div>
                                    <div class="service-content">
                                        <h6>PR & ADVERTISING <span class="service-arrow">↗</span></h6>
                                        <p>Amplifying brand presence across every medium.</p>
                                    </div>
                                </a>
                                <a href="branding.html" class="service-item">
                                    <div class="service-icon"><i class="bi bi-camera"></i></div>
                                    <div class="service-content">
                                        <h6>BRANDING <span class="service-arrow">↗</span></h6>
                                        <p>Crafting visual identities that inspire trust.</p>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </li>
                    <li class="nav-item"><a class="nav-link" href="portfolio.html">Portfolio</a></li>
                    <li class="nav-item"><a class="nav-link" href="careers.html">Careers</a></li>
                    <li class="nav-item"><a class="nav-link" href="blog.html">Blogs</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.html">Contact Us</a></li>
                </ul>
            </div>
        </div>
    </nav>


    <!-- ══ HERO ══ -->
    <section class="city-hero">
        <div class="hero-inner">

            <div class="hero-content">
                <p class="brand-eyebrow"><?php echo $city['heading']; ?></p>
                <h1 class="hero-heading">
                    <?php
                    $words = explode(' ', $city['hero_heading'] ?: $city['heading']);
                    $last  = array_pop($words);
                    echo htmlspecialchars(implode(' ', $words));
                    echo ' <span class="accent">' . htmlspecialchars($last) . '.</span>';
                    ?>
                </h1>
                <div class="hero-divider"></div>

                <?php if (!empty($city['hero_heading'])): ?>
                    <p class="hero-subheading"><?= nl2br(htmlspecialchars($city['hero_subheading'])) ?></p>
                <?php endif; ?>


                <div class="desc-content">
                    <?php foreach ($descriptions as $para): ?>
                        <p class="desc-para"><?= nl2br(htmlspecialchars($para)) ?></p>
                    <?php endforeach; ?>
                </div>

                <div style="margin-top:36px; display:flex; gap:14px; flex-wrap:wrap;">
                    <a href="contact.html" class="btn-primary-gold">Get In Touch</a>
                    <a href="portfolio.html" style="background:transparent;color:#fff;padding:14px 32px;font-size:13px;font-weight:600;text-transform:uppercase;letter-spacing:1.5px;border-radius:3px;border:1px solid #2a2a2a;text-decoration:none;display:inline-block;transition:border-color .2s,color .2s;"
                        onmouseover="this.style.borderColor='#ffc107';this.style.color='#ffc107'"
                        onmouseout="this.style.borderColor='#2a2a2a';this.style.color='#fff'">
                        See Our Work
                    </a>
                </div>
            </div>

            <img src="<?= htmlspecialchars('backend/' . $images[0]) ?>"
                alt="<?= htmlspecialchars($city['heading']) ?>"
                class="hero-main-img"
                onclick="openLightbox(0)">

        </div>
    </section>


    <!-- ══ GALLERY ══ -->
    <?php if (count($images) > 1): ?>
        <section class="gallery-section">
            <div style="max-width:1200px; margin:0 auto;">
                <p class="section-eyebrow">Photo Gallery</p>
                <h2 class="section-title">EXPLORE <span>THE CITY</span></h2>
                <div class="gallery-grid">
                    <?php foreach ($images as $i => $img): ?>
                        <div class="gallery-grid-item" onclick="openLightbox(<?= $i ?>)">
                            <img src="<?= htmlspecialchars($img) ?>" alt="Gallery image <?= $i + 1 ?>">
                            <div class="overlay"><i class="bi bi-zoom-in"></i></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>


    <?php if (!empty($features)): ?>
        <section class="features-section">
            <div class="features-inner">

                <div class="features-header">
                    <div>
                        <p class="section-eyebrow">What We Offer</p>
                        <h2 class="section-title" style="margin-bottom:0;">
                            <?= htmlspecialchars($feature_data['mainHeading'] ?? 'KEY FEATURES') ?>
                        </h2>
                    </div>
                    <?php if (!empty($feature_data['description'])): ?>
                        <p class="features-main-desc"><?= nl2br(htmlspecialchars($feature_data['description'])) ?></p>
                    <?php endif; ?>
                </div>

                <div class="features-list">
                    <?php foreach ($features as $i => $feat): ?>
                        <div class="feature-item">
                            <div class="feature-num">(<?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?>)</div>
                            <div class="feature-heading">
                                <?php
                                $fw = explode(' ', $feat['heading'] ?? '');
                                $fl = array_pop($fw);
                                echo htmlspecialchars(implode(' ', $fw));
                                echo ' <span>' . htmlspecialchars($fl) . '</span>';
                                ?>
                            </div>
                            <div>

                                <p class="feature-desc"><?= nl2br(htmlspecialchars($feat['description'] ?? '')) ?></p>
                                <div class="justify-content-end d-flex w-full">
                                    <div class="btn  flex   aos-init aos-animate" data-aos="zoom-in" data-aos-delay="600">


                                        <button class="cta-button" onclick="document.getElementById('contactModal').classList.add('active')">

                                            Let's Conect
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </section>
    <?php endif; ?>


    <!-- ══ FAQ ══ -->
    <?php if (!empty($faqs)): ?>
        <section class="faq-section">
            <div class="faq-inner">
                <div class="faq-layout">

                    <div class="faq-sidebar-sticky">
                        <p class="section-eyebrow">FAQs</p>
                        <h2 class="section-title" style="font-size:clamp(36px,4vw,60px); margin-bottom:16px;">
                            KNOW THE <span>PROCESS</span>
                        </h2>
                        <p style="font-size:14px;color:var(--text-muted);line-height:1.7;">
                            Everything you need to know about this city and how we can help your brand grow here.
                        </p>
                    </div>

                    <div class="faq-list">
                        <?php foreach ($faqs as $i => $faq): ?>
                            <div class="faq-item-block <?= $i === 0 ? 'open' : '' ?>">
                                <div class="faq-question-row" onclick="toggleFAQ(this.parentElement)">
                                    <h3><?= htmlspecialchars($faq['question']) ?></h3>
                                    <div class="faq-icon-box">
                                        <i class="fas fa-plus"></i>
                                    </div>
                                </div>
                                <div class="faq-answer-body">
                                    <p><?= nl2br(htmlspecialchars($faq['answer'])) ?></p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                </div>
            </div>
        </section>
    <?php endif; ?>


    <!-- ══ CTA BANNER ══ -->
    <section class="cta-banner">
        <h2>Ready to Grow Your Brand in <span><?= htmlspecialchars($city['heading']) ?></span>?</h2>
        <p>Let's build something powerful together — strategy, identity, and execution, all in one place.</p>
        <a href="contact.html" class="btn-primary-gold">Start Your Journey</a>
    </section>


    <!-- ══ FOOTER ══ -->
    <footer class="footer-main">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-6 footer-col">
                    <div class="d-flex justify-content-start">
                        <div class="footer-logo">
                            <img src="img/log.gif" alt="Company Logo" class="img-fluid">
                        </div>
                    </div>
                    <p class="footer-tagline">"Building Brands That Make a Difference" is Our Main Goal in our Company.</p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 footer-col">
                    <h4 class="footer-heading">Quick Links</h4>
                    <ul class="footer-links">
                        <li><a href="index.html">Home</a></li>
                        <li><a href="about.html">About</a></li>
                        <li><a href="portfolio.html">Portfolio</a></li>
                        <li><a href="contact.html">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 footer-col">
                    <h4 class="footer-heading">Our Expertise</h4>
                    <ul class="footer-links">
                        <li><a href="#">Web Development</a></li>
                        <li><a href="#">Graphic Design</a></li>
                        <li><a href="#">Branding</a></li>
                        <li><a href="#">Digital Marketing</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6 footer-col">
                    <h4 class="footer-heading">Contact Us</h4>
                    <ul class="contact-info">
                        <li><i class="fas fa-phone-alt"></i><span>+91 98677 37785<br>+91 98183 19568</span></li>
                        <li><i class="fas fa-envelope"></i><span>sales@brandingwaale.com</span></li>
                        <li><i class="fas fa-map-marker-alt"></i><span>SCF 147, Second Floor, Huda Market, Sector 37, Faridabad, Haryana 121003</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <div class="footer-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="copyright">Copyright © 2025 All rights reserved.</p>
                </div>
                <div class="col-md-6">
                    <ul class="footer-bottom-links">
                        <li><a href="#">Privacy Policy</a></li>
                        <li><a href="#">Terms of Service</a></li>
                        <li><a href="#">Sitemap</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-overlay" id="contactModal" onclick="if(event.target===this)closeModal()">
        <div class="cmodal">
            <button class="modal-close" onclick="closeModal()">&#x2715;</button>
            <p class="modal-eyebrow">Let's Connect</p>
            <h2 class="modal-title">Start Your <span>Journey</span></h2>
            <p class="modal-sub">Tell us about your brand and we'll craft the perfect strategy for your market.</p>
            <div class="modal-divider"></div>

            <div id="mFormContent">
                <div class="mform-row">
                    <div class="mform-group">
                        <label>Full Name *</label>
                        <input type="text" class="mform-control" placeholder="John Doe" id="mName">
                    </div>
                    <div class="mform-group">
                        <label>Email Address *</label>
                        <input type="email" class="mform-control" placeholder="john@company.com" id="mEmail">
                    </div>
                </div>
                <div class="mform-row">
                    <div class="mform-group">
                        <label>Company</label>
                        <input type="text" class="mform-control" placeholder="Your Company Name" id="mCompany">
                    </div>
                    <div class="mform-group">
                        <label>Phone Number *</label>
                        <div class="phone-row">
                            <select class="phone-code" id="mPhoneCode">
                                <option value="+91">🇮🇳 +91</option>
                                <option value="+971">🇦🇪 +971</option>
                                <option value="+1">🇺🇸 +1</option>
                                <option value="+44">🇬🇧 +44</option>
                                <option value="+61">🇦🇺 +61</option>
                                <option value="+49">🇩🇪 +49</option>
                                <option value="+33">🇫🇷 +33</option>
                                <option value="+86">🇨🇳 +86</option>
                                <option value="+55">🇧🇷 +55</option>
                                <option value="+52">🇲🇽 +52</option>
                                <option value="+34">🇪🇸 +34</option>
                                <option value="+39">🇮🇹 +39</option>
                                <option value="+31">🇳🇱 +31</option>
                                <option value="+82">🇰🇷 +82</option>
                                <option value="+65">🇸🇬 +65</option>
                                <option value="+92">🇵🇰 +92</option>
                                <option value="+880">🇧🇩 +880</option>
                                <option value="+977">🇳🇵 +977</option>
                                <option value="+213">🇩🇿 +213</option>
                                <option value="+54">🇦🇷 +54</option>
                                <option value="+43">🇦🇹 +43</option>
                                <option value="+32">🇧🇪 +32</option>
                                <option value="+359">🇧🇬 +359</option>
                                <option value="+56">🇨🇱 +56</option>
                                <option value="+57">🇨🇴 +57</option>
                                <option value="+20">🇪🇬 +20</option>
                                <option value="+358">🇫🇮 +358</option>
                                <option value="+30">🇬🇷 +30</option>
                                <option value="+36">🇭🇺 +36</option>
                                <option value="+98">🇮🇷 +98</option>
                                <option value="+964">🇮🇶 +964</option>
                                <option value="+353">🇮🇪 +353</option>
                                <option value="+972">🇮🇱 +972</option>
                                <option value="+962">🇯🇴 +962</option>
                                <option value="+254">🇰🇪 +254</option>
                                <option value="+965">🇰🇼 +965</option>
                                <option value="+961">🇱🇧 +961</option>
                                <option value="+60">🇲🇾 +60</option>
                                <option value="+212">🇲🇦 +212</option>
                                <option value="+234">🇳🇬 +234</option>
                                <option value="+47">🇳🇴 +47</option>
                                <option value="+968">🇴🇲 +968</option>
                                <option value="+507">🇵🇦 +507</option>
                                <option value="+63">🇵🇭 +63</option>
                                <option value="+48">🇵🇱 +48</option>
                                <option value="+351">🇵🇹 +351</option>
                                <option value="+974">🇶🇦 +974</option>
                                <option value="+40">🇷🇴 +40</option>
                                <option value="+7">🇷🇺 +7</option>
                                <option value="+966">🇸🇦 +966</option>
                                <option value="+27">🇿🇦 +27</option>
                                <option value="+46">🇸🇪 +46</option>
                                <option value="+41">🇨🇭 +41</option>
                                <option value="+886">🇹🇼 +886</option>
                                <option value="+66">🇹🇭 +66</option>
                                <option value="+216">🇹🇳 +216</option>
                                <option value="+90">🇹🇷 +90</option>
                                <option value="+380">🇺🇦 +380</option>
                                <option value="+971">🇦🇪 +971</option>
                                <option value="+84">🇻🇳 +84</option>
                                <option value="+967">🇾🇪 +967</option>
                                <option value="+263">🇿🇼 +263</option>
                            </select>
                            <input type="tel" class="mform-control" placeholder="98765 43210" id="mPhone" style="flex:1;">
                        </div>
                    </div>
                </div>

                <div class="mform-group">
                    <label>Services Required *</label>
                    <div class="services-list">
                        <?php
                        $services = ['Digital Marketing', 'Web Development', 'Mobile Development', 'UI/UX Design', 'SEO', 'Performance Marketing', 'Brand Communication', 'Content Creation', 'Social Media Marketing', 'Business Consulting', 'Others'];
                        foreach ($services as $svc): ?>
                            <div class="svc-item" onclick="this.classList.toggle('selected')">
                                <div class="chk-box"><span class="chk-mark">&#10003;</span></div>
                                <span class="svc-name"><?= htmlspecialchars($svc) ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="mform-group" style="margin-top:4px;">
                    <label>Share Your Message</label>
                    <textarea class="mform-control" placeholder="Tell us about your project, goals, or any questions..." id="mMessage"></textarea>
                </div>

                <p class="modal-err" id="mErr">Please fill in all required fields and select at least one service.</p>
                <button class="modal-submit" onclick="submitModalForm()">Send Message &rarr;</button>
            </div>

            <div class="modal-success" id="mSuccess">
                <div class="success-icon-circle">&#10003;</div>
                <h3>Message Sent!</h3>
                <p>Thank you for reaching out. Our team will get back to you within 24 hours.</p>
            </div>
        </div>
    </div>

    <!-- ══ LIGHTBOX ══ -->
    <div class="lightbox-overlay" id="lightbox">
        <span class="lightbox-close" onclick="closeLightbox()">&#x2715;</span>
        <div class="lightbox-nav prev" onclick="lightboxNav(-1)"><i class="bi bi-chevron-left"></i></div>
        <img src="" alt="" class="lightbox-img" id="lightboxImg">
        <div class="lightbox-nav next" onclick="lightboxNav(1)"><i class="bi bi-chevron-right"></i></div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/index.js"></script>

    <script>
        // Images array for lightbox
        const galleryImages = <?= json_encode(array_map(function ($img) {
                                    return "backend/" . $img;
                                }, array_values($images))) ?>;

        let currentIndex = 0;

        function openLightbox(index) {
            if (!galleryImages.length) return;

            currentIndex = index;

            document.getElementById('lightboxImg').src = galleryImages[currentIndex];

            document.getElementById('lightbox').classList.add('active');

            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {

            document.getElementById('lightbox').classList.remove('active');

            document.body.style.overflow = '';

        }

        function lightboxNav(dir) {

            currentIndex = (currentIndex + dir + galleryImages.length) % galleryImages.length;

            document.getElementById('lightboxImg').src = galleryImages[currentIndex];

        }

        document.getElementById('lightbox').addEventListener('click', function(e) {

            if (e.target === this) closeLightbox();

        });

        document.addEventListener('keydown', function(e) {

            if (e.key === 'Escape') closeLightbox();

            if (e.key === 'ArrowLeft') lightboxNav(-1);

            if (e.key === 'ArrowRight') lightboxNav(1);

        });

        // FAQ toggle
        function toggleFAQ(block) {

            const isOpen = block.classList.contains('open');

            document.querySelectorAll('.faq-item-block').forEach(b => b.classList.remove('open'));

            if (!isOpen) block.classList.add('open');

        }
    </script>


    <script>
        function closeModal() {
            document.getElementById('contactModal').classList.remove('active');
            document.body.style.overflow = '';
        }
        document.getElementById('contactModal').addEventListener('click', function(e) {
            if (e.target === this) closeModal();
        });
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeModal();
        });

        function submitModalForm() {
            var n = document.getElementById('mName').value.trim();
            var e = document.getElementById('mEmail').value.trim();
            var p = document.getElementById('mPhone').value.trim();
            var selected = document.querySelectorAll('.svc-item.selected');
            var err = document.getElementById('mErr');
            if (!n || !e || !p || selected.length === 0) {
                err.style.display = 'block';
                return;
            }
            err.style.display = 'none';
            document.getElementById('mFormContent').style.display = 'none';
            document.getElementById('mSuccess').style.display = 'block';
        }
        // Open modal — call this from any button
        function openContactModal() {
            document.getElementById('contactModal').classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    </script>

</body>

</html>