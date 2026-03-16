<?php
error_reporting(1);
session_start();
include 'db.php';

$alertmsg = '';
$link = 'All Blogs';

/* SESSION CHECK */
if (isset($_SESSION['user'])) {

  $user = $_SESSION['user'];
  $type = $_SESSION['type'];
  $subid = $_SESSION['subid'];

  if ($type == 'Admin') {
    $query = mysqli_query($conn, "SELECT * FROM user WHERE userid='$user'");
  } else {
    $query = mysqli_query($conn, "SELECT * FROM subadmin WHERE userid='$user'");
  }

  if (mysqli_num_rows($query) > 0) {

    $userdata = mysqli_fetch_assoc($query);
    $username = $userdata['name'];
  } else {
    header('location:logout.php');
  }
} else {
  header('location:logout.php');
}
?>

<head>
  <title>All Blogs</title>
</head>

<body>

  <div class="sl-toast-stack">
    <?php
    echo $alertmsg;
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
    ?>
  </div>

  <?php include 'sidenav.php'; ?>

  <div class="main-content">
    <div class="content-wrapper">

      <div class="container-xxl flex-grow-1 container-p-y">

        <h4 class="py-3 mb-4 text-white">All Blogs</h4>

        <div class="card">

          <div class="card-datatable table-responsive pt-0">

            <table class="datatables-basic table table-bordered">

              <thead>
                <tr>
                  <th>Id</th>
                  <th>Image</th>
                  <th>Heading</th>
                  <th>Content</th>
                  <th>Operations</th>
                </tr>
              </thead>

              <tbody>

                <?php

                /* FETCH BLOGS */
                $query = mysqli_query($conn, "SELECT * FROM city ORDER BY id DESC");

                while ($data = mysqli_fetch_assoc($query)) {

                  /* IMAGE JSON */
                  $images = json_decode($data['images'], true);
                  $first_image = !empty($images[0]) ? $images[0] : 'no-image.png';

                  /* DESCRIPTION JSON */
                  $desc = json_decode($data['description_section'], true);
                  $first_desc = !empty($desc[0]) ? $desc[0] : '';

                  $preview = strip_tags(substr($first_desc, 0, 100));

                ?>

                  <tr>

                    <td><?php echo $data['id']; ?></td>

                    <td>
                      <img src="<?php echo $first_image; ?>" width="60">
                    </td>

                    <td><?php echo $data['heading']; ?></td>

                    <td><?php echo $preview; ?>...</td>

                    <td width="120">

                      <div class="d-flex justify-content-center align-items-center">

                        <a href="edit-blog.php?id=<?php echo $data['id']; ?>"
                          class="btn btn-primary"
                          style="margin-right:5px;">

                          Edit

                        </a>

                        <a href="delete-city.php?id=<?php echo $data['id']; ?>"
                          class="btn btn-danger">

                          Delete

                        </a>

                      </div>

                    </td>

                  </tr>

                <?php } ?>

              </tbody>

            </table>

          </div>

        </div>

      </div>

      <?php include 'footer.php'; ?>

      <div class="content-backdrop fade"></div>

    </div>
  </div>

</body>