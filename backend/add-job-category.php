<?php
session_start();
include 'db.php';

$alertmsg = '';
$success  = '';

if (isset($_SESSION['msg'])) {
    $success = $_SESSION['msg'];
    unset($_SESSION['msg']);
}

if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    if ($name) {
        // Check duplicate
        $check = mysqli_fetch_assoc(mysqli_query($conn, "SELECT id FROM job_categories WHERE name='$name'"));
        if ($check) {
            $alertmsg = "Category '$name' already exists.";
        } else {
            mysqli_query($conn, "INSERT INTO job_categories (name) VALUES ('$name')");
            $_SESSION['msg'] = "Category Added Successfully";
            header("Location: add-job-category.php");
            exit;
        }
    } else {
        $alertmsg = "Category name cannot be empty.";
    }
}

$categories = mysqli_query($conn, "SELECT jc.*, COUNT(j.id) as job_count 
    FROM job_categories jc 
    LEFT JOIN jobs j ON j.category_id = jc.id 
    GROUP BY jc.id 
    ORDER BY jc.created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Job Categories</title>
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
            --text-light: #ffffff;
            --text-muted: #888;
            --text-dim: #555;
            --danger: #ef4444;
            --font-display: 'Syne', sans-serif;
            --font-mono: 'DM Mono', monospace;
            --radius: 10px;
            --tr: 0.22s ease
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

        .alert-box.success {
            background: rgba(255, 193, 7, 0.08);
            border: 1px solid rgba(255, 193, 7, 0.25);
            color: var(--accent)
        }

        .layout {
            display: grid;
            grid-template-columns: 340px 1fr;
            gap: 24px;
            align-items: start
        }

        /* ADD FORM */
        .form-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            overflow: hidden;
            position: sticky;
            top: 24px
        }

        .form-card-header {
            padding: 18px 24px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 12px
        }

        .fch-icon {
            width: 38px;
            height: 38px;
            background: var(--accent-dim);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent);
            font-size: 17px
        }

        .fch-title {
            font-size: 14px;
            font-weight: 700
        }

        .fch-sub {
            font-size: 11px;
            color: var(--text-muted);
            font-family: var(--font-mono);
            margin-top: 2px
        }

        .form-body-p {
            padding: 22px
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
            margin-bottom: 8px
        }

        .field-label i {
            color: var(--accent);
            font-size: 13px
        }

        .form-input {
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

        .form-input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-dim)
        }

        .form-input::placeholder {
            color: var(--text-dim)
        }

        .btn-submit {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            padding: 13px;
            background: var(--accent);
            color: #000;
            border: none;
            border-radius: 8px;
            font-family: var(--font-display);
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: var(--tr);
            margin-top: 16px
        }

        .btn-submit:hover {
            background: #fff;
            transform: translateY(-1px)
        }

        /* TABLE CARD */
        .table-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            overflow: hidden
        }

        .table-card-header {
            padding: 18px 24px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between
        }

        .tch-title {
            font-size: 14px;
            font-weight: 700
        }

        .total-badge {
            font-family: var(--font-mono);
            font-size: 12px;
            color: var(--text-muted)
        }

        .total-badge span {
            color: var(--accent);
            font-weight: 600
        }

        table {
            width: 100%;
            border-collapse: collapse
        }

        thead tr {
            background: var(--bg-primary);
            border-bottom: 1px solid var(--border-color)
        }

        thead th {
            padding: 12px 20px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--text-muted);
            white-space: nowrap
        }

        tbody tr {
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
            transition: background var(--tr)
        }

        tbody tr:last-child {
            border-bottom: none
        }

        tbody tr:hover {
            background: rgba(255, 193, 7, 0.02)
        }

        tbody td {
            padding: 14px 20px;
            font-size: 13px;
            vertical-align: middle
        }

        .id-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            background: var(--accent-dim);
            color: var(--accent);
            font-family: var(--font-mono);
            font-size: 12px;
            border-radius: 6px
        }

        .cat-name {
            font-weight: 600;
            font-size: 14px
        }

        .job-count {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-family: var(--font-mono);
            font-size: 12px;
            color: var(--text-muted);
            background: var(--bg-secondary);
            padding: 4px 12px;
            border-radius: 20px
        }

        .job-count.has-jobs {
            color: var(--accent);
            background: var(--accent-dim)
        }

        .date-text {
            font-family: var(--font-mono);
            font-size: 11px;
            color: var(--text-dim)
        }

        .btn-del {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            background: transparent;
            color: var(--text-muted);
            font-size: 15px;
            cursor: pointer;
            transition: var(--tr)
        }

        .btn-del:hover {
            border-color: var(--danger);
            background: rgba(239, 68, 68, 0.08);
            color: var(--danger)
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px
        }

        .empty-state i {
            font-size: 40px;
            color: var(--border-color);
            display: block;
            margin-bottom: 12px
        }

        .empty-state p {
            font-size: 13px;
            color: var(--text-muted)
        }

        /* CONFIRM MODAL */
        .confirm-bg {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.75);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(4px)
        }

        .confirm-bg.active {
            display: flex
        }

        .confirm-box {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            padding: 36px;
            max-width: 380px;
            width: 90%;
            text-align: center
        }

        .ci {
            width: 54px;
            height: 54px;
            background: rgba(239, 68, 68, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: var(--danger);
            margin: 0 auto 18px
        }

        .confirm-box h5 {
            font-size: 17px;
            font-weight: 800;
            margin-bottom: 8px
        }

        .confirm-box p {
            font-size: 13px;
            color: var(--text-muted);
            margin-bottom: 24px;
            line-height: 1.6
        }

        .confirm-btns {
            display: flex;
            gap: 12px;
            justify-content: center
        }

        .cb-cancel {
            padding: 10px 24px;
            background: var(--bg-secondary);
            color: var(--text-light);
            border: 1px solid var(--border-color);
            border-radius: 7px;
            font-family: var(--font-display);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--tr)
        }

        .cb-cancel:hover {
            border-color: #fff
        }

        .cb-del {
            padding: 10px 24px;
            background: var(--danger);
            color: #fff;
            border: none;
            border-radius: 7px;
            font-family: var(--font-display);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: var(--tr)
        }

        .cb-del:hover {
            background: #dc2626;
            color: #fff
        }

        @media(max-width:800px) {
            .layout {
                grid-template-columns: 1fr
            }

            .form-card {
                position: static
            }

            .main-content {
                padding: 20px 16px
            }
        }
    </style>
</head>

<body>
    <?php include 'sidenav.php'; ?>
    <div class="main-content">

        <div class="top-bar">
            <div>
                <div class="page-title">Job <span>Categories</span></div>
                <div class="page-sub">Manage job categories for the careers page</div>
            </div>
            <a href="all-jobs.php" class="btn-back"><i class="bi bi-arrow-left"></i> All Jobs</a>
        </div>

        <?php if ($alertmsg): ?>
            <div class="alert-box danger"><i class="bi bi-exclamation-circle-fill"></i><?= htmlspecialchars($alertmsg) ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="alert-box success"><i class="bi bi-check-circle-fill"></i><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <div class="layout">

            <!-- ADD FORM -->
            <div class="form-card">
                <div class="form-card-header">
                    <div class="fch-icon"><i class="bi bi-tag"></i></div>
                    <div>
                        <div class="fch-title">Add New Category</div>
                        <div class="fch-sub">e.g. Design, Development</div>
                    </div>
                </div>
                <div class="form-body-p">
                    <form method="POST">
                        <div class="field-label"><i class="bi bi-type"></i> Category Name</div>
                        <input type="text" name="name" class="form-input"
                            placeholder="e.g. Marketing"
                            value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>" required>
                        <button type="submit" name="submit" class="btn-submit">
                            <i class="bi bi-plus-circle"></i> Add Category
                        </button>
                    </form>
                </div>
            </div>

            <!-- CATEGORIES TABLE -->
            <div class="table-card">
                <div class="table-card-header">
                    <div class="tch-title">All Categories</div>
                    <div class="total-badge">Total: <span><?= mysqli_num_rows($categories) ?></span></div>
                </div>
                <?php if (mysqli_num_rows($categories) > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Category Name</th>
                                <th>Jobs</th>
                                <th>Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
                            while ($cat = mysqli_fetch_assoc($categories)): ?>
                                <tr>
                                    <td>
                                        <div class="id-badge"><?= $i++ ?></div>
                                    </td>
                                    <td>
                                        <div class="cat-name"><?= htmlspecialchars($cat['name']) ?></div>
                                    </td>
                                    <td>
                                        <span class="job-count <?= $cat['job_count'] > 0 ? 'has-jobs' : '' ?>">
                                            <i class="bi bi-briefcase"></i> <?= $cat['job_count'] ?> jobs
                                        </span>
                                    </td>
                                    <td>
                                        <div class="date-text"><?= date('d M Y', strtotime($cat['created_at'])) ?></div>
                                    </td>
                                    <td>
                                        <button class="btn-del" onclick="confirmDel(<?= $cat['id'] ?>, '<?= htmlspecialchars($cat['name']) ?>')" title="Delete">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="empty-state">
                        <i class="bi bi-tag"></i>
                        <p>No categories yet. Add your first one.</p>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>

    <!-- DELETE CONFIRM -->
    <div class="confirm-bg" id="confirmBg">
        <div class="confirm-box">
            <div class="ci"><i class="bi bi-trash3-fill"></i></div>
            <h5>Delete Category?</h5>
            <p id="confirmText">This will also delete all jobs under this category. This cannot be undone.</p>
            <div class="confirm-btns">
                <button class="cb-cancel" onclick="closeConfirm()">Cancel</button>
                <a href="#" id="delLink" class="cb-del">Yes, Delete</a>
            </div>
        </div>
    </div>
    <script>
        function confirmDel(id, name) {
            document.getElementById('confirmText').textContent =
                'Deleting "' + name + '" will also remove all jobs under it. This cannot be undone.';
            document.getElementById('delLink').href = 'delete-job-category.php?id=' + id;
            document.getElementById('confirmBg').classList.add('active');
        }

        function closeConfirm() {
            document.getElementById('confirmBg').classList.remove('active');
        }
    </script>
</body>

</html>