<?php
// echo "Link - $link";
?>
<link rel="stylesheet" href="assets/css/style.css" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/@shoelace-style/shoelace@2.0.0-beta.83/dist/themes/light.css" />

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script type="module" src="https://cdn.jsdelivr.net/npm/@shoelace-style/shoelace@2.0.0-beta.83/dist/shoelace.js">
</script>


<nav class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <img src="/images/imgi_1_logo.gif" alt="" class="logo">
        <h2>brandingwaale</h2>
    </div>

    <div class="sidebar-nav">
        <a href="dashboard.php" class="nav-item <?php echo $link == 'dashboard' ? 'active' : ''; ?>"
            onclick="showSection('dashboard')">
            <i>📊</i> Dashboard
        </a>
        <div class="nav-item has-submenu">
            <a href="javascript:void(0)" onclick="toggleSubmenu(this)" class="menu-link">
                <i>📝</i> City
            </a>
            <ul class="menu-sub">
                <li class="menu-item ">
                    <a href="all-city.php" class="menu-link <?php echo $link == 'All Blogs' ? 'active' : ''; ?>">All
                        City</a>
                </li>
                <li class="menu-item">
                    <a href="add-city.php" class="menu-link <?php echo $link == 'Add Blogs' ? 'active' : ''; ?>">Add
                        City</a>
                </li>
                <!-- <li class="menu-item">
                    <a href="add-city-category.php"
                        class="menu-link <?php echo $link == 'Blogs Category' ? 'active' : ''; ?>">Add Blogs
                        Category</a>
                </li>
                <li class="menu-item">
                    <a href="all-blog-categories.php"
                        class="menu-link <?php echo $link == 'All Blogs Category' ? 'active' : ''; ?>">All Blogs
                        Category</a>
                </li> -->
            </ul>
        </div>
        <!-- Blogs Parent -->
        <div class="nav-item has-submenu">
            <a href="javascript:void(0)" onclick="toggleSubmenu(this)" class="menu-link">
                <i>📰</i> Blog
            </a>

            <ul class="menu-sub">

                <li class="menu-item">
                    <a href="all-blogs.php"
                        class="menu-link <?php echo $link == 'All Blogs' ? 'active' : ''; ?>">
                        All Blogs
                    </a>
                </li>

                <li class="menu-item">
                    <a href="add-blog.php"
                        class="menu-link <?php echo $link == 'Add Blog' ? 'active' : ''; ?>">
                        Add Blog
                    </a>
                </li>


                <li class="menu-item">
                    <a href="add-blog-category.php"
                        class="menu-link <?php echo $link == 'Blog Category' ? 'active' : ''; ?>">
                        Add Blog Category
                    </a>
                </li>

                <li class="menu-item">
                    <a href="all-blog-categories.php"
                        class="menu-link <?php echo $link == 'All Blog Category' ? 'active' : ''; ?>">
                        All Blog Categories
                    </a>
                </li>


            </ul>
        </div>
    </div>

    <a href="logout.php" class="btn text-white bg-danger
 logout-btn" onclick="logout()">Logout</a>
</nav>

<style>
    .menu-sub {
        max-height: 0;
        opacity: 0;
        overflow: hidden;
        transition: max-height 0.4s ease, opacity 0.4s ease;
        padding-left: 20px;
    }

    .has-submenu.open>.menu-sub {
        max-height: 500px;
        /* large enough to fit submenu */
        opacity: 1;
    }

    .menu-item {
        margin: 5px 0;
    }

    .menu-link {
        text-decoration: none;
        display: block;
        padding: 6px 0;
        color: white;
    }
</style>

<script>
    function toggleSubmenu(el) {
        el.parentElement.classList.toggle("open");
    }
</script>