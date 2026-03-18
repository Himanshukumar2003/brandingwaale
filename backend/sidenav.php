<?php
// sidenav.php – dark luxury sidebar
?>
<link rel="stylesheet" href="assets/css/style.css" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/@shoelace-style/shoelace@2.0.0-beta.83/dist/themes/light.css" />

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script type="module"
    src="https://cdn.jsdelivr.net/npm/@shoelace-style/shoelace@2.0.0-beta.83/dist/shoelace.js"></script>

<nav class="sidebar" id="sidebar">

    <div class="sidebar-header">
        <img src="../img/log.gif" alt="logo" class="logo">

    </div>

    <div class="sidebar-nav">

        <!-- Dashboard -->
        <a href="dashboard.php"
            class="nav-item <?php echo ($link === 'dashboard') ? 'active' : ''; ?>">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <!-- City -->
        <div class="nav-item mb-0 has-submenu <?php echo in_array($link, ['All City', 'Add City']) ? 'open' : ''; ?>">

            <a href="javascript:void(0)" onclick="toggleSubmenu(this)" class="menu-link mb-0 pb-0">
                <i class="bi bi-buildings"></i> City
            </a>

            <ul class="menu-sub">

                <li class="menu-item">
                    <a href="all-city.php"
                        class="menu-link <?php echo ($link === 'All City') ? 'active' : ''; ?>">
                        <i class="bi bi-list-ul"></i> All Cities
                    </a>
                </li>

                <li class="menu-item">
                    <a href="add-city.php"
                        class="menu-link <?php echo ($link === 'Add City') ? 'active' : ''; ?>">
                        <i class="bi bi-plus-circle"></i> Add City
                    </a>
                </li>

            </ul>

        </div>

        <!-- Blog -->
        <div class="nav-item has-submenu <?php echo in_array($link, ['All Blogs', 'Add Blog', 'Blog Category', 'All Blog Category']) ? 'open' : ''; ?>">

            <a href="javascript:void(0)" onclick="toggleSubmenu(this)" class="menu-link">
                <i class="bi bi-journal-text"></i> Blog
            </a>

            <ul class="menu-sub">

                <li class="menu-item">
                    <a href="all-blogs.php"
                        class="menu-link <?php echo ($link === 'All Blogs') ? 'active' : ''; ?>">
                        <i class="bi bi-file-earmark-text"></i> All Blogs
                    </a>
                </li>

                <li class="menu-item">
                    <a href="add-blog.php"
                        class="menu-link <?php echo ($link === 'Add Blog') ? 'active' : ''; ?>">
                        <i class="bi bi-pencil-square"></i> Add Blog
                    </a>
                </li>

            </ul>

        </div>



        <!-- Portfolio -->
        <div class="nav-item has-submenu <?php echo in_array($link, ['All Portfolio', 'Add Portfolio']) ? 'open' : ''; ?>">

            <a href="javascript:void(0)" onclick="toggleSubmenu(this)" class="menu-link">
                <i class="bi bi-images"></i> Portfolio
            </a>

            <ul class="menu-sub">

                <li class="menu-item">
                    <a href="all-portfolio.php"
                        class="menu-link <?php echo ($link === 'All Portfolio') ? 'active' : ''; ?>">
                        <i class="bi bi-image"></i> All Portfolio
                    </a>
                </li>

                <li class="menu-item">
                    <a href="add-portfolio.php"
                        class="menu-link <?php echo ($link === 'Add Portfolio') ? 'active' : ''; ?>">
                        <i class="bi bi-plus-square"></i> Add Portfolio
                    </a>
                </li>

            </ul>

        </div>


        <!-- Jobs -->
        <div class="nav-item has-submenu <?php echo in_array($link, ['All Jobs', 'Add Job', 'Job Category']) ? 'open' : ''; ?>">

            <a href="javascript:void(0)" onclick="toggleSubmenu(this)" class="menu-link">
                <i class="bi bi-briefcase"></i> Jobs
            </a>

            <ul class="menu-sub">

                <li class="menu-item">
                    <a href="all-jobs.php"
                        class="menu-link <?php echo ($link === 'All Jobs') ? 'active' : ''; ?>">
                        <i class="bi bi-list"></i> All Jobs
                    </a>
                </li>

                <li class="menu-item">
                    <a href="add-job.php"
                        class="menu-link <?php echo ($link === 'Add Job') ? 'active' : ''; ?>">
                        <i class="bi bi-plus-circle"></i> Add Job
                    </a>
                </li>

                <li class="menu-item">
                    <a href="add-job-category.php"
                        class="menu-link <?php echo ($link === 'Job Category') ? 'active' : ''; ?>">
                        <i class="bi bi-tags"></i> Job Category
                    </a>
                </li>

            </ul>

        </div>

    </div>

    <!-- Logout -->
    <a href="logout.php" class="logout-btn">
        <i class="bi bi-box-arrow-right"></i> Logout
    </a>

</nav>

<script>
    function toggleSubmenu(el) {
        el.parentElement.classList.toggle("open");
    }

    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('open');
    }
</script>