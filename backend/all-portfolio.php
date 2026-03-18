<?php
session_start();
include 'db.php';

$success = '';
if (isset($_SESSION['msg'])) {
    $success = $_SESSION['msg'];
    unset($_SESSION['msg']);
}

// DELETE
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];
    $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT image FROM portfolio WHERE id = $id"));
    if ($row) {
        $imgPath = "uploads/portfolio/" . $row['image'];
        if (file_exists($imgPath)) unlink($imgPath);
        mysqli_query($conn, "DELETE FROM portfolio WHERE id = $id");
        $_SESSION['msg'] = "Deleted Successfully";
        header("Location: all-portfolio.php");
        exit;
    }
}

$result = mysqli_query($conn, "SELECT * FROM portfolio ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>All Portfolio</title>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Mono:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        * {
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

        /* ── PAGE WRAPPER ── */
        .page-wrap {
            padding: 36px 40px;
            max-width: 1300px;
            margin: 0 auto;
        }

        /* ── TOP BAR ── */
        .top-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 32px;
            gap: 16px;
            flex-wrap: wrap;
        }

        .page-title {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -0.5px;
            color: var(--text-light);
        }

        .page-title span {
            color: var(--accent-color);
        }

        .btn-add {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--accent-color);
            color: #000;
            font-family: var(--font-display);
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.5px;
            padding: 11px 22px;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            transition: var(--transition);
        }

        .btn-add:hover {
            background: #fff;
            color: #000;
            transform: translateY(-1px);
        }

        /* ── ALERT ── */
        .alert-success-custom {
            background: rgba(255, 193, 7, 0.1);
            border: 1px solid var(--accent-glow);
            color: var(--accent-color);
            padding: 13px 20px;
            border-radius: var(--radius);
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 24px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        /* ── STATS ROW ── */
        .stats-row {
            display: flex;
            gap: 16px;
            margin-bottom: 28px;
            flex-wrap: wrap;
        }

        .stat-pill {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            padding: 14px 22px;
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 160px;
        }

        .stat-pill .s-icon {
            width: 38px;
            height: 38px;
            background: var(--accent-dim);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            color: var(--accent-color);
        }

        .stat-pill .s-val {
            font-size: 22px;
            font-weight: 800;
            line-height: 1;
            color: var(--text-light);
        }

        .stat-pill .s-label {
            font-size: 11px;
            font-weight: 500;
            color: var(--text-muted);
            letter-spacing: 0.5px;
            margin-top: 3px;
        }

        /* ── TABLE CARD ── */
        .table-card {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            overflow: hidden;
        }

        .table-card table {
            width: 100%;
            border-collapse: collapse;
        }

        .table-card thead tr {
            background: var(--bg-primary);
            border-bottom: 1px solid var(--border-color);
        }

        .table-card thead th {
            padding: 14px 20px;
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--text-muted);
            white-space: nowrap;
        }

        .table-card thead th:first-child {
            color: var(--accent-color);
        }

        .table-card tbody tr {
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
            transition: background var(--transition);
        }

        .table-card tbody tr:last-child {
            border-bottom: none;
        }

        .table-card tbody tr:hover {
            background: rgba(255, 193, 7, 0.03);
        }

        .table-card tbody td {
            padding: 16px 20px;
            font-size: 13px;
            vertical-align: middle;
            color: var(--text-light);
        }

        /* ── ID BADGE ── */
        .id-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            background: var(--accent-dim);
            color: var(--accent-color);
            font-family: var(--font-mono);
            font-size: 12px;
            font-weight: 500;
            border-radius: 6px;
        }

        /* ── PORTFOLIO IMAGE ── */
        .port-img-wrap {
            position: relative;
            width: 90px;
            height: 62px;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid var(--border-color);
            background: var(--input-bg);
            flex-shrink: 0;
        }

        .port-img-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform 0.3s ease;
        }

        .port-img-wrap:hover img {
            transform: scale(1.08);
        }

        .port-img-wrap .img-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.55);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.2s;
            cursor: pointer;
        }

        .port-img-wrap:hover .img-overlay {
            opacity: 1;
        }

        /* ── URL CELL ── */
        .url-cell {
            display: flex;
            align-items: center;
            gap: 10px;
            max-width: 320px;
        }

        .url-text {
            font-family: var(--font-mono);
            font-size: 12px;
            color: var(--text-muted);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 240px;
        }

        .url-open {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            background: var(--accent-dim);
            color: var(--accent-color);
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            flex-shrink: 0;
            transition: var(--transition);
        }

        .url-open:hover {
            background: var(--accent-color);
            color: #000;
        }

        /* ── GROUP ID ── */
        .group-id {
            font-family: var(--font-mono);
            font-size: 11px;
            color: var(--text-muted);
            background: var(--bg-secondary);
            padding: 4px 10px;
            border-radius: 20px;
        }

        /* ── ACTION BTNS ── */
        .action-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            background: transparent;
            color: var(--text-muted);
            font-size: 15px;
            text-decoration: none;
            transition: var(--transition);
            cursor: pointer;
        }

        .btn-action:hover.view {
            border-color: #3b82f6;
            background: rgba(59, 130, 246, 0.1);
            color: #3b82f6;
        }

        .btn-action:hover.delete {
            border-color: #ef4444;
            background: rgba(239, 68, 68, 0.1);
            color: #ef4444;
        }

        /* ── EMPTY STATE ── */
        .empty-state {
            text-align: center;
            padding: 80px 40px;
        }

        .empty-state .e-icon {
            font-size: 48px;
            color: var(--border-color);
            margin-bottom: 16px;
        }

        .empty-state h5 {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-muted);
            margin-bottom: 8px;
        }

        .empty-state p {
            font-size: 13px;
            color: var(--border-color);
        }

        /* ── MODAL ── */
        .img-modal-bg {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.85);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(6px);
        }

        .img-modal-bg.active {
            display: flex;
        }

        .img-modal-inner {
            position: relative;
            max-width: 80vw;
            max-height: 80vh;
        }

        .img-modal-inner img {
            max-width: 100%;
            max-height: 80vh;
            border-radius: 10px;
            border: 1px solid var(--border-color);
            display: block;
        }

        .modal-close {
            position: absolute;
            top: -14px;
            right: -14px;
            width: 32px;
            height: 32px;
            background: var(--accent-color);
            color: #000;
            border: none;
            border-radius: 50%;
            font-size: 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
        }

        /* ── DELETE CONFIRM MODAL ── */
        .confirm-modal-bg {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.7);
            z-index: 9998;
            align-items: center;
            justify-content: center;
            backdrop-filter: blur(4px);
        }

        .confirm-modal-bg.active {
            display: flex;
        }

        .confirm-box {
            background: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            padding: 36px 32px;
            max-width: 400px;
            width: 90%;
            text-align: center;
        }

        .confirm-box .c-icon {
            width: 56px;
            height: 56px;
            background: rgba(239, 68, 68, 0.1);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            color: #ef4444;
            margin: 0 auto 20px;
        }

        .confirm-box h5 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .confirm-box p {
            font-size: 13px;
            color: var(--text-muted);
            margin-bottom: 28px;
        }

        .confirm-btns {
            display: flex;
            gap: 12px;
            justify-content: center;
        }

        .btn-cancel {
            padding: 10px 24px;
            background: var(--bg-secondary);
            color: var(--text-light);
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-family: var(--font-display);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
        }

        .btn-cancel:hover {
            background: var(--bg-primary);
            color: var(--text-light);
        }

        .btn-confirm-del {
            padding: 10px 24px;
            background: #ef4444;
            color: #fff;
            border: none;
            border-radius: 6px;
            font-family: var(--font-display);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
        }

        .btn-confirm-del:hover {
            background: #dc2626;
            color: #fff;
        }

        @media (max-width: 768px) {
            .page-wrap {
                padding: 20px 16px;
            }

            .url-text {
                max-width: 140px;
            }

            .port-img-wrap {
                width: 70px;
                height: 48px;
            }
        }
    </style>
    <link rel="stylesheet" href="assets/css/style.css" />
</head>

<body>

    <?php include 'sidenav.php'; ?>

    <div class="main-content">

        <!-- TOP BAR -->
        <div class="top-bar">
            <div>
                <div class="page-title">All <span>Portfolio</span></div>
                <div style="font-size:12px;color:var(--text-muted);margin-top:4px;font-family:var(--font-mono)">
                    Manage your portfolio images & links
                </div>
            </div>
            <a href="add-portfolio.php" class="btn-add">
                <i class="bi bi-plus-lg"></i> Add Portfolio
            </a>
        </div>

        <!-- SUCCESS ALERT -->
        <?php if ($success): ?>
            <div class="alert-success-custom">
                <i class="bi bi-check-circle-fill"></i>
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <!-- STATS -->
        <?php $total = mysqli_num_rows($result);
        mysqli_data_seek($result, 0); ?>


        <!-- TABLE -->
        <div class="table-card">
            <?php if ($total > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>URL / Slug</th>
                            <th>Group ID</th>
                            <th>Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                        while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <!-- ID -->
                                <td>
                                    <div class="id-badge"><?= $i++ ?></div>
                                </td>

                                <!-- IMAGE -->
                                <td>
                                    <div class="port-img-wrap"
                                        onclick="openImgModal('uploads/portfolio/<?= htmlspecialchars($row['image']) ?>')">
                                        <img src="uploads/portfolio/<?= htmlspecialchars($row['image']) ?>"
                                            alt="portfolio"
                                            onerror="this.src='https://placehold.co/90x62/1a1a1a/555?text=No+Img'">
                                        <div class="img-overlay">
                                            <i class="bi bi-zoom-in" style="color:#fff;font-size:18px"></i>
                                        </div>
                                    </div>
                                </td>

                                <!-- URL -->
                                <td>
                                    <div class="url-cell">
                                        <span class="url-text" title="<?= htmlspecialchars($row['slug']) ?>">
                                            <?= htmlspecialchars($row['slug']) ?>
                                        </span>
                                        <?php if (!empty($row['slug'])): ?>
                                            <a href="<?= htmlspecialchars($row['slug']) ?>"
                                                target="_blank" class="url-open" title="Open link">
                                                <i class="bi bi-box-arrow-up-right"></i>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>

                                <!-- GROUP ID -->
                                <td>
                                    <span class="group-id"><?= htmlspecialchars($row['image_id']) ?></span>
                                </td>

                                <!-- ACTIONS -->
                                <td>
                                    <div class="action-group">
                                        <a href="<?= htmlspecialchars($row['slug']) ?>"
                                            target="_blank"
                                            class="btn-action view" title="Visit URL">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <button class="btn-action delete" title="Delete"
                                            onclick="confirmDelete(<?= $row['id'] ?>)">
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
                    <div class="e-icon"><i class="bi bi-images"></i></div>
                    <h5>No Portfolio Items Yet</h5>
                    <p>Click "Add Portfolio" to upload your first image.</p>
                </div>
            <?php endif; ?>
        </div>

    </div>

    <!-- IMAGE PREVIEW MODAL -->
    <div class="img-modal-bg" id="imgModal" onclick="closeImgModal(event)">
        <div class="img-modal-inner">
            <button class="modal-close" onclick="closeImgModalBtn()">✕</button>
            <img id="modalImg" src="" alt="Preview">
        </div>
    </div>

    <!-- DELETE CONFIRM MODAL -->
    <div class="confirm-modal-bg" id="confirmModal">
        <div class="confirm-box">
            <div class="c-icon"><i class="bi bi-trash3-fill"></i></div>
            <h5>Delete this image?</h5>
            <p>This will permanently delete the image and its link. This action cannot be undone.</p>
            <div class="confirm-btns">
                <button class="btn-cancel" onclick="closeConfirm()">Cancel</button>
                <a href="#" id="confirmDelBtn" class="btn-confirm-del">Yes, Delete</a>
            </div>
        </div>
    </div>

    <script>
        // Image preview modal
        function openImgModal(src) {
            document.getElementById('modalImg').src = src;
            document.getElementById('imgModal').classList.add('active');
        }

        function closeImgModal(e) {
            if (e.target === document.getElementById('imgModal')) {
                document.getElementById('imgModal').classList.remove('active');
            }
        }

        function closeImgModalBtn() {
            document.getElementById('imgModal').classList.remove('active');
        }

        // Delete confirm modal
        function confirmDelete(id) {
            document.getElementById('confirmDelBtn').href = 'all-portfolio.php?delete=' + id;
            document.getElementById('confirmModal').classList.add('active');
        }

        function closeConfirm() {
            document.getElementById('confirmModal').classList.remove('active');
        }
    </script>

</body>

</html>