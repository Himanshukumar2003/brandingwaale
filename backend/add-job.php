<?php
session_start();
include 'db.php';

$alertmsg = '';

// Fetch categories for dropdown
$cats = mysqli_query($conn, "SELECT * FROM job_categories ORDER BY name ASC");

if (isset($_POST['submit'])) {
    $title       = mysqli_real_escape_string($conn, trim($_POST['title']));
    $description = mysqli_real_escape_string($conn, trim($_POST['description']));
    $department  = mysqli_real_escape_string($conn, trim($_POST['department']));
    $category_id = (int) $_POST['category_id'];
    $location    = mysqli_real_escape_string($conn, trim($_POST['location']));

    if ($title && $description && $department && $category_id && $location) {
        $result = mysqli_query($conn, "INSERT INTO jobs 
            (title, description, department, category_id, location) 
            VALUES ('$title','$description','$department','$category_id','$location')");

        if ($result) {
            $_SESSION['msg'] = "Job Created Successfully";
            header("Location: all-jobs.php");
            exit;
        } else {
            $alertmsg = "DB Error: " . mysqli_error($conn);
        }
    } else {
        $alertmsg = "All fields are required.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Add Job</title>
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
            --accent: #ffc107;
            --accent-dim: rgba(255, 193, 7, 0.08);
            --accent-glow: rgba(255, 193, 7, 0.2);
            --text-light: #ffffff;
            --text-muted: #888;
            --text-dim: #555;
            --danger: #ef4444;
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
            box-sizing: border-box
        }

        body {
            background: var(--dark-bg);
            color: var(--text-light);
            font-family: var(--font-display);
            min-height: 100vh
        }

        .main-content {
            padding: 40px 44px;

            margin: 0 auto
        }

        .top-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 36px;
            flex-wrap: wrap;
            gap: 12px
        }

        .page-title {
            font-size: 26px;
            font-weight: 800;
            letter-spacing: -.5px
        }

        .page-title span {
            color: var(--accent)
        }

        .page-sub {
            font-size: 12px;
            color: var(--text-muted);
            font-family: var(--font-mono);
            margin-top: 4px
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
            transition: var(--tr)
        }

        .btn-back:hover {
            border-color: var(--accent);
            color: var(--accent)
        }

        .alert-box {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 14px 18px;
            border-radius: var(--radius);
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 24px
        }

        .alert-box.danger {
            background: rgba(239, 68, 68, 0.08);
            border: 1px solid rgba(239, 68, 68, 0.25);
            color: #f87171
        }

        .form-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            overflow: hidden
        }

        .form-card-header {
            padding: 20px 28px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 14px
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
            font-size: 18px
        }

        .fch-title {
            font-size: 15px;
            font-weight: 700
        }

        .fch-sub {
            font-size: 11px;
            color: var(--text-muted);
            font-family: var(--font-mono);
            margin-top: 2px
        }

        .form-body {
            padding: 28px;
            display: flex;
            flex-direction: column;
            gap: 20px
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px
        }

        .field-group {
            display: flex;
            flex-direction: column;
            gap: 8px
        }

        .field-group.full {
            grid-column: 1/-1
        }

        .field-label {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--text-muted)
        }

        .field-label i {
            color: var(--accent);
            font-size: 13px
        }

        .form-input,
        .form-select,
        .form-textarea {
            width: 100%;
            padding: 12px 14px;
            background: var(--input-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            color: var(--text-light);
            font-family: var(--font-mono);
            font-size: 13px;
            outline: none;
            transition: var(--tr)
        }

        .form-input:focus,
        .form-select:focus,
        .form-textarea:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-dim)
        }

        .form-input::placeholder,
        .form-textarea::placeholder {
            color: var(--text-dim)
        }

        .form-select {
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='8' viewBox='0 0 12 8'%3E%3Cpath d='M1 1l5 5 5-5' stroke='%23888' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center
        }

        .form-select option {
            background: #1a1a1a
        }

        .form-textarea {
            resize: vertical;
            min-height: 130px;
            line-height: 1.6
        }

        .char-hint {
            font-size: 11px;
            color: var(--text-dim);
            font-family: var(--font-mono);
            text-align: right
        }

        .form-footer {
            padding: 20px 28px;
            border-top: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: wrap
        }

        .footer-info {
            font-size: 12px;
            color: var(--text-muted);
            font-family: var(--font-mono)
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
            transition: var(--tr)
        }

        .btn-submit:hover {
            background: #fff;
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(255, 193, 7, 0.2)
        }

        .no-cats-warn {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            background: rgba(255, 193, 7, 0.06);
            border: 1px solid rgba(255, 193, 7, 0.2);
            border-radius: 8px;
            font-size: 13px;
            color: var(--accent)
        }

        .no-cats-warn a {
            color: var(--accent);
            font-weight: 700;
            text-underline-offset: 3px
        }

        @media(max-width:640px) {
            .main-content {
                padding: 20px 16px
            }

            .form-row {
                grid-template-columns: 1fr
            }

            .field-group.full {
                grid-column: 1
            }

            .form-footer {
                flex-direction: column;
                align-items: stretch
            }

            .btn-submit {
                justify-content: center
            }
        }
    </style>
</head>

<body>
    <?php include 'sidenav.php'; ?>
    <div class="main-content">

        <div class="top-bar">
            <div>
                <div class="page-title">Create <span>Job</span></div>
                <div class="page-sub">Post a new opening to the careers page</div>
            </div>
            <a href="all-jobs.php" class="btn-back"><i class="bi bi-arrow-left"></i> All Jobs</a>
        </div>

        <?php if ($alertmsg): ?>
            <div class="alert-box danger"><i class="bi bi-exclamation-circle-fill"></i><?= htmlspecialchars($alertmsg) ?></div>
        <?php endif; ?>

        <?php if (mysqli_num_rows($cats) == 0): ?>
            <div class="no-cats-warn">
                <i class="bi bi-exclamation-triangle-fill"></i>
                No categories found. <a href="add-job-category.php">Create a category first →</a>
            </div>
        <?php else: ?>

            <form method="POST">
                <div class="form-card">
                    <div class="form-card-header">
                        <div class="fch-icon"><i class="bi bi-briefcase"></i></div>
                        <div>
                            <div class="fch-title">Job Details</div>
                            <div class="fch-sub">Fill in all required fields</div>
                        </div>
                    </div>
                    <div class="form-body">
                        <!-- Row 1 -->
                        <div class="form-row">
                            <div class="field-group">
                                <div class="field-label"><i class="bi bi-type"></i> Job Title</div>
                                <input type="text" name="title" class="form-input"
                                    placeholder="e.g. Senior UI Designer"
                                    value="<?= isset($_POST['title']) ? htmlspecialchars($_POST['title']) : '' ?>" required>
                            </div>
                            <div class="field-group">
                                <div class="field-label"><i class="bi bi-building"></i> Department</div>
                                <input type="text" name="department" class="form-input"
                                    placeholder="e.g. Design, Development"
                                    value="<?= isset($_POST['department']) ? htmlspecialchars($_POST['department']) : '' ?>" required>
                            </div>
                        </div>
                        <!-- Row 2 -->
                        <div class="form-row">
                            <div class="field-group">
                                <div class="field-label"><i class="bi bi-tag"></i> Category</div>
                                <select name="category_id" class="form-select" required>
                                    <option class="text-white" value="">— Select Category —</option>
                                    <?php mysqli_data_seek($cats, 0);
                                    while ($cat = mysqli_fetch_assoc($cats)): ?>
                                        <option class="text-white" value="<?= $cat['id'] ?>"
                                            <?= (isset($_POST['category_id']) && $_POST['category_id'] == $cat['id']) ? 'selected' : '' ?>>
                                            <?= htmlspecialchars($cat['name']) ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="field-group">
                                <div class="field-label"><i class="bi bi-geo-alt"></i> Location</div>
                                <input type="text" name="location" class="form-input"
                                    placeholder="e.g. Delhi NCR / Remote"
                                    value="<?= isset($_POST['location']) ? htmlspecialchars($_POST['location']) : '' ?>" required>
                            </div>
                        </div>
                        <!-- Description -->
                        <div class="field-group full">
                            <div class="field-label"><i class="bi bi-card-text"></i> Job Description</div>
                            <textarea name="description" class="form-textarea"
                                placeholder="Describe responsibilities, requirements, skills needed..."
                                id="descTA" oninput="updateChar()" required><?= isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '' ?></textarea>
                            <div class="char-hint" id="charHint">0 characters</div>
                        </div>
                    </div>
                    <div class="form-footer">
                        <div class="footer-info">All fields marked are required</div>
                        <button type="submit" name="submit" class="btn-submit">
                            <i class="bi bi-plus-circle"></i> Post Job
                        </button>
                    </div>
                </div>
            </form>

        <?php endif; ?>
    </div>
    <script>
        function updateChar() {
            const len = document.getElementById('descTA').value.length;
            document.getElementById('charHint').textContent = len + ' characters';
        }
    </script>
</body>

</html>