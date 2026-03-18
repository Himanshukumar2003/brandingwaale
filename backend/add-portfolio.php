<?php
session_start();
include 'db.php';

$alertmsg = '';

if (isset($_POST['submit'])) {

    $date = date('Y-m-d H:i:s');

    if (!empty($_FILES['images']['name'][0])) {

        $uploadDir = "uploads/portfolio/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $group_id = (int) time();

        foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {

            if ($_FILES['images']['error'][$key] == 0) {

                $raw_slug = isset($_POST['slug'][$key]) ? trim($_POST['slug'][$key]) : '';

                if (!empty($raw_slug)) {
                    $raw_slug = preg_replace('#^(https?://)+(https?://)#', '$1', $raw_slug);
                    if (!preg_match('#^https?://#i', $raw_slug)) {
                        $raw_slug = 'https://' . $raw_slug;
                    }
                }

                $slug         = mysqli_real_escape_string($conn, $raw_slug);
                $filename_raw = time() . "_" . basename($_FILES['images']['name'][$key]);
                $filename     = mysqli_real_escape_string($conn, $filename_raw);
                $date_escaped = mysqli_real_escape_string($conn, $date);
                $target       = $uploadDir . $filename_raw;

                if (move_uploaded_file($tmpName, $target)) {
                    $result = mysqli_query($conn, "INSERT INTO portfolio 
                        (image_id, image, slug, created_at)
                        VALUES 
                        ('$group_id', '$filename', '$slug', '$date_escaped')");

                    if (!$result) {
                        $alertmsg = "DB Error: " . mysqli_error($conn);
                    }
                }
            }
        }

        if (!$alertmsg) {
            $_SESSION['msg'] = "Portfolio Added Successfully";
            header("Location: all-portfolio.php");
            exit;
        }
    } else {
        $alertmsg = "Please select at least one image";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <title>Add Portfolio</title>

    <link rel="stylesheet" href="assets/css/style.css" />
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Mono:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --dark-bg: #0f0f0f;
            --bg-primary: #1a1a1a;
            --bg-secondary: #2a2a2a;
            --card-bg: #141414;
            --input-bg: #0e0e0e;
            --border-color: #2a2a2a;
            --border-focus: rgba(255, 193, 7, 0.5);
            --accent: #ffc107;
            --accent-dim: rgba(255, 193, 7, 0.08);
            --accent-glow: rgba(255, 193, 7, 0.2);
            --text-light: #ffffff;
            --text-muted: #888;
            --text-dim: #555;
            --danger: #ef4444;
            --danger-dim: rgba(239, 68, 68, 0.08);
            --font-display: 'Syne', sans-serif;
            --font-mono: 'DM Mono', monospace;
            --radius: 10px;
            --tr: 0.22s ease;
        }

        *,
        *::before,
        *::after {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--dark-bg);
            color: var(--text-light);
            font-family: var(--font-display);
            min-height: 100vh;
        }

        /* ── PAGE WRAP ── */
        .main-content {
            padding: 40px 44px;

            margin: 0 auto;
        }

        /* ── TOP BAR ── */
        .top-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 36px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .page-title {
            font-size: 26px;
            font-weight: 800;
            letter-spacing: -.5px;
        }

        .page-title span {
            color: var(--accent);
        }

        .page-sub {
            font-size: 12px;
            color: var(--text-muted);
            font-family: var(--font-mono);
            margin-top: 4px;
        }

        .btn-back {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: var(--bg-secondary);
            color: var(--text-muted);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-family: var(--font-display);
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: var(--tr);
        }

        .btn-back:hover {
            border-color: var(--accent);
            color: var(--accent);
        }

        /* ── ALERT ── */
        .alert-box {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 18px;
            border-radius: var(--radius);
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 24px;
        }

        .alert-box.danger {
            background: rgba(239, 68, 68, 0.08);
            border: 1px solid rgba(239, 68, 68, 0.25);
            color: #f87171;
        }

        /* ── FORM CARD ── */
        .form-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            overflow: hidden;
        }

        .form-card-header {
            padding: 20px 28px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .fch-icon {
            width: 40px;
            height: 40px;
            background: var(--accent-dim);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent);
            font-size: 18px;
        }

        .fch-title {
            font-size: 15px;
            font-weight: 700;
        }

        .fch-sub {
            font-size: 11px;
            color: var(--text-muted);
            font-family: var(--font-mono);
            margin-top: 2px;
        }

        .form-card-body {
            padding: 28px;
        }

        /* ── IMAGE CONTAINER ── */
        #imageContainer {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        /* ── UPLOAD BOX ── */
        .upload-box {
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            overflow: hidden;
            transition: border-color var(--tr);
            position: relative;
        }

        .upload-box:hover {
            border-color: rgba(255, 193, 7, 0.2);
        }

        .box-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 16px;
            border-bottom: 1px solid var(--border-color);
            background: rgba(0, 0, 0, 0.2);
        }

        .box-num {
            font-family: var(--font-mono);
            font-size: 11px;
            color: var(--accent);
            font-weight: 500;
            background: var(--accent-dim);
            padding: 3px 10px;
            border-radius: 20px;
        }

        .btn-remove {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 5px 12px;
            background: var(--danger-dim);
            color: var(--danger);
            border: 1px solid rgba(239, 68, 68, 0.2);
            border-radius: 6px;
            font-family: var(--font-display);
            font-size: 11px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--tr);
        }

        .btn-remove:hover {
            background: rgba(239, 68, 68, 0.15);
            border-color: var(--danger);
        }

        .box-body {
            padding: 18px 16px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            align-items: start;
        }

        /* ── DROPZONE ── */
        .dropzone {
            position: relative;
            border: 1.5px dashed var(--border-color);
            border-radius: 8px;
            padding: 28px 16px;
            text-align: center;
            cursor: pointer;
            transition: var(--tr);
            background: var(--input-bg);
            overflow: hidden;
        }

        .dropzone:hover,
        .dropzone.dragover {
            border-color: var(--accent);
            background: var(--accent-dim);
        }

        .dropzone input[type="file"] {
            position: absolute;
            inset: 0;
            opacity: 0;
            cursor: pointer;
            width: 100%;
            height: 100%;
        }

        .dz-icon {
            font-size: 28px;
            color: var(--text-dim);
            margin-bottom: 8px;
        }

        .dropzone:hover .dz-icon,
        .dropzone.dragover .dz-icon {
            color: var(--accent);
        }

        .dz-text {
            font-size: 12px;
            color: var(--text-muted);
            line-height: 1.5;
        }

        .dz-text strong {
            color: var(--accent);
        }

        /* ── PREVIEW SIDE ── */
        .preview-side {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .preview-wrap {
            width: 100%;
            aspect-ratio: 16/10;
            border-radius: 8px;
            overflow: hidden;
            background: var(--input-bg);
            border: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .preview-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none;
        }

        .preview-wrap img.show {
            display: block;
        }

        .preview-placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 6px;
        }

        .preview-placeholder i {
            font-size: 22px;
            color: var(--text-dim);
        }

        .preview-placeholder span {
            font-size: 11px;
            color: var(--text-dim);
            font-family: var(--font-mono);
        }

        /* ── SLUG INPUT ── */
        .slug-field {
            grid-column: 1 / -1;
        }

        .field-label {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 8px;
        }

        .field-label i {
            color: var(--accent);
            font-size: 13px;
        }

        .slug-input-wrap {
            position: relative;
        }

        .slug-prefix {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            font-family: var(--font-mono);
            font-size: 12px;
            color: var(--text-dim);
            pointer-events: none;
            user-select: none;
        }

        .slug-input {
            width: 100%;
            padding: 12px 14px 12px 14px;
            background: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            color: var(--text-light);
            font-family: var(--font-mono);
            font-size: 13px;
            outline: none;
            transition: var(--tr);
        }

        .slug-input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-dim);
        }

        .slug-input::placeholder {
            color: var(--text-dim);
        }

        /* ── ADD MORE BTN ── */
        .add-more-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 14px;
            background: transparent;
            border: 1.5px dashed var(--border-color);
            border-radius: var(--radius);
            color: var(--text-muted);
            font-family: var(--font-display);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--tr);
            margin-top: 4px;
        }

        .add-more-btn:hover {
            border-color: var(--accent);
            color: var(--accent);
            background: var(--accent-dim);
        }

        /* ── FORM FOOTER ── */
        .form-footer {
            padding: 20px 28px;
            border-top: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap;
        }

        .footer-info {
            font-size: 12px;
            color: var(--text-muted);
            font-family: var(--font-mono);
        }

        .footer-info span {
            color: var(--accent);
            font-weight: 600;
        }

        .btn-submit {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 13px 32px;
            background: var(--accent);
            color: #000;
            border: none;
            border-radius: 8px;
            font-family: var(--font-display);
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: var(--tr);
            letter-spacing: 0.3px;
        }

        .btn-submit:hover {
            background: #fff;
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(255, 193, 7, 0.2);
        }

        /* ── COUNTER BADGE ── */
        .img-count-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 22px;
            height: 22px;
            background: var(--accent);
            color: #000;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            padding: 0 7px;
        }

        @media (max-width: 640px) {
            .main-content {
                padding: 20px 16px;
            }

            .box-body {
                grid-template-columns: 1fr;
            }

            .slug-field {
                grid-column: 1;
            }

            .form-footer {
                flex-direction: column;
                align-items: stretch;
            }

            .btn-submit {
                justify-content: center;
            }
        }
    </style>
</head>

<body>

    <?php include 'sidenav.php'; ?>

    <div class="main-content">

        <!-- TOP BAR -->
        <div class="top-bar">
            <div>
                <div class="page-title">Add <span>Portfolio</span></div>
                <div class="page-sub">Upload images with their project URLs</div>
            </div>
            <a href="all-portfolio.php" class="btn-back">
                <i class="bi bi-arrow-left"></i> Back to Portfolio
            </a>
        </div>

        <!-- ERROR ALERT -->
        <?php if ($alertmsg): ?>
            <div class="alert-box danger">
                <i class="bi bi-exclamation-circle-fill"></i>
                <?= htmlspecialchars($alertmsg) ?>
            </div>
        <?php endif; ?>

        <!-- FORM CARD -->
        <form method="POST" enctype="multipart/form-data" id="portfolioForm">
            <div class="form-card">

                <!-- Header -->
                <div class="form-card-header">
                    <div class="fch-icon"><i class="bi bi-images"></i></div>
                    <div>
                        <div class="fch-title">Upload Portfolio Images</div>
                        <div class="fch-sub">Each image requires a project URL / link</div>
                    </div>
                </div>

                <!-- Body -->
                <div class="form-card-body">
                    <div id="imageContainer"></div>

                    <!-- Add More -->
                    <button type="button" class="add-more-btn" onclick="addMore()">
                        <i class="bi bi-plus-circle"></i>
                        Add Another Image
                    </button>
                </div>

                <!-- Footer -->
                <div class="form-footer">
                    <div class="footer-info">
                        <span id="imgCountDisplay">1</span> image(s) queued for upload
                    </div>
                    <button type="submit" name="submit" class="btn-submit">
                        <i class="bi bi-cloud-upload"></i>
                        Upload Portfolio
                    </button>
                </div>

            </div>
        </form>

    </div>

    <script>
        let boxCount = 0;

        function createBox(isFirst = false) {
            boxCount++;
            const num = boxCount;

            const box = document.createElement('div');
            box.className = 'upload-box';
            box.id = 'box_' + num;

            box.innerHTML = `
            <div class="box-header">
                <span class="box-num">IMAGE ${String(num).padStart(2,'0')}</span>
                ${!isFirst ? `
                <button type="button" class="btn-remove" onclick="removeBox(${num})">
                    <i class="bi bi-trash3"></i> Remove
                </button>` : '<span style="font-size:11px;color:var(--text-dim);font-family:var(--font-mono)">Required</span>'}
            </div>
            <div class="box-body">
                <!-- Dropzone -->
                <div class="dropzone" id="dz_${num}">
                    <input type="file" name="images[]" accept="image/*"
                        ${isFirst ? 'required' : ''}
                        onchange="previewImage(this, ${num})"
                        ondragover="this.parentElement.classList.add('dragover')"
                        ondragleave="this.parentElement.classList.remove('dragover')"
                        ondrop="this.parentElement.classList.remove('dragover')">
                    <div class="dz-icon"><i class="bi bi-cloud-arrow-up"></i></div>
                    <div class="dz-text">
                        <strong>Click to browse</strong> or drag & drop<br>
                        PNG, JPG, WEBP supported
                    </div>
                </div>

                <!-- Preview -->
                <div class="preview-side">
                    <div class="preview-wrap" id="pw_${num}">
                        <div class="preview-placeholder">
                            <i class="bi bi-image"></i>
                            <span>Preview</span>
                        </div>
                        <img id="prev_${num}" src="" alt="">
                    </div>
                </div>

                <!-- Slug -->
                <div class="slug-field">
                    <div class="field-label">
                        <i class="bi bi-link-45deg"></i> Project URL / Slug
                    </div>
                    <div class="slug-input-wrap">
                        <input type="text" name="slug[]"
                            class="slug-input"
                            placeholder="https://example.com/project"
                            ${isFirst ? 'required' : ''}>
                    </div>
                </div>
            </div>
        `;

            return box;
        }

        function addMore() {
            const container = document.getElementById('imageContainer');
            container.appendChild(createBox(false));
            updateCount();
        }

        function removeBox(num) {
            const box = document.getElementById('box_' + num);
            if (box) {
                box.style.opacity = '0';
                box.style.transform = 'scale(0.97)';
                box.style.transition = 'all 0.2s ease';
                setTimeout(() => {
                    box.remove();
                    updateCount();
                }, 200);
            }
        }

        function previewImage(input, num) {
            const img = document.getElementById('prev_' + num);
            const wrap = document.getElementById('pw_' + num);
            const placeholder = wrap.querySelector('.preview-placeholder');

            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    img.src = e.target.result;
                    img.classList.add('show');
                    if (placeholder) placeholder.style.display = 'none';

                    // Update dropzone to show filename
                    const dz = document.getElementById('dz_' + num);
                    dz.querySelector('.dz-text').innerHTML =
                        `<strong>${input.files[0].name}</strong><br>
                     <span style="color:var(--accent)">${(input.files[0].size/1024).toFixed(1)} KB</span>`;
                    dz.querySelector('.dz-icon').innerHTML = '<i class="bi bi-check-circle-fill" style="color:var(--accent)"></i>';
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        function updateCount() {
            const count = document.querySelectorAll('.upload-box').length;
            document.getElementById('imgCountDisplay').textContent = count;
        }

        // Init first box
        document.getElementById('imageContainer').appendChild(createBox(true));
    </script>

</body>

</html>