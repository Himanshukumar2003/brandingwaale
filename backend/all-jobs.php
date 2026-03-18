<?php
session_start();
include 'db.php';

$success = '';
if (isset($_SESSION['msg'])) {
    $success = $_SESSION['msg'];
    unset($_SESSION['msg']);
}

if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    mysqli_query($conn, "DELETE FROM jobs WHERE id = $id");
    $_SESSION['msg'] = "Job Deleted Successfully";
    header("Location: all-jobs.php");
    exit;
}

// Pagination
$perPage    = 10;
$page       = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset     = ($page - 1) * $perPage;
$totalRows  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as cnt FROM jobs"))['cnt'];
$totalPages = ceil($totalRows / $perPage);

// Filter by category
$filterCat = isset($_GET['cat']) ? (int)$_GET['cat'] : 0;
$whereClause = $filterCat ? "WHERE j.category_id = $filterCat" : "";

$jobs = mysqli_query($conn, "SELECT j.*, jc.name as cat_name 
    FROM jobs j 
    LEFT JOIN job_categories jc ON jc.id = j.category_id
    $whereClause
    ORDER BY j.id DESC 
    LIMIT $perPage OFFSET $offset");

$allCats = mysqli_query($conn, "SELECT * FROM job_categories ORDER BY name ASC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>All Jobs</title>
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
            --text-dim: #444;
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
            max-width: 1300px;
            margin: 0 auto
        }

        .top-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 32px;
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

        .top-btns {
            display: flex;
            gap: 10px;
            flex-wrap: wrap
        }

        .btn-outline {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 18px;
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

        .btn-outline:hover {
            border-color: var(--accent);
            color: var(--accent)
        }

        .btn-primary-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: var(--accent);
            color: #000;
            border: none;
            border-radius: 8px;
            font-family: var(--font-display);
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            transition: var(--tr)
        }

        .btn-primary-link:hover {
            background: #fff;
            color: #000;
            transform: translateY(-1px)
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

        .alert-box.success {
            background: rgba(255, 193, 7, 0.08);
            border: 1px solid rgba(255, 193, 7, 0.25);
            color: var(--accent)
        }

        /* STATS */
        .stats-row {
            display: flex;
            gap: 14px;
            margin-bottom: 24px;
            flex-wrap: wrap
        }

        .stat-pill {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 14px 20px;
            display: flex;
            align-items: center;
            gap: 12px
        }

        .sp-icon {
            width: 36px;
            height: 36px;
            background: var(--accent-dim);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent);
            font-size: 16px
        }

        .sp-val {
            font-size: 20px;
            font-weight: 800;
            line-height: 1;
            color: var(--text-light)
        }

        .sp-label {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 3px;
            letter-spacing: .5px
        }

        /* FILTER */
        .filter-bar {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 22px;
            flex-wrap: wrap
        }

        .filter-select {
            padding: 9px 14px;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            color: var(--text-light);
            font-family: var(--font-mono);
            font-size: 12px;
            outline: none;
            transition: var(--tr);
            cursor: pointer;
            appearance: none;
            padding-right: 32px;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6' viewBox='0 0 10 6'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%23888' stroke-width='1.5' fill='none' stroke-linecap='round'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 10px center
        }

        .filter-select:focus {
            border-color: var(--accent)
        }

        .filter-select option {
            background: #1a1a1a
        }

        .filter-label {
            font-size: 12px;
            color: var(--text-muted);
            font-family: var(--font-mono)
        }

        /* TABLE */
        .table-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            overflow: hidden;
            margin-bottom: 28px
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
            padding: 13px 20px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--text-muted);
            white-space: nowrap
        }

        thead th:first-child {
            color: var(--accent)
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
            padding: 15px 20px;
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

        .job-title-cell h4 {
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 4px
        }

        .job-title-cell p {
            font-size: 11px;
            color: var(--text-muted);
            line-height: 1.5;
            max-width: 340px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis
        }

        .dept-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            font-family: var(--font-mono);
            color: var(--text-muted);
            background: var(--bg-secondary);
            padding: 5px 12px;
            border-radius: 20px;
            border: 1px solid var(--border-color)
        }

        .cat-badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            font-size: 11px;
            font-family: var(--font-mono);
            color: var(--accent);
            background: var(--accent-dim);
            padding: 5px 12px;
            border-radius: 20px;
            border: 1px solid rgba(255, 193, 7, 0.15)
        }

        .loc-cell {
            display: flex;
            align-items: center;
            gap: 6px;
            font-family: var(--font-mono);
            font-size: 12px;
            color: var(--text-muted)
        }

        .date-text {
            font-family: var(--font-mono);
            font-size: 11px;
            color: var(--text-dim)
        }

        .action-group {
            display: flex;
            align-items: center;
            gap: 8px
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            background: transparent;
            color: var(--text-muted);
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            transition: var(--tr)
        }

        .btn-action.view:hover {
            border-color: #3b82f6;
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6
        }

        .btn-action.del:hover {
            border-color: var(--danger);
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger)
        }

        .empty-state {
            text-align: center;
            padding: 70px 20px
        }

        .empty-state i {
            font-size: 44px;
            color: var(--border-color);
            display: block;
            margin-bottom: 14px
        }

        .empty-state h5 {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-muted);
            margin-bottom: 8px
        }

        .empty-state p {
            font-size: 13px;
            color: var(--text-dim);
            margin-bottom: 20px
        }

        /* PAGINATION */
        .pagination-wrap {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 14px
        }

        .page-info {
            font-size: 12px;
            color: var(--text-muted);
            font-family: var(--font-mono)
        }

        .pag-btns {
            display: flex;
            gap: 5px
        }

        .pag-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            padding: 0 8px;
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 7px;
            color: var(--text-muted);
            font-family: var(--font-mono);
            font-size: 12px;
            text-decoration: none;
            transition: var(--tr)
        }

        .pag-btn:hover:not(.disabled):not(.active) {
            border-color: var(--accent);
            color: var(--accent)
        }

        .pag-btn.active {
            background: var(--accent);
            border-color: var(--accent);
            color: #000;
            font-weight: 700
        }

        .pag-btn.disabled {
            opacity: .3;
            pointer-events: none
        }

        .pag-dots {
            color: var(--text-muted);
            padding: 0 4px;
            font-size: 14px
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

        /* JOB DETAIL DRAWER */
        .drawer-bg {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.6);
            z-index: 9998;
            backdrop-filter: blur(4px)
        }

        .drawer-bg.active {
            display: block
        }

        .drawer {
            position: fixed;
            top: 0;
            right: -520px;
            width: 500px;
            height: 100vh;
            background: var(--card-bg);
            border-left: 1px solid var(--border-color);
            z-index: 9999;
            overflow-y: auto;
            transition: right .3s cubic-bezier(.76, 0, .24, 1);
            padding: 32px 28px
        }

        .drawer.open {
            right: 0
        }

        .drawer-close {
            position: absolute;
            top: 20px;
            right: 20px;
            width: 32px;
            height: 32px;
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--text-muted);
            font-size: 16px;
            transition: var(--tr)
        }

        .drawer-close:hover {
            color: var(--text-light);
            border-color: #fff
        }

        .drawer-label {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--accent);
            margin-bottom: 8px
        }

        .drawer-title {
            font-size: 22px;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 20px
        }

        .drawer-meta {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            margin-bottom: 24px
        }

        .drawer-divider {
            height: 1px;
            background: var(--border-color);
            margin: 20px 0
        }

        .drawer-section-title {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 12px
        }

        .drawer-desc {
            font-size: 13px;
            line-height: 1.8;
            color: rgba(255, 255, 255, 0.65);
            white-space: pre-wrap
        }

        @media(max-width:768px) {
            .main-content {
                padding: 20px 16px
            }

            .drawer {
                width: 100%;
                right: -100%
            }

            .drawer.open {
                right: 0
            }
        }
    </style>
</head>

<body>
    <?php include 'sidenav.php'; ?>
    <div class="main-content">

        <div class="top-bar">
            <div>
                <div class="page-title">All <span>Jobs</span></div>
                <div class="page-sub">Manage career openings</div>
            </div>
            <div class="top-btns">
                <a href="add-job-category.php" class="btn-outline"><i class="bi bi-tag"></i> Categories</a>
                <a href="add-job.php" class="btn-primary-link"><i class="bi bi-plus-lg"></i> Add Job</a>
            </div>
        </div>

        <?php if ($success): ?>
            <div class="alert-box success"><i class="bi bi-check-circle-fill"></i><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <!-- STATS -->
        <div class="stats-row">
            <div class="stat-pill">
                <div class="sp-icon"><i class="bi bi-briefcase"></i></div>
                <div>
                    <div class="sp-val"><?= $totalRows ?></div>
                    <div class="sp-label">Total Jobs</div>
                </div>
            </div>
            <?php
            $catCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as cnt FROM job_categories"))['cnt'];
            ?>
            <div class="stat-pill">
                <div class="sp-icon"><i class="bi bi-tag"></i></div>
                <div>
                    <div class="sp-val"><?= $catCount ?></div>
                    <div class="sp-label">Categories</div>
                </div>
            </div>
        </div>

        <!-- FILTER -->
        <div class="filter-bar">
            <span class="filter-label">Filter by:</span>
            <form method="GET" style="display:flex;gap:8px">
                <select name="cat" class="filter-select" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    <?php while ($c = mysqli_fetch_assoc($allCats)): ?>
                        <option value="<?= $c['id'] ?>" <?= $filterCat == $c['id'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($c['name']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </form>
            <?php if ($filterCat): ?>
                <a href="all-jobs.php" class="btn-outline" style="padding:8px 14px;font-size:11px">
                    <i class="bi bi-x"></i> Clear
                </a>
            <?php endif; ?>
        </div>

        <!-- TABLE -->
        <div class="table-card">
            <?php if (mysqli_num_rows($jobs) > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Job Title</th>
                            <th>Department</th>
                            <th>Category</th>
                            <th>Location</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = $offset + 1;
                        while ($job = mysqli_fetch_assoc($jobs)): ?>
                            <tr>
                                <td>
                                    <div class="id-badge"><?= $i++ ?></div>
                                </td>
                                <td>
                                    <div class="job-title-cell">
                                        <h4><?= htmlspecialchars($job['title']) ?></h4>
                                        <p><?= htmlspecialchars($job['description']) ?></p>
                                    </div>
                                </td>
                                <td><span class="dept-badge"><i class="bi bi-building"></i><?= htmlspecialchars($job['department']) ?></span></td>
                                <td><span class="cat-badge"><i class="bi bi-tag"></i><?= htmlspecialchars($job['cat_name'] ?? '—') ?></span></td>
                                <td>
                                    <div class="loc-cell"><i class="bi bi-geo-alt"></i><?= htmlspecialchars($job['location']) ?></div>
                                </td>
                                <td>
                                    <div class="date-text"><?= date('d M Y', strtotime($job['created_at'])) ?></div>
                                </td>
                                <td>
                                    <div class="action-group">
                                        <button class="btn-action view" title="View Details"
                                            onclick="openDrawer(
                                <?= htmlspecialchars(json_encode($job['title'])) ?>,
                                <?= htmlspecialchars(json_encode($job['department'])) ?>,
                                <?= htmlspecialchars(json_encode($job['cat_name'] ?? '')) ?>,
                                <?= htmlspecialchars(json_encode($job['location'])) ?>,
                                <?= htmlspecialchars(json_encode($job['description'])) ?>
                            )">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <button class="btn-action del" title="Delete"
                                            onclick="confirmDel(<?= $job['id'] ?>, '<?= htmlspecialchars($job['title']) ?>')">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="empty-state">
                    <i class="bi bi-briefcase"></i>
                    <h5>No Jobs Found</h5>
                    <p>Start posting openings to your careers page.</p>
                    <a href="add-job.php" class="btn-primary-link" style="display:inline-flex;margin:0 auto">
                        <i class="bi bi-plus-lg"></i> Add First Job
                    </a>
                </div>
            <?php endif; ?>
        </div>

        <!-- PAGINATION -->
        <?php if ($totalPages > 1): ?>
            <div class="pagination-wrap">
                <div class="page-info">
                    Showing <?= $offset + 1 ?>–<?= min($offset + $perPage, $totalRows) ?> of <?= $totalRows ?> jobs
                </div>
                <div class="pag-btns">
                    <a href="?page=<?= $page - 1 ?><?= $filterCat ? "&cat=$filterCat" : '' ?>" class="pag-btn <?= $page <= 1 ? 'disabled' : '' ?>">
                        <i class="bi bi-chevron-left"></i>
                    </a>
                    <?php
                    $s = max(1, $page - 2);
                    $e = min($totalPages, $page + 2);
                    if ($s > 1) {
                        echo '<a href="?page=1" class="pag-btn">1</a>';
                        if ($s > 2) echo '<span class="pag-dots">…</span>';
                    }
                    for ($p = $s; $p <= $e; $p++) echo "<a href='?page=$p" . ($filterCat ? "&cat=$filterCat" : '') . "' class='pag-btn " . ($p == $page ? 'active' : '') . "'>$p</a>";
                    if ($e < $totalPages) {
                        if ($e < $totalPages - 1) echo '<span class="pag-dots">…</span>';
                        echo "<a href='?page=$totalPages' class='pag-btn'>$totalPages</a>";
                    }
                    ?>
                    <a href="?page=<?= $page + 1 ?><?= $filterCat ? "&cat=$filterCat" : '' ?>" class="pag-btn <?= $page >= $totalPages ? 'disabled' : '' ?>">
                        <i class="bi bi-chevron-right"></i>
                    </a>
                </div>
            </div>
        <?php endif; ?>

    </div>

    <!-- JOB DETAIL DRAWER -->
    <div class="drawer-bg" id="drawerBg" onclick="closeDrawer()"></div>
    <div class="drawer" id="drawer">
        <div class="drawer-close" onclick="closeDrawer()"><i class="bi bi-x"></i></div>
        <div class="drawer-label">Job Details</div>
        <div class="drawer-title" id="dTitle"></div>
        <div class="drawer-meta" id="dMeta"></div>
        <div class="drawer-divider"></div>
        <div class="drawer-section-title">Description</div>
        <div class="drawer-desc" id="dDesc"></div>
    </div>

    <!-- DELETE CONFIRM -->
    <div class="confirm-bg" id="confirmBg">
        <div class="confirm-box">
            <div class="ci"><i class="bi bi-trash3-fill"></i></div>
            <h5>Delete this Job?</h5>
            <p id="confirmText">This action cannot be undone.</p>
            <div class="confirm-btns">
                <button class="cb-cancel" onclick="closeConfirm()">Cancel</button>
                <a href="#" id="delLink" class="cb-del">Yes, Delete</a>
            </div>
        </div>
    </div>

    <script>
        function openDrawer(title, dept, cat, loc, desc) {
            document.getElementById('dTitle').textContent = title;
            document.getElementById('dDesc').textContent = desc;
            document.getElementById('dMeta').innerHTML =
                `<span class="dept-badge"><i class="bi bi-building"></i>${dept}</span>
         <span class="cat-badge"><i class="bi bi-tag"></i>${cat}</span>
         <span class="dept-badge"><i class="bi bi-geo-alt"></i>${loc}</span>`;
            document.getElementById('drawer').classList.add('open');
            document.getElementById('drawerBg').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeDrawer() {
            document.getElementById('drawer').classList.remove('open');
            document.getElementById('drawerBg').classList.remove('active');
            document.body.style.overflow = '';
        }

        function confirmDel(id, title) {
            document.getElementById('confirmText').textContent = 'Deleting "' + title + '" cannot be undone.';
            document.getElementById('delLink').href = 'all-jobs.php?delete=' + id;
            document.getElementById('confirmBg').classList.add('active');
        }

        function closeConfirm() {
            document.getElementById('confirmBg').classList.remove('active');
        }
    </script>
</body>

</html>